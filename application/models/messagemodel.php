<?php

class Messagemodel extends CI_Model {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function get_user_messages($user_id) {
		$return = array();
		$this->db->select('id,from_id,message_sent,message_content,message_read');
		$this->db->order_by('message_read');
		$this->db->order_by('message_sent',"desc");
		$query = $this->db->get_where('messages',array('user_id'=>$user_id));
		
		$return = $query->result();
		
		if (count($return) > 0) {
			foreach ($return as $row) {
				$row->pretty_time = date("n/j/y g:ia",strtotime($row->message_sent));	
			}
		}
		
		return $return;
	}
	
}

?>