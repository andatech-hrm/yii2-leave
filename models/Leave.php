<?php

namespace andahrm\leave\models;

use Yii;
use andahrm\person\models\Person;
use andahrm\leave\models\PersonLeave;
use yii\helpers\ArrayHelper;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use andahrm\structure\models\FiscalYear;

/**
 * This is the model class for table "leave".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $leave_type_id
 * @property string $date_start
 * @property integer $start_part
 * @property string $date_end
 * @property integer $end_part
 * @property string $reason
 * @property integer $acting_user_id
 * @property integer $status
 * @property string $inspector_comment
 * @property integer $inspector_status
 * @property integer $inspector_by
 * @property integer $inspector_at
 * @property string $commander_comment
 * @property integer $commander_status
 * @property integer $commander_by
 * @property integer $commander_at
 * @property string $director_comment
 * @property integer $director_status
 * @property integer $director_by
 * @property integer $director_at
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Person $user
 * @property LeaveType $leaveType
 * @property LeaveCancel $leaveCancel
 */
class Leave extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'leave_type_id', 'start_part', 'end_part', 'acting_user_id', 'status', 'inspector_status', 'inspector_by', 'inspector_at', 'commander_status', 'commander_by', 'commander_at', 'director_status', 'director_by', 'director_at', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['to','acting_user_id', 'inspector_by','director_by','date_start', 'date_end','contact'], 'required'],
            [['year','date_start', 'date_end'], 'safe'],
            [['reason','contact'], 'string'],
            [['number_day'], 'number'],
            [['to', 'inspector_comment', 'commander_comment', 'director_comment'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['leave_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeaveType::className(), 'targetAttribute' => ['leave_type_id' => 'id']],
            [['leave_type_id'] ,'default','value'=>4],
            ['status','default','value'=>0,'when'=>
              function($model){ return $model->isNewRecord; } 
            ],
        ];
    }
  
    public function scenarios(){
      $scenarios = parent::scenarios();
      
      $scenarios['create-vacation'] = ['to','year', 'user_id','leave_type_id','acting_user_id','contact', 'date_start', 'date_end','status','inspector_by','director_by','commander_by','start_part','end_part','contact','number_day','year'];
      
      $scenarios['confirm'] = ['status'];
      
      $scenarios['inspector'] = ['status','inspector_status', 'inspector_at','inspector_comment'];
      $scenarios['commander'] = ['status','commander_status', 'commander_at', 'commander_comment'];
      $scenarios['director'] = ['status','director_status', 'director_at', 'director_comment'];
      
      return $scenarios;
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
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/leave', 'ID'),
            'to' => Yii::t('andahrm/structure', 'เรียน'),
            'year' => Yii::t('andahrm/structure', 'ปีงบประมาณ'),
            'user_id' => Yii::t('andahrm/leave', 'ผู้ยื่นลา'),
            'leave_type_id' => Yii::t('andahrm/leave', 'ประเภทการลา'),
            'contact' => Yii::t('andahrm/leave', 'ติดต่อ'),
            'date_start' => Yii::t('andahrm/leave', 'ตั้งแต่วันที่'),
            'start_part' => Yii::t('andahrm/leave', 'เริ่มช่วง'),
            'date_end' => Yii::t('andahrm/leave', 'ถึงวันที่'),
            'end_part' => Yii::t('andahrm/leave', 'สิ้นสุดช่วง'),
            'reason' => Yii::t('andahrm/leave', 'เหตุผล'),
            'number_day' => Yii::t('andahrm/leave', 'จำนวนวันลา'),
            'acting_user_id' => Yii::t('andahrm/leave', 'ผู้ปฎิบัติราชการแทน'),
            'status' => Yii::t('andahrm/leave', 'สถานะ'),
            'inspector_comment' => Yii::t('andahrm/leave', 'ความคิดเห็นผู้ตรวจสอบ'),
            'inspector_status' => Yii::t('andahrm/leave', 'ผู้ตรวจสอบ'),
            'inspector_by' => Yii::t('andahrm/leave', 'ผู้ตรวจสอบ'),
            'inspector_at' => Yii::t('andahrm/leave', 'วันที่'),
            'commander_comment' => Yii::t('andahrm/leave', 'ความคิดเห็นผู้บังคับบัญชา'),
            'commander_status' => Yii::t('andahrm/leave','ผู้บังคับบัญชา'),
            'commander_by' => Yii::t('andahrm/leave', 'ผู้บังคับบัญชา'),
            'commander_at' => Yii::t('andahrm/leave', 'วันที่'),
            'director_comment' => Yii::t('andahrm/leave', 'ความคิดเห็นผู้สั่งการ'),
            'director_status' => Yii::t('andahrm/leave', 'คำสั่ง'),
            'director_by' => Yii::t('andahrm/leave', 'ผู้ออกคำสั่ง'),
            'director_at' => Yii::t('andahrm/leave', 'วันที่'),
            'created_at' => Yii::t('andahrm/leave', 'Created At'),
            'created_by' => Yii::t('andahrm/leave', 'ผู้ยื่นลา'),
            'updated_at' => Yii::t('andahrm/leave', 'Updated At'),
            'updated_by' => Yii::t('andahrm/leave', 'Updated By'),
        ];
    }
   const STATUS_DRAFT = 0;
   const STATUS_OFFER = 1;
   const STATUS_CONSIDER = 2;
   const STATUS_ALLOW = 3;
   const STATUS_DISALLOW = 4;
   const STATUS_CANCEL = 5;
  
   const ALL_DAY = 1;
   const HALF_DAY_MORNIG = 2;
   const LATE_AFTERNOON = 3;
  
   const ALLOW = 1;
   const DISALLOW = 0;
  
  public static function itemsAlias($key) {
        $items = [
            'status' => [
                self::STATUS_DRAFT => Yii::t('andahrm/leave', 'ร่าง'),
                self::STATUS_OFFER => Yii::t('andahrm/leave', 'เสนอ'),
                self::STATUS_CONSIDER => Yii::t('andahrm/leave', 'พิจารณา'),
                self::STATUS_ALLOW => Yii::t('andahrm/leave', 'อนุมัติ'),
                self::STATUS_DISALLOW => Yii::t('andahrm/leave', 'ไม่อนุมัติ'),
                self::STATUS_CANCEL => Yii::t('andahrm/leave', 'ยกเลิก'),
            ],
          'inspactor_status' => [
                self::ALLOW => Yii::t('andahrm/leave', 'ผ่าน'),
                self::DISALLOW => Yii::t('andahrm/leave', 'ไม่ผ่าน'),
            ],
          'commander_status' => [
                self::ALLOW => Yii::t('andahrm/leave', 'เห็นชอบ'),
                self::DISALLOW => Yii::t('andahrm/leave', 'ไม่เห็นชอบ'),
            ],
          'director_status' => [
                self::ALLOW => Yii::t('andahrm/leave', 'อนุญาต'),
                self::DISALLOW => Yii::t('andahrm/leave', 'ไม่อนุญาต'),
            ],
            'start_part'=> [
                self::ALL_DAY => Yii::t('andahrm/leave','ทั้งวัน'),
                self::HALF_DAY_MORNIG => Yii::t('andahrm/leave','ครึ่งวันเช้า'),
                self::LATE_AFTERNOON =>  Yii::t('andahrm/leave','ครึ่งวันบ่าย'),
            ],
            'end_part' => [
                self::ALL_DAY => Yii::t('andahrm/leave','ทั้งวัน'),
                self::HALF_DAY_MORNIG => Yii::t('andahrm/leave','ครึ่งวันเช้า'),
                self::LATE_AFTERNOON =>  Yii::t('andahrm/leave','ครึ่งวันบ่าย'),
            ]
        ];
        return ArrayHelper::getValue($items, $key, []);
    }
  
  public function getStatusLabel() {
        $status = ArrayHelper::getValue($this->getItemStatus(), $this->status);
        $status = ($this->status === NULL) ? ArrayHelper::getValue($this->getItemStatus(), 0) : $status;
        switch ($this->status) {
            case 0 :
            case NULL :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case 1 :
                $str = '<span class="label label-primary">' . $status . '</span>';                
                break;
            case 2 :
                $str = '<span class="label label-primary">' . $status . '</span>';
                break;
            case 3 :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;
            case 4 :
                $str = '<span class="label label-error">' . $status . '</span>';
                break;
            case 5 :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            default :
                $str = $status;
                break;
        }

        return $str;
    }
  
  public function getInspactorStatusLabel() {
        $selected_status = $this->inspector_status;
        $status = ArrayHelper::getValue($this->getItemInspactorStatus(), $selected_status);
        $status = ($selected_status === NULL) ? ArrayHelper::getValue($this->getItemInspactorStatus(), 0) : $status;
        switch ($selected_status) {
           
            case NULL :
                $str = '-';
                break;
            case 0 :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case 1 :
                $str = '<span class="label label-success">' . $status . '</span>';                
                break;
            default :
                $str = $status;
                break;
        }
        $str= $this->inspector_at?$str.'<br/><small>'.Yii::$app->formatter->asDate($this->inspector_at)."</small>":$str;
        return $str;
    }
    public function getCommanderStatusLabel() {
        $selected_status = $this->commander_status;
        $status = ArrayHelper::getValue($this->getItemInspactorStatus(), $selected_status);
        $status = ($selected_status === NULL) ? ArrayHelper::getValue($this->getItemInspactorStatus(), 0) : $status;
        switch ($selected_status) {
           
            case NULL :
                $str = '-';
                break;
            case 0 :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case 1 :
                $str = '<span class="label label-success">' . $status . '</span>';                
                break;
            default :
                $str = $status;
                break;
        }
        $str= $this->commander_at?$str.'<br/><small>'.Yii::$app->formatter->asDate($this->commander_at)."</small>":$str;
        return $str;
    }
  
  public function getDirectorStatusLabel() {
        $selected_status = $this->director_status;
        $status = ArrayHelper::getValue($this->getItemInspactorStatus(), $selected_status);
        $status = ($selected_status === NULL) ? ArrayHelper::getValue($this->getItemInspactorStatus(), 0) : $status;
        switch ($selected_status) {
           
            case NULL :
                $str = '-';
                break;
            case 0 :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case 1 :
                $str = '<span class="label label-success">' . $status . '</span>';                
                break;
            default :
                $str = $status;
                break;
        }
        $str= $this->director_at?$str.'<br/><small>'.Yii::$app->formatter->asDate($this->director_at)."</small>":$str;
        return $str;
    }
  
  public function getStartPartLabel() {
       return ArrayHelper::getValue($this->getItemStartPart(), $this->start_part);
  }
  
  public function getEndPartLabel() {
       return ArrayHelper::getValue($this->getItemEndPart(), $this->end_part);
  }
  
 public static function getWidgetStatus($status,$items){
   $widget = '';
   foreach($items as $key => $item){
      $widget .= ' <i class="fa '.(($status==$key&&$status!=null)?'fa-check-square-o':'fa-square-o').' aria-hidden="true"></i> '.$item; 
    }
   return $widget;
 }
  ##############################
  
    public static function getItemStatus() {
          return self::itemsAlias('status');
     }
  
    public static function getItemInspactorStatus() {
        return self::itemsAlias('inspactor_status');
    }
  
    public static function getItemCommanderStatus() {
        return self::itemsAlias('commander_status');
    }
  
    public static function getItemDirectorStatus() {
        return self::itemsAlias('director_status');
    }    
  
    public static function getItemStartPart() {
            return self::itemsAlias('start_part');
    }
  
     public static function getItemEndPart() {
              return self::itemsAlias('end_part');
     }

  
