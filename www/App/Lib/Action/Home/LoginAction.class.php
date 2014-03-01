<?php
/**
 * 登录后的主页控制器
 */
class LoginAction extends CommonAction{
	public function index() {
		if ( session( 'user_type' ) == 0 ) {
			$this->display();
		}else {
			$this->redirect( 'Home/Index/index' );
		}
	}

	public function logout() {
		$last_login = array(
			'user_id' => session( 'user_id' ),
			'last_login_time' => session( 'current_login_time' ),
			'last_login_ip' => session( 'current_login_ip' ),
		);
		M( 'user' )->save( $last_login );

		session_unset();
		session_destroy();
		$this->redirect( 'Home/Index/index' );
	}
	public function changepwd() {
		$old_pass=I('post.old_pass');
		$new_pass=I('post.new_pass');
		$userid=I('post.user_id');	
		$user=M('user')	;
		$old_pass_real=$user->where("user_id=$userid")->getField('password');
		if ($old_pass!=$old_pass_real)
			$this->ajaxReturn( 0 );	//wrong password
		else
		{
			$result=$user->where("user_id=$userid")->setField('password', $new_pass);
			if ($result)
				{
				$modifytime=date( 'Y-m-d H:i:s', time() );
				$user->where("user_id=$userid")->setField('modify_time', $modifytime);
				$this->ajaxReturn( 1 );// right
				}
			else	
				$this->ajaxReturn( 2 );// unable to change password
		}	
	}
	public function show_page()
	{
		switch ( session('user_type') ) {
			case 4:
				$unit_name = M('agency')->where( array( 'user_id' => session( 'user_id' ) ) )->getField('agency_name');
				$this->unit_name = $unit_name;
				break;
			case 5:
				$unit_name = M('production_unit')->where( array( 'user_id' => session( 'user_id' ) ) )->getField('production_unit_name');
				$this->unit_name = $unit_name;
				break;
			case 6:
				$unit_name = M('transport_unit')->where( array( 'user_id' => session( 'user_id' ) ) )->getField('transport_unit_name');
				$this->unit_name = $unit_name;
				break;
			case 7:
				$unit_name = M('reception_unit')->where( array( 'user_id' => session( 'user_id' ) ) )->getField('reception_unit_name');
				$this->unit_name = $unit_name;
				break;
			default :
				error('无法读取用户信息');
				break;
		}
		$this->unit_name = $unit_name;
		// $unit_name_json = json_encode($unit_name);
		$tmp_content=$this->fetch( './App/Tpl/Home/Common/changepwd.html' );
		// $tmp_content="<script>unit_name = $unit_name_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}
}

?>
