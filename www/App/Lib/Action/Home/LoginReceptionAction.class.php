<?php
/**
 *
 */
class LoginReceptionAction extends CommonAction{
	public function homepage() {
		if ( session( 'user_type' ) == 7 ) {
			$unit = M( 'reception_unit' )->where( array( 'user_id' => session( 'user_id' ) ) )->find();
			session( 'reception_unit_id', $unit['reception_unit_id'] );
			session( 'jurisdiction_id', $unit['jurisdiction_id'] );

			layout( './Common/frame' );
			$this->display( './Public/html/Content/Reception/homepage/reception_index.html' );
		}else {
			$this->redirect( 'Home/Index/index' );
		}
	}
}

?>