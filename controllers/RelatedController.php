<?php

namespace andahrm\leave\controllers;

use Yii;
use andahrm\leave\models\LeaveRelated;
use andahrm\leave\models\LeaveRelatedApprover;
use andahrm\leave\models\LeaveRelatedInspector;
use andahrm\leave\models\LeaveRelatedCommander;
use andahrm\leave\models\LeaveRelatedDirector;
use andahrm\leave\models\LeaveRelatedPerson;
use andahrm\leave\models\LeaveRelatedSection;
use andahrm\leave\models\LeaveRelatedSearch;

use yii\data\ActiveDataProvider;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use beastbytes\wizard\WizardBehavior;

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

        //$query = Post::find()->where(['status' => 1]);
        $config=[];
        $config['pagination'] =  [
                'pageSize' => 10,
            ];
         $config['sort'] = [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,                    
                ]
        ];
      
         $inspectorProvider = new ActiveDataProvider([
            'query' => LeaveRelatedInspector::find()->where(['leave_related_id' => $model->id]),
            'pagination'=>$config['pagination'],
            'sort'=>$config['sort'],
        ]);
      
         $commanderProvider = new ActiveDataProvider([
            'query' => LeaveRelatedCommander::find()->where(['leave_related_id' => $model->id]),
            'pagination'=>$config['pagination'],
            'sort'=>$config['sort'],
        ]);
      
         $directorProvider = new ActiveDataProvider([
            'query' => LeaveRelatedDirector::find()->where(['leave_related_id' => $model->id]),
            'pagination'=>$config['pagination'],
            'sort'=>$config['sort'],
        ]);
      
      
        $personProvider = new ActiveDataProvider([
            'query' => LeaveRelatedPerson::find()->where(['leave_related_id' => $model->id]),
            'pagination'=>$config['pagination'],
            'sort'=>$config['sort'],
        ]);
      
      
        return $this->render('view', [
            'model' => $model,
            //'searchModel' => $searchModel,
            'inspectorProvider' => $inspectorProvider,
            'commanderProvider' => $commanderProvider,
            'directorProvider' => $directorProvider,
            'personProvider' => $personProvider,
        ]);
   
    }
  
  public function actionAssign($id)
    {
      $model = $this->findModel($id);
      $model->scenario = 'assign';
      
      if ($model->load(Yii::$app->request->post()) ){
          $post = Yii::$app->request->post();
//           print_r($post);
//           exit();
        if(isset($post['LeaveRelated']['persons'])&&!empty($post['LeaveRelated']['persons'])){
              LeaveRelatedPerson::deleteAll(['leave_related_id' => $model->id]);
              foreach($post['LeaveRelated']['persons'] as $item){
                $modelSelect = LeaveRelatedPerson::findOne(['user_id'=>$item]);
                if(!$modelSelect){
                  $modelSelect = new LeaveRelatedPerson();
                  $modelSelect->leave_related_id = $model->id;
                  $modelSelect->user_id = $item;
                  $modelSelect->save();
                }else{
                  $modelSelect->leave_related_id = $model->id;
                  $modelSelect->save();
                }
              }   
          }
          
          if($model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
          }
        } 
       $config=[];
        $config['pagination'] =  [
                'pageSize' => 10,
            ];
         $config['sort'] = [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,                    
                ]
        ];
      
         $inspectorProvider = new ActiveDataProvider([
            'query' => LeaveRelatedInspector::find()->where(['leave_related_id' => $model->id]),
            'pagination'=>$config['pagination'],
            'sort'=>$config['sort'],
        ]);
      
         $commanderProvider = new ActiveDataProvider([
            'query' => LeaveRelatedCommander::find()->where(['leave_related_id' => $model->id]),
            'pagination'=>$config['pagination'],
            'sort'=>$config['sort'],
        ]);
      
         $directorProvider = new ActiveDataProvider([
            'query' => LeaveRelatedDirector::find()->where(['leave_related_id' => $model->id]),
            'pagination'=>$config['pagination'],
            'sort'=>$config['sort'],
        ]);
      
      
      
      
      
        return $this->render('assign', [
            'model' => $model,
            'inspectorProvider' => $inspectorProvider,
            'commanderProvider' => $commanderProvider,
            'directorProvider' => $directorProvider,
        ]);
    }

    /**
     * Creates a new LeaveRelated model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

    
        $model = new LeaveRelated(['scenario'=>'insert']);
        $modelSection = new LeaveRelatedSection();

        if ($model->load(Yii::$app->request->post())){
          
          $post = Yii::$app->request->post();
          
           $transaction = \Yii::$app->db->beginTransaction();
          $flag = true;
            try {
                
                if ($flag = $model->save()) {
                  
                    if(isset($post['LeaveRelated']['inspectors'])){
                        //LeaveRelatedInspector::deleteAll(['leave_related_id' => $model->id]);
                        foreach($post['LeaveRelated']['inspectors'] as $item){
                              $modelSelect = new LeaveRelatedInspector();
                              $modelSelect->leave_related_id = $model->id;
                              $modelSelect->user_id = $item;
                              if (($flag = $modelSelect->save(false)) === false) {
                                  $transaction->rollBack();
                                  break;
                              }
                         }
                  }
                  
                  if(isset($post['LeaveRelated']['commanders'])){
                        //LeaveRelatedCommander::deleteAll(['leave_related_id' => $model->id]);
                      foreach($post['LeaveRelated']['commanders'] as $item){
                            $modelSelect = new LeaveRelatedCommander();
                            $modelSelect->leave_related_id = $model->id;
                            $modelSelect->user_id = $item;
                            $modelSelect->save();
                       }
                  }
                  
                  if(isset($post['LeaveRelated']['directors'])){
                        //LeaveRelatedDirector::deleteAll(['leave_related_id' => $model->id]);
                        foreach($post['LeaveRelated']['directors'] as $item){
                                $modelSelect = new LeaveRelatedDirector();
                                $modelSelect->leave_related_id = $model->id;
                                $modelSelect->user_id = $item;
                                if (($flag = $modelSelect->save(false)) === false) {
                                    $transaction->rollBack();
                                    break;
                                }
                           }
                   }
                   
                   if(isset($post['LeaveRelatedSection']['section_id'])){
                        LeaveRelatedSection::deleteAll(['leave_related_id' => $model->id]);
                        foreach($post['LeaveRelatedSection']['section_id'] as $item){
                                $modelSelect = new LeaveRelatedSection();
                                $modelSelect->leave_related_id = $model->id;
                                $modelSelect->section_id = $item;
                                if (($flag = $modelSelect->save(false)) === false) {
                                    $transaction->rollBack();
                                    break;
                                }
                           }
                   }
                  
                  
                }else{
                  print_r($model->getErrors());
                }
              
              
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        } 
      
      
        return $this->render('create', [
            'model' => $model,
            'modelSection'=>$modelSection
        ]);
        
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
        $model->scenario = 'update';
        
        $modelSection = new LeaveRelatedSection();
      if ($model->load(Yii::$app->request->post())){
          
          $post = Yii::$app->request->post();
//         print_r($post);
//         exit();
          
           $transaction = \Yii::$app->db->beginTransaction();
          $flag = true;
            try {
                
                if ($flag = $model->save()) {
                  
                  if(isset($post['LeaveRelated']['inspectors'])){
                        LeaveRelatedInspector::deleteAll(['leave_related_id' => $model->id]);
                        foreach($post['LeaveRelated']['inspectors'] as $item){
                              $modelSelect = new LeaveRelatedInspector();
                              $modelSelect->leave_related_id = $model->id;
                              $modelSelect->user_id = $item;
                              if (($flag = $modelSelect->save(false)) === false) {
                                  $transaction->rollBack();
                                  break;
                              }
                         }
                  }
                  
                  if(isset($post['LeaveRelated']['commanders'])){
                        LeaveRelatedCommander::deleteAll(['leave_related_id' => $model->id]);
                      foreach($post['LeaveRelated']['commanders'] as $item){
                            $modelSelect = new LeaveRelatedCommander();
                            $modelSelect->leave_related_id = $model->id;
                            $modelSelect->user_id = $item;
                            $modelSelect->save();
                       }
                  }
                  
                  if(isset($post['LeaveRelated']['directors'])){
                        LeaveRelatedDirector::deleteAll(['leave_related_id' => $model->id]);
                        foreach($post['LeaveRelated']['directors'] as $item){
                                $modelSelect = new LeaveRelatedDirector();
                                $modelSelect->leave_related_id = $model->id;
                                $modelSelect->user_id = $item;
                                if (($flag = $modelSelect->save(false)) === false) {
                                    $transaction->rollBack();
                                    break;
                                }
                           }
                   }
                  
                  if(isset($post['LeaveRelatedSection']['section_id'])){
                        LeaveRelatedSection::deleteAll(['leave_related_id' => $model->id]);
                        foreach($post['LeaveRelatedSection']['section_id'] as $item){
                                $modelSelect = new LeaveRelatedSection();
                                $modelSelect->leave_related_id = $model->id;
                                $modelSelect->section_id = $item;
                                if (($flag = $modelSelect->save(false)) === false) {
                                    $transaction->rollBack();
                                    break;
                                }
                           }
                   }
                  
                  
                }else{
                  print_r($model->getErrors());
                }
              
              
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        } 
      
        
        return $this->render('update', [
            'model' => $model,
            'modelSection'=>$modelSection
        ]);
        
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
