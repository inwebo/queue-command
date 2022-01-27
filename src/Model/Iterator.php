<?php

namespace Inwebo\QueueCommand\Model;

use Inwebo\QueueCommand\QueueCommand;

/**
 * Syntax sugar, it's an \RecursiveIteratorIterator class.
 */
class Iterator extends \RecursiveIteratorIterator
{
    /**
     * Force return type.
     *
     * @return QueueCommand
     */
    public function current(): QueueCommand
    {
        return parent::current();
    }
}