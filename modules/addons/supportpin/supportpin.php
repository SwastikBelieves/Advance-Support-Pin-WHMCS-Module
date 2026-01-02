<?php
/**
 * WHMCS-SupportPIN
 *
 * Copyright (c) 2026 SWASTIK.DEV
 *
 * Licensed under GPL-3.0
 */

use WHMCS\Database\Capsule;
use SwastikDev\SupportPin\Manager\TemplateManager;
use SwastikDev\SupportPin\Services\ResponseService;
use SwastikDev\SupportPin\Services\TemplateService;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

if (file_exists(__DIR__ . '/Loader.php')) {
    require_once __DIR__ . '/Loader.php';
}

function supportpin_config()
{
    return [
        'name' => 'Support PIN',
        'description' => 'Empower your clients with Instant Identity Verification. Our advanced Support PIN system ensures secure, friction-less authentication, allowing your team to verify ownership in seconds during voice or chat interactions.',
        'author' => 'SWASTIK.DEV',
        'language' => 'english',
        'version' => '2.01',
    ];
}

function supportpin_activate()
{
    try {
        if (!Capsule::schema()->hasTable('mod_supportpin')) {
            Capsule::schema()->create('mod_supportpin', function ($table) {
                $table->increments('id');
                $table->integer('customerid');
                $table->string('pin', 20); // Changed to string for flexibility
                $table->timestamps();
            });
        }
        return [
            'status' => 'success',
            'description' => 'Support Pin has been successfully activated.',
        ];
    } catch (\Exception $e) {
        return [
            'status' => "error",
            'description' => 'Unable to create mod_supportpin: ' . $e->getMessage(),
        ];
    }
}

function supportpin_deactivate()
{
    try {
        Capsule::schema()->dropIfExists('mod_supportpin');
        return [
            'status' => 'success',
            'description' => 'Support Pin has been successfully disabled.',
        ];
    } catch (\Exception $e) {
        return [
            "status" => "error",
            "description" => "Unable to drop mod_supportpin: {$e->getMessage()}",
        ];
    }
}

function supportpin_clientarea($vars)
{
    $clientid = $_SESSION['uid'] ?? null;
    if ($clientid === null) {
        return;
    }

    $vars = array_merge($vars, ["clientID" => $clientid]);

    $page = $_GET['page'] ?? 'index';

    // Ensure the page parameter is safe.
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $page)) {
        $page = 'index';
    }

    $CustomFunction = "template_Client_" . $page;
    $TPLManager = new TemplateManager(__DIR__, "client/index.tpl");
    $_lang = $vars['_lang'];
    $modulelink = $vars['modulelink'];

    if ($page == "renew" && isset($_POST['PIN'])) {
        (new ResponseService)->jsonResponse((new TemplateService)->template_RenewPIN($clientid));
    }

    // Inject module assets.
    $headOutput = '<link href="modules/addons/supportpin/assets/css/styles.css" rel="stylesheet">';
    $footerOutput = '<script src="modules/addons/supportpin/assets/js/scripts.js"></script>';

    return [
        'pagetitle' => 'Support PIN',
        'breadcrumb' => ['index.php?m=supportpin' => 'Support PIN'],
        'templatefile' => $TPLManager->getTemplate($page),
        'requirelogin' => true,
        'forcessl' => false,
        'vars' => [
            'modulelink' => $modulelink,
            'tplVars' => (new TemplateService)->$CustomFunction($vars),
            'lang_client_title' => $_lang['client_title'],
            'lang_client_info' => $_lang['client_info'],
            'lang_client_regenerate' => $_lang['client_regenerate'],
            'assetsPath' => 'modules/addons/supportpin/assets',
        ],
    ];
}

function supportpin_output($vars)
{
    $_lang = $vars['_lang'];
    $smarty = new Smarty();
    $page = $_GET['page'] ?? 'index';

    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $page)) {
        $page = 'index';
    }

    $TPLManager = new TemplateManager(__DIR__);

    (new TemplateService)->handle_POST($_POST);

    $smarty->assign('modulelink', $vars['modulelink']);
    $smarty->assign('tplPath', __DIR__ . '/templates');
    $smarty->assign('currentPage', $page);
    $smarty->assign('addonlang', $_lang);
    $smarty->caching = false;
    $smarty->compile_dir = $GLOBALS['templates_compiledir'];

    $CustomFunction = "template_" . $page;
    $smarty->assign('tplVars', (new TemplateService)->$CustomFunction($vars));

    $smarty->display($TPLManager->getTemplate($page, true));
}
