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
		$tmp_content=$this->fetch( './App/Tpl/Home/Common/changepwd.html' );
		$this->ajaxReturn( $tmp_content );
	}
}

?>
