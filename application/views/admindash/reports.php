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

</style>

<div class="admin_reports_typeSelector mattswell" style="text-align:left;">

    <span class="custom_select_label">Select a report type</span><br />
    <select class="custom_select report_typeSelector" style="width:100%;">
        <option class="report_typeSelector" value="-1">Select One...</option>
        <option class="report_typeSelector" value="0">Payroll Report</option>
        <option class="report_typeSelector" value="2">User Hours By Pay Week</option>
        <option class="report_typeSelector" value="1">Project Overview Report</option>
    </select>

</div>

<div class="admin_report_loading" style="text-align:center;display:none;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>

<div class="admin_report_body" style="text-align:left;display:none; margin-top:10px;">

    <div class="report_pane payroll">
        <div class="mattswell_title" style="padding-top:10px;">Payroll Report</div>

        <div class="btn-group">
            <button class="btn button_admin_report_payroll_generate"><i class="icon-file"></i> Generate PDF</button>
            <button class="btn button_admin_report_payroll_view"><i class="icon-eye-open"></i> View Report</button>
        </div>

        <div style="clear:both; margin-bottom:15px;"></div>

        <span class="custom_select_label">Select a pay period</span><br />
        <select class="custom_select report_payroll_period" style="width:100%;">
            <?php foreach ($pay_periods as $pay_period) { ?>
                <option
                    starts="<?php echo $pay_period->starts; ?>"
                    ends="<?php echo $pay_period->ends; ?>">
                    <?php echo date('m/d/y',$pay_period->starts) . ' - ' . date('m/d/y',$pay_period->ends); ?>
                </option>
            <?php } ?>
        </select>

        <span class="custom_select_label">Select included users:</span><br />

        <table class="table hover_table solid_table table-condensed" style="margin-top:15px;">
            <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td width="20">
                        <input class="payroll_user" user_id="<?php echo $user->id; ?>" type="checkbox" <?php if($user->payroll > 0) { echo 'checked="checked"'; } ?> style="margin:0 0 0 4px;" />
                    </td>
                    <td>
                        <?php echo $user->user_name; ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>

    <div class="report_pane user_hours_by_pay_week">
        <div class="mattswell_title" style="padding-top:10px;">User Hours by Pay Week Report</div>

        <div class="btn-group">
            <button class="btn button_admin_report_userhoursbyweek_generate"><i class="icon-file"></i> Generate PDF</button>
            <button class="btn button_admin_report_userhoursbyweek_view"><i class="icon-eye-open"></i> View Report</button>
        </div>

        <div style="clear:both; margin-bottom:15px;"></div>

        <span class="custom_select_label">Select a pay week</span><br />
        <select class="custom_select report_userhoursbyweek_period" style="width:100%;">
            <?php foreach ($pay_periods as $pay_period) {
                $week1ends = $pay_period->starts + 604799;
                $week2begins = $week1ends + 1;
                ?>
                <option
                    starts="<?php echo $week2begins; ?>"
                    ends="<?php echo $pay_period->ends; ?>">
                    <?php echo date('m/d/y',$week2begins) . ' - ' . date('m/d/y',$pay_period->ends); ?>
                </option>
                <option
                    starts="<?php echo $pay_period->starts; ?>"
                    ends="<?php echo $week1ends; ?>">
                    <?php echo date('m/d/y',$pay_period->starts) . ' - ' . date('m/d/y',$week1ends); ?>
                </option>
            <?php } ?>
        </select>

        <span class="custom_select_label">Select included users:</span><br />

        <table class="table hover_table solid_table table-condensed" style="margin-top:15px;">
            <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td width="20">
                        <input class="userhoursbyweek_user" user_id="<?php echo $user->id; ?>" type="checkbox" <?php if($user->payroll > 0) { echo 'checked="checked"'; } ?> style="margin:0 0 0 4px;" />
                    </td>
                    <td>
                        <?php echo $user->user_name; ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
    
    <div class="report_pane project_overview">
    	<div class="mattswell_title" style="padding-top:10px;">Project Overview Report</div>

        <div class="btn-group">
            <button class="btn button_admin_report_project_view"><i class="icon-print"></i> Printer Friendly</button>
        </div>

        <div style="clear:both; margin-bottom:15px;"></div>

        <span class="custom_select_label">Select a project</span><br />
        <select class="custom_select report_project_project" style="width:100%;">
            <?php foreach ($project_list as $project) { ?>
                <option value="<?php echo $project->id; ?>">
                    <?php echo $project->project_name; ?>
                </option>
            <?php } ?>
        </select>

        <div class="project_report"></div>

    </div>

</div>

