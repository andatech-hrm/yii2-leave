<?php

namespace andahrm\leave\models;

use Yii;

/**
 * This is the model class for table "leave_permission_transection".
 *
 * @property int $user_id
 * @property string $year
 * @property int $trans_time
 * @property int $leave_trans_cate_id
 * @property int $trans_type
 * @property string $amount
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $leave_id
 *
 * @property LeaveTransCate $leaveTransCate
 */
class LeavePermissionTransection2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_permission_transection';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'year', 'trans_time', 'leave_trans_cate_id', 'trans_type'], 'required'],
            [['user_id', 'trans_time', 'leave_trans_cate_id', 'trans_type', 'created_at', 'created_by', 'updated_at', 'updated_by', 'leave_id'], 'integer'],
            [['year'], 'safe'],
            [['amount'], 'number'],
            [['user_id', 'year', 'trans_time', 'leave_trans_cate_id', 'trans_type'], 'unique', 'targetAttribute' => ['user_id', 'year', 'trans_time', 'leave_trans_cate_id', 'trans_type']],
            [['leave_trans_cate_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeaveTransCate::className(), 'targetAttribute' => ['leave_trans_cate_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('andahrm/leave', 'User ID'),
            'year' => Yii::t('andahrm/leave', 'Year'),
            'trans_time' => Yii::t('andahrm/leave', 'Trans Time'),
            'leave_trans_cate_id' => Yii::t('andahrm/leave', 'Leave Trans Cate ID'),
            'trans_type' => Yii::t('andahrm/leave', 'Trans Type'),
            'amount' => Yii::t('andahrm/leave', 'Amount'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
            'leave_id' => Yii::t('andahrm/leave', 'Leave ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveTransCate()
    {
        return $this->hasOne(LeaveTransCate::className(), ['id' => 'leave_trans_cate_id']);
    }
}
