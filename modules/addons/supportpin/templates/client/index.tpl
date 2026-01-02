<!--
* WHMCS-SupportPIN
* Copyright (c) 2026 SWASTIK.DEV
* Licensed under GPL-3.0
-->

<link href="modules/addons/supportpin/assets/css/styles.css" rel="stylesheet">

<div class="supportpin-container">
    <div class="supportpin-title">{$lang_client_title}</div>

    <div id="sPIN" class="supportpin-display">{$tplVars.supportpin}</div>

    <p class="text-muted">{$lang_client_info}</p>

    <div class="supportpin-actions">
        <button onclick="supportPin.renew(event)" class="btn-renew">
            <i class="fas fa-sync-alt"></i> {$lang_client_regenerate}
        </button>
    </div>
</div>

<script src="modules/addons/supportpin/assets/js/scripts.js"></script>