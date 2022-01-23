<?php

namespace Inwebo\QueueCommand\Model;

use Inwebo\QueueCommand\Model\EventDispatcherInterface as BaseEventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as BaseSymfonyInterface;

interface EventDispatcherInterface extends BaseSymfonyInterface
{
    public function getEventDispatcher(): BaseEventDispatcherInterface|BaseSymfonyInterface;

    /**
     * Devrait être executée dans Symfony\Component\Console\Command\Command::configure()
     * @return void
     */
    public function configureEventSubscriber(): void;
}