<?php

namespace andahrm\leave\controllers;

use Yii;
use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Leave model.
 */
class DefaultController extends Controller
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
  
    public function actions()
    {
        $this->layout = 'menu-top';
    }

    /**
     * Lists all Leave models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LeaveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Leave model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    /**
     * Displays a single Leave model.
     * @param integer $id
     * @return mixed
     */
    public function actionConfirm($id)
    {
      
        $model = $this->findModel($id);
        $model->scenario = 'confirm';

        if ($model->load(Yii::$app->request->post())){
            $model->status = 1;
            if($model->save()) {
              return $this->redirect(['view', 'id' => $model->id]);
            }else{
              print_r($model->getErrors());
            }
        } 
        return $this->render('confirm', [
            'model' => $model,
        ]);
    }
  
  
   /**
     * Creates a new Leave model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateSick()
    {
        $model = new Leave();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create-sick', [
                'model' => $model,
            ]);
        }
    }

    
  
    /**
     * Creates a new Leave model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateVacation()
    {
        $model = new Leave(['scenario'=>'create-vacation']);

        if ($model->load(Yii::$app->request->post())){
            if($model->save()) {
              return $this->redirect(['confirm', 'id' => $model->id]);
            }else{
              print_r($model->getErrors());
            }
        } 
            return $this->render('create-vacation', [
                'model' => $model,
            ]);
        
    }
  
    /**
     * Creates a new Leave model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Leave();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Leave model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       if ($model->load(Yii::$app->request->post())){
            if($model->save()) {
              return $this->redirect(['confirm', 'id' => $model->id]);
            }else{
              print_r($model->getErrors());
            }
        } 
            return $this->render('update', [
                'model' => $model,
            ]);
        
    }

    /**
     * Deletes an existing Leave model.
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
     * Finds the Leave model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Leave the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Leave::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
