<?php
class ProvinceStatisticsAction extends ProvinceCommonAction{
	// -------- 危废产生单位->侧边栏 --------
	public function statistics_sidebar(){
		layout( './Common/frame' );
		$this->display( './Public/html/Content/Province/statistics/statistics_sidebar.html' );
	}

	// 危废转移->统计分析->转移去向统计
	public function direction_statistic(){
		$tmp_content=$this->fetch( './Public/html/Content/Province/statistics/direction_statistic.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->统计分析->转移联单统计
	public function manifest_statistic(){
		$tmp_content=$this->fetch( './Public/html/Content/Province/statistics/manifest_statistic.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->统计分析->企业信息统计
	public function enterprise_statistic(){
		$tmp_content=$this->fetch( './Public/html/Content/Province/statistics/enterprise_statistic.html' );
		$this->ajaxReturn( $tmp_content );
	}

	// 危废转移->统计分析->危废数量统计
	public function waste_statistic(){
		$tmp_content=$this->fetch( './Public/html/Content/Province/statistics/waste_statistic.html' );
		$this->ajaxReturn( $tmp_content );
	}
}
?>