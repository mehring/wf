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
	
	.total_time {
		font-size:18px;
	}
	
</style>

<div class="admin_logs_filters mattswell" style="text-align:left;">

	<table style="background-color:transparent;">
    	<tr style="background-color:transparent;">
        	<td><span class="custom_select_label">Search Filters</span></td>
            <td style="padding-left:20px;"><span class="custom_select_label">Sort By</span></td>
            <td rowspan="2" align="left" valign="middle" style="padding-left:20px;">
                <div class="btn-group">
                    <a class="btn btn-large admin_logs_button_reset"><i class="icon-share-alt"></i>&nbsp;Reset Filters</a>
                    <a class="btn btn-large btn-primary admin_logs_button_search"><i class="icon-search icon-white"></i>&nbsp;Search</a>
                </div>
            </td>
        </tr>
        <tr style="background-color:transparent;">
        	<td>
            	<div class="btn-group" data-toggle="buttons-checkbox" style="margin-top:5px;">
                    <a class="btn admin_logs_btn_filterType">User</a>
                    <a class="btn admin_logs_btn_filterType">Job</a>
                    <a class="btn admin_logs_btn_filterType">Project</a>
                    <a class="btn admin_logs_btn_filterType">Box</a>
                    <a class="btn admin_logs_btn_filterType">Date</a>
                </div>
            </td>
            <td style="padding-left:20px;">
            	<div class="input-append" style="margin-top:5px;">
                    <select class="admin_logs_order_by">
                        <option>Date</option>
                        <option>User</option>
                        <option>Job</option>
                        <option>Project</option>
                        <option>Box</option>
                    </select>
                    <div class="btn-group" data-toggle="buttons-radio" style="display:inline-block;">
                        <a class="btn admin_logs_btn_sortDesc active"><i class="icon-arrow-down"></i></a>
                        <a class="btn admin_logs_btn_sortAsc"><i class="icon-arrow-up"></i></a>
                    </div>
                </div>
            </td>
        </tr>
    </table>
	<hr style="margin:5px 0; border-color:silver;" />
    <table style="background-color:transparent; margin-top:10px;" cellpadding="5px" width="100%">
    	<tr class="admin_logs_filterGroup admin_logs_filterGroup_user" style="background-color:transparent;display:none;">
        	<td align="right" valign="middle" width="100px">User:&nbsp;</td>
            <td align="left" valign="top">
            	<div class="admin_logs_filter_user_loading" style="text-align:center;display:none;">
                    <img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
                </div>
                <div class="admin_logs_filter_user_body">
                    <select class="admin_logs_filter_user" style="width:100%;margin-bottom:0px;">
                        <option value="">Select One</option>
                    </select>
                </div>
            </td>
        </tr>
        
        <tr class="admin_logs_filterGroup admin_logs_filterGroup_job" style="background-color:transparent;display:none;">
        	<td align="right" valign="middle" width="100px">Job:&nbsp;</td>
            <td align="left" valign="top">
            	<div class="admin_logs_filter_job_loading" style="text-align:center;display:none;">
                    <img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
                </div>
                <div class="admin_logs_filter_job_body">
                    <select class="admin_logs_filter_job" style="width:100%;margin-bottom:0px;">
                        <option value="">Select One</option>
                    </select>
                </div>
            </td>
        </tr>
        
        <tr class="admin_logs_filterGroup admin_logs_filterGroup_project" style="background-color:transparent;display:none;">
        	<td align="right" valign="middle" width="100px">Project:&nbsp;</td>
            <td align="left" valign="top">
            	<div class="admin_logs_filter_project_loading" style="text-align:center;display:none;">
                    <img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
                </div>
                <div class="admin_logs_filter_project_body">
                    <select class="admin_logs_filter_project" style="width:100%;margin-bottom:0px;">
                        <option value="">Select One</option>
                    </select>
                </div>
            </td>
        </tr>
        
        <tr class="admin_logs_filterGroup admin_logs_filterGroup_box" style="background-color:transparent;display:none;">
        	<td align="right" valign="middle" width="100px">Box:&nbsp;</td>
            <td align="left" valign="top">
            	<div class="admin_logs_filter_box_loading" style="text-align:center;display:none;">
                    <img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
                </div>
                <div class="admin_logs_filter_box_body">
                    <select class="admin_logs_filter_box" style="width:100%;margin-bottom:0px;">
                        <option value="">Select One</option>
                    </select>
                </div>
            </td>
        </tr>
        
        <tr class="admin_logs_filterGroup admin_logs_filterGroup_date" style="background-color:transparent;display:none;">
        	<td align="right" valign="middle" width="100px">Date:&nbsp;</td>
            <td align="left" valign="top">
            	<div class="admin_logs_filter_date_loading" style="text-align:center;display:none;">
                    <img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
                </div>
                <div class="admin_logs_filter_date_body">
                    <input class="admin_logs_filter_date admin_logs_filter_dateFrom" />&nbsp;to&nbsp;<input class="admin_logs_filter_date admin_logs_filter_dateTo" />
                </div>
            </td>
        </tr>
    </table>
    
