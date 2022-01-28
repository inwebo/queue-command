<?php

namespace Inwebo\QueueCommand\Model;

use Symfony\Component\Console\Input\ArrayInput as BaseArrayInput;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Is a Symfony\Component\Console\Input\InputInterface extended with bubbling options.
 *
 * It will be the default Symfony\Component\Console\Input\InputInterface for a QueueCommand.
 */
class ArrayInput extends BaseArrayInput
{
    /**
     * @var bool If true, the current queue-command's arguments will be available for the next command.
     */
    protected bool $bubblingArguments = true;
    /**
     * @var bool If true, the current queue-command's options will be available for the next command.
     */
    protected bool $bubblingOptions   = true;
    /**
     * @var bool If true, both current queue-command's arguments AND options will be available for the next command.
     *           If false, arguments & options will be reset.
     */
    protected bool $bubbling          = true;

    /**
     * Constructor
     *
     * @param InputInterface $input
     * @return ArrayInput
     */
    static public function create(InputInterface $input): self
    {
        return new self($input->getArguments());
    }

    /**
     * Getter
     * @see bubbling
     * @return bool
     */
    public function isBubbling(): bool
    {
        return $this->bubbling;
    }

    /**
     * Setter
     * @param bool $bubbling
     * @see bubbling
     * @return void
     */
    public function setBubbling(bool $bubbling): void
    {
        $this->bubbling = $bubbling;
    }

    /**
     * @return bool
     */
    public function isBubblingArguments(): bool
    {
        return $this->bubblingArguments;
    }

    public function setBubblingArguments(bool $bubblingArguments): void
    {
        $this->bubblingArguments = $bubblingArguments;
    }

    public function stopBubblingArguments(): void
    {
        $this->setBubblingArguments(false);
        $this->resetArguments();
    }

    public function isBubblingOptions(): bool
    {
        return $this->bubblingOptions;
    }

    public function setBubblingOptions(bool $bubblingOptions): void
    {
        $this->bubblingOptions = $bubblingOptions;
    }

    public function stopBubblingOptions(): void
    {
        $this->setBubblingOptions(false);
        $this->resetOptions();
    }

    public function stopBubbling(): void
    {
        $this->stopBubblingArguments();
        $this->stopBubblingOptions();
    }

    public function resetOptions(): void
    {
        $this->options = [];
    }

    public function resetArguments(): void
    {
        $this->arguments = [];
    }

    public function mergeArguments(ArrayInput $arguments): void
    {
        $this->arguments = array_merge($this->arguments, $arguments->getArguments());
    }
}
