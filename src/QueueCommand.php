<?php

namespace Inwebo\QueueCommand;

use Inwebo\QueueCommand\Event\BeforeEvent;
use Inwebo\QueueCommand\Event\AfterEvent;
use Inwebo\QueueCommand\Event\FinallyEvent;
use Inwebo\QueueCommand\Event\ThrowExceptionEvent;
use Inwebo\QueueCommand\EventSubscriber\HookSubscriber;
use Inwebo\QueueCommand\Model\EventDispatcherTrait;
use Inwebo\QueueCommand\Model\HookableTrait;
use Inwebo\QueueCommand\Model\HookInterface;
use Inwebo\QueueCommand\Model\Queue;
use Inwebo\QueueCommand\Model\QueueableTrait;
use Inwebo\QueueCommand\Model\QueueEventDispatcherInterface;
use Inwebo\QueueCommand\Model\QueueInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

abstract class QueueCommand extends Command implements HookInterface, QueueInterface, QueueEventDispatcherInterface
{
    use QueueableTrait;
    use HookableTrait;
    use EventDispatcherTrait;
    use LockableTrait;

    protected static $defaultName = 'queue';

    protected bool $clearScreen   = false;

    protected function hasToClearScreen(): bool
    {
        return $this->clearScreen;
    }

    protected function clearScreen(OutputInterface $output): void
    {
        $output->write("\033\143");
    }

    /**
     * Les classes enfants doivent implementer parent::__construct();
     */
    public function __construct(string $name = null)
    {
        $this->commandNames    = new \SplQueue();
        $this->queue           = new Queue();
        $this->eventDispatcher = new EventDispatcher();

        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();
        $this->configureQueue();
        $this->configureHooks();
        $this->configureEventSubscriber();
    }

    /**
     * {@inheritdoc}
     */
    public function runCommand(QueueCommand $cmd, InputInterface $input, OutputInterface $output): void
    {
        if (false === $this->lock() && $this->isLockable()) {
            throw new \Exception();
        }

        $cmd->setInput($input);
        $cmd->run($input, $output);
    }

    /**
     * {@inheritdoc}
     */
    public function configureQueue(): void
    {
        // ...
        // FIFO
        // ...
        // $this->getQueue()->enqueue($this->getApplication()->find(QueueCommand::getDefaultName()));
        $this->getQueueCommandNames()->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function configureHooks(): void
    {
        $this->onBefore(function (InputInterface $input, OutputInterface $output, QueueCommand $cmd) {
            $this->getEventDispatcher()->dispatch(new BeforeEvent($input, $output, $cmd));
        });

        $this->onAfter(function (InputInterface $input, OutputInterface $output, QueueCommand $cmd) {
            $this->getEventDispatcher()->dispatch(new AfterEvent($input, $output, $cmd));
        });

        $this->onThrowException(function (InputInterface $input, OutputInterface $output, QueueCommand $cmd, \Exception $e) {
            $this->getEventDispatcher()->dispatch(new ThrowExceptionEvent($input, $output, $cmd, $e));
        });

        $this->onFinally(function (InputInterface $input, OutputInterface $output, QueueCommand $cmd) {
            $this->getEventDispatcher()->dispatch(new FinallyEvent($input, $output, $cmd));
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureEventSubscriber(): void
    {
        $this->getEventDispatcher()->addSubscriber(new HookSubscriber());
    }
}
