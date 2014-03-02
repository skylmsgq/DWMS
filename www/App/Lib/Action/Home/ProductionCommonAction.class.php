<?php
//生产单位的通用的控制器
class ProductionCommonAction extends CommonAction{
	//自动执行的方法，判断是否通过登录跳转
	public function _initialize() {
		if ( session( 'user_type' ) != 5 ) {
			$this->redirect( 'Home/Index/index' );
		}
	}
}
?>
