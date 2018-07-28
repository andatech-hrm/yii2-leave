<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeavePermission */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$modals['add'] = Modal::begin([
            'header' => 'add'
        ]);
//echo Yii::$app->runAction('/leave/permission/assign', ['id' => $model->user_id, 'formAction' => '/leave/permission/assign']);
Modal::end();
?>
<div class="leave-permission-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'user_id',
                'format' => 'html',
                'value' => $model->infoMedia
            ],
            [
                'attribute' => 'leavePermission.credit',
//                'value'=>function($model){
//        
//                }
            ]
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
<div class="person-index">

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'data-grid',
        'pjax' => true,
//        'resizableColumns'=>true,
//        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
//        'floatHeader'=>true,
//        'floatHeaderOptions'=>['scrollingTop'=>'50'],
        'export' => [
            'label' => Yii::t('yii', 'Page'),
            'fontAwesome' => true,
            'target' => GridView::TARGET_SELF,
            'showConfirmAlert' => false,
        ],
//         'exportConfig' => [
//             GridView::HTML=>['filename' => $exportFilename],
//             GridView::CSV=>['filename' => $exportFilename],
//             GridView::TEXT=>['filename' => $exportFilename],
//             GridView::EXCEL=>['filename' => $exportFilename],
//             GridView::PDF=>['filename' => $exportFilename],
//             GridView::JSON=>['filename' => $exportFilename],
//         ],
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="fa fa-th"></i> ' . Html::encode($this->title) . '</h3>',
            'type' => 'default',
            'before' => '<div class="btn-group">' .
            Html::button('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('andahrm', 'Create'), [
                'class' => 'btn btn-success btn-flat',
                'data-pjax' => 0,
                'data-toggle' => 'modal',
                'data-target' => '#' . $modals['add']->id,
            ]) . ' ' .
            '</div>',
            'heading' => false,
        //'footer'=>false,
        ],
        'toolbar' => [
            '{export}',
            '{toggleData}',
            $fullExportMenu,
        ],
            //'columns' => $gridColumns,
    ]);
    ?>
</div>

<?php
$urlAssign = Url::to(['assign', 'id' => $model->user_id]);
$js[] = <<< JS
var modalAssign = "#{$modals['add']->id}";
var urlAssign = "{$urlAssign}";
//alert(modalAssign);

   

    //$(modalAssign).modal('show');
    $(modalAssign).on('show.bs.modal', function () {
         $(this).find(".modal-body").load(urlAssign);
    });

    $(modalAssign).on('hidden.bs.modal', function () {

    });
        
JS;

$this->registerJs(implode('\n', $js));
?>

