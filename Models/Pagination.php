<?php

namespace  Pkshetlie\PaginationBundle\Models;


use Doctrine\ORM\Mapping\Entity;

class Pagination
{
    /**
     * @var Entity[]
     */
    protected $entities;
    /** @var int */
    protected $count;
    /**
     * @var int
     */
    protected $pages;
    /**
     * @var int
     */
    protected $current;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected static $increment = 0;
    /**
     * @var bool
     */
    protected $isPartial;
    /**
     * @var integer
     */
    private $lastEntityId;

    public function __construct()
    {
        self::$increment += 1;
        $this->identifier = self::$increment;
    }
    /**
     * @return Entity[]
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @param Entity[] $entities
     */
    public function setEntities($entities)
    {
        $this->entities = $entities;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param int $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    /**
     * @return int
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param int $current
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return int
     */
    public function getLastEntityId(): int
    {
        return $this->lastEntityId;
    }

    /**
     * @param int $lastEntityid
     */
    protected function setLastEntityId(int $lastEntityId)
    {
        $this->lastEntityId = $lastEntityId;
    }

    /**
     * @return bool
     */
    public function isPartial(): bool
    {
        return $this->isPartial;
    }

    /**
     * @param bool $isPartial
     */
    protected function setIsPartial(bool $isPartial)
    {
        $this->isPartial = $isPartial;
    }
}