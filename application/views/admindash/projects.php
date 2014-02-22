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

</style>

<div class="mattswell_title">Projects List</div>

<div class="admin_projects_loading" style="text-align:center;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>
<div class="admin_projects" style="display:none;">
	<div class="btn-group">
    	<button class="btn button_admin_add_project"><i class="icon-plus"></i> Add Project</button>
        <button class="btn button_admin_undelete_project"><i class="icon-share-alt"></i> Undelete Project</button>
    </div>
    
    <div class="list_projects">
    
    </div>
</div>

<div class="modal hide modal_addProject">
  <div class="modal-header">
  	<input type="hidden" class="launch_project" value="" />
    <input type="hidden" class="cur_project_id" value="-1" />
    <button type="button" class="close button_close_addProject" aria-hidden="true">&times;</button>
    <h3><span class="admin_modal_project_title"></span> Project</h3>
  </div>
  <div class="modal-body">
    <div class="modal_addProject_name" style="text-align:center;">
    	<table width="100%" cellpadding="4px" cellspacing="0" border="0">
        	<tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;">Name:</td>
                <td><input type="text" class="field_addProject" maxlength="100" /></td>
            </tr>
            <tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;">Received:</td>
                <td><input type="text" class="field_addProject_received" /></td>
            </tr>
            <tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;">Destroyed:</td>
                <td>
                	<select class="field_addProject_destroyed">
                    	<option value="">Unknown</option>
                        <option value="Destroyed">Destroyed</option>
                        <option value="Not Destroyed">Not Destroyed</option>
                    </select>
                </td>
            </tr>
            <tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;">Price Per Large Format:</td>
                <td><input type="text" class="field_addProject_pplf" /></td>
            </tr>
            <tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;">Price Per Small Format:</td>
                <td><input type="text" class="field_addProject_ppsf" /></td>
            </tr>
            <tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;">Price Per Box:</td>
                <td><input type="text" class="field_addProject_ppb" /></td>
            </tr>
        </table>
    </div>
    <div class="modal_addProject_loading" style="text-align:center; display:none;">
    	Attempting to <span class="admin_modal_project_title"></span> <div class="addProject_label" style="display:inline-block"></div><br />
    	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
    </div>
  </div>
  <div class="modal-footer modal_addProject_footer">
    <a href="#" class="btn btn-danger button_close_addProject"><i class="icon-remove icon-white"></i>&nbsp;Close</a>
    <a href="#" class="btn btn-primary button_addProject_submit"><i class="icon-ok icon-white"></i>&nbsp;Submit</a>
  </div>
</div>

<div class="modal hide modal_undeleteProject">
  <div class="modal-header">
    <button type="button" class="close button_close_undeleteProject" aria-hidden="true">&times;</button>
    <h3>Undelete Projects</h3>
  </div>
  <div class="modal-body">
    <div class="modal_undeleteProject_list" style="text-align:center;">
    	
    </div>
    <div class="modal_undeleteProject_loading" style="text-align:center; display:none;">
    	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
    </div>
  </div>
  <div class="modal-footer modal_undeleteProject_footer">
    <a href="#" class="btn btn-danger button_close_undeleteProject"><i class="icon-remove icon-white"></i>&nbsp;Close</a>
  </div>
</div>

