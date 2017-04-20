<?php

namespace Klever\JustGivingApiSdk\Clients;

use GuzzleHttp\Client;
use Klever\JustGivingApiSdk\Clients\Models\Model;
use Klever\JustGivingApiSdk\Support\Response;
use Psr\Http\Message\ResponseInterface;

class BaseClient
{
    /**
     * Method name aliases.
     *
     * @var array
     */
    protected $aliases = [];

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
    public function __construct($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Allow aliases to be defined for API methods.
     *
     * @param $calledMethod
     * @param $args
     * @return mixed
     */
    public function __call($calledMethod, $args)
    {
        foreach ($this->aliases as $realMethod => $aliases) {
            if (in_array($calledMethod, (array) $aliases)) {
                return $this->$realMethod(...$args);
            }
        }
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
     * @return Response|ResponseInterface
     */
    protected function get($uri)
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
        return $this->httpClient->head($uri);
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
