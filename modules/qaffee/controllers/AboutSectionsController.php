<?php

namespace qaffee\controllers;

use Yii;
use qaffee\models\AboutSections;
use qaffee\models\searches\AboutSectionsSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * AboutSectionsController implements the CRUD actions for AboutSections model.
 */
class AboutSectionsController extends DashboardController
{
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

        return $this->renderFile(
    Yii::getAlias('@app/providers/interface/views/qaffee/about-sections/index.php'),
    [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]
);

    }
    public function actionCreate()
    {
        // Yii::$app->user->can('qaffee-about-sections-create');
        $model = new AboutSections();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'AboutSections created successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }
         return $this->renderFile(
        Yii::getAlias('@app/providers/interface/views/qaffee/about-sections/create.php'),
        ['model' => $model]
    );
    }
    public function actionUpdate($id)
    {
        // Yii::$app->user->can('qaffee-about-sections-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'AboutSections updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        return $this->renderFile(
        Yii::getAlias('@app/providers/interface/views/qaffee/about-sections/update.php'),
        ['model' => $model]
    );
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
