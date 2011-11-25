How to use
==========

Creating a page
---------------

There are two options here:

1. Go to pages management **admin/pages** and create your pages.

2. Type on the *url* the route you want, if the page doesn't exists you'll see a suggestion to create it.

Choose your template
--------------------

In the bundle you'll find two templates: "Default" and "Right Sidebar". You can choose to use them or create your own templates.

Just override **Lansole/PagesBundle/Resources/views/Template** and put in here your templates.

**Note**: you can also, override the existing templates and make them yours.

Create your template
--------------------

Override the folder **Lansole/PagesBundle/Resources/views/Template** and put there your template (i.e. *my_cool_template.html.twig*).

Now, you decide the structure and how many and different **blocks** you want (See *Block* section).

Block
-----

A block is a very simple twig function:

    {{ lansole_pages_block(page, 'slug-to-your-block', options) }}

Explaining the variables:

 * **page:** this is mandatory and is your current page, sended automatically thought the controller.
 * **'slug-to-your-block':** this should be the slug of your block, for example, "title" or "content"
 * **options:** This is an optional array of options.
   * *tag*: default tag is *div* (this can be h1, h2, h3, etc)
   * *type*: default type is *text* (this can be 'text', 'textarea' and 'richtext');
   * *html-params*: you can add other options like *class* and others. The attribute *id* is automatic to prevent duplicate ids (use this at you own risk).

--

And that's all, folks :)

I hope to have time to upgrade this. I've couple of good ideas.

If you want to help, let me know :)