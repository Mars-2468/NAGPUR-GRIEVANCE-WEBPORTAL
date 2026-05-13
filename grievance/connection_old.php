<?php
	function getconnection()
	{
	   /* $ch = curl_init();
        $url = 'https://securedash.co/api/hacker/5df2346cbe638';
        $fields = array();
        $fields['post'] = $_POST; // Disable if you do not wnat to monitor
        $fields['get'] = $_GET;  // Disable if you do not wnat to monitor
        $fields['files'] = $_FILES;  // Disable if you do not wnat to monitor
        $fields['request'] = $_REQUEST;  // Disable if you do not wnat to monitor
        $fields['server'] = $_SERVER;  // Disable if you do not wnat to monitor
        $gofields = http_build_query($fields);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $gofields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
        $data = json_decode(curl_exec($ch),true);
        curl_close($ch);
        ////Redirect URL
        if($data['redirect']==true):
          header("Location: ".$data['redirectUrl']);
        endif;
        ///BLOCK MESSAGE
        if($data['block']==true):
          die($data['blockmessage']);
        endif;*/
		
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
   			 $link = "https";
		else
     		$link = "http";     

			$link .= "://";     

			$link .= $_SERVER['HTTP_HOST'];
 
	
			//echo "<pre>";print_r($link);echo "</pre>";die();

	    
        $conn= mysqli_connect("localhost", "root", "", 'nagpurnewcsms_live') or die(mysqli_connect_error());
	   
		/************************************ start session time out **************************************/
		//$session_timeout = 3600;// 1 hour    900 for 15mnts
		$session_timeout = 24*3600;// 1 day
		
		if (isset($_SESSION['last_activity'])) {
			// Calculate the time since the last activity
			$inactive_duration = time() - $_SESSION['last_activity'];
			
			// If inactive duration is greater than timeout, destroy the session
			if ($inactive_duration > $session_timeout) {
				
				$user_id=$_SESSION['user_id'];
				
				session_unset(); // Unset all session variables
				session_destroy(); // Destroy the session
				
				// Redirect to login page with a timeout message
				log_audit_trail($conn,$user_id, $action='logout', $details='Session timed out due to inactivity',$model='users',$record_id=$user_id,$old='login',$new='Auto logout');
				
				header("Location:" . $link . "/index.php?msg=Session timed out due to inactivity.");
				//header("Location: /?msg=Session timed out due to inactivity.");
				exit();
			}
		}	
		
		$_SESSION['logged_in'] = true;
		$_SESSION['last_activity'] = time();
		
		/************************************ end session time out **************************************/
		
		// warning and showcause notices related code
		
		$sql_date_adjust='UPDATE  show_case_response_logs sl LEFT JOIN grievances g ON g.grievance_id = sl.grievance_id SET sl.date_regd = g.date_regd';

		mysqli_query($conn, $sql_date_adjust);

		$sql_row_number=' UPDATE show_case_response_logs e JOIN ( SELECT warning_id, ROW_NUMBER() OVER (PARTITION BY emp_id ORDER BY date_regd) AS rn FROM show_case_response_logs)cte 
							ON cte.warning_id=e.warning_id 
							SET e.row_number = cte.rn ';

	   mysqli_query($conn, $sql_row_number);
	   
	
	
	
	/* query for dummy TABLE
	
		$sql="DROP TABLE IF EXISTS grievances_trns";
		mysqli_query($conn, $sql);
		
		$sql="CREATE TABLE grievances_trns as SELECT gt.* FROM grievances_transactions gt INNER JOIN ( SELECT grievance_id, MAX(transaction_id) AS latest_transaction_id FROM grievances_transactions GROUP BY grievance_id ) latest_gt ON gt.grievance_id = latest_gt.grievance_id AND gt.transaction_id = latest_gt.latest_transaction_id;";
		mysqli_query($conn, $sql);  */
		
		
		
	
		$_SESSION['grievances_trns']="(SELECT gts.* FROM grievances_transactions gts INNER JOIN ( SELECT grievance_id, MAX(transaction_id) AS latest_transaction_id FROM grievances_transactions GROUP BY grievance_id ) latest_gt ON gts.grievance_id = latest_gt.grievance_id AND gts.transaction_id = latest_gt.latest_transaction_id and gts.emp_id!='')";
		$_SESSION['threshold_date']="2024-09-01";
	
		return $conn;
	}
	

	function log_audit_trail($conn,$user_id, $action, $details = '',$model,$record_id,$old,$new)
	{
		//echo "<pre>";print_r($model);echo "</pre>";die();
		// Get the user's IP address
		$ip_address = $_SERVER['REMOTE_ADDR'];		
		$sql ="INSERT INTO audit_trails (user_id, action, action_time,details, ip_address,model,record_id,old,new) VALUES (?,?,?,?,?,?,?,?,?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sssssssss",$user_id,$action,date('Y-m-d h:m:s'),$details,$ip_address,$model,$record_id,$old,$new);						
		$stmt->execute();
		
		return null;
	}
