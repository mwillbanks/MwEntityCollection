Entity Collection Module
=======

Introduction
------------

The Entity Collection module contains abstract classes that will help you to
consume services.  The reasoning this was created is that when
you consume APIs it is ideal to provide an object approach with hydration.

Requirements
------------

 * [Zend Framework 2](https://github.com/zendframework/zf2) (latest master)

Goals
-----

 * Provide an abstraction layer to quickly consume APIs
 * Allow for consumption in the collection of multiple types of data
    * JSON
    * XML
    * array
 * Lazily load the entities from a collection

Current State
-------------

 * The collection currently only supports arrays and will need to be refactored


Documentation
-------------

No real docbook documentation at this point in time; however, I will attempt to
explain a few of the items.

 * Entity Methods
    * fromArray - This is basically the loader; this will not cause an element to become "dirty"
    * isDirty   - when you set a property using $entity->property, that property will become dirty
    * toArray   - This will take the loaded elements by default (dirty if you pass in true) and push
                  them to an array

If you attempt to get a property from an entity that has not been set; an exception will be thrown.
If you attempt to set a property from an entity that is on a blacklist; an exception will be thrown.

Examples
--------

```php
namespace ZfcEntityCollection\Entity;

class EntityTest extends AbstractEntity
{
    /**
     * @property
     */
    protected $id;
    /**
     * @property
     */
    protected $name;
    /**
     * @property
     */
    protected $desc;
    /**
     * @property
     */
    protected $youcantuseme;

    public function __construct() {
        $this->propertyBlacklist[] = 'youcantuseme';
    }
}
```
```php
namespace ZfcEntityCollection\Collection;

class CollectionTest extends AbstractCollection
{
    /**
     * Entity Class
     * @var string
     */
    protected $entity = '\ZfcEntityCollection\Entity\EntityTest';
}
```

```php
use \ZfcEntityCollection\Entity\EntityTest,
    \ZfcEntityCollection\Collection\CollectionTest;

$collection = new CollectionTest(array(
    array(
        'id' => 1,
        'name' => 'Foo Bar',
        'desc' => 'This is a description',
    ),
    array(
        'id' => 2,
        'name' => 'My Bar',
    ),
));

foreach ($collection as $c) {
    var_dump($c->toArray(), $c->isDirty()); // array, false
    $c->id = 5;
    var_dump($c->id, $c->isDirty()); // 5, true
}
```

Installation
------------

### Main Setup

1. Clone this project into your `./vendors/` directory and enable it in your
   `application.config.php` file.
