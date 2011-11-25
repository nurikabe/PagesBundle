<?php

namespace Lansole\PagesBundle\Entity;

interface PageInterface
{
    public function __toString();

    public function setUpdatedValue();

    public function getId();

    public function setTitle($title);

    public function getTitle();

    public function setSlug($slug);

    public function getSlug();

    public function setCreatedAt($createdAt);

    public function getCreatedAt();

    public function setUpdatedAt($updatedAt);

    public function getUpdatedAt();

    public function setPath($path);

    public function getPath();

    public function setLft($lft);

    public function getLft();

    public function setLvl($lvl);

    public function getLvl();

    public function setRgt($rgt);

    public function getRgt();

    public function setRoot($root);

    public function getRoot();

    public function setParent(\Lansole\PagesBundle\Entity\Page $parent);

    public function getParent();

    public function addPage(\Lansole\PagesBundle\Entity\Page $children);

    public function getChildren();

    public function setTemplate($template);

    public function getTemplate();

    public function setDescription($description);

    public function getDescription();

    public function setKeywords($keywords);

    public function getKeywords();

    public function addBlock(\Lansole\PagesBundle\Entity\Block $blocks);

    public function getBlocks();

    public function setIsPublished($isPublished);

    public function getIsPublished();

    public function setLink($link);

    public function getLink();
}