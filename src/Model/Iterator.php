<?php

namespace Inwebo\QueueCommand\Model;

use Inwebo\QueueCommand\QueueCommand;

/**
 * Syntax sugar, it's a typed \RecursiveIteratorIterator class.
 */
class Iterator extends \RecursiveIteratorIterator
{
    /**
     * {@inheritDoc}
     *
     * Force Inwebo\QueueCommand\QueueCommand return type.
     *
     * @return QueueCommand
     */
    public function current(): QueueCommand
    {
        return parent::current();
    }
}