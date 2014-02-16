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

<div class="mattswell_title">Groups List</div>

<div class="admin_groups_loading" style="text-align:center;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>
<div class="admin_groups" style="display:none;">
	<div class="btn-group">
    	<button class="btn button_admin_add_group"><i class="icon-plus"></i> Add Group</button>
    </div>
    
    <div class="list_groups">
    
    </div>
</div>


<div class="modal hide modal_addGroup">
  <div class="modal-header">
    <button type="button" class="close button_close_addGroup" aria-hidden="true">&times;</button>
    <h3><span class="admin_modal_group_title"></span> Group - Enter Name</h3>
  </div>
  <div class="modal-body">
    <div class="modal_addGroup_name" style="text-align:center;">
    	<div class="modal_addGroup_error_1 alert alert-error" style="display:none;"><strong>Error! </strong>That group name already exists.</div>
        <input type="text" class="field_addGroup" maxlength="100" />
        <input type="hidden" class="field_cur_groupid" />
    </div>
    <div class="modal_addGroup_loading" style="text-align:center; display:none;">
    	Attempting to <span class="admin_modal_group_title"></span> <div class="addGroup_label" style="display:inline-block"></div><br />
    	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
    </div>
  </div>
  <div class="modal-footer modal_addGroup_footer">
    <a href="#" class="btn btn-danger button_close_addGroup"><i class="icon-remove icon-white"></i>&nbsp;Close</a>
    <a href="#" class="btn btn-primary button_addGroup_submit"><i class="icon-ok icon-white"></i>&nbsp;Submit</a>
  </div>
</div>

<div class="modal hide modal_group_users">
  <div class="modal-header">
    <button type="button" class="close button_close_group_users" aria-hidden="true">&times;</button>
    <input type="hidden" class="field_cur_id" />
    <h3>Modify Group's Users</h3>
  </div>
  <div class="modal-body">
    <div class="modal_group_users_list" style="text-align:left;">
    	
    </div>
    <div class="modal_group_users_loading" style="text-align:center; display:none;">
    	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
    </div>
  </div>
  <div class="modal-footer modal_group_users_footer">
    <a href="#" class="btn btn-danger button_close_group_users"><i class="icon-remove icon-white"></i>&nbsp;Close</a>
    <a href="#" class="btn btn-primary button_group_users_submit"><i class="icon-ok icon-white"></i>&nbsp;Submit</a>
  </div>
</div>

