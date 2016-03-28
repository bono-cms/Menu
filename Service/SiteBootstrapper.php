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

use Cms\Service\AbstractSiteBootstrapper;

final class SiteBootstrapper extends AbstractSiteBootstrapper
{
    /**
     * {@inheritDoc}
     */
    public function bootstrap()
    {
        $homeWebPageId = $this->moduleManager->getModule('Pages')->getService('pageManager')->getDefaultWebPageId();
        $this->view->addVariable('menu', $this->createSiteService($homeWebPageId));
    }

    /**
     * Returns menu's block service
     * 
     * @param string $homeWebPageId $homeWebPageId
     * @return \Menu\Service\Block
     */
    private function createSiteService($homeWebPageId)
    {
        $block = $this->moduleManager->getModule('Menu')->getService('siteService');
        $block->setHomeWebPageId($homeWebPageId);

        return $block;
    }
}
