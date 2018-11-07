<div id=imenuproducts>
<?php

	echo( '<div name="main_menu_div">' );
	echo( '<div class="gc btxt gtxt ltxt" style="padding-bottom:15px;padding-top:15px"><a class="a-high" href=# onclick="CHelp.displaySubMenu(this);return(false);"><span class=ibd>[</span><span class=ipd name=ipmid>+</span><span class=ibd>]</span></a>Downloads</div>' );
	echo( '<div name="submenu" style="display:none;">' );  //product sumbneu start
	$q = 'select did , dname , dsize , ddate from downloads;';
	$res = $hlp->_db->db_query( $q );
	
	if( $res )
	{
		
		$cx = 475;
		
		while( ( $row = $hlp->_db->db_get( $res ) ) !== false )
		{
			$did = $row[ 'did' ];
			$dname = htmlspecialchars( $row[ 'dname' ] );
			
			
			$did_ex = base64_encode($did);
			echo( '<div name=menut><div class="gc gbox" name=mr0 style="width:'.$cx.'px;"><table name=mr25 border=0 style="width:'.($cx-25).'px;">
					<tr><td align=center valign=middle height=35px >						
						<div class=gc name=mr75 style="width:'.($cx-75).'px"><a class="a-high gtxt gprod" name="'.$dname.'" href=\''.$me.'dwnld='.$did_ex.'\' onclick="">'.$dname.'</a></div>
					</td></tr>
				</table></div></div>' );
			/* echo( '<div class=gc name=submenux style="display:none;white-space:normal;">' );
			echo( '<a class="a-high gtxt"  href=\''.$me.'dwnld='.$did_ex.'\' name="'.$dname.'"><div name=mr55 class="gc-wrap gbox-sub gdtxt" style="width:'.($cx-55).'px;">Download</div></a></div></div>' ); */
			
		}
	}
	echo( '</div>' );
?>
</div>

<?php

echo( '<div name="main_menu_div" ><div class="gc btxt gtxt ltxt" style="padding-bottom:15px"><a class="a-high" href=# onclick="CHelp.displaySubMenu(this);return(false);"><span class=ibd>[</span><span class=ipd name=ipmid>+</span><span class=ibd>]</span></a>Product Range</div>' );
	/* echo( '<div name="main_menu_div" class="gc btxt gtxt ltxt" style="padding-bottom:15px">
			<a class="a-high" href=# onclick="CHelp.displaySubMenu(this);return(false);"><span class=ibd>[</span><span class=ipd name=ipmid>+</span><span class=ibd>]</span></a>Product Range' ); */
			
	echo( '<div name="submenu" style="display:none;">' );  //product sumbneu start

	$q = 'select categories.cid as cid, categories.cname as cname, products.pname as pname, products.pid as pid from products, categories where products.pgroup=categories.cid order by cname;';
	$res = $hlp->_db->db_query( $q );
	
	if( $res )
	{
		$catlist = array();
		$cid_prev = false;
		$cx = 475;
		
		while( ( $row = $hlp->_db->db_get( $res ) ) !== false )
		{
			$cid = $row[ 'cid' ];
			$cname = htmlspecialchars( $row[ 'cname' ] );
			$pid = $row[ 'pid' ];			
			$pname = htmlspecialchars( $row[ 'pname' ] );
			
			if( isset( $catlist[ $cid ] ) )
			{
				$pid_ex = 'p'.base64_encode($pid);
				echo( '<a class="a-high gtxt" href=\''.$me.'fl='.$pid_ex.'\' onclick="CHelp.clickMe(\''.$pid_ex.'\');return(false);" name="'.$pname.'"><div name=mr55 class="gc-wrap gbox-sub gdtxt" style="width:'.($cx-55).'px;">'.$pname.'</div></a>' );
			}
			else
			{
				if( $catlist[ $cid_prev ] === false )
					{ echo( '</div></div>' ); $catlist[ $cid_prev ] = true; }
				
				$cid_ex= 'c'.base64_encode($cid);
				echo( '<div name=menut><div class="gc gbox" name=mr0 style="width:'.$cx.'px;"><table name=mr25 border=0 style="width:'.($cx-25).'px;">
						<tr><td align=center valign=middle height=35px >						
							<div class=gc name=mr75 style="width:'.($cx-75).'px"><a '.( ($isNOJS) ? ('style="display:none;"') : ('') ).' class="a-high" href=# onclick="CHelp.productSubDisp(this);return(false);"><span class=ibd>[</span><span class=ipd name=ipmid>+</span><span class=ibd>]</span></a><a class="a-high gtxt gprod" name="'.$cname.'" href=\''.$me.'fl='.$cid_ex.'\' onclick="CHelp.clickMe(\''.$cid_ex.'\');return(false);">'.$cname.'</a></div>
						</td></tr>
					</table></div>' );
					
				echo( '<div class=gc name=submenux style="display:none;white-space:normal;">' );
				$pid_ex = 'p'.base64_encode($pid);
				echo( '<a class="a-high gtxt"  href=\''.$me.'fl='.$pid_ex.'\' onclick="CHelp.clickMe(\''.$pid_ex.'\', false);return(false);" name="'.$pname.'"><div name=mr55 class="gc-wrap gbox-sub gdtxt" style="width:'.($cx-55).'px;">'.$pname.'</div></a>' );
				
				$catlist[ $cid ] = false;
				$cid_prev = $cid;
			}
		}
	}
	
	echo( '</div>' );  // product submenu end
	
	echo( '</div>' );
?>
</div></div>

