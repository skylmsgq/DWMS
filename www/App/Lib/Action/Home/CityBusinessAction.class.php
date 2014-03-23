<?php
/**
 *
 */
class CityBusinessAction extends CityCommonAction{
	public function get_chart()
	{
		$str="";
		$pnum=M('production_unit')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->where( array( 'jurisdiction_up_id' => session('jurisdiction_id') ) )->count();
		$tnum=M('transport_unit')->join('jurisdiction ON transport_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->where( array( 'jurisdiction_up_id' => session('jurisdiction_id') ) )->count();
		$rnum=M('reception_unit')->join('jurisdiction ON reception_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->where( array( 'jurisdiction_up_id' => session('jurisdiction_id') ) )->count();
		$manifestnum=M('manifest')->join('production_unit ON production_unit.production_unit_id = manifest.production_unit_id')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->where( array( 'jurisdiction_up_id' => session('jurisdiction_id') ) )->count();
		$recordnum=M('record')->join('production_unit ON production_unit.production_unit_id = record.production_unit_id')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->where( array( 'jurisdiction_up_id' => session('jurisdiction_id') ) )->count();
		$devicenum=M('device')->join('jurisdiction ON device.jurisdiction_id = jurisdiction.jurisdiction_id')->where( array('jurisdiction_up_id' => session('jurisdiction_id') ) )->count();
		$vehiclenum=M('vehicle')->join('transport_unit ON transport_unit.transport_unit_id = vehicle.transport_unit_id')->join('jurisdiction ON transport_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->where( array( 'jurisdiction_up_id' => session('jurisdiction_id') ) )->count();
		
		// $tong_num=M('rfid')->where("add_method=0")->sum('waste_total');
		// $dai_num=M('rfid')->where("add_method=1")->sum('waste_total');

		$tong_num=M('manifest')->join('production_unit ON production_unit.production_unit_id = manifest.production_unit_id')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->where( array( 'jurisdiction_up_id' => session('jurisdiction_id') ) )->sum('waste_weight');
		$dai_num=M('manifest')->join('production_unit ON production_unit.production_unit_id = manifest.production_unit_id')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->where( array( 'jurisdiction_up_id' => session('jurisdiction_id') ) )->sum('waste_num');

		// $categories=M('rfid')->join('waste_category ON rfid.waste_category_id = waste_category.waste_category_id')->group('waste_category_code')->where(array('add_method'=>0))->getField('waste_category_code',true);
		// $rfid = M('rfid');
		// $condition['add_method'] = array('EQ',0);
		// $join = $rfid->join('production_unit ON rfid.production_unit_id = production_unit.production_unit_id' )->join('waste_category ON rfid.waste_category_id = waste_category.waste_category_id')->where($condition)->select();

		$categories = M('manifest')->join('production_unit ON production_unit.production_unit_id = manifest.production_unit_id')->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->where( array( 'jurisdiction_up_id' => session('jurisdiction_id') ) )->group('waste_category_code')->getField('waste_category_code',true);
		$manifest = M('manifest');
		$join = $manifest->join( 'production_unit ON manifest.production_unit_id = production_unit.production_unit_id' )->join('jurisdiction ON production_unit.jurisdiction_id = jurisdiction.jurisdiction_id')->where( array( 'jurisdiction_up_id' => session('jurisdiction_id') ) )->select();


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
