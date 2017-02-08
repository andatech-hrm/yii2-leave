<?php

namespace andahrm\leave\models;

use Yii;

use yii\db\ActiveRecord;
use andahrm\leave\base\YearConverter;
  
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;


use andahrm\person\models\Person;
/**
 * This is the model class for table "leave_permission".
 *
 * @property integer $user_id
 * @property integer $leave_condition_id
 * @property string $year
 * @property integer $number_day
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property LeaveCondition $leaveCondition
 */
class LeavePermission extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_permission';
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
            [['year'], 'required','on'=>'create'],
            [['user_id', 'number_day', 'year'], 'required','on'=>'insert'],
            [['user_id', 'leave_condition_id', 'number_day', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['year'], 'safe'],
          [['leave_condition_id'],'default','value'=>3],
            [['leave_condition_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeaveCondition::className(), 'targetAttribute' => ['leave_condition_id' => 'id']],
        ];
    }

  public $person_type_id;
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('andahrm/leave', 'User ID'),
            'leave_condition_id' => Yii::t('andahrm/leave', 'Leave Condition ID'),
            'year' => Yii::t('andahrm/leave', 'Year'),
            'number_day' => Yii::t('andahrm/leave', 'Number Day'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveCondition()
    {
        return $this->hasOne(LeaveCondition::className(), ['id' => 'leave_condition_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
//         return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }
}
