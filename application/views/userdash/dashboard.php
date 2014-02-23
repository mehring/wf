<style type="text/css">
	.unread {
		background: rgb(255,255,255); /* Old browsers */
		background: -moz-linear-gradient(top,  rgba(255,255,255,1) 0%, rgba(155,215,255,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,1)), color-stop(100%,rgba(155,215,255,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(155,215,255,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(155,215,255,1) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(155,215,255,1) 100%); /* IE10+ */
		background: linear-gradient(to bottom,  rgba(255,255,255,1) 0%,rgba(155,215,255,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#9bd7ff',GradientType=0 ); /* IE6-9 */
	}
	.unread:HOVER {
		background: rgb(255,255,255);
	}
</style>

<table border="0" width="100%" cellpadding="5px" cellspacing="0">
	<tr>
    	<td width="50%" valign="top">
        	<div class="mattswell well_tasks" style="overflow-y:auto;">
                <div class="mattswell_title">My Tasks</div>
                
                <div class="well_tasks_info" style="display:none;height:155px;overflow-y:auto;"></div>
                
                <div class="well_tasks_loading" style="text-align:center;">
                	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
                </div>
                
            </div>
        </td>
    	<td valign="top">
            <div class="mattswell well_clock">
                <div class="mattswell_title">Clock In & Out</div>
                
                <div class="info_clockout" style="display:none">
                    <table class="hover_table" cellspacing="0" cellpadding="5px" border="0" width="100%" style="margin-bottom:10px;">
                        <tbody>
                            <tr>
                                <td align="right" valign="top"><strong>Job:</strong></td>
                                <td align="left" valign="top" class="dash_cur_job" itemID="<?php echo($status_info[0]->job_id); ?>"><?php echo($status_info[0]->job_name); ?></td>
                            </tr>
                            
                            <tr>
                                <td align="right" valign="top"><strong>Project:</strong></td>
                                <td align="left" valign="top" class="dash_cur_project" itemID="<?php echo($status_info[0]->project_id); ?>"><?php echo($status_info[0]->project_name); ?></td>
                            </tr>
                            
                            <tr>
                                <td align="right" valign="top"><strong>Box:</strong></td>
                                <td align="left" valign="top" class="dash_cur_box" itemID="<?php echo($status_info[0]->box_id); ?>"><?php echo($status_info[0]->box_name); ?></td>
                            </tr>
                            
                            <tr>
                                <td align="right" valign="top"><strong>Started:</strong></td>
                                <td align="left" valign="top" class="dash_cur_start"><?php echo(date("M j, Y g:i A",strtotime($status_info[0]->user_start))); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div style="text-align:center;">
                        <div class="btn-group">
                            <div class="btn btn-inverse button_switchTask"><i class="icon-refresh icon-white"></i> Switch Task</div>
                            <div class="btn btn-danger button_clockOut"><i class="icon-time icon-white"></i> Clock Out</div>
                        </div>
                    </div>
                </div>
                
                <div class="info_clockin" style="display:none">
                    <table class="hover_table" cellspacing="0" cellpadding="5px" border="0" width="100%" style="margin-bottom:10px;">
                        <tbody>
                            <tr>
                                <td align="right" valign="top"><strong>Job:</strong></td>
                                <td align="left" valign="top" class="dash_cur_job" itemID="<?php echo($status_info[0]->job_id); ?>"><?php echo($status_info[0]->job_name); ?></td>
                            </tr>
                            
                            <tr>
                                <td align="right" valign="top"><strong>Project:</strong></td>
                                <td align="left" valign="top" class="dash_cur_project" itemID="<?php echo($status_info[0]->project_id); ?>"><?php echo($status_info[0]->project_name); ?></td>
                            </tr>
                            
                            <tr>
                                <td align="right" valign="top"><strong>Box:</strong></td>
                                <td align="left" valign="top" class="dash_cur_box" itemID="<?php echo($status_info[0]->box_id); ?>"><?php echo($status_info[0]->box_name); ?></td>
                            </tr>
                            
                            <tr>
                                <td align="right" valign="top"><strong>Started:</strong></td>
                                <td align="left" valign="top"><span class="font_disabled">Clocked Out</span></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div style="text-align:center;">
                        <div class="btn btn-success button_clockIn"><i class="icon-time icon-white"></i> Clock In</div>
                    </div>
                </div>
                
                <div class="info_loading" style="display:none">
                	<table class="hover_table" cellspacing="0" cellpadding="5px" border="0" width="100%" style="margin-bottom:10px;">
                        <tbody>
                            <tr>
                                <td align="right" valign="top"><strong>Job:</strong></td>
                                <td align="left" valign="top" class="dash_cur_job" itemID="<?php echo($status_info[0]->job_id); ?>"><?php echo($status_info[0]->job_name); ?></td>
                            </tr>
                            
                            <tr>
                                <td align="right" valign="top"><strong>Project:</strong></td>
                                <td align="left" valign="top" class="dash_cur_project" itemID="<?php echo($status_info[0]->project_id); ?>"><?php echo($status_info[0]->project_name); ?></td>
                            </tr>
                            
                            <tr>
                                <td align="right" valign="top"><strong>Box:</strong></td>
                                <td align="left" valign="top" class="dash_cur_box" itemID="<?php echo($status_info[0]->box_id); ?>"><?php echo($status_info[0]->box_name); ?></td>
                            </tr>
                            
                            <tr>
                                <td align="right" valign="top"><strong>Started:</strong></td>
                                <td align="left" valign="top"><span class="font_disabled">Clocking Out...</span></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div style="text-align:center;">
                        <img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
                    </div>
                </div>
                
            </div>
        </td>
        
    </tr>
    <tr>
    	<td width="50%" valign="top">
        	<div class="mattswell well_messages" style="min-height:285px;">
                <div class="mattswell_title">My Messages
                	<button type="button" class="btn btn-mini button_delete_message_all" style="float:right;"><i class="icon-trash"></i> Delete All Read</button>
                </div>
                
                <div class="well_messages_info" style="display:none;"></div>
                
                <div class="well_messages_loading" style="text-align:center;">
                	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
                </div>
                
            </div>
        </td>
        <td valign="top">
        	<div class="mattswell well_stats">
                <div class="mattswell_title">My Stats
                	<div style="display:inline-block; float:right;">
                    	<div class="btn btn-mini refresh_stats"><i class="icon-repeat"></i>&nbsp;Refresh</div>
                    </div>
                </div>
                
                <div class="well_stats_info" style="display:none;text-align:center;"></div>
                
                <div class="well_stats_loading" style="text-align:center;">
                	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
                </div>
                
            </div>
        </td>
    </tr>
</table>

<div class="modal hide modal_view_message">
  <div class="modal-header">
    <button type="button" class="close button_close_message" aria-hidden="true">&times;</button>
      <input type="hidden" value="" class="cur_message_id" />
      <input type="hidden" value="" class="cur_from_id" />
    <h3>Message</h3>
    <div style="margin:10px 0;">
        <strong>From:</strong> <span class="message_from"></span><br />
        <strong>Sent:</strong> <span class="message_sent"></span>
    </div>
  </div>
  <div class="modal-body message_body"></div>
  <div class="modal-footer">
    <a href="#" class="btn btn-primary button_reply_message" style="float:left;"><i class="icon-share-alt icon-white"></i> Reply</a>
    <a href="#" class="btn btn-danger button_delete_message"><i class="icon-trash icon-white"></i> Delete</a>
    <a href="#" class="btn btn-primary button_close_message"><i class="icon-ok icon-white"></i> Close</a>
  </div>
</div>

<div class="modal hide modal_set_box_data">
  <div class="modal-header">
      <input type="hidden" value="" class="clock_out_or_switch" />
      <input type="hidden" value="<?php echo $status_info[0]->box_id; ?>" class="cur_box_id" />
    <h3>Box Image Count?</h3>
  </div>
  <div class="modal-body message_body">
  	<table width="100%" cellpadding="4px" cellspacing="0" border="0">
        <tr style="background-color:transparent;">
            <td align="right" style="font-weight:bold;"># Small Format:</td>
            <td><input type="text" class="field_box_data_sf" value="<?php echo($status_info[0]->sf); ?>" maxlength="50" /></td>
        </tr>
        <tr style="background-color:transparent;">
            <td align="right" style="font-weight:bold;"># Large Format:</td>
            <td><input type="text" class="field_box_data_lf" value="<?php echo($status_info[0]->lf); ?>" maxlength="50" /></td>
        </tr>
    </table>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-primary button_save_box_data"><i class="icon-ok icon-white"></i> Save</a>
  </div>
</div>

<script type="text/javascript">
	var user_messages = false;
	var user_tasks = false;
	
	function isNumber(n) {
	  return !isNaN(parseFloat(n)) && isFinite(n);
	}

	function sync_heights() {
		$(".well_tasks").height($(".well_clock").height())
	}
	
	function load_tasks() {
		$(".well_tasks_info").hide();
		$(".well_tasks_loading").show();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_user/get_tasks")); ?>',
			dataType:"json",
			success: function(data) {
				user_tasks = data;
				console.log(data);
				
				if (data.length) {
				var html_to_set = "\
					<table class=\"table table-condensed hover_table\">\
                      <thead>\
                        <tr>\
                          <th>Job</th>\
						  <th>Priority</th>\
                          <th>Actions</th>\
                        </tr>\
                      </thead>\
                      <tbody>";
					  
				for (var i=0;i<data.length;i++) {
					html_to_set += "\
						<tr>\
						  <td>"+get_job_name(data[i].job_id)+" - "+get_project_name(data[i].project_id)+"</td>\
						  <td>"+get_priority_label(data[i].priority)+"</td>\
						  <td>";
					
					<?php if($status_info[0]->user_start) { ?>
						html_to_set += "<button class=\"btn btn-mini btn-inverse button_start_task\" type=\"button\" task_id=\""+data[i].id+"\"><i class=\"icon-refresh icon-white\"></i> Switch Task</button>";
					<?php } else { ?>
						html_to_set += "<button class=\"btn btn-mini btn-success button_start_task\" type=\"button\" task_id=\""+data[i].id+"\"><i class=\"icon-time icon-white\"></i> Clock In</button>";
					<?php } ?>
					
					html_to_set += "</td></tr>";
				}
				
					  
				html_to_set += "\
					  </tbody>\
                    </table>";
					
				} else {
					var html_to_set = "<div style=\"text-align:center; font-style:italic;color:#666;\">You have no tasks.</div>";
				}
				
				$(".well_tasks_info").html(html_to_set);
				$(".well_tasks_info").show();
				$(".well_tasks_loading").hide();
			}
		});
		
	}
	
	function load_messages() {
		$(".well_messages_info").hide();
		$(".well_messages_loading").show();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_user/get_messages")); ?>',
			dataType:"json",
			success: function(data) {
				user_messages = data;
 
				if (data.length) {
					var html_to_set = "\
						<table class=\"table table-condensed hover_table\">\
						  <thead>\
							<tr>\
							  <th>From</th>\
							  <th>Sent</th>\
							  <th>Actions</th>\
							</tr>\
						  </thead>\
						  <tbody>";
						  
					for (var i=0;i<data.length;i++) {
						
						var from_user = "";
						for(j=0;j<user_list.length;j++) {
							if (user_list[j].id == data[i].from_id) {
								from_user = user_list[j].user_name;
								break;
							}
						}
						
						if(data[i].message_read == "0") {
							html_to_set += "\
							    <tr class=\"unread\">\
								  <td>"+from_user+"</td>\
								  <td>"+data[i].pretty_time+"</td>\
								  <td><button class=\"btn btn-mini btn-primary button_view_message\" type=\"button\" message_id=\""+data[i].id+"\"><i class=\"icon-eye-open icon-white\"></i> View</button></td>\
								</tr>";
						} else {
							html_to_set += "\
							    <tr>\
								  <td>"+from_user+"</td>\
								  <td>"+data[i].pretty_time+"</td>\
								  <td>\
										<button class=\"btn btn-mini btn-primary button_view_message\" type=\"button\" message_id=\""+data[i].id+"\"><i class=\"icon-eye-open icon-white\"></i> View</button>\
										<button class=\"btn btn-mini btn-danger button_delete_message\" type=\"button\" message_id=\""+data[i].id+"\"><i class=\"icon-trash icon-white\"></i> Delete</button>\
								  </td>\
								</tr>";
						}
					}
					
					html_to_set += "\
					  </tbody>\
                    </table>";
				} else {
					var html_to_set = "<div style=\"text-align:center; font-style:italic;color:#666;\">You have no messages.</div>";
				}
				
				
				
				$(".well_messages_info").html(html_to_set).show();
				$(".well_messages_loading").hide();
			}
		});
	}
	
	function updateWidget_stats() {
		$(".well_stats_info").hide();
		$(".well_stats_loading").show();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_user/get_user_stats")); ?>',
			dataType: 'html',
			success: function(data) {
				$(".well_stats_loading").hide();
				$(".well_stats_info").html(data).slideDown("slow");
			},
			fail: function(data) {
				$(".well_stats_loading").hide();
				alert("Error while updating stats widget: "+data);
			}
		});
	}
	
	function getstats() {
		//$(".well_stats_info").hide();
		//$(".well_stats_loading").show();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_user/get_stats")); ?>',
			dataType: 'json',
			success: function(data) {
				console.log(data);
				//$(".well_stats_loading").hide();
				//$(".well_stats_info").html(data).slideDown("slow");
			},
			fail: function(data) {
				$(".well_stats_loading").hide();
				alert("Error while updating stats widget: "+data);
			}
		});
	}
	
	$(".button_start_task").live("click",function() {
        var user_id = <?php echo($currentUserID); ?>;
		var task_id = $(this).attr("task_id");
		for (var i=0;i<user_tasks.length;i++) {
			if(user_tasks[i].id == task_id) {
				var job_id = user_tasks[i].job_id;
				var project_id = user_tasks[i].project_id;
                $.ajax({
                    url: '<?php echo(base_url("index.php/ajax_message/get_message_count")); ?>',
                    data: { user_id:user_id },
                    success: function (data) {
                        if(data > 0) {
                            alert('Please read all of your messages first.');
                        } else {
                            showClockInModal(job_id,project_id);
                        }
                    }
                });

				break;
			}
		}
	});
	
	$(".button_view_message").live("click",function() {
		
		var message_id = $(this).attr("message_id");
		console.log(message_id);

		if(user_messages.length) {
			for(var i=0;i<user_messages.length;i++) {
				if (user_messages[i].id == message_id) {
					var message_from_id = user_messages[i].from_id;
					var message_from = "";
					for(var j=0;j<user_list.length;j++) {
						if (user_list[j].id == message_from_id) {
							message_from = user_list[j].user_name;
							break;
						}
					}

                    $(".message_from").html(message_from);
					$(".message_sent").html(user_messages[i].pretty_time);
					$(".message_body").html(user_messages[i].message_content);
					$(".cur_message_id").val(user_messages[i].id);
                    $(".cur_from_id").val(message_from_id);
					$(".modal_view_message").modal('show');	
					break;
				}
			}
		}

	});

    $('.button_reply_message').live('click',function() {
        var cur_from_id = $(".cur_from_id").val();
        $('.modal_view_message').modal('hide');
        update_to_tags(cur_from_id + '|','')
        switchActivePane('button_sendmessage');

    });
	
	$(".button_close_message").live("click",function() {
		$(".modal_view_message").modal('hide');	
		var cur_message_id = $(".cur_message_id").val();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_message/mark_read")); ?>',
			type:"POST",
			dataType:"json",
			data:{ cur_message_id:cur_message_id },
			complete: function(data) { load_messages(); }
		});
	});
	
	$(".button_delete_message").live("click",function() {
		
		if($(".modal_view_message").is(":visible")) {
			var cur_message_id = $(".cur_message_id").val();
		} else {
			var cur_message_id = $(this).attr("message_id");
		}
		
		$(".modal_view_message").modal('hide');	

		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_message/delete_message")); ?>',
			type:"POST",
			dataType:"json",
			data:{ cur_message_id:cur_message_id },
			complete: function(data) { load_messages(); }
		});
	});
	
	$(".button_delete_message_all").live("click",function() {
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_message/delete_message_all")); ?>',
			complete: function() { load_messages(); }
		});
	});
	
	$(".button_clockIn").click(function() {
        var user_id = <?php echo($currentUserID); ?>;
		cur_job_id = $(".dash_cur_job").attr("itemID");
		cur_project_id = $(".dash_cur_project").attr("itemID");
        $.ajax({
            url: '<?php echo(base_url("index.php/ajax_message/get_message_count")); ?>',
            data: { user_id:user_id },
            success: function (data) {
                if(data > 0) {
                    alert('Please read all of your messages first.');
                } else {
                    showClockInModal(cur_job_id,cur_project_id);
                }
            }
        });
	});
	
	$(".button_clockOut").click(function() {
        $('.clock_out_or_switch').val('clock_out');
		$('.modal_set_box_data').modal('show');
	});
	
	$('.button_switchTask').click(function() {
		var user_id = <?php echo($currentUserID); ?>;
		$.ajax({
            url: '<?php echo(base_url("index.php/ajax_message/get_message_count")); ?>',
            data: { user_id:user_id },
            success: function (data) {
                if(data > 0) {
                    alert('Please read all of your messages first.');
                } else {
                    $('.clock_out_or_switch').val('switch');
					$('.modal_set_box_data').modal('show');
                }
            }
        });
	});
	
	$('.button_save_box_data').click(function() {
		var user_id = <?php echo($currentUserID); ?>;
		var box_id = $('.cur_box_id').val();
		var box_sf = $('.field_box_data_sf').val();
		var box_lf = $('.field_box_data_lf').val();
		var clock_out_or_switch = $('.clock_out_or_switch').val();
		cur_job_id = $(".dash_cur_job").attr("itemID");
		cur_project_id = $(".dash_cur_project").attr("itemID");
		
		if (isNumber(box_sf) == false || isNumber(box_lf) == false) {
			alert('Both values must be a number.');
		} else {
			
			$('.modal_set_box_data').modal('hide');
		
			//ajax call to set box image count data
			$.ajax({
				url: '<?php echo(base_url("index.php/ajax_box/save_box_data")); ?>',
				data: { 
					box_id:box_id,
					box_sf:box_sf,
					box_lf:box_lf 
				}
			});
			
			//show clock in modal if switch task, else just clock out
			switch(clock_out_or_switch) {
				
				case "switch":
					showClockInModal(cur_job_id,cur_project_id);
					break;
					
				
				case "clock_out": 
					$(".info_clockout").hide();
					$(".info_loading").show();
					sync_heights();
					$.ajax({
						url: '<?php echo(base_url("index.php/ajax_user/clock_out")); ?>',
						dataType: 'html',
						success: function(data) {
							$(".info_loading").hide();
							$(".info_clockin").show();
							updateWidget_stats();
							load_tasks();
							sync_heights();
						},
						error: function(data) {
							alert("An error occured while trying to clock you out");
							$(".info_loading").hide();
							$(".info_clockout").show();
							updateWidget_stats();
							load_tasks();
							sync_heights();
						}
					});
					break;
			}
			
		}
		
	});
	
	$(".refresh_stats").click(function() {updateWidget_stats();})
	
	$(document).ready(function() {
		
		<?php if($status_info[0]->user_start) { ?>
			$(".info_clockout").show();
		<?php } else { ?>
			$(".info_clockin").show();
		<?php } ?>
		
		load_messages();
		load_tasks();
		updateWidget_stats();
		sync_heights();
	});
	
	$(window).resize(function() {sync_heights();});
	$(window).scroll(function() {sync_heights();});
</script>