<?php

/**
 * This file is part of the Bono CMS
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

return [
    '/%s/module/menu' => [
        'controller' => 'Admin:Item@indexAction'
    ],
    
    '/%s/module/menu/save.ajax' => [
        'controller' => 'Admin:Item@saveAction',
        'disallow' => ['guest']
    ],
    
    '/%s/module/menu/item/add/category/(:var)/parent/(:var)' => [
        'controller' => 'Admin:Item@addChildAction'
    ],
    
    '/%s/module/menu/item/add.ajax' => [
        'controller' => 'Admin:Item@addAction',
        'disallow' => ['guest']
    ],
    
    '/%s/module/menu/item/view/(:var)' => [
        'controller' => 'Admin:Item@viewAction'
    ],
    
    '/%s/module/menu/item/delete/(:var)' => [
        'controller' => 'Admin:Item@deleteAction',
        'disallow' => ['guest']
    ],
    
    '/%s/module/menu/item/edit.ajax' => [
        'controller' => 'Admin:Item@updateAction',
        'disallow' => ['guest']
    ],
    
    '/%s/module/menu/category/load-items.ajax' => [
        'controller' => 'Admin:Widget@loadCategoryItemsAction',
    ],
    
    '/%s/module/menu/widget/load-empty.ajax' => [
        'controller' => 'Admin:Widget@loadEmptyAction',
    ],
    
    '/%s/module/menu/widget/load/(:var)' => [
        'controller' => 'Admin:Widget@loadWigdetAction',
    ],

    '/%s/module/menu/category/delete/(:var)' => [
        'controller' => 'Admin:Category@deleteAction',
        'disallow' => ['guest']
    ],
    
    '/%s/module/menu/category/truncate/(:var)' => [
        'controller' => 'Admin:Category@truncateAction',
        'disallow' => ['guest']
    ],

    '/%s/module/menu/browse/category/(:var)' => [
        'controller' => 'Admin:Item@categoryAction'
    ],
    
    '/%s/module/menu/category/add' => [
        'controller' => 'Admin:Category@addAction'
    ],
    
    '/%s/module/menu/category/edit/(:var)' => [
        'controller' => 'Admin:Category@editAction'
    ],
    
    '/%s/module/menu/category/save' => [
        'controller' => 'Admin:Category@saveAction',
        'disallow' => ['guest']
    ]
];