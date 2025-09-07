<?php
namespace jeyroik\interfaces;

interface IHaveAttributes extends \ArrayAccess, \Iterator, \JsonSerializable
{
    public function __construct(array $attributes = []);

    public function getAttribute(string $name, $default = null): mixed;

    public function getAttributeInt(string $name, int $default = 0): int;
    public function getAttributeString(string $name, string $default = ''): string;

    /**
     * Use $unpackSelf=true to convert instance of IHaveAttributes to array by __toArray() method.
     */
    public function getAttributeArray(string $name, array $default = [], bool $unpackSelf = true): array;

    /**
     * @return array
     */
    public function __toArray(): array;
}
