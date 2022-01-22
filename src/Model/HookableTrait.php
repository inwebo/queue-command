<?php

namespace Inwebo\QueueCommand\Model;

use \Closure;

trait HookableTrait
{
    protected ?Closure $before         = null;
    protected ?Closure $after          = null;
    protected ?Closure $finally        = null;
    protected ?Closure $throwException = null;

    /**
     * {@inheritdoc}
     */
    public function before(): ?Closure
    {
        return $this->before;
    }
    /**
     * {@inheritdoc}
     */
    public function after(): ?Closure
    {
        return $this->after;
    }
    /**
     * {@inheritdoc}
     */
    public function finally(): ?Closure
    {
        return  $this->finally;
    }
    /**
     * {@inheritdoc}
     */
    public function throwException(): ?Closure
    {
        return $this->throwException;
    }
    /**
     * {@inheritdoc}
     */
    public function onBefore(Closure $callback): void
    {
        $this->before = $callback;
    }
    /**
     * {@inheritdoc}
     */
    public function onAfter(Closure $callback): void
    {
        $this->after = $callback;
    }
    /**
     * {@inheritdoc}
     */
    public function onFinally(Closure $callback): void
    {
        $this->finally = $callback;
    }
    /**
     * {@inheritdoc}
     */
    public function onThrowException(Closure $callback): void
    {
        $this->throwException = $callback;
    }
}