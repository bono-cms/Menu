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

use Krystal\Validate\Pattern;
use Krystal\Stdlib\VirtualEntity;

final class Category extends AbstractAdminController
{
    /**
     * Creates a form
     * 
     * @param \Krystal\Stdlib\VirtualEntity $category
     * @param string $title
     * @return string
     */
    private function createForm(VirtualEntity $category, $title)
    {
        // Append breadcrumbs
        $this->view->getBreadcrumbBag()->addOne('Menu', 'Menu:Admin:Item@indexAction')
                                       ->addOne($title);

        return $this->view->render('category.form', array(
            'category' => $category
        ));
    }

    /**
     * Renders empty form
     * 
     * @return string
     */
    public function addAction()
    {
        $category = new VirtualEntity();
        $category->setMaxDepth(5);

        return $this->createForm($category, 'Add a category');
    }

    /**
     * Renders edit form
     * 
     * @param string $id
     * @return string
     */
    public function editAction($id)
    {
        $category = $this->getCategoryManager()->fetchById($id);

        if ($category !== false) {
            $title = $this->translator->translate('Edit the category "%s"', $category->getName());
            return $this->createForm($category, $title);
        } else {
            return false;
        }
    }

    /**
     * Deletes a category by its associated id
     * 
     * @param string $id
     * @return string
     */
    public function deleteAction($id)
    {
        $historyService = $this->getService('Cms', 'historyManager');
        $category = $this->getCategoryManager()->fetchById($id);

        if ($category !== false) {
            $service = $this->getModuleService('categoryManager');
            $service->deleteById($id);

            $this->flashBag->set('success', 'Selected element has been removed successfully');

            // Save in the history
            $historyService->write('Menu', 'Category menu "%s" has been removed', $category->getName());
        }

        return '1';
    }

    /**
     * Truncates a category. Removes all attached items
     * 
     * @param int $id Category id
     * @return int
     */
    public function truncateAction($id)
    {
        $this->getModuleService('itemManager')->deleteAllByCategoryId($id);

        $this->flashBag->set('success', 'The menu category has been truncated successfully');
        return 1;
    }

    /**
     * Persists a category
     * 
     * @return string
     */
    public function saveAction()
    {
        $input = $this->request->getPost('category');

        $formValidator = $this->createValidator(array(
            'input' => array(
                'source' => $input,
                'definition' => array(
                    'name' => new Pattern\Name(),
                    'class' => new Pattern\ClassName()
                )
            )
        ));

        if ($formValidator->isValid()) {
            $historyService = $this->getService('Cms', 'historyManager');
            $service = $this->getModuleService('categoryManager');

            if (!empty($input['id'])) {
                if ($service->update($input)) {
                    $this->flashBag->set('success', 'The element has been updated successfully');

                    $historyService->write('Menu', 'Category menu "%s" has been updated', $input['name']);
                    // Save in the history
                    return '1';
                }

            } else {
                if ($service->add($input)) {
                    $this->flashBag->set('success', 'The element has been created successfully');

                    $historyService->write('Menu', 'Category menu "%s" has been created', $input['name']);
                    return $service->getLastId();
                }
            }

        } else {
            return $formValidator->getErrors();
        }
    }
}
