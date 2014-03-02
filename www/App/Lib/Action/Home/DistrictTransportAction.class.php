<?php
/**
 *
 */
class DistrictTransportAction extends DistrictCommonAction{
	// -------- 危废运输单位->侧边栏 --------
	public function transport_sidebar(){
		layout( './Common/frame' );
		$this->display( './Public/html/Content/District/transport/transport_sidebar.html' );
	}

	// 危废运输单位->企业基本信息->企业基本信息
	public function transport_basic_information(){
		$transport_unit = M( 'transport_unit' )->where( array( 'jurisdiction_id' => session( 'jurisdiction_id' ) ) )->getField( 'transport_unit_id,transport_unit_name,transport_unit_address,transport_unit_county' );
		$transport_unit_json = json_encode( $transport_unit );
		$tmp_content=$this->fetch( './Public/html/Content/District/transport/transport_basic_information.html' );
		$tmp_content = "<script>transport_unit_json = $transport_unit_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废运输单位->企业基本信息->企业基本信息：详情
	public function transport_basic_information_page($record_id=""){
		$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => $record_id ) )->find();
		$this->unit = $transport_unit;
		$tmp_content=$this->fetch( './Public/html/Content/District/transport/transport_basic_information_page.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废运输单位->运输车辆管理->运输车辆管理
	public function transport_vehicle_management(){
		$vehicle = M( 'vehicle' );
		$condition['jurisdiction_id'] = array('EQ', session( 'jurisdiction_id' ) );
		$condition['_string'] = 'vehicle_status!=2';
		$join = $vehicle->join( 'transport_unit ON vehicle.transport_unit_id = transport_unit.transport_unit_id' )->where( $condition )->select();
		$vehicle_json = json_encode( $join );

		$tmp_content=$this->fetch( './Public/html/Content/District/transport/transport_vehicle_management.html' );
		$tmp_content="<script>vehicle = $vehicle_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废运输单位->运输车辆管理->运输车辆管理->gps
	public function transport_vehicle_management_gps_detail($vehicle_id=""){
		$vehicle = M( 'vehicle' )->where( array( 'vehicle_id' => $vehicle_id ) )->find();
		$device_num = M( 'device' )->where( array( 'device_id' => $vehicle['device_id'] ) )->getField('device_serial_num');
		$this->device_num = $device_num;

		$tmp_content=$this->fetch( './Public/html/Content/District/transport/transport_vehicle_management_gps_detail.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废运输单位->运输车辆管理->运输车辆管理->详情
	public function transport_vehicle_management_detail($vehicle_id=""){
		$vehicle = M( 'vehicle' )->where( array( 'vehicle_id' => $vehicle_id ) )->find();
		$this->vehicle = $vehicle;

		$tmp_content=$this->fetch( './Public/html/Content/District/transport/transport_vehicle_management_detail.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废运输单位->GPS监控信息->GPS监控信息
	public function transport_gps_monitor_information(){
		$tmp_content=$this->fetch( './Public/html/Content/District/transport/transport_gps_monitor_information.html' );
		$this->ajaxReturn( $tmp_content );
	}

}
?>