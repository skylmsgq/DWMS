<?php
/**
 *
 */
class RegisterAction extends Action{
	public function index( $id="" ) {
		$username = M( 'user' )->getField('username',true);
		$enterprise_scale = M( 'enterprise_scale' )->getField('enterprise_scale_name',true);
		$county_code = M( 'county_code' )->where('county_id < 34')->getfield('county_name',true);
		$enterprise_register_type = M( 'enterprise_register_type' )->getField('enterprise_register_type_name',true);
		$waste_code = M( 'waste' )->getField('waste_code',true);
		$waste = M( 'waste' )->select();
		// $tradecode=M('trade_code')->select();
		
		// $this->tradecode=$tradecode;
		// $this->enterprise_scale = $enterprise_scale;
		// $this->county_code = $county_code;
		// $this->enterprise_register_type = $enterprise_register_type;
		$this->waste = $waste;
		$waste_code_json = json_encode($waste_code);
		$username_json = json_encode($username);
		$county_code_json = json_encode($county_code);
		// $tradecode_json = json_encode($tradecode);
		$enterprise_scale_json = json_encode($enterprise_scale);
		$enterprise_register_type_json = json_encode($enterprise_register_type);
		switch ( $id ) {

		case 'production':
			
			$tmp_content = $this->fetch( "./App/Tpl/Home/Register/register_production.html" );
			$tmp_content = "<script>waste_code = $waste_code_json; county_name = $county_code_json;username = $username_json; enterprise_scale = $enterprise_scale_json;enterprise_register_type = $enterprise_register_type_json;</script> $tmp_content";
			$this->show( $tmp_content );
			break;

		case 'transport':
			$tmp_content = $this->fetch( "./App/Tpl/Home/Register/register_transport.html" );
			$tmp_content = "<script>username = $username_json;enterprise_scale = $enterprise_scale_json;enterprise_register_type = $enterprise_register_type_json;county_name = $county_code_json;</script> $tmp_content";
			$this->show( $tmp_content );
			break;

		case 'reception':
			$tmp_content = $this->fetch( "./App/Tpl/Home/Register/register_reception.html" );
			$tmp_content = "<script>enterprise_scale = $enterprise_scale_json;enterprise_register_type = $enterprise_register_type_json;county_name = $county_code_json;username = $username_json;</script> $tmp_content";
			$this->show( $tmp_content );
			break;

		default:
			$this->error( '页面不存在' );
			break;
		}
	}

	public function select_city_name(){
		$county_code = M( 'county_code' )->where( array('county_up_id'=> I('post.id') ) )->select();
		if ($county_code) {
			$city_name_json = json_encode( $county_code );
			$this->ajaxReturn( $city_name_json, 'JSON');
		} else {
			$this->ajaxReturn( "区县代码未找到" );
		}
		
	}

	public function select_county_name(){
		$county_code = M( 'county_code' )->where( array('county_up_id'=> I('post.id') ) )->select();
		if ($county_code) {
			$county_name_json = json_encode( $county_code );
			$this->ajaxReturn( $county_name_json, 'JSON');
		} else {
			$this->ajaxReturn( "区县代码未找到" );
		}
		
	}

	public function select_code_jurisdiction(){
		// $county_code = M( 'county_code' )->where( array('county_id'=> I('post.id') ) )->select();
		$jurisdiction = M( 'jurisdiction' )->where( array('county_name'=> I('post.name') ) )->select();
		// $county_code_json = json_encode( $county_code );
		$jurisdiction_json = json_encode( $jurisdiction );
		// $this->ajaxReturn( $county_code_json,'JSON' );
		$this->ajaxReturn( $jurisdiction_json,'JSON' );

	}

	public function select_code(){
		// $county_code = M( 'county_code' )->where( array('county_id'=> I('post.id') ) )->select();
		$county_code = M( 'county_code' )->where( array('county_name'=> I('post.name') ) )->select();
		// $county_code_json = json_encode( $county_code );
		$code_return=$county_code['county_code'];
		$code_json = json_encode( $county_code );
		// $this->ajaxReturn( $county_code_json,'JSON' );
		$this->ajaxReturn( $code_json,'JSON' );

	}


