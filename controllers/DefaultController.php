<?php

namespace andahrm\leave\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use andahrm\setting\models\Helper;
use beastbytes\wizard\WizardBehavior;
###
use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveCancel;
use andahrm\leave\models\LeaveType;
use andahrm\leave\models\LeaveSearch;
use andahrm\leave\models\LeavePermission;
use andahrm\structure\models\FiscalYear;
use andahrm\leave\models\PersonLeave;
use andahrm\leave\models\Draft;
use andahrm\leave\models\LeaveDraft;

/**
 * DefaultController implements the CRUD actions for Leave model.
 */
class DefaultController extends Controller {

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

    public function beforeAction($action) {
        $config = [];
        switch ($action->id) {
            case 'create':
                $config = [
                    'steps' => [
                        Yii::t('andahrm/leave', 'Select Type') => 'select',
                        Yii::t('andahrm/leave', 'Draft Form') => 'draft',
                        Yii::t('andahrm/leave', 'Confirm') => 'confirm',
                    ],
                    'events' => [
                        WizardBehavior::EVENT_WIZARD_STEP => [$this, $action->id . 'WizardStep'],
                        WizardBehavior::EVENT_AFTER_WIZARD => [$this, $action->id . 'AfterWizard'],
                        WizardBehavior::EVENT_INVALID_STEP => [$this, 'invalidStep']
                    ]
                ];
                break;

            case 'resume':
                $config = ['steps' => []]; // force attachment of WizardBehavior
                break;
            default:
                break;
        }

        if (!empty($config)) {
            $config['class'] = WizardBehavior::className();
            $config['sessionKey'] = 'Wizard-Leave';
            $this->attachBehavior('wizard', $config);
        }

        return parent::beforeAction($action);
    }

    /**
     * Lists all Leave models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new LeaveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $leaveType = LeaveType::find()->all();
        $leavePermission = LeavePermission::getPermission();

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    //'modelLeave'=>$model
                    'leaveType' => $leaveType,
                    'leavePermission' => $leavePermission,
        ]);
    }

    /**
     * Displays a single Leave model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);

        return $this->render('view', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new Leave model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateSick($id = null) {
        $model = [];
        if (!$model = Leave::findOne($id)) {
            $model = new Leave(['user_id' => Yii::$app->user->identity->id]);
        }
        $model->scenario = 'create-sick';

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            //print_r($post);

            if (($model->date_start == $model->date_end) && ($model->start_part !== $model->end_part)) {
                $model->addError('end_part', Yii::t('app', 'Not match! 1'));
            }

            if ($model->date_start < $model->date_end) {
                if (($model->start_part == Leave::HALF_DAY_MORNIG) || ($model->end_part == Leave::LATE_AFTERNOON)) {
                    $model->addError('end_part', Yii::t('app', 'Not match! 2'));
                }
            }


            $model->number_day = Leave::calCountDays($model->date_start, $model->date_end, $model->start_part, $model->end_part);
//           print_r($model->getErrors());
//            exit();
            $model->year = FiscalYear::currentYear();

            if (!$model->hasErrors() && $model->save()) {
                return $this->redirect(['confirm', 'id' => $model->id]);
            } else {
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
    public function actionCreateVacation($id = null) {
        $model = [];
        if (!$model = Leave::findOne($id)) {
            $model = new Leave();
        }

        $model->scenario = 'create-vacation';

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            //print_r($post);
            /* if(!($model->start_part == Leave::ALL_DAY && $model->start_part == $model->end_part)){
              echo $model->start_part."-".$model->end_part;
              if(!($model->start_part == Leave::HALF_DAY_MORNIG && $model->end_part == Leave::ALL_DAY)){
              if(!($model->start_part == Leave::LATE_AFTERNOON && $model->end_part == Leave::HALF_DAY_MORNIG)){
              $model->addError('end_part','คุณเลือกตัวเลือกที่ไม่เข้ากันอยู่');
              }
              }
              } */

            if (($model->date_start == $model->date_end) && ($model->start_part !== $model->end_part)) {
                $model->addError('end_part', Yii::t('app', 'Not match! 1'));
            }

            if ($model->date_start < $model->date_end) {
                if (($model->start_part == Leave::HALF_DAY_MORNIG) || ($model->end_part == Leave::LATE_AFTERNOON)) {
                    $model->addError('end_part', Yii::t('app', 'Not match! 2'));
                }
            }


            $model->number_day = Leave::calCountDays(Helper::dateUi2Db($model->date_start), Helper::dateUi2Db($model->date_end), $model->start_part, $model->end_part);
//           print_r($model->getErrors());
//            exit();
            $model->year = FiscalYear::currentYear();

