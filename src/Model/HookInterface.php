<?php

namespace Inwebo\QueueCommand\Model;

use \Closure;

interface HookInterface
{
    /**
     * Devrait être executée dans Symfony\Component\Console\Command\Command::configure()
     * @return void
     */
    public function configureHooks(): void;
    /**
     * Setter
     * @param Closure $callback
     * @return void
     */
    public function onBefore(Closure $callback): void;
    /**
     * Getter
     * @return Closure|null
     */
    public function before(): ?Closure;
    /**
     * Setter
     * @param Closure $callback
     * @return void
     */
    public function onAfter(Closure $callback): void;
    /**
     * Getter
     * @return Closure|null
     */
    public function after(): ?Closure;
    /**
     * Setter
     * @param Closure $callback
     * @return void
     */
    public function onFinally(Closure $callback): void;
    /**
     * Getter
     * @return Closure|null Si n'est pas null la fonction de rappel est invoquée systématiquement après l'execution
     * de la commande courante et aprés le hook out().
     */
    public function finally(): ?Closure;
    /**
     * Setter
     * @param Closure $callback
     * @return void
     */
    public function onThrowException(Closure $callback): void;
    /**
     * Getter
     * @return Closure|null Si n'est pas null la fonction de rappel est invoquée lors d'une exception.
     */
    public function throwException(): ?Closure;
}