<script type="text/javascript">
	function refresh_admin_projects_list() {
		$('.admin_projects').hide();
		$('.admin_projects_loading').show();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_project/get_admin_projects_list")); ?>',
			dataType: 'html',
			success: function(data) {
				$('.list_projects').html(data);
				$('.admin_projects_loading').hide();
				$('.admin_projects').show();
			},
			fail: function(data) {
				alert("Error while updating admin projects list: "+data);
				$('.admin_projects_loading').hide();
				$('.admin_projects').show();
			}
		});
	}
	
	function sumbit_addProject() {
		var project_id = $('.cur_project_id').val();
		var name_entered = $('.field_addProject').val();
		var received_entered = $('.field_addProject_received').val();
		var destroyed_entered = $('.field_addProject_destroyed').val();
		var pplf_entered = $('.field_addProject_pplf').val();
		var ppsf_entered = $('.field_addProject_ppsf').val();
		var ppb_entered = $('.field_addProject_ppb').val();
		if (name_entered.length == 0 || received_entered.length == 0 || pplf_entered.length == 0  || ppsf_entered.length == 0 || ppb_entered.length == 0) {
			alert("All fields are required.");
		} else {
			$('.addProject_label').html(name_entered);
			$('.modal_addProject_name').hide();
			$('.modal_addProject_loading').show();
			$('.modal_addProject_footer').hide();
			$.ajax({
				url: '<?php echo(base_url("index.php/ajax_project/add_project")); ?>',
				type: 'post',
				dataType: 'html',
				data: {
					project_id:project_id,
					project_to_add:name_entered,
					project_to_add_received:received_entered,
					destroyed:destroyed_entered,
					pplf:pplf_entered,
					ppsf:ppsf_entered,
					ppb:ppb_entered
				},
				success: function(data) {
					$('.modal_addProject').modal('hide');
					if (project_id == -1) {
						$('.launch_project').val(data);
						switchActivePane("button_boxes");
					} else {
						refresh_admin_projects_list();
					}
				},
				error: function(data) {
					alert("Could not add / modify project with values given.");
					$('.modal_addProject_name').show();
					$('.modal_addProject_footer').show();
					$('.modal_addProject_loading').hide();
				}
			});
		}
	}
	
	$('.button_admin_add_project').click(function() {
		$('.modal_addProject').modal('show');
		$('.modal_addProject_name').show();
		$('.modal_addProject_footer').show();
		$('.modal_addProject_loading').hide();
		$('.field_addProject').val('');
		$('.field_addProject_received').val('');
		$('.field_addProject_pplf').val('');
		$('.field_addProject_ppsf').val('');
		$('.field_addProject_ppb').val('');
		$('.cur_project_id').val("-1");
		$('.admin_modal_project_title').html("Add");
		$('.modal_addProject').on('shown',function() {
			$('.field_addProject').focus();
		});
	});
	
	$('.button_admin_undelete_project').click(function() {
		$('.modal_undeleteProject').modal('show');
		$('.modal_undeleteProject_loading').show();
		$('.modal_undeleteProject_list').hide();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_project/get_hidden_project_list")); ?>',
			dataType: 'html',
			success: function(data) {
				$('.modal_undeleteProject_list').html(data);
				$('.modal_undeleteProject_loading').hide();
				$('.modal_undeleteProject_list').show();
			},
			fail: function(data) {
				alert("Error while updating hidden users list: "+data);
				$('.modal_undeleteProject').modal('hide');
			}
		});
	});
	
	$('.hidden_project').live('click',function() {
		var ID_selected = $(this).attr('itemID');
		$('tr[itemID="'+ID_selected+'"]').fadeOut('fast');
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_project/undelete_project")); ?>',
			type: 'post',
			dataType: 'html',
			data: {projectID_to_undelete:ID_selected},
			success: function(data) {
				refresh_admin_projects_list();
			},
			fail: function(data) {
				alert("Error while undeleting project: "+data);
				$('.modal_undeleteProject').modal('hide');
			}
		});
	});

	$('.button_admin_modify_project').live('click', function() {
		var ID_selected = $(this).attr('itemID');
		var project_name = $(this).attr('project_name');
		var project_received = $(this).attr('project_received');
		var pplf = $(this).attr('pplf');
		var ppsf = $(this).attr('ppsf');
		var ppb = $(this).attr('ppb');
		$('.modal_addProject').modal('show');
		$('.modal_addProject_name').show();
		$('.modal_addProject_footer').show();
		$('.modal_addProject_loading').hide();
		$('.field_addProject').val(project_name);
		$('.field_addProject_received').val(project_received);
		$('.field_addProject_pplf').val(pplf);
		$('.field_addProject_ppsf').val(ppsf);
		$('.field_addProject_ppb').val(ppb);
		$('.cur_project_id').val(ID_selected);
		$('.admin_modal_project_title').html("Modify");
		$('.modal_addProject').on('shown',function() {
			$('.field_addProject').focus();
		});
	});
	
	$('.button_admin_delete_project').live('click', function() {
		var ID_selected = $(this).attr('itemID');
		$('tr[itemID="'+ID_selected+'"]').hide('slow');
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_project/delete_project")); ?>',
			type: 'post',
			dataType: 'html',
			data: {projectID_to_delete:ID_selected},
			success: function(data) {
			},
			fail: function(data) {
				alert("Error while deleting project: "+data);
			}
		});
	});
	
	$('.button_close_addProject').click(function() {$('.modal_addProject').modal('hide');});
	$('.button_close_undeleteProject').click(function() {$('.modal_undeleteProject').modal('hide');});
	
	$('.button_addProject_submit').click(function() {sumbit_addProject();});
	
	$('.field_addProject_received').datepicker({ dateFormat: "yy-mm-dd" });
	
</script>