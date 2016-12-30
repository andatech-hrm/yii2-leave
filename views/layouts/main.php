<?php
use yii\bootstrap\Html;
//use yii\widgets\Menu;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use mdm\admin\components\Helper;

 $this->beginContent('@app/views/layouts/main.php'); 
 $module = $this->context->module->id;
?>

<?php if(Yii::$app->user->can('manager-leave')):?>
<div class="row hidden-print">
    <div class="col-md-12"> 
      
      <?php
                    $menuItems = [];
      
                    $menuItems[] =  [
                           'label' => '<i class="fa fa-sitemap"></i> ' . Yii::t('andahrm/leave', 'Leaves'),
                            'url' => ["/{$module}/default/"],
                     ];
      
      
                    $menuItems[] =  [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('andahrm/leave', 'Leave Day Offs'),
                            'url' => ["/{$module}/day-off/"],
                     ];
      
                    $menuItems[] =  [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('andahrm/leave', 'Leave Types'),
                            'url' => ["/{$module}/type/"],
                    ];                 
                       
      
                    $menuItems[] =  [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('andahrm/leave', 'Leave Conditions'),
                            'url' => ["/{$module}/condition/"],
                     ];
      
                      $menuItems[] =  [
                           'label' => '<i class="fa fa-sitemap"></i> ' . Yii::t('andahrm/leave', 'Leave Permissions'),
                            'url' => ["/{$module}/permission/"],
                     ];
      
                    $menuItems[] =  [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('andahrm/leave', 'Leave Relateds'),
                            'url' => ["/{$module}/related/"],
                     ];
                    //print_r($menuItems);
                    //echo "<hr/>";
                    $menuItems = Helper::filter($menuItems);
                    $newMenu = [];
                    foreach($menuItems as $k=>$menu){
                      $newMenu[$k]=$menu;
                      $newMenu[$k]['url'][0] = rtrim($menu['url'][0], "/");
                    }
                    $menuItems=$newMenu;
                    //print_r($menuItems);
                    //$nav = new Navigate();
                    echo Menu::widget([
                        'options' => ['class' => 'nav nav-tabs'],
                        'encodeLabels' => false,
                        //'activateParents' => true,
                        //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
                        'items' => $menuItems,
                    ]);
                    ?>
      
      
     
      
    </div>
</div>
<?php endif;?>

<div class="row">
    <div class="col-md-12">
      
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