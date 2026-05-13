{include file='header.tpl'}
{literal}
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css" media="all">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .activ_column {
        background-color: #7ac18a;
        color: white !important;
    }

    .activ_column a {
        /*background-color: #54B435;*/
        color: #FFF !important;
        /*text-shadow: 0 0 3px #FFFF;*/
        text-decoration: underline #1C82AD;
    }

    a {
        color: blue;
        text-decoration: none;
    }

    .icon {
        font-size: 60px;
        margin-bottom: 20px;
    }

    .icon,
    h5 {
        color: #fff;
    }

    .card {
        min-height: 176px;
    }



    .bounce:hover {
        -webkit-animation-name: bounce;
        -moz-animation-name: bounce;
        -o-animation-name: bounce;
        animation-name: bounce;
        animation-duration: 1s;
        animation-timing-function: ease-in-out;
        animation-delay: 0s;
        animation-direction: alternate;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
            opacity: 1;
        }

        40% {
            transform: translateY(-20px);
        }

        60% {
            transform: translateY(-10px);
        }
    }

</style>


{/literal}




<div class="boxed">
    <div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
        <h4>Reports</h4>
        <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
    </div>


    <div class="row">
{if $user_type eq 'U' }
        <div class="col-md-3 mb-3 bounce">
            <a href="rep_comp_dept_abs_comp.php" target="_blank">
                <div class="card bg-primary text-center">
                    <div class="card-body p-4">
                        <i class="fa fa-file-alt icon"></i>
                        <h5>Deptwise Complaints Report</h5>
                    </div>
                </div>
            </a>
        </div>


      

       <div class="col-md-3 mb-3 bounce">
            <a href="ward_wise_abstract.php" target="_blank">
            <div class="card bg-primary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Zone Wise Abstract</h5>
                </div>
            </div>
            </a>    
        </div>

        <div class="col-md-3 mb-3 bounce">
            <a href="all_empwise_report_new.php" target="_blank">
            <div class="card bg-primary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Employee Wise Pending Report</h5>
                </div>
            </div>
            </a>    
        </div>


		<div class="col-md-3 mb-3 bounce">
            <a href="details_of_completed_grievance_report.php"  target="_blank">
            <div class="card bg-primary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Remark/Rating Report on Completed Grievances</h5>
                </div>
            </div>
            </a>    
        </div>


		<div class="col-md-3 mb-3 bounce">
            <a href="employee_rating_report.php"  target="_blank">
            <div class="card bg-primary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Employee Rating Report</h5>
                </div>
            </div>
            </a>    
        </div>


        <div class="col-md-3 mb-3 bounce">
            <a href="escaleted_grievance_rep.php" target="_blank">
            <div class="card bg-primary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Escalated Grievance Report</h5>
                </div>
            </div>
            </a>    
        </div>

		<div class="col-md-3 mb-3 bounce">
            <a href="complaint_wise_rep.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Complaint Wise Report</h5>
                </div>
            </div>
            </a>    
        </div>

        <div class="col-md-3 mb-3 bounce">
            <a href="complaints_sla.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Complaint Disposable Days</h5>
                </div>
            </div>
                </a>
        </div>

        <div class="col-md-3 mb-3 bounce">
            <a href="complaints_rating.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Citizen Feedback Department wise and category wise</h5>
                </div>
            </div>
            </a>    
        </div>

        <div class="col-md-3 mb-3 bounce">
            <a href="ulb_comp_resp_rep.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Complaints Response Report</h5>
                </div>
            </div>
                </a>
        </div>

 
        <div class="col-md-3 mb-3 bounce">
            <a href="search_complaint.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Search Complaint</h5>
                </div>
            </div>
            </a>    
        </div>

        <div class="col-md-3 mb-3 bounce">
            <a href="cat_max_comp_resolved_rep.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Category Max Grievance Resolved</h5>
                </div>
            </div>
            </a>    
        </div>

        <div class="col-md-3 mb-3 bounce">
            <a href="grievance_pending_rep.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Grievance Pending Report</h5>
                </div>
            </div>
            </a>    
        </div>

        <div class="col-md-3 mb-3 bounce">
            <a href="top_greivanes_received.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Top 10 Grievances (Grievance Type & zone wise)</h5>
                </div>
            </div>
            </a>    
        </div>

        <div class="col-md-3 mb-3 bounce">
            <a href="citizen_feedback_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Citizen Feedback Report</h5>
                </div>
            </div>
            </a>    
        </div>

        <div class="col-md-3 mb-3 bounce">
            <a href="dept_pendancy_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Department wise pendency report</h5>
                </div>
            </div>
            </a>    
        </div>

        <div class="col-md-3 mb-3 bounce">
            <a href="grievance_month_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Pending Grievances &#60; 7 and &#62; 30</h5>
                </div>
            </div>
            </a>    
        </div>

        <div class="col-md-3 mb-3 bounce">
            <a href="grievance_sla_anlysis_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Complaints SLA Analysis Report</h5>
                </div>
            </div>
            </a>    
        </div>

        <div class="col-md-3 mb-3 bounce">
            <a href="grievance_analysis_dept_zone.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Grievance Analysis Department Zone Wise</h5>
                </div>
            </div>
            </a>    
        </div>

        <div class="col-md-3 mb-3 bounce">
            <a href="grievance_resolved_percent.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Resolved Grievances %</h5>
                </div>
            </div>
            </a>    
        </div>
		
		 <div class="col-md-3 mb-3 bounce">
            <a href="all_empwise_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Employee Wise Report</h5>
                </div>
            </div>
            </a>    
        </div>

	
		<div class="col-md-3 mb-3 bounce">
            <a href="designation_wise_abstract.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Designation Wise Abstract Report</h5>
                </div>
            </div>
            </a>    
        </div>


		<div class="col-md-3 mb-3 bounce" hidden>
            <a href="track_of_emp_wise_total_recieved_grievance_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Track of Employee Wise Recieved Grievance Report</h5>
                </div>
            </div>
            </a>    
        </div>

		<div class="col-md-3 mb-3 bounce" hidden>
            <a href="track_of_emp_wise_total_resolved_grievance_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Track of Employee Wise Resolved Grievance Report</h5>
                </div>
            </div>
            </a>    
        </div>
		<div class="col-md-3 mb-3 bounce" hidden>
            <a href="track_of_emp_wise_total_pending_grievance_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Track of Employee Wise Pending Grievance Report</h5>
                </div>
            </div>
            </a>    
        </div>

		<div class="col-md-3 mb-3 bounce" hidden>
            <a href="track_of_emp_wise_transfered_grievance_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Track of Employee Wise Transfered Grievance Report</h5>
                </div>
            </div>
            </a>    
        </div>


		<div class="col-md-3 mb-3 bounce" hidden>
            <a href="track_of_dept_wise_total_recieved_grievance_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Track of Department Wise Recieved Grievance Report</h5>
                </div>
            </div>
            </a>    
        </div>


		<div class="col-md-3 mb-3 bounce" hidden>
            <a href="track_of_dept_wise_total_resolved_grievance_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Track of Department Wise Resolved Grievance Report</h5>
                </div>
            </div>
            </a>    
        </div>


		<div class="col-md-3 mb-3 bounce" hidden>
            <a href="track_of_dept_wise_total_pending_grievance_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Track of Department Wise Pending Grievance Report</h5>
                </div>
            </div>
            </a>    
        </div>


		<div class="col-md-3 mb-3 bounce" hidden>
            <a href="track_of_dept_wise_total_transfered_grievance_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Track of Department Wise Transfered Grievance Report</h5>
                </div>
            </div>
            </a>    
        </div>



		<div class="col-md-3 mb-3 bounce" hidden>
            <a href="emp_warning_sms_recieved_grievance_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Employee Warning SMS Recieved Grievance Report</h5>
                </div>
            </div>
            </a>    
        </div>




		<div class="col-md-3 mb-3 bounce" hidden>
            <a href="emp_showcause_sms_recieved_grievance_report.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Employee Showcause SMS Recieved Grievance Report</h5>
                </div>
            </div>
            </a>    
        </div>
{/if}


