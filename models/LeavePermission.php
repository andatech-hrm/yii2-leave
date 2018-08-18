<?php

namespace andahrm\leave\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
###
use andahrm\leave\base\YearConverter;
use andahrm\person\models\Person;
use andahrm\leave\models\PersonLeave;
use andahrm\structure\models\FiscalYear;

/**
 * This is the model class for table "leave_permission".
 *
 * @property int $user_id
 * @property int $leave_condition_id
 * @property string $year
 * @property int $number_day
 * @property string $credit 
 * @property string $debit 
 * @property string $balance 
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property LeaveCondition $leaveCondition
 */
class LeavePermission extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'leave_permission';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id',], 'required'],
            [['user_id', 'leave_condition_id', 'number_day', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['year'], 'safe'],
            [['credit', 'debit', 'balance'], 'number'],
            //[['user_id', 'leave_condition_id', 'year'], 'unique', 'targetAttribute' => ['user_id', 'leave_condition_id', 'year']],
            [['leave_condition_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeaveCondition::className(), 'targetAttribute' => ['leave_condition_id' => 'id']],
        ];
    }

    public $amount;

    const SCENARIOS_UPDATE = 'update';

    public function scenarios() {
        $scenarios[self::SCENARIOS_UPDATE] = ['user_id', 'year_credit', 'credit', 'insure', 'balance'];
        return array_merge(parent::scenarios(), $scenarios);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
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
    public function getLeaveCondition() {
        return $this->hasOne(LeaveCondition::className(), ['id' => 'leave_condition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
//         return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
        return $this->hasOne(PersonLeave::className(), ['user_id' => 'user_id']);
    }

    public function getCreatedBy() {
        return $this->hasOne(PersonLeave::className(), ['user_id' => 'created_by']);
    }

    public function getUpdatedBy() {
        return $this->hasOne(PersonLeave::className(), ['user_id' => 'updated_by']);
    }

    public static function getPermission($user_id = null, $year = null) {
        $year = $year ? $year : date('Y');
        $user_id = $user_id ? $user_id : Yii::$app->user->id;

        $userNumber = self::find()
                ->where(['year' => $year])
                ->andWhere(['user_id' => $user_id])
                ->one();

        return $userNumber ? $userNumber->number_day : 0;
    }

    #วันสะสมทั้งหมด

    public static function getPermissionAll($user_id = null, $year = null) {
        $year = $year ? $year : date('Y');
        $user_id = $user_id ? $user_id : Yii::$app->user->id;

        $permissionAll = LeavePermission::find()
                ->where(['<=', 'year', $year])
                ->andWhere(['user_id' => $user_id])
                ->sum('number_day');

        return $permissionAll ? $permissionAll : 0;
    }

    public static function updateBalance($id, $year = null) {
        $year = $year == null ? FiscalYear::getYearly() : $year;
        $options = ['user_id'=>$id,'year'=>$year];
        if (!$model = self::findOne($options)) {
            $model = new self($options);
        }


        if ($model) {
//            echo ($id);
//            exit();
            $err = [];
            $countAll = 0;
            $trans = LeavePermissionTransection::findAll($options);
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
                $model->attributes = $data;
                //$model->request_form_id = $request_id;
                //$model->scenario = WelfareCredit::SCENARIOS_SYNC;
                if ($model->save()) {
                    //$this->saveLog();
//                    print_r($model->attributes);
//                    exit();
                } else {
                    print_r($model->getErrors());
                    exit();
                }
            }
        }
        return true;
    }

}
