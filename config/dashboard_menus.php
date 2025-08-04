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
    ],
    [
        'label' => 'Customers',
        'isHeader' => true, // Used for section headers
    ],
    [
        'label' => 'CRM',
        'icon' => 'fa-solid fa-users',
        'items' => [
            [
                'label' => 'Customers',
                'url' => ['/crm/customer']
            ],
            [
                'label' => 'Orders',
                'url' => ['/crm/order']
            ],
            [
                'label' => 'Tickets',
                'url' => ['/crm/support-ticket']
            ],
            [
                'label'=> 'Order History',
                'url'=> ['/crm/order-history']
            ]
        ],
    ],



];

return $menus;
