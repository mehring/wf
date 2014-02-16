<style type="text/css">
	
	tbody tr {
		background-color:#F0F0F0;
	}
	
	tbody tr:HOVER {
		background-color:#FFFFFF;
		cursor:pointer;
	}
	
	tbody tr td {
		border-top:none !important;
	}
	
</style>

<div class="bodyBox" id="main">

    <div style="padding:10px;">

        <table class="table table-condensed usersTable">
        	<thead><tr>
            	<th></th>
                <th>Name</th>
                <th>Job</th>
                <th>Project</th>
                <th>Box</th>
                <th>Start</th>
            </tr></thead>
            
            <tbody>

                <?php foreach($users as $row) { ?>

                    <tr user_id="<?php echo($row->id); ?>">
                    	<?php if($row->user_start) { ?>
                        	<td><img src="<?php echo(base_url("assets/img/ui/icons/glassButton_blue.png")); ?>" style="width:20px;height:20px;" /></td>
                            <td><?php echo($row->user_name); ?></td>
                            <td><?php echo($row->job_name); ?></td>
                            <td><?php echo($row->project_name); ?></td>
                            <td><?php echo($row->box_name); ?></td>
                            <td><?php echo(date("M j, Y g:i A",strtotime($row->user_start))); ?></td>
                        <?php } else { ?>
                        	<td><img src="<?php echo(base_url("assets/img/ui/icons/glassButton_gray.png")); ?>" style="width:20px;height:20px;" /></td>
                            <td><?php echo($row->user_name) ?></td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        	<td>Clocked Out</td>
                        <?php }?>
                        
                        
                    </tr>
                
                <?php } ?>
                
            </tbody>
        </table>
        
    </div>
</div>

<div class="bodyBox" id="loading" style="display:none;">
	<div id="load_div" style="padding:10px;text-align:center;">
    	
        <img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
        
    </div>
</div>


<script type="text/javascript">

	$(".usersTable tbody tr").live("click", function() {
		var user_clicked = $(this).attr('user_id');
		
		$("#main").fadeOut("fast",function() {
			$("#loading").fadeIn("fast");
		});
		
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_user/log_in")); ?>',
			type: 'post',
			dataType: 'html',
			data: {id_to_login:user_clicked},
			success: function(data) {
				window.location = "<?php echo(base_url("index.php/ww/userdash")); ?>";
			},
			fail: function(data) {
				alert("Sorry, something went terribly wrong...");
				$("#loading").hide();
				$("#main").show();
			}
		});
		
	});
	
</script>

