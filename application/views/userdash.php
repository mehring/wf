<?php
	$this->data = array();
	$this->data['status_info'] = $status_info;
?>

<style type="text/css">
	.contentPane {
		padding:10px;
		display:none;
	}

</style>

<script type="text/javascript">
	var job_list = <?php echo($job_list); ?>;
	var project_list = <?php echo($project_list); ?>;
	var user_list = <?php echo($user_list); ?>;
	var group_list = <?php echo($group_list); ?>;
	var group_members = <?php echo($group_members); ?>;
	
	function get_priority_label(priority) {
		switch(priority) {
			case "3": return "<span class=\"label label-important\">Critical</span>";
			case "2": return "<span class=\"label label-warning\">High</span>";
			case "1": return "<span class=\"label label-success\">Low</span>";
			default: return "<span class=\"label\">None</span>";
		}
	}
	
	function get_job_name(job_id) {
		if (job_list.length) {
			for(var i=0;i<job_list.length;i++) {
				if (job_list[i].id == job_id) {
					return job_list[i].job_name;
				}
			}
		}
	}
	
	function get_project_name(project_id) {
		if (project_list.length) {
			for(var i=0;i<project_list.length;i++) {
				if (project_list[i].id == project_id) {
					return project_list[i].project_name;
				}
			}
		}
	}
	
</script>

<?php $this->load->view("userdash/modal_clockIn", $this->data); ?>
<?php $this->load->view("userdash/modal_viewHelp", $this->data); ?>

<div class="bodyBox_sideMenu">
	<div class="contentPane button_dashboard_pane"><?php $this->load->view("userdash/dashboard", $this->data); ?></div>
    <!--<div class="contentPane button_schedule_pane"><?php $this->load->view("userdash/schedule", $this->data); ?></div>-->
    <div class="contentPane button_loghistory_pane"><?php $this->load->view("userdash/loghistory", $this->data); ?></div>
    <div class="contentPane button_help_pane"><?php $this->load->view("userdash/help", $this->data); ?></div>
    <div class="contentPane button_sendmessage_pane"><?php $this->load->view("userdash/sendmessage", $this->data); ?></div>
</div>