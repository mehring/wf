<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_user extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->data = array();
		$this->data['currentUser'] = $this->session->userdata('currentUser');
		$this->data['currentUserID'] = $this->session->userdata('currentUserID');
	}
	
	public function get_messages() {
		$this->load->model("messagemodel");
		$user_messages = $this->messagemodel->get_user_messages($this->data['currentUserID']);
		echo json_encode($user_messages);
	}
	
	public function get_tasks() {
		$this->load->model("taskmodel");
		$user_tasks = $this->taskmodel->get_user_tasks($this->data['currentUserID']);
		echo json_encode($user_tasks);
	}
	
	public function log_in() {
		$id_to_login = $_POST['id_to_login'];

		$this->db->select('user_name');
		$query = $this->db->get_where('users',array('id'=>$id_to_login));
		
		foreach($query->result() as $row) {
			$this->session->set_userdata('currentUser',$row->user_name);
			$this->session->set_userdata('currentUserID',$id_to_login);	
		}	
	}
	
	public function add_user() {
		$user_to_add = $_POST['user_to_add'];
		
		$this->db->select('user_name');
		$query = $this->db->get('users');
		foreach ($query->result() as $row) {
			if (strtoupper($row->user_name) == strtoupper($user_to_add)) {
				echo("2");
				return;
			}
		}
		
		$data = array(
			'user_name'=>$user_to_add,
			'user_hidden'=>'0'
		);
		$this->db->insert('users',$data);
		
		echo("1");
	}
	
	public function rename_user() {
		$new_name = $_POST['user_to_add'];
		$id_to_set = $_POST['id_entered'];
		
		$this->db->select('user_name');
		$query = $this->db->get('users');
		foreach ($query->result() as $row) {
			if (strtoupper($row->user_name) == strtoupper($new_name)) {
				echo("2");
				return;
			}
		}
		
		$this->db->where('id',$id_to_set);
		$this->db->update('users',array('user_name'=>$new_name));
		
		echo("1");
	}
	
	public function delete_user() {
		$userID_to_delete = $_POST['userID_to_delete'];
		$this->db->where('id',$userID_to_delete);
		$this->db->update('users',array('user_hidden'=>'1'));
	}
	
	public function undelete_user() {
		$userID_to_undelete = $_POST['userID_to_undelete'];
		$this->db->where('id',$userID_to_undelete);
		$this->db->update('users',array('user_hidden'=>'0'));
	}
	
	public function clock_in() {
		$return = new stdClass;
		$user_id = $this->data['currentUserID'];
		$job_id = $_POST['job_id'];
		$project_id = $_POST['project_id'];
		$box_id = $_POST['box_id'];
		$cur_time = time();
		$string_time = date('M j, Y g:i A',$cur_time);
		$string_time_db = date('Y-m-d H:i:s',$cur_time);
		
		$this->db->select('job_id,project_id,box_id,user_start');
		$query = $this->db->get_where('users',array('id'=>$user_id));
		
		foreach ($query->result() as $row) {
			$cur_job_id = $row->job_id;
			$cur_project_id = $row->project_id;
			$cur_box_id = $row->box_id;
			$cur_user_start = $row->user_start;
		}
		
		if ($cur_user_start) {
			$stop_time_db = date('Y-m-d H:i:s');
			$data = array(
				'user_id' => $user_id,
				'job_id' => $cur_job_id,
				'project_id' => $cur_project_id,
				'box_id' => $cur_box_id,
				'log_start' => $cur_user_start,
				'log_stop' => $stop_time_db
			);
			$this->db->insert('logs', $data);

            //update box status
            $this->db->select('set_box_status_id');
            $query = $this->db->get_where('jobs',array('id'=>$cur_job_id));
            if ($query->num_rows() > 0) {
                $row = $query->row();
                if ($row->set_box_status_id > 0) {
                    $data = array(
                        'box_status_id' => $row->set_box_status_id
                    );
                    $this->db->where('id',$cur_box_id);
                    $this->db->update('boxes',$data);
                }
            }
		}
		
		$data = array(
			'job_id' => $job_id,
			'project_id' => $project_id,
			'box_id' => $box_id,
			'user_start' => $string_time_db
		);
		
		$this->db->where('id', $user_id);
		$this->db->update('users', $data); 
		
		$return->start_time = $string_time;
		
		$where = array(
			'job_id' => $job_id,
			'project_id' => $project_id
		);
		$this->db->select('help_content');
		$query = $this->db->get_where('help',$where);
		$return->help_content = "";
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$return->help_content .= $row->help_content;
			}
		}
		
		echo json_encode($return);
	}
	
	public function clock_out() {
		$user_id = $this->data['currentUserID'];
		$this->db->select('job_id,project_id,box_id,user_start');
		$query = $this->db->get_where('users',array('id'=>$user_id));
		foreach ($query->result() as $row) {
			$cur_job_id = $row->job_id;
			$cur_project_id = $row->project_id;
			$cur_box_id = $row->box_id;
			$cur_user_start = $row->user_start;
		}
		$stop_time_db = date('Y-m-d H:i:s');
		$data = array(
			'user_id' => $user_id,
			'job_id' => $cur_job_id,
			'project_id' => $cur_project_id,
			'box_id' => $cur_box_id,
			'log_start' => $cur_user_start,
			'log_stop' => $stop_time_db
		);
		$this->db->insert('logs', $data);
		
		$data = array('user_start' => NULL);
		
		$this->db->where('id', $user_id);
		$this->db->update('users', $data);
		
		//update box status
		$this->db->select('set_box_status_id');
		$query = $this->db->get_where('jobs',array('id'=>$cur_job_id));
		if ($query->num_rows() > 0) {
			$row = $query->row();
			if ($row->set_box_status_id > 0) {
				$data = array(
					'box_status_id' => $row->set_box_status_id
				);
				$this->db->where('id',$cur_box_id);
				$this->db->update('boxes',$data);
			}
		}
	}
	
	public function get_hidden_users_list() {
		$this->db->select('id,user_name');
		$this->db->order_by('user_name');
		$query = $this->db->get_where('users',array('user_hidden'=>'1'));
		echo("<div style=\"overflow-y:auto; height:275px;\"><table class=\"table table-condensed\" style=\"margin-top:15px;\">");
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				echo("<tr itemID=\"".$row->id."\">
						<td><img src=".base_url("assets/img/ui/icons/user.png")." />&nbsp;".$row->user_name."<div class=\"hidden_user btn btn-primary btn-mini\" style=\"float:right;\" itemID=\"".$row->id."\"><i class=\"icon-share-alt icon-white\"></i>&nbsp;Undelete</div></td>
					  </tr>");
			}
		} else {
				echo("<tr>
						<td>There are no users that can be undeleted.</td>
					  </tr>");
		}
		
		echo("</table></div>");
	}

	public function get_admin_users_list() {
		$this->db->select('id,user_name');
		$this->db->order_by('user_name','asc');
		$query = $this->db->get_where('users',array('user_hidden'=>'0'));
		
		echo("<table class=\"table hover_table solid_table table-condensed\" style=\"margin-top:15px;\">
    
				<thead><tr>
					<th>User Name</th>
					<th>Actions</th>
				</tr></thead>
				
				<tbody>");
		
		foreach ($query->result() as $row) {
		/*
		echo("  	<tr class=\"user_row\" itemID=".$row->id.">
						<td><img src=".base_url("assets/img/ui/icons/user.png")." />&nbsp;".$row->user_name."</td>
						<td>
							<div class=\"btn-group\">
							  <button class=\"btn btn-mini btn-inverse button_admin_modify_user\" style=\"width:80px;\" itemID=".$row->id." userName=\"".$row->user_name."\"><i class=\"icon-edit icon-white\"></i>&nbsp;Rename</button>
							  <button class=\"btn btn-mini btn-primary button_admin_modify_user_groups\" style=\"width:80px;\" itemID=".$row->id."><i class=\"icon-list icon-white\"></i>&nbsp;Groups</button>
							  <button class=\"btn btn-mini btn-danger button_admin_delete_user\" style=\"width:80px;\" itemID=".$row->id."><i class=\"icon-trash icon-white\"></i>&nbsp;Delete</button>
							</div>
						</td>
					</tr>");*/
		
		echo("  	<tr class=\"user_row\" itemID=".$row->id.">
						<td><img src=".base_url("assets/img/ui/icons/user.png")." />&nbsp;".$row->user_name."</td>
						<td>
						
							<a class=\"admin_button black button_admin_modify_user\" style=\"color:black;\" itemID=".$row->id." userName=\"".$row->user_name."\"><span class=\"ico-edit\" style=\"position:relative;top:2px;\"></span> Rename</a>
							<a class=\"admin_button blue button_admin_modify_user_groups\" itemID=".$row->id."><span class=\"ico-users\"></span> Groups</button>
							<a class=\"admin_button red button_admin_delete_user\" style=\"color:red;\" itemID=".$row->id."><span class=\"ico-trash\" style=\"position:relative;top:2px;\"></span> Delete</button>

						</td>
					</tr>");
					
		}
		
		echo("	</tbody>
			
			</table>");
	}
	
	public function get_stats() {
		$return = new stdClass;
		
		$this->load->model('timemodel');
		$time_now = time();
		
		$payPeriod_start = date("M j, Y g:i A",$this->timemodel->getPayPeriodStart());
		$payPeriod_end = date("M j, Y g:i A",$this->timemodel->getPayPeriodStart(1)-1);
		
		//GET CURRENT LOG DATA
		$user_id = $this->data['currentUserID'];
		$this->db->select('user_start');
		$query = $this->db->get_where('users',array('id'=>$user_id));
		
		foreach ($query->result() as $row) {
			$cur_user_start = $row->user_start;
		}
		
		if($cur_user_start) {
			$start_timestamp = strtotime($cur_user_start);
			$stop_timestamp = time();
			
			if ($start_timestamp >= strtotime('today')) {
				$add_todays_time = true;
			} else {
				$add_todays_time = false;
			}
			
			$cur_log_seconds = $stop_timestamp - $start_timestamp;
			$time_curlog = $this->timemodel->getCleanTime($cur_log_seconds);
		} else {
			$time_curlog = "-";
			$cur_log_seconds = 0;
			$add_todays_time = false;
		}

		//GET PREVIOUS LOG DATA STARTING FROM LAST PAY PERIOD
		$last_payperiod_start = date("Y-m-d H:i:s",$this->timemodel->getPayPeriodStart());
		$last_payperiod_end = date("Y-m-d H:i:s",$this->timemodel->getPayPeriodStart(1));
		$where = array('log_start >=' => $last_payperiod_start, 'log_start <' => $last_payperiod_end);
		$this->db->select('log_start,log_stop');
		$this->db->where($where);
		$this->db->order_by('log_start','desc');
		$query = $this->db->get_where('logs',array('user_id'=>$user_id));
		
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
		
		$return->logs = $logs;
		
		echo json_encode($return);
		return;
		
		//PROCESS PREVIOUS LOG DATA
		if (count($logs) == 0) {
			$time_lastlog = "-";
			$time_today = "-";
			$time_week = "-";
			$time_payperiod = "-";
			$time_payperiod_ot = "-";
		} else {
			$time_lastlog = $this->timemodel->getCleanTime($logs[0]['diff_seconds']);
			$time_today = "";
			$time_week = "";
			$time_payperiod = "";
			$time_payperiod_ot = "";
			$seconds_today = 0;
			$seconds_week = 0;
			$seconds_payperiod_w1r = 0;
			$seconds_payperiod_w1ot = 0;
			$seconds_payperiod_w2r = 0;
			$seconds_payperiod_w2ot = 0;

			//CALCULATE TODAYS TIME
			$date_string_today = date('Y-m-d',$time_now);
			foreach ($logs as $log) {
				$log_date_string = date("Y-m-d",$log['start_timestamp']);
				if ($log_date_string == $date_string_today) {$seconds_today += $log['diff_seconds'];}
			}
			if ($add_todays_time) {$seconds_today += $cur_log_seconds;}
			$time_today = $this->timemodel->getCleanTime($seconds_today);
			
			//CALCULATE WEEKS TIME
			$time_last_sunday = strtotime("last monday");
			foreach ($logs as $log) {
				if ($log['start_timestamp'] >= $time_last_sunday) {$seconds_week += $log['diff_seconds'];}
			}
			if ($add_todays_time) {$seconds_week += $cur_log_seconds;}
			$time_week = $this->timemodel->getCleanTime($seconds_week);
			
			//CALCULATE PAY PERIOD TIME
			$w1_start = $this->timemodel->getPayPeriodStart();
			$w1_end = $w1_start + 604799;
			$w2_start = $w1_start + 604800;
			$w2_end = $w2_start + 604799;
			foreach ($logs as $log) {
				if ($log['start_timestamp'] >= $w1_start && $log['start_timestamp'] <= $w1_end) {$seconds_payperiod_w1r += $log['diff_seconds'];}
				if ($log['start_timestamp'] >= $w2_start && $log['start_timestamp'] <= $w2_end) {$seconds_payperiod_w2r += $log['diff_seconds'];}
			}
			$start_timestamp = strtotime($cur_user_start);
			if ($start_timestamp >= $w1_start && $start_timestamp <= $w1_end) {$seconds_payperiod_w1r += $cur_log_seconds;}
			if ($start_timestamp >= $w2_start && $start_timestamp <= $w2_end) {$seconds_payperiod_w2r += $cur_log_seconds;}
			if ($seconds_payperiod_w1r > 144000) {
				$seconds_payperiod_w1ot = $seconds_payperiod_w1r - 144000;
				$seconds_payperiod_w1r = 144000;
			}
			if ($seconds_payperiod_w2r > 144000) {
				$seconds_payperiod_w2ot = $seconds_payperiod_w2r - 144000;
				$seconds_payperiod_w2r = 144000;
			}
			$time_payperiod = $this->timemodel->getCleanTime($seconds_payperiod_w1r + $seconds_payperiod_w2r);
			$time_payperiod_ot = $this->timemodel->getCleanTime($seconds_payperiod_w1ot + $seconds_payperiod_w2ot);
		}
		
		//OUTPUT RESULTS
		echo("<table class=\"hover_table\" cellspacing=\"0\" cellpadding=\"5px\" border=\"0\" width=\"100%\" style=\"margin-bottom:10px;\">
				<tbody>
					<tr>
						<td align=\"right\" valign=\"top\" width=\"50%\"><strong>Current Log:</strong></td>
						<td align=\"left\" valign=\"top\">".$time_curlog."</td>
					</tr>
					
					<tr>
						<td align=\"right\" valign=\"top\" width=\"50%\"><strong>Last Log:</strong></td>
						<td align=\"left\" valign=\"top\">".$time_lastlog."</td>
					</tr>
					
					<tr>
						<td align=\"right\" valign=\"top\"><strong>Today:</strong></td>
						<td align=\"left\" valign=\"top\">".$time_today."</td>
					</tr>
					
					<tr>
						<td align=\"right\" valign=\"top\"><strong>This Week:</strong></td>
						<td align=\"left\" valign=\"top\">".$time_week."</td>
					</tr>
					
					<tr>
						<td align=\"right\" valign=\"top\"><strong>This Pay Period:</strong></td>
						<td align=\"left\" valign=\"top\">".$time_payperiod."</td>
					</tr>
					
					<tr>
						<td align=\"right\" valign=\"top\"><strong>This Pay Period (OT):</strong></td>
						<td align=\"left\" valign=\"top\">".$time_payperiod_ot."</td>
					</tr>
					
					<tr>
						<td align=\"right\" valign=\"top\"><strong>Pay Period Start Date:</strong></td>
						<td align=\"left\" valign=\"top\">".$payPeriod_start."</td>
					</tr>
					
					<tr>
						<td align=\"right\" valign=\"top\"><strong>Pay Period End Date:</strong></td>
						<td align=\"left\" valign=\"top\">".$payPeriod_end."</td>
					</tr>
					
				</tbody>
			</table>");
	}

	public function get_user_stats() {
		$this->load->model('timemodel');
		$time_now = time();
		
		$payPeriod_start = date("M j, Y g:i A",$this->timemodel->getPayPeriodStart());
		$payPeriod_end = date("M j, Y g:i A",$this->timemodel->getPayPeriodStart(1)-1);

		//GET CURRENT LOG DATA
		$user_id = $this->data['currentUserID'];
		$this->db->select('user_start');
		$query = $this->db->get_where('users',array('id'=>$user_id));
		
		foreach ($query->result() as $row) {
			$cur_user_start = $row->user_start;
		}
		
		$cur_log_start_timestamp = false;
		if($cur_user_start) {
			$start_timestamp = strtotime($cur_user_start);
			$cur_log_start_timestamp = strtotime($cur_user_start);
			$stop_timestamp = time();
			
			if ($start_timestamp >= strtotime('today')) {
				$add_todays_time = true;
			} else {
				$add_todays_time = false;
			}
			
			$cur_log_seconds = $stop_timestamp - $start_timestamp;
			$time_curlog = $this->timemodel->getCleanTime($cur_log_seconds);
		} else {
			$time_curlog = "-";
			$cur_log_seconds = 0;
			$add_todays_time = false;
		}
		
		//GET PREVIOUS LOG DATA STARTING FROM LAST PAY PERIOD
		$last_payperiod_start = date("Y-m-d H:i:s",$this->timemodel->getPayPeriodStart());
		$last_payperiod_end = date("Y-m-d H:i:s",$this->timemodel->getPayPeriodStart(1));
		$where = array('log_start >=' => $last_payperiod_start, 'log_start <' => $last_payperiod_end);
		$this->db->select('log_start,log_stop');
		$this->db->where($where);
		$this->db->order_by('log_start','desc');
		$query = $this->db->get_where('logs',array('user_id'=>$user_id));
		
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
		
		//PROCESS PREVIOUS LOG DATA
		if (count($logs) == 0) {
			$time_lastlog = "-";
			$time_today = "-";
			$time_week = "-";
			$time_payperiod = "-";
			$time_payperiod_ot = "-";
		} else {
			$time_lastlog = $this->timemodel->getCleanTime($logs[0]['diff_seconds']);
			$time_today = "";
			$time_week = "";
			$time_payperiod = "";
			$time_payperiod_ot = "";
			$seconds_today = 0;
			$seconds_week = 0;
			$seconds_payperiod_w1r = 0;
			$seconds_payperiod_w1ot = 0;
			$seconds_payperiod_w2r = 0;
			$seconds_payperiod_w2ot = 0;

			//CALCULATE TODAYS TIME
			$date_string_today = date('Y-m-d',$time_now);
			foreach ($logs as $log) {
				$log_date_string = date("Y-m-d",$log['start_timestamp']);
				if ($log_date_string == $date_string_today) {$seconds_today += $log['diff_seconds'];}
			}
			if ($add_todays_time) {$seconds_today += $cur_log_seconds;}
			$time_today = $this->timemodel->getCleanTime($seconds_today);
			
			//CALCULATE WEEKS TIME
			$time_last_sunday = strtotime("last monday");
			foreach ($logs as $log) {
				if ($log['start_timestamp'] >= $time_last_sunday) {$seconds_week += $log['diff_seconds'];}
			}
			
			if ($cur_log_start_timestamp >= $time_last_sunday) {
				$seconds_week += $cur_log_seconds;
			}
			$time_week = $this->timemodel->getCleanTime($seconds_week);
			
			//CALCULATE PAY PERIOD TIME
			$w1_start = $this->timemodel->getPayPeriodStart();
			$w1_end = $w1_start + 604799;
			$w2_start = $w1_start + 604800;
			$w2_end = $w2_start + 604799;
			foreach ($logs as $log) {
				if ($log['start_timestamp'] >= $w1_start && $log['start_timestamp'] <= $w1_end) {$seconds_payperiod_w1r += $log['diff_seconds'];}
				if ($log['start_timestamp'] >= $w2_start && $log['start_timestamp'] <= $w2_end) {$seconds_payperiod_w2r += $log['diff_seconds'];}
			}
			$start_timestamp = strtotime($cur_user_start);
			if ($start_timestamp >= $w1_start && $start_timestamp <= $w1_end) {$seconds_payperiod_w1r += $cur_log_seconds;}
			if ($start_timestamp >= $w2_start && $start_timestamp <= $w2_end) {$seconds_payperiod_w2r += $cur_log_seconds;}
			if ($seconds_payperiod_w1r > 144000) {
				$seconds_payperiod_w1ot = $seconds_payperiod_w1r - 144000;
				$seconds_payperiod_w1r = 144000;
			}
			if ($seconds_payperiod_w2r > 144000) {
				$seconds_payperiod_w2ot = $seconds_payperiod_w2r - 144000;
				$seconds_payperiod_w2r = 144000;
			}
			$time_payperiod = $this->timemodel->getCleanTime($seconds_payperiod_w1r + $seconds_payperiod_w2r);
			$time_payperiod_ot = $this->timemodel->getCleanTime($seconds_payperiod_w1ot + $seconds_payperiod_w2ot);
		}
		
		//OUTPUT RESULTS
		echo("<table class=\"hover_table\" cellspacing=\"0\" cellpadding=\"5px\" border=\"0\" width=\"100%\" style=\"margin-bottom:10px;\">
				<tbody>
					<tr>
						<td align=\"right\" valign=\"top\" width=\"50%\"><strong>Current Log:</strong></td>
						<td align=\"left\" valign=\"top\">".$time_curlog."</td>
					</tr>
					
					<tr>
						<td align=\"right\" valign=\"top\" width=\"50%\"><strong>Last Log:</strong></td>
						<td align=\"left\" valign=\"top\">".$time_lastlog."</td>
					</tr>
					
					<tr>
						<td align=\"right\" valign=\"top\"><strong>Today:</strong></td>
						<td align=\"left\" valign=\"top\">".$time_today."</td>
					</tr>
					
					<tr>
						<td align=\"right\" valign=\"top\"><strong>This Week:</strong></td>
						<td align=\"left\" valign=\"top\">".$time_week."</td>
					</tr>
					
					<tr>
						<td align=\"right\" valign=\"top\"><strong>This Pay Period:</strong></td>
						<td align=\"left\" valign=\"top\">".$time_payperiod."</td>
					</tr>
					
					<tr>
						<td align=\"right\" valign=\"top\"><strong>This Pay Period (OT):</strong></td>
						<td align=\"left\" valign=\"top\">".$time_payperiod_ot."</td>
					</tr>
					
					<tr>
						<td align=\"right\" valign=\"top\"><strong>Pay Period Start Date:</strong></td>
						<td align=\"left\" valign=\"top\">".$payPeriod_start."</td>
					</tr>
					
					<tr>
						<td align=\"right\" valign=\"top\"><strong>Pay Period End Date:</strong></td>
						<td align=\"left\" valign=\"top\">".$payPeriod_end."</td>
					</tr>
					
				</tbody>
			</table>");
	}
	
}
