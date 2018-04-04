<?php
namespace RemoteProxy\Adapter;

use GuzzleHttp\ClientInterface;
use ProxyManager\Factory\RemoteObject\AdapterInterface;
/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 18-4-4
 * Time: 下午3:32
 */

class RestAdapter implements AdapterInterface
{

    /**
     * Adapter client
     *
     * @var GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * Mapping information
     *
     * @var array
     */
    protected $map;

    /**
     * Constructor
     *
     * @param Client $client
     * @param array  $map    Map of service names to their aliases
     */
    public function __construct(ClientInterface $client, $map = [])
    {
        $this->client  = $client;

        $this->map     = $map;
    }

    /**
     * {@inheritDoc}
     */
    public function call(string $wrappedClass, string $method, array $parameters = [])
    {
        if (!isset($this->map[$method])) {
            throw new \RuntimeException('No endpoint has been mapped to this method.');
        }
        $endpoint =  $this->map[$method];
        $path     = $this->compilePath($endpoint['path'], $parameters);

        $response = $this->client->request(strtoupper($endpoint['method']), $path);

        return (string) $response->getBody();
    }

    /**
     * Compile URL with its values
     *
     * @param string $path
     * @param array $parameters
     *
     * @return string
     */
    protected function compilePath($path, $parameters)
    {
        return preg_replace_callback('|:\w+|', function ($matches) use (&$parameters) {
            return array_shift($parameters);
        }, $path);
    }
}