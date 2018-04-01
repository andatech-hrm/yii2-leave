<?php

namespace andahrm\leave\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\base\Model;

class Select extends Model
{
   
    
    public $leave_type_id;
  
    public function scenarios(){
      $scenarios = parent::scenarios();
      $scenarios['insert'] = ['leave_type_id'];
      return $scenarios;
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveType()
    {
        return LeaveType::find()->where(['id'=>$this->leave_type_id])->one();
    }
  
  
   public function beforeValidate()
    {
         
        if (parent::beforeValidate()) {
           if($this->leave_type_id==null){
                $this->addError('leave_type_id','กรุณาเลือกประเภทการลา');
            }
            return true;
        }
        return false;
    }
  
}
