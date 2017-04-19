<?php

namespace Klever\JustGivingApiSdk\Clients;

use GuzzleHttp\Client;
use Klever\JustGivingApiSdk\Clients\Models\Model;
use Klever\JustGivingApiSdk\Support\Response;
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
    public $httpClient;

    /**
     * ClientBase constructor.
     *
     * @param $httpClient
     * @param $justGivingApi
     */
    public function __construct($httpClient, $justGivingApi)
    {
        $this->Parent = $justGivingApi;
        $this->httpClient = $httpClient;
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
     * @return ResponseInterface|Response
     */
    protected function get($uri, $payload = null)
    {
        return $this->httpClient->get($uri);
    }

    /**
     * Perform a HEAD request.
     *
     * @param string $uri
     * @return ResponseInterface|Response
     */
    protected function head($uri)
    {
        return $this->httpClient->get($uri);
    }

    /**
     * Perform a PUT request.
     *
     * @param $uri
     * @param $payload
     * @return ResponseInterface|Response
     */
    protected function put($uri, Model $payload)
    {
        return $this->httpClient->put($uri, ['json' => $payload->getAttributes()]);
    }

    /**
     * Perform a POST request.
     *
     * @param $uri
     * @param $payload
     * @return ResponseInterface|Response
     */
    protected function post($uri, $payload)
    {
        return $this->httpClient->post($uri, ['json' => get_object_vars($payload)]);
    }

    /**
     * Perform a POST request with data from a file sent as the request body.
     *
     * @param string $uri
     * @param string $filename
     * @param string $contentType
     * @return Response|ResponseInterface
     */
    protected function postFile($uri, $filename, $contentType = null)
    {
        $options = ['body' => fopen($filename, 'r')];

        if ($contentType !== null) {
            $options['headers']['Content-Type'] = $contentType;
        }

        return $this->httpClient->post($uri, $options);
    }

    /**
     * Perform a DELETE request.
     *
     * @param $uri
     * @return ResponseInterface|Response
     */
    protected function delete($uri)
    {
        return $this->httpClient->delete($uri);
    }
}
