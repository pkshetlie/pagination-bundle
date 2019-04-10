<?php

namespace  Pkshetlie\PaginationBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Exception;
use Pkshetlie\PaginationBundle\Models\Pagination;
use Symfony\Component\HttpFoundation\Request;

class Calcul
{
    protected $em = null;
    private $nb_elt_per_page = 25;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function setDefaults($nb_elt_per_page = null)
    {
        if ($nb_elt_per_page !== null) {
            $this->nb_elt_per_page = $nb_elt_per_page;
        }
        return $this;
    }

    /**
     * @param QueryBuilder $qb
     * @param Request $request
     * @return Pagination
     */
    public function process(QueryBuilder $qb, Request $request)
    {
        $page = $request->get('ppage', 1) - 1;

        $startAt = $page * $this->nb_elt_per_page;
        $count_qb = clone $qb;
        try {
            $countRslt = $count_qb->addSelect('COUNT(' . $qb->getAllAliases()[0] . ') as count_nb_elt')->getQuery()->getOneOrNullResult();
        } catch (Exception $e) {
        }
        $nb_pages = ceil($countRslt['count_nb_elt'] / $this->nb_elt_per_page);
        $entities = $qb->setMaxResults($this->nb_elt_per_page)->setFirstResult($startAt)->getQuery()->getResult();

        $pagination = new Pagination();
        $pagination->setEntities($entities);
        $pagination->setPages($nb_pages);
        $pagination->setCount($countRslt['count_nb_elt']);
        $pagination->setCurrent($page+1);

        return $pagination;
    }

}