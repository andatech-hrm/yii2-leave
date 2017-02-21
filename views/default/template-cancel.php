

<div class="font-thai-sarabun">

	<h2 class="text-center">แบบใบขอยกเลิกวันลา</h2>

	<p class="text-right">
		เขียนที่ <span class="text-dest-under">องค์การบริหารส่วนจังหวัดยะลา</span>
	</p>

	<p class="text-right">
		<?=$created_at?>
	</p>

	

	<p class="text-left">
		เรื่อง <span class="text-dashed">ขอยกเลิกวันลา</span>
	</p>

	<p class="text-left">
		<div class="row">
			<div class="col-sm-5">
			<?=$to?>
			</div>
	</div>
	</p>
	<p class="p-form-indent">
    
		ข้าพเจ้า <span class="text-dashed"><?=$user->fullname?></span>
    ตำแหน่ง <span class="text-dashed"><?=$user->position->title?></span>
    สังกัด <span class="text-dashed"><?=$user->position->section->title?></span>
ได้รับอนุญาตให้ลา 
<?=$leave_type_id?>
<?=$date_range_old?> 
รวม <span class="text-dashed"><?=$number_day?></spa> วัน      นั้น
	</p>
	
	<p class="p-form-indent">เนื่องจาก <?=$reason?>
		จึงขอยกเลิกวันลา 
		<span class="text-dashed"><?=$leave_type_id?></span>
		จำนวน ……………วัน
		<?=$date_range?>
	</p>



<?php

#######################
	$col1 = 'col-sm-4 col-sm-offset-1';
	$col2 = 'col-sm-4 col-sm-offset-2';
	?>
	<div class="row">
		
		<div class="col-sm-12 text-center">

			<p>
				ลงชื่อ .....................................<br/>
				(<span class="text-dashed"><?=$user->fullname?></span>)<br/>
				ตำแหน่ง <?=$user->position->title?>
			</p>
		</div>
	</div>


	<div class="row">
		
		<div class="col-sm-10 col-sm-offset-1 text-center">
			
			<h4 class="text-left">ผู้บังคับบัญชา</h4>
			<p class="text-left">
				<?=$commander_status?><br/>
				ความคิดเห็น<br/>
				<span class="text-dashed width100"><?=$commander_comment?></span>
			</p>
				</div>
	</div>
	<div class="row">
		
		<div class="col-sm-4 col-sm-offset-5 text-center">
			<p>
					ลงชื่อ .....................................<br/>
					<?=$commanders?><br/>				
					<?=$commander_at?>
			</p>
			<br/>
		</div>
	</div>



	<div class="row">
		
		
		<div class="col-sm-10 col-sm-offset-1 text-center">
			<h4 class="text-left">คำสั่ง</h4>
			<p class="text-left">
				<?=$director_status?><br/>
				ความคิดเห็น<br/>
				<span class="text-dashed width100"><?=$director_comment?></span>
			</p>
			</div>
	</div>
	<div class="row">
		
		<div class="col-sm-4 col-sm-offset-5 text-center">
			<p>
					ลงชื่อ  .....................................<br/>
					<?=$directors?><br/>				
					<?=$director_at?>
			</p>
			</div>
	</div>