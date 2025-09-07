<?php

use jeyroik\components\THasAttributes;
use jeyroik\interfaces\IHaveAttributes;
use PHPUnit\Framework\TestCase;

class TraitTest extends TestCase
{
    public function testBasic()
    {
        $something = new class ([
            'p1' => 'v1',
            'p2' => 'v2'
        ]) implements IHaveAttributes {
            use THasAttributes;
        };

        $this->assertEquals('v1', $something->getAttribute('p1'));
        $this->assertEquals('v1', $something['p1']);

        $this->assertEquals('{"p1":"v1","p2":"v2"}', json_encode($something));
        
        $encoded = json_encode($something);
        $decoded = json_decode($encoded, true);

        $this->assertEquals('v1', $decoded['p1']);
        $this->assertEquals('v2', $decoded['p2']);

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

        $withoutAttrs = new class () implements IHaveAttributes {
            use THasAttributes;
        };

        $this->assertFalse(isset($withoutAttrs['anything']));
    }

    public function testTypes()
    {
        $p4 = new class ([
            'p' => 'some'
        ]) implements IHaveAttributes {
            use THasAttributes;
        };

        $p5 = new class ('some') {
            protected string $some = '';

            public function __construct($some)
            {
                $this->some = $some;
            }
        };

        $something = new class ([
            'p1' => 'string',
            'p2' => 1,
            'p3' => ['array'],
            'p4' => $p4,
            'p5' => $p5
        ]) implements IHaveAttributes {
            use THasAttributes;
        };

        $this->assertEquals('string', $something->getAttribute('p1'));
        $this->assertEquals('string', $something->getAttributeString('p1'));
        $this->assertEquals(0, $something->getAttributeInt('p1'));
        $this->assertEquals(['string'], $something->getAttributeArray('p1'));

        $this->assertEquals(1, $something->getAttribute('p2'));
        $this->assertEquals('1', $something->getAttributeString('p2'));
        $this->assertEquals(1, $something->getAttributeInt('p2'));
        $this->assertEquals([1], $something->getAttributeArray('p2'));

        $this->assertEquals(['array'], $something->getAttribute('p3'));
        $this->assertEquals('', $something->getAttributeString('p3'));
        $this->assertEquals(0, $something->getAttributeInt('p3'));
        $this->assertEquals(['array'], $something->getAttributeArray('p3'));

        $this->assertEquals($p4, $something->getAttribute('p4'));
        $this->assertEquals('', $something->getAttributeString('p4'));
        $this->assertEquals(0, $something->getAttributeInt('p4'));
        $this->assertEquals(['p' => 'some'], $something->getAttributeArray('p4'));
        $this->assertEquals([$p4], $something->getAttributeArray('p4', unpackSelf: false));

        $this->assertEquals($p5, $something->getAttribute('p5'));
        $this->assertEquals('', $something->getAttributeString('p5'));
        $this->assertEquals(0, $something->getAttributeInt('p5'));
        $this->assertEquals([$p5], $something->getAttributeArray('p5'));
    }
}
