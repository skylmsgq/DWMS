<?php
//区环保局的通用的控制器
class CityCommonAction extends CommonAction{
	//自动执行的方法，判断是否通过登录跳转
	public function _initialize() {
		if ( session( 'user_type' ) != 3 ) {
			$this->redirect( 'Home/Index/index' );
		}
	}
}
?>
