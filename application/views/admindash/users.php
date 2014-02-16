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
	
	.hidden_user:HOVER {
		cursor:pointer;
	}
	
</style>

<div class="mattswell_title">User List!</div>

<div class="admin_users_loading" style="text-align:center;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>
<div class="admin_users" style="display:none;">
	<div class="btn-group">
    	<button class="btn button_admin_add_user"><i class="icon-plus"></i> Add User</button>
        <button class="btn button_admin_undelete_user"><i class="icon-share-alt"></i> Undelete User</button>
    </div>
    
    <div class="list_users">
    
    </div>
</div>

<div class="modal hide modal_addUser">
  <div class="modal-header">
    <button type="button" class="close button_close_addUser" aria-hidden="true">&times;</button>
    <h3><span class="admin_modal_user_title"></span> User - Enter Name</h3>
  </div>
  <div class="modal-body">
    <div class="modal_addUser_name" style="text-align:center;">
    	<div class="modal_addUser_error_1 alert alert-error" style="display:none;"><strong>Error! </strong>That user name already exists.</div>
        <input type="text" class="field_addUser" maxlength="100" />
       	<input type="hidden" class="field_cur_id" />
    </div>
    <div class="modal_addUser_loading" style="text-align:center; display:none;">
    	Attempting to <span class="admin_modal_user_title"></span> <div class="addUser_label" style="display:inline-block"></div><br />
    	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
    </div>
  </div>
  <div class="modal-footer modal_addUser_footer">
    <a href="#" class="btn btn-danger button_close_addUser"><i class="icon-remove icon-white"></i>&nbsp;Close</a>
    <a href="#" class="btn btn-primary button_addUser_submit"><i class="icon-ok icon-white"></i>&nbsp;Submit</a>
  </div>
</div>

<div class="modal hide modal_undeleteUser">
  <div class="modal-header">
    <button type="button" class="close button_close_undeleteUser" aria-hidden="true">&times;</button>
    <h3>Undelete Users</h3>
  </div>
  <div class="modal-body">
    <div class="modal_undeleteUser_list" style="text-align:center;">
    	
    </div>
    <div class="modal_undeleteUser_loading" style="text-align:center; display:none;">
    	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
    </div>
  </div>
  <div class="modal-footer modal_undeleteUser_footer">
    <a href="#" class="btn btn-danger button_close_undeleteUser"><i class="icon-remove icon-white"></i>&nbsp;Close</a>
  </div>
</div>

<div class="modal hide modal_user_groups">
  <div class="modal-header">
    <button type="button" class="close button_close_user_groups" aria-hidden="true">&times;</button>
    <input type="hidden" class="field_cur_id" />
    <h3>Modify User Groups</h3>
  </div>
  <div class="modal-body">
    <div class="modal_user_groups_list" style="text-align:left;">
    	
    </div>
    <div class="modal_user_groups_loading" style="text-align:center; display:none;">
    	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
    </div>
  </div>
  <div class="modal-footer modal_user_groups_footer">
    <a href="#" class="btn btn-danger button_close_user_groups"><i class="icon-remove icon-white"></i>&nbsp;Close</a>
    <a href="#" class="btn btn-primary button_user_groups_submit"><i class="icon-ok icon-white"></i>&nbsp;Submit</a>
  </div>
</div>

