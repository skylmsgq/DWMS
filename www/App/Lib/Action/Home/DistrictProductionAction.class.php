<?php
/**
 *
 */
class DistrictProductionAction extends DistrictCommonAction{
	// -------- 危废产生单位->侧边栏 --------
	public function production_sidebar(){
		layout( './Common/frame' );
		$this->display( './Public/html/Content/District/production/production_sidebar.html' );
	}

	// 危废产生单位->企业基本信息->企业基本信息
	public function production_basic_information(){
		$production_unit = M( 'production_unit' )->where( array( 'jurisdiction_id' => session( 'jurisdiction_id' ) ) )->getField('production_unit_id,production_unit_name,production_unit_address,waste_location_county');
		$production_unit_json = json_encode( $production_unit );
		$tmp_content = $this->fetch('./Public/html/Content/District/production/production_basic_information.html');
		$tmp_content = "<script>production_unit_json = $production_unit_json;</script> $tmp_content";
		$this->ajaxReturn($tmp_content);
	}

	// 危废产生单位->企业基本信息->企业基本信息：企业详细信息
	public function production_basic_information_page($record_id=""){
		$production_unit = M( 'production_unit' )->where( array( 'production_unit_id' => $record_id ) )->find();
		$this->unit = $production_unit;
		$tmp_content = $this->fetch( './Public/html/Content/District/production/production_basic_information_page.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废产生单位->危险废物台账->危废产生统计
	public function waste_account_monthly_statistics(){
		$production_unit = M( 'production_unit' )->where( array( 'jurisdiction_id' =>session('jurisdiction_id') ) )->select();
		$production_unit_json = json_encode($production_unit);
		$tmp_content = $this->fetch( './Public/html/Content/District/production/waste_account_monthly_statistics.html' );
		$tmp_content = "<script>production_unit_json = $production_unit_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废产生单位->危险废物台账->危废产生统计->详情
	public function waste_account_monthly_statistics_page($production_unit_id=""){
		$rfid = M('rfid');
		$condition['production_unit_id'] = array('EQ',$production_unit_id);
		$join = $rfid->join('waste_category ON rfid.waste_category_id = waste_category.waste_category_id')->where($condition)->select();
		$rfid_json = json_encode($join);
		$tmp_content = $this->fetch( './Public/html/Content/District/production/waste_account_monthly_statistics_page.html' );
		$tmp_content = "<script>rfid_json = $rfid_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废产生单位->RFID手持端->RFID手持端绑定
	public function production_rfid_hand_equipment(){
		$tmp_content=$this->fetch( './Public/html/Content/District/production/production_rfid_hand_equipment.html' );
		$this->ajaxReturn( $tmp_content );
	}

	//扩展功能->扩展功能
	public function expandfunction(){
		$tmp_content=$this->fetch( './Public/html/Content/Expand/expandfunction.html' );
		$this->ajaxReturn( $tmp_content );
	}
}

?>