<!-- ************************** Employee Category 1 *********************************** -->


{if ($smarty.session.user_type eq 'E' && $smarty.session.hod_status eq 1) || ($smarty.session.user_type eq 'E' && $smarty.session.hod_status2 eq 1)}
       
	   <div class="col-md-3 mb-3 bounce">
            <a href="rep_comp_dept_abs_comp.php" target="_blank">
                <div class="card bg-primary text-center">
                    <div class="card-body p-4">
                        <i class="fa fa-file-alt icon"></i>
                        <h5>Deptwise Complaints Report</h5>
                    </div>
                </div>
            </a>
        </div>


      

       <div class="col-md-3 mb-3 bounce">
            <a href="ward_wise_abstract.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Zone Wise Abstract</h5>
                </div>
            </div>
            </a>    
        </div>

       

        <div class="col-md-3 mb-3 bounce">
            <a href="escaleted_grievance_rep.php" target="_blank">
            <div class="card bg-primary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Escalated Grievance Report</h5>
                </div>
            </div>
            </a>    
        </div>


        <div class="col-md-3 mb-3 bounce">
            <a href="emp_complaints_sla.php" target="_blank">
            <div class="card bg-secondary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Complaint Disposable Days</h5>
                </div>
            </div>
            </a>
        </div>

       
{/if}

<!-- ************************** Employee Category 2 *********************************** -->

{if ($smarty.session.user_type eq 'E') && ($smarty.session.user_type eq 'E' && $smarty.session.hod_status eq 0) || ($smarty.session.user_type eq 'E' && $smarty.session.hod_status2 eq 0)}
		<div class="col-md-3 mb-3 bounce">
            <a href="details_of_completed_grievance_report.php"  target="_blank">
            <div class="card bg-primary text-center">
                <div class="card-body p-4">
                    <i class="fa fa-file-alt icon"></i>
                    <h5>Details of Completed Grievance Report</h5>
                </div>
            </div>
            </a>    
        </div>

{/if}


    </div>




    <div style="background-image:url(images/search_bg_2.jpg); height:28px;"></div>
    {include file='footer.tpl'}


    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script>
        $(function() {
            $(".datepicker").datepicker({
                changeMonth: true,
                changeYear: true
            });
        });

    </script>
