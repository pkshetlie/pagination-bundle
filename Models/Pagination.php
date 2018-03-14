<?php
/**
 * Created by PhpStorm.
 * User: p.pobelle
 * Date: 02/03/2018
 * Time: 10:56
 */

namespace PaginationBundle\Models;


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


}