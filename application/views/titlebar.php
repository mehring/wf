<style type="text/css">
	.titleBar {
		position:fixed;
		top:0px;
		left:0px;
		height:65px;
		background-image:url(<?php echo(base_url("assets/img/ui/titlebar/bg.png")); ?>);
		background-position:center center;
		background-repeat:repeat-x;
		z-index:100;
	}
	
	.userBar {
		display:inline-block;
		float:right;
		height:33px;
		margin-top:27px;
		background-image:url(<?php echo(base_url("assets/img/ui/titlebar/bg_user.png")); ?>);
		background-position:center center;
		background-repeat:repeat-x;
		border-radius: 10px 0 0 0;
	}
	
	.userBar_inner {
		padding:6px 10px 0px 10px;
		color:#FFF;
	}
	
	.userName {
		display:inline-block;
		font-family:"ChivoBlack";
	}
	
	.modal-header h3 {
		font-family:"ChivoBlack";
	}
	
	.div_adminPass {
		float:right;
		margin: 5px 10px 0px 0px;
		text-align:left;
	}

</style>

<div class="titleBar">
    <a href="/webflow">
	<img src="<?php echo(base_url("assets/img/ui/logos/main.png")); ?>" style="margin:9px 0 0 10px;" />
    </a>
    
    <?php if ($currentUser) { ?>
        <div class="userBar">
            <div class="userBar_inner">
                <img src="<?php echo(base_url("assets/img/ui/icons/user.png")); ?>" style="margin-right:5px;" />Welcome,&nbsp;<div class="userName" style="margin-right:10px;"><?php echo($currentUser); ?></div><a class="btn btn-mini" href="<?php echo(base_url("index.php/ww/userselect")); ?>"><i class="icon-refresh"></i>&nbsp;Change User / Log Out</a>
            </div>
        </div>
	<?php } ?>

    <div class="div_adminPass">
    	<span style="color:#FFF; font-weight:bold;">Admin Mode: </span>
        
        <?php if($admin_mode == true && uri_string() == 'ww/admindash') { ?>
	        <span class="label label-success">On</span><br />
            <div class="btn-group" style="margin-top:5px;">
                <a class="btn btn-mini btn-inverse button_adminOff" style="width:125px;"><i class="icon-off icon-white"></i>&nbsp;Turn Off</a>
            </div>
		<?php } else { ?>
        	<span class="label label-important">Off</span><br />
            <div class="btn-group" style="margin-top:5px;">
                <a class="btn btn-mini btn-inverse button_adminOn" style="width:125px;"><i class="icon-off icon-white"></i>&nbsp;Turn On</a>
            </div>
        <?php } ?>

    </div>

    <?php if($admin_mode == true && uri_string() == 'ww/admindash') { ?>
        <!--<a class="btn btn-primary" style="float:right; margin:15px 20px 0 0 ;" href="docs"><i class="icon-film icon-white"></i> View Docs</a>-->
    <?php } else { ?>
    <?php } ?>

</div>

<div class="modal hide modal_adminPass">
  <div class="modal-header">
    <button type="button" class="close button_close_adminpass" aria-hidden="true">&times;</button>
    <h3>Enter Admin Password</h3>
  </div>
  <div class="modal-body">
    <div class="modal_adminPass_password" style="text-align:center;">
    	<div class="modal_adminPass_error alert alert-error" style="display:none;"><strong>Incorrect password</strong>, try again.</div>
        <input type="password" class="field_adminPass" />
    </div>
    <div class="modal_adminPass_loading" style="text-align:center; display:none;">
    	Attempting to authenticate<br />
    	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn button_close_adminpass">Close</a>
    <a href="#" class="btn btn-primary button_adminPass_submit">Submit</a>
  </div>
</div>

<script type="text/javascript">
	
	function resize_titleBar() {$(".titleBar").width($(window).width());}

	function submit_adminPass() {
		$('.modal_adminPass_password').hide();
		$('.modal_adminPass_loading').show();
		$('.modal-footer').hide();
		
		var pass_to_try = $('.field_adminPass').val();
		
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax/adminAuth")); ?>',
			type: 'post',
			dataType: 'html',
			data: {try_pass:pass_to_try},
			success: function(data) {
				if (data == '1') {
					window.location="<?php echo(base_url("index.php/ww/admindash")); ?>"
				} else {
					$('.modal_adminPass_password').show();
					$('.modal_adminPass_loading').hide();
					$('.modal-footer').show();
					$('.modal_adminPass_error').show();
					$('.field_adminPass').val("");
					$('.field_adminPass').focus();
				}
			},
			fail: function(data) {
				alert("Sorry, something went terribly wrong...");
				$('.modal_adminPass_password').show();
				$('.modal_adminPass_loading').hide();
				$('.modal-footer').show();
			}
		});
	}
	
	$('.button_close_adminpass').click(function() {
		$('.modal_adminPass_error').hide();
		$('.field_adminPass').val("");
		$('.modal_adminPass').modal('hide');
	});
	
	$(".button_adminMenu").click(function() {});
	
	$('.button_adminOn').click(function() {
		$('.modal_adminPass').modal('show');
		$('.modal_adminPass').on('shown',function() {
			$('.field_adminPass').focus();
		});
	});
	
	$('.button_adminOff').click(function() {
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax/adminOff")); ?>',
			type: 'post',
			dataType: 'html',
			success: function(data) {
				location.reload(true);
			},
			fail: function(data) {
				alert("Sorry, something went terribly wrong...");
				location.reload(true);
			}
		});
	});
	
	$('.button_adminPass_submit').click(function() {submit_adminPass();});
	$('.field_adminPass').keypress(function(e) {
		if (e.which == 13) {
			submit_adminPass();
		}
	})
	
	$(document).ready(function() {resize_titleBar();});
	$(window).resize(function() {resize_titleBar();});
	$(window).scroll(function() {resize_titleBar();});

</script>