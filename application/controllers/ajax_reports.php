<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_reports extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->data = array();
	}

    function set_user_payroll()
    {
        $return = new stdClass;
        $user_id = $_GET['user_id'];
        $checked = $_GET['checked'];

        $return->user_id = $user_id;
        $return->checked = $checked;

        $this->db->where('id',$user_id);
        if($checked == 'true') {
            $data = array('payroll'=>1);
        } else {
            $data = array('payroll'=>0);
        }
        $this->db->update('users',$data);

        echo json_encode($return);
    }

    function get_payroll_html()
    {
        $return = new stdClass;
        $pps = $_GET['pps'];
        $ppe = $_GET['ppe'];

        //get report data
        $this->load->model('reportmodel');
        $report_data = $this->reportmodel->payroll_report($pps,$ppe);
        $return->html = $this->load->view('reports/payroll',$report_data,true);

        echo json_encode($return);
    }

    function get_userhoursbyweek_html()
    {
        $return = new stdClass;
        $pps = $_GET['pps'];
        $ppe = $_GET['ppe'];

        //get report data
        $this->load->model('reportmodel');
        $report_data = $this->reportmodel->userhoursbyweek_report($pps,$ppe);
        $return->html = $this->load->view('reports/userHoursByWeek',$report_data,true);

        echo json_encode($return);
    }


	
}
