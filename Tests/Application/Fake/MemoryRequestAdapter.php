<?php


namespace App\RequestQueueBundle\Tests\Application\Fake;


use App\RequestQueueBundle\Queue\RequestQueueAdapterInterface;

/**
 * Class MemoryRequestAdapter
 * @package App\RequestQueueBundle\Queue
 */
final class MemoryRequestAdapter implements RequestQueueAdapterInterface
{

    /**
     * @var
     */
    private $storage;

    /**
     * @param string $channel
     * @param string $identity
     */
    public function push(string $channel, string $identity): void
    {
        $this->storage[$channel][] = $identity;
    }

    /**
     * @param string $channel
     * @return string
     */
    public function pull(string $channel): string
    {
        return reset($this->storage[$channel]);
    }

    /**
     * @param string $channel
     * @param string $identity
     */
    public function release(string $channel, string $identity): void
    {
        foreach ($this->storage[$channel] as $index => $currentIdentity) {

            if($currentIdentity === $identity) {
                unset($this->storage[$channel][$index]);
            }
        }
    }
}