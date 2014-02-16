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
                    <a class="btn admin_logs_btn_filterType active">User</a>
                    <a class="btn admin_logs_btn_filterType">Job</a>
                    <a class="btn admin_logs_btn_filterType">Project</a>
                    <a class="btn admin_logs_btn_filterType">Box</a>
                    <a class="btn admin_logs_btn_filterType active">Date</a>
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

<script type="text/javascript">
	var box_list = "";
	
	function refresh_admin_logs_filter_user(user_id) {
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
				
				if(user_id) {
					$('.admin_logs_filter_user').val(user_id);
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
	
	$(document).ready(function() {
		$('.admin_logs_filter_date').datepicker({ dateFormat: "yy-mm-dd" });
		
		$('.admin_logs_filterGroup_user').show();
		refresh_admin_logs_filter_user(<?php echo $currentUserID; ?>);
		$('.admin_logs_filterGroup_date').show();			
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = yyyy+'-'+mm+'-'+dd;
		$('.admin_logs_filter_date').val(today);
	});
	
	$('.admin_logs_button_search').click(function() {refresh_admin_logs_list();});
	
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