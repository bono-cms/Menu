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
     * Create menu links
     * 
     * @return array
     */
    private function createLinks()
    {
        $menu = $this->moduleManager->getModule('Menu');
        $service = $this->getService('Cms', 'webPageManager');

        // Prepare links
        $items = array_replace(array(
            '#' => 'None', 
            '0' => 'Custom link'
        ), $service->createPrettyLinks($menu->getLinkDefinitions()));

        return $this->translateItems($items);
    }

    /**
     * Translate captions only
     * 
     * @param array $items Items to translate
     * @return array
     */
    private function translateItems($items)
    {
        $output = array();

        foreach ($items as $category => $item) {
            $output[$this->translator->translate($category)] = !is_array($item) ? $this->translator->translate($item) : $item;
        }

        return $output;
    }

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
                    ->load('chosen')
                    ->appendScripts(array(
                        '@Menu/nestable/jquery.nestable.js',
                        '@Menu/admin/module.menu.js'
                    ))
                    ->appendStylesheets(array(
                        '@Menu/nestable/jquery.nestable.css',
                    ));

        // Append a breadcrumb
        $this->view->getBreadcrumbBag()
                   ->addOne('Menu');

        $treeBuilder = $this->getTreeBuilder($categoryId);

        // Current maximal depth
        $maxDepth = $this->getCategoryManager()->fetchMaxDepthById($categoryId);

        return $this->view->render('browser', array(
            'links' => $this->createLinks(),
            'itemsBlock' => $treeBuilder->render(new Nestedable(), $active),
            'items'  => $treeBuilder->render(new PhpArray('name'), $active),
            'categories' => $this->getCategoryManager()->fetchAll(),
            'maxDepth' => $maxDepth,
            'helper_title' => $title,
            'item' => $item,
            'canHaveChildren' => $maxDepth > 1
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
        $input = $this->request->getPost();

        $itemManager = $this->getItemManager();
        $itemManager->add($input);

        $this->flashBag->set('success', 'An item has been created successfully!');

        $historyService = $this->getService('Cms', 'historyManager');
        $historyService->write('Menu', 'A new "%s" item has been created', $input['name']);

        return $itemManager->getLastId();
    }

    /**
     * Updates an item
     * 
     * @return string The response
     */
    public function updateAction()
    {
        $input = $this->request->getPost();

        $this->getItemManager()->update($input);
        $this->flashBag->set('success', 'An item has been updated successfully!');

        $historyService = $this->getService('Cms', 'historyManager');
        $historyService->write('Menu', 'The "%s" item has been updated', $input['name']);

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
            $historyService = $this->getService('Cms', 'historyManager');
            $historyService->write('Menu', 'Menu items have been sorted');

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
        $item = $this->getItemManager()->fetchById($id);

        if ($item !== false) {
            $historyService = $this->getService('Cms', 'historyManager');
            $historyService->write('Menu', 'The "%s" item has been removed', $item->getName());

            $this->getItemManager()->deleteById($id);
            $this->flashBag->set('success', 'The item has been removed successfully!');
        }

        return '1';
    }
}
