<style type="text/css">
	.filter_label {
		text-align:right;
	}
	
	.filter_field {
		text-align:left;	
	}
</style>


<div class="mattswell well_clock" style="margin-bottom:15px;">
	<div class="mattswell_title">Send a Message</div>
    <input type="hidden" class="sendto_groups">
    <input type="hidden" class="sendto_users">
    <table cellpadding="5" style="width:100%;">
    	<tr>
        	<td width="100" class="filter_label">From:</td>
        	<td class="filter_field"><?php echo($currentUser); ?></td>
        </tr>
        <tr>
        	<td width="100" class="filter_label">To:</td>
        	<td class="filter_field">
				<button type="button" class="btn btn-mini btn_send_to"><i class="icon-user"></i>&nbsp;Select Recipients</button>
            	<span class="to_tags"></span>
            </td>
        </tr>
    </table>
</div>

<div class="modal hide modal_select_recipients">
  <div class="modal-header">
    <button type="button" class="close button_close_select_recipients" aria-hidden="true">&times;</button>
    <h3>Select Message Recipients</h3>
  </div>
  <div class="modal-body">
  	<div style="width:200px; display:inline-block; float:left;">
        <h4>Users&nbsp;<div class="btn-group">
        <button class="btn btn-mini message_sendto_user_all">All</button>
        <button class="btn btn-mini message_sendto_user_none">None</button>
        </h4>
        <?php
            $user_list_obj = json_decode($user_list);
            foreach ($user_list_obj as $user) { ?>
            <label class="checkbox"><input class="message_sendto_user_item" user_id="<?php echo $user->id; ?>" type="checkbox"> <?php echo $user->user_name; ?></label>
        <?php } ?>
	</div>
    <div style="width:200px; display:inline-block; float:left;">
        <h4>Groups&nbsp;<div class="btn-group">
        <button class="btn btn-mini message_sendto_group_all">All</button>
        <button class="btn btn-mini message_sendto_group_none">None</button>
        </h4>
        <?php
            $group_list_obj = json_decode($group_list);
            foreach ($group_list_obj as $group) { ?>
            <label class="checkbox"><input class="message_sendto_group_item" group_id="<?php echo $group->id; ?>" type="checkbox"> <?php echo $group->group_name; ?></label>
        <?php } ?>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn button_close_select_recipients">Cancel</a>
    <a href="#" class="btn btn-primary button_select_recipients_submit">Submit</a>
  </div>
</div>


<textarea class="user_message_body"></textarea>
<div style="text-align:center;">
    <button type="button" class="btn btn-large btn-success btn_send_message" style="margin-top:15px;"><i class="icon-envelope icon-white"></i>&nbsp;Send</button>
</div>


