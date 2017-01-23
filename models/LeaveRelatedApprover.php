<?php

namespace andahrm\leave\models;

use Yii;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

use andahrm\person\models\Person;

/**
 * This is the model class for table "leave_related_approver".
 *
 * @property integer $leave_related_id
 * @property integer $inspector_by
 * @property integer $commander_by
 * @property integer $director_by
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class LeaveRelatedApprover extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_related_approver';
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
           // [[ 'inspector_by','commander_by', 'director_by','inspector', 'director'], 'required'],
            [['leave_related_id','inspector_by', 'commander_by', 'director_by',  'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
          
          [['inspector_by', 'commander_by', 'director_by', 'leave_related_id'], 'unique', 'targetAttribute' => ['inspector_by', 'commander_by', 'director_by', 'leave_related_id'], 'message' => 'The combination of ชุดผู้เกี่ยวข้อง, ผู้ตรวจสอบ, ผู้บังคับบัญชา and ผู้ออกคำสั่ง has already been taken.'], 
           [['leave_related_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeaveRelated::className(), 'targetAttribute' => ['leave_related_id' => 'id']], 
           [['inspector_by'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['inspector_by' => 'user_id']], 
           [['commander_by'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['commander_by' => 'user_id']], 
           [['director_by'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['director_by' => 'user_id']], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'leave_related_id' => Yii::t('andahrm/leave', 'ชุดผู้เกี่ยวข้อง'),
            'inspector_by' => Yii::t('andahrm/leave', 'ผู้ตรวจสอบ'),
            'commander_by' => Yii::t('andahrm/leave', 'ผู้บังคับบัญชา'),
            'director_by' => Yii::t('andahrm/leave', 'ผู้ออกคำสั่ง'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
            'inspectors' => Yii::t('andahrm/leave', 'ผู้ตรวจสอบ'),
        ];
    }
   public $inspector;
   public $commander;
   public $director;
   public function getInspectorBy()
    {
        return $this->hasMany(Person::className(), ['user_id' => 'inspector_by']);
    }  
  
    public function getCommanderBy()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'commander_by']);
    }
  
    public function getDirectorBy()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'director_by']);
    }
  
  
  public function getInspectorBySelected()
    {
        return arrayHelper::index($this->inspectorBy,'user_id');
    }
  
}
