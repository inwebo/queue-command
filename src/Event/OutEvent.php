<?php

namespace Inwebo\QueueCommand\Event;

class OutEvent extends HookEvent
{
    public const NAME = 'command.hook.out';
}