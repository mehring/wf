<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_task extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->data = array();
		$this->data['currentUser'] = $this->session->userdata('currentUser');
		$this->data['currentUserID'] = $this->session->userdata('currentUserID');
	}
	
	public function get_admin_tasks_list() {
        if (isset($_GET['job_id'])) {
            $job_id = $_GET['job_id'];
        } else {
            $job_id = '';
        }

        if (isset($_GET['project_id'])) {
            $project_id = $_GET['project_id'];
        } else {
            $project_id = '';
        }

        //get $task_members
        $this->db->select('*,users.user_name,groups.group_name');
        $this->db->join('users','users.id = task-members.user_id','left');
        $this->db->join('groups','groups.id = task-members.group_id','left');
        $task_members = $this->db->get('task-members')->result();

		$this->load->model("usermodel");
		$this->db->select('tasks.id,job_name,project_name,priority');
		$this->db->join('jobs','jobs.id = tasks.job_id', 'left');
		$this->db->join('projects','projects.id = tasks.project_id', 'left');
		$this->db->order_by('priority','desc');
		
		if($job_id <> -1) {
			$this->db->where('tasks.job_id',$job_id);
		}
		
		if($project_id <> -1) {
			$this->db->where('tasks.project_id',$project_id);
		}
		
		$query = $this->db->get('tasks');
		
		echo("<table class=\"table hover_table solid_table table-condensed\" style=\"margin-top:15px;\">
    
				<thead><tr>
					<th style=\"width:20px;\"></th>
					<th>Priority</th>
					<th style=\"max-width: 200px;\">Assigned</th>
					<th>Job</th>
					<th>Project</th>
					<th style=\"min-width: 175px;\">Actions</th>
				</tr></thead>
				
				<tbody>");
		
		foreach ($query->result() as $row) {
		
			echo("  	<tr class=\"task_row\" itemID=".$row->id.">
							<td><img src=".base_url("assets/img/ui/icons/tasks.png")." /></td>");
			
			
			switch($row->priority) {
				case 0:
					$priority_text = "<span class=\"label\">None</span>";
					break;
				case 1:
					$priority_text = "<span class=\"label label-success\">Low</span>";
					break;
				case 2:
					$priority_text = "<span class=\"label label-warning\">High</span>";
					break;
				case 3:
					$priority_text = "<span class=\"label label-important\">Critical</span>";
					break;
			}


            echo("  	    <td>".$priority_text."</td>
                            <td>");

            foreach($task_members as $task_member) {
                if ($task_member->task_id == $row->id) {

                    if($task_member->user_name) {
                        echo "<span class=\"label label-info\" style=\"display:inline-block; margin-right:5px;\">".$task_member->user_name."</span>";
                    }

                    if($task_member->group_name) {
                        echo "<span class=\"label label-inverse\" style=\"display:inline-block; margin-right:5px;\">".$task_member->group_name."</span>";
                    }

                }

            }

            echo("</td>
                            <td>".$row->job_name."</td>
							<td>".$row->project_name."</td>
							<td>

							  <a class=\"admin_button black button_admin_modify_task\" style=\"color:black;\" itemID=".$row->id."><span class=\"ico-edit icon-white\"></span>&nbsp;Modify</a>
							  <a class=\"admin_button red button_admin_delete_task\" style=\"color:red;\" itemID=".$row->id."><span class=\"ico-trash icon-white\"></span>&nbsp;Delete</a>

							</td>
						</tr>");
		}
		
		echo("	</tbody>
			
			</table>");
	}
	
	public function add_task() {//FINISH ME - return new task ID, if error, return 0
		
	}
	
	public function delete_task() {
		$taskID_to_delete = $_POST['taskID_to_delete'];
        $this->db->where('id',$taskID_to_delete);
        $this->db->delete('tasks');
        $this->db->where('task_id',$taskID_to_delete);
        $this->db->delete('task-members');
	}
	
	public function modTask_get_task_info() {
		$taskID = $_POST['taskID_to_get'];
		$return = new stdClass;
		
		$return->jobs = array();
		$this->db->select('id,job_name');
		$this->db->order_by('job_name');
		$query = $this->db->get('jobs');
		foreach ($query->result() as $row) {
			array_push($return->jobs,$row);
		}
		
		$return->projects = array();
		$this->db->select('id,project_name');
		$this->db->order_by('project_name');
		$query = $this->db->get_where('projects',array('hidden'=>0));
		foreach ($query->result() as $row) {
			array_push($return->projects,$row);
		}
		
		$return->job_id = -1;
		$return->project_id = -1;
		$return->priority = -1;
		if ($taskID != -1) {
			$this->db->where('id',$taskID);
			$this->db->select('job_id,project_id,priority');
			$query = $this->db->get('tasks');
			foreach ($query->result() as $row) {
				$return->job_id = $row->job_id;
				$return->project_id = $row->project_id;
				$return->priority = $row->priority;
			}
		}
		
		$return->task_members = array();
		$this->db->select('user_id,group_id');
		$query = $this->db->get_where('task-members',array('task_id'=>$taskID));
		foreach ($query->result() as $row) {
			array_push($return->task_members,$row);
		}
		
		echo json_encode($return);
	}
	
	public function modTask_save_task() {
		$assigned_id = $_POST['assigned_id'];
		
		if (isset($_POST['assigned_users'])) {
			$assigned_users = $_POST['assigned_users'];
		} else {
			$assigned_users = array();
		}
		
		if (isset($_POST['assigned_groups'])) {
			$assigned_groups = $_POST['assigned_groups'];
		} else {
			$assigned_groups = array();
		}
		
		$assigned_job = $_POST['assigned_job'];
		$assigned_project = $_POST['assigned_project'];
		$assigned_priority = $_POST['assigned_priority'];
		
		$data = array(
			'job_id' => $assigned_job,
			'project_id' => $assigned_project,
			'priority' => $assigned_priority
		);
		
		if ($assigned_id == -1) {
			$this->db->insert('tasks',$data);
			$assigned_id = $this->db->insert_id();
		} else {
			$this->db->where('id', $assigned_id);
			$this->db->update('tasks', $data); 
		}
		
		$this->db->delete('task-members',array('task_id'=>$assigned_id));	
		
		foreach ($assigned_users as $assigned_user) {
			$data = array(
				'task_id' => $assigned_id,
				'user_id' => $assigned_user
			);
			$this->db->insert('task-members',$data);
		}
		
		foreach ($assigned_groups as $assigned_group) {
			$data = array(
				'task_id' => $assigned_id,
				'group_id' => $assigned_group
			);
			$this->db->insert('task-members',$data);
		}
		
	}
	
	public function get_filters_html() {
		
		$this->db->select('id,job_name');
		$this->db->order_by('job_name','asc');
		$query = $this->db->get('jobs');
		$jobs = $query->result();
		
		$this->db->select('id,project_name');
		$this->db->order_by('project_name','asc');
		$query = $this->db->get_where('projects',array('hidden'=>0));
		$projects = $query->result();

		echo("<span class=\"custom_select_label\">
				Showing tasks for</span><br />
				<select class=\"custom_select tasks_jobSelector\" style=\"width:49%;display:inline-block;float:left;\">");
		echo("		<option class=\"tasks_jobSelector\" value=\"-1\">All Jobs</option>");
		
		foreach ($jobs as $row) {
    		echo("		<option class=\"tasks_jobSelector\" item_id=\"".$row->id."\" value=\"".$row->id."\">".$row->job_name."</option>");
		}

		echo("	</select>");

		echo("<select class=\"custom_select tasks_projectSelector\" style=\"width:49%;display:inline-block;float:left;\">
				<option class=\"tasks_projectSelector\" value=\"-1\">All Projects</option>");
		
		foreach ($projects as $row) {
    		echo("		<option class=\"tasks_projectSelector\" item_id=\"".$row->id."\" value=\"".$row->id."\">".$row->project_name."</option>");
		}
		
    	echo("	</select><div style=\"clear:both;\"></div>");

	}

}
