<?php

/**
 * Module configuration container
 */

return [
    'name'  => 'Menu',
    'description' => 'Menu modules allows you to easily handle different menus on your site',
    'bookmarks' => [
        [
            'name' => 'Configure menu',
            'controller' => 'Menu:Admin:Item@indexAction',
            'icon' => 'fas fa-bars'
        ]
    ],
    'menu' => [
        'name' => 'Menu',
        'icon' => 'fas fa-bars',
        'items' => [
            [
                'route' => 'Menu:Admin:Item@indexAction',
                'name' => 'View all menu items'
            ]
        ]
    ]
];