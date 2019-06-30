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

/**
 * This dropdown is used on site
 */
final class Dropdown extends AbstractSiteDropdown
{
    /**
     * {@inheritDoc}
     */
    protected function getChildOpener(array $row, array $parents, $active)
    {
        $li = new NodeElement();
        $li->openTag('li');

        // Is it active web page?
        if (isset($row['web_page_id']) && $row['web_page_id'] != 0 && $active != 0 && $row['web_page_id'] == $active) {
            if (isset($this->options['class']['active'])) {
                $activeClass = $this->options['class']['active'];
            } else {
                // By default "active" since this naming is kinda de-facto
                $activeClass = 'active';
            }

            $li->addAttribute('class', $activeClass);
        } else {
            // Add class item if defined
            if ($this->hasChildren($row['id'], $parents)) {
                $liClass = $this->options['class']['item_parent'];
            } else {
                $liClass = isset($this->options['class']['item']) ? $this->options['class']['item'] : null;
            }

            if ($liClass !== null) {
                $li->addAttribute('class', $liClass);
            }
        }

        $a = new NodeElement();
        $a->openTag('a')
          ->addAttribute('href', $this->makeUrl($row));

        // Whether to open in new window?
        if ((bool) $row['open_in_new_window']) {
            $a->addAttributes(array(
                'target' => '_blank',
                'rel' => 'noopener noreferrer'
            ));
        }

        if (!empty($row['hint'])) {
            $a->addAttribute('title', $row['hint']);
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
            $ul->addAttribute('class', $this->options['class']['base']);
        }

        return $ul->finalize()
                  ->render();
    }

    /**
     * {@inheritDoc}
     */
    protected function getNestedLevelParent()
    {
        $ul = new NodeElement();
        $ul->openTag('ul');

        // Check whether we have a class name
        if (isset($this->options['class']['inner'])) {
            $ul->addAttribute('class', $this->options['class']['inner']);
        }

        return $ul->finalize()
                  ->render();
    }
}
