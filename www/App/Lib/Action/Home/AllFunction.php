<?php
date_default_timezone_set("PRC");
function login($json_string)
{
	if(ini_get("magic_quotes_gpc")=="1")
		 {
		  $json_string=stripslashes($json_string);
		 }
	$code=0;
	$json_data = json_decode($json_string);
	$username=$json_data->user;
	$password=$json_data->pass;
	$imei=$json_data->imei;
	$type=$json_data->type;
	$password=md5($password);
	try
	{$User=M("user");}
	catch (Exception $e)
	{$code=1; return $code;}
	$query1=$User->where("username='$username' and password='$password'")->find();
	if($query1)// no such user
	{
		$user_id=$query1['user_id'];
		$user_type=$query1['user_type'];
		if ($user_type==0)
			return $code;
		if ($user_type<=4)
			$table="agency";
		else if ($user_type==5)
			$table="production_unit";
		else if ($user_type==6)
			$table="transport_unit";
		else if ($user_type==7)
			$table="reception_unit";
		$deeptable=M($table);
		$queryid=$deeptable->where("user_id='$user_id'")->find();
		$own_id=$queryid[$table.'_id'];
		$device=M("device");
		$q2=$device->where(" device_serial_num='$imei'")->find();
		if ($q2)//no such device
			{
				$ano_type=$q2['ownership_type'];
				$ano_id=$q2['ownership_id'];
				if ($own_id==$ano_id && $ano_type==$user_type && $user_type==$type)// correct user
				return  $code;
				else
					{$code=4; return $code;}
			}
		else
			{$code=2; return  $code;}
	}
	else
		{$code=3; return $code;}
}
function checkout($json_string)
{
	if(ini_get("magic_quotes_gpc")=="1")
		 {
		  $json_string=stripslashes($json_string);
		 }
	try {
		$rfidtable=M("rfid");	
	} catch (Exception $e) {
		$error->code = 7;
		$error->des = urlencode('数据库连接失败');
		$resdata->error = $error;
		return $resdata;
	}
	$json_data = json_decode($json_string);
	$rfid=$json_data->rfid;
	$result=$rfidtable->where("rfid_id='$rfid'")->find();
	if (!$result)
	{
		$error->code = 8;
		$error->des = urlencode('RFID标签没有绑定废物');
		$resdata->error = $error;
		return $resdata;
	}
	$status=$result['rfid_status'];
	$total=$result['waste_total'];
	$addway=$result['add_method'];
	$manifest_id=$result['manifest_id'];
	$resultData->rfid=$rfid;
	$resultData->status=$status;
	$resultData->total=$total;
	$resultData->addway=$addway;
	
	$resultData->code=200;
	if (!isset($manifest_id))
	return $resultData;
	$resultData->manifest_id=$manifest_id;
	$mnftable=M('manifest');
	$result1=$mnftable->where("manifest_id='$manifest_id'")->find();
	if (!$result1)
	{
		$error->code = 20;
		$error->des = urlencode('联单信息有误，不存在对应联单');
		$resdata->error = $error;
		return $resdata;
	}
	$mstatus=$result1['manifest_status'];
	$resultData->mstatus=$mstatus;
	return $resultData;
}
function check($json_string)
{
	if(ini_get("magic_quotes_gpc")=="1")
		 {
		  $json_string=stripslashes($json_string);
		 }
	try {
		$device=M("device");	
	} catch (Exception $e) {
		$error->code = 7;
		$error->des = urlencode('数据库连接失败');
		$resdata->error = $error;
		return $resdata;
	}
	$json_data = json_decode($json_string);
	$rfid=$json_data->rfid;
	$imei=$json_data->imei;
	$result = $device->where(" device_serial_num='$imei'")->find();		
	 if(!$result){
		 $error->code = 0;
		 $error->des = urlencode('企业没有绑定手持设备');
		 $resdata->error = $error;
		 return $resdata;
		}
	$userId = $result['ownership_id'];
	$ownershipType = $result['ownership_type'];
	$resultData->code=200;
	if($ownershipType != 4){
		$error->code = 19;
		$error->des = urlencode('该企业不是区环保局');
		$resdata->error = $error;
		 return $resdata;
	}
	$rfidtable=M('rfid');
	$result2 = $rfidtable->where(" rfid_id='$rfid'")->find();
		if(!$result2){
			$error->code = 8;
			$error->des = urlencode('RFID标签没有绑定废物');
			$resdata->error = $error;
			return $resdata;
		}	
		$rfid_stat = $result2['rfid_status'];
		$transfer_stat = $result2['transfer_status'];
		$wasteId = $result2['waste_id'];
		$addWay = $result2['add_method'];
		$total = $result2['waste_total'];
		$record_id=$result2['record_id'];
		$manifest_id=$result2['manifest_id'];
			
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
		$wstable=M('waste');
		$result7=$wstable->where(" waste_id='$wasteId'")->find();
		if(!$result7)
		{
			$error->code = 24;
			$error->des = urlencode('没有对应废物类型');
			$resdata->error = $error;
			return $resdata;
		}
		$wname=$result7['waste_name'];
		$resultData->wname=$wname;

		if (!isset($record_id))
			{$resultData->hasrecord=0;		
			 		return $resultData;
			}
		$resultData->hasrecord=1;		
		$recordtable=M('record');
		$result3=$recordtable->where(" record_id='$record_id'")->find();
		if(!$result3)
		{
			$error->code = 19;
			$error->des = urlencode('备案信息有误，不存在对应备案');
			$resdata->error = $error;
			return $resdata;
		}	
		$pid=$result3['production_unit_id'];
		$tid=$result3['transport_unit_id'];
		$rid=$result3['reception_unit_id'];
		$putable=M('production_unit');
		$result4=$putable->where(" production_unit_id='$pid'")->find();
		if(!$result4)
		{
			$error->code = 21;
			$error->des = urlencode('没有对应生产企业');
			$resdata->error = $error;
			return $resdata;
		}
		$pname=$result4['production_unit_name'];			
		$resultData->pname=$pname;
		$rcptable=M('reception_unit');
		$result5=$rcptable->where(" reception_unit_id='$rid'")->find();
		if(!$result5)
		{
			$error->code = 22;
			$error->des = urlencode('没有对应处置企业');
			$resdata->error = $error;
			return $resdata;
		}	
		$rname=$result5['reception_unit_name'];	
		$resultData->rname=$rname;
		$tptable=M('transport_unit');
		$result6=$tptable->where(" transport_unit_id='$tid'")->find();
		if(!$result6)
		{
			$error->code = 23;
			$error->des = urlencode('没有对应运输企业');
			$resdata->error = $error;
			return $resdata;
		}		
		$tname=$result6['transport_unit_name'];
		$resultData->tname=$tname;
		
		if (!isset($manifest_id))
			{$resultData->hasmanifest=0;		
			 	return $resultData;
			}
		$resultData->hasmanifest=1;		
		$mnftable=M('manifest');
		$result8=$mnftable->where(" manifest_id='$manifest_id'")->find();
		if(!$result8)
		{
			$error->code = 20;
			$error->des = urlencode('联单信息有误，不存在对应联单');
			$resdata->error = $error;
			return $resdata;
		}
		$driver=$result8['carrier_1_name'];
		$driver_id=$result8['carrier_1_num'];
		$carid=$result8['vehicle_id_1'];
		$resultData->driver=$driver;		
		$resultData->driver_id=$driver_id;		
		$vtable=M('vehicle');
		$result9=$vtable->where(" vehicle_id='$carid'")->find();
		if(!$result9)
		{
			$error->code = 25;
			$error->des = urlencode('没有对应车辆');
			$resdata->error = $error;
			return $resdata;
		}
		$carnum=$result9['vehicle_num'];
		$resultData->carnum=$carnum;		
		return $resultData;
}

