<?php

namespace andahrm\leave\controllers;

use Yii;
use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveCancel;
use andahrm\leave\models\LeaveType;
use andahrm\leave\models\LeaveSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use andahrm\structure\models\FiscalYear;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use andahrm\leave\models\PersonLeave;
use yii\helpers\Json;

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
    
    
    public function beforeAction($action)
    {
        $config = [];
        switch ($action->id) {
           55
            case 'registration':
                $config = [
                    'steps' => ['profile', 'address', 'phoneNumber', 'user'],
                    'events' => [
                        WizardBehavior::EVENT_WIZARD_STEP => [$this, $action->id.'WizardStep'],
                        WizardBehavior::EVENT_AFTER_WIZARD => [$this, $action->id.'AfterWizard'],
                        WizardBehavior::EVENT_INVALID_STEP => [$this, 'invalidStep']
                    ]
                ];
                break;
           
            case 'resume':
                $config = ['steps' => []]; // force attachment of WizardBehavior
            default:
                break;
        }

        if (!empty($config)) {
            $config['class'] = WizardBehavior::className();
            $this->attachBehavior('wizard', $config);
        }

        return parent::beforeAction($action);
    }
    

    /**
     * Lists all Leave models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LeaveSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $leaveType = LeaveType::find()->all();
        
        // foreach($leaveType as $k=> $type){
        //     $leaveType[$k]['data'] = null;
        //     $searchModel = new LeaveSearch();
        //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //     $dataProvider->query->where(['leave_type_id'=>$type->id]);
        //     $dataProvider->sort->defaultOrder = [
        //         'leave_type_id' => SORT_ASC,
        //         'created_at' => SORT_ASC
        //     ];
            
            
        //     $leaveType[$k]['data'] = $dataProvider;
        // }
        
        
        
        
        // $year=$year?$year:FiscalYear::currentYear();
        // $query = Leave::find()
        //     ->where([
        //         'created_by' => Yii::$app->user->id,
        //     ])
        //     ->andFilterWhere(['year' => $year]);
        //     //->all();
        
        
        // //$model = ArrayHelper::index($model,'leave_type_id');
        // //print_r($model);
        
        // $leaveProvider = new ActiveDataProvider([
        //     'query' => $query,
        //     // 'pagination' => [
        //     //     'pageSize' => 10,
        //     // ],
        //     // 'sort' => [
        //     //     'defaultOrder' => [
        //     //         'created_at' => SORT_DESC,
        //     //         'title' => SORT_ASC, 
        //     //     ]
        //     // ],
        //     ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //'modelLeave'=>$model
            'leaveType' => $leaveType
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
        //$model->scenario
        //print_r($model->getscenarios());

        //exit();
        if ($model->load(Yii::$app->request->post())){
            $model->status = Leave::STATUS_OFFER;
            if($model->save()) {
                Yii::$app->getSession()->setFlash('saved',[
                'type' => 'success',
                'msg' => Yii::t('andahrm/leave', 'The system successfully sent.')
            ]);
              return $this->redirect(['index']);
            }else{
              print_r($model->getErrors());
            }
        } 
        
        $confirm = $model->leave_type_id==4?'confirm':'confirm-sick';
        
        return $this->render($confirm, [
            'model' => $model,
        ]);
    }
  
  
   /**
     * Creates a new Leave model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateSick($id=null)
    {
        $model=[];
        if(!$model = Leave::findOne($id)){
          $model = new Leave();
        }
        $model->scenario = 'create-sick';

        if ($model->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post();
          
            //print_r($post);
            
            if(($model->date_start == $model->date_end) && ($model->start_part !== $model->end_part)){                   
                $model->addError('end_part',Yii::t('app','Not match! 1'));                  
            }
            
            if($model->date_start < $model->date_end){
                if(($model->start_part == Leave::HALF_DAY_MORNIG) || ($model->end_part ==  Leave::LATE_AFTERNOON)){                   
                 $model->addError('end_part',Yii::t('app','Not match! 2'));
                }
            }
            
            
            $model->number_day = Leave::calCountDays($model->date_start,$model->date_end,$model->start_part,$model->end_part);
//           print_r($model->getErrors());
//            exit();
            $model->year = FiscalYear::currentYear();
          
            if(!$model->hasErrors() && $model->save()) {
              return $this->redirect(['confirm', 'id' => $model->id]);
            }else{
              print_r($model->getErrors());
            }
        } 
            return $this->render('create-sick', [
                'model' => $model,
            ]);
    }

    
  
    /**
     * Creates a new Leave model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateVacation($id=null)
    {
        $model=[];
        if(!$model = Leave::findOne($id)){
          $model = new Leave();
        }
        
        $model->scenario = 'create-vacation';

        if ($model->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post();
          
            //print_r($post);
            /*if(!($model->start_part == Leave::ALL_DAY && $model->start_part == $model->end_part)){
              echo $model->start_part."-".$model->end_part;
                if(!($model->start_part == Leave::HALF_DAY_MORNIG && $model->end_part == Leave::ALL_DAY)){                   
                  if(!($model->start_part == Leave::LATE_AFTERNOON && $model->end_part == Leave::HALF_DAY_MORNIG)){                   
                      $model->addError('end_part','คุณเลือกตัวเลือกที่ไม่เข้ากันอยู่');                  
                  }
                }
            }*/
            
            if(($model->date_start == $model->date_end) && ($model->start_part !== $model->end_part)){                   
                $model->addError('end_part',Yii::t('app','Not match! 1'));                  
            }
            
            if($model->date_start < $model->date_end){
                if(($model->start_part == Leave::HALF_DAY_MORNIG) || ($model->end_part ==  Leave::LATE_AFTERNOON)){                   
                 $model->addError('end_part',Yii::t('app','Not match! 2'));
                }
            }
            
            
            $model->number_day = Leave::calCountDays($model->date_start,$model->date_end,$model->start_part,$model->end_part);
