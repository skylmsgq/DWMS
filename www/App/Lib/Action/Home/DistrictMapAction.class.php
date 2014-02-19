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
		$join = $vehicle->join( 'transport_unit ON vehicle.transport_unit_id = transport_unit.transport_unit_id' )->where( $condition )->select();
		$join_json = json_encode( $join );

		$route_vehicle = M( 'route_vehicle' );
		$route_vehicle_join = $route_vehicle->join( 'route ON route_vehicle.route_id = route.route_id' )->join( 'vehicle ON route_vehicle.vehicle_id = vehicle.vehicle_id' )->where( $condition )->select();
		$route_vehicle_join_json = json_encode( $route_vehicle_join );

		$tmp_content=$this->fetch( './Public/html/Content/District/map/transfer_map_display.html' );
		$tmp_content = "<script>join_json=$join_json; route_json=$route_vehicle_join_json</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 转移地图->地图展示->转移地图展示：获取实时GPS数据
	public function ajax_gps_data() {
		$vehicle = M( 'vehicle' );
		$condition['vehicle_status'] = array( 'EQ', 2 );
		$condition['jurisdiction_id'] = array( 'EQ', session( 'jurisdiction_id' ) );
		$join = $vehicle->join( 'device ON vehicle.device_id = device.device_id' )->where( $condition )->field( 'vehicle_id, device_serial_num' )->select();

		for ($idx=0; $idx < count($join); $idx++) {
			$gps_table_name = 'gps_' . $join[$idx]['device_serial_num'];
			$gps = M( $gps_table_name );
			$gps_max_id = $gps->where( array( 'status' => 0 ) )->max( 'id' );
			$gps_lng_lat = $gps->where( array( 'id' => $gps_max_id ) )->field( 'bmap_longitude, bmap_latitude')->select();
			$gps_data = array( 'vehicle_id' => $join[$idx]['vehicle_id'], 'lng' => $gps_lng_lat[0]['bmap_longitude'], 'lat' => $gps_lng_lat[0]['bmap_latitude'] );
			$gps_data_array[$idx] = $gps_data;
		}
		$this->ajaxReturn( $gps_data_array );
	}

	// 转移地图->地图展示->仓库地图展示
	public function warehouse_map_display() {
		$condition['jurisdiction_id'] = array( 'EQ', session( 'jurisdiction_id' ) );
		$production_unit = M( 'production_unit' )->where( $condition )->select();
		$reception_unit = M( 'reception_unit' )->where( $condition )->select();
		$production_unit_json = json_encode( $production_unit );
		$reception_unit_json = json_encode( $reception_unit );
		$tmp_content = $this->fetch( './Public/html/Content/District/map/warehouse_map_display.html' );
		$tmp_content = "<script> production_unit_json = $production_unit_json; reception_unit_json = $reception_unit_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 转移地图->路线规划->运输路线规划，按照鼠标点规划路线
	public function transfer_route_plan_1() {
		$record = M( 'vehicle_gps_transport' )->where( "vehicle_status<2" )->select();
		$record_json = json_encode( $record );

		$tmp_content=$this->fetch( './Public/html/Content/District/map/transfer_route_plan_1.html' );
		$this->ajaxReturn( "<script>record_json=$record_json; </script> $tmp_content" );
	}

	// 转移地图->路线规划->运输路线规划，按照百度API自助规划路线
	public function transfer_route_plan_2() {
		$record = M( 'vehicle_gps_transport' )->where( "vehicle_status<2" )->select();
		$record_json = json_encode( $record );

		$tmp_content=$this->fetch( './Public/html/Content/District/map/transfer_route_plan_2.html' );
		$tmp_content="<script>record_json=$record_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 转移地图->路线规划->运输路线规划：ajax传回路线数据
	public function ajax_map_plan_receiver() {
		$table=M( "route" );
		if ( $table ) {
			$data["route_lng_lat"]=I( 'post.route_lng_lat' );
			$time = date( 'Y-m-d H:i:s', time() );
			$data["route_add_time"]=$time;
			$data["route_modify_time"]=$time;
			$data["route_status"]=0;
			$table->add( $data );
			$this->show( "succ" );
		}else {
			$this->show( "fail" );
		}
	}

	// 转移地图->路线规划->运输路线规划，百度API规划路线：生产单位->接受单位
	public function transfer_route_plan_3() {
		$production_unit = M( 'production_unit' )->where( array( 'jurisdiction_id' => session( 'jurisdiction_id' ) ) )->select();
		$production_unit_json = json_encode( $production_unit );
		$reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => session( 'jurisdiction_id' ) ) )->select();
		$reception_unit_json = json_encode( $reception_unit );

		$tmp_content=$this->fetch( './Public/html/Content/District/map/transfer_route_plan_3.html' );
		$tmp_content="<script> production_unit_json=$production_unit_json; reception_unit_json=$reception_unit_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 转移地图->路线规划->运输路线规划：ajax传回路线数据
	public function ajax_transfer_route_receiver() {
		$route=M( "route" );
		$condition['production_unit_id'] = array( 'EQ', I( 'post.production_unit_id' ) );
		$condition['reception_unit_id'] = array( 'EQ', I( 'post.reception_unit_id' ) );
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
			$data["route_add_time"]=$time;
			$data["route_modify_time"]=$time;
			$data["route_status"]=0;
			$result = $route->add( $data );
			if ( $result ) {
				$this->ajaxReturn( "success" );
			}else {
				$this->ajaxReturn( "fail" );
			}
		}
	}

	// 转移地图->路线规划->路线车辆绑定
	public function route_vehicle_binding(){
		$condition['jurisdiction_id'] = array( 'EQ', session( 'jurisdiction_id' ) );
		$production_unit = M( 'production_unit' )->where( $condition )->getField( 'production_unit_id, production_unit_name' );
		$reception_unit = M( 'reception_unit' )->where( $condition )->getField( 'reception_unit_id, reception_unit_name' );
		$condition['vehicle_status'] = array( 'EQ', 0 );
		$vehicle = M( 'vehicle' )->join( 'transport_unit ON vehicle.transport_unit_id = transport_unit.transport_unit_id' )->where( $condition )->getField( 'vehicle_id, vehicle_type, vehicle_num' );
		$production_unit_json = json_encode( $production_unit );
		$reception_unit_json = json_encode( $reception_unit );
		$vehicle_json = json_encode($vehicle);
		if ( $production_unit_json && $reception_unit_json ) {
			$tmp_content=$this->fetch( './Public/html/Content/District/map/route_vehicle_binding.html' );
			$tmp_content = "<script>production_unit_json=$production_unit_json; reception_unit_json=$reception_unit_json; vehicle_json=$vehicle_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
			$this->show( 'succ' );
		} else {
			$this->show( 'fail' );
		}
	}

	// 转移地图->路线规划->路线车辆绑定：绑定
	public function ajax_route_vehicle_binding(){
		$correlation = M( 'route_vehicle' );
		$data['route_id'] = I( 'post.route_id' );
		$data['vehicle_id'] = I( 'post.vehicle_id' );
		$time = date( 'Y-m-d H:i:s', time() );
		$data['correlation_add_time'] = $time;
		$data['correlation_status'] = 0;
		$result = $correlation->add( $data );
		if ( $result ) {
			$this->show( "succ" );
		}else {
			$this->show( "fail" );
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
		$route = M( 'route' )->where( array( 'production_unit_id' => I( 'post.production_unit_id' ), 'reception_unit_id' => I( 'post.reception_unit_id' ) ) )->select();
		// $route = htmlspecialchars_decode($route);
		// $route = stripslashes($route);

		$route_json = json_encode( $route );
		//$route_json = htmlspecialchars_decode( $route_json );
		//$route_json = json_encode( $route_json );

		//$route_json = stripslashes($route_json);
		$this->ajaxReturn( $route_json, 'JSON' );
	}

	// 转移地图->地图管理->运输路线查询：删除路线
	public function ajax_delete_route(){
		$route = M( 'route' )->where( array( 'route_id' => I( 'post.route_id' ) ) )->delete();
		if ( $route ) {
			$this->ajaxReturn( 'success' );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

}
?>