</div>

<div class="mattswell_logs_title" style="padding-top:40px;display:none;">Results</div>

<div class="admin_logs_loading" style="text-align:center;display:none;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>

<div class="admin_logs" style="display:none;">
	<div class="btn-group" style="display:inline-block;float:left;">
    	<button class="btn button_admin_add_log"><i class="icon-plus"></i> Add Log</button>
    </div>
    
    <div class="admin_logs_itemsper_selector" style="display:inline-block;float:right;position:relative;top:-37px;">
    	Display:&nbsp;
        <div style="display:inline-block;" class="btn-group admin_logs_btnlst_itemsper" data-toggle="buttons-radio">
        	<a class="btn admin_logs_btn_itemsper active">10</a>
            <a class="btn admin_logs_btn_itemsper">25</a>
            <a class="btn admin_logs_btn_itemsper">50</a>
            <a class="btn admin_logs_btn_itemsper">100</a>
        </div>
        &nbsp;per page
    </div>
    
    <div class="page_selector" style="display:inline-block;float:right;position:relative;">
    	<div style="display:inline-block;" class="pages_label"></div>&nbsp;
        <div class="btn-group">
        	<a class="btn admin_logs_btn_navpage_fast_backward"><i class="icon-fast-backward"></i></a>
            <a class="btn admin_logs_btn_navpage_backward"><i class="icon-backward"></i></a>
        </div>
        <div style="display:inline-block;" class="btn-group btnlst_page" data-toggle="buttons-radio"></div>
        <div class="btn-group">
        	<a class="btn admin_logs_btn_navpage_forward"><i class="icon-forward"></i></a>
            <a class="btn admin_logs_btn_navpage_fast_forward"><i class="icon-fast-forward"></i></a>
        </div>
    </div>
    
    <div style="clear:both;"></div>
    
    <div class="list_logs"></div>
    
    <div class="page_selector_bot" style="display:inline-block;float:right;">
    	<div style="display:inline-block;" class="pages_label"></div>&nbsp;
        <div class="btn-group">
        	<a class="btn admin_logs_btn_navpage_fast_backward"><i class="icon-fast-backward"></i></a>
            <a class="btn admin_logs_btn_navpage_backward"><i class="icon-backward"></i></a>
        </div>
        <div style="display:inline-block;" class="btn-group btnlst_page" data-toggle="buttons-radio"></div>
        <div class="btn-group">
        	<a class="btn admin_logs_btn_navpage_forward"><i class="icon-forward"></i></a>
            <a class="btn admin_logs_btn_navpage_fast_forward"><i class="icon-fast-forward"></i></a>
        </div>
    </div>
    
    <div class="total_time">
    	Total time: <span class="time_total"></span>
    </div>
    
</div>

