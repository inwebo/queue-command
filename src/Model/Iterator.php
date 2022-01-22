<?php

namespace Inwebo\QueueCommand\Model;

use Inwebo\QueueCommand\QueueCommand;

class Iterator extends \RecursiveIteratorIterator
{
    public function current(): QueueCommand
    {
        return parent::current();
    }
}