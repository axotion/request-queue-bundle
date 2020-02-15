<?php


namespace App\RequestQueueBundle\Filter;


use App\RequestQueueBundle\Matcher\RouteMatcherInterface;
use App\RequestQueueBundle\Queue\RequestQueueAdapterInterface;
use App\RequestQueueBundle\Resolver\Identity\RequestIdentityResolverInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 * Class KernelExceptionFilter
 * @package App\RequestQueueBundle\Filter
 */
final class KernelExceptionFilter
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
     * KernelExceptionFilter constructor.
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
     * @param ExceptionEvent $exceptionEvent
     */
    public function __invoke(ExceptionEvent $exceptionEvent)
    {
        if(!$this->routeMatcher->isMatched($exceptionEvent->getRequest()->getUri())) {
            return;
        }

        $currentRequestIdentity = $exceptionEvent->getRequest()->attributes->get('atomic_request_bundle.current_assigned_ticket');

        if($currentRequestIdentity === null) {
            return;
        }

        $currentIdentityKey = $this->requestIdentityResolver->resolve($exceptionEvent->getRequest());
        $this->requestQueue->release($currentIdentityKey, $currentRequestIdentity);
    }
}