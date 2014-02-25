<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->data = array();
		$this->data['admin_mode'] = $this->session->userdata('admin_mode');
	}
	
	public function index()
	{
		redirect("/ww/userselect");
	}

    function project()
    {
        $project_id = $_GET['project_id'];

        //get report data
        $this->load->model('reportmodel');
        $report_data = $this->reportmodel->project_report($project_id);

        //get report logs
        $this->db->select('
            logs.id,
            logs.user_id,
            logs.job_id,
            logs.box_id,
            logs.log_start,
            logs.log_stop,
            users.user_name,
            boxes.box_name,
            jobs.job_name
        ');
        $this->db->where('logs.project_id',$project_id);
        $this->db->join('users','logs.user_id = users.id','left');
        $this->db->join('boxes','logs.box_id = boxes.id','left');
        $this->db->join('jobs','logs.job_id = jobs.id','left');
        $this->db->order_by('boxes.box_name');
        $report_logs = $this->db->get('logs')->result();
        $report_data['report_logs'] = $report_logs;

        $report_jobs = array();

        //setup containers for unique jobs
        foreach($report_logs as $report_log) {
            $report_jobs[$report_log->job_name] = new stdClass();
            $report_jobs[$report_log->job_name]->boxes = array();
            $report_jobs[$report_log->job_name]->total_seconds = 0;
            $report_jobs[$report_log->job_name]->job_name = $report_log->job_name;
        }

        //gather add the meat to the containers
        foreach($report_logs as $report_log) {

            //how many seconds did this log take?
            $num_seconds = strtotime($report_log->log_stop) - strtotime($report_log->log_start);

            //add total seconds to job
            $report_jobs[$report_log->job_name]->total_seconds += $num_seconds;

            //add info to data structure
            if(array_key_exists(
                    $report_log->box_name,
                    $report_jobs[$report_log->job_name]->boxes)) {
                //The box_name for this log exists in report_jobs

                //add seconds of this log to [report_jobs > box_name > num_seconds]
                $report_jobs[$report_log->job_name]->boxes[$report_log->box_name]->num_seconds += $num_seconds;

                //add seconds of log to user
                if (array_key_exists(
                    $report_log->user_name,
                    $report_jobs[$report_log->job_name]->boxes[$report_log->box_name]->users)) {
                    //the user_name for this box already exists

                    //add seconds of this log to [report_jobs > box_name  > user_name > num_seconds]
                    $report_jobs[$report_log->job_name]->boxes[$report_log->box_name]->users[$report_log->user_name] += $num_seconds;
                } else {
                    $report_jobs[$report_log->job_name]->boxes[$report_log->box_name]->users[$report_log->user_name] = $num_seconds;
                }


            } else {

                //the_box name doesn't exist, create skeleton for this box
                $report_jobs[$report_log->job_name]->boxes[$report_log->box_name] = new stdClass();
                $report_jobs[$report_log->job_name]->boxes[$report_log->box_name]->num_seconds = $num_seconds; // total by box
                $report_jobs[$report_log->job_name]->boxes[$report_log->box_name]->users = array();
                $report_jobs[$report_log->job_name]->boxes[$report_log->box_name]->users[$report_log->user_name] = $num_seconds; // toal by user
                $report_jobs[$report_log->job_name]->boxes[$report_log->box_name]->box_name = $report_log->box_name;

            }
        }


        $report_data['report_jobs'] = $report_jobs;

        //generate gchart
        $this->load->library('gcharts');
        $this->gcharts->load('PieChart');

        $this->gcharts->DataTable('ProjectByJob')
            ->addColumn('string', 'Job', 'job')
            ->addColumn('string', 'Time (H)', 'hours');

        foreach ($report_jobs as $report_job) {
            $this->gcharts->DataTable('ProjectByJob')->addRow(array($report_job->job_name, round($report_job->total_seconds/3600,2)));
        }


        $config = array(
            'title' => '',
            'is3D' => TRUE
        );

        $this->gcharts->PieChart('ProjectByJob')->setConfig($config);

        //output
        $this->load->view('reports/project',$report_data);
    }

    public function payroll() {
        if ($this->data['admin_mode']!=true) {return;}

        //obtain pay period info
        $pps = $_GET['pps'];
        $ppe = $_GET['ppe'];

        //choose a filename
        $filename = 'Payroll '.date('M j, Y',$pps).' - '.date('M j, Y',$ppe).'.pdf';

        //get report data
        $this->load->model('reportmodel');
        $report_data = $this->reportmodel->payroll_report($pps,$ppe);
        $html = $this->load->view('reports/payroll',$report_data,true);

        //generate report
        $this->load->library('html_to_pdf');
        $this->html_to_pdf->view_pdf_from_html($filename,$html);
    }

    public function userhoursbyweek() {
        if ($this->data['admin_mode']!=true) {return;}

        //obtain pay period info
        $pps = $_GET['pps'];
        $ppe = $_GET['ppe'];

        //choose a filename
        $filename = 'Payroll '.date('M j, Y',$pps).' - '.date('M j, Y',$ppe).'.pdf';

        //get report data
        $this->load->model('reportmodel');
        $report_data = $this->reportmodel->payroll_report($pps,$ppe);
        $html = $this->load->view('reports/payroll',$report_data,true);

        //generate report
        $this->load->library('html_to_pdf');
        $this->html_to_pdf->view_pdf_from_html($filename,$html);
    }

}
