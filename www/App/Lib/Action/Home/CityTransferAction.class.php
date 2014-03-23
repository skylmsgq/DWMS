<?php
/**
 *
 */
class CityTransferAction extends CityCommonAction{
	// -------- 危废转移->侧边栏 --------
	public function transfer_sidebar(){
		layout( './Common/frame' );
		$this->display( './Public/html/Content/City/transfer/transfer_sidebar.html' );
	}

	// 危废转移->转移备案管理->转移备案
	public function transfer_record(){
		$record = M( 'record' );
		$condition['jurisdiction_id'] = array('GT', 1 );
		$condition['record_status'] = array('GT', 0);
		$join = $record->join( 'production_unit ON record.production_unit_id = production_unit.production_unit_id' )->where( $condition )->select();
		$record_json = json_encode( $join );

		$tmp_content=$this->fetch( './Public/html/Content/City/transfer/transfer_record.html' );
		$tmp_content = "<script>record_json = $record_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->转移备案管理->转移备案：详情页
	public function transfer_record_page($record_id=""){
		$record = M( 'record' )->where( array( 'record_id' =>$record_id ) )->find();
		$production_unit = M( 'production_unit' )->where( array( 'production_unit_id' => $record['production_unit_id'] ) )->find();
		$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => $record['transport_unit_id'] ) )->find();
		$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => $record['reception_unit_id'] ) )->find();
		$this->record = $record;
		$this->production_unit = $production_unit;
		$this->transport_unit = $transport_unit;
		$this->reception_unit = $reception_unit;

		$tmp_content=$this->fetch( './Public/html/Content/City/transfer/transfer_record_page.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->转移联单管理->转移联单
	public function transfer_manifest(){
		$manifest = M( 'manifest' );
		$condition['jurisdiction_id'] = array('GT', 1 );
		$condition['_string'] = 'manifest_status>0';
		$transfer_manifest = $manifest->join( 'production_unit ON manifest.production_unit_id = production_unit.production_unit_id' )->where( $condition )->select();
		$transfer_manifest_json = json_encode( $transfer_manifest );

		$tmp_content=$this->fetch( './Public/html/Content/City/transfer/transfer_manifest.html' );
		$tmp_content = "<script>manifest_json = $transfer_manifest_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	//危废转移->转移联单管理->转移联单: 详情页
	public function transfer_manifest_page($manifest_id=""){
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		// $unit = M( 'production_unit' )->where( array( 'production_unit_id' => $manifest['production_unit_id'] ) )->find();
		// $reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => $manifest['reception_unit_id'] ) )->find();
		// $transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => $manifest['transport_unit_id'] ) )->find();
		// $this->manifest = $manifest;
		// $this->rname = $reception_unit['reception_unit_name'];
		// $this->tname = $transport_unit['transport_unit_name'];
		// $this->tcode=$transport_unit['transport_unit_code'];
		// $this->rcode =$reception_unit['reception_unit_code'];
		// $this->unit = $unit;
		$vehicle_num_1 = M( 'vehicle' )->where( array( 'vehicle_id' => $manifest['vehicle_id_1'] ) )->getField('vehicle_num');
		$this->vehicle_num_1 = $vehicle_num_1;

		if($manifest['vehicle_id_2']){
			$vehicle_num_2 = M( 'vehicle' )->where( array( 'vehicle_id' => $manifest['vehicle_id_2'] ) )->getField('vehicle_num');
			$this->vehicle_num_2 = $vehicle_num_2;
		}
		$p_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('production_unit_id');
		$t_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('transport_unit_id');
		$r_id=M('manifest')->where("manifest_id='$manifest_id'")->getField('reception_unit_id');
		$p_name=M('production_unit')->where("production_unit_id='$p_id'")->getField('production_unit_name');
		$t_name=M('transport_unit')->where("transport_unit_id='$t_id'")->getField('transport_unit_name');
		$r_name=M('reception_unit')->where("reception_unit_id='$r_id'")->getField('reception_unit_name');
		$this->p_name=$p_name;
		$this->t_name=$t_name;
		$this->r_name=$r_name;
		$this->manifest	= $manifest;
		// $manifest_id_json = json_encode( $manifest_id );
		// $manifest_status_json = json_encode( $manifest['manifest_status'] );

		$tmp_content=$this->fetch( './Public/html/Content/City/transfer/transfer_manifest_page.html' );
		// $tmp_content = "<script>manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->统计分析->转移去向统计
	public function transfer_direction_statistic(){
		$tmp_content=$this->fetch( './Public/html/Content/City/transfer/transfer_direction_statistic.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->统计分析->转移联单统计
	public function transfer_manifest_statistic(){
		$tmp_content=$this->fetch( './Public/html/Content/City/transfer/transfer_manifest_statistic.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->统计分析->转移专题定制
	public function transfer_topic_customize(){
		$tmp_content=$this->fetch( './Public/html/Content/City/transfer/transfer_topic_customize.html' );
		$this->ajaxReturn( $tmp_content );
	}

}
?>