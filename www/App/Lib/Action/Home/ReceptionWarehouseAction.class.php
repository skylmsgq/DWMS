<?php
/**
 *
 */
class ReceptionWarehouseAction extends CommonAction{
// -------- 危废库存->侧边栏 --------
	public function warehouse_sidebar() {
		layout( './Common/frame' );
		$this->display( './Public/html/Content/Reception/warehouse/warehouse_sidebar.html' );
	}

	// 危废库存->危废入库记录
	public function storage_input_record($record_id="") {
		$rfid = M( 'rfid' )->where( array( 'reception_unit_id' => session( 'reception_unit_id' ) ) )->select();
		$rfid_json = json_encode( $rfid );
		$tmp_content=$this->fetch( './Public/html/Content/Reception/warehouse/storage_input_record.html' );
		$tmp_content="<script> record_json=$rfid_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废库存->危废入库记录->详情
	public function storage_input_record_page($record_id="") {
		$reception_unit = "reception_unit_".session( 'reception_unit_id' );
		$waste = M( $reception_unit )->where( array( 'rfid_id' => $record_id ) )->select();
		$rfid_json = json_encode( $waste );
		//$this->waste_data=$rfid_json;
		$tmp_content=$this->fetch( './Public/html/Content/Reception/warehouse/storage_input_record_page.html' );
		$tmp_content="<script> waste_data=$rfid_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废库存->危废在库查询
	public function storage_query() {
		$tmp_content=$this->fetch( './Public/html/Content/Reception/warehouse/storage_query.html' );
		$this->ajaxReturn( $tmp_content );
	}

}
?>