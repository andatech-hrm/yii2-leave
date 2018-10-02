<?php

namespace andahrm\leave\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
###
use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveCancel;
use andahrm\leave\models\LeaveDirectorSearch;
use andahrm\leave\models\LeaveDirectorCancelSearch;

/**
 * DirectorController implements the CRUD actions for Leave model.
 */
class LeavePresidentSearch extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions() {
        $this->layout = 'menu-top';
    }

    /**
     * Lists all Leave models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new LeaveDirectorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $searchModelCancel = new LeaveDirectorCancelSearch();
        $dataProviderCancel = $searchModelCancel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'searchModelCancel' => $searchModelCancel,
                    'dataProviderCancel' => $dataProviderCancel,
        ]);
    }

    /**
     * Displays a single Leave model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionConsider($id) {
        $model = $this->findModel($id);
        $model->scenario = Leave::SCENARIO_DIRECTOR;

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            if (isset($post['allow'])) {
                $model->director_status = 1;
                $model->status = Leave::STATUS_ALLOW; #พิจารณา
            } elseif (isset($post['disallow'])) {
                $model->director_status = 0;
                $model->status = Leave::STATUS_DISALLOW; #ไม่อนุมัติ
            }

            $model->director_at = time();

            if ($model->save()) {
                //return $this->redirect(['view', 'id' => $model->id]);
                return $this->redirect(['index']);
            }
        }

        return $this->render('consider', [
                    'model' => $model,
        ]);
    }

    /**
     * Finds the Leave model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Leave the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Leave::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Displays a single Leave model.
     * @param integer $id
     * @return mixed
     */
    public function actionCancelView($id) {
        return $this->render('cancel-view', [
                    'model' => $this->findCancleModel($id),
        ]);
    }

    /**
     * Updates an existing Leave model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCancelConsider($id) {
        $model = $this->findCancleModel($id);
        $model->scenario = LeaveCancel::SCENARIO_DIRECTOR;

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            //   print_r($post);
            //   exit();

            if (isset($post['allow'])) {
                $model->director_status = LeaveCancel::ALLOW;
                $model->status = LeaveCancel::STATUS_ALLOW; #ส่งไปให้ผู้ตัวตรว
            } elseif (isset($post['disallow'])) {
                $model->director_status = LeaveCancel::DISALLOW;
                $model->status = LeaveCancel::STATUS_DISALLOW; #ไม่อนุมัติ
            }

            $model->director_at = time();

            if ($model->validate() && $model->save()) {
                //return $this->redirect(['view', 'id' => $model->id]);
                Yii::$app->getSession()->setFlash('saved', [
                    'type' => 'success',
                    'msg' => Yii::t('andahrm/leave', 'The system successfully sent.')
                ]);
                return $this->redirect(['index']);
            } else {
                print_r($model->getErrors());
            }
        }

        return $this->render('cancel-consider', [
                    'model' => $model,
        ]);
    }

    protected function findCancleModel($id) {
        if (($model = LeaveCancel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
