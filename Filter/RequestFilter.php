<?php


namespace App\RequestQueueBundle\Filter;


use App\RequestQueueBundle\Assigner\RequestTicketAssignerInterface;
use App\RequestQueueBundle\Matcher\RouteMatcherInterface;
use App\RequestQueueBundle\Queue\RequestQueueAdapterInterface;
use App\RequestQueueBundle\Resolver\Identity\RequestIdentityResolverInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Class RequestFilter
 * @package App\RequestQueueBundle\Filter
 */
final class RequestFilter
{

    /**
     * @var RequestIdentityResolverInterface
     */
    private $requestIdentityResolver;

    /**
     * @var RequestQueueAdapterInterface
     */
    private $requestQueue;

    /**
     * @var RouteMatcherInterface
     */
    private $routeMatcher;

    private $requestTicketAssigner;

    /**
     * RequestFilter constructor.
     * @param RequestIdentityResolverInterface $requestIdentityResolver
     * @param RequestQueueAdapterInterface $requestQueue
     * @param RouteMatcherInterface $routeMatcher
     * @param RequestTicketAssignerInterface $requestTicketAssigner
     */
    public function __construct(
        RequestIdentityResolverInterface $requestIdentityResolver,
        RequestQueueAdapterInterface $requestQueue,
        RouteMatcherInterface $routeMatcher,
        RequestTicketAssignerInterface $requestTicketAssigner
    ) {
        $this->requestIdentityResolver = $requestIdentityResolver;
        $this->requestQueue = $requestQueue;
        $this->routeMatcher = $routeMatcher;
        $this->requestTicketAssigner = $requestTicketAssigner;
    }

    /**
     * @param RequestEvent $requestEvent
     */
    public function __invoke(RequestEvent $requestEvent) : void
    {
        if(!$this->routeMatcher->isMatched($requestEvent->getRequest()->getUri())) {
            return;
        }

        $currentIdentityKey = $this->requestIdentityResolver->resolve($requestEvent->getRequest());
        $assignedTicket = $this->requestTicketAssigner->assign($currentIdentityKey, time());
        $this->requestQueue->push($currentIdentityKey, $assignedTicket);

        $requestEvent->getRequest()->attributes->set('atomic_request_bundle.current_assigned_ticket', $assignedTicket);

        while($assignedTicket !== $this->requestQueue->pull($currentIdentityKey)) {usleep(5);}
    }
}