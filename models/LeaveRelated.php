<?php

namespace andahrm\leave\models;

use Yii;

/**
 * This is the model class for table "leave_related".
 *
 * @property integer $id
 * @property string $title
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property LeaveRelatedPerson[] $leaveRelatedPeople
 */
class LeaveRelated extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_related';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/leave', 'ID'),
            'title' => Yii::t('andahrm/leave', 'ชื่อชุดผู้ที่เกี่ยวข้อง'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }
  
    /**
    * @return \yii\db\ActiveQuery
    */
   public function getLeaveRelatedApprover() 
   { 
       return $this->hasOne(LeaveRelatedApprover::className(), ['leave_related_id' => 'id']); 
   } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveRelatedPeople()
    {
        return $this->hasMany(LeaveRelatedPerson::className(), ['leave_related_id' => 'id']);
    }
}
