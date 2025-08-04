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
                'url' => ['/crm/customers']
            ],
            [
                'label' => 'Orders',
                'url' => ['/crm/orders']
            ],
            [
                'label' => 'Tickets',
                'url' => ['/crm/support-tickets']
            ],
            [
                'label'=> 'Reviews',
                'url'=> ['/crm/reviews']
            ]
        ],
    ],



];

return $menus;
