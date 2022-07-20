<?php

namespace Imsidow\Wapi;

use GuzzleHttp\Client;

class Request
{
    private string $baseUrl = 'https://api.waafipay.net/asm';

    private string $merchantUid;
    private string $apiUserId;
    private string $apiKey;

    public function __construct(string $merchantUid, string $apiUserId, string $apiKey)
    {
        $this->merchantUid = $merchantUid;
        $this->apiUserId = $apiUserId;
        $this->apiKey = $apiKey;
    }

    public function send(array $request = [])
    {
        print_r($this->formatRequest($request));
        return $this->client()->post('', ["json" => $this->formatRequest($request)]);
    }

    private function formatRequest(array $request)
    {
        return [
            "schemaVersion" => "1.0",
            "requestId" => rand(1000000000, 9999999999),
            "timestamp" => time(),
            "channelName" => "WEB",
            "serviceName" => $request['serviceName'],
            "serviceParams" => [
                "merchantUid" => $this->merchantUid,
                "apiUserId" => $this->apiUserId,
                "apiKey" => $this->apiKey,
                "paymentMethod" => "MWALLET_ACCOUNT",
                "payerInfo" => $request['payerInfo'],
                "transactionInfo" => $request['transactionInfo']
            ]
        ];
    }

    private function client(): Client
    {
        return new Client(['base_uri' => $this->baseUrl, 'timeout' => 1000]);
    }
}
