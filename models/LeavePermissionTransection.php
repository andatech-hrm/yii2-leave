<?php

namespace andahrm\leave\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

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
            [['user_id', 'year', 'trans_time', 'leave_trans_cate_id', 'trans_type'], 'required'],
            [['user_id', 'trans_time', 'leave_trans_cate_id', 'trans_type', 'leave_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['year'], 'safe'],
            [['user_id', 'year', 'trans_time', 'leave_trans_cate_id', 'trans_type'], 'unique', 'targetAttribute' => ['user_id', 'year', 'trans_time', 'leave_trans_cate_id', 'trans_type']],
            [['leave_trans_cate_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeaveTransCate::className(), 'targetAttribute' => ['leave_trans_cate_id' => 'id']],
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
            'leave_trans_cate_id' => Yii::t('andahrm/leave', 'Leave Trans Cate ID'),
            'trans_type' => Yii::t('andahrm/leave', 'Trans Type'),
            'amount' => Yii::t('andahrm/leave', 'Amount'),
            'sumRow' => Yii::t('andahrm/leave', 'Balance'),
//            'leave_type' => Yii::t('andahrm/leave', 'Leave Type'),
            'leave_id' => Yii::t('andahrm/leave', 'Leave ID'),
            'reference' => Yii::t('andahrm/leave', 'Reference'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }

    public $sumRow;

    /**
     * @const Type
     */
    const TYPE_ADD = 1; #เพิ่มโควต้า
    const TYPE_MINUS = 2; #ใช้ไป
//    const TYPE_CARRY = 3; #ยกยอด
//    const TYPE_RESTORE = 4; #ยกเลิก

    /**
     * @const Type
     */
    const CATE_YEARLY = 1; #เพิ่มโควต้า
    const CATE_CARRY = 2; #วันลาสะสม
    const CATE_EXTRA = 3; #วันลาพิเศษ
    const CATE_USE = 4; #ใช้ไป
    const CATE_CANCEL = 5; #ยกเลิก
    const CATE_RESTORE = 6; #คืนวันลา
    const TOTAL = 'total'; #รวมทั้งหมด

    public static function itemsAlias($key) {
        $items = [
            'type' => [
                self::TYPE_ADD => Yii::t('andahrm/leave', 'Add'),
                self::TYPE_MINUS => Yii::t('andahrm/leave', 'Minus'),
//                self::TYPE_CARRY => Yii::t('andahrm/leave', 'Carry'),
//                self::TYPE_RESTORE => Yii::t('andahrm/leave', 'Restore'),
            ],
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getTypeLabel() {
        return ArrayHelper::getValue(self::itemsAlias('type'), $this->trans_type);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveTransCate() {
        return $this->hasOne(LeaveTransCate::className(), ['id' => 'leave_trans_cate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getLeaveCondition() {
//        return $this->hasOne(LeaveCondition::className(), ['id' => 'leave_condition_id']);
//    }

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

    /**
     * Func สำหรับดึงยอดตามประเภทต่างๆ
     * @param type $user_id
     * @param type $year
     * @return boolean
     */
    public static function getAmountOnType($user_id, $year) {
        $options = ['user_id' => $user_id, 'year' => $year];
        $trans = self::findAll($options);
        if ($trans) {
            $data = self::itemsAlias('type');

            foreach ($data as $k => $d)
                $data[$k] = 0;
            foreach ($trans as $tran) {
                $data[$tran->trans_type] += $tran->amount;
            }
        }
        return $data;
    }

    /**
     * Func สำหรับดึงยอดตามประเภทต่างๆ
     * @param type $user_id
     * @param type $year
     * @return boolean
     */
    public static function getAmountOnCate($user_id, $year) {
        $options = ['user_id' => $user_id, 'year' => $year];
        $trans = self::find()->where($options)
                ->select(['leave_trans_cate_id', 'amount' => 'SUM(amount)'])
                ->groupBy('leave_trans_cate_id')
                ->asArray()
                ->all();
        return ArrayHelper::map($trans, 'leave_trans_cate_id', 'amount');
    }

    /**
     * Func สำหรับใช้ใน Form
     */
    public static function getDataForForm($user_id, $year) {
        $data = self::getAmountOnCate($user_id, $year);
        $data[self::CATE_CARRY] = $data[self::CATE_CARRY] ? $data[self::CATE_CARRY] : 0;
        #มีสิทธิลาพักผ่อนประจำปีนี้อีก
        $data[self::CATE_YEARLY] = $data[self::CATE_YEARLY] - $data[self::CATE_USE];
        #รวมเป็น
        $data[self::TOTAL] = $data[self::CATE_YEARLY] + $data[self::CATE_CARRY];
        return $data;
    }

    /**
     * Func สำหรับยกยอดจำนวนโควต้า
     * @param type $user_id
     * @param type $year
     * @return boolean
     */
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
                //$options = ['user_id' => $user_id, 'year' => $year, 'trans_type' => LeavePermissionTransection::TYPE_CARRY];
                $options = ['user_id' => $user_id, 'year' => $year, 'trans_type' => LeavePermissionTransection::TYPE_ADD, 'leave_trans_cate_id' => LeavePermissionTransection::CATE_CARRY];
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

    public function getReference($route = null) {
        $requestForm = 'andahrm\leave\models\Leave';
        $route = '/leave/default/view';
        $topic = 'ใบลาเลขที่ ';
        if ($requestForm) {
            $model = $requestForm::find()->where(['id' => $this->leave_id])->one();

            if (isset($model->id) && $route)
                return $topic . \yii\helpers\Html::a($model->id, [$route, 'id' => $model->id]);
            if (isset($this->request_id))
                return $topic . $this->request_id;
            return null;
        } else {
            return ($topic ? $topic : '') . $this->request_id;
        }
    }

}
