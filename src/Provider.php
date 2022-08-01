<?php

namespace Imsidow\Wapi;

use Imsidow\Wapi\Request;

class Provider
{
    private Request $request;

    public function __construct(string $merchantUid, string $apiUserId, string $apiKey)
    {
        $this->request = new Request($merchantUid, $apiUserId, $apiKey);
    }

    /**
     * send request to customer to pay using mobile payment
     * 
     * @param array $options [
     * 
     *  -   mobile: string
     *  -   reference: string
     *  -   invoiceNo: string
     *  -   amount: float
     *  -   currency: string Optional.
     *  -   description: string Optional.
     *  -   brandName: string Optional.
     *  -   category: string Optional.
     * 
     * ]
     * 
     * @return Provider
     * 
     */

    public function requestMobilePayment(array $options): Provider
    {
        $request = [
            "serviceName" => "API_PREAUTHORIZE",
            "payerInfo" => [
                "accountNo" => $options['mobile']
            ],
            "transactionInfo" => [
                "referenceId" => $options['reference'],
                "invoiceId" => $options['invoiceNo'],
                "amount" => $options['amount'],
                "currency" => $options['currency'] ?? "USD",
                "description" => $options['description'] ?? "",
                "paymentBrand" => $options['brandName'] ?? "",
                "transactionCategory" => $options['category'] ?? ""
            ]
        ];
        $response = $this->request->send($request);
        echo json_encode($response);
        return $this;
    }

    public function refundPayment()
    {
        $request = [
            "serviceName" => "API_PREAUTHORIZE",
            'transactionId' => "24280691",
            'description' => "Cancel Transaction",
            'referenceId' => "00001"
        ];
        $response = $this->request->send($request);

        echo json_encode($response);
    }

    public function cancelPurchase()
    {
    }

    public function requestCardPayment()
    {
    }
}
