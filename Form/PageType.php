<?php

namespace Lansole\PagesBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder,
    Symfony\Component\Finder\Finder as Finder;

class PageType extends AbstractType
{
    /**
     * Build form
     *
     * @param FormBuilder $builder
     * @param array       $options
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('title')
                ->add('description')
                ->add('keywords')
                ->add('parent')
                ->add('template', 'choice', array('choices' => $this->getTemplates()))
                ->add('link')
                ->add('is_published');
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return 'lansole_pages_page';
    }

    /**
     * Search on views folder for templates
     *
     * @return array
     */
    protected function getTemplates()
    {
        $finder = new Finder();
        $finder->files()->in('../src/Lansole/PagesBundle/Resources/views/Template')
                        ->in(__DIR__ . '/../Resources/views/Template');

        $templates = array();

        foreach ($finder->files() as $file) {
            $name = str_replace(array('.html.twig', '.html.php'), '', $file->getFileName());

            $templates[$name] = ucwords(str_replace('_', ' ', $name));
        }

        return $templates;
    }
}
