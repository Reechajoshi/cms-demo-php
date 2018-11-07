<?php
	$parent_tab = 'TAB_ENQUIRIES';
	$pgnum = 1;
	$frm_submit = "$me?b=enqall";
	$comboHTML = false;
	$srctxt = false;
	$frmname = "allenq";
	//$eid = false;
	
	if( isset( $_GET[ 'ac' ] ) )
	{
		if( $_GET[ 'ac' ] == 'd' )
		{
			$eid = base64_decode( $_GET[ 'eid' ] );
			$q = "delete from enquiry where eid='$eid';";
			
			if( $hlp->_db->db_query( $q ) )
				$hlp->echo_ok( "Enquiry removed." );
			else
				$hlp->echo_err( "Sorry, unable to remove enquiry" );
		}
	
		if( $_GET[ 'ac' ] == 'a' )
		{
		
			$eid = base64_decode( $_GET[ 'eid' ] );
			$q = "update enquiry set eack= true where eid='$eid';";
			
			if( $hlp->_db->db_query( $q ) )
				$hlp->echo_ok( "" );
			else
				$hlp->echo_err( "Error" );
		}
	}
	//$pid = $hlp->getunqid( $pname );
	if( isset( $_GET['cbo'] ) )
	{
	
		$pgnum = $_POST['pageCombo'];
		$srctxt = trim( $_POST[ 'cbosrctxt' ] );
	}	
	
	if( isset( $_POST[ 'srctxt' ] ) )
	{
		
		$srctxt = trim( $_POST[ 'srctxt' ] );
	}
	$allx = $hlp->_db->db_return( "select count(*) cnt from enquiry;", array( 'cnt' ) );
	$allcnt = intval( $allx[0] );
	
	if( $allcnt > 0 )
	{
	
			$q = "select count(*) cnt from enquiry  where ename like '%$srctxt%';";
	
		$cntx = $hlp->_db->db_return( $q, array( "cnt" ) );
	
		$cnt = intval( $cntx[0] );
		//
		
		if( $cnt > 0 )
		{
			$q = "select eid,ename, email,econt,enote,eack,edate from enquiry where ename like '%$srctxt%' order by edate desc";
		
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
					$eack = $row['eack'];
					$ename = $row[ 'ename' ];
					$email = $row[ 'email' ];
					$econt = $row[ 'econt' ];
					$enote = $row[ 'enote' ];
					$edate = $row[ 'edate' ];
					$eid=$row['eid'];
	
					$caption_style = "color:#8e8e8e;float:left;width:80px;";
					$val_style = "color:#3f95b1;white-space:normal;width:610px;";
					
					echo( '<div name=entrydiv class="gencon bviewdash" style="white-space:nowrap;width:100%;padding-top:10px;" ><table name=tbl class=txt  style="background-color:#f8f8f8;" border=0 width=100%>' );
					echo( '<tr><td align=left valign=top style="width:800px;">
						<div ><table class=txt ><tr><td>' );
					
					echo( '<div id=txt style="color:#10647e;"><b>'.$ename.'</b></div>' );
					echo( '<div style="padding-top:7px;" >
							<table class=txt style="width:650px;" >
								<tr>	
									<td style="'.$caption_style.'" ><b>Name:</b></td><td style="'.$val_style.'" >'.$ename.'&#160;</td>
								</tr>
								<tr>	
									<td style="'.$caption_style.'" ><b>Email:</b></td><td style="'.$val_style.'" >'.$email.'&#160;</td>
								</tr>
								<tr>	
									<td style="'.$caption_style.'" ><b>Date:</b></td><td style="'.$val_style.'" >'.substr($edate,0,10).'&#160;</td>
								</tr>
							</table>		
						<div></td></tr></table></td><td><div>' );
					
					//echo( $hlp->getLinkAncHtml( 'aeditm',60,'asb ','#','tt="Edit :'.addslashes( $pname ).'";addDynTabMain("'.$parent_tab.'","Edit ","'.addslashes( $pname ).'",tt,"'.$me.'?b=prodnew&edt='.base64_encode( $pid ).'",true, true);',20,'images/ic/itick.gif','Edit',$parent_tab ) );
					echo( $hlp->getLinkAncHtml( 'aeditm',60,'asb ','#','tt="View :'.$ename.'";addDynTabEx("'.$parent_tab.'","View ","'.$ename.'",tt,"'.$me.'?b=enqview&eid='.base64_encode( $eid ).'",true);',20,'images/ic/itick.gif','View',$parent_tab ) );
					if($eack==false)
					{	
						echo( $hlp->getLinkAncHtml( 'aeditm',60,'asb ',$me.'?b=enqall&ac=a&eid='.base64_encode( $eid ),'',20,'images/ic/itick.gif','Answered',$parent_tab ) );
					}
					echo( $hlp->getLinkAncHtml( 'aeditm',60,'asb ',$me.'?b=enqall&ac=d&eid='.base64_encode( $eid ),'confirm( "Are you sure, you want to delete \"'.addslashes( $ename ).'\"?" )',20,'images/ic/itick.gif','Delete',$parent_tab ) );

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
			echo( "There are no Enquiries to show for search text \"$srctxt\"." );	
		}	
	}
	else
		echo( "<div style='padding:20px;' >No Enquiries to show.</div>" );
?>