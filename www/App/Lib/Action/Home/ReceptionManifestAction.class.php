<?php
/**
 *
 */
class ReceptionManifestAction extends CommonAction{
// -------- 转移联单->侧边栏 --------
	public function manifest_sidebar() {
		layout( './Common/frame' );
		$this->display( './Public/html/Content/Reception/manifest/manifest_sidebar.html' );
	}
// 转移联单->转移联单处理
	public function transfer_manifest_handle() {
		$manifest = M( 'manifest' );
		$condition['reception_unit_id'] = session('reception_unit_id');
		$condition['_string'] = 'manifest_status=4 OR manifest_status=9 OR manifest_status=10 OR manifest_status=12 OR manifest_status=13 OR manifest_status=11';
		$manifest_data = $manifest->where($condition)->getField( 'manifest_id,manifest_num,manifest_modify_time,manifest_status' );

		$manifest_json = json_encode( $manifest_data ); 

		$unit_name = M( 'reception_unit' )->where( array( 'reception_unit_id' => session( 'reception_unit_id' ) ) )->getField( 'reception_unit_name' );
		$unit_json = json_encode( $unit_name );
		
		$tmp_content=$this->fetch( './Public/html/Content/Reception/manifest/transfer_manifest_handle.html' );
		$tmp_content = "<script>manifest_json = $manifest_json;  unit_json = $unit_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

// 转移联单->转移联单处理->填写页
	public function transfer_manifest_handle_request($manifest_id=""){
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => session('reception_unit_id' ) ) )->find();
		
		$manifest_id_json = json_encode($manifest_id);
		$manifest_status_json = json_encode($manifest['manifest_status']);

		$this->manifest = $manifest;
		$this->reception_unit = $reception_unit;
		$p_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('production_unit_id');
		$t_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('transport_unit_id');
		$p_name=M('production_unit')->where("production_unit_id='$p_id'")->getField('production_unit_name');
		$t_name=M('transport_unit')->where("transport_unit_id='$t_id'")->getField('transport_unit_name');
		$this->p_name=$p_name;
		$this->t_name=$t_name;
		$tmp_content=$this->fetch( './Public/html/Content/Reception/manifest/transfer_manifest_handle_request.html' );
		$tmp_content = "<script>manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

// 转移联单->转移联单处理->填写页->保存
	public function transfer_manifest_handle_request_form($manifest_id="") {
		$manifest = M( 'manifest' ); // 实例化record对象
		$data = I( 'post.' );
		$time = date( 'Y-m-d H:i:s', time() );
		$data['manifest_modify_time'] = $time;
		
		$manifest_status_old = I( 'post.manifest_status_old' );
		switch ( $manifest_status_old ) {
		case '4':
			$manifest_status = 9;
			break;
		default:
			$manifest_status = -1;
			break;
		}
		$data['manifest_status'] = $manifest_status;
		$manifest->where( array( 'manifest_id' =>$manifest_id ) )->save( $data ); // 根据条件保存修改的数据

	}

// 转移联单->转移联单处理->修改页

	public function transfer_manifest_handle_modify($manifest_id=""){
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => session('reception_unit_id' ) ) )->find();
		
		$manifest_id_json = json_encode($manifest_id);
		$manifest_status_json = json_encode($manifest['manifest_status']);

		$this->manifest = $manifest;
		$this->reception_unit = $reception_unit;
		$p_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('production_unit_id');
		$t_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('transport_unit_id');
		$p_name=M('production_unit')->where("production_unit_id='$p_id'")->getField('production_unit_name');
		$t_name=M('transport_unit')->where("transport_unit_id='$t_id'")->getField('transport_unit_name');
		$this->p_name=$p_name;
		$this->t_name=$t_name;
		$tmp_content=$this->fetch( './Public/html/Content/Reception/manifest/transfer_manifest_handle_modify.html' );
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
		case '9':
			$manifest_status = 9;
			break;
		case '12':
			$manifest_status = 13;
			break;
		case '13':
			$manifest_status = 13;
			break;	
		default:
			$manifest_status = -1;
			break;
		}
		$data['manifest_status'] = $manifest_status;
		$manifest->where( array( 'manifest_id' =>$manifest_id ) )->save( $data );
	}

// 转移联单->转移联单处理->提交页
	public function transfer_manifest_handle_submit($manifest_id="") {
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => session('reception_unit_id' ) ) )->find();
		
		$manifest_id_json = json_encode($manifest_id);
		$manifest_status_json = json_encode($manifest['manifest_status']);

		$this->manifest = $manifest;
		$this->reception_unit = $reception_unit;
		$p_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('production_unit_id');
		$t_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('transport_unit_id');
		$p_name=M('production_unit')->where("production_unit_id='$p_id'")->getField('production_unit_name');
		$t_name=M('transport_unit')->where("transport_unit_id='$t_id'")->getField('transport_unit_name');
		$this->p_name=$p_name;
		$this->t_name=$t_name;
		$tmp_content=$this->fetch( './Public/html/Content/Reception/manifest/transfer_manifest_handle_submit.html' );
		$tmp_content = "<script>manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

// 转移联单->转移联单处理->提交页->提交联单
	public function transfer_manifest_handle_submited($manifest_id="") {
		$manifest = M( 'manifest' ); 
		$time = date( 'Y-m-d H:i:s', time() );
		$data['manifest_modify_time'] = $time;
		$data['manifest_id'] = $manifest_id;
		$data['manifest_status'] = 10;
		$manifest->save( $data );
	}

// 转移联单->转移联单查询
	public function transfer_manifest_query() {
		$manifest = M( 'manifest' );
		$condition['reception_unit_id'] = session('reception_unit_id');
		$condition['_string'] = 'manifest_status=9 OR manifest_status=13 OR manifest_status=10 OR manifest_status=12 OR manifest_status=11';
		$manifest_data = $manifest->where($condition)->getField( 'manifest_id,manifest_num,manifest_add_time,manifest_status' );

		$manifest_json = json_encode( $manifest_data ); 

		$unit_name = M( 'reception_unit' )->where( array( 'reception_unit_id' => session( 'reception_unit_id' ) ) )->getField( 'reception_unit_name' );
		$unit_json = json_encode( $unit_name );
		
		$tmp_content=$this->fetch( './Public/html/Content/Reception/manifest/transfer_manifest_query.html' );
		$tmp_content = "<script>manifest_json = $manifest_json;  unit_json = $unit_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

// 转移联单->转移联单查询->详情页
	public function transfer_manifest_query_page($manifest_id="") {
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => session( 'reception_unit_id' ) ) )->find();
		$this->manifest = $manifest;
		$this->unit = $transport_unit;
		$p_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('production_unit_id');
		$t_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('transport_unit_id');
		$p_name=M('production_unit')->where("production_unit_id='$p_id'")->getField('production_unit_name');
		$t_name=M('transport_unit')->where("transport_unit_id='$t_id'")->getField('transport_unit_name');
		$this->p_name=$p_name;
		$this->t_name=$t_name;
		$tmp_content=$this->fetch( './Public/html/Content/Reception/manifest/transfer_manifest_query_detail.html' );
		$this->ajaxReturn( $tmp_content );
	}
}
?>