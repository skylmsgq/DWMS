<?php
/**
 *
 */
class RegisterAction extends Action{
	public function index( $id="" ) {
		$enterprise_scale = M( 'enterprise_scale' )->select();
		$county_code = M( 'county_code' )->where('county_id < 34')->select();
		$enterprise_register_type = M( 'enterprise_register_type' )->select();
		$waste = M( 'waste' )->select();


		$this->enterprise_scale = $enterprise_scale;
		$this->county_code = $county_code;
		$this->enterprise_register_type = $enterprise_register_type;
		$this->waste = $waste;
		switch ( $id ) {

		case 'production':
			
			$tmp_content = $this->fetch( "./App/Tpl/Home/Register/register_production.html" );
			$this->show( $tmp_content );
			break;

		case 'transport':
			$tmp_content = $this->fetch( "./App/Tpl/Home/Register/register_transport.html" );
			$this->show( $tmp_content );
			break;

		case 'reception':
			$tmp_content = $this->fetch( "./App/Tpl/Home/Register/register_reception.html" );
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

				if ( $unit->add() ) {
					$this->success( '生产企业注册成功!', "../../../../../", 5 );
				}
				else {
					$user->where( 'user_id=$user_id' )->delete();
					$this->error( '账户创建失败:企业信息写入失败', "../../../../../", 5 );
				}
			}
			else {
				$this->error( '账户创建失败:账户信息写入失败', "../../../../../", 5 );
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
					$this->success( '运输企业注册成功!', "../../../../../", 5 );
				}
				else {
					$user->where( 'user_id=$user_id' )->delete();
					$this->error( '账户创建失败:企业信息写入失败', "../../../../../", 5 );
				}
			}

			else {
				$this->error( '账户创建失败:账户信息写入失败', "../../../../../", 5 );
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
					$this->success( '接受企业注册成功!', "../../../../../", 5 );
				}
				else {
					$user->where( 'user_id=$user_id' )->delete();
					$this->error( '账户创建失败:企业信息写入失败', "../../../../../", 5 );
				}
			}

			else {
				$this->error( '账户创建失败:账户信息写入失败', "../../../../../", 5 );
			}
			break;

		default:
			$this->error( '页面不存在' );
			break;
		}
	}
}
?>
