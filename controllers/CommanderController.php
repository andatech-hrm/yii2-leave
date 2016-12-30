<?php

namespace andahrm\leave\controllers;

class CommanderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
