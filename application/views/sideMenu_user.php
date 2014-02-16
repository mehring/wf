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
	
    <div class="button button_dashboard" style="margin-top:15px;">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Dashboard</div>
        <div class="button_text_active">Dashboard</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/dashboard.png")) ?>" /></div>
        <div class="button_actions" for="button_dashboard"></div>
    </div>
    <!--
    <div class="button button_tasks">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Tasks</div>
        <div class="button_text_active">Tasks</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php //echo(base_url("assets/img/ui/icons/tasks.png")) ?>" /></div>
        <div class="button_actions" for="button_tasks"></div>
    </div>
    
    <div class="button button_messages">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Messages</div>
        <div class="button_text_active" style="display:none;">Messages</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php //echo(base_url("assets/img/ui/icons/messages.png")) ?>" /></div>
        <div class="button_actions" for="button_messages"></div>
    </div>
    
    <div class="button button_schedule">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Schedule</div>
        <div class="button_text_active" style="display:none;">Schedule</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/schedule.png")) ?>" /></div>
        <div class="button_actions" for="button_schedule"></div>
    </div>
    -->
    <div class="button button_loghistory">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Log History</div>
        <div class="button_text_active" style="display:none;">Log History</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/loghistory.png")) ?>" /></div>
        <div class="button_actions" for="button_loghistory"></div>
    </div>
    
    <div class="button button_sendmessage">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Send Message</div>
        <div class="button_text_active" style="display:none;">Send Message</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/messages.png")) ?>" /></div>
        <div class="button_actions" for="button_sendmessage"></div>
    </div>
    
    <div class="button button_help">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Help</div>
        <div class="button_text_active" style="display:none;">Help</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/help.png")) ?>" /></div>
        <div class="button_actions" for="button_help"></div>
    </div>
    
    <!--
    <div class="button button_personalinfo">
    	<div class="button_up"></div>
        <div class="button_over"></div>
        <div class="button_active"></div>
        <div class="button_text">Personal Info</div>
        <div class="button_text_active" style="display:none;">Personal Info</div>
        <div class="button_badge" style="display:none;"><span class="badge badge-inverse" style="font-weight:normal;">0</span></div>
        <div class="button_icon"><img src="<?php echo(base_url("assets/img/ui/icons/user.png")) ?>" /></div>
        <div class="button_actions" for="button_personalinfo"></div>
    </div>
    -->
 
</div>

<script type="text/javascript">
	
	function resize_sideMenu() {$(".sideMenu").height($(window).height());}
	
	function switchActivePane(toPane) {
        console.log(toPane);
		$(".button_active").not("."+toPane+" .button_active").fadeOut("fast");
		$(".button_text_active").not("."+toPane+" .button_text_active").fadeOut("fast");
		$(".button_text").not("."+toPane+" .button_text").fadeIn("fast");
		
		$("."+toPane+" .button_active").show().stop(true,true).css("background-position","192px 0px");
		$("."+toPane+" .button_active").animate({'background-position-x':'0px'},{duration:200});
		$("."+toPane+" .button_text").fadeOut("fast");
		$("."+toPane+" .button_text_active").fadeIn("fast");
		
		$(".contentPane").not("."+toPane+"_pane .contentPane").hide();
		$("."+toPane+"_pane").show();
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
		
		switchActivePane("button_dashboard");
		
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
		switchActivePane(button_affected);
	});

</script>