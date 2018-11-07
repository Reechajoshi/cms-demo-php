<?php
	
		$did = base64_decode( $_GET[ 'dwnld' ] );
		
		$q = "select dname from downloads where did='$did' ;";
		
		$lval = $hlp->_db->db_return( $q, array( "dname"  ) );
		
		$dname = $lval[0];
		
		$full_path = $DOWNLOAD_DESTINATION.$dname;
		
		if( file_exists( $full_path ) )
		{
			//$hlp->echoDownloadFileHeader( $full_path);
			
			$hlp->echoDwnFileHeader( $full_path);
			
			readFile($full_path);
			
		}	
?>