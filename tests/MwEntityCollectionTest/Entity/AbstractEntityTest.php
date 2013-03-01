<?php

namespace MwEntityCollectionTest\Entity;

class AbstractEntityTest extends \PHPUnit_Framework_TestCase
{
    protected $entity;

    public function setUp()
    {
        $this->entity = new TestAsset\TestEntity();
    }

    public function testConstructor()
    {
        $entity = new TestAsset\TestEntity(array('property' => 'foo'));
        $this->assertEquals('foo', $entity->property);
        $this->assertTrue($entity->isLoaded());
        $this->assertFalse($entity->isDirty());
        $this->assertEquals(1, count($entity->toArray()));
        $this->assertEquals(0, count($entity->toArray(true)));
    }

    public function testProperty()
    {
        $this->entity->property = 'foo';
        $this->assertEquals('foo', $this->entity->property);
        $this->assertTrue($this->entity->isLoaded());
        $this->assertTrue($this->entity->isDirty());
        $this->assertEquals(1, count($this->entity->toArray(true)));
    }

    public function testSetBlacklistedPropertyThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->entity->propertyLoaded = 'foo';
    }

    public function testSetInvalidPropertyThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->entity->foo = 'bar';
    }

    public function testClean()
    {
        $this->entity->property = 'bar';
        $this->assertTrue($this->entity->isDirty());
        $this->assertTrue($this->entity->isLoaded());
        $this->entity->clean();
        $this->assertFalse($this->entity->isDirty());
        $this->assertTrue($this->entity->isLoaded());
    }
}
