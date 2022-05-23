# i-have-attributes

Simple attributes implementation.

![tests](https://github.com/jeyroik/i-have-attributes/workflows/PHP%20Composer/badge.svg?branch=master&event=push)
![codecov.io](https://codecov.io/gh/jeyroik/i-have-attributes/coverage.svg?branch=master)
<a href="https://github.com/phpstan/phpstan"><img src="https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat" alt="PHPStan Enabled"></a> 
<a href="https://codeclimate.com/github/jeyroik/i-have-attributes/maintainability"><img src="https://api.codeclimate.com/v1/badges/3f008f970f7d952c1532/maintainability" /></a>
[![Latest Stable Version](https://poser.pugx.org/jeyroik/i-have-attributes/v)](//packagist.org/packages/jeyroik/i-have-attributes)
[![Total Downloads](https://poser.pugx.org/jeyroik/i-have-attributes/downloads)](//packagist.org/packages/jeyroik/i-have-attributes)
[![Dependents](https://poser.pugx.org/jeyroik/i-have-attributes/dependents)](//packagist.org/packages/jeyroik/i-have-attributes)


# Usage

See tests

`$ composer test`

```php
$something = new class ([
    'p1' => 'v1',
    'p2' => 'v2'
]) implements IHaveAttributes {
    use THasAttributes;
};

$this->assertEquals('v1', $something->getAttribute('p1'));
$this->assertEquals('v1', $something['p1']);

foreach($something as $name => $value) {
    if ($name == 'p2') {
        $this->assertEquals('v2', $value);
    }
}

$this->assertTrue(isset($something['p1']));
unset($something['p1']);
$this->assertFalse(isset($something['p1']));;

$something->__merge(['p2' => 'v2.1', 'p3' => 'v3']);

$this->assertEquals(
    ['p2' => 'v2.1', 'p3' => 'v3'],
    $something->__toArray()
);
```