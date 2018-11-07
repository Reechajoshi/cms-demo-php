<?php
	header("Expires: Mon, 26 Jul 1990 05:00:00 GMT");
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");

	require( 'conf/vars.php' );
	require( 'helper/class.helper.php' );
	
	$me = $_SERVER[ "PHP_SELF" ];
	$hlp = new chlp();
	
	echo('<html>');	
	if( $_GET['a']=='t' )
	{
		echo( '<html><head></head>' );
		require( 'inc/frmtop.php' );
	}
	else if( $_GET['a']=='r' )
	{
		echo( '<html><head>' );
			require( 'inc/head.php' );//only required for TAB
			require( 'inc/menu_main.php' );
		echo( '</head>' );
		echo( '<body onload=menuInit();></body>' );
	}
	else if( $_GET['a']=='prod' )
	{
		echo('<html>');			
			require( 'inc/head.php' );//only required for TAB
			require( 'inc/products/menu.php' );
		echo( '</head>' );
		echo( '<body onload=menuInit();></body>' );
	}
	else if( $_GET['a']=='enq' )
	{
		echo('<html>');			
			require( 'inc/head.php' );//only required for TAB
			require( 'inc/enquiries/menu.php' );
		echo( '</head>' );
		echo( '<body onload=menuInit();></body>' );
	}// Added by Shrikant
	else if( $_GET['a']=='dwn' )
	{
		echo('<html>');			
			require( 'inc/head.php' );//only required for TAB
			require( 'inc/downloads/menu.php' );
		echo( '</head>' );
		echo( '<body onload=menuInit();></body>');
	}// Added by Shrikant
	else if( $_GET['b'] == 'prodall' )
		require( 'inc/products/all.php' );
	else if( $_GET['b'] == 'prodview' || $_GET['b'] == 'catview' )
		require( 'inc/products/view.php' );
	else if( $_GET['b'] == 'prodnew' || $_GET['b'] == 'catnew' )
	{
		echo( '<link rel="stylesheet" type="text/css" href="styles/ui.css.x">' );
		echo( "</head>" );
		require( 'inc/init_ckeditor.php' );
	}	
	else if( $_GET['b'] == 'imgall' )
		require( 'inc/products/imageall.php' );
	else if( $_GET['b'] == 'imageupload' )
		require( "Fileuploader/uploader.html" );
	else if( $_GET['b'] == 'catall' )
		require( 'inc/products/categories.php' );
	else if( $_GET['b'] == 'enqall' )
		require( 'inc/enquiries/enqall.php');
	else if( $_GET['b'] == 'enqview')
		require( 'inc/enquiries/enqview.php' );
	else if( $_GET['b'] == 'dwnall' )
		require( 'inc/downloads/dwnall.php');
	else if( $_GET['b'] == 'dwnview')
		require( 'inc/downloads/dwnview.php' );
	else if( $_GET['b'] == 'dwnnew')
	{
		echo( '<link rel="stylesheet" type="text/css" href="styles/ui.css.x">' );
		echo( "</head>" );
		require( 'inc/downloads/dwnnew.php' );
	}	
	else
	{
		echo( "<head></head><frameset rows='40,*'>
			<frame src='$me?a=t' frameborder=0 marginheight=0 marginwidth=0 name=ft noresize=noresize scrolling=no />
			<frame src='$me?a=r' frameborder=0 marginheight=0 marginwidth=0 name=fb noresize=noresize scrolling=auto />
		</frameset>" );
	}
	echo('</html>');
?>