<?php

class Jobmodel extends CI_Model {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function get_job_list() {
		$this->db->select("*");
		$query = $this->db->get('jobs');
		return $query->result();
	}
	
}

?>