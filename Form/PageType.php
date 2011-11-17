<?php

namespace Lansole\PagesBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder,
    Symfony\Component\Finder\Finder as Finder;

class PageType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('title')
                ->add('parent')
                ->add('template', 'choice', array('choices' => $this->getTemplates()));
    }

    public function getName()
    {
        return 'lansole_pages_page';
    }

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
