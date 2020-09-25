<?php
declare(strict_types=1);

namespace PersiLiao\Eventy;

use InvalidArgumentException;

use function is_callable;

class Events{

    /**
     * Holds all registered actions.
     *
     * @var Action
     */
    protected $action;

    /**
     * Holds all registered filters.
     *
     * @var Filter
     */
    protected $filter;

    /**
     * Construct the class.
     */
    public function __construct()
    {
        $this->action = new Action();
        $this->filter = new Filter();
    }

    /**
     * Get the action instance.
     *
     * @return Action
     */
    public function getAction(): Action
    {
        return $this->action;
    }

    /**
     * Get the action instance.
     *
     * @return Filter
     */
    public function getFilter(): Filter
    {
        return $this->filter;
    }

    /**
     * Add an action.
     *
     * @param string   $hook      Hook name
     * @param callable $callback  Function to execute
     * @param int      $priority  Priority of the action
     * @param int      $arguments Number of arguments to accept
     *
     * @return void
     */
    public function addAction(string $hook, callable $callback, int $priority = 10, int $arguments = 1): void
    {
        $this->action->listen($hook, $callback, $priority, $arguments);
    }

    /**
     * Remove an action.
     *
     * @param string   $hook     Hook name
     * @param callable $callback Function to execute
     * @param int      $priority Priority of the action
     *
     * @return void
     */
    public function removeAction(string $hook, callable $callback, int $priority = 10): void
    {
        $this->action->remove($hook, $callback, $priority);
    }

    /**
     * Remove all actions.
     *
     * @param string $hook Hook name
     *
     * @return void
     */
    public function removeAllActions(string $hook = ''): void
    {
        $this->action->removeAll($hook);
    }

    /**
     * Adds a filter.
     *
     * @param string   $hook      Hook name
     * @param callable $callback  Function to execute
     * @param int      $priority  Priority of the action
     * @param int      $arguments Number of arguments to accept
     */
    public function addFilter(string $hook, callable $callback, int $priority = 10, int $arguments = 1)
    {
        if(is_callable($callback) === false){
            throw new InvalidArgumentException('$callback must be a callable');
        }
        $this->filter->listen($hook, $callback, $priority, $arguments);
    }

    /**
     * Remove a filter.
     *
     * @param string   $hook     Hook name
     * @param callable $callback Function to execute
     * @param int      $priority Priority of the action
     *
     * @return void
     */
    public function removeFilter(string $hook, callable $callback, int $priority = 10): void
    {
        $this->filter->remove($hook, $callback, $priority);
    }

    /**
     * Remove all filters.
     *
     * @param string $hook Hook name
     *
     * @return void
     */
    public function removeAllFilters(string $hook = ''): void
    {
        $this->filter->removeAll($hook);
    }

    /**
     * Set a new action.
     * Actions never return anything. It is merely a way of executing code at a specific time in your code.
     * You can add as many parameters as you'd like.
     *
     * @param string $hook         Name of hook
     * @param mixed  ...$arguments Arguments
     *
     * @return void
     */
    public function doAction(string $hook, ...$arguments): void
    {
        $this->action->fire($hook, $arguments);
    }

    /**
     * Set a new filter.
     * Filters should always return something. The first parameter will always be the default value.
     * You can add as many parameters as you'd like.
     *
     * @param string $hook      Name of hook
     * @param mixed  $arguments Arguments
     *
     * @return mixed
     */
    public function applyFilters(string $hook, ...$arguments)
    {
        return $this->filter->fire($hook, $arguments);
    }

}
