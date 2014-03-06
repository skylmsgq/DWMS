<?php
/**
 *
 */
class ProductionManifestAction extends ProductionCommonAction{
	// -------- 转移联单->侧边栏 --------
	public function manifest_sidebar() {
		layout( './Common/frame' );
		$this->display( './Public/html/Content/Production/manifest/manifest_sidebar.html' );
	}

	// 转移联单->转移联单申请
	public function transfer_manifest_request() {
		$record = M( 'record' )->where( array('record_status'=>2,'production_unit_id' => session( 'production_unit_id' ) ) )->getField( 'record_id,record_code,record_date,record_status' );
		$record_json = json_encode( $record );

		$unit_name = M( 'production_unit' )->where( array( 'production_unit_id' => session( 'production_unit_id' ) ) )->getField( 'production_unit_name' );
		$unit_json = json_encode( $unit_name );

		$tmp_content=$this->fetch( './Public/html/Content/Production/manifest/transfer_manifest_request.html' );
		$tmp_content = "<script>record_json = $record_json; unit_json = $unit_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}
	// 转移联单->转移联单申请: 申请联单
	public function transfer_manifest_request_page($record_id="") {
		$record = M( 'record' )->where( array( 'record_id' => $record_id ) )->find();
		$record_json = json_encode($record);

		$waste_category_code = M('waste_category')->where('waste_category_id>0')->getField('waste_category_code',true);
		$waste_category_code_json = json_encode($waste_category_code);
		$waste_form = M('waste_form')->where('waste_form_id>0')->getField('waste_form',true);
		$waste_form_json = json_encode($waste_form);
		$package_method = M( 'package_method' )->where('package_method_id>0')->select();
		$package_method_json = json_encode($package_method);
		$waste_transport_goal = M( 'waste_transport_goal' )->where('waste_transport_goal_id>0')->select();
		$waste_transport_goal_json = json_encode($waste_transport_goal);

		$production_unit = M( 'production_unit' )->where( array( 'production_unit_id' => session('production_unit_id' ) ) )->find();
		//$this->ajaxReturn("<script>record_data=$record_json.reception_unit_name;</script>");
		$t_id = M( 'record' )->where( array( 'record_id' =>$record_id ) )->getField('transport_unit_id');
		$r_id = M( 'record' )->where( array( 'record_id' =>$record_id ) )->getField('reception_unit_id');
		$t_name = M( 'transport_unit' )->where( array( 'transport_unit_id' => $t_id ) )->getField('transport_unit_name');
		$r_name = M( 'reception_unit' )->where( array( 'reception_unit_id' => $r_id ) )->getField('reception_unit_name');
		$this->t_name = $t_name;
		$this->r_name = $r_name;

		$this->record = $record;
		$this->production_unit = $production_unit;

		$tmp_content=$this->fetch( './Public/html/Content/Production/manifest/transfer_manifest_request_page.html' );

		$tmp_content = "<script>record_json = $record_json;waste_category_code = $waste_category_code_json;waste_form = $waste_form_json;package_method = $package_method_json;waste_transport_goal = $waste_transport_goal_json; </script> $tmp_content";

		$this->ajaxReturn( $tmp_content );
	}

	// 转移联单->转移联单申请->表单提交
	public function transfer_manifest_request_form($record_id="") {
		$record = M( 'record' );
		$data['record_status'] = 5;
		$record->where( array( 'record_id' =>$record_id ) )->save($data);

		// $table = M('record')->where( array( 'record_id' =>$record_id ) )->select();

		$manifest = M( 'manifest' ); //实例化record对象
		$manifest->create(); // 根据表单提交的POST数据创建数据对象
		$time = date( 'Y-m-d H:i:s', time() );
		$manifest->manifest_add_time = $time;
		$manifest->manifest_modify_time = $time;

		$manifest->rfid_table_id = I( 'post.rfid_table_id' );
		$manifest->manifest_record_id = $record_id;

		$manifest->transport_unit_id = I( 'post.transport_unit_id' );
		$manifest->reception_unit_id = I( 'post.reception_unit_id' );
		// $manifest->waste_id = I( 'post.waste_id' );
		$manifest->waste_weight = I( 'post.waste_weight' );
		$manifest->waste_num = I( 'post.waste_num' );

		$manifest->production_unit_id = session( 'production_unit_id' );
		$manifest->manifest_num = session( 'production_unit_id' ) . '-' . date( 'Y-m' ) . '-' . ( M( 'manifest' )->max( 'manifest_id' )+1 );
		// $manifest->manifest_num = '34' . '08' .

		$manifest->manifest_status = I( 'post.manifest_status' );
		$result = $manifest->add(); // 根据条件保存修改的数据

		if ( $result ) {
			$this->ajaxReturn( 1, '保存成功！', 1 );
		} else {
			$this->ajaxReturn( 0, '保存失败！', 0 );
		}
	}

	// 转移联单->转移联单查询
	public function transfer_manifest_query() {
		// $manifest = M( 'manifest' )->where( array('production_unit_id' => session( 'production_unit_id' ) ) );
		$manifest = M( 'manifest' );
		$condition['production_unit_id'] = session('production_unit_id');
		$condition['_string'] = 'manifest_status >= 0';
		$manifest_data = $manifest->where($condition)->getField( 'manifest_id,manifest_num,manifest_add_time,manifest_status' );

		$manifest_json = json_encode( $manifest_data );

		$unit_name = M( 'production_unit' )->where( array( 'production_unit_id' => session( 'production_unit_id' ) ) )->getField( 'production_unit_name' );
		$unit_json = json_encode( $unit_name );

		$tmp_content=$this->fetch( './Public/html/Content/Production/manifest/transfer_manifest_query.html' );
		$tmp_content = "<script>manifest_json = $manifest_json;  unit_json = $unit_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 转移联单->转移联单查询->详细信息页
	public function transfer_manifest_query_detail($manifest_id="") {
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$production_unit = M( 'production_unit' )->where( array( 'production_unit_id' => session( 'production_unit_id' ) ) )->find();
		$this->manifest = $manifest;
		$this->unit = $production_unit;
		$t_id = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->getField('transport_unit_id');
		$r_id = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->getField('reception_unit_id');
		$t_name = M( 'transport_unit' )->where( array( 'transport_unit_id' => $t_id ) )->getField('transport_unit_name');
		$r_name = M( 'reception_unit' )->where( array( 'reception_unit_id' => $r_id ) )->getField('reception_unit_name');
		$this->t_name = $t_name;
		$this->r_name = $r_name;
		$tmp_content=$this->fetch( './Public/html/Content/Production/manifest/transfer_manifest_query_detail.html' );
		$this->ajaxReturn( $tmp_content );
	}
	// 转移联单->转移联单查询->修改信息页
	public function transfer_manifest_query_modify($manifest_id="") {
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$production_unit = M( 'production_unit' )->where( array( 'production_unit_id' => session( 'production_unit_id' ) ) )->find();
		$this->manifest = $manifest;
		$this->production_unit = $production_unit;

		$waste_category_code = M('waste_category')->where('waste_category_id>0')->getField('waste_category_code',true);
		$waste_category_code_json = json_encode($waste_category_code);
		$waste_form = M('waste_form')->where('waste_form_id>0')->getField('waste_form',true);
		$waste_form_json = json_encode($waste_form);
		$package_method = M( 'package_method' )->where('package_method_id>0')->select();
		$package_method_json = json_encode($package_method);
		$waste_transport_goal = M( 'waste_transport_goal' )->where('waste_transport_goal_id>0')->getField('waste_transport_goal',true);
		$waste_transport_goal_json = json_encode($waste_transport_goal);

		$manifest_id_json = json_encode( $manifest_id );
		$manifest_status_json = json_encode( $manifest['manifest_status'] );

		$t_id = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->getField('transport_unit_id');
		$r_id = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->getField('reception_unit_id');
		$t_name = M( 'transport_unit' )->where( array( 'transport_unit_id' => $t_id ) )->getField('transport_unit_name');
		$r_name = M( 'reception_unit' )->where( array( 'reception_unit_id' => $r_id ) )->getField('reception_unit_name');
		$this->t_name = $t_name;
		$this->r_name = $r_name;

		$tmp_content=$this->fetch( './Public/html/Content/Production/manifest/transfer_manifest_query_modify.html' );
		$tmp_content = "<script>manifest_id_json = $manifest_id_json; waste_category_code =$waste_category_code_json; waste_form = $waste_form_json; manifest_status_json = $manifest_status_json;package_method = $package_method_json;waste_transport_goal = $waste_transport_goal_json;  </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 转移联单->转移联单查询->修改提交
    public function transfer_manifest_query_modified($manifest_id="") {
		$manifest = M( 'manifest' ); // 实例化record对象
		$manifest->create(); // 根据表单提交的POST数据创建数据对象
		$manifest->manifest_id = $manifest_id;
		$time = date( 'Y-m-d H:i:s', time() );
		$manifest->manifest_modify_time = $time;
		$manifest_status_old = I( 'post.manifest_status_old' );
		switch ( $manifest_status_old ) {
		case '0':
			$manifest_status = 0;
			break;
		case '7':
			$manifest_status = 8;
			break;
		case '8':
			$manifest_status = 8;
			break;
		default:
			$manifest_status = -1;
			break;
		}
		$manifest->manifest_status = $manifest_status;
		$result = $manifest->save(); // 根据条件保存修改的数据

		if ( $result ) {
			$this->ajaxReturn( 1, '修改成功！', 1 );
		} else {
			$this->ajaxReturn( 0, '修改失败！', 0 );
		}
	}


	// 转移联单->转移联单查询->提交信息页
	public function transfer_manifest_query_submit($manifest_id="") {
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$production_unit = M( 'production_unit' )->where( array( 'production_unit_id' => session( 'production_unit_id' ) ) )->find();
		$this->manifest = $manifest;
		$this->production_unit = $production_unit;

		$t_id = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->getField('transport_unit_id');
		$r_id = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->getField('reception_unit_id');
		$t_name = M( 'transport_unit' )->where( array( 'transport_unit_id' => $t_id ) )->getField('transport_unit_name');
		$r_name = M( 'reception_unit' )->where( array( 'reception_unit_id' => $r_id ) )->getField('reception_unit_name');
		$this->t_name = $t_name;
		$this->r_name = $r_name;

		$manifest_id_json = json_encode( $manifest_id );
		$manifest_status_json = json_encode( $manifest['manifest_status'] );

		$tmp_content=$this->fetch( './Public/html/Content/Production/manifest/transfer_manifest_query_submit.html' );
		$tmp_content = "<script>manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 转移联单->转移联单查询->提交联单
	public function transfer_manifest_query_submited($manifest_id="") {
		$manifest_status_old = I( 'post.manifest_status_old' );
		switch ( $manifest_status_old ) {
		case '0':
			$manifest_status = 1;
			break;
		case '8':
			$manifest_status = 1;
			break;
		default:
			$manifest_status = -1;
			break;
		}
		$manifest = M( 'manifest' );
		$time = date( 'Y-m-d H:i:s', time() );
		$data['manifest_modify_time'] = $time;
		$data['manifest_id'] = $manifest_id;
		$data['manifest_status'] = $manifest_status;
		$manifest->save( $data );
	}
}

?>
