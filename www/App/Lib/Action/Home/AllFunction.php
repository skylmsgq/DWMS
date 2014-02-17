<?php
date_default_timezone_set("PRC");
function login($json_string)
{
	$code=0;
	$con = mysql_connect("10.50.6.70","root","root1234");
	if (!$con)
	  {
	  	$code=1;
	  	return $code;
	  }
		mysql_query("set names 'utf8'");
		mysql_select_db("dwms", $con);
		if(ini_get("magic_quotes_gpc")=="1")
		 {
		  $json_string=stripslashes($json_string);
		 }
		$json_data = json_decode($json_string);
		$username=$json_data->user;
		$password=$json_data->pass;
		$imei=$json_data->imei;
		$type=$json_data->type;
	$password=md5($password);

	$query=mysql_query("SELECT * from user where username='$username' and password='$password'");
	if(mysql_num_rows($query)>0)
	{
		$q2=mysql_query("SELECT * from device where device_serial_num='$imei' and ownership_type='$type'");
		if (mysql_num_rows($q2)>0)
			return  $code;
		else
			{$code=2; return  $code;}
	}
	else
		{$code=3; return $code;}
}
function check($json_string)
{
	$con = mysql_connect("10.50.6.70","root","root1234");
	if (!$con)
	  {
	  	$error->code = 7;
		$error->des = urlencode('数据库连接失败');
		$resdata->error = $error;
		return $resdata;
	  }
	mysql_query("set names 'utf8'");
	mysql_select_db("dwms", $con);
	if(ini_get("magic_quotes_gpc")=="1")
	{
		$json_string=stripslashes($json_string);
	}
	$json_data = json_decode($json_string);
	$rfid=$json_data->rfid;
	$imei=$json_data->imei;
		$result = mysql_query("SELECT ownership_type, ownership_id FROM device WHERE device_serial_num='".$imei."'");
		$userId = null;
		$receivingId = null;
		$ownershipType = null;
		 if(!mysql_num_rows($result)){
			 $error->code = 0;
			 $error->des = urlencode('企业没有绑定手持设备');
			 $resdata->error = $error;
			 return $resdata;
		}
	//echo mysql_num_rows($result);
		while($row = mysql_fetch_array($result))
		  {
		  $userId = $row['ownership_id'];
		  $ownershipType = $row['ownership_type'];
		  }
		$resultData->code=200;
		if($ownershipType != 4){
			$error->code = 19;
			$error->des = urlencode('该企业不是区环保局');
			$resdata->error = $error;
			 return $resdata;
		}
		$result2 = mysql_query("SELECT * FROM rfid WHERE rfid_id='".$rfid."'");
		if(!mysql_num_rows($result2)){
			$error->code = 8;
			$error->des = urlencode('RFID标签没有绑定废物');
			$resdata->error = $error;
			return $resdata;
		}
		while($row = mysql_fetch_array($result2))
			{
				$rfid_stat = $row['rfid_status'];
				$transfer_stat = $row['transfer_status'];
				$wasteId = $row['waste_id'];
				$addWay = $row['add_method'];
				$total = $row['waste_total'];
				$record_id=$row['record_id'];
				$manifest_id=$row['manifest_id'];
			}
		if ($addWay==0)
			$resultData->addway=urlencode('桶装');
		else
			$resultData->addway=urlencode('袋装');
		
		if($rfid_stat==0)
			$resultData->rstatus=urlencode('初始化绑定废物');
		else if($rfid_stat==1)
			$resultData->rstatus=urlencode('出库');
		else if($rfid_stat==2)
			$resultData->rstatus=urlencode('接受');
		else if($rfid_stat==3)
			$resultData->rstatus=urlencode('在库');
		
		if($transfer_stat==0)
			$resultData->tstatus=urlencode('可修改，备案审核未通过');
		else if($transfer_stat==1)
			$resultData->tstatus=urlencode('不可修改，备案审核已通过');
		
		$resultData->total=$total;

		if (!isset($record_id))
			{$resultData->hasrecord=0;		
			 		return $resultData;
			}
		$resultData->hasrecord=1;		

		$result3=mysql_query("SELECT * from record where record_id='$record_id'");
		if(!mysql_num_rows($result3))
		{
			$error->code = 19;
			$error->des = urlencode('备案信息有误，不存在对应备案');
			$resdata->error = $error;
			return $resdata;
		}
		while($row = mysql_fetch_array($result3))
			{
				$pid=$row['production_unit_id'];
				$tid=$row['transport_unit_id'];
				$rid=$row['reception_unit_id'];
			}
		$result4=mysql_query("SELECT production_unit_name from production_unit where production_unit_id='$pid'");
		if(!mysql_num_rows($result4))
		{
			$error->code = 21;
			$error->des = urlencode('没有对应生产企业');
			$resdata->error = $error;
			return $resdata;
		}
		while($row = mysql_fetch_array($result4))
			{
				$pname=$row['production_unit_name'];
			}
			$resultData->pname=$pname;
		$result5=mysql_query("SELECT reception_unit_name from reception_unit where reception_unit_id='$rid'");
		if(!mysql_num_rows($result5))
		{
			$error->code = 22;
			$error->des = urlencode('没有对应处置企业');
			$resdata->error = $error;
			return $resdata;
		}
		while($row = mysql_fetch_array($result5))
			{
				$rname=$row['reception_unit_name'];
			}
			$resultData->rname=$rname;
		$result6=mysql_query("SELECT transport_unit_name from transport_unit where transport_unit_id='$tid'");
		if(!mysql_num_rows($result6))
		{
			$error->code = 23;
			$error->des = urlencode('没有对应运输企业');
			$resdata->error = $error;
			return $resdata;
		}
		while($row = mysql_fetch_array($result6))
			{
				$tname=$row['transport_unit_name'];
			}
			$resultData->tname=$tname;
			//echo $wasteId;
		$result7=mysql_query("SELECT waste_name from waste where waste_id='$wasteId'");
		if(!mysql_num_rows($result7))
		{
			$error->code = 24;
			$error->des = urlencode('没有对应废物类型');
			$resdata->error = $error;
			return $resdata;
		}
		while($row = mysql_fetch_array($result7))
			{
				$wname=$row['waste_name'];
			}
		$resultData->wname=$wname;
		
		if (!isset($manifest_id))
			{$resultData->hasmanifest=0;		
			 		return $resultData;
			}
			$resultData->hasmanifest=1;		

		$result8=mysql_query("SELECT * from manifest where manifest_id='$manifest_id'");
		if(!mysql_num_rows($result8))
		{
			$error->code = 20;
			$error->des = urlencode('联单信息有误，不存在对应联单');
			$resdata->error = $error;
			return $resdata;
		}
		while($row = mysql_fetch_array($result8))
			{
				$driver=$row['carrier_1_name'];
				$driver_id=$row['carrier_1_num'];
				$carid=$row['vehicle_id_1'];
			}
		$resultData->driver=$driver;		
		$resultData->driver_id=$driver_id;		
		$result9=mysql_query("SELECT vehicle_num from vehicle where vehicle_id='$carid'");
		if(!mysql_num_rows($result9))
		{
			$error->code = 25;
			$error->des = urlencode('没有对应车辆');
			$resdata->error = $error;
			return $resdata;
		}
		while($row = mysql_fetch_array($result9))
			{
				$carnum=$row['vehicle_num'];
			}
		$resultData->carnum=$carnum;		
		return $resultData;
}
function bindRfid($json_string){
		$con = mysql_connect("10.50.6.70","root","root1234");
	if (!$con)
	  {
		$error->code = 7;
		$error->des = urlencode('数据库连接失败');
		$resdata->error = $error;
		return $resdata;
	  }
		mysql_query("set names 'utf8'");
		mysql_select_db("dwms", $con);
		//$json_string = $_POST['txt_json'];
		//$json_string = file_get_contents("php://input");
		 if(ini_get("magic_quotes_gpc")=="1")
		 {
		  $json_string=stripslashes($json_string);
		 }
		$json_data = json_decode($json_string);
		$wasteBind = $json_data->wasteBindList;
		$imei = $json_data->imei;
		function isNotExist($rfid){
			$result = mysql_query("SELECT * FROM rfid WHERE rfid_id='".$rfid."'");
			if (!mysql_num_rows($result))
				{
					return true;
				}
			else
				{
					return false;
				}
		}
		
		$result = mysql_query("SELECT ownership_type, ownership_id FROM device WHERE device_serial_num='".$imei."'");
		$userId = null;
		$productionId = null;
		$ownershipType = null;
		if(!mysql_num_rows($result)){
			$error->code = 0;
			$error->des = urlencode('企业没有绑定手持设备');
			$resdata->error = $error;
			return $resdata;
		}
		
		while($row = mysql_fetch_array($result))
		  {
		  $userId = $row['ownership_id'];
		  $ownershipType = $row['ownership_type'];
		  }
		
		if($ownershipType != 5){
			$error->code = 17;
			$error->des = urlencode('该企业不是产生单位');
			$resdata->error = $error;
			return $resdata;
		}
		
		$result1 = mysql_query("SELECT production_unit_id FROM production_unit WHERE production_unit_id='".$userId."'");
		if(!mysql_num_rows($result1)){
			$error->code = 2;
			$error->des = urlencode('该用户没有企业');
			$resdata->error = $error;
			return $resdata;
		}
		
		while($row = mysql_fetch_array($result1))
		{
		  $productionId = $row['production_unit_id'];
		}
		$productionUnit = "production_unit_".$productionId;
		
		$key = 0;
		foreach($wasteBind as $wasteRfid){
			$rfid = $wasteRfid->rfid;
			$wasteId = $wasteRfid->wasteid;
			$addWay = $wasteRfid->addway;
			$time = date("Y-m-d H:i:s");
			if(isNotExist($rfid)){
				$sql1 = "INSERT INTO rfid (rfid_id, waste_id, add_date_time,rfid_status,add_method,ownership_id,waste_total) VALUES ('$rfid','$wasteId','$time','0','$addWay','$userId','0')";
				if (!mysql_query($sql1,$con))
				  {
					//die(mysql_error());
					$error[$key]->code = 3;
					$error[$key]->des = urlencode('写入RFID数据库失败');
					$error[$key]->rfid = $rfid;
					$key++;
				  }else{
				  $sql2 = "INSERT INTO $productionUnit (rfid_id, waste_id, add_date_time,android_num) VALUES ('$rfid', '$wasteId', '$time','$imei')";
				  if (!mysql_query($sql2,$con))
					 {
						$error[$key]->code = 4;
						$error[$key]->des = urlencode('写入企业库存数据失败');
						$error[$key]->rfid = $rfid;
						$key++;
					 }
				  }
				
			}else{
				$error[$key]->code = 5;
				$error[$key]->des = urlencode('RFID标签已经绑定');
				$error[$key]->rfid = $rfid;
				$key++;
			}
			
		}
		mysql_close($con);
		if(isset($error)){
			$newerror['error'] = $error;
			return $newerror;
		}else{
			$resultData->code = 200;
			return $resultData;
		}

}

