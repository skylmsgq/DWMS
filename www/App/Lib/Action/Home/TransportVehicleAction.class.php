<?php
/**
 *
 */
class TransportVehicleAction extends TransportCommonAction{
	// -------- 运输车辆->侧边栏 --------
	public function vehicle_sidebar() {
		layout( './Common/frame' );
		$this->display( './Public/html/Content/Transport/vehicle/vehicle_sidebar.html' );
	}

	//运输车辆->运输车辆管理
	public function vehicle_management(){
		$condition['transport_unit_id'] = session('transport_unit_id');
		$condition['_string'] = 'vehicle_status!=2';

		$vehicle = M( 'vehicle' )->where($condition)->select();
		$vehicle_json = json_encode($vehicle);

		$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => session( 'transport_unit_id' ) ) )->getField('transport_unit_name');
		$transport_unit_name_json = json_encode($transport_unit);

		$tmp_content = $this->fetch('./Public/html/Content/Transport/vehicle/vehicle_management.html');
		$tmp_content = "<script>vehicle = $vehicle_json;transport_unit_name = $transport_unit_name_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	//运输车辆->运输车辆管理->详情页
	public function vehicle_management_detail($vehicle_id=""){
		$vehicle = M( 'vehicle' )->where( array( 'vehicle_id' => $vehicle_id ) )->find();
		$this->vehicle = $vehicle;

		$tmp_content = $this->fetch('./Public/html/Content/Transport/vehicle/vehicle_management_detail.html');
		$this->ajaxReturn( $tmp_content );
	}

	//运输车辆->运输车辆管理->修改页
	public function vehicle_management_modify($vehicle_id=""){
		$vehicle = M( 'vehicle' )->where( array( 'vehicle_id' => $vehicle_id ) )->find();
		$this->vehicle = $vehicle;

		$vehicle_id_json = json_encode($vehicle_id);

		$tmp_content = $this->fetch('./Public/html/Content/Transport/vehicle/vehicle_management_modify.html');
		$tmp_content = "<script>vehicle_id_json = $vehicle_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	//运输车辆->运输车辆管理->修改页->提交
	public function vehicle_management_modified($vehicle_id=""){
		$vehicle = M( 'vehicle' ); // 实例化record对象
		$data = I( 'post.' );
		$time = date( 'Y-m-d H:i:s', time() );
		$data['vehicle_modify_time'] = $time;
		$result = $vehicle->where( array( 'vehicle_id' => $vehicle_id ) )->save( $data );

		if ( $result ) {
			$this->ajaxReturn( 1, '修改成功！', 1 );
		} else {
			$this->ajaxReturn( 0, '修改失败！', 0 );
		}
	}

	//运输车辆->运输车辆管理->删除确认
	public function vehicle_management_delete_confirm($vehicle_id=""){
		$vehicle = M( 'vehicle' )->where( array( 'vehicle_id' => $vehicle_id ) )->find();
		if($vehicle){
			$this->vehicle = $vehicle;
			$vehicle_json = json_encode( $vehicle );
			$tmp_content = $this->fetch( './Public/html/Content/Transport/vehicle/vehicle_management_delete.html' );
			$tmp_content = "<script> vehicle_json=$vehicle_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else{
			$this->ajaxReturn("发生错误");
		}	
	}


	//运输车辆->运输车辆管理->删除
	public function vehicle_management_delete($vehicle_id=""){
		$vehicle = M( 'vehicle' ); // 实例化waste对象
		$data['vehicle_status'] = 2;
		$time = date( 'Y-m-d H:i:s', time() );
		$data['vehicle_delete_time'] = $time;
		$result = M( 'vehicle' )->where( array('vehicle_id' => $vehicle_id ) )->save( $data ); // 删除waste_id=id的用户数据

		if ($result) {
			$this->ajaxReturn( "success" );
		} else {
			$this->ajaxReturn( "fail" );
		}
	}

	//运输车辆->运输车辆添加
	public function vehicle_add(){
		$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => session( 'transport_unit_id' ) ) )->find();
		$this->unit = $transport_unit;
		$tmp_content = $this->fetch('./Public/html/Content/Transport/vehicle/vehicle_add.html');
		$this->ajaxReturn( $tmp_content );
	}

	//运输车辆->运输车辆添加->提交
	public function vehicle_add_form(){
		$vehicle = M( 'vehicle' );
		$vehicle->create();
		$time = date( 'Y-m-d H:i:s', time() );
		$vehicle->vehicle_add_time = $time;
		$vehicle->vehicle_modify_time = $time;
		$vehicle->transport_unit_id = session('transport_unit_id');
		$vehicle->vehicle_status = 0;
		$result = $vehicle->add();
		if ( $result ) {
			$this->ajaxReturn( 1, '保存成功！', 1 );
		} else {
			$this->ajaxReturn( 0, '保存失败！', 0 );
		}
	}

	//运输车辆->GPS绑定详情
	public function vehicle_gps_binding_detail($vehicle_id=""){
		$vehicle = M( 'vehicle' )->where( array( 'vehicle_id' => $vehicle_id ) )->find();
		$device_num = M( 'device' )->where( array( 'device_id' => $vehicle['device_id'] ) )->getField('device_serial_num');
		$this->device_num = $device_num;

		$tmp_content=$this->fetch( './Public/html/Content/Transport/vehicle/vehicle_gps_binding_detail.html' );
		$this->ajaxReturn( $tmp_content );
	}

	//运输车辆->GPS 绑定
	public function vehicle_gps_binding(){
		$transport_unit_id = session('transport_unit_id');

		$vehicle = M( 'vehicle' )->where( "transport_unit_id = '$transport_unit_id' and device_id is null" )->select();
		$vehicle_json = json_encode($vehicle);

		$transport_unit = M( 'transport_unit' )->where("transport_unit_id = '$transport_unit_id'")->getField('transport_unit_name');
		$transport_unit_name_json = json_encode($transport_unit);

		$tmp_content = $this->fetch('./Public/html/Content/Transport/vehicle/vehicle_gps_binding.html');
		$tmp_content = "<script>vehicle = $vehicle_json;transport_unit_name = $transport_unit_name_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}


	//运输车辆->GPS 绑定->绑定页面
	public function vehicle_gps_binding_request($vehicle_id=""){
		$vehicle_id_json = json_encode($vehicle_id);

		$device = M( 'device' )->where( array( 'ownership_type' => 6, 'ownership_id' => session( 'transport_unit_id' ), 'device_status' => 0 ) )->select();
		$device_json = json_encode($device);

		$tmp_content = $this->fetch('./Public/html/Content/Transport/vehicle/vehicle_gps_binding_request.html');
		$tmp_content = "<script>vehicle_id = $vehicle_id_json;device = $device_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	//运输车辆->GPS 绑定->绑定页面->提交
	public function vehicle_gps_binding_request_form(){
		$device = M( 'device' );
		$data_1['device_status'] = 1;
		$device->where( array( 'device_id' => I('post.device_id') ) )->save($data_1);

		$vehicle = M( 'vehicle' );
		$data = I('post.');
		$time = date( 'Y-m-d H:i:s', time() );
		$data['vehicle_modify_time'] = $time;
		$data['vehicle_status'] = 1;


		$vehicle->where( array( 'vehicle_id' => I('post.vehicle_id') ) )->save($data);
	}
}
?>