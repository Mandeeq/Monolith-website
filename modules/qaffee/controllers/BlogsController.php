<?php

namespace qaffee\controllers;

use Yii;
use qaffee\models\Blogs;
use qaffee\models\searches\BlogsSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * BlogsController implements the CRUD actions for Blogs model.
 */
class BlogsController extends DashboardController
{
    public $permissions = [
        'qaffee-blogs-list'=>'View Blogs List',
        'qaffee-blogs-create'=>'Add Blogs',
        'qaffee-blogs-update'=>'Edit Blogs',
        'qaffee-blogs-delete'=>'Delete Blogs',
        'qaffee-blogs-restore'=>'Restore Blogs',
        ];
    public function actionIndex()
    {
        // Yii::$app->user->can('qaffee-blogs-list');
        $searchModel = new BlogsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

               return $this->renderFile(
    Yii::getAlias('@app/providers/interface/views/qaffee/blogs/index.php'),
    [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]
);
    }
    public function actionCreate()
    {
        // Yii::$app->user->can('qaffee-blogs-create');
        $model = new Blogs();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Blogs created successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->renderFile(
        Yii::getAlias('@app/providers/interface/views/qaffee/blogs/create.php'),
        ['model' => $model]
    );
    }
    public function actionUpdate($id)
    {
        // Yii::$app->user->can('qaffee-blogs-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Blogs updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        return $this->renderFile(
        Yii::getAlias('@app/providers/interface/views/qaffee/blogs/update.php'),
        ['model' => $model]
    );
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
