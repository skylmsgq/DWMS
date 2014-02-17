<?php
/**
 *
 */
require('AllFunction.php');
class AndroidApiAction extends Action{
	
	//登录
	public function login()
	{
		$postData=$_POST['txt_json'];
		echo urldecode(json_encode(login($postData)));
	}
	//查看rfid对应信息
	public function check()
	{
		$postData=$_POST['txt_json'];
		echo urldecode(json_encode(check($postData)));
	}
	// 获取废物的名称
	public function getWasteName($imei=0){
		echo urldecode(json_encode(getWasteName($imei)));
	}
	
	// 增加废物重量
	public function addWaste(){
		$postData=$_POST['txt_json'];
		echo urldecode(json_encode(addWaste($postData)));
	}
	
	// 绑定RFID
	public function bindRfid(){
		$postData=$_POST['txt_json'];
		echo urldecode(json_encode(bindRfid($postData)));
	}
	
	// 获取RFID绑定的废物信息
	public function getRfidWasteName($rfid=0,$imei=0){
		echo urldecode(json_encode(getRfidWasteName($rfid,$imei)));
	}
	
	//废物入库
	public function wasteIn(){
		$postData=$_POST['txt_json'];
		echo urldecode(json_encode(wasteIn($postData)));
	}
	
	//废物出库
	public function wasteOut(){
		$postData=$_POST['txt_json'];
		echo urldecode(json_encode(wasteOut($postData)));
	}
	
}
?>