            if (!$model->hasErrors() && $model->save()) {
                return $this->redirect(['confirm', 'id' => $model->id]);
            } else {
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
    // public function actionCreate()
    // {
    //     $model = new Leave();
    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         return $this->render('create', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    /**
     * Updates an existing Leave model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->leave_type_id == 1) {
            $model->scenario = Leave::SCENA_UPDATE_VACATION;
        } elseif ($model->leave_type_id) {
            $model->scenario = Leave::SCENA_UPDATE_SICK;
        }

        //return $this->redirect(['create-'.(($model->leave_type_id==4)?'vacation':'sick'), 'id' => $model->id]);
        if ($model->load(Yii::$app->request->post())) {
            $model->number_day = Leave::calCountDays(Helper::dateUi2Db($model->date_start), Helper::dateUi2Db($model->date_end), $model->start_part, $model->end_part);
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('saved', [
                    'type' => 'success',
                    'msg' => Yii::t('andahrm/leave', 'The system successfully sent.')
                ]);
                return $this->redirect(['index']);
            } else {
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
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCancel($id) {

        $model = $this->findModel($id);
        $modelCancel = new LeaveCancel([
            'leave_id' => $model->id,
            'date_start' => $model->date_start,
            'date_end' => $model->date_end,
            'start_part' => $model->start_part,
            'end_part' => $model->end_part,
            'commander_by' => $model->commander_by,
            'director_by' => $model->director_by
        ]);
        //$model->scenario
        //print_r($model->getscenarios());
        //exit();
        if ($modelCancel->load(Yii::$app->request->post())) {
            $modelCancel->status = LeaveCancel::STATUS_OFFER;
            $modelCancel->number_day = Leave::calCountDays($modelCancel->date_start, $modelCancel->date_end, $modelCancel->start_part, $modelCancel->end_part);
            if ($modelCancel->save()) {
                Yii::$app->getSession()->setFlash('saved', [
                    'type' => 'success',
                    'msg' => Yii::t('andahrm/leave', 'The system successfully sent.')
                ]);
                return $this->redirect(['index']);
            } else {
                print_r($modelCancel->getErrors());
            }
        }

        //$confirm = 'cancel-form';

        return $this->render('cancel-form', [
                    'model' => $model,
                    'modelCancel' => $modelCancel
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
                    ->where(['LIKE', 'firstname_th', $q])
                    ->orWhere(['LIKE', 'lastname_th', $q])
                    ->limit(20)
                    //->toArray()
                    ->all();
            $new = [];
            foreach ($data as $d) {
                $new[] = [
                    'id' => $d->user_id,
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
    public function actionCancelView($id) {
        return $this->render('cancel-view', [
                    'model' => $this->findCancleModel($id),
        ]);
    }

    protected function findCancleModel($id) {
        if (($model = LeaveCancel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    ###########################################################
    ###########################################################
    ###########################################################

    public function actionCreate($step = null) {
        // print_r(Yii::$app->session);
        // exit();
        //if ($step===null) $this->resetWizard();

        if ($step == 'reset')
            $this->resetWizard();
        return $this->step($step);
    }

    /**
     * Process wizard steps.
     * The event handler must set $event->handled=true for the wizard to continue
     * @param WizardEvent The event
     */
    public function createWizardStep($event) {

        //print_r(Yii::$app->request->get());

        if (empty($event->stepData)) {
            $modelName = 'andahrm\leave\models\\' . ucfirst($event->step);
            $model = new $modelName();
            $model->scenario = 'insert';
        } else {
            $model = $event->stepData;
        }

        $post = Yii::$app->request->post();

        if (isset($post['cancel'])) {
            $event->continue = false;
        } elseif (isset($post['prev'])) {
            $event->nextStep = WizardBehavior::DIRECTION_BACKWARD;
            $event->handled = true;
        } elseif ($model->load($post) && $model->validate()) {




            $event->data = $model;
            $event->handled = true;

            if (isset($post['pause'])) {
                $event->continue = false;
            } elseif ($event->n < 2 && isset($post['add'])) {
                $event->nextStep = WizardBehavior::DIRECTION_REPEAT;
            }

            if ($post) {
//                print_r($post);
//                exit();
            }
        } else {
            if ($model->getErrors()) {
                // echo "DefaultController : ";
                // print_r($model->getErrors());
                //exit();
            }

            $event->data = $this->render('wizard/' . $event->step, compact('event', 'model'));
        }
    }

    /**
     * @param WizardEvent The event
     */
    public function invalidStep($event) {
        $event->data = $this->render('wizard/invalidStep', compact('event'));
        $event->continue = false;
        return $this->redirect(['create']);
    }

    /**
     * Registration wizard has ended; the reason can be determined by the
     * step parameter: TRUE = wizard completed, FALSE = wizard did not start,
     * <string> = the step the wizard stopped at
     * @param WizardEvent The event
     */
    public function createAfterWizard($event) {
        if (is_string($event->step)) {
            $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );

            $registrationDir = Yii::getAlias('@runtime/wizard/leave');
            $registrationDirReady = true;
            if (!file_exists($registrationDir)) {
                if (!mkdir($registrationDir) || !chmod($registrationDir, 0775)) {
                    $registrationDirReady = false;
                }
            }
            if ($registrationDirReady && file_put_contents(
                            $registrationDir . DIRECTORY_SEPARATOR . $uuid, $event->sender->pauseWizard()
                    )) {
                $event->data = $this->render('wizard/paused', compact('uuid'));
            } else {
                $event->data = $this->render('wizard/notPaused');
            }
        } elseif ($event->step === null) {
            $event->data = $this->render('wizard/cancelled');
        } elseif ($event->step) {



            $model = $event->stepData['draft'][0];
            $modelConfirm = $event->stepData['confirm'][0];
            // print_r($model);
            // exit();
            if ($model) {
                $model->status = 1;
                if ($model->save()) {
                    //print_r($model);
                    // exit();
                } else {
                    
                }
            }


            $event->data = $this->render('wizard/complete', [
                'data' => $event->stepData
            ]);
            //$event->continue = false;
        } else {

            $event->data = $this->render('wizard/notStarted');
        }
    }

    /**
     * Method description
     *
     * @return mixed The return value
     */
    public function actionResume($uuid) {
        $registrationFile = Yii::getAlias('@runtime/wizard/leave') . DIRECTORY_SEPARATOR . $uuid;
        if (file_exists($registrationFile)) {
            $this->resumeWizard(@file_get_contents($registrationFile));
            unlink($registrationFile);
            $this->redirect(['create']);
        } else {
            return $this->render('wizard/notResumed');
        }
    }

    public function actionDraft($type = null, $id = null) {
        $type = $type === null ? 1 : $type;

        $model = new Leave(['leave_type_id' => $type, 'user_id' => Yii::$app->user->identity->id]);
        $model->checkScenario();
        if ($id) {
            $modelDraft = LeaveDraft::findOne($id);
            $model->attributes = $modelDraft->data;
            $model->leave_draft_id = $id;
        } else {
            $modelDraft = new LeaveDraft();
        }

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $model->number_day = Leave::calCountDays(Helper::dateUi2Db($model->date_start), Helper::dateUi2Db($model->date_end), $model->start_part, $model->end_part);
            $model->user_id = Yii::$app->user->identity->id;
            $modelDraft->draft_time = time();
            $modelDraft->user_id = Yii::$app->user->identity->id;
            $modelDraft->status = LeaveDraft::STATUS_DRAFT;
            $modelDraft->data = $model->attributes;
            if ($modelDraft->save()) {
                return $this->redirect(['confirm', 'id' => $modelDraft->id]);
            } else {
                print_r($modelDraft->getErrors());
                exit();
            }
        }
        return $this->render('draft', ['model' => $model]);
    }

    /**
     * Displays a single Leave model.
     * @param integer $id
     * @return mixed
     */
    public function actionConfirm($id) {

        $modelDraft = LeaveDraft::findOne($id);
        $model = new Leave();

//        print_r( $modelDraft->data);
//        exit();
        $model->attributes = $modelDraft->data;
        $model->checkScenario();
        $model->leave_draft_id = $id;
        //$model->scenario = 'confirm';
        //$model->scenario
        //print_r($model->getscenarios());
        //exit();
        if ($model->load(Yii::$app->request->post())) {
            $model->load(['Leave' => $modelDraft->data]);
            $model->status = Leave::STATUS_OFFER;
            $modelDraft->status = LeaveDraft::STATUS_USED;
            if ($model->save()) {
                $modelDraft->save();
                Yii::$app->getSession()->setFlash('saved', [
                    'type' => 'success',
                    'msg' => Yii::t('andahrm/leave', 'The system successfully sent.')
                ]);
                return $this->redirect(['complete']);
            } else {
                print_r($model->getErrors());
            }
        }
        return $this->render('confirm', [
                    'model' => $model,
        ]);
    }

    public function actionComplete() {
        return $this->render('complete');
    }

}
