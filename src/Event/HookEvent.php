<?php

namespace Inwebo\QueueCommand\Event;

use Inwebo\QueueCommand\QueueCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\EventDispatcher\Event;

abstract class HookEvent extends Event
{
    public const NAME = 'command.hook';

    protected QueueCommand    $cmd;
    protected InputInterface  $input;
    protected OutputInterface $output;
    protected ?\Exception     $exception = null;

    public function getCmd(): QueueCommand
    {
        return $this->cmd;
    }

    public function getInput(): InputInterface
    {
        return $this->input;
    }

    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

    public function getException(): ?\Exception
    {
        return $this->exception;
    }

    public function __construct(InputInterface $input, OutputInterface $output, QueueCommand $cmd, ?\Exception $e = null)
    {
        $this->cmd       = $cmd;
        $this->input     = $input;
        $this->output    = $output;
        $this->exception = $e;
    }
}
