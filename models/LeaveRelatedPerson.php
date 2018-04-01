<?php

namespace andahrm\leave\models;

use Yii;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

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
            //[['user_id', 'leave_related_id'], 'required'],
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
            'user_id' => Yii::t('andahrm/leave', 'Sender'),
            'persons' => Yii::t('andahrm/leave', 'Sender'),
            'leave_related_id' => Yii::t('andahrm/leave', 'Related'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
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
  
  //public $persons;
  
//   public function getLeaveRelatedPeople()
//     {
//         return $this->hasMany(LeaveRelatedPerson::className(), ['leave_related_id' => 'id']);
//     }
  
//     public static function getList(){
//       return ArrayHelper::map(self::find()->all(),'id','title');
//     } 
  
//     public $persons;
  
//     public function getPersonSelected()
//     {
//         return arrayHelper::index($this->leaveRelatedPeople,'user_id');
//     }
  
}
