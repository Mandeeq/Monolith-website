<?php

namespace qaffee\controllers;

use Yii;
use qaffee\models\MenuCategories;
use qaffee\models\searches\MenuCategorieSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * MenuCategoriesController implements the CRUD actions for MenuCategories model.
 */
class MenuCategoriesController extends DashboardController
{
    public $permissions = [
        'qaffee-menu-categories-list'=>'View MenuCategories List',
        'qaffee-menu-categories-create'=>'Add MenuCategories',
        'qaffee-menu-categories-update'=>'Edit MenuCategories',
        'qaffee-menu-categories-delete'=>'Delete MenuCategories',
        'qaffee-menu-categories-restore'=>'Restore MenuCategories',
        ];
        public function getViewPath(){
        return '@ui/views/qaffee/menu-categories';
            
        }
    public function actionIndex()
    {
        Yii::$app->user->can('qaffee-menu-categories-list');
        $searchModel = new MenuCategorieSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('qaffee-menu-categories-create');
        $model = new MenuCategories();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'MenuCategories created successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }
        if ($this->request->isAjax) {
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
        Yii::$app->user->can('qaffee-menu-categories-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'MenuCategories updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        if ($this->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }else{ return $this->render('update', [
            'model' => $model,
        ]);}
       
    }
    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        if ($model->is_deleted) {
            Yii::$app->user->can('qaffee-menu-categories-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'MenuCategories has been restored');
        } else {
            Yii::$app->user->can('qaffee-menu-categories-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'MenuCategories has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = MenuCategories::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
