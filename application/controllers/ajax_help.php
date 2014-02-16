<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_help extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->data = array();
		$this->data['currentUser'] = $this->session->userdata('currentUser');
		$this->data['currentUserID'] = $this->session->userdata('currentUserID');
	}
	
	public function copy_all_help() {
		$return = new stdClass;
		$return->cnt = 0;
		$return->files_copied = array();
		
		$project_id_to_copy = $_GET['project_id'];
		$cur_project_id = $_GET['cur_project_id'];
		
		$this->db->select('help_content,job_id');
		$this->db->where('project_id',$project_id_to_copy);
		$query = $this->db->get('help');
		
		if($query->num_rows > 0) {
			foreach($query->result() as $row) {
				$return->cnt++;
				$data_to_insert = array(
					'help_content' => $row->help_content,
					'job_id' => $row->job_id,
					'project_id' => $cur_project_id
				);
				array_push($return->files_copied,$data_to_insert);
				$this->db->insert('help',$data_to_insert);
			}
		}
		
		echo json_encode($return);
	}
	
	public function copy_help() {
		$return = new stdClass;
		$return->cnt = 0;
		
		$project_id_to_copy = $_GET['project_id'];
		$job_id_to_copy = $_GET['job_id'];
		$cur_project_id = $_GET['cur_project_id'];
		
		$this->db->select('help_content');
		$this->db->where('job_id',$job_id_to_copy);
		$this->db->where('project_id',$project_id_to_copy);
		$query = $this->db->get('help');
		
		if($query->num_rows > 0) {
			foreach($query->result() as $row) {
				$return->cnt++;
				$data_to_insert = array(
					'help_content' => $row->help_content,
					'job_id' => $job_id_to_copy,
					'project_id' => $cur_project_id
				);
				$this->db->insert('help',$data_to_insert);
			}
		}
		
		echo json_encode($return);
	}
	
	public function get_copyhelp_data() {
		$return = new stdClass;
		$return->jobs = array();
		$return->projects = array();
		
		$this->db->select('id,job_name');
		$this->db->order_by('job_name');
		$query = $this->db->get('jobs');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				array_push($return->jobs,$row);
			}
		}
		
		$this->db->select('id,project_name');
		$this->db->order_by('project_name');
		$query = $this->db->get_where('projects',array('hidden'=>0));
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				array_push($return->projects,$row);
			}
		}

		echo json_encode($return);
	}
	
	public function save_help() {
		$return = new stdClass;
		$data = $_POST['data_to_send'];
		
		$sql_data = array(
			'job_id' => $data['job_id'],
			'project_id' => $data['project_id'],
			'help_content' => $data['msg_body']
		);
		
		if ($data['help_id'] == "-1") {
			$this->db->insert('help',$sql_data);
		} else {
			$this->db->where('id',$data['help_id']);
			$this->db->update('help',$sql_data);
		}
		
		$return->data = $data;
		echo json_encode($return);
	}

	
	
}
