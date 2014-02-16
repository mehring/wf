<?php

class Timemodel extends CI_Model {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function getCleanTime($seconds) {
		$hours = 0;
		$minutes = 0;
		
		while($seconds >= 3600) {
			$hours++;
			$seconds -= 3600;
		}
		
		while($seconds >= 60) {
			$minutes++;
			$seconds -= 60;
		}
		
		return $hours . "h " . $minutes . "m";
	}
	
	function getPayrollTime($seconds) {
		$hours = $seconds / 3600;
		
		$dec_r = fmod($hours, 1);
		$dec_l = floor($hours);
		
		if ($dec_r >= 0 && $dec_r < 0.125) {
			$dec_r = 0;
		} else if ($dec_r >= 0.125 && $dec_r < 0.375) {
			$dec_r = 0.25;
		} else if ($dec_r >= 0.375 && $dec_r < 0.625) {
			$dec_r = 0.50;
		} else if ($dec_r >= 0.625 && $dec_r < 0.875) {
			$dec_r = 0.75;
		} else if ($dec_r >= 0.875 && $dec_r < 1) {
			$dec_r = 1.0;
		}
		
		$return_hours = round($dec_l + $dec_r,2);
		
		return $return_hours;
	}
	
	function convert_date_to_readable($date) {
		return date('n/j/y g:iA',strtotime($date));	
	}
	
	function getPayPeriodStart($offset = 0) {
		//need to back up 2 weeks from now, accounting for the offset
		$weeks_offset = ($offset * 2) - 2;
		
		if ($weeks_offset == 0) {
			$cur_time = time();
		} else if ($weeks_offset < 0) {
			$cur_time = strtotime(date('Y-m-d H:i:s') . ' ' . $weeks_offset . ' weeks');
		} else {
			$cur_time = strtotime(date('Y-m-d H:i:s') . ' +' . $weeks_offset . ' weeks');
		}

		//sets initial data
		$num_weeks = 0;
		$pay_period_start = strtotime('2009-12-21 00:00:00 +'.$num_weeks.' weeks');
		
		//adds 2 weeks until we are caught up
		while($pay_period_start < $cur_time) {
			$num_weeks += 2;
			$pay_period_start = strtotime('2009-12-21 00:00:00 +'.$num_weeks.' weeks');
		}

		return $pay_period_start;
	}
	
	function getPayPeriods() {
		$return = array();
		
		//get the last 12 pay periods
		for ($i=0;$i<120;$i++) {
			$pushme = new stdClass;
			$pushme->starts = $this->getPayPeriodStart(-$i);
			$pushme->ends = $this->getPayPeriodStart(-$i+1)-1;
			array_push($return,$pushme);
		}
		
		return $return;
	}

}

?>