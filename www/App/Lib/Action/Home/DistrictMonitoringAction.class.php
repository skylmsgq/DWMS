<?php
	class DistrictMonitoringAction extends DistrictCommonAction{
	// -------- 视频监控->侧边栏 --------
	public function monitoring_sidebar() {
		layout( './Common/frame' );
		$this->display( './Public/html/Content/District/monitoring/monitoring.html' );
	}
}
?>