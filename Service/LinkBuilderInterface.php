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

use Menu\Contract\MenuAwareManager;

interface LinkBuilderInterface
{
    /**
     * Extract links from registered services
     * 
     * @param array $definitions
     * @return array
     */
    public function collect(array $definitions);
}
