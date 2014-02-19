<?php
/**
 *
 */
class TransportManifestAction extends CommonAction{
// -------- 转移联单->侧边栏 --------
	public function manifest_sidebar() {
		layout( './Common/frame' );
		$this->display( './Public/html/Content/Transport/manifest/manifest_sidebar.html' );
	}
// 转移联单->转移联单处理
	public function transfer_manifest_handle() {
		//$manifest = M( 'manifest' )->where( array( array('transport_unit_id' => session( 'transport_unit_id' ) ), array('manifest_status' => 1,'manifest_status' => 2,'or') ) )->getField( 'manifest_id,manifest_num,manifest_add_time,manifest_status' );
		$manifest = M( 'manifest' );
		$condition['transport_unit_id'] = session('transport_unit_id');
		$condition['_string'] = 'manifest_status=1 OR manifest_status=2 OR manifest_status=3 OR manifest_status=5 OR manifest_status=6';

		$manifest_data = $manifest->where($condition)->getField( 'manifest_id,manifest_num,manifest_add_time,manifest_status' );

		$manifest_json = json_encode( $manifest_data );

		$unit_name = M( 'transport_unit' )->where( array( 'transport_unit_id' => session( 'transport_unit_id' ) ) )->getField( 'transport_unit_name' );
		$unit_json = json_encode( $unit_name );

		$tmp_content=$this->fetch( './Public/html/Content/Transport/manifest/transfer_manifest_handle.html' );
		$tmp_content = "<script>manifest_json = $manifest_json;  unit_json = $unit_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

// 转移联单->转移联单处理->填写页
	public function transfer_manifest_handle_request($manifest_id=""){
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => session('transport_unit_id' ) ) )->find();

		$manifest_id_json = json_encode($manifest_id);
		$manifest_status_json = json_encode($manifest['manifest_status']);

		$this->manifest = $manifest;
		$this->transport_unit = $transport_unit;

		$tmp_content=$this->fetch( './Public/html/Content/Transport/manifest/transfer_manifest_handle_request.html' );
		$tmp_content = "<script>manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

// 转移联单->转移联单处理->填写页->表单保存
	public function transfer_manifest_handle_request_form($manifest_id="") {
		$manifest = M( 'manifest' ); // 实例化record对象
		$time = date( 'Y-m-d H:i:s', time() );
		$data['manifest_modify_time'] = $time;
		$data = I( 'post.' );
		$manifest_status_old = I( 'post.manifest_status_old' );
		switch ( $manifest_status_old ) {
		case '1':
			$manifest_status = 2;
			break;
		default:
			$manifest_status = -1;
			break;
		}
		$data['manifest_status'] = $manifest_status;
		$manifest->where( array( 'manifest_id' =>$manifest_id ) )->save( $data );


	}

// 转移联单->转移联单处理->修改页

	public function transfer_manifest_handle_modify($manifest_id=""){
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => session('transport_unit_id' ) ) )->find();

		$manifest_id_json = json_encode($manifest_id);
		$manifest_status_json = json_encode($manifest['manifest_status']);

		$this->manifest = $manifest;
		$this->transport_unit = $transport_unit;

		$tmp_content=$this->fetch( './Public/html/Content/Transport/manifest/transfer_manifest_handle_modify.html' );
		$tmp_content = "<script>manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

// 转移联单->转移联单处理->修改页->保存
	public function transfer_manifest_handle_modified($manifest_id="") {
		$manifest = M( 'manifest' ); // 实例化record对象
		$data = I( 'post.' );
		$time = date( 'Y-m-d H:i:s', time() );

		$data['manifest_modify_time'] = $time;
		$manifest_status_old = I( 'post.manifest_status_old' );
		switch ( $manifest_status_old ) {
		case '5':
			$manifest_status = 6;
			break;
		case '6':
			$manifest_status = 6;
			break;
		default:
			$manifest_status = -1;
			break;
		}
		$data['manifest_status'] = $manifest_status;
		$result = $manifest->where( array( 'manifest_id' => $manifest_id ) )->save( $data );

		if ( $result ) {
			$this->ajaxReturn( 1, '修改成功！', 1 );
		} else {
			$this->ajaxReturn( 0, '修改失败！', 0 );
		}
	}

// 转移联单->转移联单处理->提交页
	public function transfer_manifest_handle_submit($manifest_id="") {
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => session('transport_unit_id' ) ) )->find();

		$manifest_id_json = json_encode($manifest_id);
		$manifest_status_json = json_encode($manifest['manifest_status']);

		$this->manifest = $manifest;
		$this->transport_unit = $transport_unit;

		$tmp_content=$this->fetch( './Public/html/Content/Transport/manifest/transfer_manifest_handle_submit.html' );
		$tmp_content = "<script>manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

// 转移联单->转移联单处理->提交页->提交联单
	public function transfer_manifest_handle_submited($manifest_id="") {
		$manifest = M( 'manifest' );
		$data['manifest_id'] = $manifest_id;
		$data['manifest_status'] = 3;
		$manifest->save( $data );
	}

// 转移联单->转移联单查询
	public function transfer_manifest_query() {
		//$manifest = M( 'manifest' )->where( array( array('transport_unit_id' => session( 'transport_unit_id' ) ), array('manifest_status' => 1,'manifest_status' => 2,'or') ) )->getField( 'manifest_id,manifest_num,manifest_add_time,manifest_status' );
		$manifest = M( 'manifest' );
		$condition['transport_unit_id'] = session('transport_unit_id');
		$condition['_string'] = 'manifest_status=2 OR manifest_status=3 OR manifest_status=5 OR manifest_status=6';
		$manifest_data = $manifest->where($condition)->getField( 'manifest_id,manifest_num,manifest_add_time,manifest_status' );

		$manifest_json = json_encode( $manifest_data );

		$unit_name = M( 'transport_unit' )->where( array( 'transport_unit_id' => session( 'transport_unit_id' ) ) )->getField( 'transport_unit_name' );
		$unit_json = json_encode( $unit_name );

		$tmp_content=$this->fetch( './Public/html/Content/Transport/manifest/transfer_manifest_query.html' );
		$tmp_content = "<script>manifest_json = $manifest_json;  unit_json = $unit_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

// 转移联单->转移联单查询->详情页
	public function transfer_manifest_query_page($manifest_id="") {
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => session( 'transport_unit_id' ) ) )->find();
		$this->manifest = $manifest;
		$this->unit = $transport_unit;

		$tmp_content=$this->fetch( './Public/html/Content/Transport/manifest/transfer_manifest_query_detail.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 转移联单->转移联单->联单路线查询
	public function manifest_route_query(){

	}
}
?>