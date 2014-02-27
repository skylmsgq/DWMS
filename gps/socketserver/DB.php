<?php
class DatabaseDo 
{

	function writeLog($msg)
	{
		$logFile = date('Y-m-d').'.txt';
		$message = date('Y-m-d H:i:s').' >>> '.$msg."\n";
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
		if(count($arr)<=0)
		{ 
			return 0.0;
		}
		$shortD = $this->dist2($p,$arr[0]);
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
	
		$newarr = array();
		for($i=0;$i<count($arr_json);$i++)
		{

			$newarr[$i] = $this->pointFromLatLng($arr_json[$i]->lng, $arr_json[$i]->lat);
			
		}
		return $this->disToPath($p,$newarr);
	}
	
	
	function trans($st)
	{
	    $num= (float)($st);
	    $i= floor($num/100);
	    $num=$num-$i*100;

	    return($num/60+$i);
	} 
	function getMap($long,$lat)
	{
		$url = 'http://api.map.baidu.com/ag/coord/convert';
		$method = 'get';
		//echo $long.'  '.$lat;
		$arrayList = array('from'=>'0','to'=>'4');
		$arrayList['x'] = $this->trans($long);
		$arrayList['y'] = $this->trans($lat);
		$json_string = $this->httpRequest($url,$method,$arrayList);
		$json_data = json_decode($json_string);
		$blong = 0.0;
		$blat = 0.0;
		if(($json_data->error)==0){
			$blong = base64_decode($json_data->x);
			$blat = base64_decode($json_data->y);
		}else{
			$msg = "Cann't access Baidu API";
			$this->writeLog($msg);
		}
			//echo $blong.','.$blat;
			return $blong.','.$blat;	
	}


	function httpRequest($url,$method,$params=array())
	{

			if(trim($url)==''||!in_array($method,array('get','post'))||!is_array($params)){
				return false;
			}
			$curl=curl_init();
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl,CURLOPT_HEADER,0 ) ;
			switch($method){
				case 'get':
					$str='?';
					foreach($params as $k=>$v){
						$str.=$k.'='.$v.'&';
					}
					$str=substr($str,0,-1);
					$url.=$str;
					curl_setopt($curl,CURLOPT_URL,$url);
				break;
				case 'post':
					curl_setopt($curl,CURLOPT_URL,$url);
					curl_setopt($curl,CURLOPT_POST,1 );
					curl_setopt($curl,CURLOPT_POSTFIELDS,$params);
				break;
				default:
					$res='';
				break;
			}

