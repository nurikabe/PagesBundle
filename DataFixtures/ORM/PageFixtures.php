<?php

namespace Lansole\PagesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Lansole\PagesBundle\Entity\Page;

class PageFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
        $page = new Page();
        $page->setTitle('Homepage');
        $page->setPath('/');
        $page->setTemplate('default');
        $page->setIsPublished(false);

        $manager->persist($page);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}