<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Menu\Controller\Admin;

use Cms\Controller\Admin\AbstractController;
use Krystal\Tree\AdjacencyList\TreeBuilder;

abstract class AbstractAdminController extends AbstractController
{
    /**
     * Returns MenuWidget service
     * 
     * @return \Menu\Service\MenuWidget
     */
    final protected function getMenuWidget()
    {
        return $this->getModuleService('menuWidget');
    }

    /**
     * Returns category manager
     * 
     * @return \Menu\Service\CategoryManager
     */
    final protected function getCategoryManager()
    {
        return $this->getModuleService('categoryManager');
    }

    /**
     * Returns item manager
     * 
     * @return \Menu\Service\ItemManager
     */
    final protected function getItemManager()
    {
        return $this->getModuleService('itemManager');
    }

    /**
     * Returns prepared tree builder
     * 
     * @param string $categoryId
     * @return \Krystal\Tree\AdjacencyList\TreeBuilder
     */
    final protected function getTreeBuilder($categoryId)
    {
        return new TreeBuilder($this->getItemManager()->fetchAllByCategoryId($categoryId, false));
    }
}
