<?php



$menus = [

    [
        'label' => 'Main',
        'isHeader' => true,
    ],
    [
        'label' => 'Dashboard',
        'icon' => 'fa-solid fa-house',
        'url' => ['site/index'],
        'items' => [
            ['label' => 'Admin Dashboard', 'url' => ['home/index']],
        ],
    ],
    [
        'label' => 'Customers',
        'isHeader' => true, // Used for section headers
    ],
    [
        'label' => 'Customers',
        'icon' => 'fa-solid fa-user-group',
        'url' => ['customers/index'],
    ],

    [
        'label' => 'Suppliers',
        'icon' => 'fa-solid fa-handshake',
        'url' => ['vendors/index'],
    ],

    [
        'label' => 'Invetory',
        'isHeader' => true, // Used for section headers
    ],
    [
        'label' => 'Products',
        'icon' => 'fa-brands fa-product-hunt',
        'url' => ['site/index'],
        'items' => [
            ['label' => 'Products list', 'url' => ['home/index3']],
            ['label' => 'Category', 'url' => ['role/index']],
        ],
    ],

    [
        'label' => 'Inventory',
        'icon' => 'fa-solid fa-cubes',
        'url' => ['site/index'],
    ],
    [
        'label' => 'Reports',
        'isHeader' => true,
    ],
    [
        'label' => 'Reports',
        'icon' => 'fa-solid fa-clipboard-list',
        'url' => ['site/index'],
        'items' => [
            ['label' => 'Expense Report', 'url' => ['home/index3']],
            ['label' => 'Purchase Report', 'url' => ['role/index']],
            ['label' => 'Sales Report', 'url' => ['role/index']],
        ],
    ],
    [
        'label' => 'Content (CMS)',
        'isHeader' => true, // Used for section headers
    ],
    [
        'label' => 'Pages',
        'icon' => 'fa-solid fa-file-pen',
        'url' => ['site/index'],
        'items' => [
            ['label' => 'Pages', 'url' => ['home/index3']],
            ['label' => 'Page Sections', 'url' => ['role/index']],
            ['label' => 'Media', 'url' => ['role/index']],
        ],
    ],
    [
        'label' => 'Blog',
        'icon' => 'fa-solid fa-tags',
        'url' => ['site/index'],
        'items' => [
            ['label' => 'All Blogs', 'url' => ['post/index']],
            ['label' => 'Categories', 'url' => ['category/index']],
            ['label' => 'Blog Comments', 'url' => ['comments/index']],
        ],
    ],

    [
        'label' => 'IAM',
        'isHeader' => true,
    ],

    [
        'label' => 'IAM',
        'icon' => 'fa-solid fa-shield-halved',
        'url' => ['site/index'],
        'items' => [
            ['label' => 'Users', 'url' => ['home/index3']],
            ['label' => 'Roles', 'url' => ['role/index']],
            ['label' => 'Permissions', 'url' => ['home/index3']],
        ],
    ],

    [
        'label' => 'Settings',
        'isHeader' => true, // Used for section headers
    ],

    [
        'label' => 'Settings',
        'icon' => 'fa-solid fa-gear fa-spin',
        'url' => ['site/index'],
    ],


];

return $menus;
