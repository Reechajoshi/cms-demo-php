<script type="text/javascript"> <!--
	menuInit = function()
	{ 
		var menuid = "TAB_MAIN";
		var doc = document;
		var areaBaseMargin = 25;
		var TAB_BASE_PARAMS = { txtColor: '#0099CB', txtSelectColor: '#fff', tabLImage: "images/tabs/tabtopl.png", tabTImage: "images/tabs/tabtopt.png", tabRImage: "images/tabs/tabtopr.png", tabSideWidth: "5px", borderSelect: "#0099cb 1px solid", extraBackdrop: "#ebf2f8", userTabControl: false };
		
		var areaBaseMarginCB = function(me,stab)
		{
			var vendor = 'MacGregor';
			var h = "<table width=100% height='"+areaBaseMargin+"px'><tr><td align=right valign=center id=orgtxt><div style='color:#000;'>Powered by "+vendor+"&#160;&#160;&#160;&#160;&#160;&#160;</div></td></tr></table>";
			return( h );
		};
		
		var areaTopMargin = 25;
		
		var areaTopMarginCB = function(me,stab)
		{
			
			var h = "";
			h = "<div style='overflow:hidden;width:100%;height:" + areaTopMargin + ";background-color: #0099cb'>";
			h += "<table border=0 cellpadding=0 cellspacing=0 width=100% height=100%><tr><td width=100% align=right valign=middle>";
			h += "<a class=awtxt href=# title=Refresh onClick=\"" + me.getJSRun('refSelectedIFrame()') + "\">Refresh</a>";					
			h += "</td></tr></table>"					
			h += "</div>";				

			return(h);
		};
		
		var tabSideCB = function(me)
		{
			h = '';
			//h = '<div class=gencon style="width:250px;"><div class="asb rviewcell" id=gtxt style="padding-right:10px">User : <?php echo(ucwords( $USERNAME )); ?></div><div class=asb style="padding-left:10px;"><a class=wl href="<?php echo($me) ?>?out=1" target=_top>Logout</a></div></div>';
			return(h);
		}
		
		var tabs = new CTabs.tabs(menuid,{ tabBackground: '#ebf2f8', useFullArea: true, useFullAreaXOff: 5, tabHeadTopPad: ( (CUi._isIE) ? (7) : (0) ), tabViewWidthOffset: 10, tabSideIsOn: true, tabSideCB: tabSideCB, tabRowLeftOffset: 20, roundCorners: true, borderUnSelect: '#0099CB 1px solid' });
		
		<?php 
			echo('tabs.addIFrameTab(menuid + "Products", CUtil.mergeAssoArr( { name: "Products", iframeURL:"'.$me.'?a=prod" }, TAB_BASE_PARAMS ) );');
			echo('tabs.addIFrameTab(menuid + "Enquiries", CUtil.mergeAssoArr( { name: "Enquiries", iframeURL:"'.$me.'?a=enq" }, TAB_BASE_PARAMS ) );');
			echo('tabs.addIFrameTab(menuid + "Downloads", CUtil.mergeAssoArr( { name: "Downloads", iframeURL:"'.$me.'?a=dwn" }, TAB_BASE_PARAMS ) );');
		?>
		
		tabs.setHTML(0);
		
	}
// --></script>