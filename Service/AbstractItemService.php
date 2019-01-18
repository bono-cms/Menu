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

use Cms\Service\AbstractManager;
use Krystal\Stdlib\VirtualEntity;
use Krystal\Security\Filter;

abstract class AbstractItemService extends AbstractManager
{
    /**
     * {@inheritDoc}
     */ 
    protected function toEntity(array $item)
    {
        $entity = new VirtualEntity();
        $entity->setId($item['id'], VirtualEntity::FILTER_INT)
            ->setParentId($item['parent_id'], VirtualEntity::FILTER_INT)
            ->setCategoryId($item['category_id'], VirtualEntity::FILTER_INT)
            ->setWebPageId($item['web_page_id'], VirtualEntity::FILTER_INT)
            ->setName($item['name'], VirtualEntity::FILTER_HTML)
            ->setLink($item['link'], VirtualEntity::FILTER_HTML)
            ->setHasLink($item['has_link'], VirtualEntity::FILTER_BOOL)
            ->setHint($item['hint'], VirtualEntity::FILTER_HTML)
            ->setIcon($item['icon'], VirtualEntity::FILTER_HTML)
            ->setOpenInNewWindow($item['open_in_new_window'], VirtualEntity::FILTER_BOOL)
            ->setPublished($item['published'], VirtualEntity::FILTER_BOOL);

        return $entity;
    }

    /**
     * Fetches dummy menu item's entity
     * 
     * @param string $categoryId
     * @param string $parentId
     * @return \Krystal\Stdlib\VirtualEnity
     */
    public function fetchDummy($categoryId = null, $parentId = null)
    {
        $item = new VirtualEntity();
        $item->setCategoryId($categoryId)
             ->setParentId($parentId)
             ->setHasLink(false)
             ->setPublished(true)
             ->setOpenInNewWindow(false);

        return $item;
    }
}
