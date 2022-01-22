<?php

namespace Inwebo\QueueCommand\Model;

use Inwebo\QueueCommand\QueueCommand;
use Inwebo\QueueCommand\QueueIteratorCommand;
use Symfony\Component\Console\Application;

trait QueueableTrait
{
    protected bool       $lockable = false;
    protected \SplQueue  $commandNames;
    protected Queue      $queue;
    protected ?ArrayInput $input   = null;

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
     * @param Application       $app
     * @param \SplQueue<string> $queueCommandNames
     * @param QueueCommand|null $queueCommand
     * @return void
     * @throws \Exception
     */
    protected function queueCommandFactory(Application $app, \SplQueue $queueCommandNames, ?QueueCommand $queueCommand = null): void
    {
        while ($queueCommandNames->valid())
        {
            $current = $queueCommandNames->current();
            /** @var QueueCommand $cmd */
            $cmd = $app->find($queueCommandNames->current());

            $this->getQueue()->enqueue($cmd);

            if (!$cmd->getQueueCommandNames()->isEmpty()) {
                $this->queueCommandFactory($app, $cmd->getQueueCommandNames(), $cmd);
            }

            $queueCommandNames->next();
        }
    }

    public function setInput(ArrayInput $input): void
    {
        $this->input = $input;
    }

    public function enqueue(string $defaultName): void
    {
        $this->getQueueCommandNames()->enqueue($defaultName);
    }

    public function getInput(): ?ArrayInput
    {
        return $this->input;
    }
}