<?php
/**
 *
 */
class ReceptionBasicAction extends CommonAction{
// -------- 企业基本信息->侧边栏 --------
	public function basic_sidebar(){
		layout( './Common/frame' );
		$this->display( './Public/html/Content/Reception/basic/basic_sidebar.html' );
	}

	// 企业基本信息->企业基本信息
	public function reception_basic_information(){


		$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => session( 'reception_unit_id' ) ) )->find();
		$this->unit = $reception_unit;

		$jurisdiction = M('jurisdiction')->where( array( 'jurisdiction_id' => $reception_unit['jurisdiction_id'] ) )->find();
		$this->jurisdiction_name = $jurisdiction['jurisdiction_name'];

		$tmp_content=$this->fetch( './Public/html/Content/Reception/basic/reception_basic_information.html' );
		$this->ajaxReturn( $tmp_content );

	}
	// 企业基本信息->基本信息变更
	public function reception_change_information(){
		$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => session( 'reception_unit_id' ) ) )->find();
		$this->unit = $reception_unit;

		$jurisdiction = M('jurisdiction')->where( array( 'jurisdiction_id' => $reception_unit['jurisdiction_id'] ) )->find();
		$this->jurisdiction_name = $jurisdiction['jurisdiction_name'];

		$tmp_content=$this->fetch( './Public/html/Content/Reception/basic/reception_change_information.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 企业基本信息->自行处置设备信息
	public function device_information(){
		$tmp_content=$this->fetch( './Public/html/Content/Reception/basic/device_information.html' );
		$this->ajaxReturn( $tmp_content );
	}

	//企业基本信息->存储场所
	public function storage_place(){
		$tmp_content=$this->fetch( './Public/html/Content/Reception/basic/storage_place.html' );
		$this->ajaxReturn( $tmp_content );
	}
}
?>