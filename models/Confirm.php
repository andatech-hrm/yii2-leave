<?php

namespace andahrm\leave\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\base\Model;

class Confirm extends Model
{
    public $status;
  
    public function scenarios(){
      $scenarios = parent::scenarios();
      $scenarios['insert'] = ['status'];
      return $scenarios;
    }
}
