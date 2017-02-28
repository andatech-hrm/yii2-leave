 <?php
use andahrm\leave\models\PersonLeave;
use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveType;

 
 #ผู้ขอ
	$user = PersonLeave::findOne($user_id);
 
 #ข้อมูลประเภทการลา
	$leaveType = LeaveType::findOne($model->leave_type_id);
 
 #ผู้บังคับบัญชา
	$commanderBy = PersonLeave::findOne($model->commander_by);
	$commander['status'] = Leave::getWidgetStatus($model->commander_status,Leave::getItemCommanderStatus());
    $commander['name'] = '(<span class="text-dashed">'.$commanderBy->fullname.'</span>)'; 
    $commander['position'] = Yii::t('andahrm/position-salary','Position').' <span class="text-dashed">'.$commanderBy->positionTitle.'</span>'; 
    $commander['comment'] = $model->commander_comment?$model->commander_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
    $commander['at'] = $model->commander_at?$model->commanderAt:'' ; 
    //$items['commander'] = $commander ; 
    
 #ผู้ตรวจสอบ
    $inspectorBy = PersonLeave::findOne($model->inspector_by);
    $inspector['status'] = Leave::getWidgetStatus($model->inspector_status,Leave::getItemInspactorStatus());
    $inspector['name'] = '(<span class="text-dashed">'.$inspectorBy->fullname.'</span>)'; 
    $inspector['position'] = Yii::t('andahrm/position-salary','Position').' <span class="text-dashed">'.$inspectorBy->positionTitle.'</span>'; 
    $inspector['comment'] = $model->inspector_comment?$model->inspector_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
    $inspector['at'] = $model->inspector_at?$model->inspectorAt:'' ; 
    // //$items['inspector'] = $inspector ; 
   
 #ผู้ออกคำสั่ง 
    $directorBy = PersonLeave::findOne($model->director_by);
    $director['status'] = Leave::getWidgetStatus($model->director_status,Leave::getItemDirectorStatus());
    $director['name'] = '(<span class="text-dashed">'.$directorBy->fullname.'</span>)'; 
    $director['position'] = Yii::t('andahrm/position-salary','Position').' <span class="text-dashed">'.$directorBy->positionTitle.'</span>'; 
    $director['comment'] = $model->director_comment?$model->director_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
    $director['at'] = $model->director_at?$model->directorAt:''; 
    //$items['director'] = $director ; 
 
 //print_r($commander);
 
 #ข้อมูลการครั้งล่าสุด
    $lastLeave = Leave::getLastLeave($user_id,$year,$leaveType->id);
 
 
	$col1 = 'col-sm-4 col-sm-offset-1';
	$col2 = 'col-sm-4 col-sm-offset-2';
	
	?>

<div class="font-thai-sarabun">
	
	<h2 class="text-center">
	ใบ<?=$leaveType->title?>
	</h2>
	
	<p class="text-right">
	เขียนที่ <span class="text-dest-under">องค์การบริหารส่วนจังหวัดยะลา</span>
	</p>
	
	<p class="text-right">
		<?=$created_at?>
	</p>

	<p class="text-left">
		เรื่อง
		<span class="text-dashed">ขอ<?=$leaveType->title?></span>
	</p>

	<p class="text-left">
		<div class="row">
			<div class="col-sm-5">
			<?=$to?>
			</div>
		</div>
	</p>
	
	
	<br/>

	<p class="p-form-indent">
			ข้าพเจ้า <span class="text-dashed"><?=$user->fullname?></span>
    ตำแหน่ง <span class="text-dashed"><?=$user->position->title?></span>
    สังกัด <span class="text-dashed"><?=$user->position->section->title?></span>
    </p>
    
    	<p class="p-form-indent">
    		ขอ<span class="text-dashed"><?=$leaveType->title?></span>
    	 	เนื่องจาก
    	 	<span class="text-dashed"><?=$reason?></span> 
			ตั้งแต่วันที่
			<?=$date_range?>
			มีกำหนด
			<span class="text-dashed"><?=$number_day?></span>
			วัน   
			ข้าพเจ้าได้
			<span class="text-dashed"><?=$leaveType->title?></span>
			ครั้งสุดท้าย
			<span class="text-dashed"><?=$lastLeave?Yii::$app->formatter->asDate($lastLeave->date_start):' - '?></span>
			ตั้งแต่วันที่
			<span class="text-dashed"><?=$lastLeave?Yii::$app->formatter->asDate($lastLeave->date_end):' - '?></span>
			มีกำหนด
			<span class="text-dashed"><?=$lastLeave?$lastLeave->number_day:' - '?></span>
			วัน  
			ในระหว่างลาจะติดต่อข้าพเจ้าได้ที่
			<?=$contact?>
 </p>
 <br/>
 <br/>

 
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 text-center">
			
			<p>
				ลงชื่อ .....................................<br/>
				(<span class="text-dashed"><?=$user->fullname?></span>)<br/>
				<?=Yii::t('andahrm/position-salary','Position')?><span class="text-dashed"> <?=$user->position->title?></span>
			</p>
		</div>
	</div>
	<br/>
	<br/>




