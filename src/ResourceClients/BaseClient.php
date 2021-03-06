<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients;

use Illuminate\Support\Str;
use Konsulting\JustGivingApiSdk\JustGivingClient;
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
     * The JustGiving client used to perform requests.
     *
     * @var JustGivingClient;
     */
    private $client;

    /**
     * ClientBase constructor.
     *
     * @param JustGivingClient $client
     */
    public function __construct(JustGivingClient $client)
    {
        $this->client = $client;
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
        return $this->request('get', $uri);
    }

    /**
     * Perform a HEAD request.
     *
     * @param string $uri
     * @return Response|ResponseInterface
     */
    protected function head($uri)
    {
        return $this->request('head', $uri);
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
        return $this->request('put', $uri,
            ['json' => isset($payload) ? $payload->getAttributes() : '']);
    }

    /**
     * Perform a POST request.
     *
     * @param       $uri
     * @param Model|array $payload
     * @return Response|ResponseInterface
     */
    protected function post($uri, $payload = null)
    {
        return $this->request('post', $uri,
            ['json' => $this->getPayloadAttributes($payload)]);
    }

    /**
     * Get the payload as an array.
     *
     * @param Model|array|null $payload
     * @return array
     */
    private function getPayloadAttributes($payload)
    {
        if ($payload instanceof Model) {
            return $payload->getAttributes();
        }

        return is_array($payload) ? $payload : [];
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

        return $this->request('post', $uri, $options);
    }

    /**
     * Perform a DELETE request.
     *
     * @param string $uri
     * @return Response|ResponseInterface
     */
    protected function delete($uri)
    {
        return $this->request('delete', $uri);
    }

    /**
     * Perform a request on the HTTP client.
     *
     * @param string $method
     * @param string $uri
     * @param array  $options
     */
    private function request($method, $uri, $options = [])
    {
        return $this->client->request($method, $uri, $options);
    }
}
