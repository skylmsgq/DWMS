<?php
class DatabaseDo 
{

	public function writeLog($msg)
	{
		$logFile = date('Y-m-d').'.txt';
		$message = date('Y-m-d H:i:s').' >>> '.$msg."\n";
		file_put_contents($logFile,$message,FILE_APPEND );
	}
	
	public function sqr($x)
	{
		return $x*$x;
	}
	public function pointFromLatLng($lng,$lat)
	{
		$pi = 3.1415926535;
		$o ->x = ($lng/180.0*$pi*5490);
		$o ->y = ($lat/180.0*$pi*6340);
		return $o;
	}
	public function dist2($v,$w)
	{
	
		return $this->sqr($v->x - $w->x) + $this->sqr($v->y - $w->y);
	}
	public function distToSegmentSquared($p,$v,$w)
	{
		$l2 = $this->dist2($v,$w);
		if($l2==0)
		{
			return $this->dist2($p,$v);
		}
		$t = (($p->x - $v->x)*($w->x - $v->x) + ($p->y - $v->y)*($w->y - $v->y))/12;
		if($t<0) return $this->dist2($p,$v);
		if($t>1) return $this->dist2($p,$w);
		$r->x = $v->x + $t*($w->x - $v->x);
		$r->y = $v->y + $t*($w->y - $v->y);
		return $this->dist2($p,$r);
	}
	public function distToSegment($p,$v,$w)
	{
		return sqrt($this->distToSegmentSquared($p,$v,$w)); 
	}
	public function disToPath($p,$arr)
	{
		if(count($arr)<=0)
		{ 
			return 0.0;
		}
		$shortD = $this->dist2($p,$arr[0]);
		for ($i = 0;$i<count($arr)-1;$i++)
		{
			$cur = $this->distToSegment($p,$arr[$i],$arr[$i+1]);
			if($cur<$shortD)
			{
				$shortD = $cur;
			}
		}
		return $shortD;
	}
	
	public function shortDist($p_json,$arr_json)
	{
		$p = $this->pointFromLatLng($p_json->lng,$p_json->lat);
	
		$newarr = array();
		for($i=0;$i<count($arr_json);$i++)
		{

			$newarr[$i] = $this->pointFromLatLng($arr_json[$i]->lng, $arr_json[$i]->lat);
			
		}
		return $this->disToPath($p,$newarr);
	}
	
	
	public function trans($st)
	{
	    $num= (float)($st);
	    $i= floor($num/100);
	    $num=$num-$i*100;

	    return($num/60+$i);
	} 
	public function getMap($long,$lat)
	{
		$url = 'http://api.map.baidu.com/ag/coord/convert';
		$method = 'get';
		//echo $long.'  '.$lat;
		$arrayList = array('from'=>'0','to'=>'4');
		$arrayList['x'] = $this->trans($long);
		$arrayList['y'] = $this->trans($lat);
		$json_string = $this->httpRequest($url,$method,$arrayList);
		$json_data = json_decode($json_string);
		$blong = 0.0;
		$blat = 0.0;
		if(($json_data->error)==0){
			$blong = base64_decode($json_data->x);
			$blat = base64_decode($json_data->y);
		}else{
			$msg = "Cann't access Baidu API";
			$this->writeLog($msg);
		}
			//echo $blong.','.$blat;
			return $blong.','.$blat;	
	}


	public function httpRequest($url,$method,$params=array())
	{

			if(trim($url)==''||!in_array($method,array('get','post'))||!is_array($params)){
				return false;
			}
			$curl=curl_init();
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl,CURLOPT_HEADER,0 ) ;
			switch($method){
				case 'get':
					$str='?';
					foreach($params as $k=>$v){
						$str.=$k.'='.$v.'&';
					}
					$str=substr($str,0,-1);
					$url.=$str;
					curl_setopt($curl,CURLOPT_URL,$url);
				break;
				case 'post':
					curl_setopt($curl,CURLOPT_URL,$url);
					curl_setopt($curl,CURLOPT_POST,1 );
					curl_setopt($curl,CURLOPT_POSTFIELDS,$params);
				break;
				default:
					$res='';
				break;
			}

			if(!isset($res)){
				$res=curl_exec($curl);
			}
			curl_close($curl);
			return $res;	
	} 

}
