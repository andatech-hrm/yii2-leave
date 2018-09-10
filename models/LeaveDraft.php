<?php

namespace andahrm\leave\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\components\helpers\SerializeAttributesBehavior;

/**
 * This is the model class for table "leave_draft".
 *
 * @property int $id
 * @property int $draft_time
 * @property int $user_id
 * @property string $data
 * @property int $status
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class LeaveDraft extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'leave_draft';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['draft_time', 'user_id'], 'required'],
            [['draft_time', 'user_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['data'], 'safe'],
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => SerializeAttributesBehavior::className(),
                'convertAttr' => ['data' => 'json']
            ],
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
    public function attributeLabels() {
        return [
            'id' => Yii::t('andahrm/leave', 'ID'),
            'draft_time' => Yii::t('andahrm/leave', 'Draft Time'),
            'user_id' => Yii::t('andahrm/leave', 'User ID'),
            'data' => Yii::t('andahrm/leave', 'Data'),
            'status' => Yii::t('andahrm/leave', 'Status'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }

    const STATUS_DRAFT = 0;
    const STATUS_USED = 1;

}
