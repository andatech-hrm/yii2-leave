<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use backend\widgets\WizardMenu;
use kartik\widgets\Typeahead;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use andahrm\leave\models\LeaveType;
use andahrm\leave\models\PersonLeave;

//$personLeave = PersonLeave::findOne(Yii::$app->user->identity->id);
//$personLeave = $personLeave->position->section->leaveRelatedSection;
//if ($personLeave) {
$css[] = <<< CSS
.btn-leave-type{
    white-space: normal;
    width: 300px;
}
CSS;
$this->registerCss(@implode('', $css));
?>
<table class="table">
    <thead> 
        <tr>
            <th width="250"><?= Yii::t('andahrm/leave', 'Title') ?></th>
            <th width="100"><?= Yii::t('andahrm/leave', 'Limit') ?></th>
<!--            <th ><?= Yii::t('andahrm/leave', 'Detail') ?></th>-->
        </tr>
    </thead>
    <tbody>
        <?php
//$model->leave_type_id = 1;
        foreach (LeaveType::find()->all() as $type):
            //$model->leave_type_id = null;
            ?>
            <tr>
                <td width="300">
                    <?php
                    $type->title = str_replace(' ', '<br/>', $type->title);
                    echo Html::a($type->title, ['draft', 'type' => $type->id], ['class' => 'btn btn-success btn-block btn-leave-type'])
                    ?>

                </td>
                <td>
                    <?php #= $type->detail ?>
                    <?= $type->limit ? '<span class="red">' . Yii::t('andahrm/leave', 'Limit') . ' ' . $type->limit . " " . Yii::t('andahrm', 'Day') . "</span><br/>" : '' ?>
                    <?= Html::a('<i class="fa fa-info"></i> ' . Yii::t('andahrm/leave', 'Detail'), ['/leave/type', 'id' => $type->id]) ?>
                </td>
            </tr>

            <?php
        endforeach;
        ?>
    </tbody>
</table>

<?php
//}else {
//    echo 'คุณยังไม่มีตำแหน่ง';
//}
?>