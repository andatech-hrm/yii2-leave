<?php

namespace andahrm\leave\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\AttributeBehavior;
###
use andahrm\person\models\Person;
use andahrm\leave\models\PersonLeave;
use andahrm\setting\models\Helper;
use andahrm\datepicker\behaviors\DateBuddhistBehavior;

/**
 * This is the model class for table "leave_cancel".
 *
 * @property integer $id
 * @property string $to
 * @property integer $leave_id
 * @property string $reason
 * @property string $date_start
 * @property integer $start_part
 * @property string $date_end
 * @property integer $end_part
 * @property string $number_day
 * @property integer $status
 * @property string $commander_comment
 * @property integer $commander_status
 * @property integer $commander_by
 * @property integer $commander_at
 * @property string $director_comment
 * @property integer $director_status
 * @property integer $director_by
 * @property integer $director_at
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Leave $leave
 */
class LeaveCancel extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'leave_cancel';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['to', 'leave_id', 'date_start', 'date_end'], 'required'],
            [['leave_id', 'start_part', 'end_part', 'status', 'commander_status', 'commander_by', 'commander_at', 'director_status', 'director_by', 'director_at', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['date_start', 'date_end'], 'safe'],
            [['number_day'], 'number'],
            [['commander_comment'], 'string'],
            [['to', 'director_comment'], 'string', 'max' => 255],
            [['reason'], 'string', 'max' => 200],
            [['leave_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leave::className(), 'targetAttribute' => ['leave_id' => 'id']],
        ];
    }

    function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            'date_start' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'date_start',
            ],
            'date_end' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'date_end',
            ],
