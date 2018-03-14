<?php
/**
 * Created by PhpStorm.
 * User: p.pobelle
 * Date: 02/03/2018
 * Time: 10:18
 */

namespace PaginationBundle\Service;


use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Exception;
use PaginationBundle\Models\Pagination;
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
            $countRslt = $count_qb->select('COUNT(' . $qb->getAllAliases()[0] . ')')->getQuery()->getSingleScalarResult();
        } catch (Exception $e) {
            var_dump($e->getMessage()); die;
        }
        $nb_pages = ceil($countRslt / $this->nb_elt_per_page);
        $entities = $qb->setMaxResults($this->nb_elt_per_page)->setFirstResult($startAt)->getQuery()->getResult();

        $pagination = new Pagination();
        $pagination->setEntities($entities);
        $pagination->setPages($nb_pages);
        $pagination->setCount($countRslt);
        $pagination->setCurrent($page+1);

        return $pagination;
    }

}