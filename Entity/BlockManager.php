<?php

namespace Lansole\PagesBundle\Entity;

use Lansole\PagesBundle\Entity\BlockManagerInterface,
    Lansole\PagesBundle\Entity\BlockInterface,
    Doctrine\ORM\EntityManager;

class BlockManager implements BlockManagerInterface
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
    * Find or Create a Block
    */
    public function getBlock($page, $slug, $type)
    {
       $block = $this->em->getRepository('LansolePagesBundle:Block')
                         ->getBlockForPage($page, $slug, $type);

       if (!$block) {
           $block = new Block();

           $block->setTitle(ucwords(str_replace('-', ' ', $slug)));
           $block->setPage($page);
           $block->setType($type);
           $block->setSlug($slug);

           $this->em->persist($block);
           $this->em->flush();
       }

       return $block;
    }
}