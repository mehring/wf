<?php

class Reportmodel extends CI_Model {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function project_report($project_id) {
        $return = array();

        //get project info
        $this->db->select('project_name,project_received,pplf,ppsf,ppb');
        $result = $this->db->get_where('projects',array('id'=>$project_id))->row();
        $return['project'] = $result;

        //get boxes info
        $this->db->select('box_status_id,box_name,sf,lf');
        $result = $this->db->get_where('boxes',array('project_id'=>$project_id))->result();
        $return['boxes'] = $result;

        //get project logs
        $this->db->select('
            logs.id,
            logs.user_id,
            logs.job_id,
            logs.box_id,
            logs.log_start,
            logs.log_stop,
            users.user_name,
            boxes.box_name,
            jobs.job_name
        ');
        $this->db->where('logs.project_id',$project_id);
        $this->db->join('users','logs.user_id = users.id','left');
        $this->db->join('boxes','logs.box_id = boxes.id','left');
        $this->db->join('jobs','logs.job_id = jobs.id','left');
        $this->db->order_by('boxes.box_name');
        $report_logs = $this->db->get('logs')->result();
        $return['report_logs'] = $report_logs;

        return $return;
    }

    function payroll_report($pps,$ppe) {

        $this->load->model('timemodel');

        //set initial data to send to report
        $return = array(
            'pps' => $pps,
            'ppe' => $ppe
        );

        //gather users list
        $this->db->select('id,user_name');
        $this->db->where(array(
            'user_hidden' => 0,
            'payroll' => 1
        ));
        $users = $this->db->get('users')->result();


        // foreach user, calculate hours worked this pay period
        foreach ($users as $user) {

            //GET LOG DATA
            $payperiod_start = date("Y-m-d H:i:s",$pps);
            $payperiod_end = date("Y-m-d H:i:s",$ppe);
            $where = array('log_start >=' => $payperiod_start, 'log_start <' => $payperiod_end);
            $this->db->select('log_start,log_stop');
            $this->db->where($where);
            $this->db->order_by('log_start','desc');
            $query = $this->db->get_where('logs',array('user_id'=>$user->id));

            $logs = array();

            foreach ($query->result() as $row) {
                $start_timestamp = strtotime($row->log_start);
                $stop_timestamp = strtotime($row->log_stop);
                $diff_seconds = $stop_timestamp - $start_timestamp;

                array_push($logs,array(
                    'log_start'=>$row->log_start,
                    'log_stop'=>$row->log_stop,
                    'start_timestamp'=>$start_timestamp,
                    'stop_timestamp'=>$stop_timestamp,
                    'diff_seconds'=>$diff_seconds
                ));
            }

            //CALCULATE USER'S HOURS
            $seconds_payperiod_w1r = 0;
            $seconds_payperiod_w1ot = 0;
            $seconds_payperiod_w2r = 0;
            $seconds_payperiod_w2ot = 0;

            //CALCULATE PAY PERIOD TIME
            $w1_start = $pps;
            $w1_end = $w1_start + 604799;
            $w2_start = $w1_start + 604800;
            $w2_end = $w2_start + 604799;
            foreach ($logs as $log) {
                if ($log['start_timestamp'] >= $w1_start && $log['start_timestamp'] <= $w1_end) {$seconds_payperiod_w1r += $log['diff_seconds'];}
                if ($log['start_timestamp'] >= $w2_start && $log['start_timestamp'] <= $w2_end) {$seconds_payperiod_w2r += $log['diff_seconds'];}
            }
            if ($seconds_payperiod_w1r > 144000) {
                $seconds_payperiod_w1ot = $seconds_payperiod_w1r - 144000;
                $seconds_payperiod_w1r = 144000;
            }
            if ($seconds_payperiod_w2r > 144000) {
                $seconds_payperiod_w2ot = $seconds_payperiod_w2r - 144000;
                $seconds_payperiod_w2r = 144000;
            }

            //$user->time_payperiod = $this->timemodel->getCleanTime($seconds_payperiod_w1r + $seconds_payperiod_w2r);
            //$user->time_payperiod_ot = $this->timemodel->getCleanTime($seconds_payperiod_w1ot + $seconds_payperiod_w2ot);
            $user->time_payperiod = $this->timemodel->getPayrollTime($seconds_payperiod_w1r + $seconds_payperiod_w2r);
            $user->time_payperiod_ot = $this->timemodel->getPayrollTime($seconds_payperiod_w1ot + $seconds_payperiod_w2ot);

        }


        //ADP wants last name first
        foreach ($users as $user) {
            $user->fname = '';
            $user->lname = '';
            $name_array = explode(' ',$user->user_name,2);
            if (array_key_exists(0,$name_array)) { $user->fname = $name_array[0]; }
            if (array_key_exists(1,$name_array)) { $user->lname = $name_array[1]; }
        }

        //sort and return the data
        $this->load->helper('data');
        $users = sortArrayofObjectByProperty($users,'lname');
        $return['users'] = $users;

        return $return;
    }

