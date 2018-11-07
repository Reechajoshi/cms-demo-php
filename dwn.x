<?php
	require( 'conf/vars.php' );
	require( 'helper/class.helper.php' );
	
	$me = $_SERVER[ "PHP_SELF" ];
	$hlp = new chlp();
	
	if( isset( $_GET[ 'iid' ] ) )
	{
		$iid = base64_decode( $_GET[ 'iid' ] );
		
		$q = "select concat( imime, '_#_#_', iname, '_#_#_', isize ) a from images where iid='$iid' ;";
		
		$out_name = "image/jpeg";
		$imime = $iname = $isize = false;
		$lval = $hlp->_db->db_return( $q, array( "a"  ) );
		list( $imime, $iname, $isize ) = explode( '_#_#_', $lval[0] );
		
		//$full_path = "/var/www/akola/".$DATA_DESTINATION.$iid;
		$full_path = $DATA_DESTINATION.$iid;
		
		if( file_exists( $full_path ) )
		{
			$hlp->echoFileHeader( $out_name, $iname, $dsize, false );			
			readfile( $full_path );
		}	
	}
?>