function addWaste($json_string){
	$con = mysql_connect("10.50.6.70","root","root1234");
	if (!$con)
	  {
		$error->code = 7;
		$error->des = urlencode('数据库连接失败');
		$resdata->error = $error;
		return $resdata;
	  }
	mysql_query("set names 'utf8'");
	mysql_select_db("dwms", $con);
	//$json_string = $_POST['txt_json'];
	 if(ini_get("magic_quotes_gpc")=="1")
	{
	  $json_string=stripslashes($json_string);
	}
	$json_data = json_decode($json_string);
	$rfid = $json_data->rfid;
	$wasteid = $json_data->wasteid;
	$imei = $json_data->imei;
	$addway = $json_data->addway;
	$addnum = $json_data->addnum;
	
	$column = null;
	if($addnum<=0 or !is_numeric($addnum)){
		$error->code = 16;
		$error->des = urlencode('输入的数值必须为正数');
		$resdata->error = $error;
		return $resdata;
	}
	if($addway==0){
		$column = 'add_weight';
	}else{
		$column = 'add_num';
		$addnum = ceil($addnum);
	}

		$result = mysql_query("SELECT ownership_type, ownership_id FROM device WHERE device_serial_num='".$imei."'");
		$userId = null;
		$productionId = null;
		$ownershipType = null;
		if(!mysql_num_rows($result)){
			$error->code = 0;
			$error->des = urlencode('企业没有绑定手持设备');
			$resdata->error = $error;
			return $resdata;
		}
		
		while($row = mysql_fetch_array($result))
		  {
		  $userId = $row['ownership_id'];
		  $ownershipType = $row['ownership_type'];
		  }
		
		if($ownershipType != 5){
			$error->code = 17;
			$error->des = urlencode('该企业不是产生单位');
			$resdata->error = $error;
			return $resdata;
		}
	$result1 = mysql_query("SELECT production_unit_id FROM production_unit WHERE production_unit_id='".$userId."'");

	if(!mysql_num_rows($result1)){
				$error->code = 2;
				$error->des = urlencode('该用户没有企业');
				$resdata->error = $error;
				return $resdata;
	}


	while($row = mysql_fetch_array($result1))
	{
	  $productionId = $row['production_unit_id'];
	}
	$productionUnit = "production_unit_".$productionId;


	$time = date("Y-m-d H:i:s");
	$result2 = mysql_query("SELECT * FROM rfid WHERE rfid_id='".$rfid."'");
	if(!mysql_num_rows($result2)){
		$error->code = 8;
		$error->des = urlencode('RFID标签没有绑定废物');
		$resdata->error = $error;
		return $resdata;
	}
	$wasteTotal = 0;
	while($row = mysql_fetch_array($result2))
		  {
			  $wasteTotal = $row['waste_total'];
			  $wasteStatus = $row['rfid_status'];
		  }
	if($wasteStatus==1 or $wasteStatus==2){
		$error->code = 12;
		$error->des = urlencode('废物已出库');
		$resdata->error = $error;
		return $resdata;
	}
		  
		  
	//echo $wasteTotal;
	$wasteTotal = $wasteTotal + $addnum;
	$sql1 = "UPDATE rfid SET modify_date_time = '$time',rfid_status = 3, waste_total = '$wasteTotal' WHERE rfid_id = '$rfid' AND waste_id = '$wasteid'";
	
	$key = 0;
	if (!mysql_query($sql1,$con))
	{
		$error[$key]->code = 3;
		$error[$key]->des = urlencode('更新RFID数据库失败');
		$error[$key]->rfid = $rfid;
		$key++;
	}else{
		$sql2 = "INSERT INTO $productionUnit (rfid_id, waste_id, add_date_time,android_num,$column) VALUES ('$rfid', '$wasteid', '$time','$imei','$addnum')";
		if (!mysql_query($sql2,$con))
		{
			$error[$key]->code = 4;
			$error[$key]->des = urlencode('写入企业库存数据失败');
			$error[$key]->rfid = $rfid;
		}
	}
	

	mysql_close($con);
	if(isset($error)){
				$newerror['error'] = $error;
				return $newerror;
	}else{
				$resultData->code = 200;
				return $resultData;
	}
}

