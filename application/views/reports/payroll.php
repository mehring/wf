<style type="text/css">
	.hover_white:hover { background-color:#FFF; }
</style>

<h2 align="center">Webflow Payroll Report</h2>
<strong>Pay Period: </strong><?php echo date('M j, Y',$pps).' - '.date('M j, Y',$ppe); ?>

<table width="100%" style="margin-top:20px;" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th align="left" valign="top">Name</th>
            <th align="center" valign="top">Hours</th>
            <th align="center" valign="top">Overtime</th>
        </tr>
    </thead>
    <tbody>
		
	<?php
        $total_hours = 0;
        $total_hours_ot = 0;

        foreach ($users as $user) {
            $total_hours += $user->time_payperiod;
            $total_hours_ot += $user->time_payperiod_ot;
        ?>

            <tr class="hover_white">
                <td style="border-bottom:thin solid #DDD;" align="left" valign="top"><?php echo $user->lname.', '.$user->fname; ?></td>
                <td style="border-bottom:thin solid #DDD;" width="100" align="center" valign="top"><?php echo $user->time_payperiod; ?></td>
                <td style="border-bottom:thin solid #DDD;" width="100" align="center" valign="top"><?php echo $user->time_payperiod_ot; ?></td>
            </tr>

	<?php } ?>

        <tr class="hover_white">
            <td style="border-bottom:thin solid #DDD;" align="left" valign="top"><strong>Total</strong></td>
            <td style="border-bottom:thin solid #DDD;" width="100" align="center" valign="top"><strong><?php echo $total_hours; ?></strong></td>
            <td style="border-bottom:thin solid #DDD;" width="100" align="center" valign="top"><strong><?php echo $total_hours_ot; ?></strong></td>
        </tr>
		
	</tbody>
</table>

