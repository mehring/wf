<?php
	$this->data = array();
?>

<style type="text/css">
	.contentPane {
		padding:10px;
		display:none;
	}
</style>

<script type="text/javascript">
	var job_list = <?php echo($job_list); ?>;
</script>

<?php $this->load->view("admindash/modal_modifyTask", $this->data); ?>
<?php $this->load->view("admindash/modal_addHelp", $this->data); ?>
<?php $this->load->view("admindash/modal_addBox", $this->data); ?>
<?php $this->load->view("admindash/modal_viewReport", $this->data); ?>

<div class="bodyBox_sideMenu">

	<?php switch($cur_pane) { 
			case "button_general":?>
            	<div class="contentPane button_general_pane"><?php $this->load->view("admindash/general", $this->data); ?></div>
	<?php	break; case "button_users": ?>
				<div class="contentPane button_users_pane"><?php $this->load->view("admindash/users", $this->data); ?></div>
	<?php	break; case "button_groups": ?>
				<div class="contentPane button_groups_pane"><?php $this->load->view("admindash/groups", $this->data); ?></div>
	<?php	break; case "button_tasks": ?>
				<div class="contentPane button_tasks_pane"><?php $this->load->view("admindash/tasks", $this->data); ?></div>
	<?php	break; case "button_jobs": ?>
				<div class="contentPane button_jobs_pane"><?php $this->load->view("admindash/jobs", $this->data); ?></div>
	<?php	break; case "button_projects": ?>
				<div class="contentPane button_projects_pane"><?php $this->load->view("admindash/projects", $this->data); ?></div>
                <div class="contentPane button_boxes_pane"><?php $this->load->view("admindash/boxes", $this->data); ?></div>
	<?php	break; case "button_boxes": ?>
    			<div class="contentPane button_projects_pane"><?php $this->load->view("admindash/projects", $this->data); ?></div>
				<div class="contentPane button_boxes_pane"><?php $this->load->view("admindash/boxes", $this->data); ?></div>
	<?php	break; case "button_logs": ?>
				<div class="contentPane button_logs_pane"><?php $this->load->view("admindash/logs", $this->data); ?></div>
	<?php	break; case "button_reports": ?>
				<div class="contentPane button_reports_pane"><?php $this->load->view("admindash/reports", $this->data); ?></div>
	<?php	break; case "button_help": ?>
    			<div class="contentPane button_help_pane"><?php $this->load->view("admindash/help", $this->data); ?></div>       
	<?php } ?>

</div>