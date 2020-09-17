<?php
declare(strict_types=1);

namespace PersiLiao\Eventy;

/**
 * @return Events
 */
function getInstance(): Events
{
    static $instance;
    if($instance === null){
        $instance = new Events();
    }

    return $instance;
}

/**
 * @param string   $hook
 * @param callable $callback
 * @param int      $priority
 * @param int      $arguments
 *
 * @return void
 * @see Events::addAction()
 */
function addAction(string $hook, callable $callback, int $priority = 10, int $arguments = 1): void
{
    getInstance()->addAction($hook, $callback, $priority, $arguments);
}

/**
 * @param string   $hook
 * @param callable $callback
 * @param int      $priority
 *
 * @return void
 * @see Events::removeAction()
 */
function removeAction(string $hook, callable $callback, int $priority = 10)
{
    getInstance()->removeAction($hook, $callback, $priority);
}

/**
 * @return Action
 * @see Events::getAction()
 */
function getAction(): Action
{
    return getInstance()->getAction();
}

/**
 * @param string $hook
 * @param mixed  ...$args
 *
 * @return void
 * @see Events::doAction()
 */
function doAction(string $hook, ...$arguments): void
{
    getInstance()->doAction($hook, ...$arguments);
}

/**
 * @param string   $hook
 * @param callable $callback
 * @param int      $priority
 * @param int      $arguments
 *
 * @return void
 * @see Events::addFilter()
 */
function addFilter(string $hook, callable $callback, int $priority = 10, int $arguments = 1): void
{
    getInstance()->addFilter($hook, $callback, $priority, $arguments);
}

/**
 * @param string   $hook
 * @param callable $callback
 * @param int      $priority
 *
 * @return void
 * @see Events::removeFilter()
 */
function removeFilter(string $hook, callable $callback, int $priority = 10)
{
    getInstance()->removeFilter($hook, $callback, $priority);
}

/**
 * @return Filter
 * @see Events::getAction()
 */
function getFilter(): Filter
{
    return getInstance()->getFilter();
}

/**
 * @param string $hook
 * @param mixed  ...$args
 *
 * @return void
 * @see Events::applyFilters()
 */
function applyFilters(string $hook, ...$arguments)
{
    return getInstance()->applyFilters($hook, ...$arguments);
}

