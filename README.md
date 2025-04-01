Menu module
===========
This module offers a seamless way to manage multiple menus on your site. It allows you to effortlessly create, organize, and customize menus, ensuring a smooth and intuitive navigation experience for users.

# Render menus
First of all, create a category and populate it with menu items in the administration panel. Later, render the menu on your website using the built-in `\Menu\View\Dropdown` widget and the globally available `$menu` service.

Basic example:

    <?php
    
    use Menu\View\Dropdown;
    
    ?>
    
    <nav>
      <?= $menu->renderByClass('my-menu', $page->getWebPageId(), new Dropdown([
        'class' => [
           'liClass' => 'li-example-class',
           'active' => 'li-example-active-class',
           'item_parent' => 'li-example-parent-class',
           'a' => 'a-example-class',
           'base' => 'ul-parent-base-example-class',
           'inner' => 'ul-inner-class-example'
        ]
      ])); ?>
    </nav>



# Available methods

## Render entire menu by class name
The method `renderByClass()` has the following signature:

    \Menu\Service\SiteService::renderByClass($class, $active = null, $widget)

Renders menu block by provided category class. If you want current item to be marked as active, then you need to provide an id of that element. In most cases, you can simply pass `$page->getWebPageId()`or you can pass `null` to omit rendering active class.


## Render entire menu tree by current item
The signature is the following:

    \Menu\Service\SiteService::renderByAssocWebPageId($id)

Renders a whole category's block by associated web page id. As in example above you should pass a web page id.

Basic example:

    <nav>
	    <?= $menu->renderByAssocWebPageId($page->getWebPageId()); ?>
    </nav>

## Render category name by class

The signature is the following:

     \Menu\Service\SiteService::getCategoryNameByClass($class)
    
Returns category name by its associated class.

Basic example:

    <nav>
        <h4><?= $menu->getCategoryNameByClass('my-menu'); ?></h4>
    </nav>