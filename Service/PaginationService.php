<?php

namespace Pkshetlie\PaginationBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Exception;
use Pkshetlie\PaginationBundle\Models\Pagination;
use Symfony\Component\HttpFoundation\InputBag;

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
     *
     * @param int $nb_elt_per_page
     *
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
     * @param Request $inputBag
     *
     * @return Pagination
     */
    public function process(QueryBuilder $queryBuilder, InputBag $inputBag)
    {

        $pagination = new Pagination();
        $pagination->setLastEntityId($inputBag->get('plentid'.$pagination->getIdentifier(), 0));
        $pagination->setIsPartial($inputBag->get('ppartial'.$pagination->getIdentifier(), false));
        $usableQuery = clone $queryBuilder;
        $page = $inputBag->get('ppage'.$pagination->getIdentifier(), 1);

        if (!is_numeric($page)) {
            $page = 1;
        }

        $page -= 1;

        $startAt = $page * $this->nb_elt_per_page;

        try {
            $countRslt = $usableQuery->addSelect(
                'COUNT( DISTINCT '.$usableQuery->getAllAliases()[0].') as count_nb_elt'
            )->getQuery()->getOneOrNullResult();
        } catch (Exception $e) {
            $usableQuery = clone $queryBuilder;
            $countRsltat = $usableQuery->addSelect(
                'COUNT( DISTINCT '.$usableQuery->getAllAliases()[0].') as count_nb_elt'
            )->getQuery()->getResult();
            $countRslt['count_nb_elt'] = count($countRsltat);
        }

        $nb_pages = ceil(($countRslt != null ? $countRslt['count_nb_elt'] : 0) / $this->nb_elt_per_page);
        $nb_pages = max($nb_pages, 0);
        $startAt = max($startAt, 0);

        $entities = $queryBuilder
            ->setMaxResults($this->nb_elt_per_page)
            ->setFirstResult($startAt)
            ->getQuery()->getResult();

        $pagination->setEntities($entities);
        $pagination->setPages($nb_pages);
        $pagination->setCount(($countRslt != null ? $countRslt['count_nb_elt'] : 0));
        $pagination->setCurrent($page + 1);

        return $pagination;
    }
}
