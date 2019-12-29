<?php

namespace andahrm\leave\models;

use Yii;

/**
 * This is the model class for table "leave_detail".
 *
 * @property int $leave_id
 * @property int $leave_type_id
 * @property string $detail
 *
 * @property Leave $leave
 */
class LeaveDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['leave_id'], 'required'],
            [['leave_id', 'leave_type_id'], 'integer'],
            [['detail'], 'string'],
            [['leave_id'], 'unique'],
            [['leave_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leave::className(), 'targetAttribute' => ['leave_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'leave_id' => Yii::t('andahrm/leave', 'Leave ID'),
            'leave_type_id' => Yii::t('andahrm/leave', 'Leave Type ID'),
            'detail' => Yii::t('andahrm/leave', 'Detail'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeave()
    {
        return $this->hasOne(Leave::className(), ['id' => 'leave_id']);
    }
}
