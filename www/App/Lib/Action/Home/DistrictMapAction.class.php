<?php
/**
 *
 */
class DistrictMapAction extends CommonAction{
	// -------- 转移地图 侧边栏 --------
	public function map_sidebar() {
		layout( './Common/frame' );
		$this->display( './Public/html/Content/District/map/map_sidebar.html' );
	}

	// 转移地图->地图展示->转移地图展示
	public function transfer_map_display() {
		$vehicle = M( 'vehicle' );
		$condition['vehicle_status'] = array( 'EQ', 2 );
		$condition['jurisdiction_id'] = array( 'EQ', session( 'jurisdiction_id' ) );
		$vehicle_transport_unit = $vehicle->join( 'transport_unit ON vehicle.transport_unit_id = transport_unit.transport_unit_id' )->where( $condition )->select();

		$route_vehicle = M( 'route_vehicle' );
		$route_vehicle_join = $route_vehicle->join( 'route ON route_vehicle.route_id = route.route_id' )->join( 'vehicle ON route_vehicle.vehicle_id = vehicle.vehicle_id' )->where( $condition )->select();

		if ( ( $vehicle_transport_unit ) && ( $route_vehicle_join ) ) {
			$vehicle_transport_unit_json = json_encode( $vehicle_transport_unit );
			$route_vehicle_join_json = json_encode( $route_vehicle_join );
			$tmp_content = $this->fetch( './Public/html/Content/District/map/transfer_map_display.html' );
			$tmp_content = "<script> vehicle_json=$vehicle_transport_unit_json; route_json=$route_vehicle_join_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( "加载页面失败，请重新点击侧边栏加载页面。" );
		}

	}

	// 转移地图->地图展示->转移地图展示：获取实时GPS数据
	public function ajax_gps_data() {
		$vehicle = M( 'vehicle' );
		$condition['vehicle_status'] = array( 'EQ', 2 );
		$condition['jurisdiction_id'] = array( 'EQ', session( 'jurisdiction_id' ) );
		$vehicle_device = $vehicle->join( 'device ON vehicle.device_id = device.device_id' )->where( $condition )->field( 'vehicle_id, device_serial_num' )->select();

		for ( $idx=0; $idx < count( $vehicle_device ); $idx++ ) {
			$gps_table_name = 'gps_' . $vehicle_device[$idx]['device_serial_num'];
			$gps = M( $gps_table_name );
			$gps_max_id = $gps->where( array( 'status' => 0 ) )->max( 'id' );
			$gps_lng_lat = $gps->where( array( 'id' => $gps_max_id ) )->field( 'bmap_longitude, bmap_latitude, speed, offset_distance' )->select();
			$gps_data = array( 'vehicle_id' => $vehicle_device[$idx]['vehicle_id'], 'lng' => $gps_lng_lat[0]['bmap_longitude'], 'lat' => $gps_lng_lat[0]['bmap_latitude'], 'speed' => $gps_lng_lat[0]['speed'], 'offset_distance' => $gps_lng_lat[0]['offset_distance'] );
			$gps_data_array[$idx] = $gps_data;
		}
		$this->ajaxReturn( $gps_data_array );
	}

