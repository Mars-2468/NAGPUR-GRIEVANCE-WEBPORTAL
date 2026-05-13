<?php
require "config.php";
error_reporting(0);
//session_regenerate_id();
require_once('get_services.php');
$obj = new get_services($_SESSION['uid']);
require_once('connection.php');
//include('prepare_connection.php');
$conn = getconnection();


// Capture date inputs from the form
$fdate = isset($_REQUEST['f_date']) ? $_REQUEST['f_date'] : '';
$tdate = isset($_REQUEST['t_date']) ? $_REQUEST['t_date'] : '';


	include('citizen_satisfaction_barchart.php');
	include('total_grievances_resolved_chart.php');
	include('feedback_average_rating_chart.php');
	include('feedback_received_chart.php');
	include('top10_grievances_deptwise.php');
	include('top10_grievances_zonewise_chart.php');
	//25-07-2024 include('top10_grievances_employeewise_chart.php');
	include('top10_best_employeewise_chart.php');
	include('top10_worst_employeewise_chart.php');
	include('grievance_statistics_chart.php'); 
?>