<div class="row">
		<div class="<?=$col1?> text-center">
			<h4 class="text-center">
				สถิติการลาในปีงบประมาณนี้
			</h4> 
			<table class="table table-bordered">
				<thead>
				<tr>
					<th class="text-center" nowrap>ประเภทวันลา</th>
					<th class="text-center" nowrap>ลามาแล้ว<br/>(วันทำการ)</th>
					<th class="text-center" nowrap>ลาครั้งนี้<br/>(วันทำการ)</th>
					<th class="text-center" nowrap>รวมเป็น<br/>(วันทำการ)</th>
				</tr>
					</thead>
				<tbody>
					<?php
					foreach(LeaveType::getList([$model->leave_type_id]) as $key => $value):
						 $pastDay = Leave::getPastDay($user_id,$year,$key);
						 $num_day = $model->leave_type_id==$key?$number_day:0;
						 $total = $pastDay+$num_day;
						?>
					<tr>
						<td class="text-left"><?=$value?></td>
						<td class="text-center"><?=$pastDay?></td>
						<td class="text-center"><?=$num_day?></td>
						<td class="text-center"><?=$total?></td>
					</tr>
					<?php 
					$num_day=0;$pastDay=0;$total=0;
					endforeach;?>
				</tbody>
			</table>
			
			
			  
		</div>
		<div class="<?=$col2?> text-center">
			
			<h4 class="text-left">ผู้บังคับบัญชา</h4>
			<p class="text-left">
				<?=$commander['status']?><br/>
				ความคิดเห็น<br/>
				<span class="text-dashed width100"><?=$commander['comment']?></span>
			</p>
			<p>
					ลงชื่อ .....................................<br/>
					<?=$commander['name']?><br/>
					<?=$commander['position']?><br/>				
					<?=$commander['at']?$commander['at']:'วันที่............./............................/................ '?>
			</p>
			<br/>
		</div>
	</div>



	<div class="row">
		<div class="<?=$col1?> text-center">
			<h4 class="text-left">ผู้ตรวจสอบ</h4>
			<p class="text-left">
				<?=$inspector['status']?>
				<br/>
				ความคิดเห็น<br/>
				<span class="text-dashed width100">
					<?=$inspector['comment']?>
				</span>
			</p>
			<p>
				ลงชื่อ .....................................<br/>
				
				<?=$inspector['name']?><br/>
				<?=$inspector['position']?><br/>	
				<?=$inspector['at']?$inspector['at']:'วันที่............./............................/................ ' ?>
			</p>
		</div>
		
		<div class="<?=$col2?> text-center">
			<h4 class="text-left">คำสั่ง</h4>
			<p class="text-left">
				<?=$director['status']?><br/>
				ความคิดเห็น<br/>
				<span class="text-dashed width100">
					<?=$director['comment']?>
				</span>
			</p>
			<p>
					ลงชื่อ  .....................................<br/>
					<?=$director['name']?><br/>	
					<?=$director['position']?><br/>	
					<?=$director['at']?$director['at']:'วันที่............./............................/................ ' ?>
			</p>
			</div>
	</div>
	
	
	
</div>
	
	

