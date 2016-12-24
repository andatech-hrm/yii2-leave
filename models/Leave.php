<?php

namespace andahrm\leave\models;

use Yii;
use andahrm\person\models\Person;

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
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
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
            [['id'], 'required'],
            [['id', 'user_id', 'leave_type_id', 'start_part', 'end_part', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['date_start', 'date_end'], 'safe'],
            [['reason'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['leave_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeaveType::className(), 'targetAttribute' => ['leave_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/leave', 'ID'),
            'user_id' => Yii::t('andahrm/leave', 'ผู้ยื่นลา'),
            'leave_type_id' => Yii::t('andahrm/leave', 'ประเภทการลา'),
            'date_start' => Yii::t('andahrm/leave', 'ตั้งแต่วันที่'),
            'start_part' => Yii::t('andahrm/leave', 'เริ่มช่วง'),
            'date_end' => Yii::t('andahrm/leave', 'ถึงวันที่'),
            'end_part' => Yii::t('andahrm/leave', 'สิ้นสุดช่วง'),
            'reason' => Yii::t('andahrm/leave', 'เหตุผล'),
            'status' => Yii::t('andahrm/leave', 'สถานะ'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }
}
