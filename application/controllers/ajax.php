<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->data = array();
		$this->data['currentUser'] = $this->session->userdata('currentUser');
		$this->data['currentUserID'] = $this->session->userdata('currentUserID');
	}

    public function add_log() {
        $return = new stdClass();
        $return->error = "";
        $user_to_send = $_GET['user_to_send'];
        $job_to_send = $_GET['job_to_send'];
        $project_to_send = $_GET['project_to_send'];
        $box_to_send = $_GET['box_to_send'];
        $start_date_to_send = trim($_GET['start_date_to_send']);
        $start_hour_to_send = trim($_GET['start_hour_to_send']);
        $start_min_to_send = trim($_GET['start_min_to_send']);
        $start_period_to_send = trim($_GET['start_period_to_send']);
        $stop_date_to_send = trim($_GET['stop_date_to_send']);
        $stop_hour_to_send = trim($_GET['stop_hour_to_send']);
        $stop_min_to_send = trim($_GET['stop_min_to_send']);
        $stop_period_to_send = trim($_GET['stop_period_to_send']);

        if ($user_to_send == -1) {
            $return->error = "Missing User";
            echo json_encode($return);
            return;
        }

        if ($job_to_send == -1) {
            $return->error = "Missing Job";
            echo json_encode($return);
            return;
        }

        if ($project_to_send == -1) {
            $return->error = "Missing Project";
            echo json_encode($return);
            return;
        }

        if ($box_to_send == -1) {
            $return->error = "Missing Box";
            echo json_encode($return);
            return;
        }

        if (!is_numeric($start_hour_to_send) || !is_numeric($start_min_to_send)) {
            $return->error = "Stop / Start dates are invalid.";
            echo json_encode($return);
            return;
        }

        if (!is_numeric($stop_hour_to_send) || !is_numeric($stop_min_to_send)) {
            $return->error = "Stop / Start dates are invalid.";
            echo json_encode($return);
            return;
        }

        $start_date = strtotime($start_date_to_send . " " . $start_hour_to_send . ":" . $start_min_to_send . " " . $start_period_to_send);
        $stop_date = strtotime($stop_date_to_send . " " . $stop_hour_to_send . ":" . $stop_min_to_send . " " . $stop_period_to_send);

        if (!$start_date || !$stop_date) {
            $return->error = "Stop / Start dates are invalid.";
            echo json_encode($return);
            return;
        } else if ($start_date > $stop_date) {
            $return->error = "Start date cannot be after stop date.";
            echo json_encode($return);
            return;
        }

        $data = array(
            'user_id' => $user_to_send,
            'job_id' => $job_to_send,
            'project_id' => $project_to_send,
            'box_id' => $box_to_send,
            'log_start' => date('Y-m-d H:i:s',$start_date),
            'log_stop' => date('Y-m-d H:i:s',$stop_date)
        );

        $this->db->insert('logs',$data);

        echo json_encode($return);
    }

    public function edit_log() {
        $return = new stdClass();
        $return->error = "";
        $log_id = $_GET['log_id'];
        $user_to_send = $_GET['user_to_send'];
        $job_to_send = $_GET['job_to_send'];
        $project_to_send = $_GET['project_to_send'];
        $box_to_send = $_GET['box_to_send'];
        $start_date_to_send = trim($_GET['start_date_to_send']);
        $start_hour_to_send = trim($_GET['start_hour_to_send']);
        $start_min_to_send = trim($_GET['start_min_to_send']);
        $start_period_to_send = trim($_GET['start_period_to_send']);
        $stop_date_to_send = trim($_GET['stop_date_to_send']);
        $stop_hour_to_send = trim($_GET['stop_hour_to_send']);
        $stop_min_to_send = trim($_GET['stop_min_to_send']);
        $stop_period_to_send = trim($_GET['stop_period_to_send']);

        if ($user_to_send == -1) {
            $return->error = "Missing User";
            echo json_encode($return);
            return;
        }

        if ($job_to_send == -1) {
            $return->error = "Missing Job";
            echo json_encode($return);
            return;
        }

        if ($project_to_send == -1) {
            $return->error = "Missing Project";
            echo json_encode($return);
            return;
        }

        if ($box_to_send == -1) {
            $return->error = "Missing Box";
            echo json_encode($return);
            return;
        }

        if (!is_numeric($start_hour_to_send) || !is_numeric($start_min_to_send)) {
            $return->error = "Stop / Start dates are invalid.";
            echo json_encode($return);
            return;
        }

        if (!is_numeric($stop_hour_to_send) || !is_numeric($stop_min_to_send)) {
            $return->error = "Stop / Start dates are invalid.";
            echo json_encode($return);
            return;
        }

        $start_date = strtotime($start_date_to_send . " " . $start_hour_to_send . ":" . $start_min_to_send . " " . $start_period_to_send);
        $stop_date = strtotime($stop_date_to_send . " " . $stop_hour_to_send . ":" . $stop_min_to_send . " " . $stop_period_to_send);

        if (!$start_date || !$stop_date) {
            $return->error = "Stop / Start dates are invalid.";
            echo json_encode($return);
            return;
        } else if ($start_date > $stop_date) {
            $return->error = "Start date cannot be after stop date.";
            echo json_encode($return);
            return;
        }

        $data = array(
            'user_id' => $user_to_send,
            'job_id' => $job_to_send,
            'project_id' => $project_to_send,
            'box_id' => $box_to_send,
            'log_start' => date('Y-m-d H:i:s',$start_date),
            'log_stop' => date('Y-m-d H:i:s',$stop_date)
        );

        $this->db->where('id',$log_id);
        $this->db->update('logs',$data);

        echo json_encode($return);
    }
	
	public function delete_log() {
		$log_id = $_GET['log_id'];
		$this->db->where('id', $log_id);
		$this->db->delete('logs'); 
	}
	
	public function get_admin_logs_modal_data() {
		$log_id = $_GET['log_id'];
		$return = new stdClass();
		
		$this->db->select('id,user_name');
		$this->db->order_by('user_name');
		$query = $this->db->get_where('users',array('user_hidden'=>0));
		$return->users = $query->result();

		$this->db->select('id,job_name');
		$this->db->order_by('job_name');
		$query = $this->db->get('jobs');
		$return->jobs = $query->result();
		
		$this->db->select('id,project_name');
		$this->db->order_by('project_name');
		$query = $this->db->get_where('projects',array('hidden'=>0));
		$return->projects = $query->result();
		
		$this->db->select('id,project_id,box_name');
		$this->db->order_by('box_name');
		$query = $this->db->get('boxes');
		$return->boxes = $query->result();
		
		if ($log_id > 0) {
			$this->db->select('*');
			$query = $this->db->get_where('logs',array('id'=>$log_id));
			$row = $query->row();
			
			$return->log_data = new stdClass();
			$return->log_data->user_id = $row->user_id;
			$return->log_data->job_id = $row->job_id;
			$return->log_data->project_id = $row->project_id;
			$return->log_data->box_id = $row->box_id;
			
			$start_date = strtotime($row->log_start);
			$return->log_data->start_date = date('Y-m-d',$start_date);
			$return->log_data->start_hour = date('g',$start_date);
			$return->log_data->start_min = date('i',$start_date);
			$return->log_data->start_period = date('A',$start_date);

			$stop_date = strtotime($row->log_stop);
			$return->log_data->stop_date = date('Y-m-d',$stop_date);
			$return->log_data->stop_hour = date('g',$stop_date);
			$return->log_data->stop_min = date('i',$stop_date);
			$return->log_data->stop_period = date('A',$stop_date);
		}

		echo json_encode($return);
	}
	
	public function get_admin_logs_list() {
		$this->load->model('timemodel');
		$return = new stdClass();
		$return->results = array();
		
		$filter_user = (string)$_POST['filter_user'];
		$filter_job = (string)$_POST['filter_job'];
		$filter_project = (string)$_POST['filter_project'];
		$filter_box = (string)$_POST['filter_box'];
		$filter_date = (string)$_POST['filter_date'];
		$filter_user_val = (string)$_POST['filter_user_val'];
		$filter_job_val =(string)$_POST['filter_job_val'];
		$filter_project_val = (string)$_POST['filter_project_val'];
		$filter_box_val = (string)$_POST['filter_box_val'];
		$filter_date_start_val = (string)$_POST['filter_date_start_val'];
		$filter_date_end_val = (string)$_POST['filter_date_end_val'];
		
		$itemsper =  $_POST['cur_itemsper'];
		$page = $_POST['cur_page'];
		$offset = $itemsper * ($page-1);
		
		switch($_POST['sort_by_val']) {
			case 'User': $order_by = 'user_name'; break;
			case 'Job': $order_by = 'job_name'; break;
			case 'Project': $order_by = 'project_name'; break;
			case 'Box': $order_by = 'box_name'; break;
			case 'Date': $order_by = 'log_start'; break;
			default : $order_by = 'log_start'; break;
		}
		
		switch($_POST['sort_by_dir']) {
			case '1': $sort_dir = "Desc"; break;
			case '0': $sort_dir = "Asc"; break;
			default: $sort_dir = "Desc"; break;
		}

		//get current page results
		$this->db->select('logs.id,user_name,job_name,project_name,box_name,log_start,log_stop');
		$this->db->order_by($order_by,$sort_dir);
		
		$this->db->join('users','users.id = logs.user_id', 'left');
		$this->db->join('jobs','jobs.id = logs.job_id', 'left');
		$this->db->join('projects','projects.id = logs.project_id', 'left');
		$this->db->join('boxes','boxes.id = logs.box_id', 'left');
		
		$where = array();
		if ($filter_user == "true" && $filter_user_val !== "Select One") {$where['logs.user_id'] = $filter_user_val;}
		if ($filter_job == "true" && $filter_job_val !== "Select One") {$where['logs.job_id'] = $filter_job_val;}
		if ($filter_project == "true" && $filter_project_val !== "Select One") {$where['logs.project_id'] = $filter_project_val;}
		if ($filter_box == "true" && $filter_box_val !== "Select One") {$where['logs.box_id'] = $filter_box_val;}
		if ($filter_date == "true" && $filter_date_start_val !== "") {$where['logs.log_start >='] = $filter_date_start_val;}
		if ($filter_date == "true" && $filter_date_end_val !== "") {
			$timestamp = strtotime($filter_date_end_val.' midnight +1 day');
			$where['logs.log_start <='] = date('Y-m-d',$timestamp);
		}
		
		if (count($where) > 0) {
			$query = $this->db->get_where('logs',$where,$itemsper,$offset);
		} else {
			$query = $this->db->get('logs',$itemsper,$offset);
		}

		foreach ($query->result() as $row) {
			$cur_log_seconds = strtotime($row->log_stop) - strtotime($row->log_start);
			$cur_log_time = $this->timemodel->getCleanTime($cur_log_seconds);
			array_push($return->results,array(
				'id'=>$row->id,
				'user_name'=>$row->user_name,
				'job_name'=>$row->job_name,
				'project_name'=>$row->project_name,
				'box_name'=>$row->box_name,
				'log_start'=>$this->timemodel->convert_date_to_readable($row->log_start),
				'log_stop'=>$this->timemodel->convert_date_to_readable($row->log_stop),
				'seconds'=>$cur_log_seconds,
				'time_string'=>$cur_log_time
			));
		}
		
		$cnt_total = 0;
		$total_seconds = 0;
		$this->db->select('id,log_start,log_stop');
		$where = array();
		if ($filter_user == "true" && $filter_user_val !== "Select One") {$where['logs.user_id'] = $filter_user_val;}
		if ($filter_job == "true" && $filter_job_val !== "Select One") {$where['logs.job_id'] = $filter_job_val;}
		if ($filter_project == "true" && $filter_project_val !== "Select One") {$where['logs.project_id'] = $filter_project_val;}
		if ($filter_box == "true" && $filter_box_val !== "Select One") {$where['logs.box_id'] = $filter_box_val;}
		if ($filter_date == "true" && $filter_date_start_val !== "") {$where['logs.log_start >='] = $filter_date_start_val;}
		if ($filter_date == "true" && $filter_date_end_val !== "") {
			$timestamp = strtotime($filter_date_end_val.' midnight +1 day');
			$where['logs.log_start <='] = date('Y-m-d',$timestamp);
		}
		if (count($where) > 0) {
			$query = $this->db->get_where('logs',$where);
		} else {
			$query = $this->db->get('logs');
		}
		foreach ($query->result() as $row) {
			$total_seconds += strtotime($row->log_stop) - strtotime($row->log_start);
			$cnt_total++;
		}
		$return->total_seconds = $total_seconds;
		$return->records_total = $cnt_total;
		
		$this->load->model('timemodel');
		$return->total_time = $this->timemodel->getCleanTime($total_seconds);
		
		$output = array('output' => json_encode($return));
		$this->load->view('json', $output);
	}
	
	public function get_admin_logs_filter_boxes() {
		$project_id = $_POST['project_id'];
		$return = new stdClass();
		$return->results = array();
		
		$this->db->select('id,box_name');
        $this->db->order_by('box_name');
		$query = $this->db->get_where('boxes',array('project_id'=>$project_id));
		foreach($query->result() as $row) {
			array_push($return->results,array(
				'id'=>$row->id,
				'box_name'=>$row->box_name
			));
		}

		$output = array('output' => json_encode($return));
		$this->load->view('json', $output);
	}
	
	public function get_admin_logs_filter_projects() {
		$return = new stdClass();
		$return->results = array();
		
		$this->db->select('id,project_name');
        $this->db->order_by('project_name');
		$query = $this->db->get_where('projects',array('hidden'=>0));
		foreach($query->result() as $row) {
			array_push($return->results,array(
				'id'=>$row->id,
				'project_name'=>$row->project_name
			));
		}

		$output = array('output' => json_encode($return));
		$this->load->view('json', $output);
	}
	
	public function get_admin_logs_filter_jobs() {
		$return = new stdClass();
		$return->results = array();
		
		$this->db->select('id,job_name');
        $this->db->order_by('job_name');
		$query = $this->db->get('jobs');
		foreach($query->result() as $row) {
			array_push($return->results,array(
				'id'=>$row->id,
				'job_name'=>$row->job_name
			));
		}

		$output = array('output' => json_encode($return));
		$this->load->view('json', $output);
	}
	
	public function get_admin_logs_filter_users() {
		$return = new stdClass();
		$return->results = array();
		
		$this->db->select('id,user_name');
        $this->db->order_by('user_name');
		$query = $this->db->get_where('users',array('user_hidden'=>0));
		foreach($query->result() as $row) {
			array_push($return->results,array(
				'id'=>$row->id,
				'user_name'=>$row->user_name
			));
		}

		$output = array('output' => json_encode($return));
		$this->load->view('json', $output);
	}
	
	public function changeAdminPass() {
		$cur_pass = $_POST['pass_cur'];
		$new_pass = $_POST['pass_new'];
		
		$this->db->select('admin_pass');
		$query = $this->db->get('auth');
		$result = $query->result();
		$correct_pass = $result[0]->admin_pass;
		
		if ($cur_pass == $correct_pass) {
			$this->db->update('auth', array('admin_pass'=>$new_pass), "id = 1");
			echo('1');
		}
	}
	
	public function adminAuth() {
		$pass_to_try = $_POST['try_pass'];
		
		$this->db->select('admin_pass');
		$query = $this->db->get('auth');
		$result = $query->result();
		$correct_pass = $result[0]->admin_pass;
		
		if ($pass_to_try == $correct_pass) {
			$this->session->set_userdata('admin_mode',true);
			echo("1");
		}
		
	}
	
	public function adminOff() {$this->session->set_userdata('admin_mode',false);}
	
	
	
	public function getProjectsList() {
		$this->db->select('id, project_name, project_received');
		$this->db->from('projects');
		$this->db->where('hidden',0);
		$this->db->order_by('project_name','asc');
		$query = $this->db->get();

		echo("<table class=\"table table-condensed\"><thead><tr><th>Project Name</th><th>Received</th></tr></thead><tbody>");
		foreach($query->result() as $row) {
			echo("<tr itemID=\"".$row->id."\" item_name=\"".$row->project_name."\"><td>".$row->project_name."</td><td>".date("M j, Y",strtotime($row->project_received))."</td></tr>");
		}
		echo("</tbody></table>");
	}
	
	public function getBoxList() {
		$project_id = $_POST['project_id'];
		
		//get box statuses list
		$this->db->select('id,box_status_name');
		//$this->db->order_by('box_status_name');
		$box_statuses = $this->db->get('box_status')->result();
		
		$this->db->select('boxes.id, boxes.box_name, box_status_name');
		$this->db->from('boxes');
		$this->db->join('box_status','box_status.id = boxes.box_status_id', 'left');
		$this->db->where('boxes.project_id',$project_id);
		$this->db->order_by('boxes.box_name','asc');
		$query = $this->db->get();
		
		echo("<table class=\"table table-condensed\"><thead><tr><th>Box Name</th><th>Status</th></tr></thead><tbody>");
		foreach($query->result() as $row) {

			$box_status_html = "
			<ul class=\"nav nav-pills table_nav\" style=\"margin-bottom:0px;\">
				<li class=\"dropdown\">
					<a class=\"dropdown-toggle\" id=\"box_status_".$row->id."\" data-toggle=\"dropdown\" role=\"button\" href=\"#\" style=\"margin:0;\">".$row->box_status_name."&nbsp;<span class=\"caret\"></span></a>
					<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"box_status_".$row->id."\">";
			
			foreach($box_statuses as $box_status) {
				$box_status_html .="<li><a class=\"box_status_link\" box_id=\"".$row->id."\" status_id=\"".$box_status->id."\">".$box_status->box_status_name."</a></li>";
			}

			$box_status_html .="</ul></li></ul>";
			
			echo("<tr itemID=\"".$row->id."\" item_name=\"".$row->box_name."\"><td>".$row->box_name."</td><td style=\"padding:0;\">".$box_status_html."</td></tr>");
		}
		echo("</tbody></table>");
	}

}
