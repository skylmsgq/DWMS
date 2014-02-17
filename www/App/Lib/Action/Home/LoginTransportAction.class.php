<?php
/**
 *
 */
class LoginTransportAction extends CommonAction{
	public function transport() {
		if ( session( 'user_type' ) == 6 ) {
			layout( './Common/frame' );
			$this->display('./Public/html/Content/Transport/homepage/transport_index.html');
		}else {
			$this->redirect( 'Home/Index/index' );
		}
	}
}

?>