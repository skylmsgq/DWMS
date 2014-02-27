<?php
/**
 * SelectSocketServer Class
 * By James.Napu(zhangzhaohui@sjtu.edu.cn)
**/
set_time_limit(0);
date_default_timezone_set("PRC");

class SelectSocketServer 
{
	private static $socket;
	private static $timeout = 60;
	private static $maxconns = 1024;
	private static $connections = array();
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
		if(count($arr)<=0)
		{ 
			return 0.0;
		}
		$shortD = $this->dist2($p,$arr[0]);
		for ($i = 0;$i<count($arr);$i++)
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
	function getMap($long,$lat){

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
			$msg = "访问百度API错误";
			$this->writeLog($msg);
		}
			//echo $blong.','.$blat;
			return $blong.','.$blat;	
	}


	function httpRequest($url,$method,$params=array()){

			if(trim($url)==''||!in_array($method,array('get','post'))||!is_array($params)){
				//echo 'false';
				return false;
			}
			//echo 'right';
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
					//echo $url;
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
			//echo $result;
			return $res;	
	} 
	
	
	function InsertDB($line){

		if(strpos($line,"#")>3){
			$con = mysql_connect('10.50.6.70', 'root', 'root1234');
			if (!$con)
			{
				$msg = "数据库连接失败".mysql_error();
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
			$id = substr($line,0,strpos($line,"#"));
			$blong = 0.0;
			$blat = 0.0;
			if((bool)strpos($line,"A")){
				$latitude =  substr($line,strpos($line,"N")+2,strpos($line,"E")-strpos($line,"N")-3);
				$longitude = substr($line,strpos($line,"E")+2,strpos($line,"V")-strpos($line,"E")-3);
				$speed = substr($line,strpos($line,"V")+2,strpos($line,"H")-strpos($line,"V")-3);
				$heigh = substr($line,strpos($line,"H")+2,strlen($line)-strpos($line,"H")-5);
				$status = 0;
				$rest = $this->getMap($longitude,$latitude);
				list($blong,$blat)= split(',',$rest);
				$p_json->x = $blong;
				$p_json->y = $blat;
				$wanderR = 0.0;
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
												$sql2 = "INSERT INTO alarm (alarm_date_time, alarm_longitude, alarm_latitude, vehicle_offset_distance, vehicle_id, alarm_add_time, alarm_status, agency_id,alarm_distance) VALUES ('$time', '$long', '$lat', '$wanderR', '$vehicleId', '$time', '0', '$agencyId','$alarmDistance')";
												if(!mysql_query($sql2,$con)){	
													$msg =  "插入告警数据失败：".mysql_error();
													$this->writeLog($msg);
												}
											}
										}else{
											$msg = "权限id为:".$jurisdictionId."没有规划告警距离";
											$this->writeLog($msg);
										}
										
									
									}else{
										$msg = "权限id为:".$jurisdictionId."没有绑定环保局";
										$this->writeLog($msg);
									}
									
								
								}else{
									$msg = "运输企业id为:".$transportId."没有直属环保局";
									$this->writeLog($msg);
								
								}
								
							}else{
								$msg = "路线id为:".$routeId."没有规划路线";
								$this->writeLog($msg);
							}
							
						}else{
							$msg = "车辆id为:".$vehicleId."没有绑定路线";
							$this->writeLog($msg);
						}
						
					}else{
						$msg = "设备id为:".$deviceId."没有绑定车辆";
						$this->writeLog($msg);
					}
					
				}else{
					$msg = "没有找到序列号为:".$id."的设备";
					$this->writeLog($msg);
				}
						
			}
			$tableName = trim("gps_".$id);
			$sql = "INSERT INTO $tableName (datetime,longitude,latitude,bmap_longitude,bmap_latitude,height,speed,status,offset_distance, vehicle_id) VALUES ('$time','$longitude','$latitude','$blong','$blat','$heigh','$speed','$status','$wanderR', '$vehicleId')";
			if(!mysql_query($sql,$con))
			{
				$msg = "插入表".$tableName."失败：".mysql_error();
				$this->writeLog($msg);
			}
		}
	}

	function SelectSocketServer($port) 
	{
		global $errno, $errstr;
		if ($port < 1024) {
			die("Port must be a number which bigger than 1024\n");
		}
		
		$socket = socket_create_listen($port);
		if (!$socket) die("Listen $port failed");
		
		socket_set_nonblock($socket); // non_blocking
		
		while (true) 
		{
			$readfds = array_merge(self::$connections, array($socket));
			$writefds = array();
			
			//select one link and get the pip 
			if (socket_select($readfds, $writefds, $e = null, $t = self::$timeout)) 
			{
				if (in_array($socket, $readfds)) {
					$newconn = socket_accept($socket);
					$i = (int) $newconn;
					$reject = '';
					if (count(self::$connections) >= self::$maxconns) {
						$reject = "Server full, Try again later.\n";
					}

					self::$connections[$i] = $newconn;

					$writefds[$i] = $newconn;

					if ($reject) {
						socket_write($writefds[$i], $reject);
						unset($writefds[$i]);
						self::close($i);
					} else {
						echo "Client $i come.\n";
					}
					// remove the listening socket from the clients-with-data array
					$key = array_search($socket, $readfds);
					unset($readfds[$key]);
				}
				
				
				foreach ($readfds as $rfd) {
				
					$i = (int) $rfd;
				
					$line = @socket_read($rfd, 2048, PHP_NORMAL_READ);
					if ($line === false) {
					    
						echo "Connection closed on socket $i.\n";
						self::close($i);
						continue;
					}
					$tmp = substr($line, -1);
					if ($tmp != "\r" && $tmp != "\n") {
	
						continue;
					}

					$line = trim($line);
					if ($line == "quit") {
						echo "Client $i quit.\n";
						self::close($i);
						break;
					}
					if ($line) {
						echo "Client $i >>" . $line . "\n";
						self::InsertDB($line);
						//$this->bar();
					}
				}
				
				//foreach ($writefds as $wfd) {
				//	$i = (int) $wfd;
				//	$w = socket_write($wfd, "Welcome Client $i!\n");
				//}
			}
		}
	}
	
	function close ($i) 
	{
		socket_shutdown(self::$connections[$i]);
		socket_close(self::$connections[$i]);
		unset(self::$connections[$i]);
	}
}
new SelectSocketServer(10008);
?>