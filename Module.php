<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Menu;

use Cms\AbstractCmsModule;
use Menu\Service\ItemManager;
use Menu\Service\LinkBuilder;
use Menu\Service\MenuWidget;
use Menu\Service\CategoryManager;
use Menu\Service\SiteService;
use Menu\Contract\MenuAwareManager;

final class Module extends AbstractCmsModule
{
    /**
     * Returns definitions for links
     * 
     * @return array
     */
    public function getLinkDefinitions()
    {
        return include(__DIR__ . '/Config/menu.links.php');
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceProviders()
    {
        $itemMapper = $this->getMapper('/Menu/Storage/MySQL/ItemMapper');
        $categoryMapper = $this->getMapper('/Menu/Storage/MySQL/CategoryMapper');

        $historyManager = $this->getHistoryManager();
        $webPageManager = $this->getWebPageManager();

        // Get excluded modules
        $config = $this->getConfig();
        $excludedModules = isset($config['exclude']) && is_array($config['exclude']) ? $config['exclude'] : array();

        return array(
            'menuWidget' => new MenuWidget($itemMapper),
            'siteService' => new SiteService($itemMapper, $categoryMapper, $webPageManager),
            'linkBuilder' => new LinkBuilder($webPageManager, $excludedModules),
            'itemManager' => new ItemManager($itemMapper, $categoryMapper, $historyManager),
            'categoryManager' => new CategoryManager($categoryMapper, $itemMapper, $historyManager)
        );
    }
}
