<?php
	$isProduct = ( $_GET[ 'b' ] == 'prodnew' );
	$szo='';
	$uri = $me.'?b='.$_GET[ 'b' ].'&s&n';
	
	$namefield = 'cname';
	$titlefield = 'ctitle';
	if( $isProduct )
	{
		$namefield = 'pname';
		$titlefield = 'ptitle';
	}	
	
	$pname = $phtml = $pimg = $pgroup = false;	
	$cname = $ctitle = $chtml = $cimg = false;
	
	if(isset($_GET['catid']))
		$pgroup = base64_decode($_GET['catid']);
	
	if( isset( $_GET['s'] ) && isset( $_POST[ $namefield ] ) && isset( $_POST[ 'htmlsrc' ] ) )
	{
		$isnew = isset( $_GET[ 'n' ] );
		
		if( $isProduct )
		{
			$pname = $_POST[ 'pname' ];
			$pgroup = $_POST[ 'pcategory' ];
			$ptitle = $_POST[ 'ptitle' ];
			$phtml = urldecode( $_POST[ 'htmlsrc' ] );
			$pimg = $_POST[ 'selimg' ];
			
			if( $isnew )
				$pid = $hlp->getunqid( $pname );
			else
				$pid = base64_decode( $_GET['s'] );
			
			$err_msg = false;
			if( $hlp->saveProduct( $pname, $phtml, $pid, $pgroup, $ptitle, $pimg ) )
				$szo=( '<div class=txtheadwithbg >Saved</div>' );
			else
				$szo=( '<div class=txtheadwithbg >Saving failed.</div>' );
				
			$phtml = stripslashes( $phtml );
			$uri = $me.'?b='.$_GET[ 'b' ].'&s='.base64_encode( $pid );
		}
		else
		{
			$cname = $_POST[ 'cname' ];
			$ctitle = $_POST[ 'ctitle' ];
			$chtml = $_POST[ 'htmlsrc' ];
			$cimg = $_POST[ 'selimg' ];
			
			if( $isnew )
				$cid = $hlp->getunqid( $cname );
			else
				$cid = base64_decode( $_GET['s'] );
				
			$err_msg = false;
			if( $hlp->saveCategory( $cname, $chtml, $cid, $ctitle, $cimg ) )
				$szo=( '<div class=txtheadwithbg >Saved</div>' );
			else
				$szo=( '<div class=txtheadwithbg >Saving failed.</div>' );
				
			$chtml = stripslashes( $chtml );
			$uri = $me.'?b='.$_GET[ 'b' ].'&s='.base64_encode( $cid );
		}
		
	}
	else if( isset( $_GET['edt'] ) )
	{
		if( $isProduct )
		{
			$pid = base64_decode( $_GET['edt'] );
			
			$q = "select phtml, pimg, pname, pgroup , ptitle from products where pid='$pid';";
			$res = $hlp->_db->db_query( $q );
			if( $res )
			{
				$row = $hlp->_db->db_get( $res );
				$phtml = $row[ 'phtml' ];
				$pimg = $row[ 'pimg' ];
				$pgroup = $row[ 'pgroup' ];
				$ptitle = $row[ 'ptitle' ];
				$pname = $row[ 'pname' ];
				$uri = $me.'?b='.$_GET[ 'b' ].'&s='.base64_encode( $pid );
			}	
		}
		else
		{	
			$cid = base64_decode( $_GET['edt'] );
			
			$q = "select cname, ctitle, chtml, cimg from categories where cid='$cid';";
			$res = $hlp->_db->db_query( $q );
			if( $res )
			{
				$row = $hlp->_db->db_get( $res );
				$chtml = $row[ 'chtml' ];
				$ctitle = $row[ 'ctitle' ];
				$cname = $row[ 'cname' ];
				$cimg = $row[ 'cimg' ];
				$uri = $me.'?b='.$_GET[ 'b' ].'&s='.base64_encode( $cid );
			}
		}
	}
	
	echo( '<body>' );
	
	echo( $szo );
	
	$imgHTML = false;
	if( ( $imgCombo = $hlp->getImageComboBox( ( ( $isProduct )?( $pimg ):( $cimg ) ) ) ) !== false )
		$imgHTML = "<div style='padding-top:10px' ><div style='width:150px;float:left;' >Add Image : </div><div>$imgCombo</div></div>";
	
	echo( '<div class=gencon style="padding-top:3px;">' );
	
	echo('<form name=frmWrt method="post" action="'.$uri.'" >
		'.( ( $isProduct )?( '
		<div><div style="width:150px;float:left;" >Product Category : </div><div>'.$hlp->getProductCategoryCombo( $pgroup ).'</div></div>
		<div style="padding-top:10px" ><div style="width:150px;float:left;" >Product Name : </div><div><input type=text name=pname id=pname value="'.htmlspecialchars ( $pname ).'" style="width:300px;" ></div></div><div style="padding-top:10px" ><div style="width:150px;float:left;" >Product Title : </div><div><input type=text maxlength=200 name=ptitle style="width:300px;" value="'.htmlspecialchars ( $ptitle ).'" ></div></div>'.$imgHTML.'<div style="padding-top:10px;" ><textarea id="htmlsrc" name="htmlsrc" rows="20" cols="80" style="width: 95%">'.$phtml.'</textarea></div>' ):( '
		<div style="padding-top:10px" ><div style="width:150px;float:left;" >Category Name : </div><div><input type=text name=cname id=cname value="'.htmlspecialchars ( $cname ).'" style="width:300px;" ></div></div>
		<div style="padding-top:10px" ><div style="width:150px;float:left;" >Category Title : </div><div><input type=text maxlength=200 name=ctitle style="width:300px;" value="'.htmlspecialchars ( $ctitle ).'" ></div></div>'.$imgHTML.'<div style="padding-top:10px;" ><textarea id="htmlsrc" name="htmlsrc" rows="20" cols="80" style="width: 95%">'.$chtml.'</textarea></div>' ) ).'
		</form>');
	
	$toolbar_type = "BasicToolbar";
	//if( $isProduct )
		//$toolbar_type = "AdToolbar";
	
	/*if( isset( $_GET['edt'] ) )
	{
		$pid = base64_decode($_GET['edt']);
	}*/
	require("ckeditor/init.php");
	$CKEditor = new CKEditor();
	$CKEditor->returnOutput = true;
	
	echo($CKEditor->replace("htmlsrc",array("toolbar"=>$toolbar_type)));
?>

</div>
</body>
