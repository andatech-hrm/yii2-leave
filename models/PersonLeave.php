<?php
namespace andahrm\leave\models;

use Yii;
use yii\helpers\ArrayHelper;
use andahrm\leave\models\Leave; #mad
use andahrm\leave\models\LeavePermission; #mad
use andahrm\positionSalary\models\PersonPositionSalary; #mad
use andahrm\leave\models\LeaveRelatedPerson; #mad


class PersonLeave extends \andahrm\person\models\Person
{
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaves()
    {
        return $this->hasMany(Leave::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveRelatedPerson()
    {
        return $this->hasOne(LeaveRelatedPerson::className(), ['user_id' => 'user_id']);
    }
    
    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }
  
     
  public function getInspectors()
   {
       return ArrayHelper::map($this->leaveRelatedPerson->leaveRelated->leaveRelatedInspectors,'user_id','user.fullname','user.positionTitle');
   }
  
  public function getCommanders()
   {
       return ArrayHelper::map($this->leaveRelatedPerson->leaveRelated->leaveRelatedCommanders,'user_id','user.fullname','user.positionTitle');
   }
  
  public function getDirectors()
   {
       return ArrayHelper::map($this->leaveRelatedPerson->leaveRelated->leaveRelatedDirectors,'user_id','user.fullname','user.positionTitle');
   }
  
  public function getToDirector()
   {
       $model = $this->leaveRelatedPerson
         ->leaveRelated
         ->leaveRelatedDirectors;
       return $model?$model[0]->user->positionTitle:'';
   }
  
  /**
  *  Create by mad
  * ผู้ที่เกี่ยวข้องกับการลาของฉัน
  */
//   public function getLeaveRelatedPerson()
//     {
//         $relate = $this->hasOne(LeaveRelatedPerson::className(), ['user_id' => 'user_id']);
//       //print_r($relate);
//      // exit();
//         return $relate?$relate->leaveRelated:null;
//     }

   
}