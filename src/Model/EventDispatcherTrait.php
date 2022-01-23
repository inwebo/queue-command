<?php

namespace Inwebo\QueueCommand\Model;

use Inwebo\QueueCommand\Model\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as BaseEventDispatcher;


trait EventDispatcherTrait
{
    protected EventDispatcherInterface|BaseEventDispatcher $eventDispatcher;

    public function getEventDispatcher(): EventDispatcherInterface|BaseEventDispatcher
    {
        return $this->eventDispatcher; 
    }
}