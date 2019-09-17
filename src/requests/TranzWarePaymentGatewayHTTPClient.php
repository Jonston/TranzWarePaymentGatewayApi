<?php
namespace num8er\TranzWarePaymentGateway\Requests;

/**
 * Class TranzWarePaymentGatewayHTTPClient
 * @package num8er\TranzWarePaymentGateway\Requests
 */
class TranzWarePaymentGatewayHTTPClient implements TranzWarePaymentGatewayHTTPClientInterface
{
    protected $url;
    protected $body;
    protected $sslKeyificate;
    protected $debug = false;
    protected $debugToFile;

    /**
     * TranzWarePaymentGatewayHTTPClient constructor.
     * @param string $url
     * @param null $body
     * @param null $sslKey
     */
    public function __construct
    (
        $url,
        $body = null,
        $sslKey = null
    )
    {
        $this->url = $url;
        $this->body = $body;
        $this->sslKey = $sslKey;
    }

    /**
     * Set debug to log file
     *
     * @param string $path_to_file
     */
    final public function setDebugToFile($path_to_file)
    {
        $this->debug = true;
        $this->debugToFile = $path_to_file;
    }

    /**
     * Executes request and returns instance of result object
     *
     * @return TranzWarePaymentGatewayHTTPClientResult
     */
    final public function execute()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);
        if ($this->debug) {
            curl_setopt($ch, CURLOPT_STDERR, fopen($this->debugToFile, 'w+'));
        }
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/xml',
            'Content-Length: '.strlen($this->body)
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->body);

        if ($this->sslKeyificate) {
            $sslKey = $this->sslKeyificate['key'];
            $sslKeyPass = $this->sslKeyificate['keyPass'];
            curl_setopt($ch, CURLOPT_SSLKEY, $sslKey);
            curl_setopt($ch, CURLOPT_SSLKEYPASSWD, $sslKeyPass);
        }

        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        return new TranzWarePaymentGatewayHTTPClientResult(
            $output,
            $info
        );
    }
}