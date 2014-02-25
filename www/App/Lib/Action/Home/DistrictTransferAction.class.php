<?php
/**
 *
 */
class DistrictTransferAction extends CommonAction{
	// -------- 危废转移->侧边栏 --------
	public function transfer_sidebar(){
		layout( './Common/frame' );
		$this->display( './Public/html/Content/District/transfer/transfer_sidebar.html' );
	}

	// 危废转移->转移备案管理->转移备案
	public function transfer_record(){
		$record = M( 'record' );
		$condition['jurisdiction_id'] = array('EQ', session( 'jurisdiction_id' ) );
		$condition['record_status'] = array('GT', 0);
		$join = $record->join( 'production_unit ON record.production_unit_id = production_unit.production_unit_id' )->where( $condition )->select();
		$record_json = json_encode( $join );

		$tmp_content=$this->fetch( './Public/html/Content/District/transfer/transfer_record.html' );
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

		$tmp_content=$this->fetch( './Public/html/Content/District/transfer/transfer_record_page.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->转移联单管理->生产单位转移联单
	public function production_transfer_manifest(){
		$manifest = M( 'manifest' );
		$condition['jurisdiction_id'] = array('EQ', session( 'jurisdiction_id' ) );
		$condition['_string'] = 'manifest_status=1 or manifest_status=4 or manifest_status=5';
		$production_transfer_manifest = $manifest->join( 'production_unit ON manifest.production_unit_id = production_unit.production_unit_id' )->where( $condition )->select();
		$production_transfer_manifest_json = json_encode( $production_transfer_manifest );

		$tmp_content=$this->fetch( './Public/html/Content/District/transfer/production_transfer_manifest.html' );
		$tmp_content = "<script>manifest_json = $production_transfer_manifest_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	//危废转移->转移联单管理->生产单位转移联单: 详情页
	public function production_transfer_manifest_page($manifest_id=""){
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$unit = M( 'production_unit' )->where( array( 'production_unit_id' => $manifest['production_unit_id'] ) )->find();
		$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => $manifest['reception_unit_id'] ) )->find();
		$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => $manifest['transport_unit_id'] ) )->find();
		$this->manifest = $manifest;
		$this->rname = $reception_unit['reception_unit_name'];
		$this->tname = $transport_unit['transport_unit_name'];
		$this->tcode=$transport_unit['transport_unit_code'];
		$this->rcode =$reception_unit['reception_unit_code'];
		$this->unit = $unit;
		// $manifest_id_json = json_encode( $manifest_id );
		// $manifest_status_json = json_encode( $manifest['manifest_status'] );

