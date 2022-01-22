<?php

namespace Inwebo\QueueCommand\Model;

use Inwebo\QueueCommand\Model\EventDispatcherInterface;

trait EventDispatcherTrait
{
    protected EventDispatcherInterface $eventDispatcher;

    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher; 
    }
}