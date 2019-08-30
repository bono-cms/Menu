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

use Menu\Storage\ItemMapperInterface;
use Menu\Storage\CategoryMapperInterface;
use Cms\Service\HistoryManagerInterface;
use Krystal\Tree\AdjacencyList\ChildrenJsonParser;
use Krystal\Stdlib\ArrayUtils;

final class ItemManager extends AbstractItemService implements ItemManagerInterface
{
    /**
     * Any compliant item mapper which implements ItemMapperInterface
     * 
     * @var \Menu\Storage\ItemMapperInterface
     */
    private $itemMapper;

    /**
     * Any mapper category which implements CategoryMapperInterface
     * 
     * @var \Menu\Storage\CategoryMapperInterface
     */
    private $categoryMapper;

    /**
     * State initialization
     * 
     * @param \Menu\Storage\ItemMapperInterface $itemMapper Any compliant mapper that implements this interface
     * @param \Menu\Storage\CategoryMapperInterface $categoryMapperInterface Any storage adapter that implements this interface
     * @return void
     */
    public function __construct(ItemMapperInterface $itemMapper, CategoryMapperInterface $categoryMapper)
    {
        $this->itemMapper = $itemMapper;
        $this->categoryMapper = $categoryMapper;
    }

    /**
     * Fetches item's entity by its associated id
     * 
     * @param string $id
     * @return \Krystal\Stdlib\VirtualEntity
     */
    public function fetchById($id)
    {
        return $this->prepareResult($this->itemMapper->fetchById($id));
    }

    /**
     * Fetch all items associated with given category id
     * 
     * @param string $categoryId
     * @param boolean $published Whether to filter by published attribute
     * @return array
     */
    public function fetchAllByCategoryId($categoryId, $published)
    {
        return $this->itemMapper->fetchAllByCategoryId($categoryId, $published);
    }

    /**
     * Fetches all published items associated with given category class
     * 
     * @param string $class Category class
     * @return array
     */
    public function fetchAllPublishedByCategoryClass($class)
    {
        // Get associated id
        $id = $this->categoryMapper->fetchIdByClass($class);
        return $this->fetchAllByCategoryId($id, true);
    }

    /**
     * Returns last item inserted id
     * 
     * @return integer
     */
    public function getLastId()
    {
        return $this->itemMapper->getLastId();
    }

    /**
     * Saves an order that has been dragged and dropped
     * 
     * @param string $json JSON string
     * @return boolean
     */
    public function save($json)
    {
        $parser = new ChildrenJsonParser();
        return $parser->update($json, $this->itemMapper);
    }

    /**
     * Adds an item
     * 
     * @param array $input Raw input data
     * @return boolean
     */
    public function add(array $input)
    {
        return $this->itemMapper->insert(ArrayUtils::arrayWithout($input, array('max_depth')));
    }

    /**
     * Updates an item
     * 
     * @param array $input Raw input data
     * @return boolean
     */
    public function update(array $input)
    {
        return $this->itemMapper->update(ArrayUtils::arrayWithout($input, array('max_depth')));
    }

    /**
     * Delete all items by associated category id
     * 
     * @parqm int $id Category id
     * @return boolean
     */
    public function deleteAllByCategoryId($id)
    {
        return $this->itemMapper->deleteAllByCategoryId($id);
    }

    /**
     * Deletes an item by its associated id
     * 
     * @param string $id Item's id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->itemMapper->deleteById($id) && $this->itemMapper->deleteAllByParentId($id);
    }
}
