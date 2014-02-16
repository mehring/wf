<style type="text/css">

	.viewReportModal {
		position:fixed;
		top:0;
		left:0;
		z-index:900;
		display:none;
	}
	
	.viewReportModal_inner {
		position:absolute;
		top:0;
		left:0;
		z-index:2;
		border-radius:7px;
		background-image:url(../../assets/img/ui/well_bg.png);
		background-position:center top;
		background-repeat:repeat-x;
		background-color:#EFEFEF;
		border:9px solid rgba(0,0,0,0.40);
		-webkit-background-clip: padding-box; /* for Safari */
    	background-clip: padding-box; /* for IE9+, Firefox 4+, Opera, Chrome */
	}
	
</style>

<div class="viewReportModal">
	<div class="viewReportModal_inner">
    	<div style="padding:10px;">
        	<div class="mattswell_title">View Report For - <div style="display:inline-block;" class="viewReport_name"></div></div>
            
            <div class="viewReportModal_loading" style="text-align:center;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>
            <div class="viewReportModal_content">

                <table class="viewReportModal_content_table" cellpadding="0" cellspacing="0" border="0" width="100%">
                	<tr style="background:none;">
                    	<td align="left" valign="top">
							<div class="report_content"></div>
                        </td>
                    </tr>
                    <tr style="background:none;" class="viewReportModal_content_table_taskbar">
                    	<td align="center">
                            <a class="btn btn-large btn-success viewReportModal_button_save"><i class="icon-ok icon-white"></i>&nbsp;Ok</a>&nbsp;
                        </td>
                    </tr>
                </table>
            
            </div>
            
        </div>
    </div>
</div>

<script type="text/javascript">

	function resizeviewReportModal() {
		var WW = $(window).width();
		var WH = $(window).height();
		
		var modal_inner_W = WW-80;
		var modal_inner_H = WH-80;
		var modal_inner_T = (WH/2) - (modal_inner_H/2);
		var modal_inner_L = (WW/2) - (modal_inner_W/2);
		
		var modal_outer_W = WW-50;
		var modal_outer_H = WH-50;
		var modal_outer_T = (WH/2) - (modal_outer_H/2);
		var modal_outer_L = (WW/2) - (modal_outer_W/2);
		
		$(".viewReportModal").width(WW).height(WH);
		$(".viewReportModal_inner").width(modal_inner_W).height(modal_inner_H).css({"left":modal_inner_L+"px","top":modal_inner_T+"px"});;
		$(".viewReportModal_content_table").height(modal_inner_H-50);
		$(".viewReportModal_content_table_taskbar").height($(".viewReportModal_button_save").height());
		$(".report_content").css({"max-height":modal_inner_H-112,"overflow-y":"auto"});
	}
	
	function hideviewReportModal() {
		$(".viewReportModal .viewReportModal_inner").fadeOut(function() {
			$(".viewReportModal").hide();	
		});
	}
	
	function showviewReportModal(report_title,report_html) {
		$(".viewReport_name").html(report_title);
		$(".report_content").html(report_html);
		$(".viewReportModal .viewReportModal_inner").hide();
		$(".viewReportModal_content").show();
		$(".viewReportModal_loading").hide();
		$(".viewReportModal").show();
		$(".viewReportModal .viewReportModal_inner").fadeIn();
	}
	
	$(".viewReportModal_button_save").click(function() { hideviewReportModal(); });
	

	$(document).ready(function() {

		resizeviewReportModal();
			
	});
	$(window).resize(function() {resizeviewReportModal();});
	$(window).scroll(function() {resizeviewReportModal();});
</script>