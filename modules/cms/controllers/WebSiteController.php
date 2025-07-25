<?php

namespace cms\controllers;

use Yii;
use cms\models\Website;
use app\modules\cms\models\searches\WebsiteSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * WebSiteController implements the CRUD actions for Website model.
 */
class WebSiteController extends DashboardController
{
    public $permissions = [
        'app-web-site-list' => 'View Website List',
        'app-web-site-create' => 'Add Website',
        'app-web-site-update' => 'Edit Website',
        'app-web-site-delete' => 'Delete Website',
        'app-web-site-restore' => 'Restore Website',
    ];
    public function actionIndex()
    {
        Yii::$app->user->can('app-web-site-list');
        $searchModel = new WebsiteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('app-web-site-create');
        $model = new Website();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Website created successfully');
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
        Yii::$app->user->can('app-web-site-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Website updated successfully');
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
            Yii::$app->user->can('app-web-site-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Website has been restored');
        } else {
            Yii::$app->user->can('app-web-site-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Website has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Website::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
