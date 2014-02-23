<style type="text/css">

	.startlog_list {
		border-radius:7px;
		border:thin solid #C8C8C8;
		overflow:scroll;
		background-image:url(../../assets/img/ui/well_bg.png);
		background-position:center top;
		background-repeat:repeat-x;
		background-color:#EFEFEF;
	}
	
	.startlog_list_hover {
		background-color:#FFF;
		cursor:pointer;
	}
	
	.startlog_list_selected {
		font-weight:bold;
		background-color:#00548C;
		background-image:url(../../assets/img/ui/selection_bg.png);
		background-repeat:repeat-x;
		background-position:center top;
		color:#FFF;
	}
	
	.startlog_list_selected > td > .nav > .dropdown > a {
		color:#FFFFFF;
	}
	
	.startlog_list_selected > td > .nav > .dropdown > a > .caret {
		border-top-color:#FFFFFF;
		border-bottom-color:#FFFFFF;
	}
	
	.startlog_list_selected > td > .nav > .dropdown > a:hover {
		color:#08c;
	}
	
	.startlog_list_selected > td > .nav > .dropdown > a:hover > .caret {
		border-top-color:#08c;
		border-bottom-color:#08c;
	}
	
	.clockInModal {
		position:fixed;
		top:0;
		left:0;
		z-index:900;
		display:none;
	}
	
	.clockInModal_inner {
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

<div class="clockInModal">
	
    <input id="startlog_jobID" type="hidden" value="" />
    <input id="startlog_projectID" type="hidden" value="" />
    <input id="startlog_boxID" type="hidden" value="" />
    <input id="startlog_job_name" type="hidden" value="" />
    <input id="startlog_project_name" type="hidden" value="" />
    <input id="startlog_box_name" type="hidden" value="" />
    <input id="startlog_time" type="hidden" value="" />

	<div class="clockInModal_inner">
    	<div style="padding:10px;">
        	<div class="mattswell_title">Clock In - Select a Job, Project and Box</div>
            
            <div class="startlog_pane startlog_table">
                <table width="100%" border="0" cellpadding="5px" cellspacing="5px">
                	<tr>
                    	<td width="30%" align="center" style="font-weight:bold;">1 - Select a Job</td>
                        <td width="35%" align="center" style="font-weight:bold;">2 - Select a Project</td>
                        <td width="35%" align="center" style="font-weight:bold;">3 - Select a Box</td>
                    </tr>
                    <tr>
                    	<td>
                        	<div class="startlog_list startlog_list_jobs"></div>
                        </td>
                        <td>
                        	<div class="startlog_list startlog_list_projects"></div>
                        </td>
                        <td>
                        	<div class="startlog_list startlog_list_boxes"></div>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="3" align="center">
                        	<div class="btn btn-large btn-danger startlog_button_cancel"><i class="icon-remove icon-white"></i>&nbsp;Cancel</div>&nbsp;
                            <div class="btn btn-large btn-success startlog_button_start"><i class="icon-ok icon-white"></i>&nbsp;Start</div>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="startlog_pane startlog_loading" style="display:none; text-align:center;">
            	Clocking in, please wait...<br /><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
            </div>
            
            <div class="startlog_pane startlog_clockedIn" style="display:none; text-align:center;">
            	
				
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                	<tr>
                    	<td width="450" valign="top" align="center">
                        
                        	<img src='<?php echo(base_url("assets/img/ui/icons/icon-success.png")); ?>' style="width:40px;">&nbsp;<strong>You are now clocked in!</strong>
                
                            <table cellpadding="5px" cellspacing="0" border="0" style="margin-top:10px;" width="100%">
                                <tr>
                                    <td align="right" valign="top" width="30%"><strong>Job:</strong></td>
                                    <td align="left" valign="top" class="startlog_field_job"></td>
                                </tr>
                                <tr>
                                    <td align="right" valign="top"><strong>Project:</strong></td>
                                    <td align="left" valign="top" class="startlog_field_project"></td>
                                </tr>
                                <tr>
                                    <td align="right" valign="top"><strong>Box:</strong></td>
                                    <td align="left" valign="top" class="startlog_field_box"></td>
                                </tr>
                                <tr>
                                    <td align="right" valign="top"><strong>Start Time:</strong></td>
                                    <td align="left" valign="top" class="startlog_field_time"></td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" colspan="2">
                                        <div class="btn btn-success startlog_button_gotoselectuser" style="margin:10px; width:200px;"><i class="icon-list icon-white"></i>&nbsp;User Selection</div><br />
                                        <div class="btn btn-primary " onclick="location.reload();" style="width:200px;"><i class="icon-home icon-white"></i>&nbsp;My Dashboard</div>
                                    </td>
                                </tr>
                            </table>
                        
                        </td>
                        <td valign="top" align="center">
                        
                        	<div class="mattswell startlog_help" style="text-align:left; overflow:auto;"></div>
                        
                        </td>
                    </tr>
                </table>

            </div>
            
        </div>
    </div>
</div>

<script type="text/javascript">

	function resizeClockInModal() {
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
		
		$(".clockInModal")
			.width(WW)
			.height(WH);
			
		$(".clockInModal_inner")
			.width(modal_inner_W)
			.height(modal_inner_H)
			.css({"left":modal_inner_L+"px","top":modal_inner_T+"px"});
		
		var startlog_list_H = modal_inner_H - 150;
		$(".startlog_list").height(startlog_list_H);
		$(".startlog_help").height(startlog_list_H + 75);
	}
	
	function hideClockInModal() {
		$(".clockInModal .clockInModal_inner").fadeOut(function() {
			$(".clockInModal").hide();	
		});
	}
	
	function showClockInModal(def_job_id,def_project_id,def_box_id) {
		def_job_id = typeof def_job_id !== 'undefined' ? def_job_id : -1;
		def_project_id = typeof def_project_id !== 'undefined' ? def_project_id : -1;
		def_box_id = typeof def_box_id !== 'undefined' ? def_box_id : -1;
		
		$(".startlog_pane").hide();
		$(".startlog_table").show();
		
		$(".clockInModal .clockInModal_inner").hide();
		$(".clockInModal").show();
		$(".clockInModal .clockInModal_inner").fadeIn();

		$("#startlog_jobID").val("");
		$("#startlog_projectID").val("");
		$("#startlog_boxID").val("");
		$(".startlog_list_jobs").html("<div style='padding:10px; text-align:center;'>Loading list data <img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>");
		$(".startlog_list_projects").html("<div style='padding:10px; text-align:center;'>Loading list data <img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>");
		$(".startlog_list_boxes").html("<div style='padding:10px; text-align:center;'>Select a project first</div>");
		
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_job/getJobsList")); ?>',
			dataType: 'html',
			success: function(data) {
				$(".startlog_list_jobs").html(data);
				
				if (def_job_id!=-1) {
					$(".startlog_list_jobs tr").removeClass("startlog_list_selected");
				    $(".startlog_list_jobs tr[itemID='"+def_job_id+"']").addClass("startlog_list_selected");
					$("#startlog_jobID").val($(".startlog_list_jobs tr[itemID='"+def_job_id+"']").attr("itemID"));
					$("#startlog_job_name").val($(".startlog_list_jobs tr[itemID='"+def_job_id+"']").attr("item_name"));
				}
			},
			fail: function(data) {
				$(".startlog_list_jobs").html("<div style='padding:10px; text-align:center;'>Failed to get list of jobs!</div>");
			}
		});
		
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax/getProjectsList")); ?>',
			dataType: 'html',
			success: function(data) {
				$(".startlog_list_projects").html(data);
				
				if (def_project_id!=-1) {
					$(".startlog_list_projects tr").removeClass("startlog_list_selected");
				    $(".startlog_list_projects tr[itemID='"+def_project_id+"']").addClass("startlog_list_selected");
					$("#startlog_projectID").val($(".startlog_list_projects tr[itemID='"+def_project_id+"']").attr("itemID"));
					$("#startlog_project_name").val($(".startlog_list_projects tr[itemID='"+def_project_id+"']").attr("item_name"));
					
					$("#startlog_boxID").val("");
					$(".startlog_list_boxes").html("<div style='padding:10px; text-align:center;'>Loading list data <img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>");
					
					if(def_project_id == 0) {
						$(".startlog_list_boxes").html('');
					} else {
						$.ajax({
							url: '<?php echo(base_url("index.php/ajax/getBoxList")); ?>',
							type: 'post',
							dataType: 'html',
							data: {project_id:def_project_id},
							success: function(data) {
								$(".startlog_list_boxes").html(data);
								
								if (def_box_id!=-1) {
									$(".startlog_list_boxes tr").removeClass("startlog_list_selected");
									$(".startlog_list_boxes tr[itemID='"+def_box_id+"']").addClass("startlog_list_selected");
									$("#startlog_boxID").val($(".startlog_list_boxes tr[itemID='"+def_box_id+"']").attr("itemID"));
									$("#startlog_box_name").val($(".startlog_list_boxes tr[itemID='"+def_box_id+"']").attr("item_name"));
								}
							},
							fail: function(data) {
								$(".startlog_list_boxes").html("<div style='padding:10px; text-align:center;'>Failed to get list of projects!</div>");
							}
						});
					}
					
				}
			},
			fail: function(data) {
				$(".startlog_list_projects").html("<div style='padding:10px; text-align:center;'>Failed to get list of projects!</div>");
			}
		});

	}
	
	$(".startlog_button_cancel").click(function() {hideClockInModal()});

	$(".startlog_list tbody tr").live("mouseover", function() {$(this).addClass("startlog_list_hover");});
	
	$(".startlog_list tbody tr").live("mouseout", function() {$(this).removeClass("startlog_list_hover");});
	
	$('.box_status_link').live('click', function() {
		var box_id = $(this).attr('box_id');
		var status_id = $(this).attr('status_id');
		var status_name = $(this).html();
		$('#box_status_'+box_id).html(status_name + "&nbsp;<span class=\"caret\"></span>");
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_box/change_box_status")); ?>',
			type: 'post',
			data: {box_to_change:box_id,status_to_change:status_id}
		});
	});
	
	$(".startlog_list_jobs tbody tr").live("click", function() {
		$(".startlog_list_jobs tr").removeClass("startlog_list_selected");
		$(this).addClass("startlog_list_selected");
		$("#startlog_jobID").val($(this).attr("itemID"));
		$("#startlog_job_name").val($(this).attr("item_name"));
	});
	
	$(".startlog_list_projects tbody tr").live("click", function() {
		$(".startlog_list_projects tr").removeClass("startlog_list_selected");
		$(this).addClass("startlog_list_selected");
		var project_id_clicked = $(this).attr("itemID");
		$("#startlog_projectID").val(project_id_clicked);
		$("#startlog_project_name").val($(this).attr("item_name"));
		
		$("#startlog_boxID").val("");
		$(".startlog_list_boxes").html("<div style='padding:10px; text-align:center;'>Loading list data <img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>");
		
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax/getBoxList")); ?>',
			type: 'post',
			dataType: 'html',
			data: {project_id:project_id_clicked},
			success: function(data) {
				$(".startlog_list_boxes").html(data);
			},
			fail: function(data) {
				$(".startlog_list_boxes").html("<div style='padding:10px; text-align:center;'>Failed to get list of projects!</div>");
			}
		});
	});
	
	$(".startlog_list_boxes tbody tr").live("click", function() {
		$(".startlog_list_boxes tr").removeClass("startlog_list_selected");
		$(this).addClass("startlog_list_selected");
		$("#startlog_boxID").val($(this).attr("itemID"));
		$("#startlog_box_name").val($(this).attr("item_name"));
	});
	
	$(".startlog_button_gotoselectuser").click(function() {window.location = "<?php echo(base_url("index.php/ww/userselect")); ?>";});
	
	$(".startlog_button_gotodashboard").click(function() {
		var name_job = $("#startlog_job_name").val();
		var name_project = $("#startlog_project_name").val();
		var name_box = $("#startlog_box_name").val();
		var id_job = $("#startlog_jobID").val();
		var id_project = $("#startlog_projectID").val();
		var id_box = $("#startlog_boxID").val();
		var name_time = $("#startlog_time").val();
		hideClockInModal();
		$(".dash_cur_job").attr("itemID",id_job).html(name_job);
		$(".dash_cur_project").attr("itemID",id_project).html(name_project);
		$(".dash_cur_box").attr("itemID",id_box).html(name_box);
		$(".dash_cur_start").html(name_time);
		$(".info_clockout").show();
		$(".info_clockin").hide();
		updateWidget_stats()
		sync_heights();
	});
	
	$(".startlog_button_start").click(function() {
		var id_job = $("#startlog_jobID").val();
		var id_project = $("#startlog_projectID").val();
		var id_box = $("#startlog_boxID").val();
		var name_job = $("#startlog_job_name").val();
		var name_project = $("#startlog_project_name").val();
		var name_box = $("#startlog_box_name").val();
		
		if (!id_job || !id_project || !id_box) {
			var text_error = "Please select a job, project, and box before clicking start. \n";
			if(!id_job) {text_error += "\nMissing job selection."}
			if(!id_project) {text_error += "\nMissing project selection."}
			if(!id_box) {text_error += "\nMissing box selection."}
			alert(text_error);
		} else {
			$(".startlog_table").fadeOut("fast", function() {
				$(".startlog_loading").fadeIn("fast", function() {
				
					$.ajax({
						url: '<?php echo(base_url("index.php/ajax_user/clock_in")); ?>',
						type: 'post',
						dataType: 'json',
						data: {job_id:id_job, project_id:id_project, box_id:id_box},
						success: function(data) {
							$("#startlog_time").val(data.start_time);
							
							$(".startlog_field_job").html(name_job);
							$(".startlog_field_project").html(name_project);
							$(".startlog_field_box").html(name_box);
							$(".startlog_field_time").html(data.start_time);
							$(".startlog_help").html(data.help_content);
							
							$(".startlog_loading").fadeOut("fast",function() {$(".startlog_clockedIn").fadeIn("slow");});
						},
						fail: function(data) {
							alert("Failed: "+data);
							$(".startlog_loading").hide();
							$(".startlog_table").show();
						}
					});
				
				});
			});
			
			
		}
		
	});
	
	$(document).ready(function() {resizeClockInModal();});
	$(window).resize(function() {resizeClockInModal();});
	$(window).scroll(function() {resizeClockInModal();});

</script>