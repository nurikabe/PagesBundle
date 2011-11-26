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
                ->add('template', 'choice', array('choices' => $this->getTemplates()))
                ->add('link')
                ->add('is_published');

        if ($options['data']->getId() !== 1) {
            $builder->add('parent');
        }
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

       $finder->files()->in(__DIR__ . '/../Resources/views/Template');

       if (is_dir('../app/Resources/LansolePagesBundle/views/Template')) {
         $finder->in('../app/Resources/LansolePagesBundle/views/Template');
       }

       $templates = array();

       foreach ($finder->files() as $file) {
           $name = str_replace(array('.html.twig', '.html.php'), '', $file->getFileName());

           $templates[$name] = ucwords(str_replace('_', ' ', $name));
       }

       sort($templates);

       return $templates;
   }
}
