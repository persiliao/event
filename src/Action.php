<?php
declare(strict_types=1);

namespace PersiLiao\Eventy;

class Action extends Filter{

    /**
     * Filters a value.
     *
     * @param string $action Name of action
     * @param array  $args   Arguments passed to the filter
     *
     * @return void Always returns the value
     */
    public function fire(string $action, $args): void
    {
        parent::fire($action, $args);
    }

}
