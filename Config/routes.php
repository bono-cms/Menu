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
    
    '/admin/module/menu' => array(
        'controller' => 'Admin:Item@indexAction'
    ),
    
    '/admin/module/menu/save.ajax' => array(
        'controller' => 'Admin:Item@saveAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/menu/item/add/category/(:var)/parent/(:var)' => array(
        'controller' => 'Admin:Item@addChildAction'
    ),
    
    '/admin/module/menu/item/add.ajax' => array(
        'controller' => 'Admin:Item@addAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/menu/item/view/(:var)' => array(
        'controller' => 'Admin:Item@viewAction'
    ),
    
    '/admin/module/menu/item/delete/(:var)' => array(
        'controller' => 'Admin:Item@deleteAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/menu/item/edit.ajax' => array(
        'controller' => 'Admin:Item@updateAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/menu/category/load-items.ajax' => array(
        'controller' => 'Admin:Widget@loadCategoryItemsAction',
    ),
    
    '/admin/module/menu/widget/load-empty.ajax' => array(
        'controller' => 'Admin:Widget@loadWigdetAction',
    ),
    
    '/admin/module/menu/widget/load/(:var)' => array(
        'controller' => 'Admin:Widget@loadWigdetAction',
    ),

    '/admin/module/menu/category/delete/(:var)' => array(
        'controller' => 'Admin:Category@deleteAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/menu/browse/category/(:var)' => array(
        'controller' => 'Admin:Item@categoryAction'
    ),
    
    '/admin/module/menu/category/add' => array(
        'controller' => 'Admin:Category@addAction'
    ),
    
    '/admin/module/menu/category/edit/(:var)' => array(
        'controller' => 'Admin:Category@editAction'
    ),
    
    '/admin/module/menu/category/save' => array(
        'controller' => 'Admin:Category@saveAction',
        'disallow' => array('guest')
    )
);
