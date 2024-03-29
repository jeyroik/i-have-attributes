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
}
