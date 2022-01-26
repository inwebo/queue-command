<?php

namespace Inwebo\QueueCommand\Model;

use Inwebo\QueueCommand\QueueCommand;

class Queue extends \SplQueue implements \RecursiveIterator
{
    /**
     * @param QueueCommand $value
     * @return void
     * @throws \Exception
     */
    public function enqueue(mixed $value): void
    {
        if ($value instanceof QueueCommand) {
            parent::enqueue($value);
        } else {
            throw new \Exception(sprintf('$value must be an instance of %s', QueueCommand::class));
        }
    }

    public function current(): QueueCommand
    {
        return parent::current();
    }

    public function hasChildren(): bool
    {
        return (false !== $this->current()->getQueue()->isEmpty());
    }

    public function getChildren(): ?\RecursiveIterator
    {
        return ($this->hasChildren()) ? $this->current()->getQueue() : null;
    }
}