<script type="text/javascript">

	function update_to_tags(user_id_list,group_id_list) {
        console.log(user_id_list);
        console.log(group_id_list);
		var html_to_set = "";
        if (typeof group_id_list == 'undefined') {
		    var group_id_list = $('.sendto_groups').val();
        }
        if (typeof user_id_list == 'undefined') {
		    var user_id_list = $('.sendto_users').val();
        }
        console.log(user_id_list);
        console.log(group_id_list);
		
		if (group_id_list) {
			var group_array = group_id_list.split("|");
			
			for (var i=0;i<group_array.length;i++) {
				var cur_group_id = group_array[i];
				if (cur_group_id) {
					if (group_list.length) {
						for (var j=0;j<group_list.length;j++) {
							if(group_list[j].id == cur_group_id) {
								
								var cur_group_members = new Array();
								if (group_members.length) {
									for (var k=0;k<group_members.length;k++) {
										if (group_members[k].group_id == cur_group_id) {
											cur_group_members.push(group_members[k].user_id);
										}
									}
								}
								
								var pop_content = "";
								if (cur_group_members.length) {
									pop_content += "<UL style=\"font-size:14px;\">";
									for (var k=0;k<user_list.length;k++) {
										var in_array = $.inArray(user_list[k].id, cur_group_members);
										if (in_array > -1) {
											pop_content += "<LI>"+user_list[k].user_name+"</LI>";
										}
									}
									pop_content += "</UL>";
								}
								
								
								html_to_set += "<span class=\"label label-info\" data-title=\""+group_list[j].group_name+"\" data-content='"+pop_content+"'>"+group_list[j].group_name+"</span> ";
							}
						}//end inner loop
					}
				}
			}//end first loop
			
		}
		
		if (user_id_list) {
			var user_array = user_id_list.split("|");
			
			for (var i=0;i<user_array.length;i++) {
				var user_id = user_array[i];
				
				if (user_id) {
					var user_name = "";
					for (var j=0;j<user_list.length;j++) {
						if (user_list[j].id == user_id) {
							user_name = user_list[j].user_name;
							break;
						}
					}
				
					html_to_set += "<span class=\"label label-inverse\">"+user_name+"</span> ";
				}
			}

		}
		
		$('.to_tags').html(html_to_set);
		$('span').popover({
			placement:'bottom',
			trigger:'hover',
			html:true
		});
	}

	$('.btn_show_user_message_body').click(function() {
		var content = $(".user_message_body").tinymce().getContent();
		console.log(content);
	});
	
	$('.btn_send_to').click(function() {
		$('.modal_select_recipients').modal('show');
	});
	
	$('.message_sendto_user_all').click(function() {
		$('.message_sendto_user_item').prop('checked',true);
	});
	$('.message_sendto_user_none').click(function() {
		$('.message_sendto_user_item').prop('checked',false);
	});
	
	$('.message_sendto_group_all').click(function() {
		$('.message_sendto_group_item').prop('checked',true);
	});
	$('.message_sendto_group_none').click(function() {
		$('.message_sendto_group_item').prop('checked',false);
	});
	
	$('.button_select_recipients_submit').click(function() {
		var selected_users = new Array();
		var selected_groups = new Array();
		$('.sendto_groups').val("");
		$('.sendto_users').val("");
		
		$('.message_sendto_user_item').each(function() {
			if ($(this).is(':checked')) {
				selected_users.push($(this).attr('user_id'));
			}
		});
		
		$('.message_sendto_group_item').each(function() {
			if ($(this).is(':checked')) {
				selected_groups.push($(this).attr('group_id'));
			}
		});
		
		if(selected_users.length) {
			var val_to_set = "";
			for (var i=0; i<selected_users.length; i++) {
				cur_selected_user = selected_users[i];
				val_to_set += cur_selected_user + "|";
			}
			$('.sendto_users').val(val_to_set);
		}
		
		if(selected_groups.length) {
			var val_to_set = "";
			for (var i=0; i<selected_groups.length; i++) {
				cur_selected_group = selected_groups[i];
				val_to_set += cur_selected_group + "|";
			}
			$('.sendto_groups').val(val_to_set);
		}
		
		update_to_tags();
		$('.modal_select_recipients').modal('hide');
	});
	
	$('.btn_send_message').click(function() {
		var msg_from = <?php echo($currentUserID); ?>;
		var msg_to_groups = $('.sendto_groups').val();
		var msg_to_users = $('.sendto_users').val();
		var msg_body = $(".user_message_body").tinymce().getContent();

		if (!msg_to_groups && !msg_to_users) {
			alert("Select message recipients first.");
			return;
		}
		if (msg_body.trim() == "") {
			alert("Enter a message to send first.");
			return;
		}
		$('.btn_send_message').prop('disabled',true);
		$.ajax({
			url: "<?php echo(base_url("index.php/ajax_message/send_message")); ?>",
			type: "POST",
			dataType: "json",
			data: {
				msg_from:msg_from,
				msg_to_groups:msg_to_groups,
				msg_to_users:msg_to_users,
				msg_body:msg_body
			},
			success: function(data) {
				alert("Message sent!");
				load_messages();
			},
			error: function() {
				alert("Can't send that message...");
			},
			complete: function() {
				$('.btn_send_message').prop('disabled',false);
			}
		});
	});
	
	$('.button_close_select_recipients').click(function() { $('.modal_select_recipients').modal('hide'); });
	
	$(document).ready(function() {

		$('.user_message_body').tinymce({
			script_url:"<?php echo(base_url("assets/js/tinymce/tinymce.min.js")); ?>",
			toolbar1:"newdocument bold italic underline strikethrough fontselect fontsizeselect",
			toolbar2:"alignleft aligncenter alignright alignjustify bullist numlist outdent indent undo redo removeformat image",
			menubar: false,
			plugins : "image",
			setup : function(ed)
			{
				ed.on('init', function() 
				{
					this.getDoc().body.style.fontSize = '16px';
				});
			},
			height:200
		});
	
	});

</script>