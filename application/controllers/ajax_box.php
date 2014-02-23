<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_box extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->data = array();
		$this->data['currentUser'] = $this->session->userdata('currentUser');
		$this->data['currentUserID'] = $this->session->userdata('currentUserID');
	}
	
	public function addBox_submit() {
		$project_id = $_POST['project_id_to_add'];
		foreach ($_POST['boxes_list'] as $box_to_add) {
			$data = array(
			'project_id'=>$project_id,
			'box_name'=>$box_to_add,
			'box_status_id'=>1
			);
			$this->db->insert('boxes',$data);
		}
	}
	
	public function delete_box() {
		$box_id = $_POST['box_to_delete'];
		$this->db->where('id',$box_id);
		$this->db->delete('boxes');
	}
	
	public function rename_box() {
		$box_id = $_POST['box_to_change'];
		$new_name = $_POST['new_name'];
		$box_lf = $_POST['box_lf'];
		$box_sf = $_POST['box_sf'];
		$data = array(
			'box_name'=>$new_name,
			'sf'=>$box_sf,
			'lf'=>$box_lf
		);
		$this->db->where('id',$box_id);
		$this->db->update('boxes',$data);
	}
	
	public function change_box_status() {
		$box_id = $_POST['box_to_change'];
		$status_id = $_POST['status_to_change'];
		$data = array('box_status_id'=>$status_id);
		$this->db->where('id',$box_id);
		$this->db->update('boxes',$data);
	}
	
	public function get_admin_boxes_projectselector_list() {
		$this->db->select('id,project_name');
		$this->db->order_by('project_name','asc');
		$query = $this->db->get_where('projects',array('hidden'=>0));
		
		echo("<span class=\"custom_select_label\">
				Showing boxes for</span><br />
				<select class=\"custom_select boxes_projectSelector\" style=\"width:100%;\">");
		echo("		<option class=\"boxes_projectSelector\" item_id=\"-1\">Select One...</option>");
		
		foreach ($query->result() as $row) {
    		echo("		<option class=\"boxes_projectSelector\" item_id=\"".$row->id."\" value=\"".$row->id."\">".$row->project_name."</option>");
		}
		
    	echo("	</select>");
	}
	
	public function get_admin_help_projectselector_list() {
		$this->db->select('id,project_name');
		$this->db->order_by('project_name','asc');
		$query = $this->db->get_where('projects',array('hidden'=>0));
		
		echo("<span class=\"custom_select_label\">
				Show help for</span><br />
				<select class=\"custom_select help_projectSelector\" style=\"width:100%;\">");
		echo("		<option class=\"help_projectSelector\" value=\"-1\">Select One...</option>");
		
		foreach ($query->result() as $row) {
    		echo("		<option class=\"help_projectSelector\" value=\"".$row->id."\">".$row->project_name."</option>");
		}
		
    	echo("	</select>");
	}
	
	public function get_admin_boxes_list() {
		$itemsper = $_POST['itemsper'];
		$page = $_POST['page'];
		$offset = $itemsper * ($page-1);
		
		$return = new stdClass();
		$return->statuses = array();
		$return->boxes = array();
		$return->pages = 0;
		
		$this->db->select('id,box_status_name');
		//$this->db->order_by('box_status_name');
		$query = $this->db->get('box_status');
		foreach ($query->result() as $row) {
			array_push($return->statuses,array(
				'id'=>$row->id,
				'box_status_name'=>$row->box_status_name
			));
		}
		
		//$cnt = 0;
		$this->db->select('id');
		$query = $this->db->get_where('boxes',array('project_id'=>$_POST['project_selected']));
		//foreach ($query->result() as $row) { $cnt++; }
		//$return->boxes_total = $cnt;
		$return->boxes_total = $query->num_rows();
		
		$this->db->select('id,project_id,box_name,box_status_id,sf,lf');
		$this->db->order_by('box_name','asc');
		$query = $this->db->get_where('boxes',array('project_id'=>$_POST['project_selected']),$itemsper,$offset);
		foreach ($query->result() as $row) {
			$sf = 0 + $row->sf;
			$lf = 0 + $row->lf;
			array_push($return->boxes,array(
				'id'=>$row->id,
				'box_project_id'=>$row->project_id,
				'box_name'=>$row->box_name,
				'box_status_id'=>$row->box_status_id,
				'sf'=>$sf,
				'lf'=>$lf
			));
		}
		
		$output = array('output' => json_encode($return));
		$this->load->view('json', $output);

	}

	
	
}
