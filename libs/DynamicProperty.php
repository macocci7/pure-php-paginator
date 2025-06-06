<?php

namespace Libs;

class DynamicProperty
{
    /**
     * @var array<string, mixed>    $data = []
    */
    private array $data = [];

    /**
     * @param   array<string, mixed>    $data = []
     */
    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    public function __set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function __get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    public function __isset(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * @param   array<string, mixed>    $data = []
     */
    private function setData(array $data = []): void
    {
        foreach ($data as $key => $value) {
            if (is_string($key)) {
                $this->data[$key] = $value;
            }
        }
    }
}
