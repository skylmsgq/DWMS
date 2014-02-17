<?php
/**
 *
 */
class LoginProductionAction extends CommonAction{
	public function homepage() {
		if ( session( 'user_type' ) == 5 ) {

			$unit = M( 'production_unit' )->where( array( 'user_id' => session( 'user_id' ) ) )->find();
			session( 'production_unit_id', $unit['production_unit_id'] );

			layout( './Common/frame' );
			$this->display( './Public/html/Content/Production/homepage/production_index.html' );
		}else {
			$this->redirect( 'Home/Index/index' );
		}
	}
}

?>