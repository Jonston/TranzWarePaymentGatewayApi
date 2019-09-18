<?php

namespace num8er\TranzWarePaymentGateway\Requests;

use \num8er\TranzWarePaymentGateway\OrderTypes;

/**
 * Class TranzWarePaymentGatewayOrderRequest
 * @package num8er\TranzWarePaymentGateway\Requests
 */
class TranzWarePaymentGatewayOrderRequest implements TranzWarePaymentGatewayRequestInterface
{
    private $requestAttributes = [];
    private $debugToFile = null;

    /**
     * TranzWarePaymentGatewayOrderRequest constructor.
     *
     * @param string $requestUrl
     * @param string $approvalUrl
     * @param string $declineUrl
     * @param string $cancelUrl
     * @param string{OrderTypes::PURCHASE, OrderTypes::PRE_AUTH} $orderType
     * @param string $merchantId
     * @param float  $amount
     * @param string $currency
     * @param string $description
     * @param string $lang
     * @param string $debugToFile
     */
    public function __construct(
        $requestUrl, $approvalUrl, $declineUrl, $cancelUrl,
        $orderType, $merchantId, $amount, $currency,
        $description = '', $lang = 'EN', $debugToFile = null
    )
    {
        $this->requestAttributes =
            compact('requestUrl', 'approvalUrl', 'declineUrl', 'cancelUrl', 'orderType', 'merchantId', 'amount', 'currency', 'description', 'lang');
        $this->debugToFile = $debugToFile;
    }

    /**
     * Run HTTP client request
     *
     * @return TranzWarePaymentGatewayOrderRequestResult
     */
    public function execute()
    {
        $ssl = [
            'cert'      => $this->sslCert,
            'certPass'  => $this->sslCertPass,
        ];
        $httpClient =
            new TranzWarePaymentGatewayHTTPClient($this->requestAttributes['requestUrl'], $this->getRequestBody(), $ssl);
        if ($this->debugToFile) {
            $httpClient->setDebugToFile($this->debugToFile);
        }
        return new TranzWarePaymentGatewayOrderRequestResult($httpClient->execute());
    }

    /**
     * Get request body
     *
     * @return string
     */
    final private function getRequestBody()
    {
        $orderType = OrderTypes::fromString($this->requestAttributes['orderType']);
        $templateFile = __DIR__ . '/templates/'.$orderType.'OrderRequestBodyTemplate.xml';
        $body = file_get_contents($templateFile);
        foreach ($this->requestAttributes AS $key => $value) {
            $body = str_replace('{{' . $key . '}}', $value, $body);
        }
        return $body;
    }

    private $sslCert, $sslCertPass;

    /**
     * Set ssl certificate
     *
     * @param string $sslCert
     * @param string $sslCertPass
     *
     * @return void
     */
    final public function setSslCertificate($sslCert, $sslCertPass = '')
    {
        $this->sslCert = $sslCert;
        $this->sslCertPass = $sslCertPass;
    }
}