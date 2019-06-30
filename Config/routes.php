<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

return array(
    '/%s/module/menu' => array(
        'controller' => 'Admin:Item@indexAction'
    ),
    
    '/%s/module/menu/save.ajax' => array(
        'controller' => 'Admin:Item@saveAction',
        'disallow' => array('guest')
    ),
    
    '/%s/module/menu/item/add/category/(:var)/parent/(:var)' => array(
        'controller' => 'Admin:Item@addChildAction'
    ),
    
    '/%s/module/menu/item/add.ajax' => array(
        'controller' => 'Admin:Item@addAction',
        'disallow' => array('guest')
    ),
    
    '/%s/module/menu/item/view/(:var)' => array(
        'controller' => 'Admin:Item@viewAction'
    ),
    
    '/%s/module/menu/item/delete/(:var)' => array(
        'controller' => 'Admin:Item@deleteAction',
        'disallow' => array('guest')
    ),
    
    '/%s/module/menu/item/edit.ajax' => array(
        'controller' => 'Admin:Item@updateAction',
        'disallow' => array('guest')
    ),
    
    '/%s/module/menu/category/load-items.ajax' => array(
        'controller' => 'Admin:Widget@loadCategoryItemsAction',
    ),
    
    '/%s/module/menu/widget/load-empty.ajax' => array(
        'controller' => 'Admin:Widget@loadEmptyAction',
    ),
    
    '/%s/module/menu/widget/load/(:var)' => array(
        'controller' => 'Admin:Widget@loadWigdetAction',
    ),

    '/%s/module/menu/category/delete/(:var)' => array(
        'controller' => 'Admin:Category@deleteAction',
        'disallow' => array('guest')
    ),
    
    '/%s/module/menu/category/truncate/(:var)' => array(
        'controller' => 'Admin:Category@truncateAction',
        'disallow' => array('guest')
    ),

    '/%s/module/menu/browse/category/(:var)' => array(
        'controller' => 'Admin:Item@categoryAction'
    ),
    
    '/%s/module/menu/category/add' => array(
        'controller' => 'Admin:Category@addAction'
    ),
    
    '/%s/module/menu/category/edit/(:var)' => array(
        'controller' => 'Admin:Category@editAction'
    ),
    
    '/%s/module/menu/category/save' => array(
        'controller' => 'Admin:Category@saveAction',
        'disallow' => array('guest')
    )
);
