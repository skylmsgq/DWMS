<?php
/**
 *
 */
class DistrictBusinessAction extends DistrictCommonAction{
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
		// $record_comment = I( 'post.record_comment' );
		$current_record_status = array(
			'record_id' => $record_id,
			'record_status' => $record_status,
			// 'record_production_unit_comment' => $record_comment,
		);
		if($record_status == 2 ){
			$reception_unit_id=M('record')->where("record_id='$record_id'")->getField('reception_unit_id');
			$rfid_table=M('record')->where("record_id='$record_id'")->getField('rfid_table_id');
			$rfid_list=explode(",",$rfid_table);
			foreach ($rfid_list as  $value) {
				# code...
				if ($value!="")
				{
					$rfid=M('rfid');
					$old_rfidstatus=$rfid->where("rfid_id='$value' ")->getField('transfer_status');

					if ($old_rfidstatus!=1)
					{
					$data['transfer_status']=1;
					$data['record_id']=$record_id;
					$data['reception_unit_id']=$reception_unit_id;
					$resultrfid=$rfid->where("rfid_id='$value' ")->save($data);
					if (!$resultrfid)
						$this->ajaxReturn( 0, '修改数据库失败！', 0 );
					}
				}
			}
		}
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

		$vehicle_num_1 = M( 'vehicle' )->where( array( 'vehicle_id' => $manifest['vehicle_id_1'] ) )->getField('vehicle_num');
		$this->vehicle_num_1 = $vehicle_num_1;

		if($manifest['vehicle_id_2']){
			$vehicle_num_2 = M( 'vehicle' )->where( array( 'vehicle_id' => $manifest['vehicle_id_2'] ) )->getField('vehicle_num');
			$this->vehicle_num_2 = $vehicle_num_2;
		}
		
		$manifest_id_json = json_encode( $manifest_id );
		$manifest_status_json = json_encode( $manifest['manifest_status'] );
		$production_unit_id_json = json_encode( $manifest['production_unit_id'] );
		$reception_unit_id_json = json_encode( $manifest['reception_unit_id'] );

		$tmp_content=$this->fetch( './Public/html/Content/District/business/transfer_manifest_management_page.html' );
		$tmp_content = "<script>manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json; production_unit_id = $production_unit_id_json; reception_unit_id = $reception_unit_id_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 业务办理->待办业务->转移联单管理：审核
	public function transfer_manifest_management_audit_1($manifest_id="") {
		$manifest_status = I( 'post.manifest_status' );
		$time = date( 'Y-m-d H:i:s', time() );
		$current_manifest_status = array(
			'manifest_modify_time' => $time,
			'manifest_id' => $manifest_id,
			'manifest_status' => $manifest_status,
		);
		$result = M( 'manifest' )->save( $current_manifest_status );

		if(I( 'post.manifest_status' )==4){
			$route = M( 'route' )->where( array( 'production_unit_id' => I( 'post.production_unit_id' ),'reception_unit_id' => I( 'post.reception_unit_id' ) ) )->find();
			$route_id = $route['route_id'];
			$manifest = M('manifest')->where( array( 'manifest_id' => $manifest_id ) )->find();
			$route_vehicle = M('route_vehicle');
			$route_vehicle->create();
			$route_vehicle->route_id = $route_id;
			$route_vehicle->vehicle_id = $manifest['vehicle_id_1'];
			$route_vehicle->manifest_id = $manifest_id;
			$route_vehicle->transport_date = $manifest['waste_transport_time'];
			$time = date( 'Y-m-d H:i:s', time() );
			$route_vehicle->correlation_add_time = $time;
			$route_vehicle->correlation_status = 0;

			$result = $route_vehicle->add(); // 根据条件保存修改的数据

			if ( $result ) {
				$this->ajaxReturn( 1, '保存成功！', 1 );
			} else {
				$this->ajaxReturn( 0, '保存失败！', 0 );
			}
		}
	}