function getRfidWasteName($rfid,$imei){
	$con = mysql_connect("10.50.6.70","root","root1234");
	if (!$con)
	  {
	  	$error->code = 7;
		$error->des = urlencode('数据库连接失败');
		$resdata->error = $error;
		return $resdata;
	  }
	mysql_query("set names 'utf8'");
	mysql_select_db("dwms", $con);
	// $rfid = $_GET["rfid"];
	// $imei = $_GET["imei"];
	
	$result = mysql_query("SELECT ownership_id FROM device WHERE device_serial_num='".$imei."'") or die(mysql_error());
	$userId = null;
	$productionId = null;
	if(!mysql_num_rows($result)){
				$error->code = 0;
				$error->des = urlencode('企业没有绑定手持设备');
				$resdata->error = $error;
				return $resdata;
	}
	
	
	$result1 = mysql_query("SELECT * FROM rfid WHERE rfid_id='".$rfid."'");
	$wasteId = null;
	$addWay = null;
	if(!mysql_num_rows($result1)){
		$error->code = 8;
		$error->des = urlencode('RFID标签没有绑定废物');
		$resdata->error = $error;
		return $resdata;
		
	}else{
		while($row = mysql_fetch_array($result1))
		  {
			  $wasteId = $row['waste_id'];
			  $wasteWay = $row['add_method'];
			  $wasteTotal = $row['waste_total'];
		  }
		$result2 = mysql_query("SELECT waste_name FROM waste WHERE waste_id='".$wasteId."'");
		if(!mysql_num_rows($result2)){
			$error->code = 9;
			$error->des = urlencode('没有这个危废物');
			$resdata->error = $error;
			return $resdata;
		}
		while($row = mysql_fetch_array($result2))
		  {
			$wasteName = urlencode($row['waste_name']);
		  }
		$newData['name'] =  $wasteName;
		$newData['id'] = $wasteId;
		$newData['way'] = $wasteWay;
		$newData['total'] = $wasteTotal;
		return $newData;
	
	}
	mysql_close($con);

}

