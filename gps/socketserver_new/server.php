<?php

/**
 * Check dependencies
 */
 
require "DB.php"; 
date_default_timezone_set("PRC");
if( ! extension_loaded('sockets' ) ) {
	echo "This example requires sockets extension (http://www.php.net/manual/en/sockets.installation.php)\n";
	exit(-1);
}

if( ! extension_loaded('pcntl' ) ) {
	echo "This example requires PCNTL extension (http://www.php.net/manual/en/pcntl.installation.php)\n";
	exit(-1);
}

/**
 * Connection handler
 */
function onConnect( $client ) {
	$pid = pcntl_fork();
	
	if ($pid == -1) {
		 die('could not fork');
	} else if ($pid) {
		// parent process
		return;
	}
	
	$read = '';
	printf( "[%s] Connected at port %d\n", $client->getAddress(), $client->getPort() );
	
	$flag = 0;
	$con = mysql_connect('localhost', 'root', 'omnilab');
	
	if (!$con)
	{
		$msg = "Could not connect:".mysql_error();
		//$db->writeLog($msg);
		//die('Could not connect: ' . mysql_error());
		echo $msg."\n";
	}
	mysql_select_db("dwms", $con);
	while( true ) {
		$read = $client->read();
		if( $read != '' ) {
			$client->send( '[' . date( DATE_RFC822 ) . '] ' . $read  );
		}
		else {
			//echo "first one break!\n";
			$msg = "read is null!";
			$db->writeLog($msg);
			break;
		}
		
		if( preg_replace( '/[^a-z]/', '', $read ) == 'exit' ) {
			//echo "will exit!\n";
			break;
		}
		if( $read === null ) {
			//echo "read is null\n";
			printf( "[%s] Disconnected\n", $client->getAddress() );
			return false;
		}
		else {
			$db = new DatabaseDo();
			printf( "[%s] recieved: %s", $client->getAddress(), $read );
			$line = trim($read);
			//$db->InsertDB($line);
			if(strpos($line,"#")>3)
			{
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
				$stayStatus = 0;
				if((bool)strpos($line,"A")){
					$latitude =  trim(substr($line,strpos($line,"N")+2,strpos($line,"E")-strpos($line,"N")-3));
					$longitude = trim(substr($line,strpos($line,"E")+2,strpos($line,"V")-strpos($line,"E")-3));
					$speed = trim(substr($line,strpos($line,"V")+2,strpos($line,"H")-strpos($line,"V")-3));
					$heigh = trim(substr($line,strpos($line,"H")+2,strlen($line)-strpos($line,"H")-5));
					$status = 0;
					$rest = $db->getMap($longitude,$latitude);
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
									$wanderR = round($db->shortDist($p_json,$routeD),3);
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
										
											$result6 = mysql_query("SELECT alarm_distance, alarm_time  FROM alarm_distance WHERE jurisdiction_id='".$jurisdictionId."'");
											if(mysql_num_rows($result6)){
												while($row = mysql_fetch_array($result6))
												{
													$alarmDistance = $row['alarm_distance'];
													$alarmTime = $row['alarm_time'];
												}
												if($alarmDistance){
													$alarmDistance = floatval($alarmDistance);
													if($wanderR>=$alarmDistance){
														$sql2 = "INSERT INTO alarm (alarm_date_time, alarm_longitude, alarm_latitude, vehicle_offset_distance, vehicle_id, alarm_add_time, alarm_status, agency_id) VALUES ('$time', '$blong', '$blat', '$wanderR', '$vehicleId', '$time', '0', '$agencyId')";
														if(!mysql_query($sql2,$con)){	
															$msg =  "Could not insert alarm £º".mysql_error();
															$db->writeLog($msg);
														}
													}
												}else{
													$msg = "alarm diatance not found!";
													$db->writeLog($msg);
												}
												if($alarmTime){
													$alarmTimeSecond = (int) $alarmTime;
													$alarmData = $alarmTimeSecond*6;
													if(floatval($speed)==0.0){
														$flag++;
														if($flag>=$alarmData){
															$stayStatus = 1;
														}
													}else{
														if($flag>=$alarmData){
															$stayTime = floatval($flag)/6;
															$sql3 = "INSERT INTO alarm_time (alarm_date_time,vehicle_set_time, alarm_ alarm_longitude, alarm_latitude, vehicle_stay_time, vehicle_id, alarm_add_time, alarm_status, agency_id) VALUES ('$time', '$alarmTime', '$blong', '$blat', '$stayTime', '$vehicleId', '$time', '0', '$agencyId')";
															if(!mysql_query($sql3,$con)){	
																$msg =  "Could not insert alarm_time £º".mysql_error();
																$db->writeLog($msg);
															}
														}
														$flag = 0;
													}
													
													
												}else{
													$msg = "alarm time not found!";
													$db->writeLog($msg);
												}
											}else{
												$msg = "jurisdiction id:".$jurisdictionId."does not design alarm distance or alarm time";
												$db->writeLog($msg);
											}
											
										
										}else{
											$msg = "jurisdiction id:".$jurisdictionId."does not bind distrct";
											$db->writeLog($msg);
										}
										
									
									}else{
										$msg = "transport id:".$transportId."does not bind distrct";
										$db->writeLog($msg);
									
									}
									
								}else{
									$msg = "route id:".$routeId."does not design route";
									$db->writeLog($msg);
								}
								
							}else{
								$msg = "vehicle id:".$vehicleId."does not bind route";
								$db->writeLog($msg);
							}
							
						}else{
							$msg = "device id:".$deviceId."does not bind vehicle";
							$db->writeLog($msg);
						}
						
					}else{
						$msg = "could not find device id :".$id;
						$db->writeLog($msg);
					}
							
				}
				$tableName = trim("gps_".$id);
				if(isset($vehicleId)){
					$sql = "INSERT INTO $tableName (datetime,longitude,latitude,bmap_longitude,bmap_latitude,height,speed,status,offset_distance,vehicle_id,stay_status) VALUES ('$time','$longitude','$latitude','$blong','$blat','$heigh','$speed','$status','$wanderR', '$vehicleId', '$stayStatus')";
				}else{
					$sql = "INSERT INTO $tableName (datetime,longitude,latitude,bmap_longitude,bmap_latitude,height,speed,status,offset_distance,stay_status) VALUES ('$time', '$longitude', '$latitude', '$blong', '$blat', '$heigh', '$speed', '$status', '$wanderR', '$stayStatus')";
				}
				
				if(!mysql_query($sql,$con))
				{
					$msg = "insert into ".$tableName." fails£º".mysql_error();
					$db->writeLog($msg);
				}
			}
		}
	}
	$client->close();
	mysql_close($con);
	printf( "[%s] Disconnected\n", $client->getAddress() );
	
}

require "sock/SocketServer.php";

$server = new \Sock\SocketServer();
$server->init();
$server->setConnectionHandler( 'onConnect' );
$server->listen();
