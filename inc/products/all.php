<?php
	$parent_tab = 'TAB_PRODUCTS';
	
	$pgnum = 1;
	$frm_submit = "$me?b=prodall";
	$comboHTML = false;
	$srctxt = false;
	$frmname = "allprod";
	
	$cid = false;
	if(isset($_GET['cid']))
	{
		$cid=base64_decode($_GET['cid']);
	}
	if( isset( $_GET[ 'ac' ] ) )
	{
		if( $_GET[ 'ac' ] == 'd' )
		{
			$pid = base64_decode( $_GET[ 'pid' ] );
			$q = "delete from products where pid='$pid';";
			
			if( $hlp->_db->db_query( $q ) )
				$hlp->echo_ok( "Product removed." );
			else
				$hlp->echo_err( "Sorry, unable to remove product." );
		}
	}
	
	echo( '<div class="gencon icheight txt buttonmenuwithbg" >' );
	echo( $hlp->getLinkAncHtml('anewc',100,'asb rviewdash','#','addDynTabDirect("'.$parent_tab.'","New Product","org","New Product","'.$me.'?b=prodnew&n&catid='.base64_encode( $cid ).'")',20,'images/ic/newc.png','New') );
	echo( '</div>' );
	
	if( isset( $_GET['cbo'] ) )
	{
		$pgnum = $_POST['pageCombo'];
		$srctxt = trim( $_POST[ 'cbosrctxt' ] );
	}	
	
	if( isset( $_POST[ 'srctxt' ] ) )
		$srctxt = trim( $_POST[ 'srctxt' ] );
	
	$allx = $hlp->_db->db_return( "select count(*) cnt from products;", array( 'cnt' ) );
	$allcnt = intval( $allx[0] );
	
	if( $allcnt > 0 )
	{
		if( $cid )
		{
			$q = "select count(*) cnt from products  where pname like '%$srctxt%' and pgroup='$cid';";
			$frm_submit .= '&cid='.base64_encode($cid);
			
		}
		else
		{
			$filter_cat = '';
			$q = "select count(*) cnt from products where pname like '%$srctxt%';";
		}
		
		$cntx = $hlp->_db->db_return( $q, array( "cnt" ) );
		$cnt = intval( $cntx[0] );
		
		if( $cnt > 0 )
		{
			$q = "select pid, pname, phtml, ptitle, ( select cname from categories where cid=pgroup ) pgroup, pdate from products where pname like '%$srctxt%' ".( ( $cid )?( " and pgroup = '$cid' " ):( '' ) )."  order by pdate desc";
			
			$startIndex = ( ($pgnum-1)*$PRODUCT_SHOW_PER_PAGE );	
			
			if( $cnt > $PRODUCT_SHOW_PER_PAGE )
			{
				$comboHTML = $hlp->getDisplayPageComboHTML( $parent_tab,$cnt,$frm_submit."&cbo",$frmname,$pgnum,$PRODUCT_SHOW_PER_PAGE);
				
				$q .= " LIMIT $startIndex,$PRODUCT_SHOW_PER_PAGE ;";
			}
			
			$res = $hlp->_db->db_query( $q );	
			if( $res )
			{
				$showNumRow = intval( $hlp->_db->db_num_rows( $res ) );
						
				if( ( $startIndex + 1 ) === ( $showNumRow + $startIndex ) && $pgnum == 1 )
					echo( '<div style="padding-top:15px;"><div class="txtheadwithbg" >Showing 1 of 1.</div></div>' );
				else
					echo( '<div style="padding-top:15px;"><div class="txtheadwithbg" >Showing '.( $startIndex + 1 )." to ".( $showNumRow + $startIndex ).' of '.$cnt.'.</div></div>' );
				
				$hlp->searchBox( $parent_tab, $frm_submit, $srctxt, $comboHTML, $frmname, false, false );
				
				while( ( $row = $hlp->_db->db_get( $res ) ) !== false )
				{
					$pid = $row[ 'pid' ];
					$pdate = date( 'l, d F Y',strtotime( $row[ 'pdate' ] ) );
					$pname = $row[ 'pname' ];
					$pgroup = $row[ 'pgroup' ];
					$ptitle = $row[ 'ptitle' ];
					
					
					$caption_style = "color:#8e8e8e;float:left;width:80px;";
					$val_style = "color:#3f95b1;white-space:normal;width:610px;";
					
					echo( '<div name=entrydiv class="gencon bviewdash" style="white-space:nowrap;width:100%;padding-top:10px;" ><table name=tbl class=txt  style="background-color:#f8f8f8;" border=0 width=100%>' );
					echo( '<tr><td align=left valign=top style="width:800px;">
						<div ><table class=txt ><tr><td>' );
					
					echo( '<div id=txt style="color:#10647e;"><b>'.$pname.'</b></div>' );
					echo( '<div style="padding-top:7px;" >
							<table class=txt style="width:650px;" >
								<tr>	
									<td style="'.$caption_style.'" ><b>Category:</b></td><td style="'.$val_style.'" >'.$pgroup.'&#160;</td>
								</tr>
								<tr>	
									<td style="'.$caption_style.'" ><b>Title:</b></td><td style="'.$val_style.'" >'.$hlp->trimText( $ptitle ).'&#160;</td>
								</tr>
							</table>		
						<div></td></tr></table></td><td><div>' );
					
					echo( $hlp->getLinkAncHtml( 'aeditm',60,'asb ','#','tt="Edit :'.addslashes( $pname ).'";addDynTabMain("'.$parent_tab.'","Edit ","'.addslashes( $pname ).'",tt,"'.$me.'?b=prodnew&edt='.base64_encode( $pid ).'",true, true);',20,'images/ic/itick.gif','Edit',$parent_tab ) );
					//echo( $hlp->getLinkAncHtml( 'aeditm',60,'asb ','#','tt="View :'.$pname.'";addDynTabEx("'.$parent_tab.'","View ","'.$pname.'",tt,"'.$me.'?b=prodview&pid='.base64_encode( $pid ).'",true);',20,'images/ic/itick.gif','View',$parent_tab ) );
					echo( $hlp->getLinkAncHtml( 'aeditm',60,'asb ',$me.'?b=prodall&ac=d&pid='.base64_encode( $pid ).'&cid='.base64_encode( $cid ),'confirm( "Are you sure, you want to delete \"'.addslashes( $pname ).'\"?" )',20,'images/ic/itick.gif','Delete',$parent_tab ) );
					
					echo( '</div></td></tr>' );
						
					echo( '</table></div>' );
				}	
			}
			else
				echo( "<div style='padding:20px;' >No products to show for search text \"$srctxt\".</div>" );	
		}
		else
		{
			echo( '<div style="padding-top:15px;"><div class="txtheadwithbg" >Showing 0 of 0.</div></div>' );
			$hlp->searchBox( $parent_tab, $frm_submit, $srctxt, $comboHTML, $frmname, false, false );
			echo( "There are no products to show for search text \"$srctxt\"." );	
		}	
	}
	else
		echo( "<div style='padding:20px;' >No products to show.</div>" );
?>