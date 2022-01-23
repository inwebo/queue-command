<?php

namespace Inwebo\QueueCommand\Model;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

trait EventDispatcherTrait
{
    protected EventDispatcherInterface $eventDispatcher;

    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher; 
    }
}