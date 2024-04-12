<?php

namespace App\Tests\Feature\Link\Controller\API;

use App\Repository\UserRepository;
use Helmich\JsonAssert\JsonAssertions;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AddLinkControllerTest extends WebTestCase
{
    #[Test]
    public function it_cannot_add_a_link_if_not_logged_in(): void
    {
        $client = static::createClient();
        $client->catchExceptions(false);

        $this->expectException(AccessDeniedException::class);
        $client->request('POST', '/api/link');
    }
    
    #[Test]
    public function it_cannot_add_an_invalid_link()
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('gabriel@tentacode.test');
        $client->loginUser($testUser);

        $payload = [
            'url' => 'foobar',
            'isRead' => 'not a boolean',
        ];

        $client->request(
            method: 'POST',
            uri: '/api/link',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload),
        );

        $this->assertResponseStatusCodeSame(422);

        $response = $client->getResponse();
        $this->assertJson($response->getContent());

        $json = json_decode($response->getContent(), true);
        
        $this->assertEquals('validation_error', $json['type']);
        $this->assertEquals('The given data was invalid.', $json['message']);
        $this->assertEquals(['This value is not a valid URL.'], $json['errors']['url']);
        $this->assertEquals(["This value should be of type bool."], $json['errors']['isRead']);
    }

    #[Test]
    public function it_can_add_a_link(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('gabriel@tentacode.test');
        $client->loginUser($testUser);

        $payload = [
            'url' => 'http://127.0.0.1',
            'isRead' => false,
        ];

        $client->request(
            method: 'POST',
            uri: '/api/link',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload),
        );

        $this->assertResponseStatusCodeSame(201);

        $response = $client->getResponse();
        $this->assertJson($response->getContent());

        $json = json_decode($response->getContent(), true);
        $this->assertEquals('http://127.0.0.1', $json['url']);
        $this->assertEquals(false, $json['isRead']);
        // $this->assertMatchesRegularExpression('/[0-9a-f]{8}-([0-9a-f]{4}-){3}[0-9a-f]{12}/', $json['uid']);

    }
}
