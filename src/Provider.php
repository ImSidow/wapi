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
     * send payment request to customer to pay using mobile
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

    public function requestPayment(array $options): Provider
    {
        $request = [
            "serviceName" => "API_PREAUTHORIZE",
            'paymentMethod' => "MWALLET_ACCOUNT",
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

    /**
     * refund the amount paid by the customer
     * 
     * @param array $options [ 
     * 
     *  -   reference: string
     *  -   transactionId: string
     *  -   description: string Optional.
     * 
     * ]
     * 
     * @return Provider
     * 
     */
    public function cancelRequestPayment(array $options)
    {
        $request = [
            "serviceName" => "API_PREAUTHORIZE_CANCEL",
            'transactionId' => $options['transactionId'],
            'description' => $options['description'],
            'referenceId' => $options['reference'],
        ];

        $response = $this->request->send($request);
        echo json_encode($response);
    }

    /**
     * refund the amount paid by the customer
     * 
     * @param array $options [ 
     * 
     *  -   transactionId: string
     *  -   reference: string
     *  -   description: string Optional.
     * 
     * ]
     * 
     * @return Provider
     * 
     */
    public function cancelPurchase(array $options)
    {
        $request = [
            "serviceName" => "API_CANCELPURCHASE",
            'transactionId' => $options['transactionId'],
            'description' => $options['description'],
            'referenceId' => $options['reference'],
        ];

        $response = $this->request->send($request);
        echo json_encode($response);
    }

    public function getAccountInfo()
    {
        $request = [
            "serviceName" => "API_GETACCOUNTINFO",
            "paymentMethod" => "MWALLET_ACCOUNT",
            'payerInfo' => [
                "accountNo" => "252615414470",
                "accountType" => "MERCHANT",
                "currency" => "USD",
            ],
        ];

        $response = $this->request->send($request);
        echo json_encode($response);
    }
}