function bindRfid($json_string){
		try {
			$rfidtable=M("rfid");	
		} 	
		catch (Exception $e) {
			$error->code = 7;
			$error->des = urlencode('数据库连接失败');
			$resdata->error = $error;
			return $resdata;
			}
		 if(ini_get("magic_quotes_gpc")=="1")
		 {
		  $json_string=stripslashes($json_string);
		 }
		$json_data = json_decode($json_string);
		$wasteBind = $json_data->wasteBindList;
		$imei = $json_data->imei;
		$devtable=M('device');
		$result = $devtable->where(" device_serial_num='$imei'")->find();
		if(!$result){
			$error->code = 0;
			$error->des = urlencode('企业没有绑定手持设备');
			$resdata->error = $error;
			return $resdata;
		} 
		  $userId = $result['ownership_id'];
		  $ownershipType = $result['ownership_type']; 
		
		if($ownershipType != 5){
			$error->code = 17;
			$error->des = urlencode('该企业不是产生单位');
			$resdata->error = $error;
			return $resdata;
		}
		// ???add test to check if this is the right production unit!!!
		// detail need to clarify later
		$pdutable=M('production_unit');
		$result1 = $pdutable->where(" production_unit_id='$userId'")->find();
		if(!$result1){
			$error->code = 2;
			$error->des = urlencode('该用户没有企业');
			$resdata->error = $error;
			return $resdata;
		}
		  $productionId = $result1['production_unit_id'];
		
		$productionUnit = "production_unit_".$productionId;
		
		$key = 0;
		foreach($wasteBind as $wasteRfid){
			$rfid = $wasteRfid->rfid;
			$wasteId = $wasteRfid->wasteid;
			$addWay = $wasteRfid->addway;
			$time = date("Y-m-d H:i:s");
			if(!$rfidtable->where("rfid_id='$rfid'")->find()){
				$data['rfid_id']=$rfid;
				$data['waste_id']=$wasteId;
				$data['add_date_time']=$time;
				$data['rfid_status']=0;
				$data['add_method']=$addWay;
				$data['production_unit_id']=$userId;
				$data['waste_total']=0;
				$data['transfer_status']=0;
				$resultx=$rfidtable->add($data);
				if (!$resultx)
				  {
					$error[$key]->code = 3;
					$error[$key]->des = urlencode('写入RFID数据库失败');
					$error[$key]->rfid = $rfid;
					$key++;
				  }
				else{
				$data['rfid_id']=$rfid;
				$data['waste_id']=$wasteId;
				$data['add_date_time']=$time;
				$data['android_num']=$imei;
				$pdut=M($productionUnit);
				$resultx=$pdut->add($data);
				  if (!$resultx)
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
		if(isset($error)){
			$newerror['error'] = $error;
			return $newerror;
		}else{
			$resultData->code = 200;
			return $resultData;
		}
}

function addWaste($json_string){
	
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
		try {
			$devtable=M("device");	
		} 	
		catch (Exception $e) {
			$error->code = 7;
			$error->des = urlencode('数据库连接失败');
			$error->rfid=$rfid;
			$resdata->error = $error;
			return $resdata;
			}
	if($addnum<=0 or !is_numeric($addnum)){
		$error->code = 16;
		$error->des = urlencode('输入的数值必须为正数');
		$error->rfid=$rfid;
		$resdata->error = $error;
		return $resdata;
	}
	if($addway==0){
		$column = 'add_weight';
	}else{
		$column = 'add_num';
		$addnum = ceil($addnum);
	}
 	$result=$devtable->where("device_serial_num='$imei'")->find();
		
		$userId = null;
		$productionId = null;
		$ownershipType = null;
		if(!$result){
			$error->code = 0;
			$error->des = urlencode('企业没有绑定手持设备');
			$error->rfid=$rfid;
			$resdata->error = $error;
			return $resdata;
		}	
		  $userId = $result['ownership_id'];
		  $ownershipType = $result['ownership_type'];
		
		if($ownershipType != 5){
			$error->code = 17;
			$error->des = urlencode('该企业不是产生单位');
			$error->rfid=$rfid;
			$resdata->error = $error;
			return $resdata;
		}
	$pdutable=M('production_unit');
	$result1 = $pdutable->where(" production_unit_id='$userId'")->find();

	if(!$result1){
				$error->code = 2;
				$error->des = urlencode('该用户没有企业');
				$error->rfid=$rfid;
				$resdata->error = $error;
				return $resdata;
	}
	$productionId = $result1['production_unit_id'];
	$productionUnit = "production_unit_".$productionId;

	$time = date("Y-m-d H:i:s");
	$rfidtable=M('rfid');

	$result2 = $rfidtable->where(" rfid_id='$rfid'")->find();
	if(!$result2){
		$error->code = 8;
		$error->des = urlencode('RFID标签没有绑定废物');
		$error->rfid=$rfid;
		$resdata->error = $error;
		return $resdata;
	}
	$wasteTotal = 0;
	  $wasteTotal = $result2['waste_total'];
	  $wasteStatus = $result2['rfid_status'];

	if($wasteStatus==1 or $wasteStatus==2){
		$error->code = 12;
		$error->des = urlencode('废物已出库');
		$error->rfid=$rfid;
		$resdata->error = $error;
		return $resdata;
	}
	 if ($result2['record_id']!=null)
	 {
	 	$error->code = 26;
		$error->des = urlencode('已备案，不能再修改');
		$error->rfid=$rfid;
		$resdata->error = $error;
		return $resdata;
	 }
	//echo $wasteTotal;
	$wasteTotal = $wasteTotal + $addnum;
	$Model = new Model() ;// 实例化一个model对象 没有对应任何数据表
	$result3=$Model->execute("UPDATE rfid SET modify_date_time = '$time',rfid_status = 3, waste_total = '$wasteTotal' WHERE rfid_id = '$rfid' AND waste_id = '$wasteid'");

	$key = 0;
	if (!$result3)
	{
		$error[$key]->code = 3;
		$error[$key]->des = urlencode('更新RFID数据库失败');
		$error[$key]->rfid = $rfid;
		$key++;
	}else{
		$data['rfid_id']=$rfid;
		$data['waste_id']=$wasteid;
		$data['add_date_time']=$time;
		$data['android_num']=$imei;
		$data[$column]=$addnum;
		$pdut=M($productionUnit);
		$resultx=$pdut->add($data);
		if (!$resultx)
		{
			$error[$key]->code = 4;
			$error[$key]->des = urlencode('写入企业库存数据失败');
			$error[$key]->rfid = $rfid;
		}
	}
	if(isset($error)){
				$newerror['error'] = $error;
				return $newerror;
	}else{
				$resultData->code = 200;
				return $resultData;
	}
}

function getRfidWasteName($rfid,$imei){
	try {
			$devtable=M("device");	
		} 	
		catch (Exception $e) {
			$error->code = 7;
			$error->des = urlencode('数据库连接失败');
			$error->rfid=$rfid;
			$resdata->error = $error;
			return $resdata;
			}
	$result = $devtable->where(" device_serial_num='$imei'")->find();
	$userId = null;
	$productionId = null;
	if(!$result){
				$error->code = 0;
				$error->des = urlencode('企业没有绑定手持设备');
				$resdata->error = $error;
				return $resdata;
	}
	$rfidtable=M('rfid');
	$result1 = $rfidtable->where("rfid_id='$rfid'")->find();
	$wasteId = null;
	$addWay = null;
	if(!$result1){
		$error->code = 8;
		$error->des = urlencode('RFID标签没有绑定废物');
		$resdata->error = $error;
		return $resdata;
		
	}else{
		$wasteId = $result1['waste_id'];
		$wasteWay = $result1['add_method'];
		$wasteTotal = $result1['waste_total'];
		$wastable=M('waste');
		$result2 = $wastable->where(" waste_id='$wasteId'")->find();
		if(!$result2){
			$error->code = 9;
			$error->des = urlencode('没有这个危废物');
			$resdata->error = $error;
			return $resdata;
		}
			$wasteName = urlencode($result2['waste_name']);
		  
		$newData['name'] =  $wasteName;
		$newData['id'] = $wasteId;
		$newData['way'] = $wasteWay;
		$newData['total'] = $wasteTotal;
		return $newData;
	}
}
function getWasteName($imei){
	try {
			$devtable=M("device");	
		} 	
		catch (Exception $e) {
			$error->code = 7;
			$error->des = urlencode('数据库连接失败');
			$error->rfid=$rfid;
			$resdata->error = $error;
			return $resdata;
			}
	$result = $devtable->where(" device_serial_num='$imei'")->find();
	$userId = null;
	$wasteArray = array();
	$wasteName = null;
	$ownershipType = null;
	if(!$result){
		$error->code = 0;
		$error->des = urlencode('企业没有绑定手持设备');
		$resdata->error = $error;
		return $resdata;
	}
	  $userId = $result['ownership_id'];
	  $ownershipType = $result['ownership_type'];
	  
	if($ownershipType != 5){
		$error->code = 17;
		$error->des = urlencode('该企业不是产生单位');
		$resdata->error = $error;
		return $resdata;
	}
	$pdutable=M('production_unit');
	$result1 = $pdutable->where(" production_unit_id='$userId'")->find();
	if(!$result1){
		$error->code = 1;
		$error->des = urlencode('企业没有注册危险固废');
		$resdata->error = $error;
		return $resdata;
	}
	  $wasteArray = split(",",$result1['production_unit_waste']);
	  $wastable=M('waste');
	foreach ($wasteArray as $key => $value) {
		$result2 = $wastable->where(" waste_id='$value'")->find();
		$wasteName = urlencode($result2['waste_name']);
		$newDate[$key]['name'] =  $wasteName;
		$newDate[$key]['id'] = $value;
	}
	$resultData['code'] = 200;
	$resultData['wasteOptions'] = $newDate;
	return $resultData;
}

function wasteIn($json_string){
	try {
			$devtable=M("device");	
		} 	
		catch (Exception $e) {
			$error->code = 7;
			$error->des = urlencode('数据库连接失败');
			$error->rfid=$rfid;
			$resdata->error = $error;
			return $resdata;
			}

	if(ini_get("magic_quotes_gpc")=="1")
	{
		$json_string=stripslashes($json_string);
	}
	$json_data = json_decode($json_string);
	$rfidList = $json_data->rfidlist;
	$imei = $json_data->imei;
	$result = $devtable->where(" device_serial_num='$imei'")->find();
		$userId = null;
		$receivingId = null;
		$ownershipType = null;
		if(!$result){
			$error->code = 0;
			$error->des = urlencode('企业没有绑定手持设备');
			$resdata->error = $error;
			return $resdata;
		}
		  $userId = $result['ownership_id'];
		  $ownershipType = $result['ownership_type'];
		  
		
		if($ownershipType != 7){
			$error->code = 18;
			$error->des = urlencode('该企业不是接收单位');
			$resdata->error = $error;
			return $resdata;
		}
	$rcptable=M('reception_unit');
	$result1 = $rcptable->where(" reception_unit_id='$userId'")->find();
	if(!$result1){
				$error->code = 2;
				$error->des = urlencode('该用户没有企业');
				$resdata->error = $error;
				return $resdata;
	}
	  $receivingId = $result1['reception_unit_id'];
	$receivingUnit = "reception_unit_".$receivingId;
	$key = 0;
	$rfidtable=M('rfid');
	foreach($rfidList as $rfidobj){
		$rfid = $rfidobj->rfid;

		$result2 = $rfidtable->where("rfid_id='$rfid'")->find();
		if(!$result2){
			$error[$key]->code = 8;
			$error[$key]->des = urlencode('RFID标签没有绑定废物');
			$error[$key]->rfid = $rfid;
			$key++;
		}else{			
				$stat = $result2['rfid_status'];
				$wasteId = $result2['waste_id'];
				$addWay = $result2['add_method'];
				$total = $result2['waste_total'];
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
				$Model = new Model() ;			
				$sql3 = "UPDATE rfid SET modify_date_time = '$time',rfid_status = 2,reception_unit_id = '$userId' WHERE rfid_id = '$rfid'";
				$resultx=$Model->execute($sql3);
				if (!$resultx)
				{
					$error[$key]->code = 3;
					$error[$key]->des = urlencode('更新RFID数据库失败');
					$error[$key]->rfid = $rfid;
					$key++;
				}else{
					$data['rfid_id']=$rfid;
					$data['waste_id']=$wasteId;
					$data['receive_date_time']=$time;
					$data['android_num']=$imei;
					$data[$column]=$total;
					$rcut=M($receivingUnit);
					$resulty=$rcut->add($data);
					if (!$resulty)
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
	if(isset($error)){
			$newerror['error'] = $error;
			return $newerror;
	}else{
			$resultData->code = 200;
			return $resultData;
	}
}

function wasteOut($json_string){
	try {
			$devtable=M("device");	
		} 	
		catch (Exception $e) {
			$error->code = 7;
			$error->des = urlencode('数据库连接失败');
			$error->rfid=$rfid;
			$resdata->error = $error;
			return $resdata;
			}

	if(ini_get("magic_quotes_gpc")=="1")
	{
		$json_string=stripslashes($json_string);
	}
	$json_data = json_decode($json_string);
	$rfidList = $json_data->rfidlist;
	$imei = $json_data->imei;
	$result = $devtable->where(" device_serial_num='$imei'")->find();
		$userId = null;
		$productionId = null;
		$ownershipType = null;
		if(!$result){
			$error->code = 0;
			$error->des = urlencode('企业没有绑定手持设备');
			$resdata->error = $error;
			return $resdata;
		}
		
		  $userId = $result['ownership_id'];
		  $ownershipType = $result['ownership_type'];
		
		
		if($ownershipType != 5){
			$error->code = 17;
			$error->des = urlencode('该企业不是产生单位');
			$resdata->error = $error;
			return $resdata;
		}
		  
		$pdutable=M('production_unit');
	$result1 = $pdutable->where(" production_unit_id='$userId'")->find();
	if(!$result1){
		$error->code = 2;
		$error->des = urlencode('该用户没有企业');
		$resdata->error = $error;
		return $resdata;
	}
	$key = 0;
	$rfidtable=M('rfid');
	foreach($rfidList as $rfidobj){
		$rfid = $rfidobj->rfid;
		$result2 = $rfidtable->where(" rfid_id='$rfid'")->find();
		if(!$result2){
			$error[$key]->code = 8;
			$error[$key]->des = urlencode('RFID标签没有绑定废物');
			$error[$key]->rfid = $rfid;
			$key++;
		}else{
				$stat = $result2['rfid_status'];
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
				$Model = new Model() ;			
				$sql1 = "UPDATE rfid SET modify_date_time = '$time',rfid_status = 1 WHERE rfid_id = '$rfid'";
				$resultx=$Model->execute($sql1);
				if (!$resultx)
				{
					$error[$key]->code = 3;
					$error[$key]->des = urlencode('更新RFID数据库失败');
					$error[$key]->rfid = $rfid;
					$key++;
				}
			}
		}
	}
	if(isset($error)){
			$newerror['error'] = $error;
			return $newerror;
	}else{
			$resultData->code = 200;
			return $resultData;
	}
}
?>