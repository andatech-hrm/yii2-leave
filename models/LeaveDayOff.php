<?php

namespace andahrm\leave\models;

use Yii;

/**
 * This is the model class for table "leave_day_off".
 *
 * @property integer $id
 * @property string $title
 * @property string $date_start
 * @property string $date_end
 * @property string $detail
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class LeaveDayOff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_day_off';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['date_start', 'date_end'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['detail'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/leave', 'ID'),
            'title' => Yii::t('andahrm/leave', 'Title'),
            'date_start' => Yii::t('andahrm/leave', 'Date Start'),
            'date_end' => Yii::t('andahrm/leave', 'Date End'),
            'detail' => Yii::t('andahrm/leave', 'Detail'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'Created By'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }
}
