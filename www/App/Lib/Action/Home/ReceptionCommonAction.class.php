<?php
//接受单位的通用的控制器
class ReceptionCommonAction extends CommonAction{
	//自动执行的方法，判断是否通过登录跳转
	public function _initialize() {
		if ( session( 'user_type' ) != 7 ) {
			$this->redirect( 'Home/Index/index' );
		}
	}
}
?>
