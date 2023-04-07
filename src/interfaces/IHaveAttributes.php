<?php
namespace jeyroik\interfaces;

interface IHaveAttributes extends \ArrayAccess, \Iterator, \JsonSerializable
{
    public function __construct(array $attributes = []);

    public function getAttribute(string $name, $default = null): mixed;

    /**
     * @return array
     */
    public function __toArray(): array;
}
