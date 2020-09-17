<?php
declare(strict_types=1);

namespace PersiLiao\Eventy;

use Closure;
use Opis\Closure\SerializableClosure;

use function base64_encode;

class HashedCallable{

    /**
     * @var Closure
     */
    protected $callback;

    /**
     * @var string
     */
    protected $signature;

    public function __construct(Closure $callback)
    {
        $this->callback = $callback;
        $this->signature = $this->generateSignature();
    }

    /**
     * @return string
     */
    protected function generateSignature(): string
    {
        return base64_encode(serialize(new SerializableClosure($this->callback)));
    }

    /**
     * @return mixed
     */
    public function __invoke()
    {
        return call_user_func_array($this->getCallback(), func_get_args());
    }

    /**
     * @return Closure
     */
    public function getCallback(): Closure
    {
        return $this->callback;
    }

    /**
     * @param HashedCallable $callable
     *
     * @return bool
     */
    public function is(self $callable): bool
    {
        return $callable->getSignature() === $this->getSignature();
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

}
