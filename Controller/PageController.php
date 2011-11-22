<?php

namespace Lansole\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    /**
     * Display Page
     *
     * @param string $path
     */
    public function indexAction($path)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $page = $em->getRepository('LansolePagesBundle:Page')->findOneBy(array('path' => sprintf('/%s', $path)));

        if ((!$page || !$page->getIsPublished()) && false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw $this->createNotFoundException('Unable to find Page.');
        } elseif (!$page && $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->render('LansolePagesBundle:Page:new.html.twig', array('path' => $path));
        }

        return $page->getLink() ? $this->redirect($page->getLink()) : $this->render('LansolePagesBundle:Page:index.html.twig', array('page' => $page));
    }
}