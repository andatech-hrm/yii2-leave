<?php

namespace andahrm\leave\models;

use Yii;

use andahrm\structure\models\Section; #mad
use yii\helpers\ArrayHelper;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "leave_related_section".
 *
 * @property integer $section_id
 * @property integer $leave_related_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Section $section
 * @property LeaveRelated $leaveRelated
 */
class LeaveRelatedSection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_related_section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'leave_related_id'], 'required'],
            [['section_id', 'leave_related_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
            [['leave_related_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeaveRelated::className(), 'targetAttribute' => ['leave_related_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'section_id' => Yii::t('andahrm/leave', 'Section ID'),
            'leave_related_id' => Yii::t('andahrm/leave', 'Leave Related ID'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveRelated()
    {
        return $this->hasOne(LeaveRelated::className(), ['id' => 'leave_related_id']);
    }
    
    
    public function getInspectors()
   {
       return ArrayHelper::map($this->leaveRelated->leaveRelatedInspectors,'user_id','user.fullname','user.positionTitle');
   }
  
  public function getCommanders()
   {
       return ArrayHelper::map($this->leaveRelated->leaveRelatedCommanders,'user_id','user.fullname','user.positionTitle');
   }
  
  public function getDirectors()
   {
       return ArrayHelper::map($this->leaveRelated->leaveRelatedDirectors,'user_id','user.fullname','user.positionTitle');
   }
   
   public function getToDirector()
   {
       $model = $this
         ->leaveRelated
         ->leaveRelatedDirectors;
       return $model?$model[0]->user->positionTitle:'';
   }
   
   public static function getSectionSelected($leave_related_id=null){
       return $leave_related_id?arrayHelper::getColumn(self::find()
       ->where(['leave_related_id'=>$leave_related_id])
       ->all(),'section_id'):null;
   }
   
   public static function getSectionSelectedOther($leave_related_id=null){
       $model =arrayHelper::getColumn(self::find()
       ->andFilterWhere(['!=','leave_related_id',$leave_related_id])
       ->all(),'section_id');
       
       $new_select = [];
       foreach($model as $ss){
           $new_select[$ss]=['disabled'=>true];
       }
       
       
       return $new_select;
   }
}
