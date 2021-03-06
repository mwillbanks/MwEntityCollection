<?php
/**
 * MwEntityCollection
 */

namespace MwEntityCollection\Entity;

use MwEntityCollection\Exception;

/**
 * Abstract Entity
 *
 * @category   MwEntityCollection
 * @package    MwEntityCollection
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
     * @param  array          $data
     * @return AbstractEntity
     */
    public function __construct(array $data = null)
    {
        if ($data !== null) {
            $this->fromArray($data);
            $this->clean();
        }
    }

    /**
     * Get Property
     *
     * @param  string                             $key
     * @return mixed
     * @throws Exception\InvalidArgumentException
     */
    public function __get($key)
    {
        if (!in_array($key, $this->propertyLoaded)) {
            throw new Exception\InvalidArgumentException(
                sprintf('Key: "%k" was not loaded', $key));
        }

        return $this->$key;
    }

    /**
     * Set Property
     *
     * @param  string                             $key
     * @param  mixed                              $value
     * @return AbstractEntity
     * @throws Exception\InvalidArgumentException
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
            $methodName = 'set' . ucwords($key);
            if (method_exists($this, $methodName)) {
                $this->$methodName($key);
            } else {
                $this->$key = $value;
            }
            $this->propertyDirty[] = $key;
            $this->propertyLoaded[] = $key;
        }

        return $this;
    }

    /**
     * Clean Dirty Properties
     *
     * @return AbstractEntity
     */
    public function clean()
    {
        $this->propertyDirty = array();
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
     * Is the Entity Loaded
     *
     * @return bool
     */
    public function isLoaded()
    {
        return (bool) count($this->propertyLoaded);
    }

    /**
     * Create a new object from an Array
     *
     * @return AbstractEntity
     */
    public function fromArray(array $data)
    {
        while (list($k, $v) = each($data)) {
            if (!property_exists($this, $k) || in_array($k, $this->propertyBlacklist)) {
                throw new Exception\InvalidArgumentException(sprintf(
                    '$data key: "%d" was not listed in the allowed properties', $k));
            }
            $this->$k = $v;
            $this->propertyLoaded[] = $k;
            $this->propertyDirty[] = $k;
        }

        return $this;
    }

    /**
     * To Array
     *
     * @param  bool  $dirty fetch dirty elements
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
