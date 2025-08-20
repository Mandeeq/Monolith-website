<?php

namespace crm\controllers;

use Yii;
use crm\models\Customers;
use crm\models\searches\CustomerSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * CustomersController implements the CRUD actions for Customers model.
 */
class CustomersController extends DashboardController
{
    public $permissions = [
        'app-customers-list'=>'View Customers List',
        'app-customers-create'=>'Add Customers',
        'app-customers-update'=>'Edit Customers',
        'app-customers-delete'=>'Delete Customers',
        'app-customers-restore'=>'Restore Customers',
        ];
    public function actionIndex()
    {
        // Yii::$app->user->can('app-customers-list');
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('app-customers-create');
        $model = new Customers();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Customers created successfully');
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
    }else{
        return $this->render('create', [
            'model' => $model,
        ]);
    }
        
    }
    public function actionUpdate($id)
    {
        Yii::$app->user->can('app-customers-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Customers updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
            'model' => $model,
            ]);
        } else {
            return $this->render('update', [
            'model' => $model,
            ]);
        }
    }
    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        if ($model->is_deleted) {
            Yii::$app->user->can('app-customers-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Customers has been restored');
        } else {
            Yii::$app->user->can('app-customers-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Customers has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Customers::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
