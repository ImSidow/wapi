<?php

namespace Imsidow\Wapi;

use Imsidow\Wapi\Request;

class ClassWapi
{
    public function __construct(string $merchantUid, string $apiUserId, string $apiKey)
    {
        $this->request = new Request($merchantUid, $apiUserId, $apiKey);
    }

    public function requestMobilePayment()
    {
        $res = [
            "serviceName" => "API_PREAUTHORIZE",
            "payerInfo" => [
                "accountNo" => "252616505113"
            ],
            "transactionInfo" => [
                "referenceId" => "11111",
                "invoiceId" => "22222",
                "amount" => "1",
                "currency" => "USD",
                "description" => "wan diray",
                "paymentBrand" => "WAAFI",
                "transactionCategory" => "ECOMMERCE"
            ]
        ];

        $response = $this->request->send($res);
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

    private function request()
    {
    }
}
