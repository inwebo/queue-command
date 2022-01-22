<?php

namespace Inwebo\QueueCommand\Model;

interface QueueIteratorInterface
{
    public function getIterator(): Iterator;
}