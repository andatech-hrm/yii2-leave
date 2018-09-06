<?php

namespace andahrm\leave\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "leave_trans_cate".
 *
 * @property int $id
 * @property string $title
 * @property int $type
 */
class LeaveTransCate extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'leave_trans_cate';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'type'], 'required'],
            [['type'], 'integer'],
            [['title'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('andahrm/leave', 'ID'),
            'title' => Yii::t('andahrm/leave', 'Title'),
            'type' => Yii::t('andahrm/leave', 'Type'),
        ];
    }

    public static function getList($type = null) {
        return ArrayHelper::map(self::find()->andFilterWhere(['type' => $type])->all(), 'id', 'title');
    }

}
