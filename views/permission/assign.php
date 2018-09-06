<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use andahrm\structure\models\FiscalYear;
use andahrm\leave\models\LeaveTransCate;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeavePermission */
?>
<div class="leave-permission-view">

    <?=
    DetailView::widget([
        'model' => $modelPerson,
        'attributes' => [
            [
                'attribute' => 'user_id',
                'format' => 'html',
                'value' => $modelPerson->infoMedia
            ]
        ],
    ])
    ?>
    <?php
    $form = ActiveForm::begin();
    echo Html::activeHiddenInput($model, 'year');
    ?>    
    <div class="row">
        <?= $form->field($model, 'leave_trans_cate_id', ['options' => ['class' => 'form-group col-sm-4']])->dropDownList(LeaveTransCate::getList(1)) ?>

        <?= $form->field($model, 'amount', ['options' => ['class' => 'form-group col-sm-8']])->textInput(['autocomplate' => 'off']) ?>
    </div>

    <div class="form-group">
        <?=
        Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'name' => 'save',
            'value' => 1
        ])
        ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<?php
///Surakit
if ($isAjax) {

    $js[] = <<< JS
$(document).on('submit', '#{$form->id}', function(e){
    var me = $(this);
    e.preventDefault();
    if (me.data('requestRunning')) {
        return;
    }
    me.data('requestRunning', true);

  var form = $(this);
  var formData = new FormData(form[0]);
   //alert(form.serialize());
  
  $.ajax({
    url: form.attr('action'),
    type : 'POST',
    data: formData,
    contentType:false,
    cache: false,
    processData:false,
    dataType: "json",
    success: function(data) {
      if(data.success){
        callbackPermisstion(data.result,"#{$form->id}");
      }else{
        alert('Fail');
        alert(data);
      }
    },
        complete: function() {
            me.data('requestRunning', false);
        }
  });
});
JS;

    $this->registerJs(implode("\n", $js));
}
?>
