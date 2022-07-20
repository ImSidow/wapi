<?php

namespace Imsidow\Wapi;

use GuzzleHttp\Client;
use Imsidow\Wapi\Enumerations\ResponseStatusCode;

class Request
{
    private string $baseUrl = 'https://api.waafipay.net/asm';

    private string $merchantUid;
    private string $apiUserId;
    private string $apiKey;
    private array $statusCodeMessage = [
        430 => 'insufficient balance',
        432 => 'invalid pin code',
        434 => 'user cancel',
        436 => 'request timeout',
    ];

    public function __construct(string $merchantUid, string $apiUserId, string $apiKey)
    {
        $this->merchantUid = $merchantUid;
        $this->apiUserId = $apiUserId;
        $this->apiKey = $apiKey;
    }

    public function send(array $request = [])
    {
        $response = $this->client()->post('', ["json" => $this->formatRequest($request)]);
        return $this->formatResponse($response);
    }

    private function formatRequest(array $request): array
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

    private function formatResponse($response): array
    {
        $response = json_decode($response->getBody()->getContents(), true);
        if ($response['errorCode'] === 'E10205') {
            return $this->errorResponse($response);
        }
    }

    private function errorResponse($response): array
    {
        $statusCode = $this->responseMessageToStatusCode($response['responseMsg']);
        return [
            "error" => true,
            "message" => $this->statusCodeMessage[$statusCode],
            "statusCode" => $statusCode,
            "params" => [
                "timestamp" => $response['timestamp'],
                "requestId" => $response['requestId'],
                "transactionId" => $this->getTransactionIdFromResponseMessage($response['responseMsg']),
                ...$response['params']
            ]
        ];
    }

    private function getTransactionIdFromResponseMessage(string $message): string
    {
        preg_match('/TransactionId: (\w+)/i', $message, $out);
        return $out[1] ?? "";
    }

    private function responseMessageToStatusCode(string $message): int
    {
        if (preg_match('/Invalid PIN code/i', $message)) {
            return ResponseStatusCode::INVALID_PIN_CODE;
        } else if (preg_match('/error occurred/i', $message)) {
            return ResponseStatusCode::USER_CANCEL;
        } else if (preg_match('/balance is not sufficient/i', $message)) {
            return ResponseStatusCode::INSUFFICIENT_BALANCE;
        }

        return ResponseStatusCode::UNKNOWN;
    }

    private function client(): Client
    {
        return new Client(['base_uri' => $this->baseUrl, 'timeout' => 15]);
    }
}
