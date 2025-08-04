<?php

namespace crm\controllers;

use Yii;
use crm\models\Customer;
use crm\models\searches\CustomerSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends DashboardController
{

    public $layout = 'main'; // corresponds to dashboard.php


    // public function getViewPath()
    // {
    //     return Yii::getAlias('@app/providers/interface/views/crm/');
    // }


    public $permissions = [
        'app-customer-list' => 'View Customer List',
        'app-customer-create' => 'Add Customer',
        'app-customer-update' => 'Edit Customer',
        'app-customer-delete' => 'Delete Customer',
        'app-customer-restore' => 'Restore Customer',
    ];
    public function actionIndex()
    {
        Yii::$app->user->can('app-customer-list');
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('app-customer-create');
        $model = new Customer();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Customer created successfully');
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
        Yii::$app->user->can('app-customer-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Customer updated successfully');
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
            Yii::$app->user->can('app-customer-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Customer has been restored');
        } else {
            Yii::$app->user->can('app-customer-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Customer has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Customer::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
