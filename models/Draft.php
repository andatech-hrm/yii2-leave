<?php

namespace andahrm\leave\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
###
use andahrm\structure\models\FiscalYear;
use andahrm\setting\models\Helper;

class Draft extends Leave {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'leave_type_id', 'start_part', 'end_part', 'acting_user_id', 'status', 'inspector_status', 'inspector_by', 'inspector_at', 'commander_status', 'commander_by', 'commander_at', 'director_status', 'director_by', 'director_at', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['to', 'date_start', 'date_end', 'commander_by', 'inspector_by', 'director_by', 'acting_user_id', 'contact'], 'required'],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();

        $scenarios['insert'] = ['to', 'user_id', 'year', 'leave_type_id', 'reason', 'contact', 'acting_user_id', 'date_start', 'date_end', 'status', 'inspector_by', 'director_by', 'commander_by', 'start_part', 'end_part', 'contact', 'number_day'];
        $scenarios['create-vacation'] = ['to', 'user_id', 'year', 'leave_type_id', 'acting_user_id', 'contact', 'date_start', 'date_end', 'end_part', 'status', 'inspector_by', 'director_by', 'commander_by', 'start_part', 'end_part', 'contact', 'number_day'];
        $scenarios['create-sick'] = ['to', 'user_id', 'year', 'leave_type_id', 'reason', 'contact', 'date_start', 'date_end', 'start_part', 'date_end', 'end_part', 'inspector_by', 'director_by', 'commander_by', 'contact', 'number_day'];

        return $scenarios;
    }

    public function beforeValidate() {
        #เปลี่ยน Form
        if ($this->leave_type_id == 1) {
            $this->scenario = "create-vacation";
        } else {
            $this->scenario = "create-sick";
        }


        #เช็คช่วงของวัน
        if (($this->date_start == $this->date_end) && ($this->start_part !== $this->end_part)) {
            $this->addError('end_part', Yii::t('andahrm/leave', 'Not match'));
        }
        if ($this->date_start < $this->date_end) {
            if (($this->start_part == Leave::HALF_DAY_MORNIG) || ($this->end_part == Leave::LATE_AFTERNOON)) {
                $this->addError('end_part', Yii::t('andahrm/leave', 'Not match'));
            }
        }

        #ดึงจำนวนวันลา
        $this->number_day = self::calCountDays(Helper::dateUi2Db($this->date_start), Helper::dateUi2Db($this->date_end), $this->start_part, $this->end_part);
        #วันลาสะสม
        $collect = Leave::getCollect(Yii::$app->user->id, $this->year);
        #สิทธิ์ในการฃา
        $permission = LeavePermission::getPermission(Yii::$app->user->id, $this->year);
        $total = $collect + $permission;

        #สิทธิ์ในการฃา
        $permisTrans = LeavePermissionTransection::getAmountOnType($this->user_id, $this->year);
        $total = ($permisTrans[LeavePermissionTransection::TYPE_ADD] + $permisTrans[LeavePermissionTransection::TYPE_CARRY]) - $permisTrans[LeavePermissionTransection::TYPE_MINUS];

        #ตรวจสอบเงื่อนไง
        switch ($this->leave_type_id) {
            case self::TYPE_VACATION:
                if ($total < $this->number_day)
                    $this->addError('date_end', Yii::t('andahrm/leave', 'Exceeds'));
                break;
        }

        #ตรวจสอบการวันลาซ่ำ






        if (parent::beforeValidate()) {
            return true;
        }
        return false;
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            $this->number_day = self::calCountDays($this->date_start, $this->date_end, $this->start_part, $this->end_part);
            return true;
        } else {
            return false;
        }
    }

    public static function getReasonList() {
        $model = self::find()->select('reason')->distinct()->where([
                    'created_by' => Yii::$app->user->id
                ])->groupBy('reason')->limit(20)->all();
        return $model ? ArrayHelper::getColumn($model, 'reason') : [];
    }

    public static function getContactList() {
        $model = self::find()->select('contact')->distinct()->where(['created_by' => Yii::$app->user->id])->groupBy('contact')->limit(20)->all();
        return $model ? ArrayHelper::getColumn($model, 'contact') : [];
    }

}
