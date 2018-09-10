<?php

namespace andahrm\leave\models;

use Yii;
use yii\helpers\ArrayHelper;
use andahrm\leave\models\Leave; #mad
use andahrm\leave\models\LeavePermission; #mad
use andahrm\positionSalary\models\PersonPositionSalary; #mad
use andahrm\leave\models\LeaveRelatedPerson; #mad
use andahrm\structure\models\Section; #mad

class PersonLeave extends \andahrm\person\models\Person {

    public static function getList($id = null) {
        return ArrayHelper::map(self::find()->filterWhere(['user_id' => $id])->limit(20)->all(), 'user_id', 'fullname', 'positionTitle');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaves() {
        return $this->hasMany(Leave::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveRelatedPerson() {
        return $this->hasOne(LeaveRelatedPerson::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getLeaveRelatedSection()
    // {
    //     return $this->hasOne(LeaveRelatedSection::className(), ['section_id' => 'section_id'])->w;
    // }

    public function getUser() {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }

//    public function getLeavePermission() {
//        return $this->hasOne(LeavePermission::className(), ['user_id' => 'user_id']);
//    }
//   public function getInspectors()
//   {
//       return ArrayHelper::map($this->leaveRelatedPerson->leaveRelated->leaveRelatedInspectors,'user_id','user.fullname','user.positionTitle');
//   }
//   public function getCommanders()
//   {
//       return ArrayHelper::map($this->leaveRelatedPerson->leaveRelated->leaveRelatedCommanders,'user_id','user.fullname','user.positionTitle');
//   }
//   public function getDirectors()
//   {
//       return ArrayHelper::map($this->leaveRelatedPerson->leaveRelated->leaveRelatedDirectors,'user_id','user.fullname','user.positionTitle');
//   }
//   public function getToDirector()
//   {
//       $model = $this->leaveRelatedPerson
//          ->leaveRelated
//          ->leaveRelatedDirectors;
//       return $model?$model[0]->user->positionTitle:'';
//   }

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

    /**
     *  Create by mad
     * ข้อมูลสิทธิลา
     */
    public function getLeavePermission() {
        return $this->hasOne(LeavePermission::className(), ['user_id' => 'user_id'])
                        ->orderBy(['year' => SORT_DESC]);
    }

    /**
     *  Create by mad
     * ข้อมูลสิทธิลา
     */
    public function getLeavePermissionByYear() {
        $year = date('Y');
        $get = Yii::$app->request->get();
        $year = isset($get['PersonSearch']['year']) ? $get['PersonSearch']['year'] : $year;
        return $this->hasOne(LeavePermission::className(), ['user_id' => 'user_id'])
                        ->where('leave_permission.year = :year', [':year' => $year]);
        //->orderBy('leave_permission.year');
    }

}
