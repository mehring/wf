<?php

function getCleanTime($seconds) {
    $hours = 0;
    $minutes = 0;

    while($seconds >= 3600) {
        $hours++;
        $seconds -= 3600;
    }

    while($seconds >= 60) {
        $minutes++;
        $seconds -= 60;
    }

    return $hours . "h " . $minutes . "m";
}

$seconds_total = 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WebFlow Project Report</title>
    <link rel="stylesheet" href="<?php echo(base_url("assets/css/bootstrap.min.css")); ?>">

    <style type="text/css">

        body {
            font-family: helvetica, arial, geneva, sans-serif;
        }

        #report_div {
            width:100%;
            height:400px;
        }

        .graytext {
            color: #8B8A8A;
            font-size:14px;
        }

        .greentext {
            color: #49A942 !important;
        }

    </style>

</head>
<body>

    <h2 align="center">Webflow Project Report</h2>
    <strong>Project: </strong><?php echo $project->project_name; ?>
    <hr/>
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="25%" align="left" valign="top">
                <h4>Project Totals</h4>
                <div class="graytext">
                    <strong>Total Hours: </strong><span id="hours_total"></span><br/>
                    <span class="greentext">
                        <strong>Total Bill: </strong>$<?php echo $cost_total; ?><br/>
                        <strong>Bill / Hour: </strong>$<?php echo $cost_per_hour; ?>
                    </span>
                </div>
            </td>
            <td width="25%" align="left" valign="top">
                <h4>Small Format</h4>
                <div class="graytext">
                    <strong>Avg. Small Format: </strong><?php echo $avg_sf; ?><br/>
                    <strong>Total Small Format: </strong><?php echo $total_sf; ?><br/>
                    <strong>Small Format Price: </strong>$<?php echo $project->ppsf; ?><br/>
                    <span class="greentext">
                        <strong>Small Format Bill: </strong>$<?php echo $cost_sf; ?>
                    </span>
                </div>
            </td>
            <td width="25%" align="left" valign="top">
                <h4>Large Format</h4>
                <div class="graytext">
                    <strong>Avg. Large Format: </strong><?php echo $avg_lf; ?><br/>
                    <strong>Total Large Format: </strong><?php echo $total_lf; ?><br/>
                    <strong>Large Format Price: </strong>$<?php echo $project->pplf; ?><br/>
                    <span class="greentext">
                        <strong>Large Format Bill: </strong>$<?php echo $cost_lf; ?>
                    </span>
                </div>
            </td>
            <td width="25%" align="left" valign="top">
                <h4>Boxes</h4>
                <div class="graytext">
                    <strong>Total Boxes: </strong><?php echo $num_boxes; ?><br/>
                    <strong>Box Price: </strong>$<?php echo $project->ppb; ?><br/>
                    <span class="greentext">
                        <strong>Boxes Bill: </strong>$<?php echo $cost_boxes; ?>
                    </span>
                </div>
            </td>
        </tr>
    </table>

    <?php
        echo $this->gcharts->PieChart('ProjectByJob')->outputInto('report_div');
        echo $this->gcharts->div();

        if($this->gcharts->hasErrors())
        {
            echo $this->gcharts->getErrors();
        }


    ?>


    <?php $job_name_list = array_keys($report_jobs);
        foreach ($job_name_list as $job_name) { ?>

        <h3 align="center"><?php echo $job_name; ?></h3>
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Box Name</th>
                    <?php
                    $user_name_list = array(); //need to gather unique users for this job / project

                    foreach($report_jobs[$job_name]->boxes as $box) {
                        $keys_to_add = array_keys($box->users);
                        foreach ($keys_to_add as $key) {
                            array_push($user_name_list,$key);
                        }
                    }

                    //array is dirty, clean that dirty array
                    $user_name_list = array_unique($user_name_list);

                    //we have uniuqe users, build out columns
                    foreach($user_name_list as $user) {
                        echo '<th>'.$user.'</th>';
                    }?>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $boxes = array_keys($report_jobs[$job_name]->boxes);

                //create container for job total
                $job_total = 0;

                //create containers for user totals
                $user_total = array();
                foreach($user_name_list as $user) {
                    $user_total[$user] = 0; //seconds
                }

                foreach($boxes as $box) {
                    //add box's total seconds to job total
                    $job_total += $report_jobs[$job_name]->boxes[$box]->num_seconds;
                    ?>
                <tr>
                    <td><?php echo $box;?></td>
                    <?php foreach($user_name_list as $user) {
                        if (array_key_exists($user,$report_jobs[$job_name]->boxes[$box]->users)) {

                            //add num_seconds to this user's total
                            $user_total[$user] += $report_jobs[$job_name]->boxes[$box]->users[$user]; ?>

                            <td><?php echo getCleanTime($report_jobs[$job_name]->boxes[$box]->users[$user]); ?></td>

                        <?php } else { //a user has no time for this job / project / box ?>

                            <td>-</td>

                        <?php }
                    } ?>
                    <td width="150"><?php echo getCleanTime($report_jobs[$job_name]->boxes[$box]->num_seconds); ?></td>
                </tr>
                <?php } ?>

                <tr>
                    <td style="border-top:thin solid #666;">Totals</td>
                    <?php foreach($user_name_list as $user) { ?>

                        <td style="border-top:thin solid #666;">
                            <?php echo getCleanTime($user_total[$user]); ?>
                        </td>

                    <?php } ?>
                    <td style="border-top:thin solid #666;">
                        <?php echo getCleanTime($job_total); $seconds_total += $job_total; ?><br/>
                        <span style="color:gray;font-size:12px;">avg. <?php echo(getCleanTime(round($job_total / count($boxes)))); ?></span>
                    </td>
                </tr>

            </tbody>
        </table>

    <?php } ?>

<script type="text/javascript" src="<?php echo(base_url("assets/js/jquery-1.8.3.min.js")); ?>"></script>
<script type="text/javascript" src="<?php echo(base_url("assets/js/bootstrap.min.js")); ?>"></script>
<script type="text/javascript">

    $(document).ready(function() {
       $('#hours_total').html('<?php echo(getCleantime($seconds_total)); ?>');
    });

</script>

</body>
</html>











