<?php
	$parent_tab = 'TAB_PRODUCTS';
	//$parent_tab = 'TAB_DOWNLOADS';
	
	$pgnum = 1;
	$frm_submit = "$me?b=dwnall";
	$comboHTML = false;
	$srctxt = false;
	$frmname = "alldown";
	
	echo( '<div class="gencon icheight txt buttonmenuwithbg" >' );
	echo( $hlp->getLinkAncHtml('anewc',100,'asb rviewdash','#','addDynTabDirect("'.$parent_tab.'","New Download","org","New Download","'.$me.'?b=dwnnew")',20,'images/ic/newc.png','New') );
	echo( '</div>' );
	
	if( isset( $_GET[ 'ac' ] ) )
	{
		if( $_GET[ 'ac' ] == 'd' )
		{
			if( isset( $_GET[ 'did' ] ) &&  isset( $_GET[ 'dname' ] ))
			{
				$did = base64_decode( $_GET[ 'did' ] );
				
				$dname = base64_decode( $_GET[ 'dname' ] );
				
				$q = "delete from downloads where did='$did';";

				if( $hlp->_db->db_query( $q ) )
				{
					$hlp->echo_ok( "Content removed.");
					
					@unlink( $DOWNLOAD_DESTINATION.$dname );
				}	
				else
					$hlp->echo_err( "Sorry,unable to remove content." );
			}
			
		}
	}
	
	if( isset( $_GET['cbo'] ) )
	{
		$pgnum = $_POST['pageCombo'];
	}	
	
	if( isset( $_POST[ 'srctxt' ] ) )
		$srctxt = trim( $_POST[ 'srctxt' ] );
	
	$allcntx = $hlp->_db->db_return( "select count(*) cnt from downloads;", array( 'cnt' ) );	
	$allcnt = intval( $allcntx[0] );
	
	if( $allcnt > 0 )
	{
		$q = "select count(*) cnt from downloads where dname like '%$srctxt%';";
		$cntx = $hlp->_db->db_return( $q, array( 'cnt' ) );		
		$cnt = intval( $cntx[0] );
		
		if( $cnt > 0 )
		{
			$q = "select * from downloads where dname like '%$srctxt%' order by ddate desc";
			$startIndex = ( ($pgnum-1)*$IMAGE_DISPLAY_PER_PAGE );	
			
			
			if( $cnt > $IMAGE_DISPLAY_PER_PAGE )
			{
				$comboHTML = $hlp->getDisplayPageComboHTML( $parent_tab,$cnt,$frm_submit."&cbo",$frmname,$pgnum,$IMAGE_DISPLAY_PER_PAGE);
				
				$q .= " LIMIT $startIndex,$IMAGE_DISPLAY_PER_PAGE ;";
			}
			
			$res = $hlp->_db->db_query( $q );	
			if( $res )
			{
				$showNumRow = intval( $hlp->_db->db_num_rows( $res ) );
						
				if( ( $startIndex + 1 ) === ( $showNumRow + $startIndex ) && $pgnum == 1 )
					echo( '<div style="padding-top:15px;"><div class="txtheadwithbg" >Showing 1 of 1.</div></div>' );
				else
					echo( '<div style="padding-top:15px;"><div class="txtheadwithbg" >Showing '.( $startIndex + 1 )." to ".( $showNumRow + $startIndex ).' of '.$cnt.'.</div></div>' );
				
				$hlp->searchBox( $parent_tab,$frm_submit,$srctxt,$comboHTML,$frmname,false,false );
				
				while( ( $row = $hlp->_db->db_get( $res ) ) !== false )
				{
					$did = $row['did'];
					$dname = $row['dname'];
					$ddate = date( 'l, d F Y',strtotime( $row[ 'ddate' ] ) );
					$dsize = $hlp->format_space( $row[ 'dsize' ] );
					
					
					$caption_style = "color:#8e8e8e;float:left;width:80px;";
					$val_style = "color:#3f95b1;white-space:normal;width:610px;";
					
					$dwnpath = $DOWNLOAD_DESTINATION.$did;
					
					echo( '<div name=entrydiv class="gencon bviewdash" style="white-space:nowrap;width:100%;padding-top:10px;" ><table name=tbl class=txt  style="background-color:#f8f8f8;" border=0 width=100%>' );
					echo( '<tr><td align=left valign=top style="width:800px;">
						<div ><table class=txt ><tr><td>' );
					if( file_exists( $imgpath ) )	
						echo( '<div style="float:left" ><img width=150 src="'.$dwnpath.'" />&#160;&#160;&#160;</div></td><td>' );
					echo( '<div id=txt style="color:#10647e;"><b>'.$dname.'</b></div>' );
					echo( '<div style="padding-top:7px;" >
							<table class=txt style="width:650px;" >
								<tr>
									<td style="'.$caption_style.'" ><b>Size:</b></td><td style="'.$val_style.'" >'.$dsize.'&#160;</td>
								</tr>
								<tr>	
									<td style="'.$caption_style.'" ><b>Date:</b></td><td style="'.$val_style.'" >'.$ddate.'&#160;</td>
								</tr>
							</table>		
						<div></td></tr></table></td><td><div>' );
					
					/*
					echo( $hlp->getLinkAncHtml( 'aeditm',60,'asb ',$me.'?b=dwnall&ac=d&iid='.base64_encode( $did )
					,'confirm( "Are you sure, you want to delete \"'.addslashes( $dname ).'\"?" )',20,'images/ic/itick.gif','Delete',$parent_tab,true ) );
					*/
					echo( $hlp->getLinkAncHtml( 'aeditm',60,'asb ',$me.'?b=dwnall&ac=d&did='.base64_encode( $did ).'&dname='.base64_encode($dname)
					,'confirm( "Are you sure, you want to delete \"'.addslashes( $dname ).'\"?" )',20,'images/ic/itick.gif','Delete',$parent_tab ) );
					echo( '</div></td></tr>' );
						
					echo( '</table></div>' );
				}	
			}
			else
				echo( "<div style='padding:20px;' >No downloads to show for search text \"$srctxt\".</div>" );	
		}
		else
		{
			echo( '<div style="padding-top:15px;"><div class="txtheadwithbg" >Showing 0 of 0.</div></div>' );
			$hlp->searchBox( $parent_tab,$frm_submit,$srctxt,$comboHTML,$frmname,false,false );
			echo( "There are no downloads to show for search text \"$srctxt\"." );	
		}	
	}
	else
		echo( "<div style='padding:20px;' >No contents to show.</div>" );
?>