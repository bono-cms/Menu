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

use Krystal\Stdlib\ArrayUtils;
use Krystal\Application\Module\ModuleManagerInterface;
use Menu\Contract\MenuAwareManager;
use Cms\Service\WebPageManagerInterface;
use Closure;

final class LinkBuilder implements LinkBuilderInterface
{
    /**
     * Web page manager
     * 
     * @var \Cms\Service\WebPageManagerInterface
     */
    private $webPageManager;

    /**
     * State initialization
     * 
     * @param \Cms\Service\WebPageManagerInterface $webPageManager
     * @return void
     */
    public function __construct(WebPageManagerInterface $webPageManager)
    {
        $this->webPageManager = $webPageManager;
    }

    /**
     * Extract links from registered services
     * 
     * @param array $definitions
     * @return array
     */
    public function collect(array $definitions)
    {
        $collection = array();

        foreach ($definitions as $namespace => $caption) {
            // Add only loaded mappers
            if (class_exists($namespace)) {
                $collection[$namespace::getTableName()] = $caption;
            }
        }

        $raw = $this->webPageManager->findAllLinks($collection);
        return ArrayUtils::arrayDropdown($raw, 'module', 'id', 'title');
    }
}
