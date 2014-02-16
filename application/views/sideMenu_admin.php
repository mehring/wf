<style type="text/css">
	.sideMenu {
		position:fixed;
		top:0px;
		left:0px;
		width:200px;
		background-image:url(<?php echo(base_url("assets/img/ui/sidemenu/bg.png")) ?>);
		background-position:center center;
		background-repeat:repeat-y;
		z-index:99;
		margin:60px 0 0 0;
	}
	
	.button {
		position:relative;
		top:0;
		left:0;
		float:right;
		width:192px;
		height:38px;
	}
	
	.button_up {
		position:absolute;
		top:0;
		left:0;
		z-index:1;
		width:192px;
		height:38px;
		background-image:url(<?php echo(base_url("assets/img/ui/sidemenu/button_up.png")) ?>);
	}
	
	.button_over {
		position:absolute;
		top:0;
		left:0;
		z-index:2;
		width:192px;
		height:38px;
		background-image:url(<?php echo(base_url("assets/img/ui/sidemenu/button_over.png")) ?>);
		display:none;
	}
	
	.button_active {
		position:absolute;
		top:0;
		left:0;
		z-index:3;
		width:192px;
		height:38px;
		background-image:url(<?php echo(base_url("assets/img/ui/sidemenu/button_active.png")) ?>);
		background-repeat:no-repeat;
		display:none;
	}
	
	.button_text {
		position:absolute;
		top:8px;
		left:0;
		z-index:4;
		color:#FFF;
		font-family:Arial, Helvetica, sans-serif;
	}
	
	.button_text_active {
		position:absolute;
		top:8px;
		left:0;
		z-index:5;
		color:#000;
		font-family:Arial, Helvetica, sans-serif;
		font-weight:bold;
		display:none;
	}
	
	.button_badge {
		position:absolute;
		top:6px;
		left:8px;
		z-index:6;
		color:#FFF;
	}
	
	.button_icon {
		position:absolute;
		top:6px;
		width:20px;
		height:20px;
		left:162px;
		z-index:6;
	}
	
	.button_actions {
		position:absolute;
		top:0;
		left:0;
		z-index:7;
		width:192px;
		height:38px;
		background-image:url(<?php echo(base_url("assets/img/spacer.png")) ?>);
	}
	
	
</style>

<div class="sideMenu">
	
    <div class="button button_general" style="margin-top:15px;">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">General</div>
        <div class="button_text_active">General</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/dashboard.png")) ?>" /></div>
        <div class="button_actions" for="button_general"></div>
    </div>
    
    <div class="button button_users">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Users</div>
        <div class="button_text_active">Users</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/user.png")) ?>" /></div>
        <div class="button_actions" for="button_users"></div>
    </div>
    
    <div class="button button_groups">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Groups</div>
        <div class="button_text_active">Groups</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/group.png")) ?>" /></div>
        <div class="button_actions" for="button_groups"></div>
    </div>
    
    <div class="button button_tasks">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Tasks</div>
        <div class="button_text_active">Tasks</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/tasks.png")) ?>" /></div>
        <div class="button_actions" for="button_tasks"></div>
    </div>
    
    <div class="button button_jobs">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Job List</div>
        <div class="button_text_active">Job List</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/job.png")) ?>" /></div>
        <div class="button_actions" for="button_jobs"></div>
    </div>
    
    <div class="button button_projects">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Project List</div>
        <div class="button_text_active">Project List</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/project.png")) ?>" /></div>
        <div class="button_actions" for="button_projects"></div>
    </div>
    
    <div class="button button_boxes">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Box Lists</div>
        <div class="button_text_active">Box Lists</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/box.png")) ?>" /></div>
        <div class="button_actions" for="button_boxes"></div>
    </div>
    
    <div class="button button_logs">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Logs</div>
        <div class="button_text_active">Logs</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/loghistory.png")) ?>" /></div>
        <div class="button_actions" for="button_logs"></div>
    </div>
    
    <div class="button button_reports">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Reports</div>
        <div class="button_text_active">Reports</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/report.png")) ?>" /></div>
        <div class="button_actions" for="button_reports"></div>
    </div>
    
    <div class="button button_help">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Create Help</div>
        <div class="button_text_active">Create Help</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/help.png")) ?>" /></div>
        <div class="button_actions" for="button_help"></div>
    </div>
    
</div>



<script type="text/javascript">
	var cur_pane = "";
	
	function resize_sideMenu() {$(".sideMenu").height($(window).height());}
	
	function switchActivePane(toPane) {
		cur_pane = toPane;
		$(".button_active").not("."+toPane+" .button_active").fadeOut("fast");
		$(".button_text_active").not("."+toPane+" .button_text_active").fadeOut("fast");
		$(".button_text").not("."+toPane+" .button_text").fadeIn("fast");

		$("."+toPane+" .button_active").show().stop(true,true).css("background-position","192px 0px");
		$("."+toPane+" .button_active").animate({'background-position-x':'0px'},{duration:200});
		$("."+toPane+" .button_text").fadeOut("fast");
		$("."+toPane+" .button_text_active").fadeIn("fast");
		
		$(".contentPane").not("."+toPane+"_pane .contentPane").hide();
		$("."+toPane+"_pane").show();
		
		switch(toPane) {
			case "button_users":
				refresh_admin_users_list();
				break;
			case "button_groups":
				refresh_admin_groups_list();
				break;
			case "button_tasks":
				refresh_admin_tasks_list();
				break;
			case "button_jobs":
				refresh_admin_jobs_list();
				break;
			case "button_projects":
				refresh_admin_projects_list();
				break;
			case "button_boxes":
				refresh_admin_boxes_projectselector_list()
				break;
		}
		
	}
	
	function sideMenu_sync_left() {
		$(".button_text, .button_text_active").each(function() {
			var left_to_set = 152 - $(this).width();
			$(this).css("left",left_to_set+"px");
		})
	}
	
	$(document).ready(function() {
		
		resize_sideMenu();
		
		sideMenu_sync_left();
		
		switchActivePane("<?php echo $cur_pane; ?>");
		
	});
	
	$(window).resize(function() {resize_sideMenu();});
	$(window).scroll(function() {resize_sideMenu();});
	
	$(".button_actions").hover(function() {
		$(this).css("cursor","pointer");
		var button_affected = $(this).attr("for");
		$("."+button_affected+" .button_over").stop(true,true).fadeIn("fast");
		$("."+button_affected+" .button_text, ."+button_affected+" .button_text_active").stop(true,true).animate({left:"-=10"}, "fast", function() {});
	},function() {
		var button_affected = $(this).attr("for");
		$("."+button_affected+" .button_over").stop(true,true).fadeOut("fast");
		$("."+button_affected+" .button_text, ."+button_affected+" .button_text_active").stop(true,true).animate({left:"+=10"}, "fast", function() {sideMenu_sync_left();});
	});
	
	$(".button_actions").click(function() {
		var button_affected = $(this).attr("for");
		window.location = "<?php echo(base_url("index.php/ww/admindash?pane=")) ?>"+button_affected;
		//switchActivePane(button_affected);
	});

</script>