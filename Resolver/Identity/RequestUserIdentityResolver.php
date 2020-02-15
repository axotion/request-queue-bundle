<?php


namespace App\RequestQueueBundle\Resolver\Identity;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class RequestUserIdentityResolver
 * @package App\RequestQueueBundle\Resolver\Identity
 */
final class RequestUserIdentityResolver implements RequestIdentityResolverInterface
{

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * RequestUserIdentityResolver constructor.
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function resolve(Request $request): string
    {
        if($this->tokenStorage->getToken() === null) {
            throw new \LogicException('Cannot resolve user');
        }

        return $this->tokenStorage->getToken()->getUsername();
    }
}