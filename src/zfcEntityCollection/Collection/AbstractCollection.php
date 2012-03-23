<?php
/**
 * ZfcEntityCollection
 *
 * @category   ZfcEntityCollection
 * @package    ZfcEntityCollection
 * @subpackage Collection
 */

namespace ZfcEntityCollection\Collection;

use Countable,
    Iterator,
    ZfcEntityCollection\Entity\AbstractEntity;

/**
 * Abstract Collection
 *
 * @category   ZfcEntityCollection
 * @package    ZfcEntityCollection
 * @subpackage Collection
 */
abstract class AbstractCollection implements Iterator, Countable
{
    /**
     * Entity Class
     * @var string
     */
    protected $entity;

    /**
     * Current Position
     * @var int
     */
    protected $position = 0;

    /**
     * Data
     * @param array
     */
    protected $data = array();

    /**
     * Constructor
     *
     * @param array $data
     * @return ZfcEntityCollection\Collection\AbstractCollection
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
     * @return ZfcEntityCollection\Entity\AbstractEntity
     */
    public function current()
    {
        return $this->buildEntity($this->position);
    }

    /**
     * Key
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Next
     *
     * @return ZfcEntityCollection\Entity\AbstractEntity
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Rewind
     *
     * @return ZfcEntityCollection\Entity\AbstractEntity
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Valid
     *
     * @return bool
     */
    public function valid()
    {
        return isset($this->data[$this->position]);
    }

    /**
     * Build Entity
     *
     * @return ZfcEntityCollection\Entity\AbstractEntity
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
        foreach ($this->data as $entity)
        {
            if ($entity instanceof AbstractEntity) {
                $entity = $entity->toArray();
            }
            $data[] = $entity;
        }
        return $data;
    }
}
