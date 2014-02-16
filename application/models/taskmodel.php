<?php

class Taskmodel extends CI_Model {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function get_user_tasks($user_id) {
		$return = array();
		
		$this->db->select('group_id');
		$query = $this->db->get_where('group-members',array('user_id'=>$user_id));
		$user_groups = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) { array_push($user_groups,$row->group_id); }
		}
		
		$this->db->select('task_id');
		if (count($user_groups) > 0) {
			$this->db->where_in('group_id',$user_groups);
			$this->db->or_where('user_id',$user_id);
		} else {
			$this->db->where('user_id',$user_id);
		}
		
		$query = $this->db->get('task-members');
		$task_id_list = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) { array_push($task_id_list,$row->task_id); }
		}
		
		$return = array();
		if (count($task_id_list) > 0) {
			$this->db->select('id,job_id,project_id,priority');	
			$this->db->where_in('id',$task_id_list);		
			$this->db->order_by('priority',"desc");
			$query = $this->db->get('tasks');
			$return = $query->result();
		}
		
		return $return;
	}
	
}

?>