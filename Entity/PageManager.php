<?php

namespace Lansole\PagesBundle\Entity;

use Lansole\PagesBundle\Entity\PageManagerInterface,
    Doctrine\ORM\EntityManager;

class PageManager implements PageManagerInterface
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Get path
     * 
     * @param $page
     */
    public function getPath($page)
    {
       return $this->em->getRepository('LansolePagesBundle:Page')->getPath($page);
    }
}