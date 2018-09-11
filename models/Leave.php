<?php

namespace andahrm\leave\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
###
use andahrm\person\models\Person;
use andahrm\leave\models\PersonLeave;
use andahrm\datepicker\behaviors\DateBuddhistBehavior;
use andahrm\setting\models\Helper;
use andahrm\structure\models\FiscalYear;
use andahrm\leave\models\LeavePermissionTransection;

// function behaviors()
//     {
//         return [ 
//           'timestamp' => [
//                 'class' => TimestampBehavior::className(),
//             ],
//             'blameable' => [
//                 'class' => BlameableBehavior::className(),
//             ],
//         ];
//     }

/**
 * This is the model class for table "leave".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $leave_type_id
 * @property string $date_start
 * @property integer $start_part
 * @property string $date_end
 * @property integer $end_part
 * @property string $reason
 * @property integer $acting_user_id
 * @property integer $status
 * @property string $inspector_comment
 * @property integer $inspector_status
 * @property integer $inspector_by
 * @property integer $inspector_at
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
 * @property Person $user
 * @property LeaveType $leaveType
 * @property LeaveCancel $leaveCancel
 */
class Leave extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'leave';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'leave_type_id', 'start_part', 'end_part', 'acting_user_id', 'status', 'inspector_status', 'inspector_by', 'inspector_at', 'commander_status', 'commander_by', 'commander_at', 'director_status', 'director_by', 'director_at', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['to', 'acting_user_id', 'inspector_by', 'director_by', 'date_start', 'date_end', 'contact', 'leave_draft_id'], 'required'],
            [['year', 'date_start', 'date_end'], 'safe'],
            [['reason', 'contact'], 'string'],
            [['number_day'], 'number'],
            [['to', 'inspector_comment', 'commander_comment', 'director_comment'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['leave_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeaveType::className(), 'targetAttribute' => ['leave_type_id' => 'id']],
            [['leave_type_id'], 'default', 'value' => 4],
            ['status', 'default', 'value' => 0, 'when' =>
                function($model) {
                    return $model->isNewRecord;
                }
            ],
        ];
    }

    const SCENARIO_CREATE_VACATION = "create-type-1"; #create-vacation
    const SCENARIO_CREATE_SICK = "create-type-2"; #create-sick
    const SCENARIO_CREATE_OTHER = "create-type"; #create-other
    const SCENA_UPDATE_VACATION = 'update-vacation';
    const SCENA_UPDATE_SICK = 'update-sick';
    const SCENARIO_DIRECTOR = 'director';

    public $leave_draft_id;

    public function scenarios() {
        // $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE_VACATION] = ['to', 'year', 'user_id', 'leave_type_id', 'acting_user_id', 'contact', 'date_start', 'date_end', 'status', 'inspector_by', 'director_by', 'commander_by', 'start_part', 'end_part', 'contact', 'number_day', 'year'];
        $scenarios[self::SCENARIO_CREATE_SICK] = ['to', 'year', 'user_id', 'leave_type_id', 'reason', 'contact', 'date_start', 'date_end', 'status', 'inspector_by', 'director_by', 'commander_by', 'contact', 'number_day', 'year'];
        $scenarios[self::SCENARIO_CREATE_OTHER] = ['to', 'year', 'user_id', 'leave_type_id', 'reason', 'contact', 'date_start', 'date_end', 'status', 'inspector_by', 'director_by', 'commander_by', 'contact', 'number_day', 'year'];

        $scenarios[self::SCENA_UPDATE_VACATION] = ['to', 'contact', 'date_start', 'date_end', 'end_part', 'status', 'inspector_by', 'director_by', 'commander_by', 'start_part', 'end_part', 'contact', 'number_day'];
        $scenarios[self::SCENA_UPDATE_SICK] = ['to', 'reason', 'contact', 'date_start', 'date_end', 'start_part', 'date_end', 'end_part', 'inspector_by', 'director_by', 'commander_by', 'contact', 'number_day'];

        $scenarios['confirm'] = ['status'];

        $scenarios['inspector'] = ['status', 'inspector_status', 'inspector_at', 'inspector_comment', 'date_start', 'date_end'];
        $scenarios['commander'] = ['status', 'commander_status', 'commander_at', 'commander_comment', 'date_start', 'date_end'];
        $scenarios[self::SCENARIO_DIRECTOR] = ['status', 'director_status', 'director_at', 'director_comment', 'date_start', 'date_end'];

        return array_merge(parent::scenarios(), $scenarios);
    }

    public function checkScenario() {
        $scenarios = $this->scenarios();
        $type = isset($scenarios[self::SCENARIO_CREATE_OTHER . '-' . $this->leave_type_id]) ? self::SCENARIO_CREATE_OTHER . '-' . $this->leave_type_id : self::SCENARIO_CREATE_OTHER;
        $this->scenario = $type;
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('andahrm/leave', 'ID'),
            'to' => Yii::t('andahrm/leave', 'To'),
            'year' => Yii::t('andahrm/leave', 'Year'),
            'user_id' => Yii::t('andahrm/leave', 'Sender'),
            'leave_type_id' => Yii::t('andahrm/leave', 'Leave Type'),
            'contact' => Yii::t('andahrm/leave', 'Contact'),
            'date_range' => Yii::t('andahrm/leave', 'Date Range'),
            'date_start' => Yii::t('andahrm/leave', 'Date Start'),
            'start_part' => Yii::t('andahrm/leave', 'Start Part'),
            'date_end' => Yii::t('andahrm/leave', 'Date End'),
            'end_part' => Yii::t('andahrm/leave', 'End Part'),
            'reason' => Yii::t('andahrm/leave', 'Reason'),
            'number_day' => Yii::t('andahrm/leave', 'Number Day'),
            'acting_user_id' => Yii::t('andahrm/leave', 'Acting User'),
            'status' => Yii::t('andahrm/leave', 'Status'),
            'inspector_comment' => Yii::t('andahrm/leave', 'Inspector Comment'),
            'inspector_status' => Yii::t('andahrm/leave', 'Inspector Status'),
            'inspector_by' => Yii::t('andahrm/leave', 'Inspector by'),
            'inspector_at' => Yii::t('andahrm/leave', 'Inspector At'),
            'commander_comment' => Yii::t('andahrm/leave', 'Commander Comment'),
            'commander_status' => Yii::t('andahrm/leave', 'Commander Status'),
            'commander_by' => Yii::t('andahrm/leave', 'Commander By'),
            'commander_at' => Yii::t('andahrm/leave', 'Commander At'),
            'director_comment' => Yii::t('andahrm/leave', 'Director Comment'),
            'director_status' => Yii::t('andahrm/leave', 'Director Status'),
            'director_by' => Yii::t('andahrm/leave', 'Director By'),
            'director_at' => Yii::t('andahrm/leave', 'Director At'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
        ];
    }

    const STATUS_DRAFT = 0;
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
    const TYPE_VACATION = 1; #ลาพักผ่อน

    public static function itemsAlias($key) {
        $items = [
            'status' => [
                self::STATUS_DRAFT => Yii::t('andahrm/leave', 'Draft'),
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

    public function getInspactorStatusLabel() {
        $selected_status = $this->inspector_status;
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
        $str = $this->inspector_at ? $str . '<br/><small>' . Yii::$app->formatter->asDate($this->inspector_at) . "</small>" : $str;
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
        $str = $this->commander_at ? $str . '<br/><small>' . Yii::$app->formatter->asDate($this->commander_at) . "</small>" : $str;
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
        $str = $this->director_at ? $str . '<br/><small>' . Yii::$app->formatter->asDate($this->director_at) . "</small>" : $str;
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

//       public function beforeSave($insert) {
//         if ($insert) {
//             $this->user_id = \Yii::$app->user->identity->id;
//         } else {
//         }
//         return parent::beforeSave($insert);
//     }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
//         return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson() {
//         return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
        return $this->hasOne(PersonLeave::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveType() {
        return $this->hasOne(LeaveType::className(), ['id' => 'leave_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveCancel() {
        return $this->hasMany(LeaveCancel::className(), ['leave_id' => 'id']);
    }

    public function getLeaveCancelByField($field) {
        $model = $this->leaveCancel;
        $item = [];
        foreach ($model as $cancel) {
            $item[] = "<span class='text-danger'>" . $cancel->$field . "</div>";
        }
        return $item ? '<hr/>' . implode('<br/>', $item) : '';
    }

    public function getLeaveCancelNumber($field) {
        $model = $this->leaveCancel;
        $item = [];
        foreach ($model as $cancel) {
            $item[] = "<span class='text-danger'>" . Yii::$app->formatter->asDecimal($cancel->$field, 1) . "</div>";
        }
        return $item ? '<hr/>' . implode('<br/>', $item) : '';
    }

    public function getLeaveCancelButton() {
        $model = $this->leaveCancel;
        $item = [];
        foreach ($model as $cancel) {
            $item[] = Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to(['cancel-view', 'id' => $cancel->id]), ['class' => 'btn btn-xs btn-default']);
        }
        return $item ? '<hr style="margin:11px 0px 23px;"/>' . implode('<br/>', $item) : '';
    }

    public function getCreatedBy() {
        return $this->hasOne(PersonLeave::className(), ['user_id' => 'created_by']);
    }

    public function getUpdatedBy() {
        return $this->hasOne(PersonLeave::className(), ['user_id' => 'updated_by']);
    }

    public static function getActingList() {
        $model = Person::find()->where(['!=', 'user_id', Yii::$app->user->id])->all();
        return ArrayHelper::map($model, 'user_id', 'fullname', 'positionTitle');
    }

    public function getActingUser() {
        return $this->hasOne(Person::className(), ['user_id' => 'acting_user_id']);
    }

    public function getInspectorBy() {
        return $this->hasOne(Person::className(), ['user_id' => 'inspector_by']);
    }

    public function getCommanderBy() {
        return $this->hasOne(Person::className(), ['user_id' => 'commander_by']);
    }

    public function getDirectorBy() {
        return $this->hasOne(Person::className(), ['user_id' => 'director_by']);
    }

    public function getInspectorAt() {
        return $this->inspector_at ? 'วันที่ <span class="text-dashed">' . Yii::$app->formatter->asDate($this->inspector_at, 'd') . ' / ' . Yii::$app->formatter->asDate($this->inspector_at, 'MMMM') . ' / ' . Yii::$app->formatter->asDate($this->inspector_at, 'yyyy') . '</span>' : null;
    }

    public function getCommanderAt() {
        return $this->commander_at ? 'วันที่ <span class="text-dashed">' . Yii::$app->formatter->asDate($this->commander_at, 'd') . ' / ' . Yii::$app->formatter->asDate($this->commander_at, 'MMMM') . ' / ' . Yii::$app->formatter->asDate($this->commander_at, 'yyyy') . '</span>' : null;
    }

    public function getDirectorAt() {
        return $this->director_at ? 'วันที่ <span class="text-dashed">' . Yii::$app->formatter->asDate($this->director_at, 'd') . ' / ' . Yii::$app->formatter->asDate($this->director_at, 'MMMM') . ' / ' . Yii::$app->formatter->asDate($this->director_at, 'yyyy') . '</span>' : null;
    }

    #แสดงช่วงวัน

    public function getDateRange() {
        return Yii::$app->formatter->asDate($this->date_start) . ' - ' . Yii::$app->formatter->asDate($this->date_end);
    }

    #######################################
    #จำนวนวันลาครั้งนี้

    public function getCountDays() {
        if (!($this->date_start && $this->date_end)) {
            return null;
        }
        return self::calCountDays($this->date_start, $this->date_end, $this->start_part, $this->end_part);
    }

    #คำนวนหาจำนวนวัน

    public static function calCountDays($start, $end, $start_part, $end_part) {
        $intTotalDay = ((strtotime($end) - strtotime($start)) / ( 60 * 60 * 24 )) + 1;
        $intWorkDay = 0;
        $intHoliday = 0;
        $intDayOff = 0;
        $days = [];
        $dayOffList = LeaveDayOff::getListOfCheck();
        for ($i = 0; $i < $intTotalDay; $i++) {
            //echo $i."<br/>";
            $days[$i] = date("Y-m-d", strtotime("+{$i} day", strtotime($start)));
            if (in_array($days[$i], $dayOffList)) {
                $intDayOff++;
            }

            $DayOfWeek = date("w", strtotime($days[$i]));
            if ($DayOfWeek == 0 or $DayOfWeek == 6) {  // 0 = Sunday, 6 = Saturday;
                $intHoliday++;
            }
        }
        //LeaveDayOff::getListOfCheck();
        //print_r(LeaveDayOff::getListOfCheck());
        $intWorkDay = $intTotalDay - $intHoliday - $intDayOff;

        if ($start_part != self::ALL_DAY) {
            $intWorkDay -= 0.5;
        }

        if ($end_part != self::ALL_DAY) {
            $intWorkDay -= 0.5;
        }

        // echo "<hr>";
        // echo "<br>Total Day = $intTotalDay";
        // echo "<br>Work Day = $intWorkDay";
        // echo "<br>Holiday = $intHoliday";
        // echo "<br>Day Off = $intDayOff";
        return $intWorkDay;
    }

    #วันลาพักผ่อนสะสม

    public static function getCollect($user_id = null, $year = null, $leave_type_id = self::TYPE_VACATION) {
        $year = $year ? $year : date('Y');
        $user_id = $user_id ? $user_id : Yii::$app->user->id;
        $year = $year - 1;

        #จำนวนวันที่ได้โคต้า
        $permissionAll = LeavePermission::getPermissionAll($user_id, $year);
        //$userNumber = $user->leavePermission->number_day;
        //$rangeYear = FiscalYear::find()->where(['year'=>$year])->one();
        #จำนวนวันทั้งหมด
        $leaveAll = self::find()
                ->where(['<=', 'year', $year])
//       ->where(['>=','year',$rangeYear->date_start])
//       ->andWhere(['<=','date_end',$rangeYear->date_end])
                ->andWhere([
                    'created_by' => $user_id,
                    'status' => self::STATUS_ALLOW,
                    'leave_type_id' => $leave_type_id
                ])
                ->sum('number_day');
        //->one();

        $cancelDay = self::getCancelDay($user_id, $year, $leave_type_id);

        //echo $permissionAll.'-'.$leaveAll;
        return $permissionAll - $leaveAll + $cancelDay;
    }

    #ลามาแล้ว (วันทำการ)ในปีนั้นๆ

    public static function getPastDay($user_id = null, $year = null, $leave_type_id = self::TYPE_VACATION) {
        $year = $year ? $year : date('Y');
        $user_id = $user_id ? $user_id : Yii::$app->user->id;
        //$rangeYear = FiscalYear::find()->where(['year'=>$year])->one();

        $model = self::find()
                ->where([
                    'year' => $year,
                    'created_by' => $user_id,
                    'status' => self::STATUS_ALLOW,
                    'leave_type_id' => $leave_type_id
                ])
                ->sum('number_day');
        //->one();    
        //print_r($model);
        $pastDay = $model ? $model - self::getCancelDay($user_id, $year, $leave_type_id) : 0;
        return Yii::$app->formatter->asDecimal($pastDay, 1);
    }

    #ลามาแล้ว (วันทำการ)ก่อนวันนี้

    public function getPastDayBefore() {
        $model = self::find()
                ->where([
                    'year' => $this->year,
                    'created_by' => $this->user_id,
                    'status' => self::STATUS_ALLOW,
                    'leave_type_id' => $this->leave_type_id
                ])
                ->andWhere(['<', 'created_at', $this->created_at])
                ->sum('number_day');
        //->one();    
        //print_r($model);
        $pastDay = $model ? $model - self::getCancelDay($user_id, $year, $leave_type_id) : 0;
        return Yii::$app->formatter->asDecimal($pastDay, 1);
    }

    #วันลาพักผ่อนสะสม คงเหลือ (วันลาพักผ่อน)

    public static function getTotal($user_id = null, $year = null, $leave_type_id = self::TYPE_VACATION) {
        $year = $year ? $year : date('Y');
        $user_id = $user_id ? $user_id : Yii::$app->user->id;


        #จำนวนวันที่ได้โคต้า
        $permissionAll = LeavePermission::getPermissionAll($user_id, $year);
        //$userNumber = $user->leavePermission->number_day;
        //$rangeYear = FiscalYear::find()->where(['year'=>$year])->one();
        #จำนวนวันทั้งหมด
        $leaveAll = self::getPastDay($user_id, $year);
        //->one();
        //echo $permissionAll.'-'.$leaveAll;
        $total = 0;
        $total = $permissionAll - $leaveAll;
        return Yii::$app->formatter->asDecimal($total, 1);
    }

    #จำนวนวันยกเลิกลา

    public static function getCancelDay($user_id = null, $year = null, $leave_type_id = self::TYPE_VACATION) {
        $year = $year ? $year : date('Y');
        $user_id = $user_id ? $user_id : Yii::$app->user->id;

        #จำนวนวันทั้งหมด
        $cancelDay = self::find()->joinWith('leaveCancel')
                ->where([
                    'leave.year' => $year,
                    'leave.created_by' => $user_id,
                    'leave.status' => self::STATUS_ALLOW,
                    'leave.leave_type_id' => $leave_type_id,
                    'leave_cancel.status' => LeaveCancel::STATUS_ALLOW,
                ])
                ->sum('leave_cancel.number_day');
        //->one();
        //echo $permissionAll.'-'.$leaveAll;
        return $cancelDay ? $cancelDay : 0;
    }

    #จำนวนวันที่ลา - จำนวนวันยกเลิกทั้งหมด

    public function getNumberDayTotal() {
        $cancelDay = LeaveCancel::find()
                ->where([
                    'leave_id' => $this->id,
                    'status' => LeaveCancel::STATUS_ALLOW,
                ])
                ->sum('leave_cancel.number_day');

        $cancelDay = $cancelDay ? $cancelDay : 0;
        //echo $this->number_day .'-'. $cancelDay;
        return $this->number_day - $cancelDay;
    }

    #ลาครั้งล่าสุด

    public static function getLastLeave($user_id = null, $year = null, $leave_type_id = self::TYPE_VACATION) {
        $year = $year ? $year : date('Y');
        $user_id = $user_id ? $user_id : Yii::$app->user->id;

        return self::find()->where([
                    'year' => $year,
                    'created_by' => $user_id,
                    'status' => self::STATUS_ALLOW,
                    'leave_type_id' => $leave_type_id
                ])->orderBy(['created_at' => SORT_DESC])->one();
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
            //echo $this->user_id;
        }

        switch ($this->scenario) {
            case self::SCENARIO_DIRECTOR:
                if ($this->status == self::STATUS_ALLOW && $this->leave_type_id == Leave::TYPE_VACATION) {
                    $permisTrans = LeavePermissionTransection::getDataForForm($this->user_id, $this->year);
                    $model = new LeavePermissionTransection(['user_id' => $this->user_id, 'year' => $this->year]);
                    $model->amount = $this->number_day;
                    $model->trans_time = time();
                    $model->trans_type = LeavePermissionTransection::TYPE_MINUS;
                    $model->leave_trans_cate_id = LeavePermissionTransection::CATE_USE;
                    $model->leave_id = $this->id;
                    //$model->trans_by = Yii::$app->user->identity->id;
                    if ($model->save()) {
                        $modelVacation = new LeaveVacationDetail(['leave_id' => $this->id]);
                        $modelVacation->amount_carry = $permisTrans[LeavePermissionTransection::CATE_CARRY];
                        $modelVacation->amount_yearly = $permisTrans[LeavePermissionTransection::CATE_YEARLY];
                        $modelVacation->amount_total = $permisTrans[LeavePermissionTransection::TOTAL];
                        $modelVacation->save();
                    } else {
                        print_r($model);
                        exit();
                    }
                }
//                print_r($this->attributes);
//                exit();
//                break;
        }


        //LeavePermission::updateBalance($this->user_id, $this->year);
        if (parent::afterSave($insert, $changedAttributes)) {
            return true; // do some otherthings
        }
    }

}
