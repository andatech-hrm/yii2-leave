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
            'date_start' => Yii::t('andahrm/leave', 'Date Start'),
            'start_part' => Yii::t('andahrm/leave', 'Start Part'),
            'date_end' => Yii::t('andahrm/leave', 'Date End'),
            'end_part' => Yii::t('andahrm/leave', 'End Part'),
            'status' => Yii::t('andahrm/leave', 'Status'),
            'commander_comment' => Yii::t('andahrm/leave', 'Commander Comment'),
            'commander_by' => Yii::t('andahrm/leave', 'Commander By'),
            'commanded_at' => Yii::t('andahrm/leave', 'Commander At'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
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
