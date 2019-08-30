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

use Menu\Storage\CategoryMapperInterface;
use Menu\Storage\ItemMapperInterface;
use Cms\Service\AbstractManager;
use Cms\Service\HistoryManagerInterface;
use Krystal\Stdlib\VirtualEntity;

final class CategoryManager extends AbstractManager
{
    /**
     * Any mapper which implements CategoryMapperInterface
     * 
     * @var \Menu\Storage\CategoryMapperInterface
     */
    private $categoryMapper;

    /**
     * Any mapper which implements ItemMapperInterface
     * 
     * @var \Menu\Storage\ItemMapperInterface
     */
    private $itemMapper;

    /**
     * State initialization
     * 
     * @param \Menu\Storage\CategoryMapperInterface $categoryMapper
     * @param \Menu\Storage\ItemMapperInterface $itemMapper
     * @return void
     */
    public function __construct(CategoryMapperInterface $categoryMapper, ItemMapperInterface $itemMapper)
    {
        $this->categoryMapper = $categoryMapper;
        $this->itemMapper = $itemMapper;
    }

    /**
     * Fetches maximal category's depth level
     * 
     * @param string $id Category id
     * @return integer
     */
    public function fetchMaxDepthById($id)
    {
        return $this->categoryMapper->fetchMaxDepthById($id);
    }

    /**
     * Fetches the first category id
     * 
     * @return string
     */
    public function fetchFirstId()
    {
        return $this->categoryMapper->fetchFirstId();
    }

    /**
     * Fetches the last inserted id
     * 
     * @return integer
     */
    public function fetchLastId()
    {
        return $this->categoryMapper->fetchLastId();
    }

    /**
     * Fetches all category entities
     * 
     * @return array
     */
    public function fetchAll()
    {
        return $this->prepareResults($this->categoryMapper->fetchAll());
    }

    /**
     * Fetches a category bag by its associated id
     * 
     * @param string $id
     * @return array
     */
    public function fetchById($id)
    {
        return $this->prepareResult($this->categoryMapper->fetchById($id));
    }

    /**
     * Fetches unique category classes
     * 
     * @return array
     */
    public function fetchClasses()
    {
        return $this->categoryMapper->fetchClasses();
    }

    /**
     * Returns last inserted id
     * 
     * @return integer
     */
    public function getLastId()
    {
        return $this->categoryMapper->getLastId();
    }

    /**
     * {@inheritDoc}
     */
    protected function toEntity(array $category)
    {
        $entity = new VirtualEntity();
        $entity->setId($category['id'], VirtualEntity::FILTER_INT)
               ->setName($category['name'], VirtualEntity::FILTER_HTML)
               ->setClass($category['class'], VirtualEntity::FILTER_HTML)
               ->setMaxDepth($category['max_depth'], VirtualEntity::FILTER_INT);

        return $entity;
    }

    /**
     * Adds a category
     * 
     * @param array $input
     * @return boolean
     */
    public function add(array $input)
    {
        return $this->categoryMapper->insert($input);
    }

    /**
     * Updates a category
     * 
     * @param array $data
     * @return boolean
     */
    public function update(array $data)
    {
        return $this->categoryMapper->update($data);
    }

    /**
     * Deletes a category by its associated id
     * Also remove items associated with given category id
     * 
     * @param string $id
     * @return boolean Depending on success
     */
    public function deleteById($id)
    {
        return $this->categoryMapper->deleteById($id) && $this->itemMapper->deleteAllByCategoryId($id);
    }
}