<script type="text/javascript">
	
	$(document).ready(function() {

        //Do nothing, lawls
		
	});

    $('.button_admin_report_project_view').click(function() {

        var project_id = $('.report_project_project').val();
        window.open("<?php echo(base_url("index.php/report/project")); ?>?project_id="+project_id);

    });

	$('.report_typeSelector').change(function() {
		var report_type = $(this).val();
		$('.report_pane').hide();
		
		switch(report_type) {
			
			case "0": //Payroll Report
				$('.report_pane.payroll').show();
				$('.admin_report_loading').hide();
				$('.admin_report_body').show();
				break;

            case "1": //Project Overview
                $('.report_pane.project_overview').show();
                $('.admin_report_loading').hide();
                $('.admin_report_body').show();
                break;

            case "2": //User Hours By Pay Week
                $('.report_pane.user_hours_by_pay_week').show();
                $('.admin_report_loading').hide();
                $('.admin_report_body').show();
                break;
				
			default:
				$('.admin_report_loading').hide();
				$('.admin_report_body').hide();
		}
		
	});
	
	$('.button_admin_report_payroll_view').click(function() {
		$('.admin_report_loading').show();
		$('.admin_report_body').hide();
		$('.admin_reports_typeSelector').hide();
		
		var pay_period_starts = 0;
		var pay_period_ends = 0;
		
		$('.report_payroll_period').children('option').each(function() {
			if ($(this).is(':selected')) {
				pay_period_starts = $(this).attr('starts');
				pay_period_ends = $(this).attr('ends');
			}
		});
		
		$.ajax({
			url:'<?php echo(base_url("index.php/ajax_reports/get_payroll_html")); ?>',
			dataType:'json',
			data:{
				'pps':pay_period_starts,
				'ppe':pay_period_ends
			},
			success: function(data) {
				showviewReportModal('Payroll',data.html)
				$('.admin_report_loading').hide();
				$('.admin_report_body').show();
				$('.admin_reports_typeSelector').show();
			}
		});
		
	});
	
	$('.button_admin_report_payroll_generate').click(function() {
		
		var pay_period_starts = 0;
		var pay_period_ends = 0;
		
		$('.report_payroll_period').children('option').each(function() {
			if ($(this).is(':selected')) {
				pay_period_starts = $(this).attr('starts');
				pay_period_ends = $(this).attr('ends');
			}
		});
		
		window.location = '<?php echo(base_url("index.php/report/payroll")); ?>?pps='+pay_period_starts+'&ppe='+pay_period_ends;

	});

    $('.button_admin_report_userhoursbyweek_view').click(function() {
        $('.admin_report_loading').show();
        $('.admin_report_body').hide();
        $('.admin_reports_typeSelector').hide();

        var pay_period_starts = 0;
        var pay_period_ends = 0;

        $('.report_userhoursbyweek_period').children('option').each(function() {
            if ($(this).is(':selected')) {
                pay_period_starts = $(this).attr('starts');
                pay_period_ends = $(this).attr('ends');
            }
        });

        $.ajax({
            url:'<?php echo(base_url("index.php/ajax_reports/get_userhoursbyweek_html")); ?>',
            dataType:'json',
            data:{
                'pps':pay_period_starts,
                'ppe':pay_period_ends
            },
            success: function(data) {
                showviewReportModal('Payroll',data.html)
                $('.admin_report_loading').hide();
                $('.admin_report_body').show();
                $('.admin_reports_typeSelector').show();
            }
        });

    });

    $('.button_admin_report_userhoursbyweek_generate').click(function() {

        var pay_period_starts = 0;
        var pay_period_ends = 0;

        $('.report_userhoursbyweek_period').children('option').each(function() {
            if ($(this).is(':selected')) {
                pay_period_starts = $(this).attr('starts');
                pay_period_ends = $(this).attr('ends');
            }
        });

        window.location = '<?php echo(base_url("index.php/report/userhoursbyweek")); ?>?pps='+pay_period_starts+'&ppe='+pay_period_ends;

    });

    $('.payroll_user').click(function() {
        var user_id = $(this).attr('user_id');
        var checked = $(this).is(':checked');
        $.ajax({
            url:'<?php echo(base_url("index.php/ajax_reports/set_user_payroll")); ?>',
            dataType:'json',
            data:{
                user_id:user_id,
                checked:checked
            },
            success: function(data) {
                //console.log(data);
            }
        });
    });

    $('.userhoursbyweek_user').click(function() {
        var user_id = $(this).attr('user_id');
        var checked = $(this).is(':checked');
        $.ajax({
            url:'<?php echo(base_url("index.php/ajax_reports/set_user_payroll")); ?>',
            dataType:'json',
            data:{
                user_id:user_id,
                checked:checked
            },
            success: function(data) {
                //console.log(data);
            }
        });
    });
	
</script>



























