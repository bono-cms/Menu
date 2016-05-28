<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Menu\Service;

use Krystal\Tree\AdjacencyList\TreeBuilder;
use Cms\Service\WebPageManagerInterface;
use Menu\Contract\WebPageAwareRendererInterface;
use Menu\Storage\CategoryMapperInterface;
use Menu\Storage\ItemMapperInterface;
use RuntimeException;

final class SiteService implements SiteServiceInterface
{
    /**
     * ItemMnager is used to grab items by category class
     * 
     * @var \Menu\Storage\ItemMapperInterface
     */
    private $itemMapper;

    /**
     * Any compliant category mapper
     * 
     * @var \Menu\Storage\CategoryMapperInterface
     */
    private $categoryMapper;

    /**
     * Web page manager is used to build item URLs
     * 
     * @var \Cms\Service\WebPageManagerInterface
     */
    private $webPageManager;

    /**
     * An id of home web page id
     * 
     * @var integer
     */
    private $homeWebPageId;

    /**
     * State initialization
     * 
     * @param \Menu\Storage\ItemMapperInterface $itemMapper
     * @param \Menu\Storage\CategoryMapperInterface $categoryMapper
     * @param \Cms\Service\WebPageManagerInterface $webPageManager
     * @return void
     */
    public function __construct(ItemMapperInterface $itemMapper, CategoryMapperInterface $categoryMapper, WebPageManagerInterface $webPageManager)
    {
        $this->itemMapper = $itemMapper;
        $this->categoryMapper = $categoryMapper;
        $this->webPageManager = $webPageManager;
    }

    /**
     * Defines an id of home web page id
     * Later on, this id is used in order to add class "active"
     * 
     * @param string $homeWebPageId
     * @return void
     */
    public function setHomeWebPageId($homeWebPageId)
    {
        $this->homeWebPageId = $homeWebPageId;
    }

    /**
     * Returns a tree builder loaded with provided menu class
     * 
     * @param string $class Menu category's class
     * @return \Krystal\Tree\AdjacencyList\TreeBuilder
     */
    private function createTreeBuilder($class)
    {
        $id = $this->categoryMapper->fetchIdByClass($class);
        $data = $this->itemMapper->fetchAllByCategoryId($id, true);

        return new TreeBuilder($data);
    }

    /**
     * Fetches menu category's name by its associated class name
     * 
     * @param string $class Menu category's class name
     * @return string
     */
    public function getCategoryNameByClass($class)
    {
        return $this->categoryMapper->fetchNameByClass($class);
    }

    /**
     * Renders category block associated with provided web page id
     * 
     * @param string $webPageId
     * @return string The block
     */
    public function renderByAssocWebPageId($webPageId)
    {
        $categoryId = $this->itemMapper->fetchCategoryIdByWebPageId($webPageId);
        $class = $this->categoryMapper->fetchClassById($categoryId);

        return $this->renderByClass($class, $webPageId);
    }

    /**
     * Renders menu block by category's class name
     * 
     * @param string $class
     * @param object $renderer
     * @param string $webPageId Used to add active class in <li> elements in template views
     * @return string
     */
    public function renderByClass($class, $webPageId, $renderer)
    {
        $tree = $this->createTreeBuilder($class);

        if ($renderer instanceof WebPageAwareRendererInterface) {
            $renderer->setWebPageManager($this->webPageManager);

            if ($this->homeWebPageId !== null) {
                $renderer->setHomeWebPageId($this->homeWebPageId);
            }
        }

        $tree->setRenderer($renderer);
        return $tree->render(null, $webPageId);
    }
}
