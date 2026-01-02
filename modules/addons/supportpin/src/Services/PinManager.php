<?php

namespace SwastikDev\SupportPin\Services;

use WHMCS\Database\Capsule;

class PinManager
{
    public function ensurePinExists(int $userId): string
    {
        $pin = $this->getPin($userId);
        if ($pin) {
            return $pin;
        }

        return $this->createPin($userId);
    }

    public function getPin(int $userId): ?string
    {
        $record = Capsule::table('mod_supportpin')->where('customerid', $userId)->first();
        return $record ? $record->pin : null;
    }

    public function createPin(int $userId): string
    {
        $pin = $this->generateUniquePin();

        try {
            Capsule::table('mod_supportpin')->insert([
                'customerid' => $userId,
                'pin' => $pin,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        } catch (\Exception $e) {
            logActivity("SupportPIN Error: " . $e->getMessage());
        }

        return $pin;
    }

    public function renewPin(int $userId): string
    {
        Capsule::table('mod_supportpin')->where('customerid', $userId)->delete();
        return $this->createPin($userId);
    }

    private function generateUniquePin(): string
    {
        $maxAttempts = 10;
        for ($i = 0; $i < $maxAttempts; $i++) {
            $pin = (string) random_int(100000, 999999);
            if (!$this->pinExists($pin)) {
                return $pin;
            }
        }
        throw new \RuntimeException("Unable to generate a unique PIN after $maxAttempts attempts.");
    }

    private function pinExists(string $pin): bool
    {
        return Capsule::table('mod_supportpin')->where('pin', $pin)->exists();
    }
}
