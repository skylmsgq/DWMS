<?php
/**
 *
 */
class DistrictMapAction extends DistrictCommonAction{
	// -------- 转移地图 侧边栏 --------
	public function map_sidebar() {
		layout( './Common/frame' );
		$this->display( './Public/html/Content/District/map/map_sidebar.html' );
	}

	// 转移地图->地图展示->转移地图展示
	public function transfer_map_display() {
		$condition['transport_date'] = date( 'Y-m-d', strtotime( '2014-01-13' ) );
		//$condition['transport_date'] = date( 'Y-m-d', time() );
		$condition['jurisdiction_id'] = array( 'EQ', session( 'jurisdiction_id' ) );
		$condition['route_status'] = array( 'EQ', 0 ); // 0:路线可用
		$condition['vehicle_status'] = array( 'EQ', 1 ); // 车辆添加并已绑定设备
		$route_vehicle_join = M( 'route_vehicle' )->join( 'route ON route_vehicle.route_id = route.route_id' )->join( 'vehicle ON route_vehicle.vehicle_id = vehicle.vehicle_id' )->where( $condition )->select();

		for ( $idx = 0; $idx < count( $route_vehicle_join ); ++$idx ) {
			$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => $route_vehicle_join[$idx]['transport_unit_id'] ) )->find();
			$transport_unit_data = array( 'vehicle_id' => $route_vehicle_join[$idx]['vehicle_id'], 'transport_unit_name' => $transport_unit['transport_unit_name'], 'transport_unit_phone' => $transport_unit['transport_unit_phone'], 'transport_unit_address' => $transport_unit['transport_unit_address'], 'transport_unit_contacts_name' => $transport_unit['transport_unit_contacts_name'], 'transport_unit_contacts_phone' => $transport_unit['transport_unit_contacts_phone'] );
			$transport_unit_array[$idx] = $transport_unit_data;
		}

		$alarm_distance = M( 'alarm_distance' )->where( array( 'jurisdiction_id' => session( 'jurisdiction_id' ) ) )->find();

		if ( ( $route_vehicle_join ) && ( $alarm_distance ) ) {
			$route_vehicle_join_json = json_encode( $route_vehicle_join );
			$alarm_distance_json = json_encode( $alarm_distance );
			$transport_unit_json = json_encode( $transport_unit_array );
			$tmp_content = $this->fetch( './Public/html/Content/District/map/transfer_map_display.html' );
			$tmp_content = "<script> route_json=$route_vehicle_join_json; transport_unit_json=$transport_unit_json; alarm_distance_json=$alarm_distance_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( "加载页面失败，请重新点击侧边栏加载页面。" );
		}
	}

	// 转移地图->地图展示->转移地图展示：获取实时GPS数据
	public function ajax_get_gps_data() {
		$ajax_send_data = I( 'post.ajaxSendData' );
		$ajax_send_data = htmlspecialchars_decode( $ajax_send_data );
		$ajax_send_data = json_decode( $ajax_send_data );

		$device_condition['device_type_id'] = array( 'EQ', 0 );  //0：DTU设备
		$device_condition['device_status'] = array( 'EQ', 1 ); //1：表示设备已绑定车辆，运行正常
		for ( $idx = 0; $idx < count( $ajax_send_data ); ++$idx ) {
			$device_condition['device_id'] = array( 'EQ', $ajax_send_data[$idx]->device_id );
			$device_serial_num = M( 'device' )->where( $device_condition )->getField( 'device_serial_num' );
			$gps_table_name = 'gps_' . $device_serial_num;
			$gps = M( $gps_table_name );
			$gps_max_id = $gps->where( array( 'status' => 0 ) )->max( 'id' );
			$gps_lng_lat = $gps->where( array( 'id' => $gps_max_id ) )->field( 'bmap_longitude, bmap_latitude, speed, offset_distance' )->find();
			$gps_data = array( 'vehicle_id' => $ajax_send_data[$idx]->vehicle_id, 'lng' => $gps_lng_lat['bmap_longitude'], 'lat' => $gps_lng_lat['bmap_latitude'], 'speed' => $gps_lng_lat['speed'], 'offset_distance' => $gps_lng_lat['offset_distance'] );
			$gps_data_array[$idx] = $gps_data;
		}
		$this->ajaxReturn( $gps_data_array );
	}

	// 转移地图->地图展示->转移地图展示：设置告警距离
	public function ajax_setting_alarm_distance() {
		$data['id'] = I( 'post.id' );
		$data['warning_distance'] = I( 'post.warning_distance' );
		$data['alarm_distance'] = I( 'post.alarm_distance' );
		$result = M( 'alarm_distance' )->save( $data );
		if ( $result ) {
			$this->ajaxReturn( 'success' );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

	// 转移地图->地图展示->指定车辆历史回放
	public function designate_vehicle_playback() {
		$condition['jurisdiction_id'] = array( 'EQ', session( 'jurisdiction_id' ) );
		$transport_unit = M( 'transport_unit' )->where( $condition )->select();

		$alarm_distance = M( 'alarm_distance' )->where( array( 'jurisdiction_id' => session( 'jurisdiction_id' ) ) )->find();

		if ( $transport_unit && $alarm_distance ) {
			$transport_unit_json = json_encode( $transport_unit );
			$alarm_distance_json = json_encode( $alarm_distance );
			$tmp_content = $this->fetch( './Public/html/Content/District/map/designate_vehicle_playback.html' );
			$tmp_content = "<script> transport_unit_json = $transport_unit_json; alarm_distance_json = $alarm_distance_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( "加载页面失败，请重新点击侧边栏加载页面。" );
		}
	}

	// 转移地图->地图展示->指定车辆历史回放：获取车辆列表
	public function ajax_get_vehicle_list() {
		$condition['transport_unit_id'] = array( 'EQ', I( 'post.transport_unit_id' ) );
		$vehicle_list = M( 'vehicle' )->where( $condition )->select();
		if ( $vehicle_list ) {
			$this->ajaxReturn( $vehicle_list );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

	// 转移地图->地图展示->指定车辆历史回放：获取车辆历史GPS数据
	public function ajax_get_vehicle_gps_data() {
		$condition['vehicle_id'] = array( 'EQ', I( 'post.vehicle_id' ) );
		$device_id = M( 'vehicle' )->where( $condition )->getField( 'device_id' );
		$device_serial_num = M( 'device' )->where( array( 'device_id' => $device_id ) )->getField( 'device_serial_num' );

		$where['datetime'] = array( array( 'EGT', I( 'post.beginDate' ) ), array( 'ELT', I( 'post.endDate' ) ) );
		$where['status'] = 0;
		$gps_data = M( 'gps_' . $device_serial_num )->where( $where )->field( 'vehicle_id, datetime, bmap_longitude, bmap_latitude, speed, offset_distance' )->select();
		if ( $gps_data ) {
			$this->ajaxReturn( $gps_data );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

	// 转移地图->地图展示->转移地图历史回放
	public function transfer_map_playback() {
		$alarm_distance = M( 'alarm_distance' )->where( array( 'jurisdiction_id' => session( 'jurisdiction_id' ) ) )->find();

		if ( $alarm_distance ) {
			$alarm_distance_json = json_encode( $alarm_distance );
			$tmp_content = $this->fetch( './Public/html/Content/District/map/transfer_map_playback.html' );
			$tmp_content = "<script> alarm_distance_json = $alarm_distance_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( "加载页面失败，请重新点击侧边栏加载页面。" );
		}
	}

	// 转移地图->地图展示->转移地图历史回放：获取所有车辆历史GPS路线
	public function ajax_get_vehicles_gps_data() {
		$condition['jurisdiction_id'] = array( 'EQ', session( 'jurisdiction_id' ) );
		$vehicle_device = M( 'vehicle' )->join( 'device ON vehicle.device_id = device.device_id' )->where( $condition )->field( 'vehicle_id, device_serial_num' )->select();
		for ( $idx = 0; $idx < count( $vehicle_device ); ++$idx ) {
			$gps_table_name = 'gps_' . $vehicle_device[$idx]['device_serial_num'];
			$gps = M( $gps_table_name );
			$where['datetime'] = array( array( 'EGT', I( 'post.beginDate' ) ), array( 'ELT', I( 'post.endDate' ) ) );
			$where['status'] = 0;
			$gps_route = $gps->where( $where )->field( 'vehicle_id, datetime, bmap_longitude, bmap_latitude, speed, offset_distance' )->select();
			$gps_route_array[$idx] = $gps_route;
		}
		$this->ajaxReturn( $gps_route_array );
	}

	// 转移地图->地图展示：左击覆盖物获取车辆和运输单位信息
	public function ajax_get_vehicle_transport_unit() {
		$vehicle_transport_unit = M( 'vehicle' )->join( 'transport_unit ON vehicle.transport_unit_id = transport_unit.transport_unit_id' )->where( array( 'vehicle_id' => I( 'post.vehicle_id' ) ) )->find();
		if ( $vehicle_transport_unit ) {
			$this->ajaxReturn( $vehicle_transport_unit );
		} else {
			$this->ajaxReturn( I( 'post.vehicle_id' ) );
		}
	}

	// 转移地图->地图展示：右击覆盖物获取车辆指定路线信息
	public function ajax_get_vehicle_route() {
		$condition['vehicle_id'] = array( 'EQ', I( 'post.vehicle_id' ) );
		$datetime = date( 'Y-m-d', strtotime( I( 'post.datetime' ) ) );
		$condition['transport_date'] = array( 'EQ', $datetime );
		$route_id = M( 'route_vehicle' )->where( $condition )->getField( 'route_id' );
		$route = M( 'route' )->where( array( 'route_id' => $route_id ) )->find();
		if ( $route ) {
			$this->ajaxReturn( $route );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

	// 转移地图->地图展示->仓库地图展示
	public function warehouse_map_display() {
		$condition['jurisdiction_id'] = array( 'EQ', session( 'jurisdiction_id' ) );
		$production_unit = M( 'production_unit' )->where( $condition )->select();
		$reception_unit = M( 'reception_unit' )->where( $condition )->select();

		if ( ( $production_unit ) && ( $reception_unit ) ) {
			$production_unit_json = json_encode( $production_unit );
			$reception_unit_json = json_encode( $reception_unit );
			$tmp_content = $this->fetch( './Public/html/Content/District/map/warehouse_map_display.html' );
			$tmp_content = "<script> production_unit_json = $production_unit_json; reception_unit_json = $reception_unit_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( "加载页面失败，请重新点击侧边栏加载页面。" );
		}
	}

	// 转移地图->路线规划->运输路线规划，百度API规划路线：生产单位->接受单位
	public function transfer_route_plan() {
		$condition['jurisdiction_id'] = array( 'EQ', session( 'jurisdiction_id' ) );
		$production_unit = M( 'production_unit' )->where( $condition )->select();
		$reception_unit = M( 'reception_unit' )->where( $condition )->select();

		if ( ( $production_unit ) && ( $reception_unit ) ) {
			$production_unit_json = json_encode( $production_unit );
			$reception_unit_json = json_encode( $reception_unit );
			$tmp_content=$this->fetch( './Public/html/Content/District/map/transfer_route_plan.html' );
			$tmp_content="<script> production_unit_json=$production_unit_json; reception_unit_json=$reception_unit_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( "加载页面失败，请重新点击侧边栏加载页面。" );
		}

	}

	// 转移地图->路线规划->运输路线规划：ajax传回路线数据
	public function ajax_transfer_route_plan() {
		$route=M( "route" );
		$condition['production_unit_id'] = array( 'EQ', I( 'post.production_unit_id' ) );
		$condition['reception_unit_id'] = array( 'EQ', I( 'post.reception_unit_id' ) );
		$condition['route_status'] = 0;
		$result = $route->where( $condition )->find();
		if ( $result ) {
			$this->ajaxReturn( 'exist' );
		} else {
			$data["production_unit_id"] = I( 'post.production_unit_id' );
			$data["reception_unit_id"] = I( 'post.reception_unit_id' );
			$data["jurisdiction_id"] = session( 'jurisdiction_id' );
			$data["route_lng_lat"] = I( 'post.route_lng_lat' );
			$data["route_detail"] = I( 'post.route_detail' );
			$time = date( 'Y-m-d H:i:s', time() );
			$data["route_add_time"] = $time;
			$data["route_modify_time"] = $time;
			$data["route_status"] = 0;
			$result = $route->add( $data );
			if ( $result ) {
				$this->ajaxReturn( "success" );
			}else {
				$this->ajaxReturn( "fail" );
			}
		}
	}

	// 转移地图->路线管理->运输路线查询
	public function transfer_route_query() {
		$production_unit = M( 'production_unit' )->where( array( 'jurisdiction_id' => session( 'jurisdiction_id' ) ) )->select();
		$reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => session( 'jurisdiction_id' ) ) )->select();
		$production_unit_json = json_encode( $production_unit );
		$reception_unit_json = json_encode( $reception_unit );
		if ( $production_unit_json && $reception_unit_json ) {
			$tmp_content=$this->fetch( './Public/html/Content/District/map/transfer_route_query.html' );
			$tmp_content = "<script> production_unit_json=$production_unit_json; reception_unit_json=$reception_unit_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

	// 转移地图->地图管理->运输路线查询：查找路线
	public function ajax_search_route() {
		$condition['production_unit_id'] = array( 'EQ', I( 'post.production_unit_id' ) );
		$condition['reception_unit_id'] = array( 'EQ', I( 'post.reception_unit_id' ) );
		$condition['route_status'] = 0;
		$route = M( 'route' )->where( $condition )->find();
		if ( $route ) {
			$this->ajaxReturn( $route );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

	// 转移地图->地图管理->运输路线查询：删除路线
	public function ajax_delete_route() {
		$time = date( 'Y-m-d H:i:s', time() );
		$data['route_delete_time'] = $time;
		$data['route_status'] = 1;
		$route = M( 'route' )->where( array( 'route_id' => I( 'post.route_id' ) ) )->save( $data );
		if ( $route ) {
			$this->ajaxReturn( 'success' );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

	// GPS数据模拟器
	public function gps_data_simulator() {
		$condition['device_type_id'] = array( 'EQ', 0 );
		$device = M( 'device' )->where( $condition )->select();
		if ( $device ) {
			$device_json = json_encode( $device );
			$tmp_content = $this->fetch( './Public/html/Content/District/map/gps_data_simulator.html' );
			$tmp_content = "<script>device_json=$device_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( "加载页面失败，请重新点击侧边栏加载页面。" );
		}
	}

	// GPS数据模拟器：GPS数据接受
	public function ajax_gps_data_receiver() {
		$device_serial_num = I( 'post.device_serial_num' );
		$gps_data_array = I( 'post.route_lng_lat' );
		$gps_data_array =  htmlspecialchars_decode( $gps_data_array );
		$gps_data_array = json_decode( $gps_data_array );

		$gps_table_name = "gps_" . $device_serial_num;
		$gps = M( $gps_table_name );
		//$time = date( 'Y-m-d H:i:s', time() );
		$time = date( 'Y-m-d H:i:s', strtotime( '2014-02-20 09:00:00' ) );
		for ( $idx = 0; $idx < count( $gps_data_array ); $idx += 2 ) {
			$time = date( 'Y-m-d H:i:s', strtotime( $time ) + 10 );
			$data['datetime'] = $time;
			$data['bmap_longitude'] = $gps_data_array[$idx]->lng;
			$data['bmap_latitude'] = $gps_data_array[$idx]->lat;
			$data['status'] = 0;

			$gps->add( $data );
		}
		if ( $idx == count( $gps_data_array ) ) {
			$this->ajaxReturn( 'success' );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}
}
?>
