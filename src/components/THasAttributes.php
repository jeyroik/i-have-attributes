<?php
namespace jeyroik\components;

use jeyroik\interfaces\IHaveAttributes;

/**
 * Implements IHaveAttributes interface
 */
trait THasAttributes
{
    /**
     * @var int
     */
    protected int $currentKey = 0;

    /**
     * @var array
     */
    protected array $keyMap = [];

    protected array $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function getAttribute(string $name, $default = null): mixed
    {
        return $this->attributes[$name] ?? $default;
    }

    public function getAttributeInt(string $name, int $default = 0): int
    {
        $a = $this->getAttribute($name, $default);

        return is_array($a) || is_object($a) ? $default : (int) $a;
    }

    public function getAttributeString(string $name, string $default = ''): string
    {
        $a = $this->getAttribute($name, $default);

        return is_array($a) || is_object($a) ? $default : (string) $a;
    }

    public function getAttributeArray(string $name, array $default = [], bool $unpackSelf = true): array
    {
        $a = $this->getAttribute($name, $default);

        if (is_object($a)) {
            return $a instanceof IHaveAttributes 
                        ? ($unpackSelf ? $a->__toArray() : [$a]) 
                        : [$a];
        }

        return is_array($a) ? (array) $a : [$a];
    }

    public function __toArray(): array
    {
        return $this->attributes ?? [];
    }

    public function jsonSerialize(): mixed
    {
        return $this->attributes;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->config[$name]);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function __merge(array $data): static
    {
        foreach ($data as $key => $value) {
            $this->attributes[$key] = $value;
        }

        return $this;
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->attributes[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed|null
     */
    public function offsetGet($offset): mixed
    {
        return $this->attributes[$offset] ?? null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->keyMap[$this->currentKey]);
    }

    /**
     * @return string|null
     */
    public function key(): mixed
    {
        return $this->keyMap[$this->currentKey] ?? null;
    }

    /**
     * @return void
     */
    public function next(): void
    {
        $this->currentKey++;
    }

    /**
     * @return mixed
     */
    public function current(): mixed
    {
        return $this->attributes[$this->keyMap[$this->currentKey]];
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        $this->currentKey = 0;
    }
}
