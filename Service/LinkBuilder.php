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
     * A collection to be rendered
     * 
     * @var array
     */
    private $collection = array();

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
     * Loads data from array of link definitions
     * 
     * @param array $definitions
     * @return void
     */
    public function loadFromDefiniton(array $definitions)
    {
        foreach ($definitions as $namespace => $caption) {
            // Add only loaded mappers
            if (class_exists($namespace)) {
                $this->collection[$namespace::getTableName()] = $caption;
            }
        }
    }

    /**
     * Extract links from registered services
     * 
     * @return array
     */
    public function collect()
    {
        $raw = $this->webPageManager->findAllLinks($this->collection);

        $collection = $this->compactModules($raw);
        $collection = $this->createNestedPair($collection);

        return $this->createResult($collection);
    }

    /**
     * Prepares processed result-set
     * 
     * @param array $data
     * @return array
     */
    private function createResult(array $data)
    {
        $result = array();

        foreach ($data as $module => $collection) {
            // Make sure a module label exists, if it doesn't, then create a new one
            if (!isset($result[$module])) {
                $result[$module] = array();
            }

            $result[$module] = $collection;
        }

        return $result;
    }

    /**
     * Compacts a raw result-set into sub-modules
     * 
     * @param array $raw Raw data that directly comes from a mapper
     * @return array Dropped array
     */
    private function compactModules(array $raw)
    {
        $result = array();

        foreach ($raw as $index => $collection) {
            // Extract module' name as a key and put the rest into its values
            $target = array($collection['module'] => $collection);

            foreach ($target as $module => $array) {
                // When doesn't exist, then need to create a one
                if (!isset($result[$module])) {
                    $result[$module] = array();
                }

                $result[$module][] = $array;
            }
        }

        return $result;
    }

    /**
     * Appends data into nested dropped array using a visitor
     * 
     * @param array $data
     * @return array
     */
    private function createNestedPair(array $data)
    {
        $result = array();

        foreach ($data as $module => $options) {
            foreach ($options as $index => $collection) {
                // If $data has something, then we'd start processing its block
                if (!empty($collection)) {
                    if (!isset($result[$module])) {
                        $result[$module] = array();
                    }

                    // Assign visitor's returned value
                    $result[$module][] = $collection;
                }
            }
        }

        return $result;
    }
}
