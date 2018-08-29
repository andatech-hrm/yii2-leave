<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use andahrm\structure\models\FiscalYear;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeavePermission */

$this->title = $modelPerson->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$modals['add'] = Modal::begin([
            'header' => 'add'
        ]);
//echo Yii::$app->runAction('/leave/permission/assign', ['id' => $model->user_id, 'formAction' => '/leave/permission/assign']);
Modal::end();
?>

<?php
$form = ActiveForm::begin([
            'action' => [$this->context->action->id],
            'method' => 'get',
            'options' => ['data-pjax' => true],
        ]);
?>
<?= Html::hiddenInput('id', $model->user_id); ?>
<?= $form->field($model, 'year')->dropDownList(FiscalYear::getList(), ['name' => 'year', 'onchange' => 'this.form.submit();']) ?>
<?php #= Html::dropDownList('year', FiscalYear::getList(), ['onchange' => 'this.form.submit();'])  ?>
<?php ActiveForm::end(); ?>

<?php $pjaxs['permisstion'] = Pjax::begin(['id' => 'pjax-permission']) ?>

<div class="leave-permission-view">



    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
//            [
//                'attribute' => 'user_id',
//                'format' => 'html',
//                'value' => $model->infoMedia
//            ],
            [
                'attribute' => 'credit',
//                'value'=>function($model){
//        
//                }
            ],
            [
                'attribute' => 'debit',
//                'value'=>function($model){
//        
//                }
            ],
            [
                'attribute' => 'balance',
//                'value'=>function($model){
//        
//                }
            ],
        ],
    ])
    ?>

</div>


<?php
$columns = [
];

$gridColumns = [
    ['class' => '\kartik\grid\SerialColumn'],
    ['class' => '\kartik\grid\ActionColumn',]
];

$fullExportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $columns,
            'filename' => $this->title,
            'showConfirmAlert' => false,
            'target' => ExportMenu::TARGET_BLANK,
            'fontAwesome' => true,
            'pjaxContainerId' => 'kv-pjax-container',
            'dropdownOptions' => [
                'label' => 'Full',
                'class' => 'btn btn-default',
                'itemsBefore' => [
                    '<li class="dropdown-header">Export All Data</li>',
                ],
            ],
        ]);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="btn-group">
            <?=
            Html::button('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('andahrm/leave', 'Add'), [
                'class' => 'btn btn-success btn-flat',
                'data-pjax' => 0,
                'data-toggle' => 'modal',
                'data-target' => '#' . $modals['add']->id,
            ]);
            ?>
            <?=
            Html::a('<i class="glyphicon glyphicon-repeat"></i> ' . Yii::t('andahrm/leave', 'Reload'), ['update-balance', 'id' => $model->user_id, 'year' => $model->year], [
                'class' => 'btn btn-success btn-flat',
                'data-pjax' => 1,
            ]);
            ?>
            <?=
            Html::a('<i class="glyphicon glyphicon-repeat"></i> ' . Yii::t('andahrm/leave', 'Cal Carry'), ['update-carry', 'id' => $model->user_id, 'year' => $model->year], [
                'class' => 'btn btn-success btn-flat',
                'data-pjax' => 1,
            ]);
            ?>
        </div>
    </div>
    <div class="panel-body no-padding">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'trans_type',
                    'value'=> 'typeLabel',
                ],
                'trans_time:datetime',
                [
                    //'label' => 'ได้รับ',
                    'attribute' => 'amount',
                    'format' => ['decimal', 1],
                    'contentOptions' => ['class' => 'text-right'],
//                    'value'=>function($model){
//                        return 
//                    }
                ],
                [
                    'format' => 'html',
                    'value' => function($model) {
                        return Html::a('ลบ', ['del', 'id' => $model->user_id, 'time' => $model->trans_time], ['class' => '']);
                    }
                ]
//                'created_at:datetime',
//                [
//                    'attribute' => 'created_by',
//                    'value' => 'createdBy.fullname',
//                ],
//                [
//                    'format' => 'html',
//                    'value' => function($model) {
//                        return Html::a(Yii::t('andahrm/leave', 'Management'), ['manage', 'id' => $model->user_id], ['class' => 'btn btn-primary']);
//                    }
//                ]
            ]
                //'filterModel' => $searchModel,
                //'id' => 'data-grid',
                //'pjax' => false,
//        'resizableColumns'=>true,
//        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
//        'floatHeader'=>true,
//        'floatHeaderOptions'=>['scrollingTop'=>'50'],
//        'export' => [
//            'label' => Yii::t('yii', 'Page'),
//            'fontAwesome' => true,
//            'target' => GridView::TARGET_SELF,
//            'showConfirmAlert' => false,
//        ],
//         'exportConfig' => [
//             GridView::HTML=>['filename' => $exportFilename],
//             GridView::CSV=>['filename' => $exportFilename],
//             GridView::TEXT=>['filename' => $exportFilename],
//             GridView::EXCEL=>['filename' => $exportFilename],
//             GridView::PDF=>['filename' => $exportFilename],
//             GridView::JSON=>['filename' => $exportFilename],
//         ],
//        'panel' => [
//            'heading' => '<h3 class="panel-title"><i class="fa fa-th"></i> ' . Html::encode($this->title) . '</h3>',
//            'type' => 'default',
//            'before' => '<div class="btn-group">' .
//            Html::button('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('andahrm', 'Create'), [
//                'class' => 'btn btn-success btn-flat',
//                'data-pjax' => 0,
//                'data-toggle' => 'modal',
//                'data-target' => '#' . $modals['add']->id,
//            ]) . ' ' .
//            '</div>',
//            'heading' => false,
//        //'footer'=>false,
//        ],
//        'toolbar' => [
//            '{export}',
//            '{toggleData}',
//            $fullExportMenu,
//        ],
                //'columns' => $gridColumns,
        ]);
        ?>
    </div>
</div>
<?php Pjax::end(); ?>
<?php
$urlAssign = Url::to(['assign', 'id' => $model->user_id, 'year' => $model->year]);
$jsHead[] = <<< JS
var modalAssign = "#{$modals['add']->id}";
var urlAssign = "{$urlAssign}";
var pjaxPermission = "#{$pjaxs['permisstion']->id}";
function callbackPermisstion(result,form)
{       
    jQuery(modalAssign).modal('hide');
    
}
JS;
$this->registerJs(implode("\n", $jsHead), $this::POS_HEAD);

$js[] = <<< JS

//alert(modalAssign); 
    //$(modalAssign).modal('show');
        

    jQuery(modalAssign).on('show.bs.modal', function () {
         jQuery(this).find(".modal-body").load(urlAssign);
    });
    jQuery(modalAssign).on('hidden.bs.modal', function () {
        $.pjax.reload({container: "#{$pjaxs['permisstion']->id}"});
    });

JS;

$this->registerJs(implode('\n', $js));
?>

