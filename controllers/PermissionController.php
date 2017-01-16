<?php

namespace andahrm\leave\controllers;

use Yii;
use andahrm\leave\models\LeavePermission;
use andahrm\leave\models\LeavePermissionSearch;
use andahrm\leave\models\PersonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PermissionController implements the CRUD actions for LeavePermission model.
 */
class PermissionController extends Controller
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
     * Lists all LeavePermission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LeavePermissionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LeavePermission model.
     * @param integer $user_id
     * @param integer $leave_condition_id
     * @param string $year
     * @return mixed
     */
    public function actionView($user_id, $leave_condition_id, $year)
    {
        return $this->render('view', [
            'model' => $this->findModel($user_id, $leave_condition_id, $year),
        ]);
    }

    /**
     * Creates a new LeavePermission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LeavePermission(['scenario'=>'create']);

        
     
        if ($model->load(Yii::$app->request->post())){
          $post = Yii::$app->request->post();
          $post = $post['LeavePermission'];
//           print_r($post);
//           exit();
          $flag = true;
          
         foreach($post['user_id'] as $key => $item){
           $newModel = [];
           
           if($newModel = LeavePermission::find()->where(['year'=>$model->year,'user_id'=>$item])->one()){
             $newModel->number_day = $post['number_day'][$key];
           }else{ 
             $newModel = new LeavePermission(['scenario'=>'insert']);
             $newModel->user_id = $item;
             $newModel->year = $model->year;
             $newModel->number_day = $post['number_day'][$key];
           }
            if(!$newModel->save()){
              $flag = false;
            }
         }
          
          
         if($flag)
            return $this->redirect(['index']);          
        }
      
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      
            return $this->render('create', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        
    }

    /**
     * Updates an existing LeavePermission model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $user_id
     * @param integer $leave_condition_id
     * @param string $year
     * @return mixed
     */
    public function actionUpdate($user_id, $leave_condition_id, $year)
    {
        $model = $this->findModel($user_id, $leave_condition_id, $year);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_id' => $model->user_id, 'leave_condition_id' => $model->leave_condition_id, 'year' => $model->year]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LeavePermission model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $user_id
     * @param integer $leave_condition_id
     * @param string $year
     * @return mixed
     */
    public function actionDelete($user_id, $leave_condition_id, $year)
    {
        $this->findModel($user_id, $leave_condition_id, $year)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LeavePermission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $user_id
     * @param integer $leave_condition_id
     * @param string $year
     * @return LeavePermission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $leave_condition_id, $year)
    {
        if (($model = LeavePermission::findOne(['user_id' => $user_id, 'leave_condition_id' => $leave_condition_id, 'year' => $year])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
