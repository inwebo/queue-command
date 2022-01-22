<?php

namespace Inwebo\QueueCommand\EventSubscriber;

use Inwebo\QueueCommand\Event\FinallyEvent;
use Inwebo\QueueCommand\Event\InEvent;
use Inwebo\QueueCommand\Event\OutEvent;
use Inwebo\QueueCommand\Event\ThrowExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HookSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            InEvent::class             => 'onIn',
            OutEvent::class            => 'onOut',
            ThrowExceptionEvent::class => 'onThrowException',
            FinallyEvent::class        => 'onFinally',
        ];
    }

    public function onIn(InEvent $event): void
    {

    }

    public function onOut(OutEvent $event): void
    {

    }

    public function onThrowException(ThrowExceptionEvent $event): void
    {
        print_r($event->getException()->getMessage());
    }

    public function onFinally(FinallyEvent $event): void
    {

    }
}