<?php

namespace andahrm\leave;

/**
 * leave module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'andahrm\leave\controllers';

     /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->setLayout();
        
        //$this->registerTranslations();
    }
  
  /**
     * Set Layout
     */
    private function setLayout()
    {
        $this->layoutPath = '@andahrm/leave/views/layouts';
        $this->layout = 'main';
    }
}