    function userhoursbyweek_report($pps,$ppe) {

        $this->load->model('timemodel');

        //set initial data to send to report
        $return = array(
            'pps' => $pps,
            'ppe' => $ppe
        );

        //gather users list
        $this->db->select('id,user_name');
        $this->db->where(array(
            'user_hidden' => 0,
            'payroll' => 1
        ));
        $users = $this->db->get('users')->result();


        // foreach user, calculate hours worked this pay period
        foreach ($users as $user) {

            //GET LOG DATA
            $payperiod_start = date("Y-m-d H:i:s",$pps);
            $payperiod_end = date("Y-m-d H:i:s",$ppe);
            $this->db->select('log_start,log_stop');
            $this->db->where(array('log_start >=' => $payperiod_start, 'log_start <' => $payperiod_end));
            $this->db->order_by('log_start','desc');
            $query = $this->db->get_where('logs',array('user_id'=>$user->id));

            $logs = array();

            foreach ($query->result() as $row) {
                $start_timestamp = strtotime($row->log_start);
                $stop_timestamp = strtotime($row->log_stop);
                $diff_seconds = $stop_timestamp - $start_timestamp;

                array_push($logs,array(
                    'log_start'=>$row->log_start,
                    'log_stop'=>$row->log_stop,
                    'start_timestamp'=>$start_timestamp,
                    'stop_timestamp'=>$stop_timestamp,
                    'diff_seconds'=>$diff_seconds
                ));
            }

            //CALCULATE USER'S HOURS
            $seconds_payperiod_w1r = 0;
            $seconds_payperiod_w1ot = 0;
            $seconds_payperiod_w2r = 0;
            $seconds_payperiod_w2ot = 0;
            $user->dayTimes = array(
                'mon' => 0,
                'tue' => 0,
                'wed' => 0,
                'thu' => 0,
                'fri' => 0,
                'sat' => 0,
                'sun' => 0
            );

            //CALCULATE PAY PERIOD TIME
            $w1_start = $pps;
            $w1_end = $w1_start + 604799;
            $w2_start = $w1_start + 604800;
            $w2_end = $w2_start + 604799;
            foreach ($logs as $log) {
                if ($log['start_timestamp'] >= $w1_start && $log['start_timestamp'] <= $w1_end) {$seconds_payperiod_w1r += $log['diff_seconds'];}
                if ($log['start_timestamp'] >= $w2_start && $log['start_timestamp'] <= $w2_end) {$seconds_payperiod_w2r += $log['diff_seconds'];}

                //add log time to monday
                if ($log['start_timestamp'] >= $w1_start && $log['start_timestamp'] < $w1_start + 86400) {
                    $user->dayTimes['mon'] += round($log['diff_seconds'] / 3600,2);
                }

                //add log time to tuesday
                if ($log['start_timestamp'] >= ($w1_start + 86400) && $log['start_timestamp'] < $w1_start + (86400*2)) {
                    $user->dayTimes['tue'] += round($log['diff_seconds'] / 3600,2);
                }

                //add log time to wednesday
                if ($log['start_timestamp'] >= ($w1_start + (86400*2)) && $log['start_timestamp'] < $w1_start + (86400*3)) {
                    $user->dayTimes['wed'] += round($log['diff_seconds'] / 3600,2);
                }

                //add log time to thursday
                if ($log['start_timestamp'] >= ($w1_start + (86400*3)) && $log['start_timestamp'] < $w1_start + (86400*4)) {
                    $user->dayTimes['thu'] += round($log['diff_seconds'] / 3600,2);
                }

                //add log time to friday
                if ($log['start_timestamp'] >= ($w1_start + (86400*4)) && $log['start_timestamp'] < $w1_start + (86400*5)) {
                    $user->dayTimes['fri'] += round($log['diff_seconds'] / 3600,2);
                }

                //add log time to saturday
                if ($log['start_timestamp'] >= ($w1_start + (86400*5)) && $log['start_timestamp'] < $w1_start + (86400*6)) {
                    $user->dayTimes['sat'] += round($log['diff_seconds'] / 3600,2);
                }

                //add log time to sunday
                if ($log['start_timestamp'] >= ($w1_start + (86400*6)) && $log['start_timestamp'] < $w1_start + (86400*7)) {
                    $user->dayTimes['sun'] += round($log['diff_seconds'] / 3600,2);
                }

            }
            if ($seconds_payperiod_w1r > 144000) {
                $seconds_payperiod_w1ot = $seconds_payperiod_w1r - 144000;
                $seconds_payperiod_w1r = 144000;
            }
            if ($seconds_payperiod_w2r > 144000) {
                $seconds_payperiod_w2ot = $seconds_payperiod_w2r - 144000;
                $seconds_payperiod_w2r = 144000;
            }

            //$user->time_payperiod = $this->timemodel->getCleanTime($seconds_payperiod_w1r + $seconds_payperiod_w2r);
            //$user->time_payperiod_ot = $this->timemodel->getCleanTime($seconds_payperiod_w1ot + $seconds_payperiod_w2ot);
            $user->time_payperiod = $this->timemodel->getPayrollTime($seconds_payperiod_w1r /*+ $seconds_payperiod_w2r*/);
            $user->time_payperiod_ot = $this->timemodel->getPayrollTime($seconds_payperiod_w1ot /*+ $seconds_payperiod_w2ot*/);

        }


        //ADP wants last name first
        foreach ($users as $user) {
            $user->fname = '';
            $user->lname = '';
            $name_array = explode(' ',$user->user_name,2);
            if (array_key_exists(0,$name_array)) { $user->fname = $name_array[0]; }
            if (array_key_exists(1,$name_array)) { $user->lname = $name_array[1]; }
        }

        //sort and return the data
        $this->load->helper('data');
        $users = sortArrayofObjectByProperty($users,'lname');
        $return['users'] = $users;

        return $return;
    }
	
}

?>