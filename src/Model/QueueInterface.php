<?php

namespace Inwebo\QueueCommand\Model;

use Inwebo\QueueCommand\QueueCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \Exception;

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
     * @param QueueCommand $cmd
     * @param ArrayInput $input
     * @param OutputInterface $output
     * @return void
     * @throws \Exception
     */
    public function runCommand(QueueCommand $cmd, ArrayInput $input, OutputInterface $output): void;
    /**
     * InputInterface courante de la file d'attente.
     * @return ?ArrayInput
     */
    public function getInput(): ?ArrayInput;

    public function setInput(ArrayInput $input): void;

    public function enqueue(string $defaultName): void;
}