		$tmp_content=$this->fetch( './Public/html/Content/District/transfer/production_transfer_manifest_page.html' );
		// $tmp_content = "<script>manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->转移联单管理->运输单位转移联单
	public function transport_transfer_manifest(){
		// $transport_transfer_manifest = M( 'manifest' )->where( 'manifest_status=2' )->getField( 'manifest_id,manifest_num,manifest_add_time,manifest_status' );
		// $transport_transfer_manifest_json = json_encode( $transport_transfer_manifest );

		$manifest = M( 'manifest' );
		$condition['jurisdiction_id'] = array('EQ', session( 'jurisdiction_id' ) );
		$condition['_string'] = 'manifest_status=2';
		$transport_transfer_manifest = $manifest->join( 'transport_unit ON manifest.transport_unit_id = transport_unit.transport_unit_id' )->where( $condition )->select();
		$transport_transfer_manifest_json = json_encode( $transport_transfer_manifest );

		// $unit_name = M( 'transport_unit' )->getField( 'transport_unit_name' );
		// $unit_json = json_encode( $unit_name );

		$tmp_content=$this->fetch( './Public/html/Content/District/transfer/transport_transfer_manifest.html' );
		$tmp_content = "<script>manifest_json = $transport_transfer_manifest_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}
	//危废转移->转移联单管理->运输单位转移联单：详情页
	public function transport_transfer_manifest_page($manifest_id=""){
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => $manifest['transport_unit_id'] ) )->find();
		$this->manifest = $manifest;
		$this->unit = $transport_unit;
		$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => $manifest['reception_unit_id'] ) )->find();
		$production_unit = M( 'production_unit' )->where( array( 'production_unit_id' => $manifest['production_unit_id'] ) )->find();
		$this->rname = $reception_unit['reception_unit_name'];
		$this->pname = $production_unit['production_unit_name'];
		$this->pcode=$production_unit['production_unit_code'];
		$this->rcode =$reception_unit['reception_unit_code'];
		// $manifest_id_json = json_encode( $manifest_id );
		// $manifest_status_json = json_encode( $manifest['manifest_status'] );

		$tmp_content=$this->fetch( './Public/html/Content/District/transfer/transport_transfer_manifest_page.html' );
		// $tmp_content = "<script>manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->转移联单管理->接受单位转移联单
	public function reception_transfer_manifest(){
		// $reception_transfer_manifest = M( 'manifest' )->where( 'manifest_status=3 or manifest_status=6 manifest_status=7 manifest_status=8 manifest_status=9' )->getField( 'manifest_id,manifest_num,manifest_add_time,manifest_status' );
		// $reception_transfer_manifest_json = json_encode( $reception_transfer_manifest );
		$manifest = M( 'manifest' );
		$condition['jurisdiction_id'] = array('EQ', session( 'jurisdiction_id' ) );
		$condition['_string'] = 'manifest_status=3 or manifest_status=6 manifest_status=7 manifest_status=8 manifest_status=9';
		$reception_transfer_manifest = $manifest->join( 'reception_unit ON manifest.reception_unit_id = reception_unit.reception_unit_id' )->where( $condition )->select();
		$reception_transfer_manifest_json = json_encode( $reception_transfer_manifest );

		// $unit_name = M( 'reception_unit' )->getField( 'reception_unit_name' );
		// $unit_json = json_encode( $unit_name );

		$tmp_content=$this->fetch( './Public/html/Content/District/transfer/reception_transfer_manifest.html' );
		$tmp_content = "<script>manifest_json = $reception_transfer_manifest_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->转移联单管理->接受单位转移联单: 详情页
	public function reception_transfer_manifest_page($manifest_id=""){
		$manifest = M( 'manifest' )->where( array( 'manifest_id' =>$manifest_id ) )->find();
		$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => $manifest['reception_unit_id'] ) )->find();
		$this->manifest = $manifest;
		$this->unit = $reception_unit;	
		$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => $manifest['transport_unit_id'] ) )->find();
		$production_unit = M( 'production_unit' )->where( array( 'production_unit_id' => $manifest['production_unit_id'] ) )->find();
		$this->pname = $production_unit['production_unit_name'];
		$this->pcode=$production_unit['production_unit_code'];
		$this->tname = $transport_unit['transport_unit_name'];
		$this->tcode=$transport_unit['transport_unit_code'];
		
		// $manifest_id_json = json_encode( $manifest_id );
		// $manifest_status_json = json_encode( $manifest['manifest_status'] );

		$tmp_content=$this->fetch( './Public/html/Content/District/transfer/reception_transfer_manifest_page.html' );
		// $tmp_content = "<script>manifest_id_json = $manifest_id_json; manifest_status_json = $manifest_status_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->统计分析->转移去向统计
	public function transfer_direction_statistic(){
		$tmp_content=$this->fetch( './Public/html/Content/District/transfer/transfer_direction_statistic.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->统计分析->转移联单统计
	public function transfer_manifest_statistic(){
		$tmp_content=$this->fetch( './Public/html/Content/District/transfer/transfer_manifest_statistic.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->统计分析->转移专题定制
	public function transfer_topic_customize(){
		$tmp_content=$this->fetch( './Public/html/Content/District/transfer/transfer_topic_customize.html' );
		$this->ajaxReturn( $tmp_content );
	}

}
?>