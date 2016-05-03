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

use Krystal\Tree\AdjacencyList\Render\PhpArray;
use Krystal\Stdlib\VirtualEntity;
use Menu\View\Nestedable;

final class Item extends AbstractAdminController
{
    /**
     * Creates a form
     * 
     * @param \Krystal\Stdlib\VirtualEntity $item
     * @param string $title
     * @param string $categoryId
     * @param string $active
     * @return string
     */
    private function createForm(VirtualEntity $item, $title, $categoryId, $active = null)
    {
        // Load view plugins
        $this->view->getPluginBag()
                    ->appendScripts(array(
                        '@Menu/nestable/jquery.nestable.js',
                        '@Cms/plugins/chosen/chosen.jquery.min.js',
                        '@Menu/admin/module.menu.js'
                    ))->appendStylesheets(array(
                        '@Menu/nestable/jquery.nestable.css',
                        '@Cms/plugins/chosen/chosen.css',
                        '@Cms/plugins/chosen/chosen-bootstrap.css'
                    ));

        // Append a breadcrumb
        $this->view->getBreadcrumbBag()
                   ->addOne('Menu');

        $treeBuilder = $this->getTreeBuilder($categoryId);

        return $this->view->render('browser', array(
            'links' => $this->getLinkBuilder()->collect(),
            'itemsBlock' => $treeBuilder->render(new Nestedable(), $active),
            'items'  => $treeBuilder->render(new PhpArray('name'), $active),
            'categories' => $this->getCategoryManager()->fetchAll(),
            'maxDepth' => $this->getCategoryManager()->fetchMaxDepthById($categoryId),
            'helper_title' => $title,
            'item' => $item
        ));
    }

    /**
     * Fetches dummy item bag
     * 
     * @param string $categoryId
     * @param string $parentId Optinal parent id
     * @return \Krystal\Stdlib\VirtualEntity
     */
    private function getDummyItemBag($categoryId, $parentId = null)
    {
        return $this->getItemManager()->fetchDummy($categoryId, $parentId);
    }

    /**
     * Shows main form, selecting parent item id
     * 
     * @param string $categoryId Current category id
     * @param string $parentId Parent item id to be selected
     * @return string
     */
    public function addChildAction($categoryId, $parentId)
    {
        $item = $this->getDummyItemBag($categoryId, $parentId);
        return $this->createForm($item, 'Add new item', $categoryId);
    }

    /**
     * Shows items and categories
     * 
     * @param string $categoryId When category id is null, then its replaced by the last one automatically
     * @return string
     */
    public function indexAction($categoryId = null)
    {
        // When its null, then we are on default page
        if (is_null($categoryId)) {
            $categoryId = $this->getCategoryManager()->fetchLastId();
        }

        if ($categoryId) {
            if (!$this->flashBag->has('success')) {
                $this->flashBag->set('info', 'Just drag and drop items the way you like. To get options, just do a right click on desired item');
            }
        }

        $item = $this->getDummyItemBag($categoryId);
        return $this->createForm($item, 'Add new item', $categoryId);
    }

    /**
     * Browses by category's id
     * 
     * @param string $Id Category id
     * @return string
     */
    public function categoryAction($id)
    {
        return $this->indexAction($id);
    }

    /**
     * Shows item data by its associated id
     * 
     * @param string $id Item id
     * @return string
     */
    public function viewAction($id)
    {
        // Try to grab item's entity
        $item = $this->getItemManager()->fetchById($id);

        if ($item !== false) {
            return $this->createForm($item, 'Edit the item', $item->getCategoryId(), $id);
        } else {
            return false;
        }
    }

    /**
     * Adds an item
     * 
     * @return string
     */
    public function addAction()
    {
        $itemManager = $this->getItemManager();

        $itemManager->add($this->request->getPost());
        $this->flashBag->set('success', 'An item has been created successfully!');

        return $itemManager->getLastId();
    }

    /**
     * Updates an item
     * 
     * @return string The response
     */
    public function updateAction()
    {
        $this->getItemManager()->update($this->request->getPost());
        $this->flashBag->set('success', 'An item has been updated successfully!');

        return '1'; 
    }

    /**
     * Saves what has been "dragged and dropped"
     * 
     * @return string
     */
    public function saveAction()
    {
        if ($this->request->hasPost('json_data')) {
            $jsonData = $this->request->getPost('json_data');

            return $this->getItemManager()->save($jsonData);
        }
    }

    /**
     * Deletes an item by its associated id and its children if has
     * 
     * @param string $id
     * @return string
     */
    public function deleteAction($id)
    {
        $this->getItemManager()->deleteById($id);
        $this->flashBag->set('success', 'The item has been removed successfully!');
        return '1';
    }
}
