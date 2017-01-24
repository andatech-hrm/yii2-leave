

<div class="font-thai-sarabun">

	<h2 class="text-center">แบบใบลาพักผ่อน</h2>

	<p class="text-right">
		เขียนที่ <span class="text-dest-under">องค์การบริหารส่วนจังหวัดยะลา</span>
	</p>

	<p class="text-right">
		<?=$created_at?>
	</p>

	

	<p class="text-left">
		เรื่อง <span class="text-dashed">ขอลาพักผ่อน</span>
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
    วันลาพักผ่อนสะสม <span class="text-dashed"><?=$collect?></span> วัน 
    มีสิทธิลาพักผ่อนประจำปีนี้อีก <span class="text-dashed"><?=$user->leavePermission->number_day?></span> วันทำการ
		รวมเป็น <span class="text-dashed"><?=$total?></span> วันทำการ ขอลาพักผ่อน
    
		<?=$date_range?> 

		มีกำหนด<span class="text-dashed"> <?=$number_day?> </span>วัน ในระหว่างลาจะติดต่อข้าพเจ้าได้ที่ <?=$contact?>

	</p>
  
	<p class="p-form-indent">
		ในการลาครั้งนี้ ข้าพเจ้าได้มอบหมายงานในหน้าที่ให้ <?=$acting_user_id?> เป็นผู้ปฎิบัติราชการแทน
	</p>

	<br/>
	<br/>
  <?php
	$col1 = 'col-sm-4 col-sm-offset-1';
	$col2 = 'col-sm-4 col-sm-offset-2';
	?>
	<div class="row">
		<div class="<?=$col1?> text-center">
			<p>
				ลงชื่อ ...................................ผู้รับมอบ<br/>
			<?=$acting_user?>
			</p>
		</div>
		<div class="<?=$col2?> text-center">

			<p>
				ลงชื่อ .....................................<br/>
				(<span class="text-dashed"><?=$user->fullname?></span>)<br/>
				ตำแหน่ง <?=$user->position->title?>
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
					<th class="text-center">ลามาแล้ว (วันทำการ)</th>
					<th class="text-center">ลาครั้งนี้ (วันทำการ)</th>
					<th class="text-center">รวมเป็น (วันทำการ)</th>
				</tr>
					</thead>
				<tbody>
					<tr>
					<td><?=$pastDay?></td>
					<td><?=$number_day?></td>
					<td><?=$pastDay+$number_day?></td>
				</tr>
				</tbody>
			</table>
			
			
			  
		</div>
		<div class="<?=$col2?> text-center">
			
			<h4 class="text-left">ผู้บังคับบัญชา</h4>
			<p class="text-left">
				<?=$commander_status?><br/>
				ความคิดเห็น<br/>
				<span class="text-dashed width100"><?=$commander_comment?></span>
			</p>
			<p>
					ลงชื่อ .....................................<br/>
					<?=$commanders?><br/>				
					<?=$commander_at?>
			</p>
			<br/>
		</div>
	</div>



	<div class="row">
		<div class="<?=$col1?> text-center">
			<h4 class="text-left">ผู้ตรวจสอบ</h4>
			<p class="text-left">
				<?=$inspector_status?><br/>
				ความคิดเห็น<br/>
				<span class="text-dashed width100"><?=$inspector_comment?></span>
			</p>
			<p>
				ลงชื่อ .....................................<br/>
				<?=$inspectors?><br/>				
				<?=$inspector_at?>
			</p>
		</div>
		
		<div class="<?=$col2?> text-center">
			<h4 class="text-left">คำสั่ง</h4>
			<p class="text-left">
				<?=$director_status?><br/>
				ความคิดเห็น<br/>
				<span class="text-dashed width100"><?=$director_comment?></span>
			</p>
			<p>
					ลงชื่อ  .....................................<br/>
					<?=$directors?><br/>				
					<?=$director_at?>
			</p>
			</div>
	</div>