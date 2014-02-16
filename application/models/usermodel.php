<?php

class Usermodel extends CI_Model {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function getPriorityText($priority) {
		switch ($priority) {
			case "1" : return "<span class=\"label label-success\">Very Low</span>";
			case "2" : return "<span class=\"label label-success\">Low</span>";
			case "3" : return "<span class=\"label label-warning\">Normal</span>";
			case "4" : return "<span class=\"label label-important\">High</span>";
			case "5" : return "<span class=\"label label-important\">Very High</span>";
			default : return "";
		}
	}
	
	function getUserData($id = -1) {
		$this->db->select('users.id,users.job_id,users.project_id,users.box_id,user_name,job_name,project_name,box_name,user_start');
		$this->db->from('users');
		$this->db->where(array('user_hidden'=>'0'));
		if ($id != -1) {
			$this->db->where(array('users.id'=>$id));
		}
		$this->db->join('jobs','jobs.id = users.job_id', 'left');
		$this->db->join('projects','projects.id = users.project_id', 'left');
		$this->db->join('boxes','boxes.id = users.box_id', 'left');
		$this->db->order_by('user_name','asc');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_users_list() {
		$this->db->select('id,user_name,payroll');
		$this->db->order_by('user_name');
		$this->db->where(array('user_hidden'=>'0'));
		$query = $this->db->get('users');
		return $query->result();
	}
	
}

?>