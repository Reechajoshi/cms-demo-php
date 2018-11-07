<?php
	if( isset( $_GET['fl'] ) )
		$fl = $_GET['fl'];
	else
		$fl ='';
	
	$ret_html = $hlp->getMainContentHTML( $fl );
	echo( $ret_html );
?>
