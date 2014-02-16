<style type="text/css">

	.modTaskModal {
		position:fixed;
		top:0;
		left:0;
		z-index:900;
		display:none;
	}

	.modTaskModal_inner {
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

<div class="modTaskModal">
	<div class="modTaskModal_inner">
    	<div style="padding:10px;">
        	<div class="mattswell_title"><span class="task_title"></span> Task</div>
            
            <div class="modTaskModal_loading" style="text-align:center;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>
            <div class="modTaskModal_content">
                <input type="hidden" class="task_id" value="-1" />
                <table class="modTaskModal_content_table" cellpadding="0" cellspacing="0" border="0" width="100%">
                	<tr style="background:none;">
                    	<td align="left" valign="top" width="250">

                            <label>Job</label>
                            <select class="task_job"></select>

                            <label>Project</label>
                            <select class="task_project"></select>

                            <label>Priority</label>
                            <input type="radio" name="task_priority" value="0" />&nbsp;<span class="label">None</span><br />
                            <input type="radio" name="task_priority" value="1" />&nbsp;<span class="label label-success">Low</span><br />
                            <input type="radio" name="task_priority" value="2" />&nbsp;<span class="label label-warning">High</span><br />
                            <input type="radio" name="task_priority" value="3" />&nbsp;<span class="label label-important">Critical</span>

                        </td>
                        <td style="overflow-y: auto;">

                            <div style="width:200px; display:inline-block; float:left; margin-right:15px;" class="task-assign-list">
                                <h4>Users&nbsp;
                                    <div class="btn-group">
                                        <button class="btn btn-mini button_task_assign_user_all">All</button>
                                        <button class="btn btn-mini button_task_assign_user_none">None</button>
                                    </div>
                                </h4>

                                <?php foreach ($users as $user) { ?>
                                    <label class="checkbox"><input class="task_user_item" user_id="<?php echo $user->id; ?>" type="checkbox"> <?php echo $user->user_name; ?></label>
                                <?php } ?>
                            </div>

                            <div style="width:200px; display:inline-block; float:left;" class="task-assign-list">
                                <h4>Groups&nbsp;
                                    <div class="btn-group">
                                        <button class="btn btn-mini button_task_assign_group_all">All</button>
                                        <button class="btn btn-mini button_task_assign_group_none">None</button>
                                    </div>
                                </h4>
                                <?php foreach ($groups as $group) { ?>
                                    <label class="checkbox"><input class="task_group_item" group_id="<?php echo $group->id; ?>" type="checkbox"> <?php echo $group->group_name; ?></label>
                                <?php } ?>
                            </div>

                        </td>
                    </tr>
                    <tr style="background:none;" class="modTaskModal_content_table_taskbar">
                    	<td align="center" colspan="2">
                        	<a class="btn btn-large btn-danger modTaskModal_button_close"><i class="icon-remove icon-white"></i>&nbsp;Cancel</a>&nbsp;
                            <a class="btn btn-large btn-success modTaskModal_button_save"><i class="icon-ok icon-white"></i>&nbsp;Save and Close</a>&nbsp;
                        </td>
                    </tr>
                </table>
            
            </div>
            
        </div>
    </div>
</div>

<script type="text/javascript">

	function resizemodTaskModal() {
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
		
		$(".modTaskModal").width(WW).height(WH);
		$(".modTaskModal_inner").width(modal_inner_W).height(modal_inner_H).css({"left":modal_inner_L+"px","top":modal_inner_T+"px"});;
		$(".modTaskModal_content_table").height(modal_inner_H-50);
		$(".modTaskModal_content_table_taskbar").height($(".modTaskModal_button_save").height());
		$(".task-assign-list").css({"max-height":modal_inner_H-112,"overflow-y":"auto"});
	}
	
	function hidemodTaskModal() {
		$(".modTaskModal .modTaskModal_inner").fadeOut(function() {
			$(".modTaskModal").hide();	
		});
	}
	
	function showmodTaskModal(taskID) {
		
		$('.task_id').val(taskID);
		
		if (taskID == -1) {
			$('.task_title').html('Add');
		} else {
			$('.task_title').html('Modify');
		}
		
		$(".modTaskModal .modTaskModal_inner").hide();
		$(".modTaskModal_content").hide();
		$(".modTaskModal_loading").show();
		$(".modTask_name").html("Loading");
		$(".modTaskModal").show();
		$(".modTaskModal .modTaskModal_inner").fadeIn();
		
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_task/modTask_get_task_info")); ?>',
			type: 'post',
			dataType: 'json',
			data: {taskID_to_get:taskID},
			success: function(data) {

				$('.task_job').find('option').remove().end();
				$('.task_job').append('<option value="-1">Select One</option>');
				for(var i=0;i<data.jobs.length;i++) {
					var cur_job_id = data.jobs[i].id;
					var cur_job_name = data.jobs[i].job_name;
					$('.task_job').append('<option value="'+cur_job_id+'">'+cur_job_name+'</option>');
				}
				if(data.job_id != -1) { $('.task_job').val(data.job_id); }
				
				$('.task_project').find('option').remove().end();
				$('.task_project').append('<option value="-1">Select One</option>');
				for(var i=0;i<data.projects.length;i++) {
					var cur_project_id = data.projects[i].id;
					var cur_project_name = data.projects[i].project_name;
					$('.task_project').append('<option value="'+cur_project_id+'">'+cur_project_name+'</option>');
				}
				if(data.project_id != -1) { $('.task_project').val(data.project_id); }
				
				if (data.priority == -1) {
					$('input[name="task_priority"][value="0"]').prop('checked',true);
				} else {
					$('input[name="task_priority"][value="'+data.priority+'"]').prop('checked',true);
				}
				
				$('.task_group_item').prop('checked',false);
				$('.task_user_item').prop('checked',false);
				
				if (data.task_members.length) {
					for (var i=0;i<data.task_members.length;i++) {
						if (data.task_members[i].user_id) {
							$('.task_user_item[user_id="'+data.task_members[i].user_id+'"]').prop('checked',true);
						} else {
							$('.task_group_item[group_id="'+data.task_members[i].group_id+'"]').prop('checked',true);
						}
					}
				}
				
				if (taskID == -1) {
					var job_id = $('.tasks_jobSelector').val();
					var project_id = $('.tasks_projectSelector').val();
					$('.task_job').val(job_id);
					$('.task_project').val(project_id);
				}
				
				$('.modTaskModal_loading').hide();
				$('.modTaskModal_content').show();
			}
		});
		
	}
	
	$(".button_task_assign_group_all").click(function() {$(".task_group_item").prop("checked",true)});
	$(".button_task_assign_group_none").click(function() {$(".task_group_item").prop("checked",false)});
	$(".button_task_assign_user_all").click(function() {$(".task_user_item").prop("checked",true)});
	$(".button_task_assign_user_none").click(function() {$(".task_user_item").prop("checked",false)});
	
	
	$(".modTaskModal_button_save").click(function() {
		var assigned_id = $('.task_id').val();
		var assigned_users = new Array();
		var assigned_groups = new Array();
		var assigned_job = $(".task_job").val();
		var assigned_project = $(".task_project").val();
		var assigned_priority = 0;
		
		if (assigned_job == -1) { alert("Select a job first."); return; }
		if (assigned_project == -1) { alert("Select a project first."); return; }
		
		$(".task_user_item").each(function() {
			if($(this).is(":checked")) {
				var this_id = $(this).attr("user_id");
				assigned_users.push(this_id);
			}
		});
		
		$(".task_group_item").each(function() {
			if($(this).is(":checked")) {
				var this_id = $(this).attr("group_id");
				assigned_groups.push(this_id);
			}
		});
		
		$('input[name="task_priority"]').each(function() {
			if ($(this).is(":checked")) {
				assigned_priority = $(this).val();
			}
		});
		
		$(".modTaskModal_content").hide();
		$(".modTaskModal_loading").show();
		$(".modTask_name").html("Saving");
		
		$.ajax({
			url:'<?php echo(base_url("index.php/ajax_task/modTask_save_task")); ?>',
			type:'POST',
			dataType: 'json',
			data: {
				assigned_id:assigned_id,
				assigned_users:assigned_users,
				assigned_groups:assigned_groups,
				assigned_job:assigned_job,
				assigned_project:assigned_project,
				assigned_priority:assigned_priority
			},
			success: function(data) {
				
				refresh_admin_tasks_list();
				hidemodTaskModal()
			},
			complete: function(data) {
				console.log(data);
			}
		});
		
	});
	
	$(".modTaskModal_button_close").click(function() {hidemodTaskModal();});
	
	$(document).ready(function() {resizemodTaskModal();});
	$(window).resize(function() {resizemodTaskModal();});
	$(window).scroll(function() {resizemodTaskModal();});
</script>