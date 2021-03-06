<style type="text/css">
	
	tbody tr {
		background-color:transparent;
	}
	
	.text_active {
		color:#49A942;
	}
	
	.text_hidden {
		color:#999;
		font-style:italic;
	}
	
	.custom_select_label {
		
	}
	
	.custom_select {
		font-size:18px;
		height:35px;
		width:100%;
		margin-top:5px;
	}
	
</style>

<div class="admin_help_projectSelector mattswell" style="text-align:left;display:none;"></div>

<div class="admin_help_loading" style="text-align:center;display:none;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>

<div class="admin_help_body" style="text-align:left;display:none; margin-top:10px;">
	<div class="mattswell_title" style="padding-top:10px;">Help Files</div>
    
    <div class="btn-group" style="display:inline-block;float:left;">
    	<button class="btn button_admin_add_help"><i class="icon-plus"></i> New Help</button>
        <button class="btn button_admin_add_helpfromexisting"><i class="icon-plus"></i> New Help From Existing</button>
        <button class="btn button_admin_addall_helpfromexisting"><i class="icon-plus"></i> Copy Help From Existing Project</button>
    </div>
    
	<div style="clear:both;"></div>
    
    <div class="admin_help_list" style="margin-top:15px;">
    	
    </div>
</div>

<div class="modal hide modal_addHelp">
  <div class="modal-header">
  	<input type="hidden" class="help_project_id">
    <button type="button" class="close button_close_addHelp" aria-hidden="true">&times;</button>
    <h3>Add Help</h3>
  </div>
  <div class="modal-body">
    <table width="100%" cellpadding="4px" cellspacing="0" border="0">
		<tr style="background-color:transparent;">
            <td align="right" style="width:100px; font-weight:bold;">Project:</td>
            <td><span class="project_name_selected"></span></td>
        </tr>
        <tr style="background-color:transparent;">
            <td align="right" style="width:100px; font-weight:bold;">Job:</td>
            <td>
                <select class="admin_help_filter_job" style="width:100%;margin-bottom:0px;"></select>
            </td>
        </tr>
    </table>
  </div>
  <div class="modal-footer modal_addProject_footer">
    <a href="#" class="btn btn-danger button_close_addHelp"><i class="icon-remove icon-white"></i>&nbsp;Close</a>
    <a href="#" class="btn btn-primary button_addProject_submit"><i class="icon-ok icon-white"></i>&nbsp;Submit</a>
  </div>
</div>

<div class="modal hide modal_copyHelp">
  <div class="modal-header">
    <button type="button" class="close button_close_copyHelp" aria-hidden="true">&times;</button>
    <h3>Add Help From Existing</h3>
  </div>
  <div class="modal-body modal_copyHelp_body">

    	<table width="100%" cellpadding="4px" cellspacing="0" border="0">
        	<tr style="background-color:transparent; width:100px;">
            	<td align="right" style="font-weight:bold;">Job:</td>
                <td><select class="field_copyHelp_job" style="width:100%;margin-bottom:0px;"></select></td>
            </tr>
            <tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;">Project:</td>
                <td><select class="field_copyHelp_project" style="width:100%;margin-bottom:0px;"></select></td>
            </tr>
        </table>

    <div class="modal_copyHelp_loading" style="text-align:center; display:none;">
    	Loading...<br />
    	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
    </div>
  </div>
  <div class="modal-footer modal_copyHelp_footer">
    <a href="#" class="btn btn-danger button_close_copyHelp"><i class="icon-remove icon-white"></i>&nbsp;Close</a>
    <a href="#" class="btn btn-primary button_CopyHelp_submit"><i class="icon-ok icon-white"></i>&nbsp;Submit</a>
  </div>
</div>

