<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_job extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->data = array();
		$this->data['currentUser'] = $this->session->userdata('currentUser');
		$this->data['currentUserID'] = $this->session->userdata('currentUserID');
	}
	
	public function getJobsList() {
		$this->db->select('id, job_name');
		$this->db->from('jobs');
		$this->db->where('job_hidden',NULL);
		$this->db->order_by('job_name','asc');
		$query = $this->db->get();

		echo("<table class=\"table table-condensed\"><thead><tr><th>Job Name</th></tr></thead><tbody>");
		foreach($query->result() as $row) {
			echo("<tr itemID=\"".$row->id."\" item_name=\"".$row->job_name."\"><td>".$row->job_name."</td></tr>");
		}
		echo("</tbody></table>");
	}
	
	public function change_job_status() {
		$job_id = $_POST['job_to_change'];
		$status_id = $_POST['status_to_change'];
		$data = array('set_box_status_id'=>$status_id);
		$this->db->where('id',$job_id);
		$this->db->update('jobs',$data);
	}
	
	public function get_admin_jobs_list() {
		
		//get box statuses list
		$this->db->select('id,box_status_name');
		//$this->db->order_by('box_status_name');
		$box_statuses = $this->db->get('box_status')->result();
		
		$this->db->select('id,set_box_status_id,job_name');
		$this->db->order_by('job_name','asc');
		$query = $this->db->get_where('jobs',array('job_hidden'=>NULL));
		
		echo("<table class=\"table hover_table solid_table table-condensed\" style=\"margin-top:15px;\">
    
				<thead><tr>
					<th>Job Name</th>
					<th>Sets Box Status</th>
					<th>Actions</th>
				</tr></thead>
				
				<tbody>");
		
		foreach ($query->result() as $row) {
		
		$set_box_status_name = "No Change";
		foreach($box_statuses as $box_status) {
			if ($box_status->id == $row->set_box_status_id) {
				$set_box_status_name = $box_status->box_status_name;
			}
		}
		
		$box_status_html = "
		<ul class=\"nav nav-pills table_nav\" style=\"margin-bottom:0px;\">
			<li class=\"dropdown\">
				<a class=\"dropdown-toggle\" id=\"box_status_".$row->id."\" data-toggle=\"dropdown\" role=\"button\" href=\"#\" style=\"margin:0;\">".$set_box_status_name."&nbsp;<span class=\"caret\"></span></a>
				<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"box_status_".$row->id."\">";
		
		$box_status_html .="<li><a class=\"box_status_link\" job_id=\"".$row->id."\" status_id=\"-1\">No Change</a></li>";
		foreach($box_statuses as $box_status) {
			$box_status_html .="<li><a class=\"box_status_link\" job_id=\"".$row->id."\" status_id=\"".$box_status->id."\">".$box_status->box_status_name."</a></li>";
		}
		
		$box_status_html .="</ul></li></ul>";
		
		echo("  	<tr class=\"job_row\" itemID=".$row->id.">
						<td><img src=".base_url("assets/img/ui/icons/job.png")." />&nbsp;".$row->job_name."</td>
						<td>".$box_status_html."</td>
						<td>
							<a class=\"admin_button red button_admin_delete_job\" style=\"color:red;\" itemID=".$row->id."><span class=\"ico-trash icon-white\"></span>&nbsp;Delete</a>
						</td>
					</tr>");
		}
		
		echo("	</tbody>
			
			</table>");
	}
	
	public function add_job() {
		$job_to_add = $_POST['job_to_add'];
		
		$this->db->select('id,job_name');
		$query = $this->db->get('jobs');
		$found_id = -1;
		foreach ($query->result() as $row) {
			if (strtoupper($row->job_name) == strtoupper($job_to_add)) {
				$found_id = $row->id;
			}
		}
		
		if ($found_id == -1) {
			$data = array('job_name'=>$job_to_add);
			$this->db->insert('jobs',$data);
		} else {
			$data = array(
				'job_name'=>$job_to_add,
				'hidden'=>0
			);
			$this->db->where('id',$found_id);
			$this->db->update('jobs',$data);
		}
		
		echo("1");
	}
	
	public function delete_job() {
		$jobID_to_delete = $_POST['jobID_to_delete'];
		$this->db->where('id',$jobID_to_delete);
		$this->db->update('jobs',array('job_hidden'=>1));
	}

}
