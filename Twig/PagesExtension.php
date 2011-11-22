<?php

namespace Lansole\PagesBundle\Twig;

use Lansole\PagesBundle\Entity\BlockManagerInterface,
    Symfony\Component\Security\Core\SecurityContextInterface;

class PagesExtension extends \Twig_Extension
{
    protected $blockManager;
    protected $security;
    protected $options;
    protected $params;

    /**
     * Contructor
     */
    public function __construct(BlockManagerInterface $blockManager, SecurityContextInterface $security)
    {
        $this->blockManager = $blockManager;
        $this->security = $security;

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
            'lansole_pages_block' => new \Twig_Function_Method($this, 'render', array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders a block
     */
    public function render($page, $slug, $options = array())
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

      unset($options['tag'], $options['type']);

      $params = array_merge($this->params, $options);

      if (false === $this->security->isGranted('ROLE_ADMIN')) {
        unset($params['data-id'], $params['data-role'], $params['data-type']);
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