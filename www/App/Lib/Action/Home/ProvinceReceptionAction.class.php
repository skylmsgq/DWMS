<?php
/**
 *
 */
class ProvinceReceptionAction extends ProvinceCommonAction{
	// -------- 危废处置单位->侧边栏 --------
	public function reception_sidebar(){
		layout( './Common/frame' );
		$this->display( './Public/html/Content/Province/reception/reception_sidebar.html' );
	}

	// 危废处置单位->企业基本信息->企业基本信息
	public function reception_basic_information_2(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 2 ) )->getField('reception_unit_id,reception_unit_name,reception_unit_address,reception_unit_county');
        $reception_unit_json = json_encode( $reception_unit );
        $tmp_content = $this->fetch('./Public/html/Content/Province/reception/reception_basic_information.html');
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn($tmp_content);
    }

    public function reception_basic_information_3(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 3 ) )->getField('reception_unit_id,reception_unit_name,reception_unit_address,reception_unit_county');
        $reception_unit_json = json_encode( $reception_unit );
        $tmp_content = $this->fetch('./Public/html/Content/Province/reception/reception_basic_information.html');
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn($tmp_content);
    }

    public function reception_basic_information_4(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 4 ) )->getField('reception_unit_id,reception_unit_name,reception_unit_address,reception_unit_county');
        $reception_unit_json = json_encode( $reception_unit );
        $tmp_content = $this->fetch('./Public/html/Content/Province/reception/reception_basic_information.html');
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn($tmp_content);
    }

    public function reception_basic_information_5(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 5 ) )->getField('reception_unit_id,reception_unit_name,reception_unit_address,reception_unit_county');
        $reception_unit_json = json_encode( $reception_unit );
        $tmp_content = $this->fetch('./Public/html/Content/Province/reception/reception_basic_information.html');
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn($tmp_content);
    }

    public function reception_basic_information_6(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 6 ) )->getField('reception_unit_id,reception_unit_name,reception_unit_address,reception_unit_county');
        $reception_unit_json = json_encode( $reception_unit );
        $tmp_content = $this->fetch('./Public/html/Content/Province/reception/reception_basic_information.html');
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn($tmp_content);
    }

    public function reception_basic_information_7(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 7 ) )->getField('reception_unit_id,reception_unit_name,reception_unit_address,reception_unit_county');
        $reception_unit_json = json_encode( $reception_unit );
        $tmp_content = $this->fetch('./Public/html/Content/Province/reception/reception_basic_information.html');
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn($tmp_content);
    }

    public function reception_basic_information_8(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 8 ) )->getField('reception_unit_id,reception_unit_name,reception_unit_address,reception_unit_county');
        $reception_unit_json = json_encode( $reception_unit );
        $tmp_content = $this->fetch('./Public/html/Content/Province/reception/reception_basic_information.html');
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn($tmp_content);
    }

    public function reception_basic_information_9(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 9 ) )->getField('reception_unit_id,reception_unit_name,reception_unit_address,reception_unit_county');
        $reception_unit_json = json_encode( $reception_unit );
        $tmp_content = $this->fetch('./Public/html/Content/Province/reception/reception_basic_information.html');
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn($tmp_content);
    }

    public function reception_basic_information_10(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 10 ) )->getField('reception_unit_id,reception_unit_name,reception_unit_address,reception_unit_county');
        $reception_unit_json = json_encode( $reception_unit );
        $tmp_content = $this->fetch('./Public/html/Content/Province/reception/reception_basic_information.html');
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn($tmp_content);
    }

    public function reception_basic_information_11(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 11 ) )->getField('reception_unit_id,reception_unit_name,reception_unit_address,reception_unit_county');
        $reception_unit_json = json_encode( $reception_unit );
        $tmp_content = $this->fetch('./Public/html/Content/Province/reception/reception_basic_information.html');
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn($tmp_content);
    }

    public function reception_basic_information_12(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 12 ) )->getField('reception_unit_id,reception_unit_name,reception_unit_address,reception_unit_county');
        $reception_unit_json = json_encode( $reception_unit );
        $tmp_content = $this->fetch('./Public/html/Content/Province/reception/reception_basic_information.html');
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn($tmp_content);
    }

	// 危废处置单位->企业基本信息->企业基本信息：详情
	public function reception_basic_information_page($record_id=""){
		$reception_unit = M( 'reception_unit' )->where( array( 'reception_unit_id' => $record_id ) )->find();
		$this->unit = $reception_unit;
		$tmp_content=$this->fetch( './Public/html/Content/Province/reception/reception_basic_information_page.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废处置单位->危废接受台账->危废接受统计
	public function waste_account_monthly_statistics_2(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 2 ) )->select();
        $reception_unit_json = json_encode($reception_unit);
        $tmp_content = $this->fetch( './Public/html/Content/Province/reception/waste_reception_account_monthly_statistics.html' );
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn( $tmp_content );
    }

    public function waste_account_monthly_statistics_3(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 3 ) )->select();
        $reception_unit_json = json_encode($reception_unit);
        $tmp_content = $this->fetch( './Public/html/Content/Province/reception/waste_reception_account_monthly_statistics.html' );
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn( $tmp_content );
    }

    public function waste_account_monthly_statistics_4(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 4 ) )->select();
        $reception_unit_json = json_encode($reception_unit);
        $tmp_content = $this->fetch( './Public/html/Content/Province/reception/waste_reception_account_monthly_statistics.html' );
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn( $tmp_content );
    }

    public function waste_account_monthly_statistics_5(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 5 ) )->select();
        $reception_unit_json = json_encode($reception_unit);
        $tmp_content = $this->fetch( './Public/html/Content/Province/reception/waste_reception_account_monthly_statistics.html' );
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn( $tmp_content );
    }

    public function waste_account_monthly_statistics_6(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 6 ) )->select();
        $reception_unit_json = json_encode($reception_unit);
        $tmp_content = $this->fetch( './Public/html/Content/Province/reception/waste_reception_account_monthly_statistics.html' );
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn( $tmp_content );
    }

    public function waste_account_monthly_statistics_7(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 7 ) )->select();
        $reception_unit_json = json_encode($reception_unit);
        $tmp_content = $this->fetch( './Public/html/Content/Province/reception/waste_reception_account_monthly_statistics.html' );
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn( $tmp_content );
    }

    public function waste_account_monthly_statistics_8(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 8 ) )->select();
        $reception_unit_json = json_encode($reception_unit);
        $tmp_content = $this->fetch( './Public/html/Content/Province/reception/waste_reception_account_monthly_statistics.html' );
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn( $tmp_content );
    }

    public function waste_account_monthly_statistics_9(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 9 ) )->select();
        $reception_unit_json = json_encode($reception_unit);
        $tmp_content = $this->fetch( './Public/html/Content/Province/reception/waste_reception_account_monthly_statistics.html' );
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn( $tmp_content );
    }

    public function waste_account_monthly_statistics_10(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 10 ) )->select();
        $reception_unit_json = json_encode($reception_unit);
        $tmp_content = $this->fetch( './Public/html/Content/Province/reception/waste_reception_account_monthly_statistics.html' );
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn( $tmp_content );
    }

    public function waste_account_monthly_statistics_11(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 11 ) )->select();
        $reception_unit_json = json_encode($reception_unit);
        $tmp_content = $this->fetch( './Public/html/Content/Province/reception/waste_reception_account_monthly_statistics.html' );
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn( $tmp_content );
    }

    public function waste_account_monthly_statistics_12(){
        $reception_unit = M( 'reception_unit' )->where( array( 'jurisdiction_id' => 12 ) )->select();
        $reception_unit_json = json_encode($reception_unit);
        $tmp_content = $this->fetch( './Public/html/Content/Province/reception/waste_reception_account_monthly_statistics.html' );
        $tmp_content = "<script>reception_unit_json = $reception_unit_json;</script> $tmp_content";
        $this->ajaxReturn( $tmp_content );
    }

	// 危废处置单位->危废接受台账->危废接受统计->详情
	public function waste_reception_account_monthly_statistics_page($reception_unit_id=""){
		$rfid = M('rfid');
		$condition['reception_unit_id'] = array('EQ',$reception_unit_id);
		$condition['rfid_status'] = array('EQ',2);
		$join = $rfid->join('waste_category ON rfid.waste_category_id = waste_category.waste_category_id')->where($condition)->select();
		$rfid_json = json_encode($join);
		$tmp_content = $this->fetch( './Public/html/Content/Province/reception/waste_reception_ccount_monthly_statistics_page.html' );
		$tmp_content = "<script>rfid_json = $rfid_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废处置单位->RFID手持端->RFID手持端绑定
	public function reception_rfid_hand_equipment(){
		$tmp_content=$this->fetch( './Public/html/Content/Province/reception/reception_rfid_hand_equipment.html' );
		$this->ajaxReturn( $tmp_content );
	}

}
?>