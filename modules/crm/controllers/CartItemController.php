<?php

namespace crm\controllers;

use Yii;
use crm\models\CartItems;
use crm\models\searches\CartItemSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * CartItemController implements the CRUD actions for CartItems model.
 */
class CartItemController extends DashboardController
{
    public $permissions = [
        'crm-cart-item-list'=>'View CartItems List',
        'crm-cart-item-create'=>'Add CartItems',
        'crm-cart-item-update'=>'Edit CartItems',
        'crm-cart-item-delete'=>'Delete CartItems',
        'crm-cart-item-restore'=>'Restore CartItems',
        ];
    public function actionIndex()
    {
        Yii::$app->user->can('crm-cart-item-list');
        $searchModel = new CartItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('crm-cart-item-create');
        $model = new CartItems();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'CartItems created successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionUpdate($id)
    {
        Yii::$app->user->can('crm-cart-item-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'CartItems updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        if ($model->is_deleted) {
            Yii::$app->user->can('crm-cart-item-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'CartItems has been restored');
        } else {
            Yii::$app->user->can('crm-cart-item-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'CartItems has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = CartItems::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
