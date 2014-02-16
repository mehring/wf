<?php

class Groupmodel extends CI_Model {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function get_groups_list() {
		$this->db->select('id,group_name');
		$this->db->order_by('group_name');
		$query = $this->db->get('groups');
		return $query->result();
	}
	
	function get_group_members() {
		$this->db->select('group_id,user_id');
		$query = $this->db->get('group-members');
		return $query->result();
	}
	
}

?>