<?php

namespace Inwebo\QueueCommand\Event;

class ThrowExceptionEvent extends HookEvent
{
    public const NAME = 'command.hook.throw_exception';
}