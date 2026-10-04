<?php

/**
 * This file is part of the Bono CMS
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Menu\Controller\Admin;

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

        return $this->view->render('category.form', [
            'category' => $category
        ]);
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

        return $this->json([
            'refresh' => true
        ]);
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
        return $this->json([
            'refresh' => true
        ]);
    }

    /**
     * Persists a category
     * 
     * @return string
     */
    public function saveAction()
    {
        $validator = $this->createValidation();

        $validator->field('category.name')
                  ->required()
                  ->addRule('minlength', null, ['min' => 2]);

        $validator->field('category.class')
                  ->required();

        if ($validator->isPassed()) {
            $input = $this->request->getPost('category');

            $historyService = $this->getService('Cms', 'historyManager');
            $service = $this->getModuleService('categoryManager');

            if (!empty($input['id'])) {
                if ($service->update($input)) {
                    $this->flashBag->set('success', 'The element has been updated successfully');

                    $historyService->write('Menu', 'Category menu "%s" has been updated', $input['name']);
                    // Save in the history
                    return $this->json([
                        'refresh' => true
                    ]);
                }

            } else {
                if ($service->add($input)) {
                    $this->flashBag->set('success', 'The element has been created successfully');

                    $historyService->write('Menu', 'Category menu "%s" has been created', $input['name']);
                    return $this->json([
                        'redirect' => $this->createUrl('Menu:Admin:Category@editAction', [$service->getLastId()]),
                    ]);
                }
            }

        } else {
            return $this->json([
                'errors' => $validator->getErrors()
            ]);
        }
    }
}