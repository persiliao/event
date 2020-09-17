<?php
declare(strict_types=1);

namespace PersiLiao\Eventy;

use function array_slice;
use function call_user_func;
use function call_user_func_array;
use function func_num_args;

class Filter extends Event{

    /**
     * @var mixed
     */
    protected $value;

    /**
     * Filters a value.
     *
     * @param string $action Name of filter
     * @param array  $args   Arguments passed to the filter
     *
     * @return mixed Always returns the value
     */
    public function fire(string $action, $args)
    {
        $this->value = $args[0] ?? null;
        $argsNums = func_num_args() - 1;
        if($this->getListeners()){
            $this->getListeners()->where('hook', $action)->each(function($listener) use ($args, $argsNums){
                if(0 == $listener['arguments']){
                    $this->value = call_user_func($listener['arguments']);
                }elseif($listener['arguments'] >= $argsNums){
                    $this->value = call_user_func_array($listener['callback'], $args);
                }else{
                    $this->value = call_user_func_array($listener['callback'], array_slice($args, 0, (int)$listener['arguments']));
                }
            });
        }

        return $this->value;
    }

}
