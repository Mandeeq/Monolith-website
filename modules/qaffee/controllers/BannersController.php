<?php

namespace qaffee\controllers;

use Yii;
use qaffee\models\Banners;
use qaffee\models\searches\BannersSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;

/**
 * BannersController implements the CRUD actions for Banners model.
 */
class BannersController extends DashboardController
{
    public function getViewPath()
    {
        return Yii::getAlias('@app/providers/interface/views/qaffee/banners');
    }

    public $permissions = [
        'qaffee-banners-list'   => 'View Banners List',
        'qaffee-banners-create' => 'Add Banners',
        'qaffee-banners-update' => 'Edit Banners',
        'qaffee-banners-delete' => 'Delete Banners',
        'qaffee-banners-restore'=> 'Restore Banners',
    ];

    public function actionIndex()
    {
        if (!Yii::$app->user->can('qaffee-banners-list')) {
            throw new ForbiddenHttpException('You are not allowed to view this page.');
        }

        $searchModel  = new BannersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        if (!Yii::$app->user->can('qaffee-banners-create')) {
            throw new ForbiddenHttpException('You are not allowed to create banners.');
        }

        $model = new Banners();

        if ($this->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile && !$model->uploadImage()) {
                Yii::$app->session->setFlash('error', 'Failed to upload image.');
                return $this->render('create', ['model' => $model]);
            }

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Banner created successfully');
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }
        if ($this->request->isAjax) {
            return $this->renderAjax('create', ['model' => $model]);
        } else {
          

        return $this->render('create', ['model' => $model]);
        }
    }

    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('qaffee-banners-update')) {
            throw new ForbiddenHttpException('You are not allowed to update banners.');
        }

        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile && !$model->uploadImage()) {
                Yii::$app->session->setFlash('error', 'Failed to upload image.');
                return $this->render('update', ['model' => $model]);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Banner updated successfully');
                return $this->redirect(['index']);
            }
        }
        if ($this->request->isAjax) {
            return $this->renderAjax('update', ['model' => $model]);
        } else {
            return $this->render('update', ['model' => $model]);    

        }
    }

    public function actionTrash($id)
    {
        $model = $this->findModel($id);

        if ($model->is_deleted) {
            if (!Yii::$app->user->can('qaffee-banners-restore')) {
                throw new ForbiddenHttpException('You are not allowed to restore banners.');
            }
            $model->restore();
            Yii::$app->session->setFlash('success', 'Banner has been restored');
        } else {
            if (!Yii::$app->user->can('qaffee-banners-delete')) {
                throw new ForbiddenHttpException('You are not allowed to delete banners.');
            }
            $model->delete();
            Yii::$app->session->setFlash('success', 'Banner has been deleted');
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Banners::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested banner does not exist.');
    }
}
