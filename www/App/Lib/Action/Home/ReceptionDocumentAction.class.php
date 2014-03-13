<?php
/**
 *
 */
class ReceptionDocumentAction extends ReceptionCommonAction{
	// -------- 文档资料->侧边栏 --------
	public function document_sidebar() {
		layout( './Common/frame' );
		$this->display( './Public/html/Content/Reception/document/document_sidebar.html' );
	}

	// 文档资料->官方文档->法规政策
	public function law() {
		$condition['document_type'] = 0;
		$condition['document_status'] = 0;
		$condition['jurisdiction_id'] = session( 'jurisdiction_id' );
		$document = M( 'document' )->where( $condition )->select();
		// if ( $document ) {
			$document_json = json_encode( $document );
			$tmp_content=$this->fetch( './Public/html/Content/Reception/document/law.html' );
			$tmp_content = "<script> document_json=$document_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		//} else {
			$this->ajaxReturn( '加载页面失败，请重新点击侧边栏加载页面。' );
		//}
	}

	// 文档资料->官方文档->用户手册
	public function manual() {
		$condition['document_type'] = 1;
		$condition['document_status'] = 0;
		$condition['jurisdiction_id'] = session( 'jurisdiction_id' );
		$document = M( 'document' )->where( $condition )->select();
		// if ( $document ) {
			$document_json = json_encode( $document );
			$tmp_content=$this->fetch( './Public/html/Content/Reception/document/manual.html' );
			$tmp_content = "<script> document_json=$document_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		//} else {
			$this->ajaxReturn( '加载页面失败，请重新点击侧边栏加载页面。' );
		//}
	}

	// 文档资料->官方文档->结果公告
	public function announcement() {
		$condition['document_type'] = 2;
		$condition['document_status'] = 0;
		$condition['jurisdiction_id'] = session( 'jurisdiction_id' );
		$document = M( 'document' )->where( $condition )->select();
		// if ( $document ) {
			$document_json = json_encode( $document );
			$tmp_content=$this->fetch( './Public/html/Content/Reception/document/announcement.html' );
			$tmp_content = "<script> document_json=$document_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		//} else {
			$this->ajaxReturn( '加载页面失败，请重新点击侧边栏加载页面。' );
		//}
	}	
}
?>