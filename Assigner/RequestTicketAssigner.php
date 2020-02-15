<?php


namespace App\RequestQueueBundle\Assigner;


/**
 * Class RequestTicketAssigner
 * @package App\RequestQueueBundle\Assigner
 */
final class RequestTicketAssigner implements RequestTicketAssignerInterface
{
    /**
     * @param string $identity
     * @param int $unixTime
     * @return string
     */
    public function assign(string $identity, int $unixTime): string
    {
        if($unixTime <= 0) {
            throw new \LogicException('Invalid unix time');
        }

        return $identity.$unixTime;
    }
}