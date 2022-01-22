<?php

namespace Inwebo\QueueCommand\Model;

use Inwebo\QueueCommand\Model\EventDispatcherInterface as BaseEventDispatcherInterface;

interface EventDispatcherInterface
{
    public function getEventDispatcher(): BaseEventDispatcherInterface;

    /**
     * Devrait être executée dans Symfony\Component\Console\Command\Command::configure()
     * @return void
     */
    public function configureEventSubscriber(): void;
}