<?php

namespace andahrm\leave\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "leave_permission_transection".
 *
 * @property int $user_id
 * @property string $year
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

    function behaviors() {
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
    public function rules() {
        return [
            [['user_id', 'year', 'trans_time', 'trans_type'], 'required'],
            [['user_id', 'trans_time', 'trans_type', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['year'], 'safe'],
            [['user_id', 'trans_time', 'trans_type'], 'unique', 'targetAttribute' => ['user_id', 'trans_time', 'trans_type']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => Yii::t('andahrm/leave', 'User ID'),
            'year' => Yii::t('andahrm/leave', 'Year'),
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
    const TYPE_CARRY = 3;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveCondition() {
        return $this->hasOne(LeaveCondition::className(), ['id' => 'leave_condition_id']);
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
            //echo $this->user_id;
            LeavePermission::updateBalance($this->user_id, $this->year);
        }
        //LeavePermission::updateBalance($this->user_id, $this->year);
        if (parent::afterSave($insert, $changedAttributes)) {
            return true; // do some otherthings
        }
    }

    public static function getLastBalanceYear($user_id, $year) {
        $options = ['user_id' => $user_id, 'year' => ($year - 1)];
        $trans = self::findAll($options);
        if ($trans) {
            $data['credit'] = 0;
            $data['debit'] = 0;
            $data['balance'] = 0;
            foreach ($trans as $tran) {
                if ($tran->trans_type == LeavePermissionTransection::TYPE_MINUS) {
                    $data['debit'] += $tran->amount;
                } else {
                    $data['credit'] += $tran->amount;
                }
            }
            $data['balance'] = $data['credit'] - $data['debit'];
            if ($data['balance']) {
                $options = ['user_id' => $user_id, 'year' => $year, 'trans_type' => LeavePermissionTransection::TYPE_CARRY];
                if (!$model = self::findOne($options)) {
                    $model = new self($options);
                    $model->amount = $data['balance'];
                    $model->trans_time = time();
                    //$model->trans_type = LeavePermissionTransection::TYPE_CARRY;
                    if (!$model->save()) {
                        //print_r($model);
                        // exit();
                    }
                    return true;
                }
            }
        }
        return null;
    }

}
