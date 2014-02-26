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
        $report_logs = $report_data['report_logs'];

        //setup containers for unique jobs
        $report_jobs = array();
        foreach($report_logs as $report_log) {
            $report_jobs[$report_log->job_name] = new stdClass();
            $report_jobs[$report_log->job_name]->boxes = array();
            $report_jobs[$report_log->job_name]->total_seconds = 0;
            $report_jobs[$report_log->job_name]->job_name = $report_log->job_name;
        }

        //gather add the meat to the containers
        $seconds_total = 0;
        foreach($report_logs as $report_log) {

            //how many seconds did this log take?
            $num_seconds = strtotime($report_log->log_stop) - strtotime($report_log->log_start);
            $seconds_total += $num_seconds;

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

        //get total number of sf/lf images
        $report_data['total_sf'] = 0;
        $report_data['total_lf'] = 0;
        foreach ($report_data['boxes'] as $box) {
            $report_data['total_sf'] += $box->sf;
            $report_data['total_lf'] += $box->lf;
        }

        //get number of boxes
        $report_data['num_boxes'] = count($report_data['boxes']);

        //get avg number of sf/lf images per box
        $report_data['avg_sf'] = $report_data['total_sf'] / $report_data['num_boxes'];
        $report_data['avg_lf'] = $report_data['total_lf'] / $report_data['num_boxes'];

        //calculate cost for sf/lf images and boxes
        $report_data['cost_sf'] = $report_data['project']->ppsf * $report_data['total_sf'];
        $report_data['cost_lf'] = $report_data['project']->pplf * $report_data['total_lf'];
        $report_data['cost_boxes'] = $report_data['project']->ppb * $report_data['num_boxes'];

        //calculate amount to bill
        $report_data['cost_total'] = $report_data['cost_sf'] + $report_data['cost_lf'] + $report_data['cost_boxes'];

        //calculate cost per hour (with $seconds_total)
        $report_data['cost_per_hour'] = round($report_data['cost_total'] / ($seconds_total/3600),2);

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
