<?php
/**
 *
 */
class TransportBasicAction extends TransportCommonAction{
// -------- 企业基本信息->侧边栏 --------
	public function basic_sidebar(){
		layout( './Common/frame' );
		$this->display( './Public/html/Content/Transport/basic/basic_sidebar.html' );
	}

	// 企业基本信息->企业基本信息
	public function transport_basic_information(){
		$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => session( 'transport_unit_id' ) ) )->find();
		$jurisdiction_name = M('jurisdiction')->where( array('jurisdiction_id' => $transport_unit['jurisdiction_id'] ) )->getField('jurisdiction_name');
		$this->jurisdiction_name = $jurisdiction_name;

		$this->unit = $transport_unit;
		$transport_unit = json_encode(session( 'transport_unit_id' ));

		$tmp_content=$this->fetch( './Public/html/Content/Transport/basic/transport_basic_information.html' );
		$tmp_content = "<script>transport_unit_json = $transport_unit;console.log(transport_unit_json)</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 企业基本信息->基本信息变更
	public function transport_change_information(){
		$transport_unit = M( 'transport_unit' )->where( array( 'transport_unit_id' => session( 'transport_unit_id' ) ) )->find();
		$jurisdiction_name = M('jurisdiction')->where( array('jurisdiction_id' => $transport_unit['jurisdiction_id'] ) )->getField('jurisdiction_name');
		$this->jurisdiction_name = $jurisdiction_name;

		$this->unit = $transport_unit;
		$tmp_content=$this->fetch( './Public/html/Content/Transport/basic/transport_change_information.html' );
		$this->ajaxReturn( $tmp_content );
	}
}
?>