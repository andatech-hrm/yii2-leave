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
            [['title','inspectors','commanders', 'directors'], 'required' ,'on'=>['insert','update']],
            [['persons'], 'required','on'=>'assign'],
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
             'approver' => Yii::t('andahrm/leave', 'ผู้มีอำนาจอนุมัติ'),
             'inspectors' => Yii::t('andahrm/leave', 'ผู้ตรวจสอบ'),
             'commanders' => Yii::t('andahrm/leave', 'ผู้บังคับบัญชา'),
             'directors' => Yii::t('andahrm/leave', 'ผู้ออกคำสั่ง'),
             'persons' => Yii::t('andahrm/leave', 'บุคลากร'),
        ];
    }
  
    /**
    * @return \yii\db\ActiveQuery
    */
   public function getLeaveRelatedApprover() 
   { 
       return $this->hasMany(LeaveRelatedApprover::className(), ['leave_related_id' => 'id']); 
   } 

    /**
     * @return \yii\db\ActiveQuery
     */
    
  
    public static function getList(){
      return ArrayHelper::map(self::find()->all(),'id','title');
    } 
  
    
  
  
   public $inspectors;
   public $commanders;
   public $directors;
   public $persons;
  
    /**
    * @return \yii\db\ActiveQuery
    */
   public function getLeaveRelatedInspectors()
   {
       return $this->hasMany(LeaveRelatedInspector::className(), ['leave_related_id' => 'id']);
   }
  
  public function getLeaveRelatedCommanders()
   {
       return $this->hasMany(LeaveRelatedCommander::className(), ['leave_related_id' => 'id']);
   }
  
  public function getLeaveRelatedDirectors()
   {
       return $this->hasMany(LeaveRelatedDirector::className(), ['leave_related_id' => 'id']);
   }
  
  public function getLeaveRelatedPeople()
    {
        return $this->hasMany(LeaveRelatedPerson::className(), ['leave_related_id' => 'id']);
    }
  
  
    ############### Selected ##########
    public function getInspectorSelected()
    {
      return ArrayHelper::getColumn($this->leaveRelatedInspectors, function ($element) {
    return $element['user_id'];
      });
    } 
  
    public function getCommanderSelected()
    {
      return ArrayHelper::getColumn($this->leaveRelatedCommanders, function ($element) {
    return $element['user_id'];
});
    }
  
    public function getDirectorSelected()
    {
        //return arrayHelper::index($this->leaveRelatedDirectors,'user_id');
      return ArrayHelper::getColumn($this->leaveRelatedDirectors, function ($element) {
    return $element['user_id'];
});
    }
  
    public function getPersonSelected()
    {
        //return arrayHelper::index($this->leaveRelatedPeople,'user_id');
      
      return ArrayHelper::getColumn($this->leaveRelatedPeople, function ($element) {
    return $element['user_id'];
});
    }
  
    public static function getPerson(){
      
      $select = ArrayHelper::getColumn(LeaveRelatedPerson::find()->all(), function ($element) {
          return $element['user_id'];
      });
      //print_r($select);
      $model = PersonLeave::find()              
              ->joinWith('leaveRelatedPerson', false, 'LEFT JOIN')
              ->where(['not in','person.user_id',$select])
              ->all();
      return arrayHelper::getColumn($model,function ($element) {
          return $element['fullname'];
      });  

    }
  
}
