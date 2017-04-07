<?php

namespace Klever\JustGivingApiSdk\Clients;

use GuzzleHttp\Client;
use Klever\JustGivingApiSdk\Clients\Models\Model;
use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\Psr7\stream_for;

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
    protected function put($uri, Model $payload)
    {
        dd(json_encode(get_object_vars($payload)));
        return $this->curlWrapper->put($uri, ['json' => $payload->getAttributes()]);
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

    protected function postFile($uri, $filename, $contentType = null)
    {
        return $this->curlWrapper->post($uri, ['multipart' => [
            [
                'name'     => basename($filename),
                'contents' => stream_for($filename)
            ]
        ]
        ]);
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
