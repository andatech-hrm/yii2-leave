<?php

namespace andahrm\leave;

use Yii;

/**
 * This is the model class for table "leave_permission_transection".
 *
 * @property int $user_id
 * @property int $trans_time
 * @property int $trans_type
 * @property int $leave_condition_id
 * @property string $year
 * @property int $number_day
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class LeavePermissionTransection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_permission_transection';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'trans_time', 'trans_type', 'leave_condition_id', 'year', 'number_day'], 'required'],
            [['user_id', 'trans_time', 'trans_type', 'leave_condition_id', 'number_day', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['year'], 'safe'],
            [['user_id', 'trans_time', 'trans_type', 'leave_condition_id', 'year'], 'unique', 'targetAttribute' => ['user_id', 'trans_time', 'trans_type', 'leave_condition_id', 'year']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('andahrm/leave', 'User ID'),
            'trans_time' => Yii::t('andahrm/leave', 'Trans Time'),
            'trans_type' => Yii::t('andahrm/leave', 'Trans Type'),
            'leave_condition_id' => Yii::t('andahrm/leave', 'Leave Condition ID'),
            'year' => Yii::t('andahrm/leave', 'Year'),
            'number_day' => Yii::t('andahrm/leave', 'Number Day'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }
}