//           print_r($model->getErrors());
//            exit();
            $model->year = FiscalYear::currentYear();
          
            if(!$model->hasErrors() && $model->save()) {
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
        return $this->redirect(['create-'.(($model->leave_type_id==4)?'vacation':'sick'), 'id' => $model->id]);
//        if ($model->load(Yii::$app->request->post())){
//             if($model->save()) {
//               return $this->redirect(['confirm', 'id' => $model->id]);
//             }else{
//               print_r($model->getErrors());
//             }
//         } 
//             return $this->render('update', [
//                 'model' => $model,
//             ]);
        
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
    
    
    public function actionCancel($id)
    {
      
        $model = $this->findModel($id);
        $modelCancel = new LeaveCancel([
            'date_start' => $model->date_start,
            'date_end' => $model->date_end,
            'start_part' => $model->start_part,
            'end_part' => $model->end_part,
        ]);
        //$model->scenario
        //print_r($model->getscenarios());

        //exit();
        if ($modelCancel->load(Yii::$app->request->post())){
            $modelCancel->status = LeaveCancel::STATUS_OFFER;
            $modelCancel->number_day = Leave::calCountDays($modelCancel->date_start,$modelCancel->date_end,$modelCancel->start_part,$modelCancel->end_part);
            if($modelCancel->save()) {
            Yii::$app->getSession()->setFlash('saved',[
                'type' => 'success',
                'msg' => Yii::t('andahrm/leave', 'The system successfully sent.')
            ]);
              return $this->redirect(['index']);
            }else{
              print_r($modelCancel->getErrors());
            }
        } 
        
        $confirm = 'cancel-form';
        
        return $this->render($confirm, [
            'model' => $model,
            'modelCancel'=>$modelCancel
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
    
    
     public function actionPersonList($q = null) {
        // $data = PersonLeave::find()
        // ->where(['LIKE','firstname_th',$q])
        // ->orWhere(['LIKE','lastname_th',$q])
        // ->all();
        // //print_r($data);
        // $out = [];
        // foreach ($data as $d) {
        //     $out[] = [
        //       'id'=>$d->user_id ,
        //       'title' => $d->fullname
        //     ];
        // }
        // echo Json::encode(['results'=>$out]);
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $data = PersonLeave::find()
                //->select(['user_id as id','fullname as title'])
                ->where(['LIKE','firstname_th',$q])
                ->orWhere(['LIKE','lastname_th',$q])
                ->limit(20)
                //->toArray()
                ->all();
                $new = [];
                foreach ($data as $d) {
                $new[] = [
                  'id'=>$d->user_id ,
                  'text' => $d->fullname
                ];
            }
                
            $out['results'] = $new;
        }
        return $out;
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
    
    protected function findCancleModel($id)
    {
        if (($model = LeaveCancel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
