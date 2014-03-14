<?php
/**
 *
 */
class ReceptionWarehouseAction extends ReceptionCommonAction{
// -------- 危废库存->侧边栏 --------
	public function warehouse_sidebar() {
		layout( './Common/frame' );
		$this->display( './Public/html/Content/Reception/warehouse/warehouse_sidebar.html' );
	}

	// 危废库存->危废库存管理
	public function storage_input_management() {
		$rfid = M( 'rfid' );
		$condition['reception_unit_id'] = array('EQ', session( 'reception_unit_id' ) );
		$condition['rfid_status'] = array('EQ', 2);
		$join = $rfid->join('waste_category ON rfid.waste_category_id = waste_category.waste_category_id')->where($condition)->select();
		$rfid_json = json_encode($join);

		// $rfid = M( 'rfid' )->where( array( 'reception_unit_id' => session( 'reception_unit_id' ),'rfid_status' => 2 ) )->select();
		// $rfid_json = json_encode( $rfid );

		$pdname=array();
		foreach ($join as $value) {
		$pdu=$value['production_unit_id'];
		//need to check later
		$pdname[]=M('production_unit')->where("production_unit_id='$pdu'")->getField('production_unit_name');
		//$pdname[]=$pdu;
		}
		$pd_json = json_encode( $pdname );
		$tmp_content=$this->fetch( './Public/html/Content/Reception/warehouse/storage_input_management.html' );
		$tmp_content="<script> record_json=$rfid_json; production_unit_name=$pd_json;</script> $tmp_content";

		$this->ajaxReturn( $tmp_content );
	}

	// 危废库存->危废库存管理->详情
	// public function storage_input_management_page($record_id="") {
	// 	$reception_unit = "reception_unit_".session( 'reception_unit_id' );
	// 	$waste = M( $reception_unit )->where( array( 'rfid_id' => $record_id ) )->select();
	// 	$rfid_json = json_encode( $waste );
	// 	//$this->waste_data=$rfid_json;
	// 	$tmp_content=$this->fetch( './Public/html/Content/Reception/warehouse/storage_input_management_page.html' );
	// 	$tmp_content="<script> waste_data=$rfid_json; </script> $tmp_content";
	// 	$this->ajaxReturn( $tmp_content );
	// }

	// 危废库存->危废在库查询
	// public function storage_query() {
	// 	$tmp_content=$this->fetch( './Public/html/Content/Reception/warehouse/storage_query.html' );
	// 	$this->ajaxReturn( $tmp_content );
	// }

}
?>