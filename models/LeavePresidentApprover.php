<?php

namespace andahrm\leave\models;

use Yii;

/**
 * This is the model class for table "leave_president_approver".
 *
 * @property int $leave_id
 * @property int $president_user_id
 * @property int $status
 * @property int $approved_at
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Leave $leave
 * @property President $presidentUser
 */
class LeavePresidentApprover extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_president_approver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['leave_id', 'president_user_id', 'status', 'approved_at'], 'required'],
            [['leave_id', 'president_user_id', 'status', 'approved_at', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['leave_id'], 'unique'],
            [['leave_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leave::className(), 'targetAttribute' => ['leave_id' => 'id']],
            [['president_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => President::className(), 'targetAttribute' => ['president_user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'leave_id' => Yii::t('andahrm/leave', 'Leave ID'),
            'president_user_id' => Yii::t('andahrm/leave', 'President User ID'),
            'status' => Yii::t('andahrm/leave', 'Status'),
            'approved_at' => Yii::t('andahrm/leave', 'Approved At'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeave()
    {
        return $this->hasOne(Leave::className(), ['id' => 'leave_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresidentUser()
    {
        return $this->hasOne(President::className(), ['user_id' => 'president_user_id']);
    }
}
