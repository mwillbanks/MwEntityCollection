<?php
/**
 * ZfcEntityCollection
 *
 * @category   ZfcEntityCollection
 * @package    ZfcEntityCollection
 * @subpackage Entity
 */

namespace ZfcEntityCollection\Entity;

use ZfcEntityCollection\Exception;

/**
 * Abstract Entity
 *
 * @category   ZfcEntityCollection
 * @package    ZfcEntityCollection
 * @subpackage Entity
 */
abstract class AbstractEntity
{
    /**
     * Properties that cannot be set
     * @var array
     */
    protected $propertyBlacklist = array('propertyBlacklist', 'propertyLoaded', 'propertyDirty');

    /**
     * Properties that have been loaded
     * @var array
     */
    protected $propertyLoaded = array();

    /**
     * Properties that are dirty (modified)
     * @var array
     */
    protected $propertyDirty = array();

    /**
     * Constructor
     *
     * @param array $data
     * @return ZfcEntityCollection\Entity\AbstractEntity
     */
    public function __construct(array $data = null)
    {
        if ($data !== null) {
            $this->fromArray($data);
        }
    }

    /**
     * Get Property
     *
     * @param string $key
     * @return mixed
     * @throws ZfcEntityCollection\Exception\InvalidArgumentException
     */
    public function __get($key) {
        if (!in_array($key, $this->propertyLoaded)) {
            throw new Exception\InvalidArgumentException(
                sprintf('Key: "%k" was not loaded', $key));
        }
        return $this->$key;
    }

    /**
     * Set Property
     *
     * @param string $key
     * @param mixed $value
     * @return AbstractEntity
     * @throws ZfcEntityCollection\Exception\InvalidArgumentException
     */
    public function __set($key, $value)
    {
        if (!is_string($key)) {
            throw new Exception\InvalidArgumentException('$key must be a string');
        }
        if (!property_exists($this, $key) || in_array($key, $this->propertyBlacklist)) {
            throw new Exception\InvalidArgumentException(
                sprintf('Key: "%s" is not an allowed property', $key));
        }
        if ($this->$key !== $value) {
            $this->$key = $value;
            $this->propertyDirty[] = $key;
            $this->propertyLoaded[] = $key;
        }
        return $this;
    }

    /**
     * Is the Entity Dirty
     * 
     * @return bool
     */
    public function isDirty()
    {
        return (bool) count($this->propertyDirty);
    }

    /**
     * Create a new object from an Array
     *
     * @return AbstractEntity
     */
    public function fromArray(array $data)
    {
        while(list($k, $v) = each($data)) {
            if (!property_exists($this, $k) || in_array($k, $this->propertyBlacklist)) {
                throw new Exception\InvalidArgumentException(sprintf(
                    '$data key: "%d" was not listed in the allowed properties', $k));
            }
            $this->$k = $v;
            $this->propertyLoaded[] = $k;
        }
        return $this;
    }

    /**
     * To Array
     *
     * @param bool $dirty fetch dirty elements
     * @return array
     */
    public function toArray($dirty=false)
    {
        $data = array();

        $elements = ($dirty) ? $this->propertyDirty : $this->propertyLoaded;
        foreach ($elements as $key) {
            $data[$key] = $this->$key;
        }
        return $data;
    }
}
