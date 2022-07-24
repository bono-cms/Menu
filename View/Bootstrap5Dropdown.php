<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Menu\View;

use Krystal\Form\NodeElement;

/* Special drop-down renderer made for Twitter bootstrap 4.x */
final class Bootstrap5Dropdown extends AbstractSiteDropdown
{
    /**
     * {@inheritDoc}
     */
    protected function getChildOpener(array $row, array $parents, $active)
    {
        $li = new NodeElement();
        $li->openTag('li');

        // Determine whether target id has at least one child
        $hasChildren = $this->hasChildren($row['id'], $parents);

        // Is it active web page?
        $isActive = isset($row['web_page_id']) && $row['web_page_id'] != 0 && $active != 0 && $row['web_page_id'] == $active;

        if ($hasChildren) {
            $liClass = 'nav-item dropdown';
        } else {
            $liClass = 'nav-item';
        }

        $li->addAttribute('class', $liClass);

        $a = new NodeElement();
        $a->openTag('a')
          ->addAttribute('href', $this->makeUrl($row));

        // Whether to open in new window?
        if ((bool) $row['open_in_new_window']) {
            $a->addAttribute('target', '_blank');
        }

        if (!empty($row['hint'])) {
            $a->addAttribute('title', $row['hint']);
        }

        if ($hasChildren) {
            $a->addAttributes(array(
                'class' => 'nav-link dropdown-toggle',
                'data-bs-toggle' => 'dropdown',
                'role' => 'button',
                'aria-expanded' => 'false'
            ));
        } else {
            $a->addAttribute('class', $isActive ? 'nav-link active' : 'nav-link');
        }

        $a->setText($this->createItemText($row))
          ->closeTag();

        $li->appendChild($a);

        return $li->render();
    }

    /**
     * {@inheritDoc}
     */
    protected function getParentCloser()
    {
        $ul = new NodeElement();
        $ul->closeTag('ul');

        return $ul->render();
    }

    /**
     * {@inheritDoc}
     */
    protected function getChildCloser()
    {
        $li = new NodeElement();
        $li->closeTag('li');

        return $li->render();
    }

    /**
     * {@inheritDoc}
     */
    protected function getFirstLevelParent()
    {
        $ul = new NodeElement();
        $ul->openTag('ul');

        // Check whether we have a class name
        if (isset($this->options['class']['base'])) {
            $class = $this->options['class']['base'];
        } else {
            // Use default if not provided
            $class = 'nav navbar-nav ml-auto';
        }

        return $ul->addAttribute('class', $class)
                  ->finalize()
                  ->render();
    }

    /**
     * {@inheritDoc}
     */
    protected function getNestedLevelParent()
    {
        $ul = new NodeElement();

        return $ul->openTag('ul')
                  ->addAttribute('class', 'dropdown-menu')
                  ->addAttribute('role', 'menu')
                  ->finalize()
                  ->render();
    }
}
