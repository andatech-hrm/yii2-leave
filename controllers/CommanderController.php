<?php

namespace andahrm\leave\controllers;

class CommanderController extends \yii\web\Controller
{
  
    public function actions()
    {
        $this->layout = 'menu-top';
    }
  
    public function actionIndex()
    {
        return $this->render('index');
    }

}
