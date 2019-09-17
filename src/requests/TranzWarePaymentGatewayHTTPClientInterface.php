<?php

namespace num8er\TranzWarePaymentGateway\Requests;

/**
 * Interface TranzWarePaymentGatewayHTTPClientInterface
 * @package num8er\TranzWarePaymentGateway\Requests
 */
interface TranzWarePaymentGatewayHTTPClientInterface
{
    /**
     * TranzWarePaymentGatewayHTTPClientInterface constructor.
     *
     * @param string $url
     * @param null   $body
     * @param null   $sslKeyificate
     */
    public function __construct($url, $body = null, $sslKeyificate = null);

    /**
     * @param string $path_to_file
     * @return void
     */
    public function setDebugToFile($path_to_file);

    /**
     * @return TranzWarePaymentGatewayHTTPClientResultInterface
     */
    public function execute();
}