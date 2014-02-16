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

<div class="admin_tasks_filter mattswell" style="text-align:left;display:none;margin-bottom:20px;"></div>

<div class="mattswell_title">Tasks List</div>

<div class="admin_tasks_loading" style="text-align:center;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>
<div class="admin_tasks" style="display:none;">
	<div class="btn-group">
    	<button class="btn button_admin_modify_task" itemID="-1"><i class="icon-plus"></i> Add Task</button>
    </div>
    
    <div class="list_tasks">
    
    </div>
</div>

<script type="text/javascript">
	
	function refresh_admin_task_filters() {
		$('.admin_tasks_filter').hide();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_task/get_filters_html")); ?>',
			dataType: 'html',
			success: function(data) {
				$('.admin_tasks_filter').html(data);
				$('.admin_tasks_filter').show();
				refresh_admin_tasks_list();
			},
			error: function(data) {
				alert("Error while updating filters: "+data);
				$('.admin_tasks_filter').show();
			}
		});
	}
	
	function refresh_admin_tasks_list() {
		var job_id = $('.tasks_jobSelector').val();
		var project_id = $('.tasks_projectSelector').val();
		$('.admin_tasks').hide();
		$('.admin_tasks_loading').show();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_task/get_admin_tasks_list")); ?>',
			dataType: 'html',
			data: {
				job_id:job_id,
				project_id:project_id
			},
			success: function(data) {
				$('.list_tasks').html(data);
				$('.admin_tasks_loading').hide();
				$('.admin_tasks').show();
			},
			error: function(data) {
				console.log(data);
				alert("Error while updating admin tasks list: "+data);
				$('.admin_tasks_loading').hide();
				$('.admin_tasks').show();
			}
		});
	}
	
	function sumbit_addTask() {//FINISH ME
		$(".admin_tasks").hide();
		$(".admin_tasks_loading").show();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_task/add_task")); ?>',
			type: 'post',
			dataType: 'html',
			success: function(data) {
				refresh_admin_tasks_list();
				if (data == '0') {
					alert("Failed to add new task!");
				} else {
					showmodTaskModal(data);
				}
			},
			error: function(data) {
				alert("Sorry, something went terribly wrong...");
				refresh_admin_tasks_list();
			}
		});

	}
	
	$('.button_admin_add_task').click(function() {sumbit_addTask()});
	
	$('.tasks_jobSelector').live('change', function() {refresh_admin_tasks_list();});
	$('.tasks_projectSelector').live('change', function() {refresh_admin_tasks_list();});
	
	$('.button_admin_modify_task').live('click', function() {
		var ID_selected = $(this).attr('itemID');
		showmodTaskModal(ID_selected);
	});
	
	$('.button_admin_delete_task').live('click', function() {
		var ID_selected = $(this).attr('itemID');
		$('tr[itemID="'+ID_selected+'"]').hide('slow');
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_task/delete_task")); ?>',
			type: 'post',
			dataType: 'html',
			data: {taskID_to_delete:ID_selected},
			success: function(data) {
			},
			error: function(data) {
				alert("Error while deleting task: "+data);
			}
		});
	});
	
	$('.button_close_addTask').click(function() {$('.modal_addTask').modal('hide');});
	
	$('.button_addTask_submit').click(function() {sumbit_addTask();});
	$('.field_addTask').keypress(function(e) {
		if (e.which == 13) {
			sumbit_addTask();
		}
	})
	
	$(document).ready(function() {
		refresh_admin_task_filters();
	});
	
</script>