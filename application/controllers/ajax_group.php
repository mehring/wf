<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_group extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->data = array();
		$this->data['currentUser'] = $this->session->userdata('currentUser');
		$this->data['currentUserID'] = $this->session->userdata('currentUserID');
	}
	
	public function set_user_groups() {
		$return = new stdClass;
		$user_id = $_POST['cur_id'];
		$selected_groups = $_POST['selected_groups'];
		$return->selected_groups = $selected_groups;
		$this->db->delete('group-members', array('user_id' => $user_id));
		foreach ($selected_groups as $selected_group) {
			$data = array(
				"user_id" => $user_id,
				"group_id" => $selected_group
			);
			$this->db->insert('group-members', $data);
		}
		echo json_encode($return);
	}
	
	public function set_group_users() {
		$return = new stdClass;
		$group_id = $_POST['cur_id'];
		$selected_users = $_POST['selected_users'];
		$return->selected_users = $selected_users;
		$this->db->delete('group-members', array('group_id' => $group_id));
		foreach ($selected_users as $selected_user) {
			$data = array(
				"group_id" => $group_id,
				"user_id" => $selected_user
			);
			$this->db->insert('group-members', $data);
		}
		echo json_encode($return);
	}
	
	public function get_groups_list() {
		$user_id = $_POST['user_id'];
		$return = new stdClass;
		
		//get all group names
		$return->groups = array();
		$this->db->select('id,group_name');
		$this->db->order_by('group_name','asc');
		$query = $this->db->get('groups');
		foreach ($query->result() as $row) {
			array_push($return->groups,array(
				"id"=>$row->id,
				"group_name"=>$row->group_name
			));
		}
		
		//if a user id is supplied, grab the groups this user belongs to
		if($user_id) {
			$return->group_members = array();
			$this->db->select('group_id');
			$query = $this->db->get_where('group-members',array('user_id'=>$user_id));
			foreach ($query->result() as $row) {
				array_push($return->group_members,array(
					"group_id"=>$row->group_id
				));
			}
		}
		
		echo json_encode($return);
	}
	
	public function get_group_users_list() {
		$group_id = $_POST['group_id'];
		$return = new stdClass;
		
		//get all user names
		$return->users = array();
		$this->db->select('id,user_name');
		$this->db->order_by('user_name','asc');
		$query = $this->db->get_where('users',array('user_hidden'=>0));
		foreach ($query->result() as $row) {
			array_push($return->users,array(
				"id"=>$row->id,
				"user_name"=>$row->user_name
			));
		}
		
		//if a group id is supplied, grab the users for this group
		if($group_id) {
			$return->group_members = array();
			$this->db->select('user_id');
			$query = $this->db->get_where('group-members',array('group_id'=>$group_id));
			foreach ($query->result() as $row) {
				array_push($return->group_members,array(
					"user_id"=>$row->user_id
				));
			}
		}
		
		echo json_encode($return);
	}

	public function get_admin_groups_list() {
		$this->db->select('id,group_name');
		$this->db->order_by('group_name','asc');
		$query = $this->db->get('groups');
		
		echo("<table class=\"table hover_table solid_table table-condensed\" style=\"margin-top:15px;\">
    
				<thead><tr>
					<th>Group Name</th>
					<th>Actions</th>
				</tr></thead>
				
				<tbody>");
		
		foreach ($query->result() as $row) {
		
		echo("  	<tr class=\"group_row\" itemID=".$row->id.">
						<td><img src=".base_url("assets/img/ui/icons/group.png")." />&nbsp;".$row->group_name."</td>
						<td>
						  <a class=\"admin_button black button_admin_modify_group\" style=\"color:black;\" itemID=".$row->id." groupName=\"".$row->group_name."\"><span class=\"ico-edit\" style=\"position:relative;top:2px;\"></span> Rename</a>
						  <a class=\"admin_button blue button_admin_modify_group_users\" style=\"\" itemID=".$row->id." groupName=\"".$row->group_name."\"><span class=\"ico-user3\" style=\"position:relative;top:2px;\"></span> Users</a>
						  <a class=\"admin_button red button_admin_delete_group\" style=\"color:red\" itemID=".$row->id."><span class=\"ico-trash\" style=\"position:relative;top:2px;\"></span> Delete</a>
						</td>
					</tr>");
		}
		
		echo("	</tbody>
			
			</table>");
	}
	
	public function add_group() {
		$group_to_add = $_POST['group_to_add'];
		$id_to_set = $_POST['cur_groupid'];
		
		$this->db->select('group_name');
		$query = $this->db->get('groups');
		foreach ($query->result() as $row) {
			if (strtoupper($row->group_name) == strtoupper($group_to_add)) {
				echo("2");
				return;
			}
		}
		
		if ($id_to_set == -1) {
			//new group
			$data = array(
				'group_name'=>$group_to_add
			);
			$this->db->insert('groups',$data);
		} else {
			//renaming a current group
			$this->db->where('id',$id_to_set);
			$this->db->update('groups',array('group_name'=>$group_to_add));
		}
		
		echo("1");
	}
	
	public function delete_group() {
		$groupID_to_delete = $_POST['groupID_to_delete'];
		$this->db->where('id',$groupID_to_delete);
		$this->db->delete('groups');
		$this->db->where('group_id',$groupID_to_delete);
		$this->db->delete('group-members');
	}

	
	
}
