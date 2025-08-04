<?php

namespace crm\controllers;

use Yii;
use crm\models\Order;
use crm\models\searches\OrderrSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends DashboardController
{
    public $layout = 'main'; // corresponds to dashboard.php
    public $permissions = [
        'crm-order-list' => 'View Order List',
        'crm-order-create' => 'Add Order',
        'crm-order-update' => 'Edit Order',
        'crm-order-delete' => 'Delete Order',
        'crm-order-restore' => 'Restore Order',
    ];
    public function actionIndex()
    {
        // Yii::$app->user->can('crm-order-list');
        $searchModel = new OrderrSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('crm-order-create');
        $model = new Order();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Order created successfully');
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
        Yii::$app->user->can('crm-order-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Order updated successfully');
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
            Yii::$app->user->can('crm-order-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Order has been restored');
        } else {
            Yii::$app->user->can('crm-order-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Order has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
