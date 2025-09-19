<?php

namespace qaffee\controllers;

use Yii;
use qaffee\models\AboutSections;
use qaffee\models\searches\AboutSectionsSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;

/**
 * AboutSectionsController implements the CRUD actions for AboutSections model.
 */
class AboutSectionsController extends DashboardController
{

    public function getViewPath()
    {
        return Yii::getAlias('@app/providers/interface/views/qaffee/about-sections');
    }
    public $permissions = [
        'qaffee-about-sections-list'=>'View AboutSections List',
        'qaffee-about-sections-create'=>'Add AboutSections',
        'qaffee-about-sections-update'=>'Edit AboutSections',
        'qaffee-about-sections-delete'=>'Delete AboutSections',
        'qaffee-about-sections-restore'=>'Restore AboutSections',
        ];
    public function actionIndex()
    {
        // Yii::$app->user->can('qaffee-about-sections-list');
        $searchModel = new AboutSectionsSearch();
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
        // Yii::$app->user->can('qaffee-about_section-create');
         

        $model = new AboutSections ();

        if ($this->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile && !$model->uploadImage()) {
                Yii::$app->session->setFlash('error', 'Failed to upload image.');
                return $this->render('create', ['model' => $model]);
            }

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'image created successfully');
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
        if (!Yii::$app->user->can('qaffee-about_section-update')) {
            throw new ForbiddenHttpException('You are not allowed to update image.');
        }

        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile && !$model->uploadImage()) {
                Yii::$app->session->setFlash('error', 'Failed to upload image.');
                return $this->render('update', ['model' => $model]);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'image updated successfully');
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
            // Yii::$app->user->can('qaffee-about-sections-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'AboutSections has been restored');
        } else {
            // Yii::$app->user->can('qaffee-about-sections-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'AboutSections has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = AboutSections::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
