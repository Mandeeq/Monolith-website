<?php

namespace qaffee\controllers;

use Yii;
use qaffee\models\FoodMenus;
use qaffee\models\searches\MenuSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * MenusController implements the CRUD actions for FoodMenus model.
 */
class MenusController extends DashboardController
{
    public $permissions = [
        'qaffee-menus-list'=>'View FoodMenus List',
        'qaffee-menus-create'=>'Add FoodMenus',
        'qaffee-menus-update'=>'Edit FoodMenus',
        'qaffee-menus-delete'=>'Delete FoodMenus',
        'qaffee-menus-restore'=>'Restore FoodMenus',
        ];
        public function getViewPath(){
        return '@ui/views/qaffee/menu';    
        }
    public function actionIndex()
    {
        Yii::$app->user->can('qaffee-menus-list');
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        Yii::$app->user->can('qaffee-menus-create');
        $model = new FoodMenus();
        
        if ($this->request->isPost) {
            // Correct order: Get the file instance FIRST
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    // Check if an image was uploaded and upload it
                    if ($model->imageFile && !$model->uploadImage()) {
                        Yii::$app->session->setFlash('error', 'Failed to upload image.');
                        return $this->render('create', ['model' => $model]);
                    }
                    
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'FoodMenus created successfully');
                        return $this->redirect(['index']);
                    } else {
                        Yii::$app->session->setFlash('error', 'Failed to save model.');
                    }
                }
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
        Yii::$app->user->can('qaffee-menus-update');
        $model = $this->findModel($id);
        $oldImage = $model->image;

        if ($this->request->isPost) {
            // Correct order: Get the file instance FIRST
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    // Check if a new image was uploaded
                    if ($model->imageFile) {
                        // Delete old image if it exists and a new one is uploaded
                        if ($oldImage && file_exists(Yii::getAlias('@webroot') . $oldImage)) {
                            unlink(Yii::getAlias('@webroot') . $oldImage);
                        }
                        if (!$model->uploadImage()) {
                            Yii::$app->session->setFlash('error', 'Failed to upload new image.');
                            return $this->render('update', ['model' => $model]);
                        }
                    } else {
                        // No new image uploaded, keep the old path
                        $model->image = $oldImage;
                    }

                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'FoodMenus updated successfully');
                        return $this->redirect(['index']);
                    } else {
                        Yii::$app->session->setFlash('error', 'Failed to save model.');
                    }
                }
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
            Yii::$app->user->can('qaffee-menus-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'FoodMenus has been restored');
        } else {
            Yii::$app->user->can('qaffee-menus-delete');
            if ($model->image && file_exists(Yii::getAlias('@webroot') . $model->image)) {
                unlink(Yii::getAlias('@webroot') . $model->image);
            }
            $model->delete();
            Yii::$app->session->setFlash('success', 'FoodMenus has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = FoodMenus::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}