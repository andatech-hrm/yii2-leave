<?php
use yii\bootstrap\Html;
//use yii\widgets\Menu;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use mdm\admin\components\Helper;

use andahrm\leave\models\LeaveCommanderSearch;
use andahrm\leave\models\LeaveCommanderCancelSearch;
use andahrm\leave\models\LeaveInspactorSearch;
use andahrm\leave\models\LeaveDirectorSearch;
use andahrm\leave\models\LeaveDirectorCancelSearch;

 $this->beginContent('@andahrm/leave/views/layouts/main.php'); 
 $module = $this->context->module->id;




                    $menuItems = [];
      
                    $menuItems[] =  [
                           'label' => Yii::t('andahrm/leave', 'Self'),
                            'url' => ["/{$module}/default/"],
                            'icon'=> 'fa fa-sitemap'
                     ]; 
                    
        $searchModel = new LeaveCommanderSearch();
        $dataCommander = $searchModel->search(Yii::$app->request->queryParams);
        
        $searchModel = new LeaveCommanderCancelSearch();
        $dataCommanderCancel = $searchModel->search(Yii::$app->request->queryParams);
        $totalCommand = $dataCommander->getCount() + $dataCommanderCancel->getCount();
        
        
        $countCommander = $totalCommand?' <span class="badge bg-red">'.$totalCommand.'</span>':'';
                    $menuItems[] =  [
                           'label' => Yii::t('andahrm/leave', 'Commander').$countCommander,
                            'url' => ["/{$module}/commander/"],
                            'icon'=> 'fa fa-sitemap'
                     ];
      
        $searchModel = new LeaveInspactorSearch();
        $dataInspactor = $searchModel->search(Yii::$app->request->queryParams);
        $countInspactor = $dataInspactor->getCount()?' <span class="badge bg-red">'.$dataInspactor->getCount().'</span>':'';
                    
                    $menuItems[] =  [
                            'label' => Yii::t('andahrm/leave', 'Inspactor').$countInspactor,
                            'url' => ["/{$module}/inspactor/"],
                            'icon'=> 'fa fa-sitemap'
                     ];   
      
      
        $searchModel = new LeaveDirectorSearch();
        $dataDirector = $searchModel->search(Yii::$app->request->queryParams);
        $searchModel = new LeaveDirectorCancelSearch();
        $dataDirectorCancel = $searchModel->search(Yii::$app->request->queryParams);
        $totalDirector= $dataDirector->getCount() + $dataDirectorCancel->getCount();
        $countDirector = $totalDirector?' <span class="badge bg-red">'.$totalDirector.'</span>':'';
                     $menuItems[] =  [
                            'label' => Yii::t('andahrm/leave', 'Director').$countDirector,
                            'url' => ["/{$module}/director/"],
                            'icon'=> 'fa fa-inbox'
                     ];
      
                    $menuItems = Helper::filter($menuItems);
                    $newMenu = [];
                    foreach($menuItems as $k=>$menu){
                      $newMenu[$k]=$menu;
                      $newMenu[$k]['url'][0] = rtrim($menu['url'][0], "/");
                    }
                    $menuItems=$newMenu;
?>

<div class="row ">
  <?php if(count($menuItems)>1):  
  ?>
    <div class="col-md-12 hidden-print">  
          <?php
          //$nav = new Navigate();
          echo Menu::widget([
              'options' => ['class' => 'nav nav-tabs bar_tabs'],
              'encodeLabels' => false,
              //'activateParents' => true,
              //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
              'items' => $menuItems,
          ]);
          ?>
    </div>

  
    <div class="col-md-12">
      <div class="x_panel">
            <div class="x_content">
                <?php echo $content; ?>
                <div class="clearfix"></div>
            </div>
        </div>               
     </div>
  <?php else:?>
  <div class="col-md-12">
     <?php echo $content; ?>         
  </div>
  <?php endif;?>
</div>

<?php $this->endContent(); ?>
