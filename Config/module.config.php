<?php

/**
 * Module configuration container
 */

return array(
    'name'  => 'Menu',
    'description' => 'Menu modules allows you to easily handle different menus on your site',
    // Bookmarks of this module
    'bookmarks' => array(
        array(
            'name' => 'Configure menu',
            'controller' => 'Menu:Admin:Item@indexAction',
            'icon' => 'fas fa-bars'
        )
    ),
    'menu' => array(
        'name' => 'Menu',
        'icon' => 'fas fa-bars',
        'items' => array(
            array(
                'route' => 'Menu:Admin:Item@indexAction',
                'name' => 'View all menu items'
            )
        )
    )
);