<?php

namespace Inwebo\QueueCommand\Model;

interface QueueIteratorInterface
{
    public function configureIterator(): void;

    /**
     * Syntactic Sugar
     *
     * Current Inwebo\QueueCommand\Iterator and it's a typed \RecursiveIteratorIterator
     *
     * @return Iterator
     */
    public function getIterator(): Iterator;
}