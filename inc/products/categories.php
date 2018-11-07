<?php
	$parent_tab = 'TAB_PRODUCTS';
	
	$pgnum = 1;
	$frm_submit = "$me?b=catall";
	$comboHTML = false;
	$srctxt = false;
	$frmname = "allcat";
	
	if( isset( $_GET[ 'ac' ] ) )
	{
		if( $_GET[ 'ac' ] == 'd' )
		{
			$cid = base64_decode( $_GET[ 'cid' ] );
			$q = "delete from categories where cid='$cid';";
			
			if( $hlp->_db->db_query( $q ) )
				$hlp->echo_ok( "Category removed." );
			else
				$hlp->echo_err( "Sorry, unable to remove category." );
		}
	}
	
	echo( '<div class="gencon icheight txt buttonmenuwithbg" >' );
	echo( $hlp->getLinkAncHtml('anewc',100,'asb rviewdash','#','addDynTabDirect("'.$parent_tab.'","New Categories","org","New Category","'.$me.'?b=catnew&n")',20,'images/ic/newc.png','New') );
	echo( '</div>' );
	
	if( isset( $_GET['cbo'] ) )
	{
		$pgnum = $_POST['pageCombo'];
		$srctxt = trim( $_POST[ 'cbosrctxt' ] );
	}	
	
	if( isset( $_POST[ 'srctxt' ] ) )
		$srctxt = trim( $_POST[ 'srctxt' ] );
	
	$allcntx = $hlp->_db->db_return( "select count(*) cnt from categories;", array( 'cnt' ) );
	$allcnt = intval( $allcntx[0] );
	
	if( $allcnt > 0 )
	{
		$q = "select count(*) cnt from categories where cname like '%$srctxt%';";
		$cntx = $hlp->_db->db_return( $q, array( "cnt" ) );
		$cnt = intval( $cntx[0] );
		
		if( $cnt > 0 )
		{
			$q = "select * from categories where cname like '%$srctxt%' order by cdate desc";
			$startIndex = ( ($pgnum-1)*$CATEGORY_DISPLAY_PER_PAGE );	
			
			if( $cnt > $CATEGORY_DISPLAY_PER_PAGE )
			{
				$comboHTML = $hlp->getDisplayPageComboHTML( $parent_tab,$cnt,$frm_submit."&cbo",$frmname,$pgnum,$CATEGORY_DISPLAY_PER_PAGE);
				
				$q .= " LIMIT $startIndex,$CATEGORY_DISPLAY_PER_PAGE ;";
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
					$cid = $row[ 'cid' ];
					$cdate = date( 'l, d F Y',strtotime( $row[ 'cdate' ] ) );
					$cname = $row[ 'cname' ];
					$ctitle = $row[ 'ctitle' ];
					
					$caption_style = "color:#8e8e8e;float:left;width:80px;";
					$val_style = "color:#3f95b1;white-space:normal;width:610px;";
					
					echo( '<div name=entrydiv class="gencon bviewdash" style="white-space:nowrap;width:100%;padding-top:10px;" ><table name=tbl class=txt  style="background-color:#f8f8f8;" border=0 width=100%>' );
					echo( '<tr><td align=left valign=top style="width:800px;">
						<div ><table class=txt ><tr><td>' );
					
					echo( '<div id=txt style="color:#10647e;"><b>'.$cname.'</b></div>' );
					echo( '<div style="padding-top:7px;" >
							<table class=txt style="width:650px;" >
								<tr>	
									<td style="'.$caption_style.'" ><b>Title:</b></td><td style="'.$val_style.'" >'.$hlp->trimText( $ctitle ).'&#160;</td>
								</tr>
							</table>		
						<div></td></tr></table></td><td><div>' );
					
					echo( $hlp->getLinkAncHtml( 'aeditm',60,'asb ','#','tt="Edit :'.addslashes( $cname ).'";addDynTabMain("'.$parent_tab.'","Edit ","'.addslashes( $cname ).'",tt,"'.$me.'?b=catnew&edt='.base64_encode( $cid ).'",true, true);',20,'images/ic/itick.gif','Edit',$parent_tab ) );
					//echo( $hlp->getLinkAncHtml( 'aeditm',60,'asb ','#','tt="View :'.$cname.'";addDynTabEx("'.$parent_tab.'","View ","'.$cname.'",tt,"'.$me.'?b=catview&cid='.base64_encode( $cid ).'",true);',20,'images/ic/itick.gif','View',$parent_tab ) );
					echo( $hlp->getLinkAncHtml( 'aeditm',60,'asb ','#','tt="Products of '.addslashes( $cname ).'";addDynTabEx("'.$parent_tab.'","View ","'.addslashes( $cname ).'",tt,"'.$me.'?b=prodall&cat='.base64_encode( $cname ).'&cid='.base64_encode( $cid ).'",true);',20,'images/ic/itick.gif','Products',$parent_tab ) );
					echo( $hlp->getLinkAncHtml( 'aeditm',60,'asb ',$me.'?b=catall&ac=d&cid='.base64_encode( $cid ),'confirm( "Are you sure, you want to delete \"'.addslashes( $cname ).'\"?" )',20,'images/ic/itick.gif','Delete',$parent_tab ) );
					
					echo( '</div></td></tr>' );
						
					echo( '</table></div>' );
				}	
			}
			else
				echo( "<div style='padding:20px;' >No categories to show for search text \"$srctxt\".</div>" );	
		}
		else
		{
			echo( '<div style="padding-top:15px;"><div class="txtheadwithbg" >Showing 0 of 0.</div></div>' );
			$hlp->searchBox( $parent_tab,$frm_submit,$srctxt,$comboHTML,$frmname,false,false );
			echo( "There are no categories to show for search text \"$srctxt\"." );	
		}	
	}
	else
		echo( "<div style='padding:20px;' >No categories to show.</div>" );	
?>