function getWasteName($imei){

	$con = mysql_connect("10.50.6.70","root","root1234");
	if (!$con)
	  {
		$error->code = 7;
		$error->des = urlencode('数据库连接失败');
		$resdata->error = $error;
		return $resdata;
	  }
	mysql_query("set names 'utf8'");
	mysql_select_db("dwms", $con);
	//$imei = $_GET["imei"];

	$result = mysql_query("SELECT ownership_type, ownership_id FROM device WHERE device_serial_num='".$imei."'");
	$userId = null;
	$wasteArray = array();
	$wasteName = null;
	$ownershipType = null;
	if(!mysql_num_rows($result)){
		$error->code = 0;
		$error->des = urlencode('企业没有绑定手持设备');
		$resdata->error = $error;
		return $resdata;
	}
	while($row = mysql_fetch_array($result))
	  {
	  $userId = $row['ownership_id'];
	  $ownershipType = $row['ownership_type'];
	  //echo $userId;
	  }
	  
	if($ownershipType != 5){
		$error->code = 17;
		$error->des = urlencode('该企业不是产生单位');
		$resdata->error = $error;
		return $resdata;
	}
	$result1 = mysql_query("SELECT production_unit_waste FROM production_unit WHERE production_unit_id='".$userId."'");

	if(!mysql_num_rows($result1)){
		$error->code = 1;
		$error->des = urlencode('企业没有注册危险固废');
		$resdata->error = $error;
		return $resdata;
	}

	while($row = mysql_fetch_array($result1))
	  {
	  $wasteArray = split(",",$row['production_unit_waste']);
	  }
	foreach ($wasteArray as $key => $value) {
		//echo $value;
		$result2 = mysql_query("SELECT waste_name FROM waste WHERE waste_id='".$value."'");
		while($row = mysql_fetch_array($result2))
	  {
		$wasteName = urlencode($row['waste_name']);
	  }
		$newDate[$key]['name'] =  $wasteName;
		$newDate[$key]['id'] = $value;
	}
	$resultData['code'] = 200;
	$resultData['wasteOptions'] = $newDate;
	mysql_close($con);
	return $resultData;
}

