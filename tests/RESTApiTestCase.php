<?php

namespace App\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Client;
use Unirest\Request;
use Unirest\Request\Body;
use Unirest\Response;

class RESTApiTestCase extends WebTestCase
{
    /** @var Client $client */
    protected $client;

    /** @var EntityManager $em */
    protected $em;

    /** @var string $baseUrl */
    protected $baseUrl;

    const HEADERS = [
        'content-type' => 'application/json',
        'accept' => 'application/json',
    ];

    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->baseUrl = 'http://localhost:8000/api/';
    }

    public function list($path, $params = null, array $headers = [])
    {
        return Request::get(
            $this->baseUrl . $path . '.json',
            $headers + self::HEADERS,
            $params
        );
    }

    public function post($path, $body = null, array $headers = [])
    {
        return Request::post(
            $this->baseUrl . $path . '.json',
            $headers + self::HEADERS,
            Body::Json($body)
        );
    }

    public function put($path, $id, $body = null, array $headers = [])
    {
        return Request::put(
            $this->baseUrl . $path . '/' . $id . '.json',
            $headers + self::HEADERS,
            Body::Json($body)
        );
    }

    public function delete($path, $id, array $headers = [])
    {
        return Request::delete(
            $this->baseUrl . $path . '/' . $id . '.json',
            $headers + self::HEADERS
        );
    }

    public function get($path, $id, $params = null, array $headers = [])
    {
        return Request::get(
            $this->baseUrl . $path . '/' . $id . '.json',
            $headers + self::HEADERS,
            $params
        );
    }

    public static function getArrayResponseBody(Response $response)
    {
        return json_decode($response->raw_body, true);
    }
}
