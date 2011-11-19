<?php

namespace Lansole\PagesBundle\Entity;

interface BlockManagerInterface
{
    function getBlock($page, $slug, $type);
}