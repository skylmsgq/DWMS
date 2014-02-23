<?php
/**
 *
 */
class DistrictBusinessAction extends CommonAction{
	// -------- 业务办理->侧边栏 --------
	public function business_sidebar() {
		layout( './Common/frame' );
		$this->display( './Public/html/Content/District/business/business_sidebar.html' );
	}

	// 业务办理->待办业务->转移备案管理
	public function transfer_record_management() {
		$record = M( 'record' );
		$condition['jurisdiction_id'] = array('EQ', session( 'jurisdiction_id' ) );
		$condition['record_status'] = array('GT', 0);
		$join = $record->join( 'production_unit ON record.production_unit_id = production_unit.production_unit_id' )->where( $condition )->select();
		$record_json = json_encode( $join );

		$tmp_content=$this->fetch( './Public/html/Content/District/business/transfer_record_management.html' );
		$tmp_content = "<script>record_json = $record_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 业务办理->待办业务->转移备案管理：详细信息页
	public function transfer_record_management_page($record_id="") {
		$record = M( 'record' )->where( array( 'record_id' =>$record_id ) )->find();
		$production_unit = M( 'production_unit' )->where( array( 'production_unit_id' => $record['production_unit_id'] ) )->find();
		$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => $record['transport_unit_id'] ) )->find();
		$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => $record['reception_unit_id'] ) )->find();
		$this->record = $record;
		$this->production_unit = $production_unit;
		$this->transport_unit = $transport_unit;
		$this->reception_unit = $reception_unit;

		$record_id_json = json_encode( $record_id );
		$record_status_json = json_encode( $record['record_status'] );

		$tmp_content=$this->fetch( './Public/html/Content/District/business/transfer_record_management_page.html' );
		$tmp_content = "<script>record_id_json = $record_id_json; record_status_json = $record_status_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 业务办理->待办业务->转移备案管理：审核
	public function transfer_record_management_audit($record_id="") {
		$record_status = I( 'post.record_status' );
		$current_record_status = array(
			'record_id' => $record_id,
			'record_status' => $record_status,
		);
		$result = M( 'record' )->save( $current_record_status );
		if ( $result ) {
			$this->ajaxReturn( 1, '审核成功！', 1 );
		} else {
			$this->ajaxReturn( 0, '审核失败！', 0 );
		}
	}

	// 业务办理->待办业务->转移联单管理
	public function transfer_manifest_management() {
		$manifest = M( 'manifest' );
		$condition['jurisdiction_id'] = array('EQ', session( 'jurisdiction_id' ) );
		$condition['manifest_status'] = array('EQ', 3);
		$production_manifest = $manifest->join( 'production_unit ON manifest.production_unit_id = production_unit.production_unit_id' )->where( $condition )->select();
		$production_manifest_json = json_encode( $production_manifest );

		$condition['jurisdiction_id'] = array('EQ', session( 'jurisdiction_id' ) );
		$condition['manifest_status'] = array('EQ', 10);
		$reception_manifest = $manifest->join( 'reception_unit ON manifest.reception_unit_id = reception_unit.reception_unit_id' )->where( $condition )->select();
		$reception_manifest_json = json_encode( $reception_manifest );

		$tmp_content=$this->fetch( './Public/html/Content/District/business/transfer_manifest_management.html' );
		$tmp_content = "<script>production_manifest_json = $production_manifest_json;reception_manifest_json = $reception_manifest_json </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
		
	}
		
	// 业务办理->待办业务->转移联单管理：详细信息页
	public function transfer_manifest_management_page($manifest_id="") {
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$this->manifest = $manifest;

		$manifest_id_json = json_encode( $manifest_id );
		$manifest_status_json = json_encode( $manifest['manifest_status'] );

		$tmp_content=$this->fetch( './Public/html/Content/District/business/transfer_manifest_management_page.html' );
		$tmp_content = "<script>manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 业务办理->待办业务->转移联单管理：审核
	public function transfer_manifest_management_audit_1($manifest_id="") {
		$manifest_status = I( 'post.manifest_status' );
		$time = date( 'Y-m-d H:i:s', time() );
		$current_manifest_status = array(
			'manifest_modify_time' => $time;
			'manifest_id' => $manifest_id,
			'manifest_status' => $manifest_status,
		);
		$result = M( 'manifest' )->save( $current_manifest_status );
		if ( $result ) {
			$this->ajaxReturn( 1, '审核成功！', 1 );
		} else {
			$this->ajaxReturn( 0, '审核失败！', 0 );
		}
	}
	public function transfer_manifest_management_audit_2($manifest_id="") {
		$manifest_status = I( 'post.manifest_status' );
		$time = date( 'Y-m-d H:i:s', time() );
		$current_manifest_status = array(
			'manifest_modify_time' => $time;
			'manifest_id' => $manifest_id,
			'manifest_status' => $manifest_status,
		);
		$result = M( 'manifest' )->save( $current_manifest_status );
		if ( $result ) {
			$this->ajaxReturn( 1, '审核成功！', 1 );
		} else {
			$this->ajaxReturn( 0, '审核失败！', 0 );
		}
	}

	// 业务办理->待办业务->企业用户管理
	public function enterprise_user_management() {

		/*$productionModel = new Model();
		$transportModel = new Model();
		$receptionModel = new Model();

		$production_user = $productionModel->query("SELECT `user`.`user_id`, `username`, `user_type`, `production_unit_name` AS `unit_name`, `production_unit_code` AS `unit_code`, `production_unit_username` AS `unit_username`, `waste_location_county` AS `location_county`, `jurisdiction_id`, `is_verify`, `lock` FROM user INNER JOIN production_unit ON user.user_id = production_unit.user_id");

		$transport_user = $transportModel->query("SELECT `user`.`user_id`, `username`, `user_type`, `transport_unit_name` AS `unit_name`, `transport_unit_code` AS `unit_code`, `transport_unit_username` AS `unit_username`, `transport_unit_county` AS `location_county`, `jurisdiction_id`, `is_verify`, `lock` FROM user INNER JOIN transport_unit ON user.user_id = transport_unit.user_id");

		$reception_user = $receptionModel->query("SELECT `user`.`user_id`, `username`, `user_type`, `reception_unit_name` AS `unit_name`, `reception_unit_code` AS `unit_code`, `reception_unit_username` AS `unit_username`, `reception_unit_county` AS `location_county`, `jurisdiction_id`, `is_verify`, `lock` FROM user INNER JOIN reception_unit ON user.user_id = reception_unit.user_id");*/

		/*$userModel = new Model();
		$all_user = $userModel->union("SELECT `user`.`user_id`, `username`, `user_type`, `production_unit_name` AS `unit_name`, `production_unit_code` AS `unit_code`, `production_unit_username` AS `unit_username`, `waste_location_county` AS `location_county`, `jurisdiction_id`, `is_verify`, `lock` FROM user INNER JOIN production_unit ON user.user_id = production_unit.user_id")->union("SELECT `user`.`user_id`, `username`, `user_type`, `transport_unit_name` AS `unit_name`, `transport_unit_code` AS `unit_code`, `transport_unit_username` AS `unit_username`, `transport_unit_county` AS `location_county`, `jurisdiction_id`, `is_verify`, `lock` FROM user INNER JOIN transport_unit ON user.user_id = transport_unit.user_id")->union("SELECT `user`.`user_id`, `username`, `user_type`, `reception_unit_name` AS `unit_name`, `reception_unit_code` AS `unit_code`, `reception_unit_username` AS `unit_username`, `reception_unit_county` AS `location_county`, `jurisdiction_id`, `is_verify`, `lock` FROM user INNER JOIN reception_unit ON user.user_id = reception_unit.user_id")->select();*/

		$userModel = new Model();
		$all_user = $userModel->query("
			(SELECT `user`.`user_id`, `username`, `user_type`, `production_unit_name` AS `unit_name`, `production_unit_code` AS `unit_code`, `production_unit_username` AS `unit_username`, `waste_location_county` AS `location_county`, `jurisdiction_id`, `is_verify`, `lock` FROM user INNER JOIN production_unit ON user.user_id = production_unit.user_id)
			UNION
			(SELECT `user`.`user_id`, `username`, `user_type`, `transport_unit_name` AS `unit_name`, `transport_unit_code` AS `unit_code`, `transport_unit_username` AS `unit_username`, `transport_unit_county` AS `location_county`, `jurisdiction_id`, `is_verify`, `lock` FROM user INNER JOIN transport_unit ON user.user_id = transport_unit.user_id)
			UNION
			(SELECT `user`.`user_id`, `username`, `user_type`, `reception_unit_name` AS `unit_name`, `reception_unit_code` AS `unit_code`, `reception_unit_username` AS `unit_username`, `reception_unit_county` AS `location_county`, `jurisdiction_id`, `is_verify`, `lock` FROM user INNER JOIN reception_unit ON user.user_id = reception_unit.user_id)");

		$record_json = json_encode( $all_user );

		$tmp_content=$this->fetch( './Public/html/Content/District/business/enterprise_user_management.html' );

		$tmp_content="<script>record_json=$record_json; </script> $tmp_content";
		$this->ajaxReturn( "$tmp_content" );
	}

	// 业务办理->待办业务->企业用户管理：生产企业
	public function enterprise_user_management_page_production($record_id="") {
		$production_unit = M( 'production_unit' )->where( array( 'user_id' => $record_id ) )->find();
		$this->formData = $production_unit;
		$tmp_content=$this->fetch( './Public/html/Content/District/business/enterprise_user_management_page_production.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 业务办理->待办业务->企业用户管理：运输企业
	public function enterprise_user_management_page_transport($record_id="") {
		$transport_unit = M( 'transport_unit' )->where( array( 'user_id' => $record_id ) )->find();
		$this->formData = $transport_unit;
		$tmp_content=$this->fetch( './Public/html/Content/District/business/enterprise_user_management_page_transport.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 业务办理->待办业务->企业用户管理：接受企业
	public function enterprise_user_management_page_reception($record_id="") {
		$reception_unit = M( 'reception_unit' )->where( array( 'user_id' => $record_id ) )->find();
		$this->formData = $reception_unit;
		$tmp_content=$this->fetch( './Public/html/Content/District/business/enterprise_user_management_page_reception.html' );
		$this->ajaxReturn( $tmp_content );
	}

	//
	public function enterprise_user_management_ajaxpost() {
		$munit=M( 'user' );

		if ( I( 'post.action' )=="lock" ) {
			if ( I( 'post.value' )=='0' )
				$data['lock'] = '0';
			else
				$data['lock'] = '1';
			$munit->where( array( 'user_id' =>I( 'post.user_id' ) ) )->save( $data );
			$this->show( "lock_ok".I( 'post.user_id' ) );
		}
		else if ( I( 'post.action' )=="verify" ) {
				if ( I( 'post.value' )=='0' )
					$data['is_verify'] = '0';
				else
					$data['is_verify'] = '1';

				$munit->where( array( 'user_id' =>I( 'post.user_id' ) ) )->save( $data );
				$this->show( "verify_ok".I( 'post.user_id' ) );
			}

		else {
			$this->error( "action_error" );
		}
	}

	// 业务办理->待办业务->企业信息管理
	public function enterprise_information_management(){
		$tmp_content=$this->fetch( './Public/html/Content/District/business/enterprise_information_management.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 业务办理->业务查询->转移备案查询
	public function transfer_record_query(){
		$tmp_content=$this->fetch( './Public/html/Content/District/business/transfer_record_query.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 业务办理->业务查询->转移联单查询
	public function transfer_manifest_query(){
		$tmp_content=$this->fetch( './Public/html/Content/District/business/transfer_manifest_query.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 业务办理->业务查询->企业信息查询
	public function enterprise_information_query(){
		$tmp_content=$this->fetch( './Public/html/Content/District/business/enterprise_information_query.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 业务办理->业务查询->用户信息查询
	public function user_information_query(){
		$tmp_content=$this->fetch( './Public/html/Content/District/business/user_information_query.html' );
		$this->ajaxReturn( $tmp_content );
	}

}
?>
