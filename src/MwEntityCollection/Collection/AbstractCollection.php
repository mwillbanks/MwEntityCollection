<?php
/**
 * MwEntityCollection
 */

namespace MwEntityCollection\Collection;

use Countable;
use Iterator;
use MwEntityCollection\Entity\AbstractEntity;

/**
 * Abstract Collection
 */
abstract class AbstractCollection implements Iterator, Countable
{
    /**
     * Entity Class
     * @var string
     */
    protected $entity;

    /**
     * Data
     * @param array
     */
    protected $data = array();

    /**
     * Constructor
     *
     * @param  array              $data
     * @return AbstractCollection
     */
    public function __construct(array $data = null)
    {
        if ($data !== null) {
            $this->data = $data;
        }
    }

    /**
     * Count
     *
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Current
     *
     * @return MwEntityCollection\Entity\AbstractEntity
     */
    public function current()
    {
        return $this->buildEntity(key($this->data));
    }

    /**
     * Key
     *
     * @return int
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * Next
     *
     * @return MwEntityCollection\Entity\AbstractEntity
     */
    public function next()
    {
        next($this->data);

        return $this->current();
    }

    /**
     * Rewind
     *
     * @return void
     */
    public function rewind()
    {
        reset($this->data);
    }

    /**
     * Valid
     *
     * @return bool
     */
    public function valid()
    {
        $key = key($this->data);

        return isset($this->data[$key]);
    }

    /**
     * Build Entity
     *
     * @return MwEntityCollection\Entity\AbstractEntity
     */
    protected function buildEntity($position)
    {
        $data = $this->data[$position];
        if ($data instanceof AbstractEntity) {
            return $data;
        }

        $entity = $this->entity;
        $this->data[$position] = $data = new $entity($data);

        return $data;
    }

    /**
     * To Array
     *
     * @return array
     */
    public function toArray()
    {
        $data = array();
        foreach ($this->data as $entity) {
            if ($entity instanceof AbstractEntity) {
                $entity = $entity->toArray();
            }
            $data[] = $entity;
        }

        return $data;
    }
}
