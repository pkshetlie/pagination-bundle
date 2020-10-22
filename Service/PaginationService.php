<?php

namespace  Pkshetlie\PaginationBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Exception;
use Pkshetlie\PaginationBundle\Models\Pagination;
use Symfony\Component\HttpFoundation\Request;

class PaginationService
{
    protected $em = null;
    protected $isPartial = false;
    protected $lastEntityid = 0;
    private $nb_elt_per_page = 25;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * define the default number of element by page
     * @param int $nb_elt_per_page
     * @return $this
     */
    public function setDefaults($nb_elt_per_page = 25)
    {
        if ($nb_elt_per_page !== null) {
            $this->nb_elt_per_page = $nb_elt_per_page;
        }
        return $this;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param Request $request
     * @return Pagination
     */
    public function process(QueryBuilder $queryBuilder, Request $request)
    {

        $pagination = new Pagination();
        $pagination->setLastEntityId($request->get('plentid'.$pagination->getIdentifier(), 0));
        $pagination->setIsPartial($request->get('ppartial'.$pagination->getIdentifier(), false));
        $usableQuery = clone $queryBuilder;
        $page = $request->get('ppage'.$pagination->getIdentifier(), 1) - 1;


        $startAt = $page * $this->nb_elt_per_page;
        try {
            $countRslt = $usableQuery->addSelect('COUNT( DISTINCT ' . $usableQuery->getAllAliases()[0] . ') as count_nb_elt')->getQuery()->getOneOrNullResult();
        } catch (Exception $e) {
            $usableQuery = clone $queryBuilder;
            $countRsltat = $usableQuery->addSelect('COUNT( DISTINCT ' . $usableQuery->getAllAliases()[0] . ') as count_nb_elt')->getQuery()->getResult();
            $countRslt['count_nb_elt'] = count($countRsltat);
        }
        $nb_pages = ceil($countRslt['count_nb_elt'] / $this->nb_elt_per_page);
        $entities = $queryBuilder->setMaxResults($this->nb_elt_per_page)->setFirstResult($startAt)->getQuery()->getResult();

        $pagination->setEntities($entities);
        $pagination->setPages($nb_pages);
        $pagination->setCount($countRslt['count_nb_elt']);
        $pagination->setCurrent($page+1);

        return $pagination;
    }
}