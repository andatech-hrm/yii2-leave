<?php

namespace andahrm\leave\controllers;

use Yii;
use andahrm\leave\models\LeaveRelated;
use andahrm\leave\models\LeaveRelatedPerson;
use andahrm\leave\models\LeaveRelatedSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RelatedController implements the CRUD actions for LeaveRelated model.
 */
class RelatedController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all LeaveRelated models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LeaveRelatedSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LeaveRelated model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {      
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ){
          $post = Yii::$app->request->post();
//           print_r($post);
//           exit();
          //LeaveRelatedPerson::deleteAll(['leave_related_id' => $model->id]);
          foreach($post['LeaveRelated']['persons'] as $item){
            $modelSelect = new LeaveRelatedPerson();
            $modelSelect->leave_related_id = $model->id;
            $modelSelect->user_id = $item;
            $modelSelect->save();
          }
          foreach($post['LeaveRelated']['persons'] as $item){
            $modelSelect = new LeaveRelatedPerson();
            $modelSelect->leave_related_id = $model->id;
            $modelSelect->user_id = $item;
            $modelSelect->save();
          }
          //LeaveRelatedPerson::
          
          if($model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
          }
        } 
        return $this->render('view', [
            'model' =>   $model    ,
        ]);
    }

    /**
     * Creates a new LeaveRelated model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LeaveRelated();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LeaveRelated model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LeaveRelated model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LeaveRelated model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LeaveRelated the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LeaveRelated::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
