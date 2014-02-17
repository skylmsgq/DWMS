<?php
/**
 *
 */
class DistrictSystemAction extends CommonAction{
	// -------- 系统管理->侧边栏 --------
	public function system_sidebar(){
		layout( './Common/frame' );
		$this->display( './Public/html/Content/District/system/system_sidebar.html' );
	}

	// 系统管理->系统信息设置->管辖权限
	public function jurisdiction(){
		$tmp_content=$this->fetch( './Public/html/Content/District/system/jurisdiction.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->区县代码
	public function district_code(){
		$tmp_content=$this->fetch( './Public/html/Content/District/system/district_code.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->行业代码
	public function trade_code(){
		$tmp_content=$this->fetch( './Public/html/Content/District/system/trade_code.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->企业规模
	public function enterprise_scale(){
		$tmp_content=$this->fetch( './Public/html/Content/District/system/enterprise_scale.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->注册类型
	public function register_type(){
		$tmp_content=$this->fetch( './Public/html/Content/District/system/register_type.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物代码
	public function waste_code(){
		$waste = M( 'waste' )->order( 'waste_id DESC' )->select();
		$waste_json = json_encode( $waste );
		$tmp_content=$this->fetch( './Public/html/Content/District/system/waste_code.html' );
		$tmp_content="<script> record_json=$waste_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物类别
	public function waste_category(){
		$tmp_content=$this->fetch( './Public/html/Content/District/system/waste_category.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物形态
	public function waste_form(){
		$tmp_content=$this->fetch( './Public/html/Content/District/system/waste_form.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->包装方式
	public function package_method(){
		$tmp_content=$this->fetch( './Public/html/Content/District/system/package_method.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->危废处理方式
	public function waste_disposal_method(){
		$tmp_content=$this->fetch( './Public/html/Content/District/system/waste_disposal_method.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->危废去向
	public function waste_direction(){
		$tmp_content=$this->fetch( './Public/html/Content/District/system/waste_direction.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->运输方式
	public function transport_method(){
		$tmp_content=$this->fetch( './Public/html/Content/District/system/transport_method.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->设备管理->添加设备
	public function device_add(){
		$tmp_content=$this->fetch( './Public/html/Content/District/system/device_add.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->设备管理->添加设备：接收添加设备信息
	public function device_add_form(){
		$device = M( 'device' );//实例化record对象
		$device->create();		// 根据表单提交的POST数据创建数据对象
		$device->device_status = 0;
		$time = date( 'Y-m-d H:i:s', time() );
		$device->device_add_time = $time;
		$device->device_modify_time = $time;

		$result = $device->add(); // 根据条件保存修改的数据
		if ( $result ) {
			$this->ajaxReturn( 1, '保存成功！', 1 );
		} else {
			$this->ajaxReturn( 0, '保存失败！', 0 );
		}
	}

	// 系统管理->设备管理->管理设备
	public function device_management(){
		$device = M( 'device' )->where( array( 'jurisdiction_id' => session( 'jurisdiction_id' ) ) )->select();
		if ($device) {
			$device_json = json_encode( $device );

			$tmp_content = $this->fetch( './Public/html/Content/District/system/device_management.html' );
			$tmp_content = "<script> record_json = $device_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( "设备表查询失败！" );
		}
	}

	// 系统管理->系统信息设置->管理设备：详细信息页
	public function device_management_detail($record_id=""){
		$device = M( 'device' )->where( array( 'device_id' => $record_id ) )->find();
		$this->device = $device;
		switch ($device['ownership_type']) {
			case '4':
				$agency = M( 'agency' )->where( array( 'agency_id' => $device['ownership_id'] ) )->field('agency_id as id,agency_name as name,agency_phone as phone,agency_address as address,agency_postcode as postcode,agency_fax as fax,agency_email as email')->find();
				$this->unit = $agency;
				break;
			case '5':
				$production_unit = M( 'production_unit' )->where( array( 'production_unit_id' => $device['ownership_id'] ) )->field('production_unit_id as id,production_unit_name as name,production_unit_phone as phone,production_unit_address as address,production_unit_postcode as postcode,production_unit_fax as fax,production_unit_email as email')->find();
				$this->unit = $production_unit;
				break;
			case '6':
				$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => $device['ownership_id'] ) )->field('transport_unit_id as id,transport_unit_name as name,transport_unit_phone as phone,transport_unit_address as address,transport_unit_postcode as postcode,transport_unit_fax as fax,transport_unit_email as email')->find();
				$this->unit = $transport_unit;
				break;
			case '7':
				$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => $device['ownership_id'] ) )->field('reception_unit_id as id,reception_unit_name as name,reception_unit_phone as phone,reception_unit_address as address,reception_unit_postcode as postcode,reception_unit_fax as fax,reception_unit_email as email')->find();
				$this->unit = $reception_unit;
				break;
			default:
				break;
		}

		$tmp_content=$this->fetch( './Public/html/Content/District/system/device_management_detail.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->管理设备：修改信息页
	public function device_management_modify($record_id=""){
		$device = M( 'device' )->where( array( 'device_id' => $record_id ) )->find();
		$this->device = $device;

		$record_id_json = json_encode($record_id);
		$tmp_content=$this->fetch( './Public/html/Content/District/system/device_management_modify.html' );
		$tmp_content = "<script>record_id_json = $record_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->管理设备：修改提交
	public function device_management_modified($record_id=""){
		$device = M( 'device' ); // 实例化record对象
		$device->create(); // 根据表单提交的POST数据创建数据对象
		$device->device_id = $record_id;
		$time = date( 'Y-m-d H:i:s', time() );
		$device->device_modify_time = $time;

		$result = $device->save(); // 根据条件保存修改的数据

		if ( $result ) {
			$this->ajaxReturn( 1, '修改成功！', 1 );
		} else {
			$this->ajaxReturn( 0, '修改失败！', 0 );
		}
	}

}
?>