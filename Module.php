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

        $webPageManager = $this->getWebPageManager();

        return array(
            'menuWidget' => new MenuWidget($itemMapper),
            'siteService' => new SiteService($itemMapper, $categoryMapper, $webPageManager),
            'itemManager' => new ItemManager($itemMapper, $categoryMapper),
            'categoryManager' => new CategoryManager($categoryMapper, $itemMapper)
        );
    }
}
