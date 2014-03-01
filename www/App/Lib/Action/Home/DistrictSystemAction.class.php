<?php
/**
 *
 */
class DistrictSystemAction extends DistrictCommonAction{
	// -------- 系统管理->侧边栏 --------
	public function system_sidebar(){
		layout( './Common/frame' );
		$this->display( './Public/html/Content/District/system/system_sidebar.html' );
	}

	// 系统管理->系统信息设置->废物代码
	public function waste_code(){
		$waste = M( 'waste' )->order( 'waste_id DESC' )->select();
		$waste_json = json_encode( $waste );

		$tmp_content=$this->fetch( './Public/html/Content/District/system/waste_code.html' );
		$tmp_content="<script> record_json=$waste_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物代码->删除记录
	public function record_delete($record_id=""){
		$waste = M("waste"); // 实例化waste对象
		$waste->where( array('waste_id' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ($waste) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->废物代码->修改记录
	public function record_modify($record_id=""){
		$waste_category = M( 'waste_category' )->select();
		$waste_category_json = json_encode($waste_category);

		$waste_form = M('waste_form')->select();

		$waste = M("waste")->where( array('waste_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$waste_id_json = json_encode($record_id);

		$this->waste = $waste;
		$this->waste_form = $waste_form;

		$tmp_content = $this->fetch( './Public/html/Content/District/system/waste_code_modify.html' );
		$tmp_content = "<script>waste_id_json = $waste_id_json;waste_category_json=$waste_category_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物代码->保存修改
	public function waste_code_modified($waste_id="") {
		$waste = M( 'waste' ); // 实例化record对象

		$data = I( 'post.' );

		$waste->where( array( 'waste_id' =>$waste_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->区县代码
	public function district_code(){
		$county_code = M( 'county_code' )->order( 'county_id ASC' )->select();
		$county_json = json_encode( $county_code );

		$tmp_content=$this->fetch( './Public/html/Content/District/system/district_code.html' );
		$tmp_content="<script> record_json=$county_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->区县代码->删除记录
	public function county_code_delete($record_id=""){
		$county_code = M("county_code"); // 实例化waste对象
		$county_code->where( array('county_id' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ($county_code) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->区县代码->修改记录
	public function county_code_modify($record_id=""){
		$county_code = M("county_code")->where( array('county_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$county_id_json = json_encode($record_id);

		$this->county_code = $county_code;

		$tmp_content = $this->fetch( './Public/html/Content/District/system/county_code_modify.html' );
		$tmp_content = "<script>county_id_json = $county_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->区县代码->保存修改
	public function county_code_modified($county_id="") {
		$county_code = M( 'county_code' ); // 实例化record对象

		$data = I( 'post.' );

		$county_code->where( array( 'county_id' =>$county_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->行业代码
	public function trade_code(){
		$trade_code = M( 'trade_code' )->order( 'trade_id ASC' )->select();
		$trade_code_json = json_encode( $trade_code );

		$tmp_content=$this->fetch( './Public/html/Content/District/system/trade_code.html' );
		$tmp_content="<script> record_json=$trade_code_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->区县代码->删除记录
	public function trade_code_delete($record_id=""){
		$trade_code = M("trade_code"); // 实例化waste对象
		$trade_code->where( array('trade_id' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ($trade_code) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->行业代码->修改记录
	public function trade_code_modify($record_id=""){
		$trade_code = M("trade_code")->where( array('trade_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$trade_id_json = json_encode($record_id);

		$this->trade_code = $trade_code;

		$tmp_content = $this->fetch( './Public/html/Content/District/system/trade_code_modify.html' );
		$tmp_content = "<script>trade_id_json = $trade_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->行业代码->保存修改
	public function trade_code_modified($trade_id="") {
		$trade_code = M( 'trade_code' ); // 实例化record对象

		$data = I( 'post.' );

		$trade_code->where( array( 'trade_id' =>$trade_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->企业规模
	public function enterprise_scale(){
		$enterprise_scale = M( 'enterprise_scale' )->order( 'enterprise_scale_id ASC' )->select();
		$enterprise_scale_json = json_encode( $enterprise_scale );

		$tmp_content=$this->fetch( './Public/html/Content/District/system/enterprise_scale.html' );
		$tmp_content="<script> record_json=$enterprise_scale_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->企业规模->删除记录
	public function enterprise_scale_delete($record_id=""){
		$enterprise_scale = M("enterprise_scale"); // 实例化waste对象
		$enterprise_scale->where( array('enterprise_scale_id' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ($enterprise_scale) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->企业规模->修改记录
	public function enterprise_scale_modify($record_id=""){
		$enterprise_scale = M("enterprise_scale")->where( array('enterprise_scale_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$enterprise_scale_id_json = json_encode($record_id);

		$this->enterprise_scale = $enterprise_scale;

		$tmp_content = $this->fetch( './Public/html/Content/District/system/enterprise_scale_modify.html' );
		$tmp_content = "<script>enterprise_scale_id_json = $enterprise_scale_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->企业规模->保存修改
	public function enterprise_scale_modified($enterprise_scale_id="") {
		$enterprise_scale = M( 'enterprise_scale' ); // 实例化record对象

		$data = I( 'post.' );

		$enterprise_scale->where( array( 'enterprise_scale_id' =>$enterprise_scale_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->注册类型
	public function register_type(){
		$enterprise_register_type = M( 'enterprise_register_type' )->order( 'enterprise_register_type_id ASC' )->select();
		$enterprise_register_type_json = json_encode( $enterprise_register_type );

		$tmp_content=$this->fetch( './Public/html/Content/District/system/register_type.html' );
		$tmp_content="<script> record_json=$enterprise_register_type_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->注册类型->删除记录
	public function enterprise_register_type_delete($record_id=""){
		$enterprise_register_type = M("enterprise_register_type"); // 实例化waste对象
		$enterprise_register_type->where( array('enterprise_register_type_id' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ($enterprise_register_type) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->注册类型->修改记录
	public function enterprise_register_type_modify($record_id=""){
		$enterprise_register_type = M("enterprise_register_type")->where( array('enterprise_register_type_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$enterprise_register_type_id_json = json_encode($record_id);
		$this->enterprise_register_type = $enterprise_register_type;

		$tmp_content = $this->fetch( './Public/html/Content/District/system/enterprise_register_type_modify.html' );
		$tmp_content = "<script>enterprise_register_type_id_json = $enterprise_register_type_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->注册类型->保存修改
	public function enterprise_register_type_modified($enterprise_register_type_id="") {
		$enterprise_register_type = M( 'enterprise_register_type' ); // 实例化record对象

		$data = I( 'post.' );

		$enterprise_register_type->where( array( 'enterprise_register_type_id' =>$enterprise_register_type_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->管辖权限
	public function jurisdiction(){
		$jurisdiction = M( 'jurisdiction' )->order( 'jurisdiction_id ASC' )->select();
		$jurisdiction_json = json_encode( $jurisdiction );

		$tmp_content=$this->fetch( './Public/html/Content/District/system/jurisdiction.html' );
		$tmp_content="<script> record_json=$jurisdiction_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->管辖权限->删除记录
	public function jurisdiction_delete($record_id=""){
		$jurisdiction = M("jurisdiction"); // 实例化waste对象
		$jurisdiction->where( array('jurisdiction_id' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ($jurisdiction) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->管辖权限->修改记录
	public function jurisdiction_modify($record_id=""){
		$jurisdiction = M("jurisdiction")->where( array('jurisdiction_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$jurisdiction_id_json = json_encode($record_id);
		$this->jurisdiction = $jurisdiction;

		$tmp_content = $this->fetch( './Public/html/Content/District/system/jurisdiction_modify.html' );
		$tmp_content = "<script>jurisdiction_id_json = $jurisdiction_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->管辖权限->保存修改
	public function jurisdiction_modified($jurisdiction_id="") {
		$jurisdiction = M( 'jurisdiction' ); // 实例化record对象

		$data = I( 'post.' );

		$jurisdiction->where( array( 'jurisdiction_id' =>$jurisdiction_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->废物类别
	public function waste_category(){
		$waste_category = M( 'waste_category' )->select();
		$waste_category_json = json_encode( $waste_category );

		$tmp_content=$this->fetch( './Public/html/Content/District/system/waste_category.html' );
		$tmp_content="<script>record_json=$waste_category_json</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物类别->删除记录
	public function waste_category_delete($record_id=""){
		$waste_category = M("waste_category"); // 实例化waste对象
		$waste_category->where( array('waste_category_id' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ($waste_category) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->废物类别->修改记录
	public function waste_category_modify($record_id=""){
		$waste_category = M("waste_category")->where( array('waste_category_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$waste_category_id_json = json_encode($record_id);
		$this->waste_category = $waste_category;

		$tmp_content = $this->fetch( './Public/html/Content/District/system/waste_category_modify.html' );
		$tmp_content = "<script>waste_category_id_json = $waste_category_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物类别->保存修改
	public function waste_category_modified($waste_category_id="") {
		$waste_category = M( "waste_category");

		$data = I( 'post.' );

		$waste_category->where( array( 'waste_category_id' =>$waste_category_id ) )->save( $data );
	}


	// 系统管理->系统信息设置->废物形态
	public function waste_form(){
		$waste_form = M( 'waste_form' )->select();
		$waste_form_json = json_encode($waste_form);

		$tmp_content=$this->fetch( './Public/html/Content/District/system/waste_form.html' );
		$tmp_content="<script>record_json=$waste_form_json</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物形态->删除记录
	public function waste_form_delete($record_id=""){
		$waste_form = M("waste_form"); // 实例化waste对象
		$waste_form->where( array('waste_form' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ($waste_form) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->废物形态->修改记录
	public function waste_form_modify($record_id=""){
		$waste_form = M("waste_form")->where( array('waste_form_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$waste_form_id_json = json_encode($record_id);
		$this->waste_form = $waste_form;

		$tmp_content = $this->fetch( './Public/html/Content/District/system/waste_form_modify.html' );
		$tmp_content = "<script>waste_form_id_json = $waste_form_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物形态->保存修改
	public function waste_form_modified($waste_form_id="") {
		$waste_form = M( "waste_form");

		$data = I( 'post.' );

		$waste_form->where( array( 'waste_form_id' =>$waste_form_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->包装方式
	public function package_method(){
		$package_method = M( 'package_method' )->select();
		$package_method_json = json_encode($package_method);

		$tmp_content=$this->fetch( './Public/html/Content/District/system/package_method.html' );
		$tmp_content="<script>record_json=$package_method_json</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->包装方式->删除记录
	public function package_method_delete($record_id=""){
		$package_method = M("package_method"); // 实例化waste对象
		$package_method->where( array('package_method' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ($package_method) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->包装方式->修改记录
	public function package_method_modify($record_id=""){
		$package_method = M("package_method")->where( array('package_method_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$package_method_id_json = json_encode($record_id);
		$this->package_method = $package_method;

		$tmp_content = $this->fetch( './Public/html/Content/District/system/package_method_modify.html' );
		$tmp_content = "<script>package_method_id_json = $package_method_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->包装方式->保存修改
	public function package_method_modified($package_method_id="") {
		$package_method = M( "package_method");

		$data = I( 'post.' );

		$package_method->where( array( 'package_method_id' =>$package_method_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->废物处理方式
	public function waste_disposal_method(){
		$waste_disposal_method = M( 'waste_disposal_method' )->select();
		$waste_disposal_method_json = json_encode($waste_disposal_method);

		$tmp_content=$this->fetch( './Public/html/Content/District/system/waste_disposal_method.html' );
		$tmp_content="<script>record_json=$waste_disposal_method_json</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物处理方式->删除记录
	public function waste_disposal_method_delete($record_id=""){
		$waste_disposal_method = M("waste_disposal_method"); // 实例化waste对象
		$waste_disposal_method->where( array('waste_disposal_method' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ($waste_disposal_method) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->废物处理方式->修改记录
	public function waste_disposal_method_modify($record_id=""){
		$waste_disposal_method = M("waste_disposal_method")->where( array('waste_disposal_method_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$waste_disposal_method_id_json = json_encode($record_id);
		$this->waste_disposal_method = $waste_disposal_method;

		$tmp_content = $this->fetch( './Public/html/Content/District/system/waste_disposal_method_modify.html' );
		$tmp_content = "<script>waste_disposal_method_id_json = $waste_disposal_method_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物处理方式->保存修改
	public function waste_disposal_method_modified($waste_disposal_method_id="") {
		$waste_disposal_method = M( "waste_disposal_method");

		$data = I( 'post.' );

		$waste_disposal_method->where( array( 'waste_disposal_method_id' =>$waste_disposal_method_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->废物去向
	public function waste_direction(){
		$waste_direction = M( 'waste_direction' )->select();
		$waste_direction_json = json_encode($waste_direction);

		$tmp_content=$this->fetch( './Public/html/Content/District/system/waste_direction.html' );
		$tmp_content="<script>record_json=$waste_direction_json</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物去向->删除记录
	public function waste_direction_delete($record_id=""){
		$waste_direction = M("waste_direction"); // 实例化waste对象
		$waste_direction->where( array('waste_direction' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ($waste_direction) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->废物去向->修改记录
	public function waste_direction_modify($record_id=""){
		$waste_direction = M("waste_direction")->where( array('waste_direction_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$waste_direction_id_json = json_encode($record_id);
		$this->waste_direction = $waste_direction;

		$tmp_content = $this->fetch( './Public/html/Content/District/system/waste_direction_modify.html' );
		$tmp_content = "<script>waste_direction_id_json = $waste_direction_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物去向->保存修改
	public function waste_direction_modified($waste_direction_id="") {
		$waste_direction = M( "waste_direction");

		$data = I( 'post.' );

		$waste_direction->where( array( 'waste_direction_id' =>$waste_direction_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->运输方式
	public function transport_method(){
		$transport_method = M( 'transport_method' )->select();
		$transport_method_json = json_encode($transport_method);

		$tmp_content=$this->fetch( './Public/html/Content/District/system/transport_method.html' );
		$tmp_content="<script>record_json=$transport_method_json</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->运输方式->删除记录
	public function transport_method_delete($record_id=""){
		$transport_method = M("transport_method"); // 实例化waste对象
		$transport_method->where( array('transport_method' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ($transport_method) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->运输方式->修改记录
	public function transport_method_modify($record_id=""){
		$transport_method = M("transport_method")->where( array('transport_method_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$transport_method_id_json = json_encode($record_id);
		$this->transport_method = $transport_method;

		$tmp_content = $this->fetch( './Public/html/Content/District/system/transport_method_modify.html' );
		$tmp_content = "<script>transport_method_id_json = $transport_method_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->运输方式->保存修改
	public function transport_method_modified($transport_method_id="") {
		$transport_method = M( "transport_method");

		$data = I( 'post.' );

		$transport_method->where( array( 'transport_method_id' =>$transport_method_id ) )->save( $data );
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