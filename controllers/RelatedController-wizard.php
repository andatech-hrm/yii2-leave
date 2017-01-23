<?php

namespace andahrm\leave\controllers;

use Yii;
use andahrm\leave\models\LeaveRelated as title;
use andahrm\leave\models\LeaveRelatedApprover as approve;
use andahrm\leave\models\LeaveRelatedPerson as assign;
use andahrm\leave\models\LeaveRelatedSearch;
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
  
  
  public function beforeAction($action)
    {
        $config = [];
        switch ($action->id) {
            
            case 'create':
                $config = [
                    'steps' => ['ตั้งชื่อชุด'=>'LeaveRelated', 'LeaveRelatedApprover', 'LeaveRelatedPerson'],
                    'events' => [
                        WizardBehavior::EVENT_WIZARD_STEP => [$this, $action->id.'WizardStep'],
                        WizardBehavior::EVENT_AFTER_WIZARD => [$this, $action->id.'AfterWizard'],
                        WizardBehavior::EVENT_INVALID_STEP => [$this, 'invalidStep']
                    ]
                ];
                break;
            
               
        }

        if (!empty($config)) {
            $config['class'] = WizardBehavior::className();
            $this->attachBehavior('wizard', $config);
        }

        return parent::beforeAction($action);
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LeaveRelated model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($step = null)
    {
        if ($step===null) $this->resetWizard();
        return $this->step($step);
    
    
//         $model = new LeaveRelated();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
    }
  
  
  public function createWizardStep($event)
    {
        if (empty($event->stepData)) {
            $modelName = 'andahrm\\leave\\models\\'.ucfirst($event->step);
            $model = new $modelName();
        } else {
            $model = $event->stepData;
        }
        echo $model->className();
//       echo "<pre>";
//         print_r($event);
//       echo "oo";
//       exit();
        $post = Yii::$app->request->post();
        if (isset($post['cancel'])) {
            $event->continue = false;
        } elseif (isset($post['prev'])) {
            $event->nextStep = WizardBehavior::DIRECTION_BACKWARD;
            $event->handled  = true;
        } elseif ($model->load($post) && $model->validate()) {
//           print_r($post);
//           exit();
            $event->data    = $model;
            $event->handled = true;

            if (isset($post['pause'])) {
                $event->continue = false;
            } elseif ($event->n < 2 && isset($post['add'])) {
                $event->nextStep = WizardBehavior::DIRECTION_REPEAT;
            }
        } else {
            $event->data = $this->render($event->step, compact('event', 'model'));
        }
    }
  
  
    /**
    * @param WizardEvent The event
    */
    public function invalidStep($event)
    {
        $event->data = $this->render('invalidStep', compact('event'));
        $event->continue = false;
    }

    /**
    * Registration wizard has ended; the reason can be determined by the
    * step parameter: TRUE = wizard completed, FALSE = wizard did not start,
    * <string> = the step the wizard stopped at
    * @param WizardEvent The event
    */
    public function createAfterWizard($event)
    {
        if (is_string($event->step)) {
            $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );

            $registrationDir = Yii::getAlias('@runtime/registration');
            $registrationDirReady = true;
            if (!file_exists($registrationDir)) {
                if (!mkdir($registrationDir) || !chmod($registrationDir, 0775)) {
                    $registrationDirReady = false;
                }
            }
            if ($registrationDirReady && file_put_contents(
                $registrationDir.DIRECTORY_SEPARATOR.$uuid,
                $event->sender->pauseWizard()
            )) {
                $event->data = $this->render('registration/paused', compact('uuid'));
            } else {
                $event->data = $this->render('registration/notPaused');
            }
        } elseif ($event->step === null) {
            $event->data = $this->render('registration/cancelled');
        } elseif ($event->step) {
            $event->data = $this->render('registration/complete', [
                'data' => $event->stepData
            ]);
        } else {
            $event->data = $this->render('registration/notStarted');
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
