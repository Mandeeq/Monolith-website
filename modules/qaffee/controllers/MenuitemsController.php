<?php

namespace qaffee\controllers;

use Yii;
use qaffee\models\Menu_items;
use qaffee\models\searches\Menu_itemsSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * Menu_itemsController implements the CRUD actions for Menu_items model.
 */
class MenuitemsController extends DashboardController
{
    public $permissions = [
        'qaffee-menu-items-list'=>'View Menu_items List',
        'qaffee-menu-items-create'=>'Add Menu_items',
        'qaffee-menu-items-update'=>'Edit Menu_items',
        'qaffee-menu-items-delete'=>'Delete Menu_items',
        'qaffee-menu-items-restore'=>'Restore Menu_items',
        ];
    public function actionIndex()
    {
        // Yii::$app->user->can('qaffee-menu-items-list');
        $searchModel = new Menu_itemsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

               return $this->renderFile(
    Yii::getAlias('@app/providers/interface/views/qaffee/menu_items/index.php'),
    [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]
);
    }
    public function actionCreate()
    {
        // Yii::$app->user->can('qaffee-menu-items-create');
        $model = new Menu_items();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Menu_items created successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }
       return $this->renderFile(
        Yii::getAlias('@app/providers/interface/views/qaffee/menu_items/update.php'),
        ['model' => $model]
    );
    }
    public function actionUpdate($id)
    {
        // Yii::$app->user->can('qaffee-menu-items-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Menu_items updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        return $this->renderFile(
        Yii::getAlias('@app/providers/interface/views/qaffee/menu_items/update.php'),
        ['model' => $model]
    );
    }
    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        if ($model->is_deleted) {
            // Yii::$app->user->can('qaffee-menu-items-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Menu_items has been restored');
        } else {
            // Yii::$app->user->can('qaffee-menu-items-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Menu_items has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Menu_items::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
