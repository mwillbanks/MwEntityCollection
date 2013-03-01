<?php

namespace MwEntityCollectionTest\Collection;

class AbstractCollectionTest extends \PHPUnit_Framework_TestCase
{
    protected $collection;

    public function setUp()
    {
        $this->collection = new TestAsset\TestCollection(array(
            array('property' => 'foo'),
            array('property' => 'bar'),
        ));
    }

    public function testCount()
    {
        $this->assertEquals(2, $this->collection->count());
    }

    public function testKey()
    {
        $this->assertEquals(0, $this->collection->key());
    }

    public function testCurrent()
    {
        $this->assertEquals('foo', $this->collection->current()->property);
    }

    public function testNext()
    {
        $this->assertEquals('bar', $this->collection->next()->property);
    }

    public function testToArray()
    {
        $this->assertEquals(array(array('property' => 'foo'), array('property' => 'bar')), $this->collection->toArray());
    }
}
