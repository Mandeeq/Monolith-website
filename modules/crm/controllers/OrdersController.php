<?php

namespace crm\controllers;

use Yii;
use crm\models\Orders;
use crm\models\searches\OrderSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends DashboardController
{
    public $permissions = [
        'crm-orders-list'=>'View Orders List',
        'crm-orders-create'=>'Add Orders',
        'crm-orders-update'=>'Edit Orders',
        'crm-orders-delete'=>'Delete Orders',
        'crm-orders-restore'=>'Restore Orders',
        ];
    public function actionIndex()
    {
        // Yii::$app->user->can('crm-orders-list');
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('crm-orders-create');
        $model = new Orders();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Orders created successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        Yii::$app->user->can('crm-orders-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Orders updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        if ($model->is_deleted) {
            Yii::$app->user->can('crm-orders-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Orders has been restored');
        } else {
            Yii::$app->user->can('crm-orders-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Orders has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
