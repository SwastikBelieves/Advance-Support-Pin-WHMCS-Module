<?php

namespace SwastikDev\SupportPin\Hooks;

use WHMCS\Database\Capsule;
use SwastikDev\SupportPin\Services\PinManager;


class ClientArea
{
    public function __invoke($primarySidebar)
    {
        if (!is_null($primarySidebar->getChild('Client Details'))) {
            $this->ensurePinExists();
            $this->addSidebarItem($primarySidebar);
        }
    }

    private function ensurePinExists()
    {
        $clientid = $_SESSION['uid'];
        (new PinManager())->ensurePinExists($clientid);
    }

    private function addSidebarItem($primarySidebar)
    {
        $clientid = $_SESSION['uid'];
        $customerInfo = Capsule::table('mod_supportpin')->where("customerid", "=", $clientid)->first();

        // Gracefully handle missing PIN.
        if (!$customerInfo) {
            return;
        }

        $supportPin = $customerInfo->pin;

        $supportPinMenu = $primarySidebar->addChild('supportPinMenu', [
            'name' => 'SupportPin',
            'label' => 'Support Pin',
            'uri' => 'index.php?m=supportpin',
            'order' => 1,
            'icon' => 'fas fa-key'
        ]);

        $supportPinMenu->setBodyHtml($this->getSidebarBody($supportPin));
    }

    private function getSidebarBody($supportPin)
    {
        return <<<HTML
<div class="supportpin-sidebar-widget" id="supportPinWidget" data-pin="{$supportPin}" data-visible="false">
    <div class="supportpin-title">Support PIN</div>
    <div class="supportpin-digits-container" onclick="supportPin.copyToClipboard(event)" title="Click to Copy">
        <!-- Digits injected by JS -->
    </div>
    <div class="supportpin-actions-row">
        <button type="button" class="btn btn-outline" onclick="supportPin.renew(event)">
            <i class="fas fa-sync-alt"></i>
        </button>
        <button type="button" class="btn btn-outline" onclick="supportPin.toggleVisibility(event)">
            <i class="fas fa-eye"></i>
        </button>
    </div>
</div>
HTML;
    }
}
