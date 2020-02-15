<?php


namespace App\RequestQueueBundle\Filter;


use App\RequestQueueBundle\Matcher\RouteMatcherInterface;
use App\RequestQueueBundle\Queue\RequestQueueAdapterInterface;
use App\RequestQueueBundle\Resolver\Identity\RequestIdentityResolverInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * Class ResponseFilter
 * @package App\RequestQueueBundle\Filter
 */
final class ResponseFilter
{

    /**
     * @var RequestQueueAdapterInterface
     */
    private $requestQueue;

    /**
     * @var RouteMatcherInterface
     */
    private $routeMatcher;

    /**
     * @var RequestIdentityResolverInterface
     */
    private $requestIdentityResolver;

    /**
     * ResponseFilter constructor.
     * @param RequestQueueAdapterInterface $requestQueue
     * @param RouteMatcherInterface $routeMatcher
     * @param RequestIdentityResolverInterface $requestIdentityResolver
     */
    public function __construct(
        RequestQueueAdapterInterface $requestQueue,
        RouteMatcherInterface $routeMatcher,
        RequestIdentityResolverInterface $requestIdentityResolver
 ) {

        $this->requestQueue = $requestQueue;
        $this->routeMatcher = $routeMatcher;
        $this->requestIdentityResolver = $requestIdentityResolver;
    }

    /**
     * @param ResponseEvent $responseEvent
     */
    public function __invoke(ResponseEvent $responseEvent)
    {
        if(!$this->routeMatcher->isMatched($responseEvent->getRequest()->getUri())) {
            return;
        }

        $currentRequestIdentity = $responseEvent->getRequest()->attributes->get('atomic_request_bundle.current_assigned_ticket');

        $currentIdentityKey = $this->requestIdentityResolver->resolve($responseEvent->getRequest());
        $this->requestQueue->release($currentIdentityKey, $currentRequestIdentity);
    }
}