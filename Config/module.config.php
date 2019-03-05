<?php

/**
 * Module configuration container
 */

return array(
    'name'  => 'Menu',
    'description' => 'Menu modules allows you to easily handle different menus on your site',
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