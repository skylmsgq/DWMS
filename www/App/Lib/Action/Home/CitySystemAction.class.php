<?php
/**
 *
 */
class CitySystemAction extends CityCommonAction{
	// -------- 系统管理->侧边栏 --------
	public function system_sidebar() {
		layout( './Common/frame' );
		$this->display( './Public/html/Content/City/system/system_sidebar.html' );
	}

	// 系统管理->系统信息设置->废物代码
	public function waste_code() {
		$waste = M( 'waste' )->order( 'waste_id DESC' )->select();
		$waste_json = json_encode( $waste );

		$tmp_content=$this->fetch( './Public/html/Content/City/system/waste_code.html' );
		$tmp_content="<script> record_json=$waste_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物代码->删除记录
	public function record_delete( $record_id="" ) {
		$waste = M( "waste" ); // 实例化waste对象
		$waste->where( array( 'waste_id' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ( $waste ) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->废物代码->修改记录
	public function record_modify( $record_id="" ) {
		$waste_category = M( 'waste_category' )->select();
		$waste_category_json = json_encode( $waste_category );

		$waste_form = M( 'waste_form' )->select();

		$waste = M( "waste" )->where( array( 'waste_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$waste_id_json = json_encode( $record_id );

		$this->waste = $waste;
		$this->waste_form = $waste_form;

		$tmp_content = $this->fetch( './Public/html/Content/City/system/waste_code_modify.html' );
		$tmp_content = "<script>waste_id_json = $waste_id_json;waste_category_json=$waste_category_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物代码->保存修改
	public function waste_code_modified( $waste_id="" ) {
		$waste = M( 'waste' ); // 实例化record对象

		$data = I( 'post.' );

		$waste->where( array( 'waste_id' =>$waste_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->区县代码
	public function district_code() {
		$county_code = M( 'county_code' )->order( 'county_id ASC' )->select();
		$county_json = json_encode( $county_code );

		$tmp_content=$this->fetch( './Public/html/Content/City/system/district_code.html' );
		$tmp_content="<script> record_json=$county_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->区县代码->删除记录
	public function county_code_delete( $record_id="" ) {
		$county_code = M( "county_code" ); // 实例化waste对象
		$county_code->where( array( 'county_id' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ( $county_code ) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->区县代码->修改记录
	public function county_code_modify( $record_id="" ) {
		$county_code = M( "county_code" )->where( array( 'county_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$county_id_json = json_encode( $record_id );

		$this->county_code = $county_code;

		$tmp_content = $this->fetch( './Public/html/Content/City/system/county_code_modify.html' );
		$tmp_content = "<script>county_id_json = $county_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->区县代码->保存修改
	public function county_code_modified( $county_id="" ) {
		$county_code = M( 'county_code' ); // 实例化record对象

		$data = I( 'post.' );

		$county_code->where( array( 'county_id' =>$county_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->行业代码
	public function trade_code() {
		$trade_code = M( 'trade_code' )->order( 'trade_id ASC' )->select();
		$trade_code_json = json_encode( $trade_code );

		$tmp_content=$this->fetch( './Public/html/Content/City/system/trade_code.html' );
		$tmp_content="<script> record_json=$trade_code_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->区县代码->删除记录
	public function trade_code_delete( $record_id="" ) {
		$trade_code = M( "trade_code" ); // 实例化waste对象
		$trade_code->where( array( 'trade_id' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ( $trade_code ) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->行业代码->修改记录
	public function trade_code_modify( $record_id="" ) {
		$trade_code = M( "trade_code" )->where( array( 'trade_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$trade_id_json = json_encode( $record_id );

		$this->trade_code = $trade_code;

		$tmp_content = $this->fetch( './Public/html/Content/City/system/trade_code_modify.html' );
		$tmp_content = "<script>trade_id_json = $trade_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->行业代码->保存修改
	public function trade_code_modified( $trade_id="" ) {
		$trade_code = M( 'trade_code' ); // 实例化record对象

		$data = I( 'post.' );

		$trade_code->where( array( 'trade_id' =>$trade_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->企业规模
	public function enterprise_scale() {
		$enterprise_scale = M( 'enterprise_scale' )->order( 'enterprise_scale_id ASC' )->select();
		$enterprise_scale_json = json_encode( $enterprise_scale );

		$tmp_content=$this->fetch( './Public/html/Content/City/system/enterprise_scale.html' );
		$tmp_content="<script> record_json=$enterprise_scale_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->企业规模->删除记录
	public function enterprise_scale_delete( $record_id="" ) {
		$enterprise_scale = M( "enterprise_scale" ); // 实例化waste对象
		$enterprise_scale->where( array( 'enterprise_scale_id' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ( $enterprise_scale ) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->企业规模->修改记录
	public function enterprise_scale_modify( $record_id="" ) {
		$enterprise_scale = M( "enterprise_scale" )->where( array( 'enterprise_scale_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$enterprise_scale_id_json = json_encode( $record_id );

		$this->enterprise_scale = $enterprise_scale;

		$tmp_content = $this->fetch( './Public/html/Content/City/system/enterprise_scale_modify.html' );
		$tmp_content = "<script>enterprise_scale_id_json = $enterprise_scale_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->企业规模->保存修改
	public function enterprise_scale_modified( $enterprise_scale_id="" ) {
		$enterprise_scale = M( 'enterprise_scale' ); // 实例化record对象

		$data = I( 'post.' );

		$enterprise_scale->where( array( 'enterprise_scale_id' =>$enterprise_scale_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->注册类型
	public function register_type() {
		$enterprise_register_type = M( 'enterprise_register_type' )->order( 'enterprise_register_type_id ASC' )->select();
		$enterprise_register_type_json = json_encode( $enterprise_register_type );

		$tmp_content=$this->fetch( './Public/html/Content/City/system/register_type.html' );
		$tmp_content="<script> record_json=$enterprise_register_type_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->注册类型->删除记录
	public function enterprise_register_type_delete( $record_id="" ) {
		$enterprise_register_type = M( "enterprise_register_type" ); // 实例化waste对象
		$enterprise_register_type->where( array( 'enterprise_register_type_id' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ( $enterprise_register_type ) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->注册类型->修改记录
	public function enterprise_register_type_modify( $record_id="" ) {
		$enterprise_register_type = M( "enterprise_register_type" )->where( array( 'enterprise_register_type_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$enterprise_register_type_id_json = json_encode( $record_id );
		$this->enterprise_register_type = $enterprise_register_type;

		$tmp_content = $this->fetch( './Public/html/Content/City/system/enterprise_register_type_modify.html' );
		$tmp_content = "<script>enterprise_register_type_id_json = $enterprise_register_type_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->注册类型->保存修改
	public function enterprise_register_type_modified( $enterprise_register_type_id="" ) {
		$enterprise_register_type = M( 'enterprise_register_type' ); // 实例化record对象

		$data = I( 'post.' );

		$enterprise_register_type->where( array( 'enterprise_register_type_id' =>$enterprise_register_type_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->管辖权限
	public function jurisdiction() {
		$jurisdiction = M( 'jurisdiction' )->order( 'jurisdiction_id ASC' )->select();
		$jurisdiction_json = json_encode( $jurisdiction );

		$tmp_content=$this->fetch( './Public/html/Content/City/system/jurisdiction.html' );
		$tmp_content="<script> record_json=$jurisdiction_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->管辖权限->删除记录
	public function jurisdiction_delete( $record_id="" ) {
		$jurisdiction = M( "jurisdiction" ); // 实例化waste对象
		$jurisdiction->where( array( 'jurisdiction_id' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ( $jurisdiction ) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->管辖权限->修改记录
	public function jurisdiction_modify( $record_id="" ) {
		$jurisdiction = M( "jurisdiction" )->where( array( 'jurisdiction_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$jurisdiction_id_json = json_encode( $record_id );
		$this->jurisdiction = $jurisdiction;

		$tmp_content = $this->fetch( './Public/html/Content/City/system/jurisdiction_modify.html' );
		$tmp_content = "<script>jurisdiction_id_json = $jurisdiction_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->管辖权限->保存修改
	public function jurisdiction_modified( $jurisdiction_id="" ) {
		$jurisdiction = M( 'jurisdiction' ); // 实例化record对象

		$data = I( 'post.' );

		$jurisdiction->where( array( 'jurisdiction_id' =>$jurisdiction_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->废物类别
	public function waste_category() {
		$waste_category = M( 'waste_category' )->select();
		$waste_category_json = json_encode( $waste_category );

		$tmp_content=$this->fetch( './Public/html/Content/City/system/waste_category.html' );
		$tmp_content="<script>record_json=$waste_category_json</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物类别->删除记录
	public function waste_category_delete( $record_id="" ) {
		$waste_category = M( "waste_category" ); // 实例化waste对象
		$waste_category->where( array( 'waste_category_id' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ( $waste_category ) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->废物类别->修改记录
	public function waste_category_modify( $record_id="" ) {
		$waste_category = M( "waste_category" )->where( array( 'waste_category_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$waste_category_id_json = json_encode( $record_id );
		$this->waste_category = $waste_category;

		$tmp_content = $this->fetch( './Public/html/Content/City/system/waste_category_modify.html' );
		$tmp_content = "<script>waste_category_id_json = $waste_category_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物类别->保存修改
	public function waste_category_modified( $waste_category_id="" ) {
		$waste_category = M( "waste_category" );

		$data = I( 'post.' );

		$waste_category->where( array( 'waste_category_id' =>$waste_category_id ) )->save( $data );
	}


	// 系统管理->系统信息设置->废物形态
	public function waste_form() {
		$waste_form = M( 'waste_form' )->select();
		$waste_form_json = json_encode( $waste_form );

		$tmp_content=$this->fetch( './Public/html/Content/City/system/waste_form.html' );
		$tmp_content="<script>record_json=$waste_form_json</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物形态->删除记录
	public function waste_form_delete( $record_id="" ) {
		$waste_form = M( "waste_form" ); // 实例化waste对象
		$waste_form->where( array( 'waste_form' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ( $waste_form ) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->废物形态->修改记录
	public function waste_form_modify( $record_id="" ) {
		$waste_form = M( "waste_form" )->where( array( 'waste_form_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$waste_form_id_json = json_encode( $record_id );
		$this->waste_form = $waste_form;

		$tmp_content = $this->fetch( './Public/html/Content/City/system/waste_form_modify.html' );
		$tmp_content = "<script>waste_form_id_json = $waste_form_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物形态->保存修改
	public function waste_form_modified( $waste_form_id="" ) {
		$waste_form = M( "waste_form" );

		$data = I( 'post.' );

		$waste_form->where( array( 'waste_form_id' =>$waste_form_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->包装方式
	public function package_method() {
		$package_method = M( 'package_method' )->select();
		$package_method_json = json_encode( $package_method );

		$tmp_content=$this->fetch( './Public/html/Content/City/system/package_method.html' );
		$tmp_content="<script>record_json=$package_method_json</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->包装方式->删除记录
	public function package_method_delete( $record_id="" ) {
		$package_method = M( "package_method" ); // 实例化waste对象
		$package_method->where( array( 'package_method' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ( $package_method ) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->包装方式->修改记录
	public function package_method_modify( $record_id="" ) {
		$package_method = M( "package_method" )->where( array( 'package_method_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$package_method_id_json = json_encode( $record_id );
		$this->package_method = $package_method;

		$tmp_content = $this->fetch( './Public/html/Content/City/system/package_method_modify.html' );
		$tmp_content = "<script>package_method_id_json = $package_method_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->包装方式->保存修改
	public function package_method_modified( $package_method_id="" ) {
		$package_method = M( "package_method" );

		$data = I( 'post.' );

		$package_method->where( array( 'package_method_id' =>$package_method_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->废物处理方式
	public function waste_disposal_method() {
		$waste_disposal_method = M( 'waste_disposal_method' )->select();
		$waste_disposal_method_json = json_encode( $waste_disposal_method );

		$tmp_content=$this->fetch( './Public/html/Content/City/system/waste_disposal_method.html' );
		$tmp_content="<script>record_json=$waste_disposal_method_json</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物处理方式->删除记录
	public function waste_disposal_method_delete( $record_id="" ) {
		$waste_disposal_method = M( "waste_disposal_method" ); // 实例化waste对象
		$waste_disposal_method->where( array( 'waste_disposal_method' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ( $waste_disposal_method ) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->废物处理方式->修改记录
	public function waste_disposal_method_modify( $record_id="" ) {
		$waste_disposal_method = M( "waste_disposal_method" )->where( array( 'waste_disposal_method_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$waste_disposal_method_id_json = json_encode( $record_id );
		$this->waste_disposal_method = $waste_disposal_method;

		$tmp_content = $this->fetch( './Public/html/Content/City/system/waste_disposal_method_modify.html' );
		$tmp_content = "<script>waste_disposal_method_id_json = $waste_disposal_method_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物处理方式->保存修改
	public function waste_disposal_method_modified( $waste_disposal_method_id="" ) {
		$waste_disposal_method = M( "waste_disposal_method" );

		$data = I( 'post.' );

		$waste_disposal_method->where( array( 'waste_disposal_method_id' =>$waste_disposal_method_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->废物去向
	public function waste_direction() {
		$waste_direction = M( 'waste_direction' )->select();
		$waste_direction_json = json_encode( $waste_direction );

		$tmp_content=$this->fetch( './Public/html/Content/City/system/waste_direction.html' );
		$tmp_content="<script>record_json=$waste_direction_json</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物去向->删除记录
	public function waste_direction_delete( $record_id="" ) {
		$waste_direction = M( "waste_direction" ); // 实例化waste对象
		$waste_direction->where( array( 'waste_direction' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ( $waste_direction ) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->废物去向->修改记录
	public function waste_direction_modify( $record_id="" ) {
		$waste_direction = M( "waste_direction" )->where( array( 'waste_direction_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$waste_direction_id_json = json_encode( $record_id );
		$this->waste_direction = $waste_direction;

		$tmp_content = $this->fetch( './Public/html/Content/City/system/waste_direction_modify.html' );
		$tmp_content = "<script>waste_direction_id_json = $waste_direction_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->废物去向->保存修改
	public function waste_direction_modified( $waste_direction_id="" ) {
		$waste_direction = M( "waste_direction" );

		$data = I( 'post.' );

		$waste_direction->where( array( 'waste_direction_id' =>$waste_direction_id ) )->save( $data );
	}

	// 系统管理->系统信息设置->运输方式
	public function transport_method() {
		$transport_method = M( 'transport_method' )->select();
		$transport_method_json = json_encode( $transport_method );

		$tmp_content=$this->fetch( './Public/html/Content/City/system/transport_method.html' );
		$tmp_content="<script>record_json=$transport_method_json</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->运输方式->删除记录
	public function transport_method_delete( $record_id="" ) {
		$transport_method = M( "transport_method" ); // 实例化waste对象
		$transport_method->where( array( 'transport_method' => $record_id ) )->delete(); // 删除waste_id=id的用户数据

		if ( $transport_method ) {
			$this->ajaxReturn( "删除成功" );
		} else {
			$this->ajaxReturn( "代码未找到" );
		}
	}

	// 系统管理->系统信息设置->运输方式->修改记录
	public function transport_method_modify( $record_id="" ) {
		$transport_method = M( "transport_method" )->where( array( 'transport_method_id' => $record_id ) )->find(); // 删除waste_id=id的用户数据
		$transport_method_id_json = json_encode( $record_id );
		$this->transport_method = $transport_method;

		$tmp_content = $this->fetch( './Public/html/Content/City/system/transport_method_modify.html' );
		$tmp_content = "<script>transport_method_id_json = $transport_method_id_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->运输方式->保存修改
	public function transport_method_modified( $transport_method_id="" ) {
		$transport_method = M( "transport_method" );
		$data = I( 'post.' );
		$transport_method->where( array( 'transport_method_id' =>$transport_method_id ) )->save( $data );
	}

	// 系统管理->设备管理->添加设备
	// public function device_add() {
	// 	$agency = M( 'agency' )->where( array( 'user_id' => session( 'user_id' ) ) )->field( 'agency_id, agency_name' )->select();
	// 	$condition['jurisdiction_id'] = array( 'EQ', session( 'jurisdiction_id' ) );
	// 	$production_unit = M( 'production_unit' )->where( $condition )->field( 'production_unit_id, production_unit_name' )->select();
	// 	$transport_unit = M( 'transport_unit' )->where( $condition )->field( 'transport_unit_id, transport_unit_name' )->select();
	// 	$reception_unit = M( 'reception_unit' )->where( $condition )->field( 'reception_unit_id, reception_unit_name' )->select();
	// 	if ( $agency && $production_unit && $transport_unit && $reception_unit ) {
	// 		$agency_json = json_encode( $agency );
	// 		$production_unit_json = json_encode( $production_unit );
	// 		$transport_unit_json = json_encode( $transport_unit );
	// 		$reception_unit_json = json_encode( $reception_unit );
	// 		$tmp_content=$this->fetch( './Public/html/Content/City/system/device_add.html' );
	// 		$tmp_content = "<script> agency_json=$agency_json; production_unit_json=$production_unit_json; transport_unit_json=$transport_unit_json; reception_unit_json=$reception_unit_json; </script> $tmp_content";
	// 		$this->ajaxReturn( $tmp_content );
	// 	} else {
	// 		$this->ajaxReturn( "加载页面失败，请重新点击侧边栏加载页面。" );
	// 	}
	// }

	// 系统管理->设备管理->添加设备：接收添加设备信息
	// public function device_add_form() {
	// 	$device = M( 'device' );
	// 	$device_serial_num = I( 'post.device_serial_num' );
	// 	$result = $device->where( array( 'device_serial_num' => $device_serial_num ) )->find();
	// 	if ( $result ) {
	// 		$this->ajaxReturn( 'exist' );
	// 	}
	// 	$device_type_id = I( 'post.device_type_id' );
	// 	switch ( $device_type_id ) {
	// 	case '0':
	// 		$device_name = '全球定位仪';
	// 		$device_type = 'GPS';
	// 		$device_status = 0;

	// 		$gps_table_name = 'gps_' . $device_serial_num;
	// 		$create_table = 'CREATE TABLE `' . $gps_table_name . '` (
	// 			`id` int(11) NOT NULL AUTO_INCREMENT,
	// 			`datetime` datetime DEFAULT NULL,
	// 			`longitude` double DEFAULT NULL,
	// 			`latitude` double DEFAULT NULL,
	// 			`bmap_longitude` double DEFAULT NULL,
	// 			`bmap_latitude` double DEFAULT NULL,
	// 			`height` double DEFAULT NULL,
	// 			`speed` double DEFAULT NULL,
	// 			`status` tinyint(4) DEFAULT NULL,
	// 			`vehicle_id` int(11) DEFAULT NULL,
	// 			`offset_distance` double DEFAULT NULL,
	// 			`stay_status` int(11) DEFAULT NULL,
	// 			PRIMARY KEY (`id`),
	// 			KEY `fk_vehicle_id_' . $gps_table_name .'` (`vehicle_id`),
	// 			CONSTRAINT `fk_vehicle_id_' . $gps_table_name . '` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`)
	// 			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;';
	// 		$model = new Model();
	// 		$model->execute($create_table);

	// 		break;
	// 	case '1':
	// 		$device_name = '手持读写器';
	// 		$device_type = 'Android';
	// 		$device_status = 1;
	// 		break;
	// 	default:
	// 		$this->ajaxReturn( 'fail' );
	// 		break;
	// 	}
	// 	$data['device_name'] = $device_name;
	// 	$data['device_type_id'] = $device_type_id;
	// 	$data['device_type'] = $device_type;
	// 	$data['device_serial_num'] = $device_serial_num;
	// 	$data['jurisdiction_id'] = session( 'jurisdiction_id' );
	// 	$data['ownership_type'] = I( 'post.ownership_type' );
	// 	$data['ownership_id'] = I( 'post.ownership_id' );
	// 	$data['device_status'] = $device_status;
	// 	$time = date( 'Y-m-d H:i:s', time() );
	// 	$data['device_add_time'] = $time;
	// 	$data['device_modify_time'] = $time;
	// 	$result = $device->add( $data );
	// 	if ( $result ) {
	// 		$this->ajaxReturn( 'success' );
	// 	} else {
	// 		$this->ajaxReturn( 'fail' );
	// 	}
	// }

	// 系统管理->设备管理->管理设备
	public function device_management() {
		$condition['jurisdiction_id'] = array( 'GT', 1 );
		$condition['device_status'] = array( 'LT', 3 );
		$device = M( 'device' )->where( $condition )->select();
		if ( $device ) {
			$device_json = json_encode( $device );
			$tmp_content = $this->fetch( './Public/html/Content/City/system/device_management.html' );
			$tmp_content = "<script> device_json = $device_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( "设备表查询失败！" );
		}
	}

	// 系统管理->系统信息设置->管理设备：详细信息页
	public function device_management_detail( $record_id="" ) {
		$device = M( 'device' )->where( array( 'device_id' => $record_id ) )->find();
		$this->device = $device;
		$jurisdiction = M( 'jurisdiction' )->where( array( 'jurisdiction_id' => $device['jurisdiction_id'] ) )->find();
		$this->jurisdiction = $jurisdiction;
		switch ( $device['ownership_type'] ) {
		case '4':
			$agency = M( 'agency' )->where( array( 'agency_id' => $device['ownership_id'] ) )->field( 'agency_id as id, agency_name as name, agency_phone as phone, agency_address as address, agency_postcode as postcode, agency_fax as fax, agency_email as email' )->find();
			$this->unit = $agency;
			$this->jurisdiction_type = '环保局';
			break;
		case '5':
			$production_unit = M( 'production_unit' )->where( array( 'production_unit_id' => $device['ownership_id'] ) )->field( 'production_unit_id as id, production_unit_name as name, production_unit_phone as phone, production_unit_address as address, production_unit_postcode as postcode, production_unit_fax as fax, production_unit_email as email' )->find();
			$this->unit = $production_unit;
			$this->jurisdiction_type = '生产单位';
			break;
		case '6':
			$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => $device['ownership_id'] ) )->field( 'transport_unit_id as id, transport_unit_name as name, transport_unit_phone as phone, transport_unit_address as address, transport_unit_postcode as postcode, transport_unit_fax as fax, transport_unit_email as email' )->find();
			$this->unit = $transport_unit;
			$this->jurisdiction_type = '运输单位';
			break;
		case '7':
			$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => $device['ownership_id'] ) )->field( 'reception_unit_id as id, reception_unit_name as name, reception_unit_phone as phone, reception_unit_address as address, reception_unit_postcode as postcode, reception_unit_fax as fax, reception_unit_email as email' )->find();
			$this->unit = $reception_unit;
			$this->jurisdiction_type = '接受单位';
			break;
		default:
			break;
		}
		$tmp_content=$this->fetch( './Public/html/Content/City/system/device_management_detail.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 系统管理->系统信息设置->管理设备：修改信息页
	public function device_management_modify( $record_id="" ) {
		$record_id_json = json_encode( $record_id );
		$device = M( 'device' )->where( array( 'device_id' => $record_id ) )->find();
		$this->device = $device;
		$agency = M( 'agency' )->where( array( 'user_id' => session( 'user_id' ) ) )->field( 'agency_id, agency_name' )->select();
		$condition['jurisdiction_id'] = array( 'GT', 1 );
		$production_unit = M( 'production_unit' )->where( $condition )->field( 'production_unit_id, production_unit_name' )->select();
		$transport_unit = M( 'transport_unit' )->where( $condition )->field( 'transport_unit_id, transport_unit_name' )->select();
		$reception_unit = M( 'reception_unit' )->where( $condition )->field( 'reception_unit_id, reception_unit_name' )->select();
		if ( $device && $agency && $production_unit && $transport_unit && $reception_unit ) {
			$device_json = json_encode( $device );
			$agency_json = json_encode( $agency );
			$production_unit_json = json_encode( $production_unit );
			$transport_unit_json = json_encode( $transport_unit );
			$reception_unit_json = json_encode( $reception_unit );
			$tmp_content=$this->fetch( './Public/html/Content/City/system/device_management_modify.html' );
			$tmp_content = "<script> record_id_json=$record_id_json; device_json=$device_json; agency_json=$agency_json; production_unit_json=$production_unit_json; transport_unit_json=$transport_unit_json; reception_unit_json=$reception_unit_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

	// 系统管理->系统信息设置->管理设备：修改系列号提交
	public function device_management_modified_serial_num( $record_id="" ) {
		$device_serial_num = I( 'post.device_serial_num' );
		$device = M( 'device' );
		$result = $device->where( array( 'device_serial_num' => $device_serial_num ) )->find();
		if ( $result ) {
			$this->ajaxReturn( 'exist' );
		}

		$device_old = M( 'device' )->where( array( 'device_id' => $record_id ) )->find();
		if ($device_old['device_type_id'] == '0') {
			$gps_table_name_old = 'gps_' . $device_old['device_serial_num'];
			$drop_table = 'DROP TABLE IF EXISTS `' . $gps_table_name_old . '`;';
			$model = new Model();
			$model->execute($drop_table);

			$gps_table_name = 'gps_' . $device_serial_num;
			$create_table = 'CREATE TABLE `' . $gps_table_name . '` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`datetime` datetime DEFAULT NULL,
				`longitude` double DEFAULT NULL,
				`latitude` double DEFAULT NULL,
				`bmap_longitude` double DEFAULT NULL,
				`bmap_latitude` double DEFAULT NULL,
				`height` double DEFAULT NULL,
				`speed` double DEFAULT NULL,
				`status` tinyint(4) DEFAULT NULL,
				`vehicle_id` int(11) DEFAULT NULL,
				`offset_distance` double DEFAULT NULL,
				`stay_status` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`),
				KEY `fk_vehicle_id_' . $gps_table_name .'` (`vehicle_id`),
				CONSTRAINT `fk_vehicle_id_' . $gps_table_name . '` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;';
			$model->execute($create_table);
		}

		$data['device_id'] = $record_id;
		$data['device_serial_num'] = $device_serial_num;
		$data['ownership_type'] = I( 'post.ownership_type' );
		$data['ownership_id'] = I( 'post.ownership_id' );
		$time = date( 'Y-m-d H:i:s', time() );
		$data['device_modify_time'] = $time;
		$result = $device->save( $data );
		if ( $result ) {
			$this->ajaxReturn( 'success' );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

	// 系统管理->系统信息设置->管理设备：修改归属提交
	public function device_management_modified_ownership( $record_id="" ) {
		$device = M( 'device' );
		$data['device_id'] = $record_id;
		$data['ownership_type'] = I( 'post.ownership_type' );
		$data['ownership_id'] = I( 'post.ownership_id' );
		$time = date( 'Y-m-d H:i:s', time() );
		$data['device_modify_time'] = $time;
		$result = $device->save( $data );
		if ( $result ) {
			$this->ajaxReturn( 'success' );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

	// 系统管理->文档管理->上传法规政策
	public function upload_law(){
		$condition['document_type'] = 0;
		$condition['document_status'] = 0;
		$condition['jurisdiction_id'] = array('GT',1);
		$document = M( 'document' )->where( $condition )->select();
		// if ( $document ) {
			$document_json = json_encode( $document );
			$tmp_content=$this->fetch( './Public/html/Content/City/system/upload_law.html' );
			$tmp_content = "<script> document_json=$document_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		//} else {
			$this->ajaxReturn( '加载页面失败，请重新点击侧边栏加载页面。' );
		//}
	}

	// 系统管理->文档管理->上传法规政策：接收上传的法规政策
	public function upload_law_form(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile(); // 实例化上传类
    	$upload->maxSize = 10 * 1024 * 1024; // 设置附件上传大小，10M
    	$upload->savePath =  './Uploads/'; // 设置附件上传目录
    	// $upload->saveRule = 'time'; // 采用时间戳命名
    	$upload->saveRule = 'time'; // 设置命名规范为空，保持上传的文件名不变，相同的文件名上传后被覆盖
    	$upload->allowExts  = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'); // 允许上传的文件后缀（留空为不限制）
    	// $upload->allowTypes = array('doc', 'pdf', 'jpg'); // 允许上传的文件类型（留空为不限制）
    	$upload->uploadReplace = true;

    	if( $upload->upload() ) { // 上传成功
        	$info = $upload->getUploadFileInfo(); // 取得成功上传的文件信息
        	$document = M( 'document' );
        	for ( $idx = 0; $idx < count( $info ); ++$idx ) {
				$data['form_name'] = $info[$idx]['key'];
        		$data['document_save_path'] = $info[$idx]['savepath'];
        		$data['document_original_name'] = $info[$idx]['name'];
        		$data['document_save_name'] = $info[$idx]['savename'];
        		$data['document_size'] = $info[$idx]['size'];
        		$data['document_mime_type'] = $info[$idx]['type'];
        		$data['document_suffix_type'] = $info[$idx]['extension'];
        		$data['document_hash_string'] = $info[$idx]['hash'];
        		$time = date( 'Y-m-d H:i:s', time() );
        		$data['document_upload_time'] = $time;
        		$data['document_type'] = 0;
        		$data['document_status'] = 0;
        		$data['jurisdiction_id'] = session( 'jurisdiction_id' );
        		$document->add( $data );
        	}
        	// $data = htmlspecialchars_decode( $data );
        	$this->ajaxReturn( $data, 'success', 1 );
    	}else{ // 上传错误提示错误信息
        	$this->ajaxReturn( $upload->getErrorMsg(), 'fail', 0 );
    	}
	}

	// 系统管理->文档管理->上传法规政策：删除法规政策确认页
	public function upload_law_delete($record_id=""){
		$document = M( 'document' )->where( array( 'document_id' => $record_id ) )->find();

		if ( $document ) {
			$this->document = $document;
			$document_json = json_encode( $document );
			$tmp_content=$this->fetch( './Public/html/Content/City/system/upload_law_delete.html' );
			$tmp_content = "<script> document_json=$document_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( '删除该文档失败，请重新操作。' );
		}
	}

	// 系统管理->文档管理->上传法规政策：删除法规政策
	public function upload_law_deleted($record_id="") {
		// $condition['document_id'] = array( 'EQ', I( 'post.document_id' ) );
		$data['document_id'] = $record_id;
		$time = date( 'Y-m-d H:i:s', time() );
		$data['document_delete_time'] = $time;
		$data['document_status'] = 1;
		$result = M( 'document' )->save( $data );
		if ( $result ) {
			$this->ajaxReturn( 'success' );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

	// 系统管理->文档管理->上传用户手册
	public function upload_manual(){
		$condition['document_type'] = 1;
		$condition['document_status'] = 0;
		$condition['jurisdiction_id'] = array('GT',1);
		$document = M( 'document' )->where( $condition )->select();
		// if ( $document ) {
			$document_json = json_encode( $document );
			$tmp_content=$this->fetch( './Public/html/Content/City/system/upload_manual.html' );
			$tmp_content = "<script> document_json=$document_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		//} else {
			$this->ajaxReturn( '加载页面失败，请重新点击侧边栏加载页面。' );
		//}
	}

	// 系统管理->文档管理->上传用户手册：接收上传的用户手册
	public function upload_manual_form(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile(); // 实例化上传类
    	$upload->maxSize = 10 * 1024 * 1024; // 设置附件上传大小，10M
    	$upload->savePath =  './Uploads/'; // 设置附件上传目录
    	// $upload->saveRule = 'time'; // 采用时间戳命名
    	$upload->saveRule = 'time'; // 设置命名规范为空，保持上传的文件名不变，相同的文件名上传后被覆盖
    	$upload->allowExts  = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'); // 允许上传的文件后缀（留空为不限制）
    	// $upload->allowTypes = array('doc', 'pdf', 'jpg'); // 允许上传的文件类型（留空为不限制）
    	$upload->uploadReplace = true;

    	if( $upload->upload() ) { // 上传成功
        	$info = $upload->getUploadFileInfo(); // 取得成功上传的文件信息
        	$document = M( 'document' );
        	for ( $idx = 0; $idx < count( $info ); ++$idx ) {
				$data['form_name'] = $info[$idx]['key'];
        		$data['document_save_path'] = $info[$idx]['savepath'];
        		$data['document_original_name'] = $info[$idx]['name'];
        		$data['document_save_name'] = $info[$idx]['savename'];
        		$data['document_size'] = $info[$idx]['size'];
        		$data['document_mime_type'] = $info[$idx]['type'];
        		$data['document_suffix_type'] = $info[$idx]['extension'];
        		$data['document_hash_string'] = $info[$idx]['hash'];
        		$time = date( 'Y-m-d H:i:s', time() );
        		$data['document_upload_time'] = $time;
        		$data['document_type'] = 1;
        		$data['document_status'] = 0;
        		$data['jurisdiction_id'] = session( 'jurisdiction_id' );
        		$document->add( $data );
        	}
        	$this->ajaxReturn( $data, 'success', 1 );
    	}else{ // 上传错误提示错误信息
        	$this->ajaxReturn( $upload->getErrorMsg(), 'fail', 0 );
    	}
	}

	// 系统管理->文档管理->上传用户手册：删除用户手册确认页
	public function upload_manual_delete($record_id=""){
		$document = M( 'document' )->where( array( 'document_id' => $record_id ) )->find();

		if ( $document ) {
			$this->document = $document;
			$document_json = json_encode( $document );
			$tmp_content=$this->fetch( './Public/html/Content/City/system/upload_manual_delete.html' );
			$tmp_content = "<script> document_json=$document_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( '删除该文档失败，请重新操作。' );
		}
	}

	// 系统管理->文档管理->上传用户手册：删除用户手册
	public function upload_manual_deleted($record_id="") {
		// $condition['document_id'] = array( 'EQ', I( 'post.document_id' ) );
		$data['document_id'] = $record_id;
		$time = date( 'Y-m-d H:i:s', time() );
		$data['document_delete_time'] = $time;
		$data['document_status'] = 1;
		$result = M( 'document' )->save( $data );
		if ( $result ) {
			$this->ajaxReturn( 'success' );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

	// 系统管理->文档管理->上传结果公告
	public function upload_announcement(){
		$condition['document_type'] = 2;
		$condition['document_status'] = 0;
		$condition['jurisdiction_id'] = array('GT',1);
		$document = M( 'document' )->where( $condition )->select();
		// if ( $document ) {
			$document_json = json_encode( $document );
			$tmp_content=$this->fetch( './Public/html/Content/City/system/upload_announcement.html' );
			$tmp_content = "<script> document_json=$document_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		//} else {
			$this->ajaxReturn( '加载页面失败，请重新点击侧边栏加载页面。' );
		//}
	}

	// 系统管理->文档管理->上传结果公告：接收上传的结果公告
	public function upload_announcement_form(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile(); // 实例化上传类
    	$upload->maxSize = 10 * 1024 * 1024; // 设置附件上传大小，10M
    	$upload->savePath =  './Uploads/'; // 设置附件上传目录
    	// $upload->saveRule = 'time'; // 采用时间戳命名
    	$upload->saveRule = 'time'; // 设置命名规范为空，保持上传的文件名不变，相同的文件名上传后被覆盖
    	$upload->allowExts  = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'); // 允许上传的文件后缀（留空为不限制）
    	// $upload->allowTypes = array('doc', 'pdf', 'jpg'); // 允许上传的文件类型（留空为不限制）
    	$upload->uploadReplace = true;

    	if( $upload->upload() ) { // 上传成功
        	$info = $upload->getUploadFileInfo(); // 取得成功上传的文件信息
        	$document = M( 'document' );
        	for ( $idx = 0; $idx < count( $info ); ++$idx ) {
				$data['form_name'] = $info[$idx]['key'];
        		$data['document_save_path'] = $info[$idx]['savepath'];
        		$data['document_original_name'] = $info[$idx]['name'];
        		$data['document_save_name'] = $info[$idx]['savename'];
        		$data['document_size'] = $info[$idx]['size'];
        		$data['document_mime_type'] = $info[$idx]['type'];
        		$data['document_suffix_type'] = $info[$idx]['extension'];
        		$data['document_hash_string'] = $info[$idx]['hash'];
        		$time = date( 'Y-m-d H:i:s', time() );
        		$data['document_upload_time'] = $time;
        		$data['document_type'] = 2;
        		$data['document_status'] = 0;
        		$data['jurisdiction_id'] = session( 'jurisdiction_id' );
        		$document->add( $data );
        	}
        	$this->ajaxReturn( $data, 'success', 1 );
    	}else{ // 上传错误提示错误信息
        	$this->ajaxReturn( $upload->getErrorMsg(), 'fail', 0 );
    	}
	}

	// 系统管理->文档管理->上传结果公告：删除结果公告确认页
	public function upload_announcement_delete($record_id=""){
		$document = M( 'document' )->where( array( 'document_id' => $record_id ) )->find();

		if ( $document ) {
			$this->document = $document;
			$document_json = json_encode( $document );
			$tmp_content=$this->fetch( './Public/html/Content/City/system/upload_announcement_delete.html' );
			$tmp_content = "<script> document_json=$document_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( '删除该文档失败，请重新操作。' );
		}
	}

	// 系统管理->文档管理->上传结果公告：删除结果公告
	public function upload_announcement_deleted($record_id="") {
		// $condition['document_id'] = array( 'EQ', I( 'post.document_id' ) );
		$data['document_id'] = $record_id;
		$time = date( 'Y-m-d H:i:s', time() );
		$data['document_delete_time'] = $time;
		$data['document_status'] = 1;
		$result = M( 'document' )->save( $data );
		if ( $result ) {
			$this->ajaxReturn( 'success' );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

}

?>