<div class="modal hide modal_addLog">
  <div class="modal-header">
    <input type="hidden" class="cur_log_id" value="-1" />
    <button type="button" class="close button_close_addLog" aria-hidden="true">&times;</button>
    <h3><span class="admin_modal_project_title"></span> Log</h3>
  </div>
  <div class="modal-body">
    <div class="modal_addLog_body" style="text-align:center;">
    	<table width="100%" cellpadding="4px" cellspacing="0" border="0">
        	<tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;">User:</td>
                <td align="left"><select class="field_addLog_user"></select></td>
            </tr>
            <tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;">Job:</td>
                <td align="left"><select class="field_addLog_job"></select></td>
            </tr>
            <tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;">Project:</td>
                <td align="left"><select class="field_addLog_project"></select></td>
            </tr>
            <tr class="field_addLog_box_row" style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;">Box:</td>
                <td align="left"><select class="field_addLog_box"></select></td>
            </tr>
            <tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;">Start:</td>
                <td align="left">
                	<input type="text" class="field_addLog_start_date" placeholder="Date" style="width:85px;" />
                    <input type="text" class="field_addLog_start_hour" placeholder="Hour" style="width:35px;" maxlength="2" /> :
                    <input type="text" class="field_addLog_start_minute" placeholder="Min" style="width:35px;" maxlength="2" />
                    <select class="field_addLog_start_ampm" style="width:65px;">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </td>
            </tr>
            <tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;">Stop:</td>
                <td align="left">
                	<input type="text" class="field_addLog_stop_date" placeholder="Date" style="width:85px;" />
                    <input type="text" class="field_addLog_stop_hour" placeholder="Hour" style="width:35px;" maxlength="2" /> :
                    <input type="text" class="field_addLog_stop_minute" placeholder="Min" style="width:35px;" maxlength="2" />
                    <select class="field_addLog_stop_ampm" style="width:65px;">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </td>
            </tr>
        </table>
    </div>
    <div class="modal_addLog_loading" style="text-align:center; display:none;">
    	<span class="admin_modal_project_loadtext"></span> <div class="addLog_label" style="display:inline-block"></div><br />
    	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
    </div>
  </div>
  <div class="modal-footer modal_addLog_footer">
  	<div class="modal_addLog_footer_body">
        <a href="#" class="btn btn-danger button_close_addLog"><i class="icon-remove icon-white"></i>&nbsp;Close</a>
        <a href="#" id="modal_addLog_submit" class="btn btn-primary button_addLog_submit"><i class="icon-ok icon-white"></i>&nbsp;Submit</a>
    </div>
  </div>
</div>