			if(!isset($res)){
				$res=curl_exec($curl);
			}
			curl_close($curl);
			return $res;	
	} 
	
	
	public function InsertDB($line)
	{

		if(strpos($line,"#")>3)
		{
			$con = mysql_connect('10.50.6.70', 'root', 'root1234');
			if (!$con)
			{
				$msg = "Could not connect:".mysql_error();
				$this->writeLog($msg);
				die('Could not connect: ' . mysql_error());
			}
			mysql_select_db("dwms", $con);
			$status = 1;
			$latitude = 0.0;
			$longitude = 0.0; 
			$speed = 0.0;
			$heigh = 0.0;
			$time = date("Y-m-d H:i:s");
			$id = trim(substr($line,0,strpos($line,"#")));
			$blong = 0.0;
			$blat = 0.0;
			$wanderR = 0.0;
			if((bool)strpos($line,"A")){
				$latitude =  trim(substr($line,strpos($line,"N")+2,strpos($line,"E")-strpos($line,"N")-3));
				$longitude = trim(substr($line,strpos($line,"E")+2,strpos($line,"V")-strpos($line,"E")-3));
				$speed = trim(substr($line,strpos($line,"V")+2,strpos($line,"H")-strpos($line,"V")-3));
				$heigh = trim(substr($line,strpos($line,"H")+2,strlen($line)-strpos($line,"H")-5));
				$status = 0;
				$rest = $this->getMap($longitude,$latitude);
				list($blong,$blat)= split(',',$rest);
				$p_json->lng = $blong;
				$p_json->lat = $blat;
				$result = mysql_query("SELECT device_id FROM device WHERE device_serial_num='".$id."'");
				if(mysql_num_rows($result)){
					while($row = mysql_fetch_array($result))
					{
						$deviceId = $row['device_id'];
					}
					$result1 = mysql_query("SELECT vehicle_id, transport_unit_id FROM vehicle WHERE device_id='".$deviceId."'");
					if(mysql_num_rows($result1)){
						while($row = mysql_fetch_array($result1))
						{
							$vehicleId = $row['vehicle_id'];
							$transportId = $row['transport_unit_id'];
						}		
						
						$result2 = mysql_query("SELECT  Max(correlation_add_time),route_id FROM route_vehicle WHERE vehicle_id='".$vehicleId."' and correlation_status = '0'");
						if(mysql_num_rows($result2)){
							while($row = mysql_fetch_array($result2))
							{
								$routeId = $row['route_id'];
							}
							$result3 = mysql_query("SELECT route_lng_lat FROM route WHERE route_id='".$routeId."'");
							if(mysql_num_rows($result3)){
								while($row = mysql_fetch_array($result3))
								{
									$routeDetail = $row['route_lng_lat'];
								}
								$routeD = json_decode(html_entity_decode($routeDetail));
								$wanderR = $this->shortDist($p_json,$routeD);
								$result4 = mysql_query("SELECT jurisdiction_id  FROM transport_unit WHERE transport_unit_id='".$transportId."'");
								if(mysql_num_rows($result4)){
									while($row = mysql_fetch_array($result4))
									{
										$jurisdictionId = $row['jurisdiction_id'];	
									}
									$result5 = mysql_query("SELECT agency_id  FROM agency WHERE jurisdiction_id='".$jurisdictionId."'");
									if(mysql_num_rows($result5)){
										while($row = mysql_fetch_array($result5))
										{
											$agencyId = $row['agency_id'];	
										}
									
										$result6 = mysql_query("SELECT alarm_distance  FROM alarm_distance WHERE jurisdiction_id='".$jurisdictionId."'");
										if(mysql_num_rows($result6)){
											while($row = mysql_fetch_array($result6))
											{
												$alarmDistance = $row['alarm_distance'];
											}
											if($wanderR>=$alarmDistance){
												$sql2 = "INSERT INTO alarm (alarm_date_time, alarm_longitude, alarm_latitude, vehicle_offset_distance, vehicle_id, alarm_add_time, alarm_status, agency_id,alarm_distance) VALUES ('$time', '$blong', '$blat', '$wanderR', '$vehicleId', '$time', '0', '$agencyId','$alarmDistance')";
												if(!mysql_query($sql2,$con)){	
													$msg =  "Could not insertDB£º".mysql_error();
													$this->writeLog($msg);
												}
											}
										}else{
											$msg = "jurisdiction id:".$jurisdictionId."does not design alarmdistance";
											$this->writeLog($msg);
										}
										
									
									}else{
										$msg = "jurisdiction id:".$jurisdictionId."does not bind distrct";
										$this->writeLog($msg);
									}
									
								
								}else{
									$msg = "transport id:".$transportId."does not bind distrct";
									$this->writeLog($msg);
								
								}
								
							}else{
								$msg = "route id:".$routeId."does not design route";
								$this->writeLog($msg);
							}
							
						}else{
							$msg = "vehicle id:".$vehicleId."does not bind route";
							$this->writeLog($msg);
						}
						
					}else{
						$msg = "device id:".$deviceId."does not bind vehicle";
						$this->writeLog($msg);
					}
					
				}else{
					$msg = "could not find device id :".$id;
					$this->writeLog($msg);
				}
						
			}
			$tableName = trim("gps_".$id);
			if(isset($vehicleId)){
				$sql = "INSERT INTO $tableName (datetime,longitude,latitude,bmap_longitude,bmap_latitude,height,speed,status,offset_distance,vehicle_id) VALUES ('$time','$longitude','$latitude','$blong','$blat','$heigh','$speed','$status','$wanderR', '$vehicleId')";
			}else{
				$sql = "INSERT INTO $tableName (datetime,longitude,latitude,bmap_longitude,bmap_latitude,height,speed,status,offset_distance) VALUES ('$time','$longitude','$latitude','$blong','$blat','$heigh','$speed','$status','$wanderR')";
			}
			
			if(!mysql_query($sql,$con))
			{
				$msg = "insert into ".$tableName." fails£º".mysql_error();
				$this->writeLog($msg);
			}
		}
	}

}
