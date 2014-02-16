<div class="mattswell">
	<div class="mattswell_title">Change Admin Password</div>
    
    <div class="alert alert-error alert_bad_curPass" style="display:none;"><strong>Error!</strong> Incorrect current password.</div>
    <div class="alert alert-error alert_bad_newPass" style="display:none;"><strong>Error!</strong> New password doesnt match confirm new password.</div>
    
    <div class="changePass_form" style="text-align:center;">
        <form class="form-horizontal" style="display:inline-block; margin:0 0 10px 0;">
            
          <div class="control-group cg_curPass">
            <label class="control-label" for="changePass_old">Current Password</label>
            <div class="controls">
              <input type="password" id="changePass_old" placeholder="Enter Current Password" class="input-xlarge">
            </div>
          </div>
          
          <div class="control-group cg_newPass">
            <label class="control-label" for="changePass_new">New Password</label>
            <div class="controls">
              <input type="password" id="changePass_new" placeholder="Enter New Password" class="input-xlarge">
            </div>
          </div>
          
          <div class="control-group cg_cNewPass">
            <label class="control-label" for="changePass_cnew">Confirm New Password</label>
            <div class="controls">
              <input type="password" id="changePass_cnew" placeholder="Confirm New Password" class="input-xlarge">
            </div>
          </div>
        </form>
        <div>
        	<button type="button" class="btn btn-primary changePass_button_change"><i class="icon-refresh icon-white"></i>&nbsp;Change Admin Password</button>
        </div>
    </div>
    
    <div class="changePass_ajax" style="display:none;">
    	<div class="changePass_loading" style="text-align:center;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>
        <div class="changePass_success"><div class="alert alert-success"><strong>Success!</strong> Password has been changed.</div></div>
    </div>
</div>

<script type="text/javascript">
	
	$(".changePass_button_change").click(function() {
		var cur_pass = $('#changePass_old').val();
		var new_pass = $('#changePass_new').val();
		var cnew_pass = $('#changePass_cnew').val();
		
		$('.cg_curPass').removeClass('error');
		$('.cg_newPass').removeClass('error');
		$('.cg_cNewPass').removeClass('error');
		
		$('.alert_bad_curPass').hide();
		$('.alert_bad_newPass').hide();
		
		if(new_pass != cnew_pass) {
			$('.cg_newPass').addClass('error');
			$('.cg_cNewPass').addClass('error');
			$('.alert_bad_newPass').slideDown('fast');
		} else {
			$('.changePass_form').hide();
			$('.changePass_ajax').show();
			$('.changePass_success').hide();
			$('.changePass_loading').show();
			
			$.ajax({
				url: '<?php echo(base_url("index.php/ajax/changeAdminPass")); ?>',
				type: 'post',
				dataType: 'html',
				data: {pass_cur:cur_pass,pass_new:new_pass},
				success: function(data) {
					if(data == "1") {
						$('.changePass_success').show();
						$('.changePass_loading').hide();
					} else {
						$('.cg_curPass').addClass('error');
						$('.alert_bad_curPass').show();
						$('.changePass_form').show();
						$('.changePass_ajax').hide();
						$('#changePass_old').val("").focus();
					}
				},
				fail: function(data) {
					alert("Sorry, something went terribly wrong...");
					$('.changePass_form').show();
					$('.changePass_ajax').hide();
				}
			});	
			
		}
	});
	
</script>