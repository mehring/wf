<style type="text/css">

	.modUserModal {
		position:fixed;
		top:0;
		left:0;
		z-index:900;
		display:none;
	}
	
	.modUserModal_bg {
		border-radius:7px;
		position:absolute;
		top:0;
		left:0;
		z-index:1;
		background-color:#000;
		opacity:0.7;
	}
	
	.modUserModal_inner {
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

<div class="modUserModal">
	<div class="modUserModal_bg"></div>
	<div class="modUserModal_inner">
    	<div style="padding:10px;">
        	<div class="mattswell_title">Modify User - <div style="display:inline-block;" class="modUser_name"></div></div>
            
            <div class="modUserModal_loading" style="text-align:center;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>
            <div class="modUserModal_content">

                <table class="modUserModal_content_table" cellpadding="0" cellspacing="0" border="0" width="100%">
                	<tr style="background:none;">
                    	<td align="left" valign="top" style="overflow:scroll;">
                        	<div class="tabbable tabs-left">
                              <ul class="nav nav-tabs">
                                <li class="active"><a href="#modUserPane_general" data-toggle="tab">General Info</a></li>
                                <li><a href="#modUserPane_groups" data-toggle="tab">Groups</a></li>
                                <li><a href="#modUserPane_jobs" data-toggle="tab">Allowed Jobs</a></li>
                              </ul>
                              <div class="tab-content">
                                <div class="tab-pane active" id="modUserPane_general">
                                  <p>I'm in Section A.</p>
                                </div>
                                <div class="tab-pane" id="modUserPane_groups">
                                  <p>Howdy, I'm in Section B.</p>
                                </div>
                                <div class="tab-pane" id="modUserPane_jobs">
                                  <p>What up girl, this is Section C.</p>
                                </div>
                              </div>
                            </div>
                        </td>
                    </tr>
                    <tr style="background:none;" class="modUserModal_content_table_taskbar">
                    	<td align="center">
                        	<a class="btn btn-large btn-danger modUserModal_button_close"><i class="icon-remove icon-white"></i>&nbsp;Cancel</a>&nbsp;
                            <a class="btn btn-large btn-success modUserModal_button_save"><i class="icon-ok icon-white"></i>&nbsp;Save and Close</a>&nbsp;
                        </td>
                    </tr>
                </table>
            
            </div>
            
        </div>
    </div>
</div>

<script type="text/javascript">

	function resizeModUserModal() {
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
		
		$(".modUserModal").width(WW).height(WH);
		$(".modUserModal_bg").width(modal_outer_W).height(modal_outer_H).css({"left":modal_outer_L+"px","top":modal_outer_T+"px"});
		$(".modUserModal_inner").width(modal_inner_W).height(modal_inner_H).css({"left":modal_inner_L+"px","top":modal_inner_T+"px"});;
		$(".modUserModal_content_table").height(modal_inner_H-50);
		$(".modUserModal_content_table_taskbar").height($(".modUserModal_button_save").height());
	}
	
	function hideModUserModal() {
		$(".modUserModal .modUserModal_inner").fadeOut(function() {
			$(".modUserModal .modUserModal_bg").fadeOut(function() {
				$(".modUserModal").hide();	
			});
		});
	}
	
	function showModUserModal(userID) {
		$(".modUserModal .modUserModal_bg").hide();
		$(".modUserModal .modUserModal_inner").hide();
		$(".modUserModal_content").hide();
		$(".modUserModal_loading").show();
		$(".modUser_name").html("Loading");
		$(".modUserModal").show();
		$(".modUserModal .modUserModal_bg").fadeIn();
		$(".modUserModal .modUserModal_inner").fadeIn();
		
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_user/mod_user_get_user_info")); ?>',
			type: 'post',
			dataType: 'json',
			data: {userID_to_get:userID},
			success: function(data) {			
				$('.modUser_name').html(data.user_name);
				$('.modUserModal_loading').hide();
				$('.modUserModal_content').show();
			},
			fail: function(data) {
				alert("Error while getting user info: "+data);
				hideModUserModal();
			}
		});
		
	}
	
	$(".modUserModal_button_close").click(function() {hideModUserModal();});
	
	$(document).ready(function() {resizeModUserModal();});
	$(window).resize(function() {resizeModUserModal();});
	$(window).scroll(function() {resizeModUserModal();});
</script>