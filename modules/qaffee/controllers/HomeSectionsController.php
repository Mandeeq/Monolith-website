<?php

namespace qaffee\controllers;

use Yii;
use qaffee\models\HomeSections;
use qaffee\models\searches\HomeSectionsSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * HomeSectionsController implements the CRUD actions for HomeSections model.
 */
class HomeSectionsController extends DashboardController
{
    public $permissions = [
        'qaffee-home-sections-list'=>'View HomeSections List',
        'qaffee-home-sections-create'=>'Add HomeSections',
        'qaffee-home-sections-update'=>'Edit HomeSections',
        'qaffee-home-sections-delete'=>'Delete HomeSections',
        'qaffee-home-sections-restore'=>'Restore HomeSections',
        ];
    public function actionIndex()
    {
        // Yii::$app->user->can('qaffee-home-sections-list');
        $searchModel = new HomeSectionsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->renderFile(
    Yii::getAlias('@app/providers/interface/views/qaffee/home-sections/index.php'),
    [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]
);


      
    }
    public function actionCreate()
    {
        Yii::$app->user->can('qaffee-home-sections-create');
        $model = new HomeSections();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'HomeSections created successfully');
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
        Yii::$app->user->can('qaffee-home-sections-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'HomeSections updated successfully');
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
            Yii::$app->user->can('qaffee-home-sections-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'HomeSections has been restored');
        } else {
            Yii::$app->user->can('qaffee-home-sections-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'HomeSections has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = HomeSections::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
