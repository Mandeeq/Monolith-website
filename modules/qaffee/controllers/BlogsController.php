<?php

namespace qaffee\controllers;

use Yii;
use qaffee\models\Blogs;
use qaffee\models\searches\BlogsSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
/**
 * BlogsController implements the CRUD actions for Blogs model.
 */
class BlogsController extends DashboardController
{
    public function getViewPath()
    {
        return Yii::getAlias('@app/providers/interface/views/qaffee/blogs');
    }
    public $permissions = [
        'qaffee-blogs-list' => 'View Blogs List',
        'qaffee-blogs-create' => 'Add Blogs',
        'qaffee-blogs-update' => 'Edit Blogs',
        'qaffee-blogs-delete' => 'Delete Blogs',
        'qaffee-blogs-restore' => 'Restore Blogs',
    ];
    public function actionIndex()
    {
        // Yii::$app->user->can('qaffee-blogs-list');
        $searchModel = new BlogsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }
   public function actionCreate()
    {
        if (!Yii::$app->user->can('qaffee-blogs-create')) {
            throw new ForbiddenHttpException('You are not allowed to create blogs.');
        }

        $model = new Blogs();

        if ($this->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile && !$model->uploadImage()) {
                Yii::$app->session->setFlash('error', 'Failed to upload image.');
                return $this->render('create', ['model' => $model]);
            }

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Blogs created successfully');
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
        if (!Yii::$app->user->can('qaffee-blogs-update')) {
            throw new ForbiddenHttpException('You are not allowed to update blogs.');
        }

        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile && !$model->uploadImage()) {
                Yii::$app->session->setFlash('error', 'Failed to upload image.');
                return $this->render('update', ['model' => $model]);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'blog updated successfully');
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
            // Yii::$app->user->can('qaffee-blogs-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Blogs has been restored');
        } else {
            // Yii::$app->user->can('qaffee-blogs-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Blogs has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Blogs::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
