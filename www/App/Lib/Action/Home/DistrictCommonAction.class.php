<?php
//区环保局的通用的控制器
class DistrictCommonAction extends CommonAction{
	//自动执行的方法，判断是否通过登录跳转
	public function _initialize() {
		if ( session( 'user_type' ) != 4 ) {
			$this->redirect( 'Home/Index/index' );
		}
	}
}
?>
