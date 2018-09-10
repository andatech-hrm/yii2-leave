<?php

use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$action = $this->context->action->id;
?>
<hr/>
<div class="row">
    <div class="col-sm-12">
        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group pull-left" >
                <?= Html::a('<i class="fa fa-times"></i> ' . Yii::t('andahrm', 'Reset'), ['draft', 'type' => $model->leave_type_id], ['class' => 'btn btn-link']) ?>
            </div>
            <div class="btn-group pull-right">
                <?= Html::a('<i class="fa fa-times"></i> ' . Yii::t('andahrm/leave', 'Cancel'), ['index'], ['class' => 'btn btn-link']) ?>
            </div>

            <?php if ($action == 'draft'): ?>

                <div class="btn-group pull-right">

                    <?= Html::submitButton(Yii::t('andahrm/leave', 'Confirm Form') . ' <i class="fa fa-arrow-right "></i>', ['class' => 'btn btn-success']) ?>        
                </div>

            <?php else: ?>

                <div class="btn-group pull-right">
                    <?= Html::a('<i class="fa fa-arrow-left "></i> ' . Yii::t('andahrm/leave', 'Edit Draft'), ['draft', 'id' => $model->leave_draft_id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::submitButton(Yii::t('andahrm/leave', 'Confirm') . ' <i class="fa fa-arrow-right "></i>', ['class' => 'btn btn-success']) ?>        
                </div>


            <?php
            endif;
            ?>

        </div>
    </div>
</div>
