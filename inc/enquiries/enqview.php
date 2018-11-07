<?php
	if( isset( $_GET[ 'eid' ] ))
	{
		$eid = base64_decode( $_GET[ 'eid' ] );
		$enote='enote';
		$q = "select enote from enquiry where eid='$eid';";
		
		$disp = $hlp->_db->db_return($q,array( 'enote' ));
		if(isset($disp[0]))
			echo($disp[0]);
		
	}
?>