<?php

namespace Inwebo\QueueCommand\Model;

use Inwebo\QueueCommand\QueueCommand;
use Symfony\Component\Console\Application;

trait QueueableTrait
{
    protected bool        $lockable = false;
    protected \SplQueue   $commandNames;
    protected Queue       $queue;
    protected ?ArrayInput $input    = null;

    /**
     * {@inheritdoc}
     */
    public function isLockable(): bool
    {
        return $this->lockable;
    }

    /**
     * {@inheritdoc}
     */
    public function setLockable(bool $lockable): void
    {
        $this->lockable = $lockable;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueueCommandNames():\SplQueue
    {
        return $this->commandNames;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueue(): Queue
    {
        return $this->queue;
    }

    /**
     * {@inheritdoc}
     */
    public function getInput(): ?ArrayInput
    {
        return $this->input;
    }

    /**
     * {@inheritdoc}
     */
    public function setInput(ArrayInput $input): void
    {
        $this->input = $input;
    }

    /**
     * {@inheritdoc}
     */
    public function enqueue(string $defaultName): void
    {
        $this->getQueueCommandNames()->enqueue($defaultName);
    }

    /**
     * Will transform a string QueueCommand::$defaultName; in a valid QueueCommand instance.
     *
     * Gets the application instance for this command.
     *
     * @param Application       $app
     * @param \SplQueue<string> $queueCommandNames
     * @param QueueCommand|null $queueCommand
     * @return void
     * @throws \Exception
     */
    protected function commandFactory(Application $app, \SplQueue $queueCommandNames, ?QueueCommand $queueCommand = null): void
    {
        while ($queueCommandNames->valid())
        {
            /** @var QueueCommand $cmd */
            $cmd = $app->find($queueCommandNames->current());

            $this->getQueue()->enqueue($cmd);

            if (false === $cmd->getQueueCommandNames()->isEmpty()) {
                $this->commandFactory($app, $cmd->getQueueCommandNames(), $cmd);
            }

            $queueCommandNames->next();
        }
    }
}
