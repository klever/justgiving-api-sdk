<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Str;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\Model;
use Konsulting\JustGivingApiSdk\Support\Response;
use Psr\Http\Message\ResponseInterface;

abstract class BaseClient
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
     * @var ClientInterface;
     */
    public $httpClient;

    /**
     * ClientBase constructor.
     *
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Check if the called method is valid if it's converted to camel case. If not, look for a defined method alias
     * that's either an exact match, or the Pascal-cased version of the called method.
     *
     * @param $calledMethod
     * @param $args
     * @return mixed
     */
    public function __call($calledMethod, $args)
    {
        $camelMethod = Str::camel($calledMethod);
        $pascalMethod = Str::studly($calledMethod);

        if (method_exists($this, $camelMethod)) {
            return $this->$camelMethod(...$args);
        }

        foreach ($this->aliases as $realMethod => $aliases) {
            if (in_array($calledMethod, (array) $aliases) || in_array($pascalMethod, (array) $aliases)) {
                return $this->$realMethod(...$args);
            }
        }
    }

    /**
     * Perform a GET request.
     *
     * @param string $uri
     * @return Response|ResponseInterface
     */
    protected function get($uri)
    {
        return $this->httpClient->request('get', $uri);
    }

    /**
     * Perform a HEAD request.
     *
     * @param string $uri
     * @return Response|ResponseInterface
     */
    protected function head($uri)
    {
        return $this->httpClient->request('head', $uri);
    }

    /**
     * Perform a PUT request.
     *
     * @param       $uri
     * @param Model $payload
     * @return Response|ResponseInterface
     */
    protected function put($uri, Model $payload = null)
    {
        return $this->httpClient->request('put', $uri,
            ['json' => isset($payload) ? $payload->getAttributes() : '']);
    }

    /**
     * Perform a POST request.
     *
     * @param       $uri
     * @param Model $payload
     * @return Response|ResponseInterface
     */
    protected function post($uri, Model $payload = null)
    {
        return $this->httpClient->request('post', $uri,
            ['json' => isset($payload) ? $payload->getAttributes() : '']);
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

        return $this->httpClient->request('post', $uri, $options);
    }

    /**
     * Perform a DELETE request.
     *
     * @param string $uri
     * @return Response|ResponseInterface
     */
    protected function delete($uri)
    {
        return $this->httpClient->request('delete', $uri);
    }
}
