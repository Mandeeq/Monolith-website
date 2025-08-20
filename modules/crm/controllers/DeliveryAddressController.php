<?php

namespace crm\controllers;

use Yii;
use crm\models\DeliveryAddress;
use crm\models\searches\DeliveryAddressSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * DeliveryAddressController implements the CRUD actions for DeliveryAddress model.
 */
class DeliveryAddressController extends DashboardController
{
    public $permissions = [
        'crm-delivery-address-list'=>'View DeliveryAddress List',
        'crm-delivery-address-create'=>'Add DeliveryAddress',
        'crm-delivery-address-update'=>'Edit DeliveryAddress',
        'crm-delivery-address-delete'=>'Delete DeliveryAddress',
        'crm-delivery-address-restore'=>'Restore DeliveryAddress',
        ];
    public function actionIndex()
    {
        // Yii::$app->user->can('crm-delivery-address-list');
        $searchModel = new DeliveryAddressSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('crm-delivery-address-create');
        $model = new DeliveryAddress();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'DeliveryAddress created successfully');
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
        Yii::$app->user->can('crm-delivery-address-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'DeliveryAddress updated successfully');
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
            Yii::$app->user->can('crm-delivery-address-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'DeliveryAddress has been restored');
        } else {
            Yii::$app->user->can('crm-delivery-address-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'DeliveryAddress has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = DeliveryAddress::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
