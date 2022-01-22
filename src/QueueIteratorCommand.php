<?php

namespace Inwebo\QueueCommand;

use Inwebo\QueueCommand\Model\ArrayInput;
use Inwebo\QueueCommand\Model\EventDispatcherInterface;
use Inwebo\QueueCommand\Model\HookInterface;
use Inwebo\QueueCommand\Model\Iterator;
use Inwebo\QueueCommand\Model\Queue;
use Inwebo\QueueCommand\Model\QueueInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class QueueIteratorCommand extends QueueCommand implements HookInterface, QueueInterface, EventDispatcherInterface
{
    use LockableTrait;

    protected static   $defaultName = 'base:queue';
    protected Iterator $queueRecursiveIterator;

    protected function setIterator(Queue $input, int $flags = \RecursiveIteratorIterator::SELF_FIRST): void
    {
        $this->queueRecursiveIterator = new Iterator($input, $flags);
    }

    public function getIterator(): Iterator
    {
        return $this->queueRecursiveIterator;
    }

    protected function configureQueueIterator(InputInterface $input, OutputInterface $output): void
    {
        if (false === $this->lock() && $this->isLockable()) {
            throw new \Exception();
        }

        $this->queueCommandFactory($this->getApplication(), $this->getQueueCommandNames());

        $this->setInput(ArrayInput::create($input));

        $this->setIterator($this->getQueue());
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->configureQueueIterator($input, $output);

        $this->getIterator()->rewind();

        while ($this->getIterator()->valid()) {
            try {
                $this->before()?->__invoke($this->getInput(), $output, $this->getIterator()->current());
                $this->runCommand($this->getIterator()->current(), $this->getInput(), $output);

                if (false === $this->getIterator()->current()->getInput()->isBubbling()) {
                    $this->getInput()->stopBubbling();
                }
                if (false === $this->getIterator()->current()->getInput()->isBubblingArguments()) {
                    $this->getInput()->stopBubblingArguments();
                }
                if (false === $this->getIterator()->current()->getInput()->isBubblingOptions()) {
                    $this->getInput()->stopBubblingOptions();
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