<?php
/**
 *
 */
class ProductionWarehouseAction extends ProductionCommonAction{
	// -------- 危废库存->侧边栏 --------
	public function warehouse_sidebar() {
		layout( './Common/frame' );
		$this->display( './Public/html/Content/Production/warehouse/warehouse_sidebar.html' );
	}

	// 危废库存->危废入库管理
	public function storage_input_management() {
		$rfid = M( 'rfid' )->where( array( 'production_unit_id' => session( 'production_unit_id' ) ) )->select();
		$rfid_json = json_encode( $rfid );
		$wasteid=array();
		foreach ($rfid as  $value) {
			$id=$value['waste_id'];
			$wasteid[]=M('waste')->where("waste_id='$id'")->getField('waste_code');
		}
		$waste_json=json_encode($wasteid);
		$tmp_content=$this->fetch( './Public/html/Content/Production/warehouse/storage_input_management.html' );
		$tmp_content="<script> record_json=$rfid_json; waste_json=$waste_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废库存->危废入库管理->详情
	public function storage_input_management_page($record_id="",$waste_code="") {
		$production_unit = "production_unit_".session( 'production_unit_id' );
		$waste = M( $production_unit )->where( array( 'rfid_id' => $record_id ) )->select();
		$rfid_json = json_encode( $waste );
		$waste_code_json = json_encode($waste_code);

		$tmp_content=$this->fetch( './Public/html/Content/Production/warehouse/storage_input_management_page.html' );
		$tmp_content="<script> waste_data=$rfid_json;waste_code = $waste_code_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// // 危废库存->危废在库查询
	// public function storage_query() {
	// 	$tmp_content=$this->fetch( './Public/html/Content/Production/warehouse/storage_query.html' );
	// 	$this->ajaxReturn( $tmp_content );
	// }

	// // 危废库存->危废出库管理
	// public function storage_output_management() {
	// 	$tmp_content=$this->fetch( './Public/html/Content/Production/warehouse/storage_output_management.html' );
	// 	$this->ajaxReturn( $tmp_content );
	// }
}
?>