function wasteIn($json_string){
	$con = mysql_connect("10.50.6.70","root","root1234");
	if (!$con)
	  {
	  	$error->code = 7;
		$error->des = urlencode('数据库连接失败');
		$resdata->error = $error;
		return $resdata;
	  }
	mysql_query("set names 'utf8'");
	mysql_select_db("dwms", $con);
	//$json_string = $_POST['txt_json'];
	if(ini_get("magic_quotes_gpc")=="1")
	{
		$json_string=stripslashes($json_string);
	}
	$json_data = json_decode($json_string);
	$rfidList = $json_data->rfidlist;
	$imei = $json_data->imei;
	$result = mysql_query("SELECT ownership_type, ownership_id FROM device WHERE device_serial_num='".$imei."'");
		$userId = null;
		$receivingId = null;
		$ownershipType = null;
		if(!mysql_num_rows($result)){
			$error->code = 0;
			$error->des = urlencode('企业没有绑定手持设备');
			$resdata->error = $error;
			return $resdata;
		}
		
		while($row = mysql_fetch_array($result))
		  {
		  $userId = $row['ownership_id'];
		  $ownershipType = $row['ownership_type'];
		  }
		
		if($ownershipType != 7){
			$error->code = 18;
			$error->des = urlencode('该企业不是接收单位');
			$resdata->error = $error;
			return $resdata;
		}
	
	$result1 = mysql_query("SELECT reception_unit_id FROM reception_unit WHERE reception_unit_id='".$userId."'");

	if(!mysql_num_rows($result1)){
				$error->code = 2;
				$error->des = urlencode('该用户没有企业');
				$resdata->error = $error;
				return $resdata;
	}


	while($row = mysql_fetch_array($result1))
	{
	  $receivingId = $row['reception_unit_id'];
	}
	$receivingUnit = "reception_unit_".$receivingId;
	
	$key = 0;
	foreach($rfidList as $rfidobj){
		$rfid = $rfidobj->rfid;
		$result2 = mysql_query("SELECT * FROM rfid WHERE rfid_id='".$rfid."'");
		if(!mysql_num_rows($result2)){
			$error[$key]->code = 8;
			$error[$key]->des = urlencode('RFID标签没有绑定废物');
			$error[$key]->rfid = $rfid;
			$key++;
		}else{
			while($row = mysql_fetch_array($result2))
			{
				$stat = $row['rfid_status'];
				$wasteId = $row['waste_id'];
				$addWay = $row['add_method'];
				$total = $row['waste_total'];
			}
			if($stat==2){
				$error[$key]->code = 15;
				$error[$key]->des = urlencode('废物已经入库');
				$error[$key]->rfid = $rfid;
				$key++;
			}elseif($stat!=1){
				$error[$key]->code = 11;
				$error[$key]->des = urlencode('不能够入库');
				$error[$key]->rfid = $rfid;
				$key++;
			}else{
				$column = null;
				if($addWay==0){
					$column = 'total_weight';
				}else{
					$column = 'total_num';
				}
				$time = date("Y-m-d H:i:s");
				$sql3 = "UPDATE rfid SET modify_date_time = '$time',rfid_status = 2,ownership_id = '$userId' WHERE rfid_id = '$rfid'";
				if (!mysql_query($sql3,$con))
				{
					$error[$key]->code = 3;
					$error[$key]->des = urlencode('更新RFID数据库失败');
					$error[$key]->rfid = $rfid;
					$key++;
				}else{
					$sql4 = "INSERT INTO $receivingUnit (rfid_id, waste_id, receive_date_time,android_num,$column) VALUES ('$rfid', '$wasteId', '$time','$imei','$total')";
					if (!mysql_query($sql4,$con))
					{
						$error[$key]->code = 13;
						$error[$key]->des = urlencode('更新仓库数据失败');
						$error[$key]->rfid = $rfid;
						$key++;
					}
				}
				
			}
		}
	}
	mysql_close($con);
	if(isset($error)){
			$newerror['error'] = $error;
			return $newerror;
	}else{
			$resultData->code = 200;
			return $resultData;
	}
}

