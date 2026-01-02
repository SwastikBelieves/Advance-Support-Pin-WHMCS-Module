<?php

namespace SwastikDev\SupportPin\Services;

use WHMCS\Database\Capsule;

class TemplateService
{
    protected $pinManager;

    public function __construct()
    {
        $this->pinManager = new PinManager();
    }

    public function template_index($vars)
    {
        $clients = Capsule::table('mod_supportpin')
            ->whereRaw("`mod_supportpin`.`updated_at` > (NOW() - INTERVAL 2 DAY)")
            ->join('tblclients', 'mod_supportpin.customerid', '=', 'tblclients.id')
            ->orderBy("mod_supportpin.updated_at", "desc")
            ->select('mod_supportpin.customerid', 'mod_supportpin.pin', 'mod_supportpin.updated_at', 'tblclients.firstname', 'tblclients.lastname')
            ->get();

        return ["clients" => $clients];
    }

    public function handle_POST($POST)
    {
        if (isset($POST['searchsupportpin'])) {
            $customerInfo = Capsule::table('mod_supportpin')->where("pin", "=", $POST['searchsupportpin'])->first();
            if ($customerInfo) {
                header('Location: clientssummary.php?userid=' . $customerInfo->customerid);
                exit;
            }
        }
    }

    public function template_Client_index($vars)
    {
        $pin = $this->pinManager->ensurePinExists($vars['clientID']);
        return ["supportpin" => $pin];
    }

    public function template_RenewPIN($clientid)
    {
        $newPin = $this->pinManager->renewPin($clientid);
        return ["PIN" => $newPin];
    }
}
