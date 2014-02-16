<?php

class Projectmodel extends CI_Model {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function get_project_list() {
		$this->db->select("*");
        $this->db->order_by('project_name');
		$query = $this->db->get_where('projects',array('hidden'=>0));
		return $query->result();
	}
	
}

?>