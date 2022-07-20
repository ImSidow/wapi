<?php

use Imsidow\Wapi\Http;

class Wapi
{
    public function requestMobilePayment()
    {
        $response = Http::post('', [
            "schemaVersion" => "1.0",
            "requestId" => "random",
            "timestamp" => "getDate",
            "channelName" => "WEB",
            "serviceName" => "SERVICE_NAME",
            "sessionId" => "ex_SF_8983850290821187755",
            "serviceParams" => []
        ]);


        echo $response->getStatusCode();
    }

    public function refundPayment()
    {
    }

    public function cancelPurchase()
    {
    }

    public function requestCardPayment()
    {
    }
}

$wapi = new Wapi();

$wapi->requestMobilePayment();
