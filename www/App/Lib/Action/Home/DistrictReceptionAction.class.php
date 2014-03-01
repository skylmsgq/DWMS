<?php
/**
 *
 */
class DistrictReceptionAction extends DistrictCommonAction{
	// -------- 危废处置单位->侧边栏 --------
	public function reception_sidebar(){
		layout( './Common/frame' );
		$this->display( './Public/html/Content/District/reception/reception_sidebar.html' );
	}

	// 危废处置单位->企业基本信息->企业基本信息
	public function reception_basic_information(){
		$reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => session( 'jurisdiction_id' ) ) )->getField( 'reception_unit_id,reception_unit_name,reception_unit_address,reception_unit_county' );
		$reception_unit_json = json_encode( $reception_unit );
		$tmp_content=$this->fetch( './Public/html/Content/District/reception/reception_basic_information.html' );
		$tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废处置单位->企业基本信息->企业基本信息：详情
	public function reception_basic_information_page($record_id=""){
		$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => $record_id ) )->find();
		$this->unit = $reception_unit;
		$tmp_content=$this->fetch( './Public/html/Content/District/reception/reception_basic_information_page.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废处置单位->危废接受台账->危废接受统计
	public function waste_reception_account_monthly_statistics(){
		$reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' =>session('jurisdiction_id') ) )->select();
		$reception_unit_json = json_encode($reception_unit);
		$tmp_content = $this->fetch( './Public/html/Content/District/reception/waste_reception_account_monthly_statistics.html' );
		$tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废处置单位->危废接受台账->危废接受统计->详情
	public function waste_reception_account_monthly_statistics_page($reception_unit_id=""){
		$rfid = M('rfid');
		$condition['reception_unit_id'] = array('EQ',$reception_unit_id);
		$join = $rfid->join('waste ON rfid.waste_id = waste.waste_id')->where($condition)->select();
		$rfid_json = json_encode($join);
		$tmp_content = $this->fetch( './Public/html/Content/District/reception/waste_reception_ccount_monthly_statistics_page.html' );
		$tmp_content = "<script>rfid_json = $rfid_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废处置单位->RFID手持端->RFID手持端绑定
	public function reception_rfid_hand_equipment(){
		$tmp_content=$this->fetch( './Public/html/Content/District/reception/reception_rfid_hand_equipment.html' );
		$this->ajaxReturn( $tmp_content );
	}

}
?>