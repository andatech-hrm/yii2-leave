<?php

namespace andahrm\leave\models;

use Yii;

/**
 * This is the model class for table "leave_cancel".
 *
 * @property integer $leave_id
 * @property string $reason
 * @property string $date_start
 * @property integer $start_part
 * @property string $date_end
 * @property integer $end_part
 * @property integer $status
 * @property string $commander_comment
 * @property integer $commander_by
 * @property integer $commanded_at
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Leave $leave
 */
class LeaveCancel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_cancel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['leave_id', 'date_start', 'date_end'], 'required'],
            [['leave_id', 'start_part', 'end_part', 'status', 'commander_by', 'commanded_at', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['date_start', 'date_end'], 'safe'],
            [['commander_comment'], 'string'],
            [['reason'], 'string', 'max' => 200],
            [['leave_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leave::className(), 'targetAttribute' => ['leave_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'leave_id' => Yii::t('andahrm/leave', 'Leave ID'),
            'reason' => Yii::t('andahrm/leave', 'Reason'),
            'date_start' => Yii::t('andahrm/leave', 'ตั้งแต่วันที่'),
            'start_part' => Yii::t('andahrm/leave', 'เริ่มช่วง'),
            'date_end' => Yii::t('andahrm/leave', 'ถึงวันที่'),
            'end_part' => Yii::t('andahrm/leave', 'สิ้นสุดช่วง'),
            'status' => Yii::t('andahrm/leave', 'สถานะ'),
            'commander_comment' => Yii::t('andahrm/leave', 'ความคิดเห็นผู้บังคับบัญชา'),
            'commander_by' => Yii::t('andahrm/leave', 'Commander By'),
            'commanded_at' => Yii::t('andahrm/leave', 'วันที่'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeave()
    {
        return $this->hasOne(Leave::className(), ['id' => 'leave_id']);
    }
}
