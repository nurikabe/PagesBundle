<?php

namespace Lansole\PagesBundle\Entity;

interface BlockInterface
{
    function setUpdatedValue();

    function getId();

    function setTitle($title);

    function getTitle();

    function setType($type);

    function getType();

    function setBody($body);

    function getBody();

    function setSlug($slug);

    function getSlug();

    function setCreatedAt($createdAt);

    function getCreatedAt();

    function setUpdatedAt($updatedAt);

    function getUpdatedAt();

    function setPage(\Lansole\PagesBundle\Entity\Page $page);

    function getPage();
}