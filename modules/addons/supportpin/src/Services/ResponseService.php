<?php
/**
 * WHMCS-SupportPIN - Let your customers generate a support/phone pin to identify your customers faster, for example on the phone
 *
 * Copyright (c) 2021 SWASTIK.DEV
 *
 * This file is part of swastik/whmcs-supportpin-module
 *
 * Licensed under GPL-3.0 (https://github.com/SwastikBelieves/Advance-Support-Pin-WHMCS-Module)
 */

namespace SwastikDev\SupportPin\Services;

class ResponseService
{

    public function __construct()
    {
    }


    /**
     * Send a JSON response.
     * @param array $data
     * @return json
     */
    public function jsonResponse(array $data)
    {
        $response = new \WHMCS\Http\JsonResponse((array) $data);
        $response->send();
        \WHMCS\Terminus::getInstance()->doExit();
    }

}
