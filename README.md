README
======

What is Lansole Pages Bundle?
----------------------------

**Lansole Pages Bundle** is a simple CMS system build with Symfony2.

This bundle is part of [Lansole Toolkit][1], a bunch of bundles to help you build sites out of the box.

Check [Lansole Toolkit][1] for see this bundle on action.

Requirements
------------

This bundle takes advantages of some libraries and bundles. You will need:

 * [DoctrineExtensions][2] for sluggable and tree extensions (configuration needed described below in **Installation**).

Installation
------------

Add LansolePagesBundle to your vendors:

    $ git submodule add git://github.com/marialansole/PagesBundle.git vendor/bundles/Lansole/PagesBundle

Add LansolePagesBundle to your autoload:

    // app/autoload.php
    $loader->registerNamespaces(array(
        // ...
        'Lansole' => __DIR__.'/../vendor/bundles',
        // ...
    ));

Add LansolePagesBundle to your application kernel:

    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Lansole\PagesBundle\LansolePagesBundle(),
        );
        // ...

        return $bundles;
    }

Add LansolePagesBundle routing rules to your application (this should be the last entry of *routing.yml*):

    # app/config/routing.yml
    # ...
    LansolePagesBundle:
        resource: "@LansolePagesBundle/Resources/config/routing.yml"
        prefix:   /

Enable the sluggable and tree extensions:

    # app/config/config.yml
    stof_doctrine_extensions:
        orm:
            default:
                tree: true
                sluggable: true


Add assets to your web directory:

    $ ./app/console assets:install --symlink web

Rebuild the model and update your schema:

    $ ./app/console doctrine:generate:entities
    $ ./app/console doctrine:schema:update --force

Configuration
-------------

You need a root page and for this you can load the fixtures included on the bundle (explained below on Extra section) or just add it to your database:

    INSERT INTO `page` (`id`, `title`, `slug`, `created_at`, `updated_at`, `path`, `parent_id`, `lft`, `lvl`, `rgt`, `root`, `template`, `description`, `keywords`) VALUES (1, 'Homepage', 'homepage', NOW(), NOW(), '/', NULL, 1, 0, 2, 1, NULL, NULL, NULL);

Security
--------

For this bundle you need to have a *ROLE_ADMIN* role.

The security configuration it's up to you. In most of the cases I use [FOSUserBundle][3].

**Note:** If you use [LansoleCoreBundle][4], an User class is included to take advantage of all *FOSUserBundle* functionality.

Templates
---------

This bundle uses [Bootstrap, from Twitter][5]. You can use other stylesheets and javascripts simply overriding the *LansolePagesBundle:Core:stylesheets.html.twig* and *LansolePagesBundle:Core:javascripts.html.twig* views.

The Block rendering uses [jEditable][6] for edit in place and [jWYSIWYG][7] for rich text editing.

Extra
-----

You can use the fixtures included on the bundle using the [DoctrineFixturesBundle][8]. To load it, just run the follow command:

    $ ./app/console doctrine:fixture:load --fixtures=vendor/bundles/Lansole/PagesBundle/DataFixtures/

Other
-----

* If you need any help, you can [contact me][9].
* If you want to follow the updates, [follow me on twitter][10].
* If you want to report a bug or suggest a feature, use [GitHub Issues][11].

[1]: https://github.com/marialansole/Lansole-Toolkit
[2]: https://github.com/stof/StofDoctrineExtensionsBundle/blob/master/Resources/doc/index.rst
[3]: https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md
[4]: https://github.com/marialansole/LansoleCoreBundle
[5]: http://twitter.github.com/bootstrap/index.html
[6]: https://github.com/tuupola/jquery_jeditable
[7]: https://github.com/akzhan/jwysiwyg
[8]: http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html
[9]: https://github.com/inbox/new/marialansole
[10]: https://twitter.com/marialansole
[11]: https://github.com/marialansole/PagesBundle/issues