//       public function beforeSave($insert) {
//         if ($insert) {
//             $this->user_id = \Yii::$app->user->identity->id;
//         } else {
            
//         }
//         return parent::beforeSave($insert);
//     }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
//         return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveType()
    {
        return $this->hasOne(LeaveType::className(), ['id' => 'leave_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveCancel()
    {
        return $this->hasOne(LeaveCancel::className(), ['leave_id' => 'id']);
    }
  
    public function getCreatedBy(){      
        return  $this->hasOne(PersonLeave::className(), ['user_id' => 'created_by']);
    }
  
    public function getUpdatedBy(){      
        return  $this->hasOne(PersonLeave::className(), ['user_id' => 'updated_by']);
    }
  
    public static function getActingList()
    {
      $model = Person::find()->where(['!=','user_id',Yii::$app->user->id])->all();
        return ArrayHelper::map($model,'user_id','fullname','positionTitle');
    }
  
    public function getActingUser(){      
        return  $this->hasOne(Person::className(), ['user_id' => 'acting_user_id']);
    }
  
    public function getInspectorBy(){      
        return  $this->hasOne(Person::className(), ['user_id' => 'inspector_by']);
    }
  
    public function getCommanderBy(){      
        return  $this->hasOne(Person::className(), ['user_id' => 'commander_by']);
    }
  
    public function getDirectorBy(){      
        return  $this->hasOne(Person::className(), ['user_id' => 'director_by']);
    }
    
    public function getInspectorAt(){      
        return  $this->inspector_at?'วันที่ <span class="text-dashed">'.Yii::$app->formatter->asDate($this->inspector_at,'d').' / '.Yii::$app->formatter->asDate($this->inspector_at,'MMMM').' / '.Yii::$app->formatter->asDate($this->inspector_at,'yyyy').'</span>':null;
    }
  
    public function getCommanderAt(){      
        return  $this->commander_at?'วันที่ <span class="text-dashed">'.Yii::$app->formatter->asDate($this->commander_at,'d').' / '.Yii::$app->formatter->asDate($this->commander_at,'MMMM').' / '.Yii::$app->formatter->asDate($this->commander_at,'yyyy').'</span>':null;
    }
  
    public function getDirectorAt(){      
        return  $this->director_at?'วันที่ <span class="text-dashed">'.Yii::$app->formatter->asDate($this->director_at,'d').' / '.Yii::$app->formatter->asDate($this->director_at,'MMMM').' / '.Yii::$app->formatter->asDate($this->director_at,'yyyy').'</span>':null;
    }
    
  # จำนวนวันลาครั้งนี้
    public function getCountDays(){
            if(!($this->date_start && $this->date_end)){
              return null;
            }
          return self::calCountDays($this->date_start,$this->date_end,$this->start_part,$this->end_part);
    }
  
    public static function calCountDays($star,$end,$start_part,$end_part){
            $strStartDate = $star;
            $strEndDate =  $end;

            $intWorkDay = 0;
            $intHoliday = 0;
            $intTotalDay = ((strtotime($strEndDate) - strtotime($strStartDate))/  ( 60 * 60 * 24 )) + 1; 

            while (strtotime($strStartDate) <= strtotime($strEndDate)) {
                  $DayOfWeek = date("w", strtotime($strStartDate));
                  if($DayOfWeek == 0 or $DayOfWeek ==6)  // 0 = Sunday, 6 = Saturday;
                  {
                    $intHoliday++;
                  }
                  elseif(!LeaveDayOff::checkDayOff($strStartDate)) # check day off
                  { 
                     $intWorkDay++;
                  }
              //$DayOfWeek = date("l", strtotime($strStartDate)); // return Sunday, Monday,Tuesday....
              $strStartDate = date ("Y-m-d", strtotime("+1 day", strtotime($strStartDate)));
            }
//             echo "<hr>";
//             echo "<br>Total Day = $intTotalDay";
//             echo "<br>Work Day = $intWorkDay";
//             echo "<br>Holiday = $intHoliday";
         if($start_part == self::LATE_AFTERNOON){
            $intWorkDay -= 0.5;
         }
         
         if($end_part == self::HALF_DAY_MORNIG){
           $intWorkDay -= 0.5;  
         }

          return $intWorkDay;
   }
  
  #วันลาพักผ่อนสะสม
  public static function getCollect($user_id = null,$year = null){
    $year = $year?$year:date('Y');
    $user_id = $user_id?$user_id:Yii::$app->user->id;
    $user = PersonLeave::findOne($user_id);
    $userNumber = $user->leavePermission->number_day;
    //$rangeYear = FiscalYear::find()->where(['year'=>$year])->one();
    $model = self::find()
      ->where(['<','year',$year])
//       ->where(['>=','year',$rangeYear->date_start])
//       ->andWhere(['<=','date_end',$rangeYear->date_end])
      ->andWhere(['created_by'=>$user_id])
      ->andWhere(['status'=>self::STATUS_ALLOW])
      ->sum('number_day');
      //->one();
    
    //print_r($model);
    return $userNumber-$model;
  }
  
  #ลามาแล้ว (วันทำการ)
  public static function getPastDay($user_id = null,$year = null){
    $year = $year?$year:date('Y');
    $user_id = $user_id?$user_id:Yii::$app->user->id;
    $rangeYear = FiscalYear::find()->where(['year'=>$year])->one();
    $model = self::find()
       ->where(['year'=>$year])
//       ->where(['>=','year',$rangeYear->date_start])
//       ->andWhere(['<=','date_end',$rangeYear->date_end])
      ->andWhere(['created_by'=>$user_id])
      ->andWhere(['status'=>self::STATUS_ALLOW])
      ->sum('number_day');
      //->one();    
    //print_r($model);
    return $model?$model:0;
  }
  
  
  
  
}