<script type="text/javascript">
	function refresh_admin_groups_list() {
		$('.admin_groups').hide();
		$('.admin_groups_loading').show();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_group/get_admin_groups_list")); ?>',
			dataType: 'html',
			success: function(data) {
				$('.list_groups').html(data);
				$('.admin_groups_loading').hide();
				$('.admin_groups').show();
			},
			fail: function(data) {
				alert("Error while updating admin groups list: "+data);
				$('.admin_groups_loading').hide();
				$('.admin_groups').show();
			}
		});
	}
	
	function sumbit_addGroup() {
		var name_entered = $('.field_addGroup').val()
		var cur_groupid = $('.field_cur_groupid').val();
		if (name_entered.length == 0) {
			alert("Group name field is blank.");
		} else {
			$('.addGroup_label').html(name_entered);
			$('.modal_addGroup_name').hide();
			$('.modal_addGroup_loading').show();
			$('.modal_addGroup_footer').hide();
			$.ajax({
				url: '<?php echo(base_url("index.php/ajax_group/add_group")); ?>',
				type: 'post',
				dataType: 'html',
				data: {
						group_to_add:name_entered,
						cur_groupid:cur_groupid
				},
				success: function(data) {
					if (data == '1') {
						refresh_admin_groups_list();
						$('.modal_addGroup').modal('hide');
					} else if (data == '2') {
						$('.modal_addGroup_name').show();
						$('.modal_addGroup_footer').show();
						$('.modal_addGroup_error_1').show();
						$('.modal_addGroup_loading').hide();
					}
				},
				fail: function(data) {
					alert("Sorry, something went terribly wrong...");
					$('.modal_addGroup_name').show();
					$('.modal_addGroup_footer').show();
					$('.modal_addGroup_error_1').hide();
					$('.modal_addGroup_loading').hide();
				}
			});
		}
	}
	
	$('.button_admin_add_group').click(function() {
		$('.modal_addGroup').modal('show');
		$('.modal_addGroup_name').show();
		$('.modal_addGroup_footer').show();
		$('.modal_addGroup_error_1').hide();
		$('.modal_addGroup_loading').hide();
		$('.field_addGroup').val('');
		$('.field_cur_groupid').val('-1');
		$('.admin_modal_group_title').html('Add');
		$('.modal_addGroup').on('shown',function() {
			$('.field_addGroup').focus();
		});
	});

	$('.button_admin_modify_group').live('click', function() {
		var ID_selected = $(this).attr('itemID');
		var NAME_selected = $(this).attr('groupname');
		$('.modal_addGroup').modal('show');
		$('.modal_addGroup_name').show();
		$('.modal_addGroup_footer').show();
		$('.modal_addGroup_error_1').hide();
		$('.modal_addGroup_loading').hide();
		$('.field_addGroup').val(NAME_selected);
		$('.field_cur_groupid').val(ID_selected);
		$('.admin_modal_group_title').html('Rename');
		$('.modal_addGroup').on('shown',function() {
			$('.field_addGroup').focus();
		});
	});
	
	$('.button_group_assign_users_all').live('click',function() { $('.group_user_item').attr('checked','checked'); });
	$('.button_group_assign_users_none').live('click',function() { $('.group_user_item').removeAttr('checked'); });
	
	$('.button_admin_modify_group_users').live('click', function() {
		var ID_selected = $(this).attr('itemID');
		$('.field_cur_id').val(ID_selected);
		$('.modal_group_users').modal('show');
		$('.modal_group_users_list').hide();
		$('.modal_group_users_loading').show();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_group/get_group_users_list")); ?>',
			type: 'post',
			dataType: 'json',
			data: {group_id:ID_selected},
			success: function(data) {
				var html_to_set = "\
					<div class=\"btn-group\" style=\"margin-bottom:10px;\">\
						<button class=\"btn btn-mini button_group_assign_users_all\">All</button>\
						<button class=\"btn btn-mini button_group_assign_users_none\">None</button>\
					</div>";
	
				for(var i=0;i<data.users.length;i++) {
					var cur_user = data.users[i];
					
					var checked = "";
					if (data.group_members.length) {
						for(j=0;j<data.group_members.length;j++) {
							var cur_user_id = data.group_members[j].user_id;
							if (cur_user_id == cur_user.id) {
								checked += "checked";
								break;
							}
						}
					}
					
					html_to_set += "<label class=\"checkbox\">\
										  <input class=\"group_user_item\" user_id=\""+cur_user.id+"\" type=\"checkbox\" "+checked+"> "+cur_user.user_name+"\
										</label>";
					$('.modal_group_users_list').html(html_to_set).show();
					$('.modal_group_users_loading').hide();
				}
			},
			error: function(data) {
				console.log(data);
			},
			fail: function(data) {
				alert("Error while getting users list: "+data);
			}
		});
	});
	
	$('.button_group_users_submit').click(function() {
		var cur_id = $('.field_cur_id').val();
		var selected_users = new Array();
		$('.group_user_item').each(function() {
			if ($(this).is(':checked')) {
				var id_to_push = $(this).attr('user_id');
				selected_users.push(id_to_push);
			}
		});
		
		$('.modal_group_users').modal('hide');
		
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_group/set_group_users")); ?>',
			type: 'post',
			dataType: 'json',
			data: {
				cur_id:cur_id,
				selected_users:selected_users
			},
			success: function(data) {
				console.log(data);
			},
			error: function(data) {
				console.log(data);
			}
		});
	});
	
	$('.button_admin_delete_group').live('click', function() {
		var ID_selected = $(this).attr('itemID');
		$('tr[itemID="'+ID_selected+'"]').hide('slow');
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_group/delete_group")); ?>',
			type: 'post',
			dataType: 'html',
			data: {groupID_to_delete:ID_selected},
			success: function(data) {
			},
			fail: function(data) {
				alert("Error while deleting group: "+data);
			}
		});
	});
	
	$('.button_close_addGroup').click(function() {$('.modal_addGroup').modal('hide');});
	$('.button_close_group_users').click(function() {$('.modal_group_users').modal('hide');});
	
	$('.button_addGroup_submit').click(function() {sumbit_addGroup();});
	$('.field_addGroup').keypress(function(e) {
		if (e.which == 13) {
			sumbit_addGroup();
		}
	})
	
</script>