	public function do_reg( $id='' ) {
		switch ( $id ) {
		case 'production':
			$postData=( I( 'post.' ) );
			$unit= M( 'production_unit' );
			$user=M( 'user' );

			$AccountData["user_type"]=5;
			$AccountData["username"]=$postData["username"];
			$AccountData["password"]=md5( $postData["password"] );
			$AccountData["email"]=$postData["email"];
			$AccountData["phone_num"]=$postData["phone_num"];
			$AccountData["add_time"]=date( 'Y-m-d H:i:s', time() );
			$AccountData["modify_time"]=date( 'Y-m-d H:i:s', time() );
			$AccountData["is_verify"]=0;
			$AccountData["lock"]=0;

			if ( $user_id=$user->add( $AccountData ) ) {
				$unit->create();
				$unit->user_id=$user_id;
				$county_code = M( 'county_code' )->where( array('county_name'=> I('post.name') ) )->select();
				if ( $unit->add() ) {
					$this->display('./Public/html/Content/do_reg/success.html');
				}
				else {
					$user->where( "user_id='$user_id'" )->delete();
					// $this->ajaxReturn( 1 );
					// $this->ajaxReturn(0);
					// $this->error( '账户创建失败:企业信息写入失败', "../../../../../", 5 );
					$this->display('./Public/html/Content/do_reg/fail.html');
				}
			}
			else {
				// $this->ajaxReturn( 1 );
				// $this->ajaxReturn(0);
				// $this->error( '账户创建失败:账户信息写入失败', "../../../../../", 5 );
				$this->display('./Public/html/Content/do_reg/fail.html');
			}
			break;

		case 'transport':

			//$this->success( '运输企业注册成功!',"../../../../",5);
			$postData=( I( 'post.' ) );
			$unit= M( 'transport_unit' );
			$user=M( 'user' );

			$AccountData["user_type"]=6;
			$AccountData["username"]=$postData["username"];
			$AccountData["password"]=md5( $postData["password"] );
			$AccountData["email"]=$postData["email"];
			$AccountData["phone_num"]=$postData["phone_num"];
			$AccountData["add_time"]=date( 'Y-m-d H:i:s', time() );
			$AccountData["modify_time"]=date( 'Y-m-d H:i:s', time() );
			$AccountData["is_verify"]=0;
			$AccountData["lock"]=0;

			if ( $user_id=$user->add( $AccountData ) ) {
				$unit->create();
				$unit->user_id=$user_id;

				if ( $unit->add() ) {
					
					$this->display('./Public/html/Content/do_reg/success.html');
				}
				else {
					$user->where( "user_id='$user_id'" )->delete();
					// $this->error( '账户创建失败:企业信息写入失败', "../../../../../", 5 );
					$this->display('./Public/html/Content/do_reg/fail.html');
				}
			}

			else {
					// $this->error( '账户创建失败:账户信息写入失败', "../../../../../", 5 );
				$this->display('./Public/html/Content/do_reg/fail.html');
			}

			break;

		case 'reception':

			//$this->success( '接受企业注册成功!',"../../../../../",5);
			$postData=( I( 'post.' ) );
			$unit= M( 'reception_unit' );
			$user=M( 'user' );

			$AccountData["user_type"]=7;
			$AccountData["username"]=$postData["username"];
			$AccountData["password"]=md5( $postData["password"] );
			$AccountData["email"]=$postData["email"];
			$AccountData["phone_num"]=$postData["phone_num"];
			$AccountData["add_time"]=date( 'Y-m-d H:i:s', time() );
			$AccountData["modify_time"]=date( 'Y-m-d H:i:s', time() );
			$AccountData["is_verify"]=0;
			$AccountData["lock"]=0;

			if ( $user_id=$user->add( $AccountData ) ) {
				$unit->create();
				$unit->user_id=$user_id;
				if ( $unit->add() ) {
					$this->display('./Public/html/Content/do_reg/success.html');
				}
				else {
					$user->where( "user_id='$user_id'" )->delete();
					// $this->error( '账户创建失败:企业信息写入失败', "../../../../../", 5 );
					$this->display('./Public/html/Content/do_reg/fail.html');
				}
			}

			else {
				// $this->error( '账户创建失败:账户信息写入失败', "../../../../../", 5 );
				$this->display('./Public/html/Content/do_reg/fail.html');
			}
			break;

		default:
			// $this->error( '页面不存在' );
		$this->display('./Public/html/Content/do_reg/fail.html');
			break;
		}
	}
}
?>
