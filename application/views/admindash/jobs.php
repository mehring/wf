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

<div class="mattswell_title">Jobs List</div>

<div class="admin_jobs_loading" style="text-align:center;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>
<div class="admin_jobs" style="display:none;">
	<div class="btn-group">
    	<button class="btn button_admin_add_job"><i class="icon-plus"></i> Add Job</button>
    </div>
    
    <div class="list_jobs">
    
    </div>
</div>


<div class="modal hide modal_addJob">
  <div class="modal-header">
    <button type="button" class="close button_close_addJob" aria-hidden="true">&times;</button>
    <h3>Add Job - Enter Name</h3>
  </div>
  <div class="modal-body">
    <div class="modal_addJob_name" style="text-align:center;">
    	<div class="modal_addJob_error_1 alert alert-error" style="display:none;"><strong>Error! </strong>That job name already exists.</div>
        <input type="text" class="field_addJob" maxlength="100" />
    </div>
    <div class="modal_addJob_loading" style="text-align:center; display:none;">
    	Attempting to add <div class="addJob_label" style="display:inline-block"></div><br />
    	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
    </div>
  </div>
  <div class="modal-footer modal_addJob_footer">
    <a href="#" class="btn btn-danger button_close_addJob"><i class="icon-remove icon-white"></i>&nbsp;Close</a>
    <a href="#" class="btn btn-primary button_addJob_submit"><i class="icon-ok icon-white"></i>&nbsp;Submit</a>
  </div>
</div>

<script type="text/javascript">
	function refresh_admin_jobs_list() {
		$('.admin_jobs').hide();
		$('.admin_jobs_loading').show();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_job/get_admin_jobs_list")); ?>',
			dataType: 'html',
			success: function(data) {
				$('.list_jobs').html(data);
				$('.admin_jobs_loading').hide();
				$('.admin_jobs').show();
			},
			fail: function(data) {
				alert("Error while updating admin jobs list: "+data);
				$('.admin_jobs_loading').hide();
				$('.admin_jobs').show();
			}
		});
	}
	
	function sumbit_addJob() {
		var name_entered = $('.field_addJob').val()
		if (name_entered.length == 0) {
			alert("Job name field is blank.");
		} else {
			$('.addJob_label').html(name_entered);
			$('.modal_addJob_name').hide();
			$('.modal_addJob_loading').show();
			$('.modal_addJob_footer').hide();
			$.ajax({
				url: '<?php echo(base_url("index.php/ajax_job/add_job")); ?>',
				type: 'post',
				dataType: 'html',
				data: {job_to_add:name_entered},
				success: function(data) {
					if (data == '1') {
						refresh_admin_jobs_list();
						$('.modal_addJob').modal('hide');
					} else if (data == '2') {
						$('.modal_addJob_name').show();
						$('.modal_addJob_footer').show();
						$('.modal_addJob_error_1').show();
						$('.modal_addJob_loading').hide();
					}
				},
				fail: function(data) {
					alert("Sorry, something went terribly wrong...");
					$('.modal_addJob_name').show();
					$('.modal_addJob_footer').show();
					$('.modal_addJob_error_1').hide();
					$('.modal_addJob_loading').hide();
				}
			});
		}
	}
	
	$('.box_status_link').live('click', function() {
		var job_id = $(this).attr('job_id');
		var status_id = $(this).attr('status_id');
		var status_name = $(this).html();
		$('#box_status_'+job_id).html(status_name + "&nbsp;<span class=\"caret\"></span>");
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_job/change_job_status")); ?>',
			type: 'post',
			data: {
				job_to_change:job_id,
				status_to_change:status_id
			}
		});
	});
	
	$('.button_admin_add_job').click(function() {
		$('.modal_addJob').modal('show');
		$('.modal_addJob_name').show();
		$('.modal_addJob_footer').show();
		$('.modal_addJob_error_1').hide();
		$('.modal_addJob_loading').hide();
		$('.field_addJob').val('');
		$('.modal_addJob').on('shown',function() {
			$('.field_addJob').focus();
		});
	});
	
	$('.button_admin_delete_job').live('click', function() {
		var ID_selected = $(this).attr('itemID');
		$('tr[itemID="'+ID_selected+'"]').hide('slow');
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_job/delete_job")); ?>',
			type: 'post',
			dataType: 'html',
			data: {jobID_to_delete:ID_selected},
			success: function(data) {
			},
			fail: function(data) {
				alert("Error while deleting job: "+data);
			}
		});
	});
	
	$('.button_close_addJob').click(function() {$('.modal_addJob').modal('hide');});
	
	$('.button_addJob_submit').click(function() {sumbit_addJob();});
	$('.field_addJob').keypress(function(e) {
		if (e.which == 13) {
			sumbit_addJob();
		}
	})
	
</script>