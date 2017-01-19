<?php
use yii\bootstrap\Html;
//use yii\widgets\Menu;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use mdm\admin\components\Helper;

 $this->beginContent('@app/views/layouts/main.php'); 
 $module = $this->context->module->id;
?>


<div class="row">
    <div class="col-md-12">
      
        <div class="x_panel tile">
            <div class="x_title">
                <h2><?= $this->title; ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
              
              <?php echo WizardMenu::widget(['step' => $event->step, 'wizard' => $event->sender]);?>

    <?php $form = ActiveForm::begin(); ?>
              
              
                <?php echo $content; ?>
              
              <?php
  echo Html::beginTag('div', ['class' => 'form-row buttons']);
echo Html::submitButton('Next', ['class' => 'button', 'name' => 'next', 'value' => 'next']);
echo Html::submitButton('Pause', ['class' => 'button', 'name' => 'pause', 'value' => 'pause']);
echo Html::submitButton('Cancel', ['class' => 'button', 'name' => 'cancel', 'value' => 'pause']);
echo Html::endTag('div');
  ?>
  
   <?php ActiveForm::end(); ?>
                <div class="clearfix"></div>
            </div>
        </div>
      
    </div>
</div>

<?php $this->endContent(); ?>
