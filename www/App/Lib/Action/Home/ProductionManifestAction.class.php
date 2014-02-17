<?php
/**
 *
 */
class ProductionManifestAction extends CommonAction{
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
		$record = M( 'record' )->where( array( 'record_id' =>$record_id ) )->find();
		$record_json = json_encode($record);
		$production_unit = M( 'production_unit' )->where( array( 'production_unit_id' => session('production_unit_id' ) ) )->find();
		$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_name' => $record_json.reception_unit_name) )->find();
		//$this->ajaxReturn("<script>record_data=$record_json.reception_unit_name;</script>");
		
		$this->record = $record;
		$this->production_unit = $production_unit;
		$this->reception_unit = $reception_unit;
		

		// $record_id_json = json_encode( $record_id );

		$tmp_content=$this->fetch( './Public/html/Content/Production/manifest/transfer_manifest_request_page.html' );
		// $tmp_content = "<script>record_id_json = $record_id_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 转移联单->转移联单申请->表单提交
	public function transfer_manifest_request_form() {
		// $transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_name' => I( 'post.transport_unit_name' )) )->find();
		// $reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_name' => I( 'post.reception_unit_name' )) )->find();

		$manifest = M( 'manifest' ); //实例化record对象
		$manifest->create(); // 根据表单提交的POST数据创建数据对象
		$time = date( 'Y-m-d H:i:s', time() );
		$manifest->manifest_add_time = $time;
		$manifest->manifest_modify_time = $time;

		$manifest->production_unit_id = session( 'production_unit_id' );
		$manifest->manifest_num = session( 'production_unit_id' ) . '-' . date( 'Y-m' ) . '-' . ( M( 'manifest' )->max( 'manifest_id' )+1 );

		// $manifest->manifest_transport_unit_id = $transport_unit['transport_unit_id'];
		// $manifest->manifest_reception_unit_id = $reception_unit['reception_unit_id'];
		// $manifest->waste_destination = $reception_unit['reception_unit_address'];

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
		$manifest = M( 'manifest' )->where( array('production_unit_id' => session( 'production_unit_id' ) ) )->getField( 'manifest_id,manifest_num,manifest_add_time,manifest_status' );
		$manifest_json = json_encode( $manifest ); 

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

		$tmp_content=$this->fetch( './Public/html/Content/Production/manifest/transfer_manifest_query_detail.html' );
		$this->ajaxReturn( $tmp_content );
	}
	// 转移联单->转移联单查询->修改信息页
	public function transfer_manifest_query_modify($manifest_id="") {
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$production_unit = M( 'production_unit' )->where( array( 'production_unit_id' => session( 'production_unit_id' ) ) )->find();
		$this->manifest = $manifest;
		$this->unit = $production_unit;

		$manifest_id_json = json_encode( $manifest_id );
		$manifest_status_json = json_encode( $manifest['manifest_status'] );

		$tmp_content=$this->fetch( './Public/html/Content/Production/manifest/transfer_manifest_query_modify.html' );
		$tmp_content = "<script>manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json; </script> $tmp_content";
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
		case '4':
			$manifest_status = 5;
			break;
		case '5':
			$manifest_status = 5;
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
		case '5':
			$manifest_status = 2;
			break;
		default:
			$manifest_status = -1;
			break;
		}
		$manifest = M( 'manifest' ); 
		$data['manifest_id'] = $manifest_id;
		$data['manifest_status'] = $manifest_status;
		$manifest->save( $data );
	}
}

	
	

?>
