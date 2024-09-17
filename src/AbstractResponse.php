<?php

namespace MoonlyDays\LaravelSourceQuery;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

abstract class AbstractResponse implements Arrayable, ArrayAccess, Jsonable, JsonSerializable
{
    public function __construct(
        public array $response
    ) {}

    public function __get(string $name)
    {
        return $this->offsetGet($name);
    }

    public function __set(string $name, $value): void
    {
        $this->offsetSet($name, $value);
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->response);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->response[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->response[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->response[$offset]);
    }

    public function toArray(): array
    {
        return $this->response;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toJson($options = 0): bool|string
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
