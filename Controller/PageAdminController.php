<?php

namespace Lansole\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpFoundation\Request,
    Lansole\PagesBundle\Entity\Page,
    Lansole\PagesBundle\Form\PageType;

class PageAdminController extends Controller
{
    public function indexAction()
    {
        $this->checkSecure();

        $em = $this->getDoctrine()
                   ->getEntityManager();

        $pages = $em->getRepository('LansolePagesBundle:Page')->getRootNodes();

        return $this->render('LansolePagesBundle:Admin:index.html.twig', array('pages' => $pages));
    }

    /**
     * New page
     */
    public function newAction()
    {
        $this->checkSecure();

        $page = new Page();
        $form = $this->createForm(new PageType(), $page);

        return $this->render('LansolePagesBundle:Admin:new.html.twig', array('page' => $page, 'form' => $form->createView()));
    }

    /**
     * Create a page
     *
     * @param Request $request
     */
    public function createAction(Request $request)
    {
        $this->checkSecure();

        $em = $this->getDoctrine()
                   ->getEntityManager();

        $page = new Page();
        $form = $this->createForm(new PageType(), $page);

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em->persist($page);
            $em->flush();

            $this->syncPath($em, $page);

            $this->get('session')->setFlash('page-success', '<strong>Well done!</strong> Your page was successfully created.');

            return $this->redirect($this->generateUrl('LansolePagesBundle_page', array('path' => $page->getPath())));
        } else {
            $this->get('session')->setFlash('page-error', '<strong>You got an error!</strong> Change this and that and try again.');
        }

        return $this->render('LansolePagesBundle:Admin:new.html.twig', array('page' => $page, 'form' => $form->createView()));
    }


    /**
     * Edit a page
     *
     * @param string $slug
     */
    public function editAction($slug)
    {
        $this->checkSecure();

        $em = $this->getDoctrine()
                   ->getEntityManager();

        $page = $em->getRepository('LansolePagesBundle:Page')
                   ->findOneBy(array('slug' => $slug));

        if (!$page || $page->getId() == 1) {
            throw $this->createNotFoundException('Unable to find Page.');
        }

        $form = $this->createForm(new PageType(), $page);

        return $this->render('LansolePagesBundle:Admin:edit.html.twig', array('page' => $page, 'form' => $form->createView()));
    }

    /**
     * Update page
     *
     * @param string  $slug
     * @param Request $request
     */
    public function updateAction($slug, Request $request)
    {
        $this->checkSecure();

        $em = $this->getDoctrine()
                   ->getEntityManager();

        $page = $em->getRepository('LansolePagesBundle:Page')
                   ->findOneBy(array('slug' => $slug));

        if (!$page || $page->getId() == 1) {
            throw $this->createNotFoundException('Unable to find Page.');
        }

        $form = $this->createForm(new PageType(), $page);

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em->persist($page);
            $em->flush();

            $this->syncPath($em, $page);

            $this->get('session')->setFlash('page-success', '<strong>Well done!</strong> Your page was successfully updated.');

            return $this->redirect($this->generateUrl('LansolePagesBundle_page', array('path' => $page->getPath())));
        }

        return $this->render('LansolePagesBundle:Admin:edit.html.twig', array('page' => $page, 'form' => $form->createView()));
    }

    /**
     * Delete a page
     *
     * @param string $slug
     */
    public function deleteAction($slug)
    {
        $this->checkSecure();

        $em = $this->getDoctrine()
                   ->getEntityManager();

        $page = $em->getRepository('LansolePagesBundle:Page')
                   ->findOneBy(array('slug' => $slug));

        if (!$page || $page->getId() == 1) {
            throw $this->createNotFoundException('Unable to find Page.');
        }

        $em->remove($page);
        $em->flush();

        $this->get('session')->setFlash('page-success', '<strong>Well done!</strong> Your page was successfully deleted.');

        return $this->redirect($this->generateUrl('LansolePagesBundle_page'));
    }

    /**
     * Sync page path taking into account the parents
     *
     * @param Doctrine\ORM\EntityManager        $em
     * @param Lansole\PagesBundle\Entity\Page   $page
     */
    protected function syncPath($em, $page)
    {
        $parents = $em->getRepository('LansolePagesBundle:Page')->getPath($page);

        $route = array();

        foreach ($parents as $page) {
            $route[] = $page->getSlug();
        }

        array_shift($route);

        $path = sprintf('/%s', implode('/', $route));

        if ($page->getPath() !== $path) {
            $page->setPath($path);

            $em->persist($page);
            $em->flush();
        }
    }

    /**
     * Security check for admin role
     */
    protected function checkSecure()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
    }
}