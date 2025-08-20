<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Create permissions
        $list = $auth->createPermission('qaffee-about-sections-list');
        $list->description = 'View AboutSections List';
        $auth->add($list);

        $create = $auth->createPermission('qaffee-about-sections-create');
        $create->description = 'Add AboutSections';
        $auth->add($create);

        // Assign to role
        $role = $auth->getRole('admin'); 
        $auth->addChild($role, $list);
        $auth->addChild($role, $create);

        echo "RBAC permissions created successfully.\n";
    }
}
