<?php

namespace Inwebo\QueueCommand\Model;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

interface QueueEventDispatcherInterface
{
    public function getEventDispatcher(): EventDispatcherInterface;

    /**
     * Devrait être executée dans Symfony\Component\Console\Command\Command::configure()
     *
     * @return void
     */
    public function configureEventSubscriber(): void;
}