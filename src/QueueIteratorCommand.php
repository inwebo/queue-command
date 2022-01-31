<?php

namespace Inwebo\QueueCommand;

use Inwebo\QueueCommand\Model\ArrayInput;
use Inwebo\QueueCommand\Model\HookInterface;
use Inwebo\QueueCommand\Model\Iterator;
use Inwebo\QueueCommand\Model\Queue;
use Inwebo\QueueCommand\Model\QueueEventDispatcherInterface;
use Inwebo\QueueCommand\Model\QueueInterface;
use Inwebo\QueueCommand\Model\QueueIteratorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class QueueIteratorCommand extends QueueCommand implements
    QueueIteratorInterface,             // Mandatory Interface, $this is a concrete QueueIteratorInterface implementation
    HookInterface,                      // Helper implements, already used in abstract Inwebo\QueueCommand\QueueCommand
    QueueInterface,                     // Helper implements, already used in abstract Inwebo\QueueCommand\QueueCommand
    QueueEventDispatcherInterface       // Helper implements, already used in abstract Inwebo\QueueCommand\QueueCommand
{
    use LockableTrait;

    protected static   $defaultName = 'base:queue';
    protected Iterator $queueRecursiveIterator;

    protected function setIterator(Queue $iterator, int $flags = \RecursiveIteratorIterator::SELF_FIRST): void
    {
        $this->queueRecursiveIterator = new Iterator($iterator, $flags);
    }

    public function getIterator(): Iterator
    {
        return $this->queueRecursiveIterator;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws \Exception
     */
    protected function configureQueueIterator(InputInterface $input, OutputInterface $output): void
    {
        $this->commandFactory($this->getApplication(), $this->getQueueCommandNames());

        $this->setIterator($this->getQueue());
    }

    /**
     * {@inheritdoc}
     *
     *
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (false === $this->lock() && $this->isLockable()) {
            throw new \Exception();
        }
        $this->setInput(ArrayInput::create($input));
        $this->configureQueueIterator($input, $output);

        $this->getIterator()->rewind();

        while ($this->getIterator()->valid()) {
            try {
                $this->before()?->__invoke($this->getInput(), $output, $this->getIterator()->current());

                $this->runCommand($this->getIterator()->current(), $this->getInput(), $output);

                if (false === is_null($this->getIterator()->current()->getInput())) {
                    if (false === $this->getIterator()->current()->getInput()->isBubbling()) {
                        $this->getInput()->stopBubbling();
                    }
                    if (false === $this->getIterator()->current()->getInput()->isBubblingArguments()) {
                        $this->getInput()->stopBubblingArguments();
                    }
                    if (false === $this->getIterator()->current()->getInput()->isBubblingOptions()) {
                        $this->getInput()->stopBubblingOptions();
                    }
                }

                $this->getInput()->mergeArguments($this->getIterator()->current()->getInput());
                $this->after()?->__invoke($this->getInput(), $output, $this->getIterator()->current());
            } catch (\Exception $e) {
                $this->throwException()?->__invoke($this->getInput(), $output, $this->getIterator()->current(), $e);
                return Command::FAILURE;
            } finally {
                $this->finally()?->__invoke($this->getInput(), $output, $this->getIterator()->current());
            }

            $this->getIterator()->next();
        }

        return Command::SUCCESS;
    }
}
