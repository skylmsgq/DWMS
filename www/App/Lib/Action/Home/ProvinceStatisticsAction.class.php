<?php
class ProvinceStatisticsAction extends ProvinceCommonAction{
	// -------- 危废产生单位->侧边栏 --------
	public function statistics_sidebar(){
		layout( './Common/frame' );
		$this->display( './Public/html/Content/Province/statistics/statistics_sidebar.html' );
	}

	// 危废转移->统计分析->转移去向统计
	public function direction_statistic(){
		$manifest = M('manifest')->join('reception_unit ON manifest.reception_unit_id = reception_unit.reception_unit_id')->join('jurisdiction ON reception_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->select();
		
		$manifest_json = json_encode($manifest);

		$tmp_content = $this->fetch( './Public/html/Content/Province/statistics/direction_statistic.html' );
		$tmp_content = "<script>manifest = $manifest_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->统计分析->转移联单统计
	public function manifest_statistic(){
		$manifest = M('manifest')->join('reception_unit ON manifest.reception_unit_id = reception_unit.reception_unit_id')->join('jurisdiction ON reception_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->select();
		$record = M('record')->join('reception_unit ON record.reception_unit_id = reception_unit.reception_unit_id')->join('jurisdiction ON reception_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->select();
		$manifestnum=M('manifest')->join('production_unit ON production_unit.production_unit_id = manifest.production_unit_id')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->count();
		$recordnum=M('record')->join('production_unit ON production_unit.production_unit_id = record.production_unit_id')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->count();
		$delete_manifest_num=M('manifest')->join('production_unit ON production_unit.production_unit_id = manifest.production_unit_id')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->where( array('manifest_status' => -1) )->count();
		$delete_record_num=M('record')->join('production_unit ON production_unit.production_unit_id = record.production_unit_id')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->where( array( 'record_status' => -1 ) )->count();
		$tong_num=M('manifest')->join('production_unit ON production_unit.production_unit_id = manifest.production_unit_id')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->sum('waste_weight');
		$dai_num=M('manifest')->join('production_unit ON production_unit.production_unit_id = manifest.production_unit_id')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->sum('waste_num');

		$str="";
		$dict=array();
		$count_waste=0;

		$wastelist=M('production_unit')->where( array('jurisdiction_up_id' => session('jurisdiction_id') ) )->select();
		foreach ($wastelist as  $value) {
			$type_list=explode(",", $value['production_unit_waste']);
			foreach ($type_list as $val) {
				if (!array_key_exists($val, $dict))
				{
					$count_waste++;
					$dict[$val]=1;
					$str=$str. $val;
				}
			}
		}

		$manifest_json = json_encode($manifest);
		$record_json = json_encode($record);

		$tmp_content=$this->fetch( './Public/html/Content/Province/statistics/manifest_statistic.html' );
		$tmp_content = "<script>tong_num = $tong_num; dai_num = $dai_num; count_waste = $count_waste;delete_manifest_num = $delete_manifest_num;delete_record_num = $delete_record_num;manifest = $manifest_json;record = $record_json;manifestnum = $manifestnum;recordnum = $recordnum;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->统计分析->企业信息统计
	public function enterprise_statistic(){
		$pnum=M('production_unit')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->count();
		$tnum=M('transport_unit')->join('jurisdiction ON transport_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->count();
		$rnum=M('reception_unit')->join('jurisdiction ON reception_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->count();
		$categories = M('manifest')->join('production_unit ON production_unit.production_unit_id = manifest.production_unit_id')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->group('waste_category_code')->getField('waste_category_code',true);
		$rfid = M('manifest')->join( 'production_unit ON manifest.production_unit_id = production_unit.production_unit_id' )->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->select();
		$categories_json=json_encode($categories);
		$rfid_json=json_encode($rfid);

		$tmp_content=$this->fetch( './Public/html/Content/Province/statistics/enterprise_statistic.html' );
		$tmp_content = "<script>categories=$categories_json;rfid=$rfid_json;pnum=$pnum;tnum=$tnum;rnum=$rnum;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->统计分析->危废数量统计
	public function waste_statistic(){
		$categories = M('manifest')->join('production_unit ON production_unit.production_unit_id = manifest.production_unit_id')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->group('waste_category_code')->getField('waste_category_code',true);
		$rfid = M('manifest')->join( 'production_unit ON manifest.production_unit_id = production_unit.production_unit_id' )->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->select();
		$categories_json=json_encode($categories);
		$rfid_json=json_encode($rfid);

		$tmp_content=$this->fetch( './Public/html/Content/Province/statistics/waste_statistic.html' );
		$tmp_content = "<script>categories=$categories_json;rfid=$rfid_json;</script> $tmp_content";
		$this->ajaxReturn( $tmp_content );
	}
}
?>