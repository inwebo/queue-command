<?php

namespace Inwebo\QueueCommand\Event;

class BeforeEvent extends HookEvent
{
    public const NAME = 'command.hook.before';
}