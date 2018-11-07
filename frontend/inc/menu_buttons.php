<?php
	$menus = array();	 
	$menus []= array( 'Home', 'home', 'mhome.png' );
	$menus []= array( 'About Us', 'about', 'mabout.png' );
	$menus []= array( 'Contact Us', 'contact', 'mcontact.png' );
	
	foreach( $menus as $menu )
	{	
		$mtitle = $menu[0];
		
		$mexec_id = 't'.base64_encode( strtolower( $menu[1] ) );
		$mexec = "CHelp.clickMe('${mexec_id}');return(false);";
		
		$mimg = $menu[2];		
		
		echo( "<div class=asb >
			<a class=acur href='${me}fl=${mexec_id}' onclick=\"${mexec}\">
				<table id=txt width='100px' >
					<tr><td valign=top align=center >
						<div><img border=0 width=30px src='frontend/img/${mimg}'></div>
						<div class=btxt>${mtitle}</div>
					</td></tr>
				</table>
			</a>
		</div>" );
	}
?>