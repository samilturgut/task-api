<?php

namespace Api;

use App\DataFixtures\AppFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class ApiTest extends KernelTestCase
{
    private $client;
    
    public function __construct()
    {
        parent::__construct();
    
        $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');
        
        $purger = new ORMPurger($this->em);
        $purger->setPurgeMode(1);
        $purger->purge();
    
        $passwordHasherFactory = new PasswordHasherFactory([
            PasswordAuthenticatedUserInterface::class => ['algorithm' => 'auto'],
        ]);
    
        $loader = new Loader();
        $loader->addFixture(new AppFixtures(new UserPasswordHasher($passwordHasherFactory)));
    
        $purger = new ORMPurger($this->em);
        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());
    }
    
    public function setUp(): void
    {
        parent::setUp();
        $this->client = new Client([
            'base_uri' => 'http://localhost:8080',
            'timeout'  => 2.0,
        ]);
    }
    
    private function makeJsonRequest(string $uri, string $method = 'POST', ?array $data = [], ?array $headers = []): \Psr\Http\Message\ResponseInterface
    {
        return $this->client->request($method, $uri, [
            'json' => $data,
            'headers' => $headers
        ]);
    }
    
    public function testUserLoginSuccess()
    {
        $response = $this->makeJsonRequest('/api/login', 'POST', ['username' => 'user@samil.turgut', 'password' => '123456']);
        $this->assertEquals(200, $response->getStatusCode());
        
        $response = json_decode($response->getBody()->getContents(), true);
        
        return $response['data']['token'];
    }
    
    public function testExpertLoginSuccess()
    {
        $response = $this->makeJsonRequest('/api/login', 'POST', ['username' => 'expert@samil.turgut', 'password' => '123456']);
        $this->assertEquals(200, $response->getStatusCode());
        
        $response = json_decode($response->getBody()->getContents(), true);
        
        return $response['data']['token'];
    }
    
    /**
     * @depends testUserLoginSuccess
     */
    public function testUserGetTasksSuccess($token)
    {
        $response = $this->makeJsonRequest('/api/tasks', 'GET', [], ['X-Token' => $token]);
        $this->assertEquals(200, $response->getStatusCode());
        
        $response = json_decode($response->getBody()->getContents(), true);
        
        $this->assertEquals(true, $response['success']);
        $this->assertCount(1, $response['data']);
    }
    
    /**
     * @depends testExpertLoginSuccess
     */
    public function testExpertGetTasksSuccess($token)
    {
        $response = $this->makeJsonRequest('/api/tasks', 'GET', [], ['X-Token' => $token]);
        $this->assertEquals(200, $response->getStatusCode());
        
        $response = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(true, $response['success']);
        $this->assertCount(2, $response['data']);
    }
    
    /**
     * @depends testExpertLoginSuccess
     */
    public function testUserCreateTaskSuccess($token)
    {
        $response = $this->makeJsonRequest('/api/task', 'POST', [
            'content' => 'Test task in unit test',
            'categories' => [1, 2],
            'priority' => 1,
            'status' => 1,
        ], ['X-Token' => $token]);
    
        $this->assertEquals(201, $response->getStatusCode());
    
        $response = json_decode($response->getBody()->getContents(), true);
    
        $this->assertEquals(true, $response['success']);
        $this->assertCount(1, $response['data']);
        $this->assertEquals('Test task in unit test', $response['data'][0]['content']);
    }
}