<div class="modal hide modal_copyallHelp">
  <div class="modal-header">
    <button type="button" class="close button_close_copyallHelp" aria-hidden="true">&times;</button>
    <h3>Add All Help From Existing Project</h3>
  </div>
  <div class="modal-body modal_copyallHelp_body">

    	<table width="100%" cellpadding="4px" cellspacing="0" border="0">
            <tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold; width:100px;">Project:</td>
                <td><select class="field_copyallHelp_project" style="width:100%;margin-bottom:0px;"></select></td>
            </tr>
        </table>

    <div class="modal_copyallHelp_loading" style="text-align:center; display:none;">
    	Loading...<br />
    	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
    </div>
  </div>
  <div class="modal-footer modal_copyallHelp_footer">
    <a href="#" class="btn btn-danger button_close_copyallHelp"><i class="icon-remove icon-white"></i>&nbsp;Close</a>
    <a href="#" class="btn btn-primary button_CopyallHelp_submit"><i class="icon-ok icon-white"></i>&nbsp;Submit</a>
  </div>
</div>

<script type="text/javascript">
	
	var cur_help = new Array();
	
	function refresh_admin_help_list(project_id) {
		var html_to_set = "";
		
		if (!project_id || project_id < 0) {
			//do nothing
		} else {
			$(".admin_help_loading").show();
			$(".admin_help.body").hide();
			$.ajax({
				url: '<?php echo(base_url("index.php/ajax_project/get_help")); ?>',
				type: 'post',
				dataType: 'json',
				data: {project_id:project_id},
				success: function(data) {
					cur_help = data;
					if (data.length == 0) {
						html_to_set = "No help files were found.";
					} else {
						html_to_set = "<table class=\"table hover_table solid_table table-condensed\">\
											<thead><tr>\
												<th style=\"width:20px;\"></th>\
												<th>Job</th>\
												<th>Actions</th>\
											</tr></thead>\
											<tbody>";
						
						for (var i=0;i<data.length;i++) {
							
							var row_to_add = "<tr class=\"help_row\">\
												<td><img src=\"<?php echo base_url("assets/img/ui/icons/help.png"); ?>\" /></td>\
												<td>"+data[i].job_name+"</td>\
												<td>\
												  <a class=\"admin_button black button_admin_modify_help\" style=\"color:black;\"  help_id=\""+data[i].id+"\"><span class=\"ico-edit\"></span>&nbsp;Modify</a>\
												  <a class=\"admin_button red button_admin_delete_help\" style=\"color:red;\"  help_id=\""+data[i].id+"\"><span class=\"ico-trash\"></span>&nbsp;Delete</a>\
												</td>";
												
							html_to_set = html_to_set + row_to_add;
						}
						
						html_to_set = html_to_set + "</tbody></table>";

					}
					
				},
				complete: function(data) {
					$(".admin_help_list").html(html_to_set);
					$(".admin_help_loading").hide();
					$(".admin_help_body").show();
				}
			});
			
		}
	}
	
	function refresh_admin_help_projectselector_list() {
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_box/get_admin_help_projectselector_list")); ?>',
			dataType: 'html',
			success: function(data) {
				$('.admin_help_projectSelector').html(data);
				$('.admin_help_projectSelector').show();
			},
			error: function(data) {
				alert("Error while updating project selector list: "+data);
				$('.admin_help_projectSelector').show();
				$('.admin_help').hide();
				$('.admin_help_loading').hide();
			}
		});
	}
	
	$(document).ready(function() {
		refresh_admin_help_projectselector_list();
		
		for(var i=0;i<job_list.length;i++) {
			var item_to_append = "<option value=\""+job_list[i].id+"\">"+job_list[i].job_name+"</option>";
			$('.admin_help_filter_job').append(item_to_append);
		}
		
	});
	
	$(".button_admin_add_help").click(function() { showaddHelpModal(); });
	$(".button_close_copyHelp").click(function() { $(".modal_copyHelp").modal("hide"); });
	$(".button_close_copyallHelp").click(function() { $(".modal_copyallHelp").modal("hide"); });
	
	$(".button_CopyallHelp_submit").click(function() {
		var project_id = $(".field_copyallHelp_project").val();
		var cur_project_id = $(".help_projectSelector").val();
		if (project_id == -1) {
			alert("Select a project to copy from first.");
		} else {
			$.ajax({
				async:false,
				url:"<?php echo(base_url("index.php/ajax_help/copy_all_help")); ?>",
				dataType:"json",
				data: {
					project_id:project_id,
					cur_project_id:cur_project_id
				},
				success:function(data) {
					console.log(data);
					alert(data.cnt + " help file(s) copied.");
					$(".modal_copyallHelp").modal("hide");
					refresh_admin_help_list(cur_project_id)
				}
			});
		}
	});
	
	$(".button_CopyHelp_submit").click(function() {
		var job_id = $(".field_copyHelp_job").val();
		var project_id = $(".field_copyHelp_project").val();
		var cur_project_id = $(".help_projectSelector").val();
		if (job_id == -1 || project_id == -1) {
			alert("Select a job and project to copy from first.");
		} else {
			$.ajax({
				async:false,
				url:"<?php echo(base_url("index.php/ajax_help/copy_help")); ?>",
				dataType:"json",
				data: {
					job_id:job_id,
					project_id:project_id,
					cur_project_id:cur_project_id
				},
				success:function(data) {
					alert(data.cnt + " help file(s) copied.");
					$(".modal_copyHelp").modal("hide");
					refresh_admin_help_list(cur_project_id)
				}
			});
		}
	});
	
	$(".button_admin_addall_helpfromexisting").click(function() {
		$(".modal_copyallHelp").modal("show");
		$(".modal_copyallHelp_body").hide();
		$(".modal_copyallHelp_loading").show();
		$.ajax({
			url:"<?php echo(base_url("index.php/ajax_help/get_copyhelp_data")); ?>",
			dataType:"json",
			success: function(data) {
				console.log(data);
				
				$('.field_copyallHelp_project').find('option').remove().end().append('<option value="-1">Select One</option>').val('-1');
				if (data.projects.length > 0) {
					for(var i=0;i<data.projects.length;i++) {
						$('.field_copyallHelp_project').append('<option value="'+data.projects[i].id+'">'+data.projects[i].project_name+'</option>');
					}
				}

				$(".modal_copyallHelp_loading").hide();
				$(".modal_copyallHelp_body").show();
			}
		});
	});
	
	$(".button_admin_add_helpfromexisting").click(function() {
		$(".modal_copyHelp").modal("show");
		$(".modal_copyHelp_body").hide();
		$(".modal_copyHelp_loading").show();
		$.ajax({
			url:"<?php echo(base_url("index.php/ajax_help/get_copyhelp_data")); ?>",
			dataType:"json",
			success: function(data) {
				console.log(data);
				
				$('.field_copyHelp_job,.field_copyHelp_project').find('option').remove().end().append('<option value="-1">Select One</option>').val('-1');
				if (data.jobs.length > 0) {
					for(var i=0;i<data.jobs.length;i++) {
						$('.field_copyHelp_job').append('<option value="'+data.jobs[i].id+'">'+data.jobs[i].job_name+'</option>');
					}
				}
				
				if (data.projects.length > 0) {
					for(var i=0;i<data.projects.length;i++) {
						$('.field_copyHelp_project').append('<option value="'+data.projects[i].id+'">'+data.projects[i].project_name+'</option>');
					}
				}

				$(".modal_copyHelp_loading").hide();
				$(".modal_copyHelp_body").show();
			}
		});
	});
	
	$(".button_admin_modify_help").live("click",function() {
		var help_id = $(this).attr("help_id");
		showaddHelpModal(help_id)
	});
	
	$(".help_projectSelector").live("change",function() {
		var project_id_selected = $(this).val();
		var project_name_selected = $(this).children("option[value='"+project_id_selected+"']").text()
		
		$(".help_project_id").val(project_id_selected);
		$(".help_project_name").val(project_name_selected);
		$(".addHelp_name").html(project_name_selected);
		
		refresh_admin_help_list(project_id_selected)
	});
	
</script>