function wasteOut($json_string){
	$con = mysql_connect("10.50.6.70","root","root1234");
	if (!$con)
	  {
	  	$error->code = 7;
		$error->des = urlencode('数据库连接失败');
		$resdata->error = $error;
		return $resdata;
	  }
	mysql_query("set names 'utf8'");
	mysql_select_db("dwms", $con);
	//$json_string = $_POST['txt_json'];
	if(ini_get("magic_quotes_gpc")=="1")
	{
		$json_string=stripslashes($json_string);
	}
	$json_data = json_decode($json_string);
	$rfidList = $json_data->rfidlist;
	$imei = $json_data->imei;
	$result = mysql_query("SELECT ownership_type, ownership_id FROM device WHERE device_serial_num='".$imei."'");
		$userId = null;
		$productionId = null;
		$ownershipType = null;
		if(!mysql_num_rows($result)){
			$error->code = 0;
			$error->des = urlencode('企业没有绑定手持设备');
			$resdata->error = $error;
			return $resdata;
		}
		
		while($row = mysql_fetch_array($result))
		  {
		  $userId = $row['ownership_id'];
		  $ownershipType = $row['ownership_type'];
		  }
		
		if($ownershipType != 5){
			$error->code = 17;
			$error->des = urlencode('该企业不是产生单位');
			$resdata->error = $error;
			return $resdata;
		}
		  
		
	$result1 = mysql_query("SELECT production_unit_id FROM production_unit WHERE production_unit_id='".$userId."'");
	if(!mysql_num_rows($result1)){
		$error->code = 2;
		$error->des = urlencode('该用户没有企业');
		$resdata->error = $error;
		return $resdata;
	}
	
	$key = 0;
	foreach($rfidList as $rfidobj){
		$rfid = $rfidobj->rfid;
		$result2 = mysql_query("SELECT * FROM rfid WHERE rfid_id='".$rfid."'");
		if(!mysql_num_rows($result2)){
			$error[$key]->code = 8;
			$error[$key]->des = urlencode('RFID标签没有绑定废物');
			$error[$key]->rfid = $rfid;
			$key++;
		}else{
			while($row = mysql_fetch_array($result2))
			{
				$stat = $row['rfid_status'];
			}
			if($stat==1 or $stat ==2){
				$error[$key]->code = 12;
				$error[$key]->des = urlencode('废物已经出库');
				$error[$key]->rfid = $rfid;
				$key++;
			}elseif($stat == 0){
				$error[$key]->code = 14;
				$error[$key]->des = urlencode('废物为空');
				$error[$key]->rfid = $rfid;
				$key++;
			}else{
				$time = date("Y-m-d H:i:s");
				$sql1 = "UPDATE rfid SET modify_date_time = '$time',rfid_status = 1 WHERE rfid_id = '$rfid'";
				if (!mysql_query($sql1,$con))
				{
					$error[$key]->code = 3;
					$error[$key]->des = urlencode('更新RFID数据库失败');
					$error[$key]->rfid = $rfid;
					$key++;
				}
			}
		}
	}
	mysql_close($con);
	if(isset($error)){
			$newerror['error'] = $error;
			return $newerror;
	}else{
			$resultData->code = 200;
			return $resultData;
	}
}

?>