//            'date_start' => [
//                'class' => AttributeBehavior::className(),
//                'attributes' => [
//                    ActiveRecord::EVENT_BEFORE_INSERT => 'date_start',
//                    ActiveRecord::EVENT_BEFORE_UPDATE => 'date_start',
//                ],
//                'value' => function($event) {
//                    return Helper::dateUi2Db($this->date_start);
//                },
//            ],
//            'date_end' => [
//                'class' => AttributeBehavior::className(),
//                'attributes' => [
//                    ActiveRecord::EVENT_BEFORE_INSERT => 'date_end',
//                    ActiveRecord::EVENT_BEFORE_UPDATE => 'date_end',
//                ],
//                'value' => function($event) {
//                    return Helper::dateUi2Db($this->date_end);
//                },
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('andahrm/leave', 'ID'),
            'to' => Yii::t('andahrm/leave', 'To'),
            'leave_id' => Yii::t('andahrm/leave', 'Leave ID'),
            'reason' => Yii::t('andahrm/leave', 'Reason'),
            'date_start' => Yii::t('andahrm/leave', 'Date Start'),
            'start_part' => Yii::t('andahrm/leave', 'Start Part'),
            'date_end' => Yii::t('andahrm/leave', 'Date End'),
            'end_part' => Yii::t('andahrm/leave', 'End Part'),
            'number_day' => Yii::t('andahrm/leave', 'Number Day'),
            'status' => Yii::t('andahrm/leave', 'Status'),
            'commander_comment' => Yii::t('andahrm/leave', 'Commander Comment'),
            'commander_status' => Yii::t('andahrm/leave', 'Commander Status'),
            'commander_by' => Yii::t('andahrm/leave', 'Commander By'),
            'commander_at' => Yii::t('andahrm/leave', 'Commander At'),
            'director_comment' => Yii::t('andahrm/leave', 'Director Comment'),
            'director_status' => Yii::t('andahrm/leave', 'Director Status'),
            'director_by' => Yii::t('andahrm/leave', 'Director By'),
            'director_at' => Yii::t('andahrm/leave', 'Director At'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }

    const SCENARIO_CREATE_VACATION = "create-type-1"; #create-vacation
    const SCENARIO_CREATE_SICK = "create-type-2"; #create-sick
    const SCENARIO_CREATE_OTHER = "create-type"; #create-other
    const SCENA_UPDATE_VACATION = 'update-vacation';
    const SCENA_UPDATE_SICK = 'update-sick';
    const SCENARIO_DIRECTOR = 'director';

    public function scenarios() {
        $scenarios = parent::scenarios();

        $scenarios['insert'] = ['to', 'leave_id', 'date_start', 'date_end', 'status', 'start_part', 'end_part', 'contact', 'number_day', 'reason'];

        $scenarios['commander'] = ['date_start', 'date_end', 'status', 'commander_status', 'commander_at', 'commander_comment', 'updated_at', 'updated_by'];
        $scenarios[self::SCENARIO_DIRECTOR] = ['date_start', 'date_end', 'status', 'director_status', 'director_at', 'director_comment', 'updated_at', 'updated_by'];

        return $scenarios;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeave() {
        return $this->hasOne(Leave::className(), ['id' => 'leave_id']);
    }

    #แสดงช่วงวัน

    public function getDateRange() {
        return Yii::$app->formatter->asDate($this->date_start) . ' - ' . Yii::$app->formatter->asDate($this->date_end);
    }

    //const STATUS_DRAFT = 0;
    const STATUS_OFFER = 1;
    const STATUS_CONSIDER = 2;
    const STATUS_ALLOW = 3;
    const STATUS_DISALLOW = 4;
    const STATUS_CANCEL = 5;
    const ALL_DAY = 1;
    const HALF_DAY_MORNIG = 2;
    const LATE_AFTERNOON = 3;
    const ALLOW = 1;
    const DISALLOW = 0;

    public static function itemsAlias($key) {
        $items = [
            'status' => [
                // self::STATUS_DRAFT => Yii::t('andahrm/leave', 'Draft'),
                self::STATUS_OFFER => Yii::t('andahrm/leave', 'Offer'),
                self::STATUS_CONSIDER => Yii::t('andahrm/leave', 'Consider'),
                self::STATUS_ALLOW => Yii::t('andahrm/leave', 'Allow'),
                self::STATUS_DISALLOW => Yii::t('andahrm/leave', 'Disallow'),
                self::STATUS_CANCEL => Yii::t('andahrm/leave', 'Cancel'),
            ],
            'inspactor_status' => [
                self::ALLOW => Yii::t('andahrm/leave', 'Past'),
                self::DISALLOW => Yii::t('andahrm/leave', 'Not Past'),
            ],
            'commander_status' => [
                self::ALLOW => Yii::t('andahrm/leave', 'Agree'),
                self::DISALLOW => Yii::t('andahrm/leave', 'Disagree'),
            ],
            'director_status' => [
                self::ALLOW => Yii::t('andahrm/leave', 'Allow'),
                self::DISALLOW => Yii::t('andahrm/leave', 'Disallow'),
            ],
            'start_part' => [
                self::ALL_DAY => Yii::t('andahrm/leave', 'All Day'),
                self::HALF_DAY_MORNIG => Yii::t('andahrm/leave', 'Half-day morning'),
                self::LATE_AFTERNOON => Yii::t('andahrm/leave', 'Half-day afternoon'),
            ],
            'end_part' => [
                self::ALL_DAY => Yii::t('andahrm/leave', 'All Day'),
                self::HALF_DAY_MORNIG => Yii::t('andahrm/leave', 'Half-day morning'),
                self::LATE_AFTERNOON => Yii::t('andahrm/leave', 'Half-day afternoon'),
            ]
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getStatusLabel() {
        $status = ArrayHelper::getValue($this->getItemStatus(), $this->status);
        $status = ($this->status === NULL) ? ArrayHelper::getValue($this->getItemStatus(), 0) : $status;
        switch ($this->status) {
            case 0 :
            case NULL :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case 1 :
                $str = '<span class="label label-primary">' . $status . '</span>';
                break;
            case 2 :
                $str = '<span class="label label-primary">' . $status . '</span>';
                break;
            case 3 :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;
            case 4 :
                $str = '<span class="label label-error">' . $status . '</span>';
                break;
            case 5 :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            default :
                $str = $status;
                break;
        }

        return $str;
    }

    public function getCommanderStatusLabel() {
        $selected_status = $this->commander_status;
        $status = ArrayHelper::getValue($this->getItemInspactorStatus(), $selected_status);
        $status = ($selected_status === NULL) ? ArrayHelper::getValue($this->getItemInspactorStatus(), 0) : $status;
        switch ($selected_status) {

            case NULL :
                $str = '-';
                break;
            case 0 :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case 1 :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;
            default :
                $str = $status;
                break;
        }
        $str = $this->commander_at ? $str . ' <small>' . Yii::$app->formatter->asDate($this->commander_at) . "</small>" : $str;
        return $str;
    }

    public function getDirectorStatusLabel() {
        $selected_status = $this->director_status;
        $status = ArrayHelper::getValue($this->getItemInspactorStatus(), $selected_status);
        $status = ($selected_status === NULL) ? ArrayHelper::getValue($this->getItemInspactorStatus(), 0) : $status;
        switch ($selected_status) {

            case NULL :
                $str = '-';
                break;
            case 0 :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case 1 :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;
            default :
                $str = $status;
                break;
        }
        $str = $this->director_at ? $str . ' <small>' . Yii::$app->formatter->asDate($this->director_at) . "</small>" : $str;
        return $str;
    }

    public function getStartPartLabel() {
        return ArrayHelper::getValue($this->getItemStartPart(), $this->start_part);
    }

    public function getEndPartLabel() {
        return ArrayHelper::getValue($this->getItemEndPart(), $this->end_part);
    }

    public static function getWidgetStatus($status, $items) {
        $widget = '';
        foreach ($items as $key => $item) {
            $widget .= ' <i class="fa ' . (($status == $key && $status != null) ? 'fa-check-square-o' : 'fa-square-o') . ' aria-hidden="true"></i> ' . $item;
        }
        return $widget;
    }

    public function getCreatedBy() {
        return $this->leave->createdBy;
    }

    public function getLeaveType() {
        return $this->leave->leaveType;
    }

    public function getCommanderBy() {
        return $this->hasOne(Person::className(), ['user_id' => 'commander_by']);
    }

    public function getDirectorBy() {
        return $this->hasOne(Person::className(), ['user_id' => 'director_by']);
    }

    ##############################

    public static function getItemStatus() {
        return self::itemsAlias('status');
    }

    public static function getItemInspactorStatus() {
        return self::itemsAlias('inspactor_status');
    }

    public static function getItemCommanderStatus() {
        return self::itemsAlias('commander_status');
    }

    public static function getItemDirectorStatus() {
        return self::itemsAlias('director_status');
    }

    public static function getItemStartPart() {
        return self::itemsAlias('start_part');
    }

    public static function getItemEndPart() {
        return self::itemsAlias('end_part');
    }

    public function getCommanderAt() {
        return $this->commander_at ? 'วันที่ <span class="text-dashed">' . Yii::$app->formatter->asDate($this->commander_at, 'd') . ' / ' . Yii::$app->formatter->asDate($this->commander_at, 'MMMM') . ' / ' . Yii::$app->formatter->asDate($this->commander_at, 'yyyy') . '</span>' : null;
    }

    public function getDirectorAt() {
        return $this->director_at ? 'วันที่ <span class="text-dashed">' . Yii::$app->formatter->asDate($this->director_at, 'd') . ' / ' . Yii::$app->formatter->asDate($this->director_at, 'MMMM') . ' / ' . Yii::$app->formatter->asDate($this->director_at, 'yyyy') . '</span>' : null;
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
            //echo $this->user_id;
        }

        switch ($this->scenario) {
            case self::SCENARIO_DIRECTOR:
                $modelLeave = Leave::findOne($this->leave_id);

                if ($this->status == self::STATUS_ALLOW && $modelLeave->leave_type_id == Leave::TYPE_VACATION) {
                    //$permisTrans = LeavePermissionTransection::getDataForForm($modelLeave->user_id, $modelLeave->year);



                    $model = new LeavePermissionTransection(['user_id' => $modelLeave->user_id, 'year' => $modelLeave->year]);
                    $model->amount = $this->number_day;
                    $model->trans_time = time();
                    $model->trans_type = LeavePermissionTransection::TYPE_ADD;
                    $model->leave_trans_cate_id = LeavePermissionTransection::CATE_CANCEL;
                    $model->leave_form = self::className();
                    $model->leave_id = $modelLeave->id;
                    //$model->trans_by = Yii::$app->user->identity->id;
                    if ($model->save()) {
                        echo "Success";
                        //LeavePermission::updateBalance($modelLeave->user_id, $modelLeave->year);
                    } else {
                        print_r($model);
                        exit();
                    }
                }

                break;
        }


        //LeavePermission::updateBalance($this->user_id, $this->year);
        if (parent::afterSave($insert, $changedAttributes)) {
            return true; // do some otherthings
        }
    }

}
