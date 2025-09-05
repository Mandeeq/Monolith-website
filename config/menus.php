<?php
require_once __DIR__ . '/wrapper.php';
$userMenu = [
    ['title' => 'Dashboard', 'icon' => 'home', 'url' => 'home/index'],
       ['title' => 'Menus', 'icon' => 'book-open', 'submenus' => [
        ['title' => 'Menu Items', 'url' => '/qaffee/menus/index'],         
        ['title' => 'Menu Categories', 'url' => '/qaffee/menu-categories/index'], 
    ]],
      ['title' => 'Gallery', 'icon' => 'image', 'url' => 'gallery/index'],
    ['title' => 'About Us', 'icon' => 'info-circle', 'url' => 'about/index'],
    ['title' => 'Contact Us', 'icon' => 'address-book', 'url' => 'contact/index'],
    ['title' => 'IAM & Admin', 'icon' => 'shield', 'submenus' => [
        ['title' => 'User Management', 'url' => 'accounts/index'],
        ['title' => 'Manage Roles', 'url' => 'role/index'],
        ['title' => 'Manage Permissions', 'url' => '/dashboard/permission/index'],
        ['title' => 'Manage Rules', 'url' => 'rule/index'],
    ]],


];
return $userMenu;
