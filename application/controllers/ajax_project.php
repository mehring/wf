<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_project extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->data = array();
		$this->data['currentUser'] = $this->session->userdata('currentUser');
		$this->data['currentUserID'] = $this->session->userdata('currentUserID');
	}
	
	public function get_admin_projects_list() {
		$this->db->select('id,project_name,project_received,pplf,ppsf,ppb');
		$this->db->order_by('project_name','asc');
		$this->db->where('hidden',0);
		$query = $this->db->get_where('projects',array('hidden'=>0));
		
		echo("<table class=\"table hover_table solid_table table-condensed\" style=\"margin-top:15px;\">
    
				<thead><tr>
					<th>Project Name</th>
					<th>Received</th>
					<th>Price / LF</th>
					<th>Price / SF</th>
					<th>Price / Box</th>
					<th>Actions</th>
				</tr></thead>
				
				<tbody>");
		
		foreach ($query->result() as $row) {
		
		$received_timestamp = strtotime($row->project_received);
		$date_clean = date("M j, Y",$received_timestamp);
		
		echo("  	<tr class=\"project_row\" itemID=".$row->id.">
						<td><img src=".base_url("assets/img/ui/icons/project.png")." />&nbsp;".$row->project_name."</td>
						<td>".$date_clean."</td>
						<td>".$row->pplf."</td>
						<td>".$row->ppsf."</td>
						<td>".$row->ppb."</td>
						<td>
						  <a class=\"admin_button black button_admin_modify_project\" style=\"color:black;\" 
						  	itemID=".$row->id." 
							project_name=\"".$row->project_name."\" 
							project_received=\"".$row->project_received."\"
							pplf=\"".$row->pplf."\"
							ppsf=\"".$row->ppsf."\"
							ppb=\"".$row->ppb."\"><span class=\"ico-edit\"></span>&nbsp;Modify</a>
						  <a class=\"admin_button red button_admin_delete_project\" style=\"color:red;\" itemID=".$row->id."><span class=\"ico-trash\"></span>&nbsp;Delete</a>
						</td>
					</tr>");
		}
		
		echo("	</tbody>
			
			</table>");
	}

	public function get_hidden_project_list() {
		$this->db->select('id,project_name');
		$this->db->order_by('project_name');
		$query = $this->db->get_where('projects',array('hidden'=>'1'));
		echo("<div style=\"overflow-y:auto; height:275px;\"><table class=\"table table-condensed\" style=\"margin-top:15px;\">");
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				echo("<tr itemID=\"".$row->id."\">
						<td><img src=".base_url("assets/img/ui/icons/project.png")." />&nbsp;".$row->project_name."<div class=\"hidden_project btn btn-primary btn-mini\" style=\"float:right;\" itemID=\"".$row->id."\"><i class=\"icon-share-alt icon-white\"></i>&nbsp;Undelete</div></td>
					  </tr>");
			}
		} else {
				echo("<tr>
						<td>There are no projects that can be undeleted.</td>
					  </tr>");
		}
		
		echo("</table></div>");
	}

	public function add_project() {
		$project_id = $_POST['project_id'];
		$project_to_add = $_POST['project_to_add'];
		$project_to_add_received = $_POST['project_to_add_received'];
		$pplf = $_POST['pplf'];
		$ppsf = $_POST['ppsf'];
		$ppb = $_POST['ppb'];

		$data = array(
			'project_name'=>$project_to_add,
			'project_received'=>$project_to_add_received,
			'pplf'=>$pplf,
			'ppsf'=>$ppsf,
			'ppb'=>$ppb
		);
		
		if ($project_id == -1) {
			$this->db->insert('projects',$data);
		} else {
			$this->db->where('id',$project_id);
			$this->db->update('projects',$data);
		}
		
		echo($this->db->insert_id());
	}
	
	public function delete_project() {
		$projectID_to_delete = $_POST['projectID_to_delete'];
		$this->db->where('id',$projectID_to_delete);
		$this->db->update('projects',array('hidden'=>1));
	}
	
	public function undelete_project() {
		$projectID_to_undelete = $_POST['projectID_to_undelete'];
		$this->db->where('id',$projectID_to_undelete);
		$this->db->update('projects',array('hidden'=>0));
	}
	
	public function get_help() {
		$project_id = $_POST['project_id'];
		$this->db->select('
			help.id,
			help.job_id,
			help.project_id,
			help.help_content,
			jobs.job_name
		');
		$this->db->from('help');
		$this->db->where('project_id',$project_id);
		$this->db->join('jobs','jobs.id = help.job_id');
		$query = $this->db->get();
		echo json_encode($query->result());
	}

}
