<?php

namespace num8er\TranzWarePaymentGateway\Requests;

/**
 * Interface TranzWarePaymentGatewayRequestInterface
 * @package num8er\TranzWarePaymentGateway\Requests
 */
interface TranzWarePaymentGatewayRequestInterface
{
    /**
     * Executes request and returns instance of
     * class that implements TranzWarePaymentGatewayRequestResultInterface
     *
     * @return TranzWarePaymentGatewayRequestResultInterface
     */
    public function execute();

    /**
     * Sets ssl certificate file path required in request
     *
     * @param string $cert
     * @param string $certPass
     *
     * @return void
     */
    public function setSslCertificate($cert, $certPass = '');
}