# 1.0.0

- Added return types definitions.
- Added method `getAttributeInt(string $name, int $default = 0): int`.
- Added method `getAttributeString(string $name, string $default = ''): string`.
- Added method `getAttributeArray(string $name, array $default = [], bool $unpackSelf = true): array` (see interface for details).
- Switched to PHP 8.4 on build.