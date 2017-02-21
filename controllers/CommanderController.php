<?php

namespace andahrm\leave\controllers;

use Yii;
use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveCancel;
use andahrm\leave\models\LeaveCommanderSearch;
use andahrm\leave\models\LeaveCommanderCancelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CommanderController extends \yii\web\Controller
{
  
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
        $searchModel = new LeaveCommanderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $searchModelCancel = new LeaveCommanderCancelSearch();
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    

    /**
     * Updates an existing Leave model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionConsider($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'commander';

        if ($model->load(Yii::$app->request->post())){
              $post = Yii::$app->request->post();
          
              if(isset($post['allow'])){
                  $model->commander_status = LeaveCancel::ALLOW;
                  $model->status = LeaveCancel::STATUS_CONSIDER; #ส่งไปให้ผู้ตัวตรว
              }elseif(isset($post['disallow'])){
                  $model->commander_status = LeaveCancel::DISALLOW;
                  $model->status = LeaveCancel::STATUS_DISALLOW; #ไม่อนุมัติ
              }
              
              $model->commander_at= time();
          
          if($model->save()) {
              //return $this->redirect(['view', 'id' => $model->id]);
              return $this->redirect(['index']);
          } 
        } 
      
            return $this->render('consider', [
                'model' => $model,
            ]);
        
    }
    
    
    
    /**
     * Displays a single Leave model.
     * @param integer $id
     * @return mixed
     */
    public function actionCancelView($id)
    {
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
    public function actionCancelConsider($id)
    {
        $model = $this->findCancleModel($id);
        $model->scenario = 'commander';

        if ($model->load(Yii::$app->request->post())){
              $post = Yii::$app->request->post();
          
              if(isset($post['allow'])){
                  $model->commander_status = 1;
              }elseif(isset($post['disallow'])){
                  $model->commander_status = 0;
                  $model->status = Leave::STATUS_DISALLOW; #ไม่อนุมัติ
              }
              $model->status = Leave::STATUS_OFFER; #ส่งไปให้ผู้ตัวตรว
              $model->commander_at= time();
          
          if($model->save()) {
              //return $this->redirect(['view', 'id' => $model->id]);
              Yii::$app->getSession()->setFlash('saved',[
                'type' => 'success',
                'msg' => Yii::t('andahrm/leave', 'The system successfully sent.')
            ]);
              return $this->redirect(['index']);
          } 
        } 
      
            return $this->render('cancel-consider', [
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
    protected function findModel($id)
    {
        if (($model = Leave::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findCancleModel($id)
    {
        if (($model = LeaveCancel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
