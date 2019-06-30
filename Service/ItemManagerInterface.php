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

/**
 * API for ItemManager service
 */
interface ItemManagerInterface
{
    /**
     * Fetches dummy menu item's entity
     * 
     * @param string $categoryId
     * @param string $parentId
     * @return \Krystal\Stdlib\VirtualEntity
     */
    public function fetchDummy($categoryId = null, $parentId = null);

    /**
     * Saves an order that has been dragged and dropped
     * 
     * @param string $json JSON string
     * @return boolean
     */
    public function save($json);

    /**
     * Fetch all items associated with given category id
     * 
     * @param string $categoryId
     * @param boolean $published Whether to filter by published attribute
     * @return array
     */
    public function fetchAllByCategoryId($categoryId, $published);

    /**
     * Fetches all published items associated with given category class
     * 
     * @param string $class Category class
     * @return array
     */
    public function fetchAllPublishedByCategoryClass($class);

    /**
     * Returns last item inserted id
     * 
     * @return integer
     */
    public function getLastId();

    /**
     * Adds an item
     * 
     * @param array $form Form data
     * @return boolean
     */
    public function add(array $form);

    /**
     * Updates an item
     * 
     * @param array $data
     * @return boolean
     */
    public function update(array $data);

    /**
     * Delete all items by associated category id
     * 
     * @parqm int $id Category id
     * @return boolean
     */
    public function deleteAllByCategoryId($id);

    /**
     * Deletes an item by its associated id
     * 
     * @param string $id Item id
     * @return boolean
     */
    public function deleteById($id);

    /**
     * Fetches an item bag by its associated id
     * 
     * @param string $id
     * @return object
     */
    public function fetchById($id);
}
