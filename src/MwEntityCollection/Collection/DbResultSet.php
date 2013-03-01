<?php
/**
 * MwEntityCollection
 */

namespace MwEntityCollection\Collection\ResultSet;

use Zend\Db\ResultSet\AbstractResultSet;
use MwEntityCollection\Entity\AbstractEntity;

/**
 * Result Set
 */
abstract class DbResultSet extends AbstractResultSet
{
    /**
     * Entity Class
     * @var string
     */
    protected $entity;

    /**
     * @return AbstractEntity|null
     */
    public function current()
    {
        $data = parent::current();

        $entity = $this->entity;
        $entity = new $entity();
        $entity->fromArray($data);
        $entity->clean();

        return $entity;
    }
}
