<?php

namespace andahrm\leave\models;

use Yii;

/**
 * This is the model class for table "leave_permission_transection".
 *
 * @property int $user_id
 * @property int $trans_time
 * @property int $trans_type
 * @property string $amount
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property LeaveCondition $leaveCondition
 */
class LeavePermissionTransection extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'leave_permission_transection';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'trans_time', 'trans_type'], 'required'],
            [['user_id', 'trans_time', 'trans_type', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['user_id', 'trans_time', 'trans_type'], 'unique', 'targetAttribute' => ['user_id', 'trans_time', 'trans_type']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => Yii::t('andahrm/leave', 'User ID'),
            'trans_time' => Yii::t('andahrm/leave', 'Trans Time'),
            'trans_type' => Yii::t('andahrm/leave', 'Trans Type'),
            'amount' => Yii::t('andahrm/leave', 'Amount'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }

    const TYPE_ADD = 1;
    const TYPE_MINUS = 2;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveCondition() {
        return $this->hasOne(LeaveCondition::className(), ['id' => 'leave_condition_id']);
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
            //echo $this->user_id;
            LeavePermission::updateBalance($this->user_id);
        }
        //LeavePermission::updateBalance($this->user_id);
        if (parent::afterSave($insert, $changedAttributes)) {
            return true; // do some otherthings
        }
    }

}
