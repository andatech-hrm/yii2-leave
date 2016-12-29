<?php
use yii\bootstrap\Html;
//use yii\widgets\Menu;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use mdm\admin\components\Helper;

 $this->beginContent('@andahrm/leave/views/layouts/main.php'); 
 $module = $this->context->module->id;
?>
<div class="row hidden-print">
    <div class="col-md-3"> 
      
      <?php
                    $menuItems = [];
      
                    $menuItems[] =  [
                           'label' => '<i class="fa fa-sitemap"></i> ' . Yii::t('andahrm/leave', 'History'),
                            'url' => ["/{$module}/default"],
                     ];    
                    
      
                    $menuItems[] =  [
                           'label' => '<i class="fa fa-sitemap"></i> ' . Yii::t('andahrm/leave', 'Offer'),
                            'url' => ["/{$module}/default/offer"],
                     ];
      
      
                    $menuItems[] =  [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('andahrm/leave', 'Leave Day Offs'),
                            'url' => ["/{$module}/day-off"],
                     ];
      
                    $menuItems[] =  [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('andahrm/leave', 'Leave Types'),
                            'url' => ["/{$module}/type"],
                    ];   
      
                    $menuItems[] =  [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('andahrm/leave', 'Leave Conditions'),
                            'url' => ["/{$module}/condition"],
                     ];
      
                    $menuItems = Helper::filter($menuItems);
                    
                    //$nav = new Navigate();
                    echo Menu::widget([
                        'options' => ['class' => 'nav nav-pills nav-stacked'],
                        'encodeLabels' => false,
                        //'activateParents' => true,
                        //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
                        'items' => $menuItems,
                    ]);
                    ?>
      
      
     
      
    </div>

    <div class="col-md-9">
      
        <div class="x_panel tile">
            <div class="x_title">
                <h2><?= $this->title; ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php echo $content; ?>
                <div class="clearfix"></div>
            </div>
        </div>
      
    </div>
</div>

<?php $this->endContent(); ?>
