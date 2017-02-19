<?php

namespace andahrm\leave\models;

use Yii;

/**
 * This is the model class for table "leave_condition".
 *
 * @property integer $id
 * @property string $title
 * @property integer $leave_type_id
 * @property integer $gov_service_status
 * @property double $number_year
 * @property integer $per_annual_leave
 * @property integer $per_annual_leave_limit
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property LeaveType $leaveType
 * @property LeavePermission[] $leavePermissions
 */
class LeaveCondition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_condition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['leave_type_id', 'gov_service_status', 'per_annual_leave', 'per_annual_leave_limit', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['number_year'], 'number'],
            [['title'], 'string', 'max' => 100],
            [['leave_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeaveType::className(), 'targetAttribute' => ['leave_type_id' => 'id']],
            ['leave_type_id' , 'default','value'=>4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/leave', 'ID'),
            'title' => Yii::t('andahrm/leave', 'Title'),
            'leave_type_id' => Yii::t('andahrm/leave', 'Leave Type'),
            'gov_service_status' => Yii::t('andahrm/leave', 'Service Status'),
            'number_year' => Yii::t('andahrm/leave', 'Number Year'),
            'per_annual_leave' => Yii::t('andahrm/leave', 'Per Annual'),
            'per_annual_leave_limit' => Yii::t('andahrm/leave', 'Per Annual Limit'),
            'status' => Yii::t('andahrm/leave', 'Status'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveType()
    {
        return $this->hasOne(LeaveType::className(), ['id' => 'leave_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeavePermissions()
    {
        return $this->hasMany(LeavePermission::className(), ['leave_condition_id' => 'id']);
    }
}
