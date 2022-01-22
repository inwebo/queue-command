<?php

namespace Inwebo\QueueCommand\Model;

use Inwebo\QueueCommand\QueueCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \Exception;
use Inwebo\QueueCommand\Model\ArrayInput;

interface QueueInterface extends HookInterface
{
    /**
     * @return bool Si vrai gestion de la cooncurrence activée pour la commande.
     */
    public function isLockable(): bool;
    /**
     * @param bool $lockable Si true active la gestion de la concurrence.
     * @return void
     */
    public function setLockable(bool $lockable): void;
    /**
     * Les chaines de caractères doivent correspondre à des QueueCommand::defaultName.
     *
     * @return \SplQueue<string>
     * @see
     */
    public function getQueueCommandNames():\SplQueue;
    /**
     * Une file d'attente de QueueCommand.
     * @return Queue<QueueCommand>
     */
    public function getQueue(): Queue;
    /**
     * Devrait être executée dans Symfony\Component\Console\Command\Command::configure().
     *
     * @return void
     */
    public function configureQueue(): void;
    /**
     * @param Command         $cmd
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return void
     * @throws Exception When binding input fails. Bypass this by calling {@link ignoreValidationErrors()}.
     */
    public function runCommand(Command $cmd, InputInterface $input, OutputInterface $output): void;
    /**
     * InputInterface courante de la file d'attente.
     * @return InputInterface
     */
    public function getInput(): ?ArrayInput;
}
