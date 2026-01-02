<?php

use SwastikDev\SupportPin\Hooks\AdminHome;
use SwastikDev\SupportPin\Hooks\ClientArea;

require_once __DIR__ . '/Loader.php';

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}


add_hook('AdminHomeWidgets', 1, function () {
    return new AdminHome();
});

add_hook('ClientAreaPrimarySidebar', 1, function ($primarySidebar) {
    $hook = new ClientArea();
    $hook($primarySidebar);
});

add_hook('ClientAreaHeadOutput', 1, function ($vars) {
    return '<link href="modules/addons/supportpin/assets/css/styles.css?v=' . time() . '" rel="stylesheet">';
});

add_hook('ClientAreaFooterOutput', 1, function ($vars) {
    return '<script src="modules/addons/supportpin/assets/js/scripts.js?v=' . time() . '"></script>';
});
