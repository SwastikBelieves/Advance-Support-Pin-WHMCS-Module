<!-- 
/**
 * WHMCS-SupportPIN - Empower your clients with Instant Identity Verification. Our advanced Support PIN system ensures secure, friction-less authentication, allowing your team to verify ownership in seconds during voice or chat interactions.
 *
 * Copyright (c) 2026 SWASTIK.DEV
 *
 * This file is part of swastik/whmcs-supportpin-module
 *
 * Licensed under GPL-3.0 (https://github.com/SwastikBelieves/Advance-Support-Pin-WHMCS-Module)
 */
 -->
 
 <link rel="stylesheet" href="../modules/addons/supportpin/assets/css/admin.css">

 
<h3>{$addonlang['admin_title_activepins']}</h3>
<table id="supportpinCustomers" style="width:100%">
    <tr>
        <th style="width: 5%">{$addonlang['admin_table_id']}</th>
        <th style="width: 20%">{$addonlang['admin_table_firstname']}</th>
        <th style="width: 20%">{$addonlang['admin_table_lastname']}</th>
        <th style="width: 10%">{$addonlang['admin_table_pin']}</th>
        <th style="width: 25%">{$addonlang['admin_table_updated']}</th>
        <th style="width: 10%"></th>
    </tr>
    
    {foreach from=$tplVars.clients item=$client}
    <tr>
        <td>{$client->customerid}</td>
        <td>{$client->firstname}</td>
        <td>{$client->lastname}</td>
        <td>{$client->pin}</td>
        <td>{$client->updated_at}</td>
        <td style="text-align: center;"><a href="clientssummary.php?userid={$client->customerid}" class="btn btn-success">{$addonlang['admin_table_gocustomer']}</a></td>
    </tr>
    {/foreach}