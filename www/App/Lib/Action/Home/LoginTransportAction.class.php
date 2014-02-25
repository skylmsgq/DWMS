<?php
/**
 *
 */
class LoginTransportAction extends CommonAction{
	public function homepage() {
		if ( session( 'user_type' ) == 6 ) {
			$unit = M( 'transport_unit' )->where( array( 'user_id' => session( 'user_id' ) ) )->find();
			session( 'transport_unit_id', $unit['transport_unit_id'] );
	
			layout( './Common/frame' );
			$this->display('./Public/html/Content/Transport/homepage/transport_index.html');
		}else {
			$this->redirect( 'Home/Index/index' );
		}
	}
}

?>