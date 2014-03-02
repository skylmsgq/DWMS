<?php
date_default_timezone_set("PRC");
class test{

	function writeLog($msg)
	{
		$logFile = date('Y-m-d').'.txt';
		$message = date('Y-m-d H:i:s').' >>> '.$msg."\r\n";
		file_put_contents($logFile,$message,FILE_APPEND );
	}
	
	function sqr($x)
	{
		return $x*$x;
	}
	function pointFromLatLng($lng,$lat)
	{
		$pi = 3.1415926535;
		$o ->x = ($lng/180.0*$pi*5490);
		$o ->y = ($lat/180.0*$pi*6340);
		return $o;
	}
	function dist2($v,$w)
	{
	
		return $this->sqr($v->x - $w->x) + $this->sqr($v->y - $w->y);
	}
	function distToSegmentSquared($p,$v,$w)
	{
		$l2 = $this->dist2($v,$w);
		if($l2==0)
		{
			return $this->dist2($p,$v);
		}
		$t = (($p->x - $v->x)*($w->x - $v->x) + ($p->y - $v->y)*($w->y - $v->y))/12;
		if($t<0) return $this->dist2($p,$v);
		if($t>1) return $this->dist2($p,$w);
		$r->x = $v->x + $t*($w->x - $v->x);
		$r->y = $v->y + $t*($w->y - $v->y);
		return $this->dist2($p,$r);
	}
	function distToSegment($p,$v,$w)
	{
		return sqrt($this->distToSegmentSquared($p,$v,$w)); 
	}
	function disToPath($p,$arr)
	{
		//echo count($arr);
		if(count($arr)<=0)
		{ 
			return 0.0;
		}
		$shortD = $this->dist2($p,$arr[0]);
		//echo $shortD;
		for ($i = 0;$i<count($arr)-1;$i++)
		{
			$cur = $this->distToSegment($p,$arr[$i],$arr[$i+1]);
			if($cur<$shortD)
			{
				$shortD = $cur;
			}
		}
		return $shortD;
	}
	function shortDist($p_json,$arr_json)
	{
		$p = $this->pointFromLatLng($p_json->lng,$p_json->lat);
		
		//echo $p->x.'\r\n'.$p->y.'\r\n';
		$newarr = array();
		for($i=0;$i<count($arr_json);$i++)
		{
			//echo $arr_json[$i]->lng.'\r\n';
			//echo $arr_json[$i]->lat.'\r\n';
			$newarr[$i] = $this->pointFromLatLng($arr_json[$i]->lng, $arr_json[$i]->lat);
			
		}
		//echo count($newarr);
		return $this->disToPath($p,$newarr);
	}
	function test()
	{
		$con = mysql_connect('10.50.6.70', 'root', 'root1234');
			if (!$con)
			{
			 die('Could not connect: ' . mysql_error());
			}
			mysql_select_db("dwms", $con);
			$id = 308033501795;
			
			$result = mysql_query("SELECT device_id FROM device WHERE device_serial_num='".$id."'");
				while($row = mysql_fetch_array($result))
				{
					$deviceId = $row['device_id'];
					
				}
				$result1 = mysql_query("SELECT vehicle_id,transport_unit_id FROM vehicle WHERE device_id='".$deviceId."'");
				while($row = mysql_fetch_array($result1))
				{
					$vehicleId = $row['vehicle_id'];
					$transportId = $row['transport_unit_id'];
					 
				}		
				$result2 = mysql_query("SELECT  Max(correlation_add_time),route_id FROM route_vehicle WHERE vehicle_id='".$vehicleId."' and correlation_status = '0'");
				while($row = mysql_fetch_array($result2))
				{
					 $routeId = $row['route_id'];
					
				}
				$result3 = mysql_query("SELECT route_lng_lat FROM route WHERE route_id='".$routeId."'");
				while($row = mysql_fetch_array($result3))
				{
					$routeDetail = $row['route_lng_lat'];
					
				}
				$routeD = json_decode(html_entity_decode($routeDetail));
				//$p_json->lng = 121;
				//$p_json->lat = 31;
				//echo $wanderR = $this->shortDist($p_json,$routeD);
				$tableGPS = "gps_".$id;
				$result5 = mysql_query("SELECT jurisdiction_id  FROM transport_unit WHERE transport_unit_id='".$transportId."'");
				while($row = mysql_fetch_array($result5))
				{
					$jurisdictionId = $row['jurisdiction_id'];	
				}
				//echo $jurisdictionId ;
				$result7 = mysql_query("SELECT agency_id  FROM agency WHERE jurisdiction_id='".$jurisdictionId."'");
				while($row = mysql_fetch_array($result7))
				{
					$agencyId = $row['agency_id'];	
				}
				$result6 = mysql_query("SELECT warning_distance,alarm_distance  FROM alarm_distance WHERE jurisdiction_id='".$jurisdictionId."'");
				while($row = mysql_fetch_array($result6))
				{
					$alarmDistance = $row['alarm_distance'];
					//$warningDistance = $row['warning_distance'];
				}
				
				
				$result4 = mysql_query("SELECT * FROM $tableGPS WHERE status = '0'");
				while($row = mysql_fetch_array($result4)){
					$id = $row['id'];
					$long = $row['bmap_longitude'];
					$lat = $row['bmap_latitude'];
					$time = $row['datetime'];
					$p_json->lng = $long;
					$p_json->lat = $lat;
					$wanderR = round($this->shortDist($p_json,$routeD),3);
					
					// if($wanderR>=$alarmDistance){
						// $sql2 = "INSERT INTO alarm (alarm_date_time, alarm_longitude, alarm_latitude, vehicle_offset_distance, vehicle_id, alarm_add_time, alarm_status, agency_id) VALUES ('$time', '$long', '$lat', '$wanderR', '$vehicleId', '$time', '0', '$agencyId')";
						// if(mysql_query($sql2,$con)){
							
							// echo "插入数据成功！";
							
						// } else {
							// echo "插入数据失败：".mysql_error();
						// }
					// }
					$sql1 = "UPDATE $tableGPS SET offset_distance = $wanderR, vehicle_id = $vehicleId WHERE id = '".$id."'";
					if(mysql_query($sql1,$con)){
						echo "更新数据成功！";
						$msg = "更新".$id."成功！";
						$this->writeLog($msg);
					} else {
						echo "更新数据失败：".mysql_error();
					}
					echo $wanderR."\r\n";
				}
	}
}
new test();
?>