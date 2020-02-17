<?php

class Optional
{
    protected $value;

    public function __construct($value=null)
    {
        $this->value = (object) $value;
    }

    public function __get($key)
    {
        if (is_object($this->value)) {
            return $this->value->{$key} ?? null;
        }
    }

    public function __isset($name)
    {
        if (is_object($this->value)) {
            return isset($this->value->{$name});
        }

        return false;
    }

    public function __call($method, $parameters)
    {

        if (is_object($this->value)) {
            return $this->value->{$method}(...$parameters);
        }
    }
}
