<?php

namespace andahrm\leave\models;

use Yii;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

use andahrm\person\models\Person;
/**
 * This is the model class for table "leave_related".
 *
 * @property integer $id
 * @property string $title
 * @property integer $inspector_by
 * @property integer $commander_by
 * @property integer $director_by
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
  
   public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'commander_by', 'director_by'], 'required'],
            [['inspector_by', 'commander_by', 'director_by', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
            'inspector_by' => Yii::t('andahrm/leave', 'ผู้ตรวจสอบ'),
            'commander_by' => Yii::t('andahrm/leave', 'ผู้บังคับบัญชา'),
            'director_by' => Yii::t('andahrm/leave', 'ผู้ออกคำสั่ง'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
            'personห' => Yii::t('andahrm/leave', 'บุคลากร'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveRelatedPeople()
    {
        return $this->hasMany(LeaveRelatedPerson::className(), ['leave_related_id' => 'id']);
    }
  
    public static function getList(){
      return ArrayHelper::map(self::find()->all(),'id','title');
    } 
  
    public $persons;
  
    public function getPersonSelected()
    {
        return arrayHelper::index($this->leaveRelatedPeople,'user_id');
    }
  
    public function getInspectorBy()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'inspector_by']);
    }  
  
    public function getCommanderBy()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'commander_by']);
    }
  
    public function getDirectorBy()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'director_by']);
    }
  
  
    
  
}
