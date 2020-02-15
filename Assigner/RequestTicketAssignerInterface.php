<?php


namespace App\RequestQueueBundle\Assigner;


interface RequestTicketAssignerInterface
{
    public function assign(string $identity,  int $unixTime) : string;
}