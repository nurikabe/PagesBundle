<?php

namespace Lansole\PagesBundle\Twig;

use Lansole\PagesBundle\Entity\BlockManagerInterface,
    Lansole\PagesBundle\Entity\PageManagerInterface,
    Symfony\Component\Security\Core\SecurityContextInterface,
    Symfony\Component\Routing\RouterInterface;

class PagesExtension extends \Twig_Extension
{
    protected $blockManager;
    protected $pageManager;
    protected $security;
    protected $router;
    protected $options;
    protected $params;

    /**
     * Contructor
     */
    public function __construct(BlockManagerInterface $blockManager, PageManagerInterface $pageManager, SecurityContextInterface $security, RouterInterface $router)
    {
        $this->blockManager = $blockManager;
        $this->pageManager = $pageManager;
        $this->security = $security;
        $this->router = $router;

        $this->options = array(
            'tag'  => 'div',
            'type' => 'text'
        );

        $this->params = array(
            'data-role' => 'editable', 
            'data-type' => $this->options['type'],
        );
    }

    /**
     * Get functions
     */
    public function getFunctions() {
        return array(
            'lansole_pages_block'      => new \Twig_Function_Method($this, 'block', array('is_safe' => array('html'))),
            'lansole_pages_breadcrumb' => new \Twig_Function_Method($this, 'breadcrumb', array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders a block
     */
    public function block($page, $slug, $options = array())
    {
        $options = array_merge($this->options, $options);

        $block = $this->blockManager->getBlock($page, $slug, $options['type']);

        $extra = array(
            'id'      => sprintf('%s-block', $slug),
            'data-id' => $block->getId(),
        );

        $params = $this->getParams(array_merge($extra, $options));

        return $this->getContentTag($options['tag'], $block->getBody(), $params);
    }

    /**
     * Renders the breadcrumb
     */
    public function breadcrumb($page)
    {
        $parents = $this->pageManager->getPath($page);

        $separator = $this->getContentTag('span', '/', array('class' => 'divider'));
        $items = '';

        foreach ($parents as $parent) {
            if ($parent->getId() !== $page->getId()) {
              $item = $this->getContentTag('a', $parent->getTitle(), array('href' => $this->router->generate('LansolePagesBundle_page', array('path' => $parent->getPath())))) . $separator;
            } else {
              $item = $parent->getTitle();
            }

            $items .= $this->getContentTag('li', $item);
        }

        return $this->getContentTag('ul', $items, array('class' => 'breadcrumb'));
    }

    /**
     * Get name
     */
    public function getName()
    {
        return 'lansole_pages';
    }

    /**
     * Params transformed to work properly
     */
    protected function getParams($options)
    {
      $options['data-type'] = $options['type'];
      $options['data-url'] = $this->router->generate('LansolePagesBundle_block_update');

      unset($options['tag'], $options['type']);

      $params = array_merge($this->params, $options);

      if (false === $this->security->isGranted('ROLE_ADMIN')) {
        unset($params['data-id'], $params['data-role'], $params['data-type'], $params['data-url']);
      }

      return $params;
    }

    /**
     * Create an html tag
     */
    protected function getContentTag($tag, $content = '', $options = array())
    {
        if (!$tag)
        {
            return '';
        }

        return '<'. $tag . $this->getHtmlOptions($options) . '>' . $content . '</'. $tag .'>';
    }

    /**
     * Transform an array to an html string of options
     */
    protected function getHtmlOptions($options = array())
    {
        $html = '';

        foreach ($options as $key => $value) {
            $html .= ' ' . trim($key) . '="' . trim($value) . '"';
        }

        return $html;
    }
}