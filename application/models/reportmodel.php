<?php

class Reportmodel extends CI_Model {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function project_report($project_id) {
        $return = array();

        $this->db->select('project_name,project_received');
        $result = $this->db->get_where('projects',array('id'=>$project_id))->row();
        $return['project'] = $result;

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
	
}

?>