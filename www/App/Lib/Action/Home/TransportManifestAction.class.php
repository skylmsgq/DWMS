<?php
/**
 *
 */
class TransportManifestAction extends TransportCommonAction{
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
		$condition['_string'] = 'manifest_status>0';

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

		$vehicle = M('vehicle')->where( array( 'transport_unit_id' => session('transport_unit_id') ) )->select();
		$vehicle_json = json_encode($vehicle);


		$p_id = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->getField('production_unit_id');
		$r_id = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->getField('reception_unit_id');
		$p_name = M( 'production_unit' )->where( array( 'production_unit_id' => $p_id ) )->getField('production_unit_name');
		$r_name = M( 'reception_unit' )->where( array( 'reception_unit_id' => $r_id ) )->getField('reception_unit_name');
		$this->p_name = $p_name;
		$this->r_name = $r_name;

		$this->manifest = $manifest;
		$this->transport_unit = $transport_unit;

		$tmp_content=$this->fetch( './Public/html/Content/Transport/manifest/transfer_manifest_handle_request.html' );
		$tmp_content = "<script>vehicle = $vehicle_json;manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 转移联单->转移联单处理->填写页->表单保存
	public function transfer_manifest_handle_request_form($manifest_id="") {
		$manifest = M( 'manifest' ); // 实例化record对象
		$data = I( 'post.' );
		$time = date( 'Y-m-d H:i:s', time() );
		$data['manifest_modify_time'] = $time;
		// if(I('post.vehicle_code_2')){
		// 	$vehicle_id_2 = M('vehicle')->where(array('vehicle_num' => I('post.vehicle_code_2')))->getField('vehicle_id');
		// 	$data['vehicle_id_2'] = $vehicle_id_2;
		// }
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

		$vehicle = M('vehicle')->where( array( 'transport_unit_id' => session('transport_unit_id') ) )->select();
		$vehicle_json = json_encode($vehicle);

		$p_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('production_unit_id');
		$r_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('reception_unit_id');
		$p_name=M('production_unit')->where("production_unit_id='$p_id'")->getField('production_unit_name');
		$r_name=M('reception_unit')->where("reception_unit_id='$r_id'")->getField('reception_unit_name');
		$this->p_name=$p_name;
		$this->r_name=$r_name;
		$tmp_content=$this->fetch( './Public/html/Content/Transport/manifest/transfer_manifest_handle_modify.html' );
		$tmp_content = "<script>vehicle = $vehicle_json;manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json;</script> $tmp_content";
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
		case '2':
			$manifest_status = 2;
			break;
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
		$p_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('production_unit_id');
		$r_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('reception_unit_id');
		$p_name=M('production_unit')->where("production_unit_id='$p_id'")->getField('production_unit_name');
		$r_name=M('reception_unit')->where("reception_unit_id='$r_id'")->getField('reception_unit_name');
		$this->p_name=$p_name;
		$this->r_name=$r_name;

		$tmp_content=$this->fetch( './Public/html/Content/Transport/manifest/transfer_manifest_handle_submit.html' );
		$tmp_content = "<script>manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

// 转移联单->转移联单处理->提交页->提交联单
	public function transfer_manifest_handle_submited($manifest_id="") {
		$manifest = M( 'manifest' );
		$time = date( 'Y-m-d H:i:s', time() );
		$data['manifest_modify_time'] = $time;
		$data['manifest_id'] = $manifest_id;
		$data['manifest_status'] = 3;
		$manifest->save( $data );
	}

// 转移联单->转移联单查询
	public function transfer_manifest_query(){
		//$manifest = M( 'manifest' )->where( array( array('transport_unit_id' => session( 'transport_unit_id' ) ), array('manifest_status' => 1,'manifest_status' => 2,'or') ) )->getField( 'manifest_id,manifest_num,manifest_add_time,manifest_status' );
		$manifest = M( 'manifest' );
		$condition['transport_unit_id'] = session('transport_unit_id');
		$condition['_string'] = 'manifest_status>1';
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
		$p_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('production_unit_id');
		$r_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('reception_unit_id');
		$p_name=M('production_unit')->where("production_unit_id='$p_id'")->getField('production_unit_name');
		$r_name=M('reception_unit')->where("reception_unit_id='$r_id'")->getField('reception_unit_name');
		$this->p_name=$p_name;
		$this->r_name=$r_name;
		$tmp_content=$this->fetch( './Public/html/Content/Transport/manifest/transfer_manifest_query_detail.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 转移联单->转移联单->联单路线查询
	public function manifest_route_query(){

	}
}
?>