	public function transfer_manifest_management_audit_2($manifest_id="") {
		$manifest_status = I( 'post.manifest_status' );
		if ($manifest_status==11)
		{
		$rfid_table=M('manifest')->where("manifest_id='$manifest_id'")->getField('rfid_table_id');
		$rfid_list=explode(",",$rfid_table);
		foreach ($rfid_list as  $value) {
			# code...
			if ($value!="")
			{
				$rfid=M('rfid');
				$old_rfidstatus=$rfid->where("rfid_id='$value' ")->getField('manifest_id');

				if (!$old_rfidstatus)
				{
				$data['manifest_id']=$manifest_id;
				$resultrfid=$rfid->where("rfid_id='$value' ")->save($data);
				if (!$resultrfid)
					$this->ajaxReturn( 0, '修改数据库失败！', 0 );
				}
			}
		}
		}
		$time = date( 'Y-m-d H:i:s', time() );
		$current_manifest_status = array(
			'manifest_modify_time' => $time,
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

	// 业务办理->待办业务->转移联单管理->作废
	public function manifest_delete($manifest_id=""){
		$manifest = M('manifest');  // 实例化waste对象
		$data['manifest_status'] = -1;	
		$result = $manifest->where( array( 'manifest_id' => $manifest_id ) )->save($data);
		if ( $result ) {
			$this->ajaxReturn( 1 );
		} else {
			$this->ajaxReturn( 0 );
		}
	}

	// 业务办理->待办业务->企业用户管理
	public function enterprise_user_management() {
		$userModel = new Model();
		$all_user = $userModel->query("
			(SELECT `user`.`user_id`, `username`, `user_type`, `production_unit_name` AS `unit_name`, `production_unit_id` AS `unit_code`, `production_unit_username` AS `unit_username`, `waste_location_county` AS `location_county`, `jurisdiction_id`, `is_verify`, `lock` FROM user INNER JOIN production_unit ON user.user_id = production_unit.user_id)
			UNION
			(SELECT `user`.`user_id`, `username`, `user_type`, `transport_unit_name` AS `unit_name`, `transport_unit_id` AS `unit_code`, `transport_unit_username` AS `unit_username`, `transport_unit_county` AS `location_county`, `jurisdiction_id`, `is_verify`, `lock` FROM user INNER JOIN transport_unit ON user.user_id = transport_unit.user_id)
			UNION
			(SELECT `user`.`user_id`, `username`, `user_type`, `reception_unit_name` AS `unit_name`, `reception_unit_id` AS `unit_code`, `reception_unit_username` AS `unit_username`, `reception_unit_county` AS `location_county`, `jurisdiction_id`, `is_verify`, `lock` FROM user INNER JOIN reception_unit ON user.user_id = reception_unit.user_id)");

		$record_json = json_encode( $all_user );

		$tmp_content=$this->fetch( './Public/html/Content/District/business/enterprise_user_management.html' );

		$tmp_content="<script>record_json=$record_json; </script> $tmp_content";
		$this->ajaxReturn( "$tmp_content" );
	}

	// 业务办理->待办业务->企业用户管理：生产企业
	public function enterprise_user_management_page_production($record_id="") {
		$production_unit = M( 'production_unit' )->where( array( 'user_id' => $record_id ) )->find();
		$this->formData = $production_unit;
		$jurisdiction = M( 'jurisdiction' )->where( array( 'jurisdiction_id' => $production_unit['jurisdiction_id'] ) )->getField('jurisdiction_name');
		$this->jurisdiction = $jurisdiction;
		$tmp_content=$this->fetch( './Public/html/Content/District/business/enterprise_user_management_page_production.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 业务办理->待办业务->企业用户管理：运输企业
	public function enterprise_user_management_page_transport($record_id="") {
		$transport_unit = M( 'transport_unit' )->where( array( 'user_id' => $record_id ) )->find();
		$this->formData = $transport_unit;
		$jurisdiction = M( 'jurisdiction' )->where( array( 'jurisdiction_id' => $transport_unit['jurisdiction_id'] ) )->getField('jurisdiction_name');
		$this->jurisdiction = $jurisdiction;
		$tmp_content=$this->fetch( './Public/html/Content/District/business/enterprise_user_management_page_transport.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 业务办理->待办业务->企业用户管理：接受企业
	public function enterprise_user_management_page_reception($record_id="") {
		$reception_unit = M( 'reception_unit' )->where( array( 'user_id' => $record_id ) )->find();
		$this->formData = $reception_unit;
		$jurisdiction = M( 'jurisdiction' )->where( array( 'jurisdiction_id' => $reception_unit['jurisdiction_id'] ) )->getField('jurisdiction_name');
		$this->jurisdiction = $jurisdiction;
		$tmp_content=$this->fetch( './Public/html/Content/District/business/enterprise_user_management_page_reception.html' );
		$this->ajaxReturn( $tmp_content );
	}

	
	public function enterprise_user_management_ajaxpost() {
					// 		$A=1;
					// 		$ans=json_encode($A);
					// $this->ajaxReturn( "shibai");
		$munit=M( 'user' );
		$userid=I( 'post.user_id' );
		$type=I( 'post.usertype' );
		if ( I( 'post.action' )=="lock" ) {
			if ( I( 'post.value' )=='0' )
				$data['lock'] = '0';
			else
				$data['lock'] = '1';
			$result = $munit->where( array( 'user_id' =>I( 'post.user_id' ) ) )->save( $data );
			if($result){
				$ans=json_encode("成功");
				$this->ajaxReturn( $ans ,'JSON');
			} else{
				$ans=json_encode("失败");
				$this->ajaxReturn( $ans ,'JSON');
			}
			// $this->show( "lock_ok".I( 'post.user_id' ) );
		}
		else if ( I( 'post.action' )=="verify" ) {
				$result=$munit->where( "user_id='$userid'" )->setField('is_verify', 1 );
				if ($result>0)
				{
					if ($type==5)
						$prefix="production_unit";
					else if ($type==7)
						$prefix="reception_unit";
					else
					{
						$ans=json_encode("成功");
						$this->ajaxReturn( $ans ,'JSON');
					}
					$mx=M($prefix)->where("user_id='$userid'")->getField($prefix.'_id');
					$tablename=$prefix."_".$mx;
					if ($prefix=="production_unit")
					$sql='create table '. $tablename.
					' (
 					id int(11) NOT NULL AUTO_INCREMENT,
 					rfid_id varchar(255) DEFAULT NULL,
  					waste_id int(11) DEFAULT NULL,
  					add_weight double DEFAULT NULL,
  					add_date_time datetime DEFAULT NULL,
  					add_num int(11) DEFAULT NULL,
  					android_num varchar(255) DEFAULT NULL,
  					PRIMARY KEY (id),
  					KEY fk_waste_id_'.$tablename.' (waste_id) USING BTREE,
  					CONSTRAINT fk_waste_id_'.$tablename.' FOREIGN KEY (waste_id) REFERENCES waste (waste_id)
					)';
					else
						$sql='create table '. $tablename.
					' (
 					id int(11) NOT NULL AUTO_INCREMENT,
 					rfid_id varchar(255) DEFAULT NULL,
  					waste_id int(11) DEFAULT NULL,
  					total_weight double DEFAULT NULL,
  					receive_date_time datetime DEFAULT NULL,
  					total_num int(11) DEFAULT NULL,
  					android_num varchar(255) DEFAULT NULL,
  					PRIMARY KEY (id),
  					KEY fk_waste_id_'.$tablename.' (waste_id) USING BTREE,
  					CONSTRAINT fk_waste_id_'.$tablename.' FOREIGN KEY (waste_id) REFERENCES waste (waste_id)
					)';
					$model=new Model();
					$model->execute($sql);
					$num=M('information_schema.tables')->where("table_schema = 'dwms'
							AND table_name = '$tablename'")->count();
					if ($num>0)
					{
						$ans=json_encode("成功");
						$this->ajaxReturn( $ans ,'JSON');
					}
					else
					{
						$ans=json_encode("创建数据库出现错误");
						$this->ajaxReturn( $ans ,'JSON');
					}
				}
				else
				{
					$ans=json_encode("未知错误");
					$this->ajaxReturn( $ans ,'JSON');
				}
			//	$this->show( "verify_ok".I( 'post.user_id' ) );
			}

		else {
			$this->error( "action_error" );
		}

	}


	// 业务办理->待办业务->联单编号绑定
		public function manifest_serial_num_binding(){
		$manifest = M( 'manifest' );
		$condition['jurisdiction_id'] = array('EQ', session( 'jurisdiction_id' ) );
		$condition['manifest_status'] = array('EQ', 11);
		$condition['_string'] = 'manifest_serial_num is null';
		$join = $manifest->join( 'production_unit ON manifest.production_unit_id = production_unit.production_unit_id' )->where( $condition )->select();
		$manifest_json = json_encode( $join );

		$tmp_content=$this->fetch( './Public/html/Content/District/business/manifest_serial_num_binding.html' );
		$tmp_content="<script>manifest = $manifest_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 业务办理->待办业务->联单编号绑定->操作页
	public function manifest_serial_num_binding_page($manifest_id=""){
		$manifest_id_json = json_encode($manifest_id);

		$tmp_content=$this->fetch( './Public/html/Content/District/business/manifest_serial_num_binding_page.html' );
		$tmp_content="<script>manifest_id = $manifest_id_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 业务办理->待办业务->联单编号绑定->提交
	public function manifest_serial_num_binding_form(){
		$manifest = M( 'manifest' );
		$data['manifest_serial_num'] = I( 'post.manifest_serial_num' );
		$result = $manifest->where( array( 'manifest_id' => I('post.manifest_id') ) )->save($data);		
		if($result){
			$this->ajaxReturn(1);
		} else{
			$this->ajaxReturn(0);
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

	public function get_chart()
	{
		$str="";
		$pnum=M('production_unit')->count();
		$tnum=M('transport_unit')->count();
		$rnum=M('reception_unit')->count();
		$manifestnum=M('manifest')->count();
		$recordnum=M('record')->count();
		$devicenum=M('device')->count();
		$vehiclenum=M('vehicle')->count();
		$tong_num=M('rfid')->where("add_method=0")->sum('waste_total');
		$dai_num=M('rfid')->where("add_method=1")->sum('waste_total');

		// $rfid=M('rfid');
		// $join = $rfid->join( 'production_unit ON rfid.production_unit_id = production_unit.production_unit_id' )->select();
		// $statistics=M('rfid')->where('waste_id>0')->getField('waste_id,waste_total');
		$categories=M('rfid')->join('waste ON rfid.waste_id = waste.waste_id')->group('waste_category_code')->getField('waste_category_code',true);
		$rfid = M('rfid');
		$join = $rfid->join('production_unit ON rfid.production_unit_id = production_unit.production_unit_id' )->join('waste ON rfid.waste_id = waste.waste_id')->select();

		// $hw_49 = $rfid->join('production_unit ON rfid.production_unit_id = production_unit.production_unit_id' )->join('waste ON rfid.waste_id = waste.waste_id')->select();
		// $Model = M();
		// $Model->query('SELECT production_unit_id,SUM(waste_total) FROM rfid GROUP BY production_unit_id');
		
		// $hw_49 = $rfid->join('production_unit ON rfid.production_unit_id = production_unit.production_unit_id' )->join('waste ON rfid.waste_id = waste.waste_id')->where( array( 'waste_category_code' => HW49 ) )->sum('waste_total');
		// $hw_48 = $rfid->join('production_unit ON rfid.production_unit_id = production_unit.production_unit_id' )->join('waste ON rfid.waste_id = waste.waste_id')->where( array( 'waste_category_code' => HW48 ) )->sum('waste_total');
		
		$dict=array();
		$count_waste=0;
		$wastelist=M('production_unit')->select();
		foreach ($wastelist as  $value) {
			$type_list=explode(",", $value['production_unit_waste']);
			foreach ($type_list as  $val) {
				if (!array_key_exists($val, $dict))
				{
					$count_waste++;
					$dict[$val]=1;
					$str=$str. $val;
				}
			}
		}
		$result->rfid=$join;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_01=$hw_01;
		// $result->hw_48=$hw_48;
		// $result->hw_49=$hw_49;
		
		$result->categories=$categories;
		$result->statistics=$statistics;
		$result->count_waste=$count_waste;
		$result->str=$wastelist;
		$result->pnum=$pnum;
		$result->tnum=$tnum;
		$result->rnum=$rnum;
		$result->manifestnum=$manifestnum;
		$result->recordnum=$recordnum;
		$result->devicenum=$devicenum;
		$result->vehiclenum=$vehiclenum;
		$result->tong_num=$tong_num;
		$result->dai_num=$dai_num;
		$result=json_encode($result);
		$this->ajaxReturn( $result);
	}

}
?>
