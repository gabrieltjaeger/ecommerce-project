<?php

use PHPUnit\Framework\TestCase;
use src\core\entities\Product;

class ProductTest extends TestCase
{
    public function test_setters_and_getters_work(): void
    {
        $p = new Product(id: '10');
        $p->setProduct('TV');
        $p->setPrice('2500.00');
        $p->setWidth('100');
        $p->setHeight('60');
        $p->setLength('10');
        $p->setWeight('5');
        $p->setUrl('http://example.com/tv');

        $this->assertSame('TV', $p->getProduct());
        $this->assertSame('2500.00', $p->getPrice());
        $this->assertSame('100', $p->getWidth());
        $this->assertSame('60', $p->getHeight());
        $this->assertSame('10', $p->getLength());
        $this->assertSame('5', $p->getWeight());
        $this->assertSame('http://example.com/tv', $p->getUrl());
    }
}
