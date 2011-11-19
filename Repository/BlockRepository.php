<?php

namespace Lansole\PagesBundle\Repository;

use Doctrine\ORM\EntityRepository,
    Lansole\PagesBundle\Entity\Block;

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

    /**
     * Find or Create a Block
     */
    public function getBlock($page, $slug, $type)
    {
        $block = $this->getBlockForPage($page, $slug, $type);

        if (!$block) {
            $block = new Block();

            $block->setTitle(ucwords(str_replace('-', ' ', $slug)));
            $block->setPage($page);
            $block->setType($type);
            $block->setSlug($slug);

            $this->_em->persist($block);
            $this->_em->flush();
        }

        return $block;
    }
}