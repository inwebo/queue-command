<?php

namespace Inwebo\QueueCommand\Event;

class AfterEvent extends HookEvent
{
    public const NAME = 'command.hook.after';
}