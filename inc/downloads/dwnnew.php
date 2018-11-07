<?php

	$uri = $me.'?b='.$_GET[ 'b' ];
 
	
	if(isset($_GET['s']))
	{
			//print_r($_FILES);
		if(!$_FILES['dfile']['name']=="")
		{
			foreach($_FILES as $f)
			{
				if($f['error']==0)
				{
					$isValidMime = ( $f['type'] == "application/pdf" )|| ( $f['type'] == "application/vnd.ms-powerpoint" ) || ( $f['type'] == "application/msword" )|| ( $f['type'] == "text/plain" ) || ( $f['type'] == "application/vnd.ms-excel" ) || ( $f['type'] == "image/jpeg" ) || ( $f['type'] == "image/png" ) ;
					
					if( $isValidMime )
					{				
						$dname = $f['name'];
					
						$path = $_FILES['dfile']['name'] ;
						
						$ext = pathinfo($path, PATHINFO_EXTENSION);
						
						$did = $hlp->getunqid( $dname ); 	
						
						$filePath = "$DOWNLOAD_DESTINATION".$dname;
						
						
						if( move_uploaded_file( $f['tmp_name'], $filePath ))
						{
							$size = filesize( $filePath );
							
							$q ="insert into downloads( did , dsize , dname , ddate ) values ( '$did' , $size , '$dname' , now() );";
										
							if( ( $res = $hlp->_db->db_query( $q ) ) !== false )
							{
								$hlp->echo_ok( "$dname is now available to download " );
							}
							else
							{
								$hlp->echo_err( "Sorry, unable to add the file. contact support." );
							}
							 
							
						}
						
					} //valid mim
					else
						$hlp->echo_err("File format not supported.Please contact support");
							
				}
				else
					$hlp->echo_err("Saving failed");
			}
			
		}
		else
			$hlp->echo_err("Please upload the neccessary file");	 //img empty		
	}
	
	echo('<form name=frmWrt method="post" action="'.$uri.'&s'.'" enctype="multipart/form-data">
		<!-- <div style="padding-top:10px" >
			<div style="width:150px;float:left;" >Product Name : </div>
			<div><input type=text name=dname id=pname value="" style="width:300px;" ></div>
		</div> -->
		<div style="padding-top:20px" >
			<div style="width:120px;float:left;text-align:center;" >Upload File to be Downloaded : </div>
			<div><input type=file name=dfile value="" style="width:300px;" ></div>
		</div>
		<div>
			<div style="width:320px;text-align:center;padding-top:10px;" ><button type=submit class=roundbutton style="left:10px;width:100px;" 
			>Save</button></div>	
		</div>
	  </form>'
	 );


?>