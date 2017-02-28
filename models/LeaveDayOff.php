<?php

namespace andahrm\leave\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use kuakling\datepicker\behaviors\DateBuddhistBehavior;
use andahrm\setting\models\Helper;

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
  
  
    function behaviors()
    {
        return [ 
          'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            'date_start' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'date_start',
            ],
            'date_end' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'date_end',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_start', 'date_end'], 'safe'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
        ];
    }
    
     public function getCreatedBy(){      
        return  $this->hasOne(PersonLeave::className(), ['user_id' => 'created_by']);
    }
  
    public function getUpdatedBy(){      
        return  $this->hasOne(PersonLeave::className(), ['user_id' => 'updated_by']);
    }
  
  public static function getList(){
//     return ArrayHelper::getColumn(self::find()->all(), function ($model) {
//         return self::createDateRange($model->date_start,$model->date_end);
//     });
    $data = self::find()
      ->select(['date_start','date_end'])
      ->all();
    $days = [];
    foreach($data as $model){
      $date_end = date('Y-m-d',strtotime($model->date_end."+1 days"));
      //echo $date_end;
      $dateRange = self::createDateRange($model->date_start,$date_end);     
      //foreach($dateRange as $day) $days[] =  $day;
      foreach($dateRange as $day) $days[] =  Yii::$app->formatter->asDate($day, 'php:d/m/Y');
    }    
    return $days;
  }
  
  
  public static function getListOfCheck(){
    $data = self::find()
      ->select(['date_start','date_end'])
      ->all();
    $days = [];
    foreach($data as $model){
      $date_end = date('Y-m-d',strtotime($model->date_end."+1 days"));
      //echo $date_end;
      $dateRange = self::createDateRange($model->date_start,$date_end);     
      //foreach($dateRange as $day) $days[] =  $day;
      foreach($dateRange as $day) $days[] =  $day;
    }    
    return $days;
  }
  
  
  /**
  * สร้างช่วงของวันที่
  *
  */
       public static function createDateRange($startDate, $endDate, $format = "Y-m-d")
      {
          $begin = new \DateTime($startDate);
          $end = new \DateTime($endDate);

          $interval = new \DateInterval('P1D'); // 1 Day
          $dateRange = new \DatePeriod($begin, $interval, $end);

          $range = [];
          foreach ($dateRange as $date) {
              $range[] = $date->format($format);
          }    
          return $range;
      }
  
  /**
  *  เช็ควันหยุดราชการ
  *
  */
  public static function checkDayOff($date){
    $data = self::getListOfCheck();
    // print_r($data);
    // echo "<hr/>";
    // echo $date;
    return ArrayHelper::isIn($date,$data);
  }
  
}