	// 转移地图->地图展示->指定车辆历史回放
	public function designate_vehicle_playback() {
		$condition['jurisdiction_id'] = array( 'EQ', session( 'jurisdiction_id' ) );
		$transport_unit = M( 'transport_unit' )->where( $condition )->select();
		if ( $transport_unit ) {
			$transport_unit_json = json_encode( $transport_unit );
			$tmp_content = $this->fetch( './Public/html/Content/District/map/designate_vehicle_playback.html' );
			$tmp_content = "<script> transport_unit_json = $transport_unit_json; </script> $tmp_content";
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

	// 转移地图->地图展示->指定车辆历史回放：获取车辆历史路线
	public function ajax_get_vehicle_route() {
		$condition['vehicle_id'] = array( 'EQ', I( 'post.vehicle_id' ) );
		$device_id = M( 'vehicle' )->where( $condition )->getField( 'device_id' );
		$device_serial_num = M( 'device' )->where( array( 'device_id' => $device_id ) )->getField( 'device_serial_num' );

		$where['datetime'] = array( array( 'EGT', I( 'post.beginDate' ) ), array( 'ELT', I( 'post.endDate' ) ) );
		$where['status'] = 0;
		$gps_data = M( 'gps_' . $device_serial_num )->where( $where )->field( 'id, datetime, bmap_longitude, bmap_latitude, speed, offset_distance' )->select();
		if ( $gps_data ) {
			$this->ajaxReturn( $gps_data );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

	// 转移地图->地图展示->转移地图历史回放
	public function transfer_map_playback() {
		$vehicle = M( 'vehicle' );
		$condition['vehicle_status'] = array( 'EQ', 2 );
		$condition['jurisdiction_id'] = array( 'EQ', session( 'jurisdiction_id' ) );
		$vehicle_transport_unit = $vehicle->join( 'transport_unit ON vehicle.transport_unit_id = transport_unit.transport_unit_id' )->where( $condition )->select();

		$route_vehicle = M( 'route_vehicle' );
		$route_vehicle_join = $route_vehicle->join( 'route ON route_vehicle.route_id = route.route_id' )->join( 'vehicle ON route_vehicle.vehicle_id = vehicle.vehicle_id' )->where( $condition )->select();

		if ( ( $vehicle_transport_unit ) && ( $route_vehicle_join ) ) {
			$vehicle_transport_unit_json = json_encode( $vehicle_transport_unit );
			$route_vehicle_join_json = json_encode( $route_vehicle_join );
			$tmp_content = $this->fetch( './Public/html/Content/District/map/transfer_map_playback.html' );
			$tmp_content = "<script> vehicle_json=$vehicle_transport_unit_json; route_json=$route_vehicle_join_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( "加载页面失败，请重新点击侧边栏加载页面。" );
		}
	}

	// 转移地图->地图展示->转移地图历史回放：获取所有车辆历史路线
	public function ajax_get_vehicle_routes() {
		$vehicle = M( 'vehicle' );
		$condition['jurisdiction_id'] = array( 'EQ', session( 'jurisdiction_id' ) );
		$vehicle_device = $vehicle->join( 'device ON vehicle.device_id = device.device_id' )->where( $condition )->field( 'vehicle_id, device_serial_num' )->select();
		for ( $idx = 0; $idx < count( $vehicle_device ); ++$idx ) {
			$gps_table_name = 'gps_' . $vehicle_device[$idx]['device_serial_num'];
			$gps = M( $gps_table_name );
			$where['datetime'] = array( array( 'EGT', I( 'post.beginDate' ) ), array( 'ELT', I( 'post.endDate' ) ) );
			$where['status'] = 0;
			$gps_route = $gps->where( $where )->field( 'datetime, bmap_longitude, bmap_latitude, speed, vehicle_id, offset_distance' )->select();
			$gps_route_array[$idx] = $gps_route;
		}
		$this->ajaxReturn( $gps_route_array );
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
		$production_unit = M( 'production_unit' )->where( array( 'jurisdiction_id' => session( 'jurisdiction_id' ) ) )->getField( 'production_unit_id, production_unit_name' );
		$reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => session( 'jurisdiction_id' ) ) )->getField( 'reception_unit_id, reception_unit_name' );
		$production_unit_json = json_encode( $production_unit );
		$reception_unit_json = json_encode( $reception_unit );
		if ( $production_unit_json && $reception_unit_json ) {
			$tmp_content=$this->fetch( './Public/html/Content/District/map/transfer_route_query.html' );
			$tmp_content = "<script>production_unit_json=$production_unit_json; reception_unit_json=$reception_unit_json; </script> $tmp_content";
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
			$route_json = json_encode( $route );
			$this->ajaxReturn( $route_json );
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

}
?>
