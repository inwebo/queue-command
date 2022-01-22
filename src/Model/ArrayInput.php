<?php

namespace Inwebo\QueueCommand\Model;

use Symfony\Component\Console\Input\ArrayInput as BaseArrayInput;
use Symfony\Component\Console\Input\InputInterface;

class ArrayInput extends BaseArrayInput
{
    protected bool $bubblingArguments = true;
    protected bool $bubblingOptions   = true;
    protected bool $bubbling          = true;

    public function isBubbling(): bool
    {
        return $this->bubbling;
    }

    public function setBubbling(bool $bubbling): void
    {
        $this->bubbling = $bubbling;
    }

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

    static public function create(InputInterface $input): self
    {
        return new self($input->getArguments());
    }
}
