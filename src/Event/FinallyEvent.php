<?php

namespace Inwebo\QueueCommand\Event;

use Inwebo\QueueCommand\QueueCommand;
use Inwebo\QueueCommand\QueueIteratorCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FinallyEvent extends HookEvent
{
    public const NAME = 'command.hook.finally';

    protected SymfonyStyle $style;

    public function getStyle(): SymfonyStyle
    {
        return $this->style;
    }

    public function __construct(InputInterface $input, OutputInterface $output, QueueCommand $cmd, ?\Exception $e = null)
    {
        parent::__construct($input, $output, $cmd, $e);

        $this->style  = new SymfonyStyle($input, $output);
    }

}
