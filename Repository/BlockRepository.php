<?php

namespace Lansole\PagesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BlockRepository extends EntityRepository
{
    /**
     * Get a block for a given page, slug and type
     */
    public function getBlockForPage($page, $slug, $type)
    {
      $result = $this->createQueryBuilder('b')
                     ->select('b')
                     ->where('b.page = :page AND b.slug = :slug')
                     ->setParameter('page', $page)
                     ->setParameter('slug', $slug)
                     ->getQuery()
                     ->getResult();

      return isset($result[0]) ? $result[0] : null;
    }
}