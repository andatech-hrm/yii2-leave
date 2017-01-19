<?php

namespace andahrm\leave\models;

use Yii;
use andahrm\person\models\Person;
use yii\helpers\ArrayHelper;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "leave".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $leave_type_id
 * @property string $date_start
 * @property integer $start_part
 * @property string $date_end
 * @property integer $end_part
 * @property string $reason
 * @property integer $acting_user_id
 * @property integer $status
 * @property string $inspector_comment
 * @property integer $inspector_status
 * @property integer $inspector_by
 * @property integer $inspector_at
 * @property string $commander_comment
 * @property integer $commander_status
 * @property integer $commander_by
 * @property integer $commanded_at
 * @property string $director_comment
 * @property integer $director_status
 * @property integer $director_by
 * @property integer $director_at
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Person $user
 * @property LeaveType $leaveType
 * @property LeaveCancel $leaveCancel
 */
class Leave extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'leave_type_id', 'start_part', 'end_part', 'acting_user_id', 'status', 'inspector_status', 'inspector_by', 'inspector_at', 'commander_status', 'commander_by', 'commanded_at', 'director_status', 'director_by', 'director_at', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [[ 'date_start', 'date_end'], 'required'],
            [['date_start', 'date_end'], 'safe'],
            [['reason'], 'string'],
            [['to', 'inspector_comment', 'commander_comment', 'director_comment'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['leave_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeaveType::className(), 'targetAttribute' => ['leave_type_id' => 'id']],
            [['leave_type_id'] ,'default','value'=>4,'on'=>'create-vacation'],
            ['status','default','value'=>0,'when'=>
              function($model){ return $model->isNewRecord; }
            ],
        ];
    }
  
    public function scenario(){
      return [
        'create-vacation' =>   ['user_id','leave_type_id','date_start', 'date_end','status'],
        'create-vacation' =>   ['status'],
      ];
    }
  
  function behaviors()
    {
        return [ 
          'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/leave', 'ID'),
            'to' => Yii::t('andahrm/structure', 'เรียน'),
            'user_id' => Yii::t('andahrm/leave', 'ผู้ยื่นลา'),
            'leave_type_id' => Yii::t('andahrm/leave', 'ประเภทการลา'),
            'date_start' => Yii::t('andahrm/leave', 'ตั้งแต่วันที่'),
            'start_part' => Yii::t('andahrm/leave', 'เริ่มช่วง'),
            'date_end' => Yii::t('andahrm/leave', 'ถึงวันที่'),
            'end_part' => Yii::t('andahrm/leave', 'สิ้นสุดช่วง'),
            'reason' => Yii::t('andahrm/leave', 'เหตุผล'),
            'acting_user_id' => Yii::t('andahrm/leave', 'ผู้ปฎิบัติราชการแทน'),
            'status' => Yii::t('andahrm/leave', 'สถานะ'),
            'inspector_comment' => Yii::t('andahrm/leave', 'ความคิดเห็นผู้ตรวจสอบ'),
            'inspector_status' => Yii::t('andahrm/leave', 'สถานะ'),
            'inspector_by' => Yii::t('andahrm/leave', 'ผู้ตรวจสอบ'),
            'inspector_at' => Yii::t('andahrm/leave', 'วันที่'),
            'commander_comment' => Yii::t('andahrm/leave', 'ความคิดเห็นผู้บังคับบัญชา'),
            'commander_status' => Yii::t('andahrm/leave', 'สถานะ'),
            'commander_by' => Yii::t('andahrm/leave', 'ผู้บังคับบัญชา'),
            'commanded_at' => Yii::t('andahrm/leave', 'วันที่'),
            'director_comment' => Yii::t('andahrm/leave', 'ความคิดเห็นผู้สั่งการ'),
            'director_status' => Yii::t('andahrm/leave', 'คำสั่ง'),
            'director_by' => Yii::t('andahrm/leave', 'ผู้ออกคำสั่ง'),
            'director_at' => Yii::t('andahrm/leave', 'วันที่'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }
  
//       public function beforeSave($insert) {
//         if ($insert) {
//             $this->user_id = \Yii::$app->user->identity->id;
//         } else {
            
//         }
//         return parent::beforeSave($insert);
//     }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
//         return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveType()
    {
        return $this->hasOne(LeaveType::className(), ['id' => 'leave_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveCancel()
    {
        return $this->hasOne(LeaveCancel::className(), ['leave_id' => 'id']);
    }
  
    public static function getActingList()
    {
      $model = Person::find()->where(['!=','user_id',Yii::$app->user->id])->all();
        return ArrayHelper::map($model,'user_id','fullname');
    }
  
  
  
}