<script type="text/javascript">
	var box_list = "";
	
	function refresh_admin_logs_filter_user() {
		$('.admin_logs_filter_user_loading').show();
		$('.admin_logs_filter_user_body').hide();
		$('.admin_logs_filter_user option:gt(0)').remove();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax/get_admin_logs_filter_users")); ?>',
			type: 'post',
			dataType: 'json',
			data: {},
			success: function(data) {
				
				for (var i=0;i<data.results.length;i++) {
					$('.admin_logs_filter_user').append($('<option></option>').attr('value',data.results[i]['id']).text(data.results[i]['user_name']));
				}
				
				$('.admin_logs_filter_user_loading').hide();
				$('.admin_logs_filter_user_body').show();
			},
			fail: function(data) {
				alert("Error while updating filter user list: "+data);
				$('.admin_logs_filter_user_loading').hide();
			}
		});
	}
	
	function refresh_admin_logs_filter_job() {
		$('.admin_logs_filter_job_loading').show();
		$('.admin_logs_filter_job_body').hide();
		$('.admin_logs_filter_job option:gt(0)').remove();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax/get_admin_logs_filter_jobs")); ?>',
			type: 'post',
			dataType: 'json',
			data: {},
			success: function(data) {

				for (var i=0;i<data.results.length;i++) {
					$('.admin_logs_filter_job').append($('<option></option>').attr('value',data.results[i]['id']).text(data.results[i]['job_name']));
				}
				
				$('.admin_logs_filter_job_loading').hide();
				$('.admin_logs_filter_job_body').show();
			},
			fail: function(data) {
				alert("Error while updating filter job list: "+data);
				$('.admin_logs_filter_job_loading').hide();
			}
		});
	}
	
	function refresh_admin_logs_filter_project() {
		$('.admin_logs_filter_project_loading').show();
		$('.admin_logs_filter_project_body').hide();
		$('.admin_logs_filter_box option:gt(0)').remove();
		$('.admin_logs_filter_project option:gt(0)').remove();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax/get_admin_logs_filter_projects")); ?>',
			type: 'post',
			dataType: 'json',
			data: {},
			success: function(data) {

				for (var i=0;i<data.results.length;i++) {
					$('.admin_logs_filter_project').append($('<option></option>').attr('value',data.results[i]['id']).text(data.results[i]['project_name']));
				}
				
				$('.admin_logs_filter_project_loading').hide();
				$('.admin_logs_filter_project_body').show();
			},
			fail: function(data) {
				alert("Error while updating filter project list: "+data);
				$('.admin_logs_filter_project_loading').hide();
			}
		});
	}
	
	function refresh_admin_logs_filter_box() {
		$('.admin_logs_filter_box_loading').show();
		$('.admin_logs_filter_box_body').hide();
		$('.admin_logs_filter_box option:gt(0)').remove();
		var project_selected = $('.admin_logs_filter_project').val();
		
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax/get_admin_logs_filter_boxes")); ?>',
			type: 'post',
			dataType: 'json',
			data: {project_id:project_selected},
			success: function(data) {
				
				for (var i=0;i<data.results.length;i++) {
					$('.admin_logs_filter_box').append($('<option></option>').attr('value',data.results[i]['id']).text(data.results[i]['box_name']));
				}
				
				$('.admin_logs_filter_box_loading').hide();
				$('.admin_logs_filter_box_body').show();
			},
			fail: function(data) {
				alert("Error while updating filter box list: "+data);
				$('.admin_logs_filter_box_loading').hide();
			}
		});
	}
	
	function refresh_admin_logs_list() {
		$('.mattswell_logs_title').hide();
		$('.admin_logs_filters').hide();
		$('.admin_logs').hide();
		$('.admin_logs_loading').show();
		
		var filter_user = $('.admin_logs_btn_filterType').filter(function() {return $(this).html() == 'User';}).hasClass('active');
		var filter_job = $('.admin_logs_btn_filterType').filter(function() {return $(this).html() == 'Job';}).hasClass('active');
		var filter_project = $('.admin_logs_btn_filterType').filter(function() {return $(this).html() == 'Project';}).hasClass('active');
		var filter_box = $('.admin_logs_btn_filterType').filter(function() {return $(this).html() == 'Box';}).hasClass('active');
		var filter_date = $('.admin_logs_btn_filterType').filter(function() {return $(this).html() == 'Date';}).hasClass('active');
		var filter_user_val = $('.admin_logs_filter_user').val();
		var filter_job_val = $('.admin_logs_filter_job').val();
		var filter_project_val = $('.admin_logs_filter_project').val();
		var filter_box_val = $('.admin_logs_filter_box').val();
		var filter_date_start_val = $('.admin_logs_filter_dateFrom').val();
		var filter_date_end_val = $('.admin_logs_filter_dateTo').val();
		
		var sort_by_val = $('.admin_logs_order_by').val();
		
		if($('.admin_logs_btn_sortDesc').hasClass('active')) {
			var sort_by_dir = 1;
		} else {
			var sort_by_dir = 0;
		}

		$.ajax({
			url: '<?php echo(base_url("index.php/ajax/get_admin_logs_list")); ?>',
			type: 'post',
			dataType: 'json',
			data: {
				filter_user:filter_user,
				filter_job:filter_job,
				filter_project:filter_project,
				filter_box:filter_box,
				filter_date:filter_date,
				filter_user_val:filter_user_val,
				filter_job_val:filter_job_val,
				filter_project_val:filter_project_val,
				filter_box_val:filter_box_val,
				filter_date_start_val:filter_date_start_val,
				filter_date_end_val:filter_date_end_val,
				sort_by_val:sort_by_val,
				sort_by_dir:sort_by_dir,
				cur_itemsper:cur_itemsper,
				cur_page:cur_page
			},
			success: function(data) {
				console.log(data);
				records_total = data.records_total;

				$('.time_total').html(data.total_time);

				htmlToSet = "";
				htmlToSet += "\
				<table class=\"table hover_table solid_table table-condensed\" style=\"margin-top:15px;\">\
    			\
				<thead><tr>\
					<th>User</th>\
					<th>Job</th>\
					<th>Project</th>\
					<th>Box</th>\
					<th>Start</th>\
					<th>Stop</th>\
					<th>Time</th>\
					<th>Actions</th>\
				</tr></thead>\
				\
				<tbody>";
				
				for (var i=0;i<data.results.length;i++) {
					
					htmlToSet += "\
					<tr class=\"box_row\" itemID="+data.results[i]['id']+">\
						<td><?php echo("<img src=".base_url("assets/img/ui/icons/loghistory.png")." />") ?>&nbsp;"+data.results[i]['user_name']+"</td>\
						<td>"+data.results[i]['job_name']+"</td>\
						<td>"+data.results[i]['project_name']+"</td>\
						<td>"+data.results[i]['box_name']+"</td>\
						<td>"+data.results[i]['log_start']+"</td>\
						<td>"+data.results[i]['log_stop']+"</td>\
						<td>"+data.results[i]['time_string']+"</td>\
						<td>\
						  <a class=\"admin_button black button_admin_edit_log\" style=\"color:black;\" itemID="+data.results[i]['id']+"><span class=\"ico-edit\"></span>&nbsp;Edit</a>\
						  <a class=\"admin_button red button_admin_delete_log\" style=\"color:red;\" itemID="+data.results[i]['id']+"><span class=\"ico-trash\"></span>&nbsp;Delete</a>\
						</td>\
					</tr>";
					
				}
				
				htmlToSet += "</tbody></table>";
				
				$('.list_logs').html(htmlToSet);
				$('.mattswell_logs_title').show();
				$('.admin_logs_filters').show();
				$('.admin_logs').show();
				$('.admin_logs_loading').hide();
				var left_to_set = $('.admin_logs_itemsper_selector').width();
				$('.page_selector').css('left',left_to_set+"px");
				refresh_page_value();
			},
			fail: function(data) {
				alert("Error while updating logs list: "+data);
				$('.admin_logs_filters').show();
				$('.admin_logs').hide();
				$('.admin_logs_loading').hide();
				refresh_page_value();
			}
		});
	}
	
	$('.admin_logs_btn_filterType').click(function() {
		if (!$(this).hasClass('active')) {
			switch($(this).html()) {
				case "User": $('.admin_logs_filterGroup_user').show();refresh_admin_logs_filter_user();break;
				case "Job": $('.admin_logs_filterGroup_job').show();refresh_admin_logs_filter_job();break;
				case "Project": $('.admin_logs_filterGroup_project').show();refresh_admin_logs_filter_project();break;
				case "Box":
					$('.admin_logs_filterGroup_box').show();
					$('.admin_logs_btn_filterType').filter(function() {
						return $(this).html() == "Project";
					}).addClass('active');
					$('.admin_logs_filterGroup_project').show();
					if ($('.admin_logs_filter_project').val() == "Select One") { refresh_admin_logs_filter_project() }
					break;
				case "Date":
					$('.admin_logs_filterGroup_date').show();
					
					var today = new Date();
					var dd = today.getDate();
					var mm = today.getMonth()+1; //January is 0!
					
					var yyyy = today.getFullYear();
					if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = yyyy+'-'+mm+'-'+dd;
					
					$('.admin_logs_filter_date').val(today);
					break;
			}
		} else {
			switch($(this).html()) {
				case "User": $('.admin_logs_filterGroup_user').hide();break;
				case "Job": $('.admin_logs_filterGroup_job').hide();break;
				case "Project": 
					$('.admin_logs_filterGroup_project').hide();
					$('.admin_logs_btn_filterType').filter(function() {
						return $(this).html() == "Box";
					}).removeClass('active');
					$('.admin_logs_filterGroup_box').hide();
					break;
				case "Box": $('.admin_logs_filterGroup_box').hide();break;
				case "Date": $('.admin_logs_filterGroup_date').hide();break;
			}
		}
	});
	
	$('.admin_logs_button_reset').click(function() {
		$('.admin_logs_btn_filterType').removeClass('active');
		$('.admin_logs_filterGroup').hide();
		$('.admin_logs_order_by').val('date');
		$('.admin_logs_btn_sortAsc').removeClass('active');
		$('.admin_logs_btn_sortDesc').addClass('active');
	});
	
	$('.button_admin_add_log').click(function() {
		$('.cur_log_id').val(-1);
        $('#modal_addLog_submit').removeClass('button_editLog_submit').addClass('button_addLog_submit');
		$('.admin_modal_project_title').html('Add ');
		$('.admin_modal_project_loadtext').html('Loading');
		$('.modal_addLog_loading').show();
		$('.modal_addLog_body').hide();
		
		$('.field_addLog_user').find('option').remove().end().append('<option value="-1">Select One</option>').val('-1');
		$('.field_addLog_job').find('option').remove().end().append('<option value="-1">Select One</option>').val('-1');
		$('.field_addLog_project').find('option').remove().end().append('<option value="-1">Select One</option>').val('-1');
		$('.field_addLog_box_row').hide();
		$('.field_addLog_box').find('option').remove().end().append('<option value="-1">Select One</option>').val('-1');
		
		$('.modal_addLog').modal('show');
		$.ajax({
			url: "<?php echo(base_url("index.php/ajax/get_admin_logs_modal_data")); ?>",
			dataType:"json",
			data: { log_id:"-1" },
			success: function(data) {
				console.log(data);
				box_list = data.boxes;
				
				for(var i=0;i<data.users.length;i++) {
					$('.field_addLog_user').append('<option value="'+data.users[i].id+'">'+data.users[i].user_name+'</option>');
				}
				for(var i=0;i<data.jobs.length;i++) {
					$('.field_addLog_job').append('<option value="'+data.jobs[i].id+'">'+data.jobs[i].job_name+'</option>');
				}
				for(var i=0;i<data.projects.length;i++) {
					$('.field_addLog_project').append('<option value="'+data.projects[i].id+'">'+data.projects[i].project_name+'</option>');
				}
				
				$('.modal_addLog_footer_body').show();
				$('.modal_addLog_loading').hide();
				$('.modal_addLog_body').show();
			},
			error: function(data) {
				console.log(data);
			}
		});
	});
	
	$('.button_admin_delete_log').live('click',function() {
		var itemid = $(this).attr('itemid');
		$('tr[itemid="'+itemid+'"]').fadeOut();
		$.ajax({
			url: "<?php echo(base_url("index.php/ajax/delete_log")); ?>",
			dataType:"json",
			data: { log_id:itemid },
			success: function(data) { console.log(data); }
		});
	});
	
	$('.button_admin_edit_log').live('click',function() {
		var itemid = $(this).attr('itemid');
		$('.cur_log_id').val(itemid);
        $('#modal_addLog_submit').removeClass('button_addLog_submit').addClass('button_editLog_submit');
		$('.admin_modal_project_title').html('Edit ');
		$('.admin_modal_project_loadtext').html('Loading');
		$('.modal_addLog_loading').show();
		$('.modal_addLog_body').hide();
		
		$('.field_addLog_user').find('option').remove().end().append('<option value="-1">Select One</option>').val('-1');
		$('.field_addLog_job').find('option').remove().end().append('<option value="-1">Select One</option>').val('-1');
		$('.field_addLog_project').find('option').remove().end().append('<option value="-1">Select One</option>').val('-1');
		$('.field_addLog_box_row').hide();
		$('.field_addLog_box').find('option').remove().end().append('<option value="-1">Select One</option>').val('-1');
		
		$('.modal_addLog').modal('show');
		$.ajax({
			url: "<?php echo(base_url("index.php/ajax/get_admin_logs_modal_data")); ?>",
			dataType:"json",
			data: { log_id:itemid },
			success: function(data) {
				console.log(data);
				box_list = data.boxes;
				
				for(var i=0;i<data.users.length;i++) {
					$('.field_addLog_user').append('<option value="'+data.users[i].id+'">'+data.users[i].user_name+'</option>');
				}
				for(var i=0;i<data.jobs.length;i++) {
					$('.field_addLog_job').append('<option value="'+data.jobs[i].id+'">'+data.jobs[i].job_name+'</option>');
				}
				for(var i=0;i<data.projects.length;i++) {
					$('.field_addLog_project').append('<option value="'+data.projects[i].id+'">'+data.projects[i].project_name+'</option>');
				}
				
				$('.field_addLog_user').val(data.log_data.user_id);
				$('.field_addLog_job').val(data.log_data.job_id);
				$('.field_addLog_project').val(data.log_data.project_id);
				
				update_addLog_box_list();
				
				$('.field_addLog_box').val(data.log_data.box_id);
				$('.field_addLog_start_date').val(data.log_data.start_date);
				$('.field_addLog_start_hour').val(data.log_data.start_hour);
				$('.field_addLog_start_minute').val(data.log_data.start_min);
				$('.field_addLog_start_ampm').val(data.log_data.start_period);
				$('.field_addLog_stop_date').val(data.log_data.stop_date);
				$('.field_addLog_stop_hour').val(data. log_data.stop_hour);
				$('.field_addLog_stop_minute').val(data.log_data.stop_min);
				$('.field_addLog_stop_ampm').val(data.log_data.stop_period);
				
				$('.modal_addLog_footer_body').show();
				$('.modal_addLog_loading').hide();
				$('.modal_addLog_body').show();
			},
			error: function(data) {
				console.log(data);
			}
		});
	});

    $('.button_editLog_submit').live('click',function() {
        var log_id = $('.cur_log_id').val();
        var user_to_send = $('.field_addLog_user').val();
        var job_to_send = $('.field_addLog_job').val();
        var project_to_send = $('.field_addLog_project').val();
        var box_to_send = $('.field_addLog_box').val();
        var start_date_to_send = $('.field_addLog_start_date').val();
        var start_hour_to_send = $('.field_addLog_start_hour').val();
        var start_min_to_send = $('.field_addLog_start_minute').val();
        var start_period_to_send = $('.field_addLog_start_ampm').val();
        var stop_date_to_send = $('.field_addLog_stop_date').val();
        var stop_hour_to_send = $('.field_addLog_stop_hour').val();
        var stop_min_to_send = $('.field_addLog_stop_minute').val();
        var stop_period_to_send = $('.field_addLog_stop_ampm').val();
        $('.modal_addLog_loading').show();
        $('.modal_addLog_body').hide();
        $('.modal_addLog_footer_body').hide();
        console.log(log_id);
        $.ajax({
            url: '<?php echo(base_url("index.php/ajax/edit_log")); ?>',
            dataType:"json",
            data: {
                log_id:log_id,
                user_to_send:user_to_send,
                job_to_send:job_to_send,
                project_to_send:project_to_send,
                box_to_send:box_to_send,
                start_date_to_send:start_date_to_send,
                start_hour_to_send:start_hour_to_send,
                start_min_to_send:start_min_to_send,
                start_period_to_send:start_period_to_send,
                stop_date_to_send:stop_date_to_send,
                stop_hour_to_send:stop_hour_to_send,
                stop_min_to_send:stop_min_to_send,
                stop_period_to_send:stop_period_to_send
            },
            success: function(data) {
                console.log(data);
                if (data.error == "") {
                    refresh_admin_logs_list();
                    $('.modal_addLog').modal('hide');
                } else {
                    alert(data.error);
                    $('.modal_addLog_loading').hide();
                    $('.modal_addLog_body').show();
                    $('.modal_addLog_footer_body').show();
                }

            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    $('.button_addLog_submit').live('click',function() {
        var user_to_send = $('.field_addLog_user').val();
        var job_to_send = $('.field_addLog_job').val();
        var project_to_send = $('.field_addLog_project').val();
        var box_to_send = $('.field_addLog_box').val();
        var start_date_to_send = $('.field_addLog_start_date').val();
        var start_hour_to_send = $('.field_addLog_start_hour').val();
        var start_min_to_send = $('.field_addLog_start_minute').val();
        var start_period_to_send = $('.field_addLog_start_ampm').val();
        var stop_date_to_send = $('.field_addLog_stop_date').val();
        var stop_hour_to_send = $('.field_addLog_stop_hour').val();
        var stop_min_to_send = $('.field_addLog_stop_minute').val();
        var stop_period_to_send = $('.field_addLog_stop_ampm').val();
        $('.modal_addLog_loading').show();
        $('.modal_addLog_body').hide();
        $('.modal_addLog_footer_body').hide();
        $.ajax({
            url: '<?php echo(base_url("index.php/ajax/add_log")); ?>',
            dataType:"json",
            data: {
                user_to_send:user_to_send,
                job_to_send:job_to_send,
                project_to_send:project_to_send,
                box_to_send:box_to_send,
                start_date_to_send:start_date_to_send,
                start_hour_to_send:start_hour_to_send,
                start_min_to_send:start_min_to_send,
                start_period_to_send:start_period_to_send,
                stop_date_to_send:stop_date_to_send,
                stop_hour_to_send:stop_hour_to_send,
                stop_min_to_send:stop_min_to_send,
                stop_period_to_send:stop_period_to_send
            },
            success: function(data) {
                console.log(data);
                if (data.error == "") {
                    refresh_admin_logs_list();
                    $('.modal_addLog').modal('hide');
                } else {
                    alert(data.error);
                    $('.modal_addLog_loading').hide();
                    $('.modal_addLog_body').show();
                    $('.modal_addLog_footer_body').show();
                }

            },
            error: function(data) {
                console.log(data);
            }
        });
    });
	
	$('.admin_logs_filter_project').change(function() {
		var project_id_selected = $('.admin_logs_filter_project').val();
		if (project_id_selected == "Select One") {
			$('.admin_logs_filter_box option:gt(0)').remove();
		} else { refresh_admin_logs_filter_box() }
	});
	
	function update_addLog_box_list() {
		$('.field_addLog_box').find('option').remove().end().append('<option value="-1">Select One</option>').val('-1');
		$('.field_addLog_box_row').hide();
		var cur_selected_project_id = $('.field_addLog_project').val();
		if (cur_selected_project_id != -1) {
			for(var i=0;i<box_list.length;i++) {
				if (box_list[i].project_id == cur_selected_project_id) {
					$('.field_addLog_box').append('<option value="'+box_list[i].id+'">'+box_list[i].box_name+'</option>');
				}
			}
			$('.field_addLog_box_row').show();
		}
	}
	
	$('.field_addLog_project').change(function() { update_addLog_box_list() });
	
	$(document).ready(function() {
		$('.admin_logs_filter_date').datepicker({ dateFormat: "yy-mm-dd" });
	});
	
	$('.admin_logs_button_search').click(function() {refresh_admin_logs_list()});
	$('.button_close_addLog').click(function() { $('.modal_addLog').modal('hide'); });
	$('.field_addLog_start_date,.field_addLog_stop_date').datepicker({ dateFormat: "yy-mm-dd" });
	
	$('.btn_logs_page').live('click',function() {
		cur_page = parseInt($(this).html());
		refresh_admin_logs_list();
	});
	
	$('.admin_logs_btn_itemsper').click(function() {
		cur_itemsper = parseInt($(this).html());
		refresh_admin_logs_list();
	});
	
	$('.admin_logs_btn_navpage_fast_backward').click(function() {
		cur_page = 1;
		refresh_admin_logs_list();
	});
	
	$('.admin_logs_btn_navpage_backward').click(function() {
		var go_to_page = cur_page - 1;
		if (go_to_page < 1) {go_to_page = 1}
		cur_page = go_to_page;
		refresh_admin_logs_list();
	});
	
	$('.admin_logs_btn_navpage_forward').click(function() {
		var go_to_page = cur_page + 1;
		if (go_to_page > pages_total) {go_to_page = pages_total}
		cur_page = go_to_page;
		refresh_admin_logs_list();
	});
	
	$('.admin_logs_btn_navpage_fast_forward').click(function() {
		cur_page = pages_total;
		refresh_admin_logs_list();
	});
	
</script>