<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ww extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->data = array();
		$this->data['currentUser'] = $this->session->userdata('currentUser');
		$this->data['currentUserID'] = $this->session->userdata('currentUserID');
		$this->data['admin_mode'] = $this->session->userdata('admin_mode');
	}
	
	public function index()
	{
		redirect("/ww/userselect");
	}

    public function phpinfo()
    {
        echo phpinfo();
    }

    public function docs() {
        $this->data['pageTitle'] = 'WebFlow Docs';
        $this->load->view('header',$this->data);
        $this->load->view('titlebar',$this->data);
        $this->load->view('docs',$this->data);
        $this->load->view('footer',$this->data);
    }
	
	public function userselect() {
		$this->session->unset_userdata('admin_mode');
		
		$this->load->model("usermodel");
		$this->data['users'] = $this->usermodel->getUserData();
		
		$currentUserID = $this->session->userdata('currentUserID');
		if ($currentUserID) {
			$this->session->unset_userdata('currentUser');
			$this->session->unset_userdata('currentUserID');
			$this->data['currentUser'] = false;
			$this->data['currentUserID'] = false;
		}
		
		$this->data['pageTitle'] = 'WebFlow - Select User';
		$this->load->view('header',$this->data);
		$this->load->view('titlebar',$this->data);
		$this->load->view('userselect',$this->data);
		$this->load->view('footer',$this->data);
	}
	
	public function userdash() {

		if (!$this->data['currentUserID']) {redirect("/ww/userselect");}
		
		$this->load->model("usermodel");
		$this->load->model("groupmodel");
		$this->load->model("jobmodel");
		$this->load->model("projectmodel");
		$this->data['status_info'] = $this->usermodel->getUserData($this->data['currentUserID']);
		$this->data['user_list'] = json_encode($this->usermodel->get_users_list());
		$this->data['group_list'] = json_encode($this->groupmodel->get_groups_list());
		$this->data['job_list'] = json_encode($this->jobmodel->get_job_list());
		$this->data['project_list'] = json_encode($this->projectmodel->get_project_list());
		$this->data['group_members'] = json_encode($this->groupmodel->get_group_members());
		
		$this->data['pageTitle'] = 'WebFlow - User Dashboard';
		$this->load->view('header',$this->data);
		$this->load->view('titlebar',$this->data);
		$this->load->view('sideMenu_user',$this->data);
		$this->load->view('userdash',$this->data);
		$this->load->view('footer',$this->data);
	}
	
	public function admindash() {

		if ($this->data['admin_mode']!=true) {redirect("/ww/userselect");}
		
		$this->data['pageTitle'] = 'WebFlow - Admin Dashboard';
		
		$this->load->model("groupmodel");
		$this->load->model("usermodel");
        $this->load->model("jobmodel");
        $this->load->model("projectmodel");
        $this->load->model("timemodel");

		$this->data['groups'] = $this->groupmodel->get_groups_list();
		$this->data['users'] = $this->usermodel->get_users_list();
        $this->data['job_list'] = json_encode($this->jobmodel->get_job_list());
        $this->data['project_list'] = $this->projectmodel->get_project_list();
		$this->data['pay_periods'] = $this->timemodel->getPayPeriods();
		
		if (isset($_GET['pane'])) {			
			$this->data['cur_pane'] = $_GET['pane'];
		} else {
			$this->data['cur_pane'] = "button_general";
		}

		$this->load->view('header',$this->data);
		$this->load->view('titlebar',$this->data);
		$this->load->view('sideMenu_admin',$this->data);
		$this->load->view('admindash',$this->data);
		$this->load->view('footer',$this->data);
	}

}
