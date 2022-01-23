<?php

namespace Inwebo\QueueCommand\EventSubscriber;

use Inwebo\QueueCommand\Event\FinallyEvent;
use Inwebo\QueueCommand\Event\BeforeEvent;
use Inwebo\QueueCommand\Event\AfterEvent;
use Inwebo\QueueCommand\Event\ThrowExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HookSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEvent::class         => 'onBefore',
            AfterEvent::class          => 'onAfter',
            ThrowExceptionEvent::class => 'onThrowException',
            FinallyEvent::class        => 'onFinally',
        ];
    }

    public function onBefore(BeforeEvent $event): void
    {

    }

    public function onAfter(AfterEvent $event): void
    {

    }

    public function onThrowException(ThrowExceptionEvent $event): void
    {
        $event->getOutput()->writeln($event->getException()->getMessage());
    }

    public function onFinally(FinallyEvent $event): void
    {

    }
}