<script type="text/javascript">
	function refresh_admin_users_list() {
		$('.admin_users').hide();
		$('.admin_users_loading').show();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_user/get_admin_users_list")); ?>',
			dataType: 'html',
			success: function(data) {
				$('.list_users').html(data);
				$('.admin_users_loading').hide();
				$('.admin_users').show();
			},
			fail: function(data) {
				alert("Error while updating admin users list: "+data);
				$('.admin_users_loading').hide();
				$('.admin_users').show();
			}
		});
	}
	
	function sumbit_addUser() {
		var name_entered = $('.field_addUser').val()
		var id_entered = $('.field_cur_id').val();
		
		if (id_entered == -1) {
			var url = "<?php echo(base_url("index.php/ajax_user/add_user")); ?>";
		} else {
			var url = "<?php echo(base_url("index.php/ajax_user/rename_user")); ?>";
		}
		
		if (name_entered.length == 0) {
			alert("User name field is blank.");
		} else {
			$('.addUser_label').html(name_entered);
			$('.modal_addUser_name').hide();
			$('.modal_addUser_loading').show();
			$('.modal_addUser_footer').hide();
			$.ajax({
				url: url,
				type: 'post',
				dataType: 'html',
				data: {
					user_to_add:name_entered,
					id_entered:id_entered
				},
				success: function(data) {
					if (data == '1') {
						refresh_admin_users_list();
						$('.modal_addUser').modal('hide');
					} else if (data == '2') {
						$('.modal_addUser_name').show();
						$('.modal_addUser_footer').show();
						$('.modal_addUser_error_1').show();
						$('.modal_addUser_loading').hide();
					}
				},
				fail: function(data) {
					alert("Sorry, something went terribly wrong...");
					$('.modal_addUser_name').show();
					$('.modal_addUser_footer').show();
					$('.modal_addUser_error_1').hide();
					$('.modal_addUser_loading').hide();
				}
			});
		}
	}
	
	$('.button_admin_add_user').click(function() {
		$('.modal_addUser').modal('show');
		$('.modal_addUser_name').show();
		$('.modal_addUser_footer').show();
		$('.modal_addUser_error_1').hide();
		$('.modal_addUser_loading').hide();
		$('.field_addUser').val('');
		$('.admin_modal_user_title').html('Add');
		$('.field_cur_id').val("-1");
		$('.modal_addUser').on('shown',function() {
			$('.field_addUser').focus();
		});
	});
	
	$('.button_admin_undelete_user').click(function() {
		$('.modal_undeleteUser').modal('show');
		$('.modal_undeleteUser_loading').show();
		$('.modal_undeleteUser_list').hide();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_user/get_hidden_users_list")); ?>',
			dataType: 'html',
			success: function(data) {
				$('.modal_undeleteUser_list').html(data);
				$('.modal_undeleteUser_loading').hide();
				$('.modal_undeleteUser_list').show();
			},
			fail: function(data) {
				alert("Error while updating hidden users list: "+data);
				$('.modal_undeleteUser').modal('hide');
			}
		});
	});
	
	$('.button_close_undeleteUser').click(function() {$('.modal_undeleteUser').modal('hide')});
	$('.button_close_user_groups').click(function() {$('.modal_user_groups').modal('hide')});
	
	$('.button_admin_modify_user').live('click', function() {
		var ID_selected = $(this).attr('itemID');
		var NAME_selected = $(this).attr('username');
		$('.admin_modal_user_title').html('Rename');
		$('.field_cur_id').val(ID_selected);
		$('.modal_addUser').modal('show');
		$('.modal_addUser_name').show();
		$('.modal_addUser_footer').show();
		$('.modal_addUser_error_1').hide();
		$('.modal_addUser_loading').hide();
		$('.field_addUser').val(NAME_selected);
		$('.modal_addUser').on('shown',function() {
			$('.field_addUser').focus();
		});
	});
	
	$('.button_user_groups_submit').click(function() {
		var cur_id = $('.field_cur_id').val();
		var selected_groups = new Array();
		$('.user_group_item').each(function() {
			if ($(this).is(':checked')) {
				var id_to_push = $(this).attr('group_id');
				selected_groups.push(id_to_push);
			}
		});
		
		$('.modal_user_groups').modal('hide');
		
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_group/set_user_groups")); ?>',
			type: 'post',
			dataType: 'json',
			data: {
				cur_id:cur_id,
				selected_groups:selected_groups
			},
			success: function(data) {
				console.log(data);
			}
		});
	});
	
	$('.button_group_assign_groups_all').live('click',function() { $('.user_group_item').attr('checked','checked'); });
	$('.button_group_assign_groups_none').live('click',function() { $('.user_group_item').removeAttr('checked'); });
	
	$('.button_admin_modify_user_groups').live('click', function() {
		var ID_selected = $(this).attr('itemID');
		$('.field_cur_id').val(ID_selected);
		$('.modal_user_groups').modal('show');
		$('.modal_user_groups_list').hide();
		$('.modal_user_groups_loading').show();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_group/get_groups_list")); ?>',
			type: 'post',
			dataType: 'json',
			data: {user_id:ID_selected},
			success: function(data) {
				var html_to_set = "\
					<div class=\"btn-group\" style=\"margin-bottom:10px;\">\
						<button class=\"btn btn-mini button_group_assign_groups_all\">All</button>\
						<button class=\"btn btn-mini button_group_assign_groups_none\">None</button>\
					</div>";
				for(var i=0;i<data.groups.length;i++) {
					var cur_group = data.groups[i];
					
					var checked = "";
					if (data.group_members.length) {
						for(j=0;j<data.group_members.length;j++) {
							var cur_group_id = data.group_members[j].group_id;
							if (cur_group_id == cur_group.id) {
								checked += "checked";
								break;
							}
						}
					}
					
					html_to_set += "<label class=\"checkbox\">\
										  <input class=\"user_group_item\" group_id=\""+cur_group.id+"\" type=\"checkbox\" "+checked+"> "+cur_group.group_name+"\
										</label>";
					$('.modal_user_groups_list').html(html_to_set).show();
					$('.modal_user_groups_loading').hide();
				}
			},
			fail: function(data) {
				alert("Error while getting groups list: "+data);
			}
		});
	});
	
	$('.button_admin_delete_user').live('click', function() {
		var ID_selected = $(this).attr('itemID');
		$('tr[itemID="'+ID_selected+'"]').hide('slow');
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_user/delete_user")); ?>',
			type: 'post',
			dataType: 'html',
			data: {userID_to_delete:ID_selected},
			success: function(data) {
			},
			fail: function(data) {
				alert("Error while deleting user: "+data);
			}
		});
	});
	
	$('.hidden_user').live('click',function() {
		var ID_selected = $(this).attr('itemID');
		$('tr[itemID="'+ID_selected+'"]').fadeOut('fast');
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_user/undelete_user")); ?>',
			type: 'post',
			dataType: 'html',
			data: {userID_to_undelete:ID_selected},
			success: function(data) {
				refresh_admin_users_list();
			},
			fail: function(data) {
				alert("Error while undeleting user: "+data);
				$('.modal_undeleteUser').modal('hide');
			}
		});
	});
	
	$('.button_close_addUser').click(function() {$('.modal_addUser').modal('hide');});
	
	$('.button_addUser_submit').click(function() {sumbit_addUser();});
	$('.field_addUser').keypress(function(e) {
		if (e.which == 13) {
			sumbit_addUser();
		}
	});

	$('a').tooltip();
	
</script>