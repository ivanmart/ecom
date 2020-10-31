<?php

$url = 'https://.../UTPublic/ws/UTPublic';

return [

    'wsdl' => $url . '?wsdl',

    'options' => [
        'location' => $url,
        'login' => '...',
        'password' => '...',
        'soap_version' => SOAP_1_2,
        'cache_wsdl' => WSDL_CACHE_NONE,
    ],

    'request_id' => ['RequestID' => [
        'siteID' => '...',
        'Password' => '...',
        'RequestKey' => 'ch-' . md5(time())
    ]],

];
