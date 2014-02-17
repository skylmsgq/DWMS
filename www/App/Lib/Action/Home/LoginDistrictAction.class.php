<?php
/**
 *
 */
class LoginDistrictAction extends CommonAction{
	public function homepage() {
		if ( session( 'user_type' ) == 4 ) {

			$jurisdiction = M( 'jurisdiction' )->where( array( 'user_id' => session( 'user_id' ) ) )->find();
			session( 'jurisdiction_id', $jurisdiction['jurisdiction_id'] );
			session( 'jurisdiction_name', $jurisdiction['jurisdiction_name'] );

			layout( './Common/frame' );
			$this->display( './Public/html/Content/District/homepage/district_index.html' );
		}else {
			$this->redirect( 'Home/Index/index' );
		}
	}
}

?>