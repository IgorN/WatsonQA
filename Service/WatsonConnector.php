<?php

namespace Babylon\WatsonBundle\Service;

/**
 * Wrapper for connection with watson.
 */
class WatsonConnector
{
    /**
     * Method POST.
     */
    const HTTP_METHOD_POST = 'POST';

    /**
     * Method PUT.
     */
    const HTTP_METHOD_PUT = 'PUT';

    /**
     * Method GET.
     */
    const HTTP_METHOD_GET = 'GET';

    /**
     * @var resource to curl
     */
    private $ch;

    /**
     * Called url.
     *
     * @var string
     */
    private $uri;

    /**
     * Http headers.
     *
     * @var array
     */
    private $headers;

    /**
     * Curl options.
     *
     * @var array
     */
    private $options;

    /**
     * Raw response from watson.
     *
     * @var string
     */
    private $response;

    /**
     * Initialization of the required data.
     */
    public function __construct()
    {
        if (! function_exists('curl_version')) {
            throw new \InvalidArgumentException("Curl is not installed.");
        }

        $this->initDefaultHeaders();
        $this->initDefaultOptions();

        $this->ch = curl_init();
    }

    /**
     * Get corresponding uri.
     *
     * @return string
     */
    public function getUri()
    {
        if (empty($this->uri)) {
            throw new \InvalidArgumentException("Uri can't be empty!");
        }

        return $this->uri;
    }

    /**
     * Set corresponding uri.
     *
     * @param string $uri
     *
     * @return $this
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Call corresponding uri.
     *
     * @param string $postData
     * @param string $method
     *
     * @return string
     */
    public function call($postData, $method = self::HTTP_METHOD_POST)
    {
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt_array($this->ch, $this->getOptions());
        curl_setopt($this->ch, CURLOPT_URL, $this->getUri());
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $postData);
        // TODO: need remove 
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);

        $this->response = curl_exec($this->ch);
        if (! $this->response) {
            throw new \InvalidArgumentException(
                //curl_errno($this->ch),
                curl_error($this->ch)
            );
        }

        return $this->response;
    }

    /**
     * Set base64 string for Basic Auth.
     * Encoded username and password to base64.
     *
     * @param string $value
     */
    public function setAuthorizationBasicHeader($value)
    {
        $this->headers[] = 'Authorization: Basic ' . $value;
    }

    /**
     * Get the curl options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get http headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get system information.
     *
     * @return mixed
     */
    public function getInfo()
    {
        return curl_getinfo($this->ch);
    }

    /**
     * Get http status code 200, 201 and so on.
     *
     * @return string
     */
    public function getHttStatusCode()
    {
        return $this->getInfo()['http_code'];
    }

    /**
     * Check http status code on 200.
     *
     * @return bool
     */
    public function isOk()
    {
        return $this->getHttStatusCode() == 200 ? true : false;
    }

    /**
     * Raw response from watson.
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Init default headers.
     */
    private function initDefaultHeaders()
    {
        $this->headers = [
            'Content-Type: application/json',
            'X-SyncTimeout: 30'
        ];
    }

    /**
     * Init default options.
     */
    private function initDefaultOptions()
    {
        $this->options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CONNECTTIMEOUT => 30
        ];
    }

    /**
     * Clear resources.
     */
    public function __destruct()
    {
        curl_close($this->ch);
    }
}