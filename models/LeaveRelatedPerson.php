<?php

namespace andahrm\leave\models;

use Yii;
use andahrm\person\models\Person;

/**
 * This is the model class for table "leave_related_person".
 *
 * @property integer $user_id
 * @property integer $leave_related_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Person $user
 * @property LeaveRelated $leaveRelated
 */
class LeaveRelatedPerson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_related_person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'leave_related_id'], 'required'],
            [['user_id', 'leave_related_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['leave_related_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeaveRelated::className(), 'targetAttribute' => ['leave_related_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('andahrm/leave', 'ผู้ยื่นลา'),
            'leave_related_id' => Yii::t('andahrm/leave', 'ผู้ที่เกี่ยวข้อง'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveRelated()
    {
        return $this->hasOne(LeaveRelated::className(), ['id' => 'leave_related_id']);
    }
}
