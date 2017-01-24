<?php

namespace andahrm\leave\controllers;

use Yii;
use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveDirectorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DirectorController implements the CRUD actions for Leave model.
 */
class DirectorController extends Controller
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
        $searchModel = new LeaveDirectorSearch();
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
  
  
    public function actionConsider($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'director';

        if ($model->load(Yii::$app->request->post())){
              $post = Yii::$app->request->post();
          
              if(isset($post['allow'])){
                $model->director_status = 1;
                $model->status = Leave::STATUS_ALLOW; #พิจารณา
              }elseif(isset($post['disallow'])){
                $model->director_status = 0;
                $model->status = Leave::STATUS_DISALLOW; #ไม่อนุมัติ
              }
              
              $model->director_at= time();
          
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
