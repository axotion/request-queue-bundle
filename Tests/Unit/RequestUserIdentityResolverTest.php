<?php


namespace App\RequestQueueBundle\Tests\Unit;


use App\RequestQueueBundle\Resolver\Identity\RequestUserIdentityResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class RequestUserIdentityResolverTest extends TestCase
{
    public function test_same_request_user_identity() : void
    {
        $token = $this->createMock(TokenInterface::class);
        $token->method('getUsername')->willReturn('test123');

        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $tokenStorage->method('getToken')->willReturn($token);

        $request = new Request();

        $requestUserIdentityResolver = new RequestUserIdentityResolver($tokenStorage);
        $identity = $requestUserIdentityResolver->resolve($request);

        $this->assertSame('test123', $identity);
    }
}