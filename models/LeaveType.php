<?php

namespace andahrm\leave\models;

use Yii;

/**
 * This is the model class for table "leave_type".
 *
 * @property integer $id
 * @property string $title
 * @property integer $limit
 * @property string $detail
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Leave[] $leaves
 * @property LeaveCondition[] $leaveConditions
 */
class LeaveType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['limit', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['detail'], 'string'],
            [['title'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/leave', 'ID'),
            'title' => Yii::t('andahrm/leave', 'ประเภทการลา'),
            'limit' => Yii::t('andahrm/leave', 'จำกัดวัน'),
            'detail' => Yii::t('andahrm/leave', 'Detail'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaves()
    {
        return $this->hasMany(Leave::className(), ['leave_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveConditions()
    {
        return $this->hasMany(LeaveCondition::className(), ['leave_type_id' => 'id']);
    }
}
