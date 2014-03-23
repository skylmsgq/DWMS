<?php
/**
 *
 */
class ProvinceBusinessAction extends ProvinceCommonAction{
	public function get_chart()
	{
		$str="";
		$pnum=M('production_unit')->count();
		$tnum=M('transport_unit')->count();
		$rnum=M('reception_unit')->count();
		$manifestnum=M('manifest')->count();
		$recordnum=M('record')->count();
		$devicenum=M('device')->count();
		$vehiclenum=M('vehicle')->count();
		
		// $tong_num=M('rfid')->where("add_method=0")->sum('waste_total');
		// $dai_num=M('rfid')->where("add_method=1")->sum('waste_total');

		$tong_num=M('manifest')->where('manifest_status>0')->sum('waste_weight');
		$dai_num=M('manifest')->where('manifest_status>0')->sum('waste_num');

		// $categories=M('rfid')->join('waste_category ON rfid.waste_category_id = waste_category.waste_category_id')->group('waste_category_code')->where(array('add_method'=>0))->getField('waste_category_code',true);
		// $rfid = M('rfid');
		// $condition['add_method'] = array('EQ',0);
		// $join = $rfid->join('production_unit ON rfid.production_unit_id = production_unit.production_unit_id' )->join('waste_category ON rfid.waste_category_id = waste_category.waste_category_id')->where($condition)->select();

		$categories = M('manifest')->group('waste_category_code')->getField('waste_category_code',true);
		$manifest = M('manifest');
		$join = $manifest->join( 'production_unit ON manifest.production_unit_id = production_unit.production_unit_id' )->where('manifest_status>0')->select();


		$dict=array();
		$count_waste=0;
		$wastelist=M('production_unit')->select();
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

		$result->rfid=$join;
		$result->categories=$categories;
		$result->statistics=$statistics;
		$result->count_waste=$count_waste;
		$result->str=$wastelist;
		$result->pnum=$pnum;
		$result->tnum=$tnum;
		$result->rnum=$rnum;
		$result->manifestnum=$manifestnum;
		$result->recordnum=$recordnum;
		$result->devicenum=$devicenum;
		$result->vehiclenum=$vehiclenum;
		$result->tong_num=$tong_num;
		$result->dai_num=$dai_num;
		$result=json_encode($result);
		$this->ajaxReturn( $result);
	}

}
?>
