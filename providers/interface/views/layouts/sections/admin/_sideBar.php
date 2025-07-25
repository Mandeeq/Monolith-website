<?php

use yii\widgets\Menu;
use yii\helpers\Url;

$menuConfig = require Yii::getAlias('@config/dashboard_menus.php');
?>

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <?= Menu::widget([
                'items' => array_map(function ($item) {
                    if (!empty($item['isHeader'])) {
                        return [
                            'label' => "<span>{$item['label']}</span>",
                            'options' => ['class' => 'menu-title']
                        ];
                    }

                    $hasSubmenu = isset($item['items']) && !empty($item['items']);
                    $url = isset($item['url']) ? Url::to($item['url']) : '#';

                    $item['template'] = '<a href="' . $url . '">
                                <i class="' . ($item['icon'] ?? '') . '"></i> 
                                <span>' . $item['label'] . '</span>' .
                        ($hasSubmenu ? '<span class="menu-arrow"></span>' : '') .
                        '</a>';

                    if ($hasSubmenu) {
                        $item['options'] = ['class' => 'submenu'];
                    }

                    return $item;
                }, $menuConfig),
                'options' => ['class' => 'sidebar-vertical'],
                'submenuTemplate' => "\n<ul style='display: none'>\n{items}\n</ul>\n",
                'encodeLabels' => false,
                'activateParents' => true,
                'itemOptions' => ['class' => ''],
                'activeCssClass' => 'active',
            ]) ?>
        </div>
    </div>
</div>

<?php
$this->registerCss("
.sidebar-menu ul {
    list-style: none !important; /* Removes bullets */
    padding: 0;
    margin: 0;
}

.sidebar-menu li {
    list-style: none !important; /* Ensures no dots */
    padding: 0;
    margin: 0;
}

.submenu > ul {
    display: none; /* Ensure submenus are hidden initially */
}
");
$this->registerJs("
   $(document).on('click', '.sidebar-menu a', function(e) {
    var link = $(this).attr('href');
    var parentItem = $(this).closest('li');
    var hasSubmenu = $(this).find('.menu-arrow').length > 0;

    // Only prevent default if it's a submenu parent with no valid URL
    if (hasSubmenu && (link === '#' || link === 'javascript:void(0)')) {
        e.preventDefault();
        $(this).next('ul').slideToggle();
    }
    // Otherwise, allow navigation
});
");


?>