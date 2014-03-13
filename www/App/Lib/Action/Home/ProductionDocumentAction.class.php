<?php
/**
 *
 */
class ProductionDocumentAction extends ProductionCommonAction{
	// -------- 文档资料->侧边栏 --------
	public function document_sidebar() {
		layout( './Common/frame' );
		$this->display( './Public/html/Content/Production/document/document_sidebar.html' );
	}

	// 文档资料->官方文档->法规政策
	public function law() {
		$condition['document_type'] = 0;
		$condition['document_status'] = 0;
		$condition['jurisdiction_id'] = session( 'jurisdiction_id' );
		$document = M( 'document' )->where( $condition )->select();
		// if ( $document ) {
			$document_json = json_encode( $document );
			$tmp_content=$this->fetch( './Public/html/Content/Production/document/law.html' );
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
			$tmp_content=$this->fetch( './Public/html/Content/Production/document/manual.html' );
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
			$tmp_content=$this->fetch( './Public/html/Content/Production/document/announcement.html' );
			$tmp_content = "<script> document_json=$document_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		//} else {
			$this->ajaxReturn( '加载页面失败，请重新点击侧边栏加载页面。' );
		//}
	}

	// 文档资料->企业文档->环评书上传
	public function upload_evaluate(){
		$condition['document_status'] = 0;
		$condition['production_unit_id'] = session( 'production_unit_id' );
		$document = M( 'evaluate_document' )->where( $condition )->select();
		$document_json = json_encode( $document );
		$tmp_content=$this->fetch( './Public/html/Content/Production/document/evaluate.html' );
		$tmp_content = "<script> document_json=$document_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 文档资料->企业文档->环评书上传：接收上传的环评书
	public function upload_evaluate_form(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile(); // 实例化上传类
    	$upload->maxSize = 10 * 1024 * 1024; // 设置附件上传大小，10M
    	$upload->savePath =  './Evaluate/'; // 设置附件上传目录
    	// $upload->saveRule = 'time'; // 采用时间戳命名
    	$upload->saveRule = ''; // 设置命名规范为空，保持上传的文件名不变，相同的文件名上传后被覆盖
    	$upload->allowExts  = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'); // 允许上传的文件后缀（留空为不限制）
    	// $upload->allowTypes = array('doc', 'pdf', 'jpg'); // 允许上传的文件类型（留空为不限制）
    	$upload->uploadReplace = true;

    	if( $upload->upload() ) { // 上传成功
        	$info = $upload->getUploadFileInfo(); // 取得成功上传的文件信息
        	$document = M( 'evaluate_document' );
        	for ( $idx = 0; $idx < count( $info ); ++$idx ) {
				$data['form_name'] = $info[$idx]['key'];
        		$data['document_save_path'] = $info[$idx]['savepath'];
        		$data['document_original_name'] = $info[$idx]['name'];
        		$data['document_save_name'] = $info[$idx]['savename'];
        		$data['document_size'] = $info[$idx]['size'];
        		$data['document_mime_type'] = $info[$idx]['type'];
        		$data['document_suffix_type'] = $info[$idx]['extension'];
        		$data['document_hash_string'] = $info[$idx]['hash'];
        		$time = date( 'Y-m-d H:i:s', time() );
        		$data['document_upload_time'] = $time;
        		$data['document_status'] = 0;
        		$data['production_unit_id'] = session( 'production_unit_id' );
        		$document->add( $data );
        	}
        	// $data = htmlspecialchars_decode( $data );
        	$this->ajaxReturn( $data, 'success', 1 );
    	}else{ // 上传错误提示错误信息
        	$this->ajaxReturn( $upload->getErrorMsg(), 'fail', 0 );
    	}
	}

	// 文档资料->企业文档->环评书上传：删除确认页
	public function upload_evaluate_delete($record_id=""){
		$document = M( 'evaluate_document' )->where( array( 'evaluate_document_id' => $record_id ) )->find();
		if ( $document ) {
			$this->document = $document;
			$document_json = json_encode( $document );
			$tmp_content=$this->fetch( './Public/html/Content/Production/document/upload_evaluate_delete.html' );
			$tmp_content = "<script> document_json=$document_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( '删除该文档失败，请重新操作。' );
		}
	}

	// 文档资料->企业文档->环评书上传：删除
	public function upload_evaluate_deleted($record_id="") {
		// $condition['document_id'] = array( 'EQ', I( 'post.document_id' ) );
		$data['evaluate_document_id'] = $record_id;
		$time = date( 'Y-m-d H:i:s', time() );
		$data['document_delete_time'] = $time;
		$data['document_status'] = 1;
		$result = M( 'evaluate_document' )->save( $data );
		if ( $result ) {
			$this->ajaxReturn( 'success' );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}

	// 文档资料->企业文档->管理计划备案申请表上传
	public function upload_plan(){
		$condition['document_status'] = 0;
		$condition['production_unit_id'] = session( 'production_unit_id' );
		$document = M( 'plan_document' )->where( $condition )->select();
		$document_json = json_encode( $document );
		$tmp_content=$this->fetch( './Public/html/Content/Production/document/plan.html' );
		$tmp_content = "<script> document_json=$document_json; </script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 文档资料->企业文档->管理计划备案申请表上传：接收上传的管理计划备案申请表
	public function upload_plan_form(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile(); // 实例化上传类
    	$upload->maxSize = 10 * 1024 * 1024; // 设置附件上传大小，10M
    	$upload->savePath =  './Plan/'; // 设置附件上传目录
    	// $upload->saveRule = 'time'; // 采用时间戳命名
    	$upload->saveRule = ''; // 设置命名规范为空，保持上传的文件名不变，相同的文件名上传后被覆盖
    	$upload->allowExts  = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'); // 允许上传的文件后缀（留空为不限制）
    	// $upload->allowTypes = array('doc', 'pdf', 'jpg'); // 允许上传的文件类型（留空为不限制）
    	$upload->uploadReplace = true;

    	if( $upload->upload() ) { // 上传成功
        	$info = $upload->getUploadFileInfo(); // 取得成功上传的文件信息
        	$document = M( 'plan_document' );
        	for ( $idx = 0; $idx < count( $info ); ++$idx ) {
				$data['form_name'] = $info[$idx]['key'];
        		$data['document_save_path'] = $info[$idx]['savepath'];
        		$data['document_original_name'] = $info[$idx]['name'];
        		$data['document_save_name'] = $info[$idx]['savename'];
        		$data['document_size'] = $info[$idx]['size'];
        		$data['document_mime_type'] = $info[$idx]['type'];
        		$data['document_suffix_type'] = $info[$idx]['extension'];
        		$data['document_hash_string'] = $info[$idx]['hash'];
        		$time = date( 'Y-m-d H:i:s', time() );
        		$data['document_upload_time'] = $time;
        		$data['document_status'] = 0;
        		$data['production_unit_id'] = session( 'production_unit_id' );
        		$document->add( $data );
        	}
        	// $data = htmlspecialchars_decode( $data );
        	$this->ajaxReturn( $data, 'success', 1 );
    	}else{ // 上传错误提示错误信息
        	$this->ajaxReturn( $upload->getErrorMsg(), 'fail', 0 );
    	}
	}

	// 文档资料->企业文档->管理计划备案申请表上传：删除确认页
	public function upload_plan_delete($record_id=""){
		$document = M( 'plan_document' )->where( array( 'plan_document_id' => $record_id ) )->find();
		if ( $document ) {
			$this->document = $document;
			$document_json = json_encode( $document );
			$tmp_content=$this->fetch( './Public/html/Content/Production/document/upload_plan_delete.html' );
			$tmp_content = "<script> document_json=$document_json; </script> $tmp_content";
			$this->ajaxReturn( $tmp_content );
		} else {
			$this->ajaxReturn( '删除该文档失败，请重新操作。' );
		}
	}

	// 文档资料->企业文档->管理计划备案申请表上传：删除
	public function upload_plan_deleted($record_id="") {
		// $condition['document_id'] = array( 'EQ', I( 'post.document_id' ) );
		$data['plan_document_id'] = $record_id;
		$time = date( 'Y-m-d H:i:s', time() );
		$data['document_delete_time'] = $time;
		$data['document_status'] = 1;
		$result = M( 'plan_document' )->save( $data );
		if ( $result ) {
			$this->ajaxReturn( 'success' );
		} else {
			$this->ajaxReturn( 'fail' );
		}
	}
}
?>