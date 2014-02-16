<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_message extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->data = array();
		$this->data['currentUser'] = $this->session->userdata('currentUser');
		$this->data['currentUserID'] = $this->session->userdata('currentUserID');
	}

    function get_message_count() {
        $user_id = $_GET['user_id'];
        $this->db->where(array(
            'user_id' => $user_id,
            'message_read' => 0
        ));
        echo $this->db->get('messages')->num_rows();
    }
	
	function mark_read() {
		$message_id = $_POST['cur_message_id'];
		$this->db->where("id",$message_id);
		$this->db->update("messages",array("message_read"=>1));
	}
	
	function delete_message() {
		$message_id = $_POST['cur_message_id'];
		$this->db->delete("messages",array("id"=>$message_id));
		$return = new stdClass;
		$return->fish = $message_id;
		echo json_encode($return);
	}
	
	function delete_message_all() {
		$this->db->delete("messages",array("user_id"=>$this->data['currentUserID'],"message_read"=>1));
	}
	
	function send_message() {
		$from_id = $_POST['msg_from'];
		$msg_to_groups = explode("|",$_POST['msg_to_groups']);		
		$msg_to_users = explode("|",$_POST['msg_to_users']);
		$message_content = $_POST['msg_body'];
		$users_to_send = array();
		$message_sent = date('Y-m-d H:i:s');
		
		foreach ($msg_to_users as $user) {
			array_push($users_to_send,$user);
		}
		
		foreach ($msg_to_groups as $group) {
			$this->db->select("user_id");
			$query = $this->db->get_where("group-members",array("group_id"=>$group));
			foreach ($query->result() as $row) {
				$found = false;
				foreach ($users_to_send as $user) {
					if ($user == $row->user_id) { $found = true ; break ; }
				}
				if (!$found) {
					array_push($users_to_send,$row->user_id);
				}
			}
		}

		foreach ($users_to_send as $user_id) {
			if($user_id) {
				$data = array(
					"user_id" => $user_id,
					"from_id" => $from_id,
					"message_sent" => $message_sent,
					"message_content" => $message_content,
					"message_read" => 0
				);
				$this->db->insert("messages",$data);
			}
		}

	}
	
}
