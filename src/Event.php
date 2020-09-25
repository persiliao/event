<?php
declare(strict_types=1);

namespace PersiLiao\Eventy;

use Closure;
use Illuminate\Support\Collection;

abstract class Event{

    /**
     * Holds the event listeners.
     *
     * @var Collection
     */
    protected $listeners;

    public function __construct()
    {
        $this->listeners = new Collection([]);
    }

    /**
     * Adds a listener.
     *
     * @param string $hook      Hook name
     * @param mixed  $callback  Function to execute
     * @param int    $priority  Priority of the action
     * @param int    $arguments Number of arguments to accept
     *
     * @return $this
     */
    public function listen(string $hook, callable $callback, int $priority = 10, int $arguments = 1): self
    {
        $this->listeners->push([
            'hook' => $hook,
            'callback' => $callback instanceof Closure ? new HashedCallable($callback) : $callback,
            'priority' => $priority,
            'arguments' => $arguments,
        ]);

        return $this;
    }

    /**
     * Removes a listener.
     *
     * @param string   $hook     Hook name
     * @param callable $callback Function to execute
     * @param int      $priority Priority of the action
     *
     * @return $this
     */
    public function remove(string $hook, callable $callback, int $priority = 10): self
    {
        if($this->listeners){
            $this->listeners->where('hook', $hook)->filter(function($listener) use ($callback){
                if($callback instanceof Closure){
                    return (new HashedCallable($callback))->is($listener['callback']);
                }

                return $callback === $listener['callback'];
            })->where('priority', $priority)->each(function(callable $listener, string $key){
                $this->listeners->forget($key);
            });
        }

        return $this;
    }

    /**
     * Remove all listeners with given hook in collection. If no hook, clear all listeners.
     *
     * @param string $hook Hook name
     *
     * @return void
     */
    public function removeAll(string $hook = ''): void
    {
        if($hook){
            if($this->listeners){
                $this->listeners->where('hook', $hook)->each(function($listener, $key){
                    $this->listeners->forget($key);
                });
            }
        }else{
            // no hook was specified, so clear entire collection
            $this->listeners = collect([]);
        }
    }

    /**
     * Gets a sorted list of all listeners.
     *
     * @return Collection
     */
    public function getListeners(): Collection
    {
        return $this->listeners->sortBy('priority');
    }

    /**
     * Fires a new action.
     *
     * @param string $action Name of action
     * @param array  $args   Arguments passed to the action
     */
    abstract public function fire(string $action, $args);

}