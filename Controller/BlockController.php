<?php

namespace Lansole\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response;

class BlockController extends Controller
{
    /**
     * Update block
     */
    public function updateAction()
    {
        $id = $_POST['block_id'];
        $value = $_POST['value'];

        $em = $this->getDoctrine()
                   ->getEntityManager();

        $block = $em->getRepository('LansolePagesBundle:Block')
                    ->find($id);

        if (!$block) {
           throw $this->createNotFoundException('Unable to find Block.');
        }

        if ($block->getBody() !== $value) {
          $block->setBody($value);

          $em->persist($block);
          $em->flush();
        }

        return new Response($value);
    }
}