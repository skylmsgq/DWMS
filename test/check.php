<?php
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
	//another way
	$json_string = $_POST['txt_json'];
	if(ini_get("magic_quotes_gpc")=="1")
	{
		$json_string=stripslashes($json_string);
	}
	$json_data = json_decode($json_string);
	$rfid=$json_data->rfid;
	$imei=$json_data->imei;
	
	// $rfid=$_POST['rfid'];
	// $imei=$_POST['imei'];
	$result = mysql_query("SELECT ownership_type, ownership_id FROM device WHERE device_serial_num='".$imei."'");
		$userId = null;
		$receivingId = null;
		$ownershipType = null;
		 if(!mysql_num_rows($result)){
			 $error->code = 0;
			 $error->des = urlencode('企业没有绑定手持设备');
			 $resdata->error = $error;
			 echo urldecode(json_encode($resdata));
			 exit() ;
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
			 echo urldecode(json_encode($resdata));
			 exit() ;
		}
		$result2 = mysql_query("SELECT * FROM rfid WHERE rfid_id='".$rfid."'");
		if(!mysql_num_rows($result2)){
			$error->code = 8;
			$error->des = urlencode('RFID标签没有绑定废物');
			$resdata->error = $error;
			echo urldecode(json_encode($resdata));
			exit() ;
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
			 echo urldecode(json_encode($resultData));
			 exit();
			}
		$resultData->hasrecord=1;		

		$result3=mysql_query("SELECT * from record where record_id='$record_id'");
		if(!mysql_num_rows($result3))
		{
			$error->code = 19;
			$error->des = urlencode('备案信息有误，不存在对应备案');
			$resdata->error = $error;
			echo urldecode(json_encode($resdata));
			exit() ;
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
			echo urldecode(json_encode($resdata));
			exit() ;
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
			echo urldecode(json_encode($resdata));
			exit() ;
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
			echo urldecode(json_encode($resdata));
			exit() ;
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
			echo urldecode(json_encode($resdata));
			exit() ;
		}
		while($row = mysql_fetch_array($result7))
			{
				$wname=$row['waste_name'];
			}
		$resultData->wname=$wname;
		
		if (!isset($manifest_id))
			{$resultData->hasmanifest=0;		
			 echo urldecode(json_encode($resultData));
			 exit();
			}
			$resultData->hasmanifest=1;		

		$result8=mysql_query("SELECT * from manifest where manifest_id='$manifest_id'");
		if(!mysql_num_rows($result8))
		{
			$error->code = 20;
			$error->des = urlencode('联单信息有误，不存在对应联单');
			$resdata->error = $error;
			echo urldecode(json_encode($resdata));
			exit() ;
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
			echo urldecode(json_encode($resdata));
			exit() ;
		}
		while($row = mysql_fetch_array($result9))
			{
				$carnum=$row['vehicle_num'];
			}
		$resultData->carnum=$carnum;		

		echo urldecode(json_encode($resultData));
?>