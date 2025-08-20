<?php

namespace crm\controllers;

use Yii;
use crm\models\Reviews;
use crm\models\searches\ReviewSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * ReviewsController implements the CRUD actions for Reviews model.
 */
class ReviewsController extends DashboardController
{
    public $permissions = [
        'app-reviews-list'=>'View Reviews List',
        'app-reviews-create'=>'Add Reviews',
        'app-reviews-update'=>'Edit Reviews',
        'app-reviews-delete'=>'Delete Reviews',
        'app-reviews-restore'=>'Restore Reviews',
        ];
    public function actionIndex()
    {
        // Yii::$app->user->can('app-reviews-list');
        $searchModel = new ReviewSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('app-reviews-create');
        $model = new Reviews();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Reviews created successfully');
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
        Yii::$app->user->can('app-reviews-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Reviews updated successfully');
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
            Yii::$app->user->can('app-reviews-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Reviews has been restored');
        } else {
            Yii::$app->user->can('app-reviews-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Reviews has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Reviews::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
