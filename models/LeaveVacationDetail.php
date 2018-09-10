<?php

namespace andahrm\leave\models;

use Yii;

/**
 * This is the model class for table "leave_vacation_detail".
 *
 * @property int $leave_id
 * @property double $amount_carry
 * @property double $amount_yearly
 * @property double $amount_total
 *
 * @property Leave $leave
 */
class LeaveVacationDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_vacation_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['leave_id'], 'required'],
            [['leave_id'], 'integer'],
            [['amount_carry', 'amount_yearly', 'amount_total'], 'number'],
            [['leave_id'], 'unique'],
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
            'amount_carry' => Yii::t('andahrm/leave', 'Amount Carry'),
            'amount_yearly' => Yii::t('andahrm/leave', 'Amount Yearly'),
            'amount_total' => Yii::t('andahrm/leave', 'Amount Total'),
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
