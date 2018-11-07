<?php
	if( isset( $_GET[ 'pid' ] ) || isset( $_GET[ 'cid' ] ) )
	{
		$idname = $tablename = $htmlname = false;
		if( isset( $_GET[ 'pid' ] ) )
		{
			$idname = 'pid';
			$tablename = 'products';
			$htmlname = 'phtml';
		}
		else
		{
			$idname = 'cid';
			$tablename = 'categories';
			$htmlname = 'chtml';
		}
		
		$id = base64_decode( $_GET[ $idname ] );
		$q = "select $htmlname from $tablename where $idname='$id';";
		
		$hmlt = $hlp->_db->db_return( $q, array( $htmlname ) );
		if( isset( $hmlt[0] ) )
			echo( $hmlt[0] );
	}
?>