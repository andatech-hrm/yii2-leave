<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use andahrm\structure\models\PersonType;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeavePermissionSearch */
/* @var $form yii\widgets\ActiveForm */
$startYear = 2000;
$endYear = date('Y');
$rangeYear = array_combine(range($startYear, $endYear), range($startYear + 543, $endYear + 543));
?>


<?php
$form = ActiveForm::begin([
            'method' => 'get',
            'options' => ['data-pjax' => true]
        ]);
?>

<div class="row">
    <div class="col-sm-8">      
        <?=
        $form->field($model, 'person_type_id')->dropDownList(PersonType::getList(), [
            'prompt' => 'เลือก',
            'onchange' => 'this.form.submit()'
        ])
        ?>  
    </div>
    <div class="col-sm-4">      
        <?php /* = $form->field($model, 'year')->dropDownList($rangeYear,[
          'prompt'=>'เลือก',
          'onchange' => 'this.form.submit()'
          ]) */ ?>  
        <?php
        echo $form->field($model, 'fullname')->widget(Select2::className(), [
            'options' => ['placeholder' => 'Search for a city ...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => Url::to(['/data-form/person-list']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(city) { return city.text; }'),
                'templateSelection' => new JsExpression('function (city) { return city.text; }'),
            ],
            'pluginEvents' => [
                "select2:select" => "function() { this.form.submit(); }",
            ]
        ]);
        ?>  
    </div>
</div>

<?php ActiveForm::end(); ?>

</div>
