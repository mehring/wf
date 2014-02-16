<style type="text/css">

	.modProjectModal {
		position:fixed;
		top:0;
		left:0;
		z-index:900;
		display:none;
	}
	
	.modProjectModal_bg {
		border-radius:7px;
		position:absolute;
		top:0;
		left:0;
		z-index:1;
		background-color:#000;
		opacity:0.7;
	}
	
	.modProjectModal_inner {
		position:absolute;
		top:0;
		left:0;
		z-index:2;
		border-radius:7px;
		background-image:url(../../assets/img/ui/well_bg.png);
		background-position:center top;
		background-repeat:repeat-x;
		background-color:#EFEFEF;
		border:thin solid #C8C8C8;
	}
	
</style>

<div class="modProjectModal">
	<div class="modProjectModal_bg"></div>
	<div class="modProjectModal_inner">
    	<div style="padding:10px;">
        	<div class="mattswell_title">Modify Project - <div style="display:inline-block;" class="modProject_name"></div></div>
            
            <div class="modProjectModal_loading" style="text-align:center;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>
            <div class="modProjectModal_content">

                <table class="modProjectModal_content_table" cellpadding="0" cellspacing="0" border="0" width="100%">
                	<tr style="background:none;">
                    	<td align="left" valign="top" style="overflow:scroll;">
                        	<div class="tabbable tabs-left">
                              <ul class="nav nav-tabs">
                                <li class="active"><a href="#modProjectPane_general" data-toggle="tab">General Info</a></li>
                                <li><a href="#modProjectPane_groups" data-toggle="tab">Groups</a></li>
                                <li><a href="#modProjectPane_jobs" data-toggle="tab">Allowed Jobs</a></li>
                              </ul>
                              <div class="tab-content">
                                <div class="tab-pane active" id="modProjectPane_general">
                                  <p>I'm in Section A.</p>
                                </div>
                                <div class="tab-pane" id="modProjectPane_groups">
                                  <p>Howdy, I'm in Section B.</p>
                                </div>
                                <div class="tab-pane" id="modProjectPane_jobs">
                                  <p>What up girl, this is Section C.</p>
                                </div>
                              </div>
                            </div>
                        </td>
                    </tr>
                    <tr style="background:none;" class="modProjectModal_content_table_taskbar">
                    	<td align="center">
                        	<a class="btn btn-large btn-danger modProjectModal_button_close"><i class="icon-remove icon-white"></i>&nbsp;Cancel</a>&nbsp;
                            <a class="btn btn-large btn-success modProjectModal_button_save"><i class="icon-ok icon-white"></i>&nbsp;Save and Close</a>&nbsp;
                        </td>
                    </tr>
                </table>
            
            </div>
            
        </div>
    </div>
</div>

<script type="text/javascript">

	function resizemodProjectModal() {
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
		
		$(".modProjectModal").width(WW).height(WH);
		$(".modProjectModal_bg").width(modal_outer_W).height(modal_outer_H).css({"left":modal_outer_L+"px","top":modal_outer_T+"px"});
		$(".modProjectModal_inner").width(modal_inner_W).height(modal_inner_H).css({"left":modal_inner_L+"px","top":modal_inner_T+"px"});;
		$(".modProjectModal_content_table").height(modal_inner_H-50);
		$(".modProjectModal_content_table_taskbar").height($(".modProjectModal_button_save").height());
	}
	
	function hidemodProjectModal() {
		$(".modProjectModal .modProjectModal_inner").fadeOut(function() {
			$(".modProjectModal .modProjectModal_bg").fadeOut(function() {
				$(".modProjectModal").hide();	
			});
		});
	}
	
	function showmodProjectModal(projectID) {
		$(".modProjectModal .modProjectModal_bg").hide();
		$(".modProjectModal .modProjectModal_inner").hide();
		$(".modProjectModal_content").hide();
		$(".modProjectModal_loading").show();
		$(".modProject_name").html("Loading");
		$(".modProjectModal").show();
		$(".modProjectModal .modProjectModal_bg").fadeIn();
		$(".modProjectModal .modProjectModal_inner").fadeIn();
		
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax/modProject_get_project_info")); ?>',
			type: 'post',
			dataType: 'json',
			data: {projectID_to_get:projectID},
			success: function(data) {			
				$('.modProject_name').html(data.project_name);
				$('.modProjectModal_loading').hide();
				$('.modProjectModal_content').show();
			},
			fail: function(data) {
				alert("Error while getting project info: "+data);
				hidemodProjectModal();
			}
		});
		
	}
	
	$(".modProjectModal_button_close").click(function() {hidemodProjectModal();});
	
	$(document).ready(function() {resizemodProjectModal();});
	$(window).resize(function() {resizemodProjectModal();});
	$(window).scroll(function() {resizemodProjectModal();});
</script>