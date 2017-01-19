<div class="font-thai-sarabun">


	<h2 class="text-center">แบบใบลาพักผ่อน</h2>

	<p class="text-right">
		เขียนที่ <span class="text-dest-under">องค์การบริหารส่วนจังหวัดยะลา</span>
	</p>

	<p class="text-right">
		วันที่ .............. เดือน..........................พ.ศ..........
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
    วันลาพักผ่อนสะสม...20...วัน 
    มีสิทธิลาพักผ่อนประจำปีนี้อีก <span class="text-dashed"><?=$user->leavePermission->number_day?></span> วันทำการ
		รวมเป็น...40...วันทำการ ขอลาพักผ่อน
    
		<?=$date_range?> 

		มีกำหนด..............วัน ในระหว่างลาจะติดต่อข้าพเจ้าได้ที่.........................

	</p>
  
	<p class="p-form-indent">
		ในการลาครั้งนี้ ข้าพเจ้าได้มอบหมายงานในหน้าที่ให้ <?=$acting_user_id?> เป็นผู้ปฎิบัติราชการแทน
	</p>

	<br/>
	<br/>

	<div class="row">
		<div class="col-sm-6 text-center">
			ลงชื่อ ...................................ผู้รับมอบ<br/> 
			(...........................................................)
		</div>
		<div class="col-sm-6 text-center">

			ลงชื่อ .....................................<br/>
			(...........................................................)
		</div>
	</div>
	<br/>
	<br/>


	<div class="row">
		<div class="col-sm-6 text-center">
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
					<td>7</td>
					<td>2</td>
					<td>9</td>
				</tr>
				</tbody>
			</table>
			
			
			  
		</div>
		<div class="col-sm-6 text-center">
			<h4 class="text-left">
				ความเห็นผู้บังคับบัญชา
			</h4> 
				 ....................................................................<br/> 
      ลงชื่อ <span class="text-dashed"><?=$user->leaveRelatedPerson->leaveRelated->commanderBy->fullname?></span> <br/>
	    ตำแหน่ง <span class="text-dashed"><?=$user->leaveRelatedPerson->leaveRelated->commanderBy->position->title?></span><br/>
			วันที่............/............................../..............
		</div>
	</div>



	<div class="row">
		<div class="col-sm-6 text-center">





			ลงชื่อ <span class="text-dashed"><?=$user->leaveRelatedPerson->leaveRelated->inspectorBy->fullname?></span> ผู้ตรวจสอบ<br/>
			ตำแหน่ง <span class="text-dashed"><?=$user->leaveRelatedPerson->leaveRelated->inspectorBy->position->title?></span><br/>
	วันที่............./............................/................ 
	

	</div>
		<div class="col-sm-6 text-center">
	
	
	คำสั่ง อนุญาต ไม่อนุญาต <br/>
      .................................................................... .................................................................... <br/>
			ลงชื่อ <span class="text-dashed"><?=$user->leaveRelatedPerson->leaveRelated->directorBy->fullname?></span><br/>
			ตำแหน่ง <span class="text-dashed"><?=$user->leaveRelatedPerson->leaveRelated->directorBy->positionTitle?></span><br/>
	วันที่................/.............................../..........
			</div>
	</div>