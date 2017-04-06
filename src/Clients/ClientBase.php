<?php

namespace Klever\JustGivingApiSdk\Clients;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ClientBase
{
    public $debug;
    public $Parent;

    /**
     * The HTTP client used to perform requests.
     *
     * @var Client;
     */
    public $curlWrapper;

    /**
     * ClientBase constructor.
     *
     * @param $httpClient
     * @param $justGivingApi
     */
    public function __construct($httpClient, $justGivingApi)
    {
        $this->Parent = $justGivingApi;
        $this->curlWrapper = $httpClient;
        $this->debug = false;
    }

    public function BuildAuthenticationValue()
    {
        return empty($this->Parent->Username)
            ? ''
            : base64_encode($this->Parent->Username . ":" . $this->Parent->Password);
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    protected function getJsonContents(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents());
    }

    /**
     * Perform a GET request.
     *
     * @param string $uri
     * @param        $payload
     * @return ResponseInterface
     */
    protected function get($uri, $payload = null)
    {
        return $this->curlWrapper->get($uri);
    }

    /**
     * Perform a HEAD request.
     *
     * @param string $uri
     * @return ResponseInterface
     */
    protected function head($uri)
    {
        return $this->curlWrapper->get($uri);
    }

    /**
     * Perform a PUT request.
     *
     * @param $uri
     * @param $payload
     * @return ResponseInterface
     */
    protected function put($uri, $payload)
    {
        return $this->curlWrapper->put($uri, ['json' => get_object_vars($payload)]);
    }

    /**
     * Perform a POST request.
     *
     * @param $uri
     * @param $payload
     * @return ResponseInterface
     */
    protected function post($uri, $payload)
    {
        return $this->curlWrapper->post($uri, ['json' => get_object_vars($payload)]);
    }

    /**
     * Perform a DELETE request.
     *
     * @param $uri
     * @return ResponseInterface
     */
    protected function delete($uri)
    {
        return $this->curlWrapper->delete($uri);
    }
}
