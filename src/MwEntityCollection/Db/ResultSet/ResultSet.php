<?php
/**
 * MwEntityCollection
 */

namespace MwEntityCollection\Db\ResultSet;

use Zend\Db\ResultSet\AbstractResultSet;
use MwEntityCollection\Entity\AbstractEntity;

/**
 * Result Set
 */
class ResultSet extends AbstractResultSet
{

    /**
     * @var AbstractEntity
     */
    protected $entityPrototype;

    /**
     * Set the row entity prototype
     *
     * @param  AbstractEntity           $objectPrototype
     * @throws InvalidArgumentException
     * @return ResultSet
     */
    public function setEntityPrototype($entityPrototype)
    {
        if (!$entityPrototype instanceof AbstractEntity) {
            throw new \InvalidArgumentException('Entity must be of type AbstractEntity');
        }
        $this->entityPrototype = $entityPrototype;

        return $this;
    }

    /**
     * Get the row entity prototype
     *
     * @return AbstractEntity
     */
    public function getEntityPrototype()
    {
        return $this->entityPrototype;
    }

    /**
     * @return AbstractEntity|null
     */
    public function current()
    {
        $data = parent::current();

        if (!$this->entity) {
            throw new \RuntimeException('The EntityPrototype has not been set');
        }
        $this->entity->fromArray($data);
        $this->entity->clean();

        return $this->entity;
    }
}
