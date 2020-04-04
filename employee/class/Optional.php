<?php

class Optional
{
    protected $value;

    public function __construct($value = [])
    {
        $this->value = $value;
    }

    public function __get($key)
    {
        return isset($this->value[$key]) ? $this->value[$key] : null;
    }

    public function __isset($name)
    {
        return isset($this->value[$name]);

        return false;
    }

    public function __call($method, $parameters)
    {
        if (isset($this->value[$method])) {
            return $this->value[$method](...$parameters);
        }
    }
}
