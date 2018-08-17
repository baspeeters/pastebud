<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class RESTApiTestCase extends WebTestCase
{
    /** @var Client $client */
    protected $client;

    /** @var string $baseUrl */
    protected $baseUrl;

    const HEADERS = [
        'CONTENT_TYPE' => 'application/json',
        'ACCEPT' => 'application/json',
        'PHP_AUTH_USER' => 'user-1',
        'PHP_AUTH_PW' => 'test123',
    ];

    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->baseUrl = $_SERVER['TEST_SERVER_URL'];
        $this->client = self::createClient();

        $this->logIn();
    }

    public function list($path, array $parameters = [], array $headers = [])
    {
        return $this->request('GET', $path, null, $parameters, $headers);
    }

    public function post($path, array $body = [], array $parameters = [], array $files = [], array $headers = [])
    {
        return $this->request('POST', $path, null, $parameters, $files, $headers, json_encode($body));
    }

    public function put($path, $id, array $body = [], array $parameters = [], array $files = [], array $headers = [])
    {
        return $this->request('PUT', $path, $id, $parameters, $files, $headers, json_encode($body));
    }

    public function delete($path, $id, array $parameters = [], array $headers = [])
    {
        return $this->request('DELETE', $path, $id, $parameters, [], $headers);
    }

    public function get($path, $id, array $parameters = [], array $headers = [])
    {
        return $this->request('GET', $path, $id, $parameters, [], $headers);
    }

    public function request($method, $path, $id = null, $parameters = [], $files = [], $headers = [], $body = [])
    {
        $this->client->request(
            $method,
            $this->getApiUrl($path, $id),
            $parameters,
            $files,
            $headers + self::HEADERS,
            $body
        );

        return json_decode($this->client->getResponse()->getContent(), true);
    }

    public function logIn()
    {
        /** @var Session $session */
        $session = $this->client->getContainer()->get('session');

        $firewallName = 'main';
        $token = new UsernamePasswordToken('user-1', 'test123', $firewallName, ['ROLE_USER']);

        $session->set('_security_' . $firewallName, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());

        $this->client->getCookieJar()->set($cookie);
    }

    /**
     * @param string $path
     * @param null $id
     * @return string
     */
    private function getApiUrl(string $path, $id = null): string
    {
        return is_null($id) !== false
            ? $this->baseUrl . $path . '.json'
            : $this->baseUrl . $path . '/' . $id . '.json';
    }
}
