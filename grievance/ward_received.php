<?phprequire "config.php";
	ini_set('display_errors',1);
	date_default_timezone_set('Asia/Calcutta');
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	if(isset($_SESSION['uid']))
	{
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		/// In case of service 
		
	 	$aptid1=$_REQUEST['aptid'];
		$status1=$_REQUEST['status'];
		$ulbid1=$_SESSION['ulbid'];
		$user_type1=$_SESSION['user_type'];
		$sla1=$_REQUEST['sla'];
		
		
		
	    //if($_REQUEST['aptid']==1 && $_REQUEST['user_type']=='U')
	    //{
	        // User type U
	        if($_REQUEST['status']==0)
	        {
	            /*$sql ="SELECT *,disposed_date,DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,ccm.cutt_off_time as target_days,
	               DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date FROM grievances g,grievances_transactions gt,ulbmst u ,cs_mst c,
	               comp_cutofdays_map ccm where g.cat3_id=ccm.cs_id  and g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and 
	               g.ulbid='".$_SESSION['ulbid']."'";*/
	               
	                $sql ="SELECT g.*,gt.emp_id FROM grievances g,grievances_transactions gt ,ulbmst u ,cs_mst c where g.ulbid=u.ulbid and g.grievance_id=gt.grievance_id and
	                g.cat3_id=c.cs_id and app_type_id='1' and g.ulbid='".$_SESSION['ulbid']."'
	                and g.ward_id = '".$_REQUEST['ward_id']."' and g.cat3_id = '".$_REQUEST['cat_id']."' ";
	                
	                
	                if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
        		     
        		    
	                
	               
	            $query = "SELECT count(grievance_id) as num FROM grievances g,ulbmst u ,cs_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and 
	            g.ulbid='".$_SESSION['ulbid']."' and g.ward_id = '".$_REQUEST['ward_id']."' and g.cat3_id = '".$_REQUEST['cat_id']."' ";
	            
	                if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
	            
	            
	            
	        }
	        
	        
	        
	        
	        
	        
	       /* 
	        
	        
	        
	        
	        else if($_REQUEST['status']==1 && $_REQUEST['sla']==0)
	        {
	            $sql="select * from grievances where ulbid='".$_SESSION['ulbid']."' and grievance_status_id='1' and app_type_id='1'";
	             
                    if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
        
        	            $query="select count(grievance_id) as num from grievances g,cs_mst c,ulbmst u where 
        		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='1' and app_type_id='1'";
        		
        		
        		if(isset($_POST['search']))
        		{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		 }
        		
        	
	        }
	        else if($_REQUEST['status']==2 && $_REQUEST['sla']==1)
	        {
	       /*$sql="SELECT *,disposed_date,DATEDIFF(NOW(),date_regd)-ccm.cutt_off_time  AS no_of_days_exeed,ccm.cutt_off_time as target_days,
	               DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time DAY) as comp_date FROM grievances g,grievances_transactions gt ,cs_mst c,ulbmst u, 
	              comp_cutofdays_map ccm where g.cat3_id=ccm.cs_id  and g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1";
				 
				 $sql="SELECT g.*,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
				  g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and gt.disposal_status !=5 and is_reopened_yn='0' ";
				  
				  
				  if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
				  
	            
	            $query="SELECT count(grievance_id) as num FROM grievances g,cs_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 ";
				 
				 
				 if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
				 
			
	        }
	        
	         else if($_REQUEST['status']==2 && $_REQUEST['sla']==2)
	        {
	       /*$sql="SELECT * FROM grievances g,cs_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2";
				 
				 $sql="SELECT g.*,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
				  g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and gt.disposal_status !=5 and is_reopened_yn='0'";
				  
				  if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
	            
	            $query="SELECT count(grievance_id) as num FROM grievances g,cs_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 ";
				 
				 if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
	        }
	        else if($_REQUEST['status']==3 && $_REQUEST['sla']==1)
	        {
	       /*$sql="SELECT * FROM grievances g,cs_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=1";
	            
	            $query="SELECT count(grievance_id) as num FROM grievances g,cs_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=1";
				 
				 if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
				 
			$sql="SELECT g.*,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(NOW(),g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
				  g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and gt.disposal_status !=5 and is_reopened_yn='0' ";
				  
				  
				  if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
				 
				 
				 
				 
				 
				 
	        }
	        else if($_REQUEST['status']==3 && $_REQUEST['sla']==2)
	        {
	       /*$sql="SELECT * FROM grievances g,cs_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=2";
				 
				 $sql="SELECT g.*,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(NOW(),g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
				  g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and gt.disposal_status !=5 and is_reopened_yn='0' ";
	            
	            
	                if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
	            
	            
	            $query="SELECT count(grievance_id) as num FROM grievances g,cs_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=2";
				 
				 if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
				 
				 
				 
				 
				 
				 
	        }
	        else if($_REQUEST['status']==6)
	        {
	            /*$sql="select * from grievances g,cs_mst c,ulbmst u where 
		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='6' and app_type_id='1'";
		
		$sql="SELECT g.*,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
				  g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id ='6' and gt.disposal_status !=5 and is_reopened_yn='0' "; 
				  
				  if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            $query="select count(grievance_id) as num from grievances g,cs_mst c,ulbmst u where 
		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='6' and app_type_id='1'";
		
		            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
        		     
	        }
	        
	        
	         else if($_REQUEST['status']==10)
	        {
	            /*$sql="select * from grievances g,cs_mst c,ulbmst u where 
		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='10' and app_type_id='1'";
		
		$sql="SELECT g.*,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
				  g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id ='10' and gt.disposal_status !=5 and is_reopened_yn='0'"; 
				  
				  
				  if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            $query="select count(grievance_id) as num from grievances g,cs_mst c,ulbmst u where 
		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='10' and app_type_id='1'";
		
		            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
	        }
	         else if($_REQUEST['status']==11)
	        {
	            /*$sql="select * from grievances g,cs_mst c,ulbmst u where 
		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='4' and app_type_id='1'";
		
		$sql="SELECT g.*,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_off_time+holidays_added  DAY) as comp_date,ccm.cutt_off_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_off_time-holidays_added  AS no_of_days_exeed FROM grievances g,grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
				  g.cat3_id=ccm.cs_id and app_type_id='1' and grievance_status_id ='4' and gt.disposal_status !=5 and is_reopened_yn='0'"; 
				  
				  if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            $query="select count(grievance_id) as num from grievances g,cs_mst c,ulbmst u where 
		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='4' and app_type_id='1'";
		
		        if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
		
		
	        }
	        
	        
	        
	        
	    }*/
	    
	    /////////////////////////////////////////////////////////////////// Employee complaints
	    
	    /*
	    if($_REQUEST['aptid']==1 && $_REQUEST['user_type']=='E')
	    {
	        // User type U
	        if($_REQUEST['status']==0 && $_REQUEST['sla']==0)
	        {
	            
	            $sql ="SELECT * FROM grievances g,ulbmst u ,cs_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and
	            app_type_id='1' and gt.emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5";
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	            $query = "SELECT count(g.grievance_id) as num FROM grievances g,ulbmst u ,cs_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and 
	            g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and gt.emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and is_reopened_yn='0'";
	            
	               if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	        }
	        else if($_REQUEST['status']==1 && $_REQUEST['sla']==0)
	        {
	            
	            $sql="select * from grievances g,cs_mst c,ulbmst u where 
		        g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='1' and app_type_id='1' and gt.disposal_status !=5 and is_reopened_yn='0'";
	           
	           
	           if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	           
	           
	           
	           
	            $query="select count(grievance_id) as num from grievances g,cs_mst c,ulbmst u where 
		                            g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='1' and app_type_id='1' and 
		                            gt.disposal_status !=5 and is_reopened_yn='0'";
	        
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	            
	            
	        }
	        else if($_REQUEST['status']==2 && $_REQUEST['sla']==1)
	        {
	       $sql="SELECT * FROM grievances g,cs_mst c,ulbmst u,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and gt.disposal_status !=5 and is_reopened_yn='0'";
	            
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	            
	            
	            
	            
	            $query="SELECT count(g.grievance_id) as num FROM grievances g,cs_mst c,ulbmst u,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=1 and gt.disposal_status !=5 and is_reopened_yn='0'";
	        
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	            
	            
	            
	            
	        }
	        
	         else if($_REQUEST['status']==2 && $_REQUEST['sla']==2)
	        {
	       $sql="SELECT * FROM grievances g,cs_mst c,ulbmst u, grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and gt.disposal_status !=5 and is_reopened_yn='0'";
	          
	          
	          if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	          
	            
	            $query="SELECT count(g.grievance_id) as num FROM grievances g,cs_mst c,ulbmst u,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('3','8','9') and sla_status=2 and gt.disposal_status !=5 and is_reopened_yn='0'";
	       
	       
	              if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	        }
	        else if($_REQUEST['status']==3 && $_REQUEST['sla']==1)
	        {
	            
	                $sql="SELECT * FROM grievances g,cs_mst c,ulbmst u, grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				            g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and gt.disposal_status !=5 and is_reopened_yn='0'";
	            
	            
	                if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	            
	            
	            
	            $query="SELECT count(g.grievance_id) as num FROM grievances g,category3_mst c,ulbmst u , grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=1 and gt.disposal_status !=5 and is_reopened_yn='0'";
	        
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	            
	            
	            
	        }
	        else if($_REQUEST['status']==3 && $_REQUEST['sla']==2)
	        {
	       $sql="SELECT * FROM grievances g,cs_mst c,ulbmst u ,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5";
	           
	           
	           if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	           
	            
	            $query="SELECT count(g.grievance_id) as numFROM grievances g,cs_mst c,ulbmst u ,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and is_reopened_yn='0'";
	        
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	            
	            
	            
	        }
	        
	        
	        else if($_REQUEST['status']==6)
	        {
	            
		
		$sql="SELECT * FROM grievances g,cs_mst c,ulbmst u ,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('6')  and gt.disposal_status !=5 and is_reopened_yn='0'";
	        
	       if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		 
	        
	        
	        
	        
	            
	            $query="SELECT count(g.grievance_id) as num FROM grievances g,cs_mst c,ulbmst u ,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('6')  and gt.disposal_status !=5 and is_reopened_yn='0'";
	        
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	            
	            
	            
	        }
	         else if($_REQUEST['status']==10)
	        {
	           
		
		$sql="SELECT * FROM grievances g,cs_mst c,ulbmst u ,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('10')  and gt.disposal_status !=5";
				 
				 
			if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
			 
				 
				 
				 
				 
	            
	            $query="SELECT count(g.grievance_id) as num FROM grievances g,cs_mst c,ulbmst u ,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('10')  and gt.disposal_status !=5 and is_reopened_yn='0'";
				 
				 
				 if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	        }
	         else if($_REQUEST['status']==11)
	        {
	            
		
	$sql="SELECT * FROM grievances g,cs_mst c,ulbmst u ,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('4')  and gt.disposal_status !=5";
				 
				 
		            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
				 
				 
				 
				 
	            
	            $query="SELECT count(g.grievance_id) as num FROM grievances g,cs_mst c,ulbmst u ,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='1' and grievance_status_id IN('4')  and gt.disposal_status !=5 and is_reopened_yn='0'";
				 
				 if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	        }
	        
	    }
	    
	    
	    
	    
	    
	    
	  ////////////////////////////////////////////////////////////////  employee services  
	    
	    
	    
	    
	    
	    
	    
	    if($_REQUEST['aptid']==2 && $_REQUEST['user_type']=='E')
	    {
	        // User type U
	        if($_REQUEST['status']==0 && $_REQUEST['sla']==0)
	        {
	            $sql ="SELECT * FROM grievances g,ulbmst u ,category3_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and 
	            g.cat3_id=c.cs_id and app_type_id='2' and gt.emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5";
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	            $query = "SELECT count(g.grievance_id) as num FROM grievances g,ulbmst u ,category3_mst c,grievances_transactions gt where g.grievance_id=gt.grievance_id and
	            g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and gt.emp_id='".$_SESSION['emp_id']."' and gt.disposal_status !=5 and is_reopened_yn='0'";
	            
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	        }
	        else if($_REQUEST['status']==1 && $_REQUEST['sla']==0)
	        {
	            $sql="select * from grievances g,category3_mst c,ulbmst u where 
            		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='1' and app_type_id='2' and gt.disposal_status !=5 and 
            		is_reopened_yn='0'";
            		
            		
            		if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
            		
            		
            		
            		
	            $query="select count(grievance_id) as num from grievances g,category3_mst c,ulbmst u where 
		                    g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='1' and app_type_id='2' and gt.disposal_status !=5 and is_reopened_yn='0'";
	       
	               if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		     
	        }
	        else if($_REQUEST['status']==2 && $_REQUEST['sla']==1)
	        {
	             $sql="SELECT * FROM grievances g,category3_mst c,ulbmst u,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=1 and gt.disposal_status !=5 and is_reopened_yn='0'";
	            
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
	            
	            $query="SELECT count(g.grievance_id) as num FROM grievances g,category3_mst c,ulbmst u,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=1 and gt.disposal_status !=5 and is_reopened_yn='0'";
	       
	       
	             if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	       
	       
	        }
	        
	         else if($_REQUEST['status']==2 && $_REQUEST['sla']==2)
	        {
	             $sql="SELECT * FROM grievances g,category3_mst c,ulbmst u, grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2 and gt.disposal_status !=5 and is_reopened_yn='0'";
	            
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            $query="SELECT count(g.grievance_id) as num FROM grievances g,category3_mst c,ulbmst u,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2 and gt.disposal_status !=5 and is_reopened_yn='0'";
	       
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	       
	       
	       
	       
	       
	        }
	        else if($_REQUEST['status']==3 && $_REQUEST['sla']==1)
	        {
	       $sql="SELECT * FROM grievances g,category3_mst c,ulbmst u, grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=1 and gt.disposal_status !=5 and is_reopened_yn='0'";
	            
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
	            
	             $query="SELECT count(g.grievance_id) as num FROM grievances g,category3_mst c,ulbmst u , grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=1 and gt.disposal_status !=5 and is_reopened_yn='0'";
	        
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	        }
	        
	        else if($_REQUEST['status']==3 && $_REQUEST['sla']==2)
	        {
	             $sql="SELECT * FROM grievances g,category3_mst c,ulbmst u ,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and is_reopened_yn='0'";
	            
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	            
	            
	            $query="SELECT count(g.grievance_id) as num FROM grievances g,category3_mst c,ulbmst u, grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=2 and gt.disposal_status !=5 and is_reopened_yn='0'";
	        
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	            
	            
	            
	            
	        }
	         else if($_REQUEST['status']==6)
	        {
	            
		
		        $sql="SELECT * FROM grievances g,category3_mst c,ulbmst u .grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('6')  and gt.disposal_status !=5";
				 
			if(isset($_POST['search']))
        	{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        	}
			 
				 
	            
	            $query="SELECT count(g.grievance_id) num FROM grievances g,category3_mst c,ulbmst u ,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('6')  and gt.disposal_status !=5 and is_reopened_yn='0'";
				 
				 if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
				 
				 
				 
				 
	        }
	         else if($_REQUEST['status']==10)
	        {
	           
		
		$sql="SELECT * FROM grievances g,category3_mst c,ulbmst u ,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('10')  and gt.disposal_status !=5";
	            
	            
	       if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		     
	            
	            $query="SELECT count(g.grievance_id) num FROM grievances g,category3_mst c,ulbmst u ,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('10')  and gt.disposal_status !=5 and is_reopened_yn='0'";
				 
				 
				 if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
				 
				 
	        }
	        
	        
	        else if($_REQUEST['status']==11)
	        {
	            
		
	            $sql="SELECT * FROM grievances g,cs_mst c,category3_mst u ,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('4')  and gt.disposal_status !=5";
				 
				 
				 if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            $query="SELECT count(g.grievance_id) as num FROM grievances g,category3_mst c,ulbmst u ,grievances_transactions gt where g.grievance_id=gt.grievance_id and gt.emp_id='".$_SESSION['emp_id']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('4')  and gt.disposal_status !=5 and is_reopened_yn='0'";
				 
				 if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	        }
	    }
	    
	    
	    
	    if($_REQUEST['aptid']==2 && $_REQUEST['user_type']=='U')
	    {
	        // User type U
	        if($_REQUEST['status']==0 && $_REQUEST['sla']==0)
	        {
	            $sql ="SELECT * FROM grievances g,ulbmst u ,category3_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and 
	            g.ulbid='".$_SESSION['ulbid']."'";
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            $query = "SELECT count(grievance_id) as num FROM grievances g,ulbmst u ,category3_mst c where g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and
	            g.ulbid='".$_SESSION['ulbid']."'";
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	        }
	        
	        
	        else if($_REQUEST['status']==1 && $_REQUEST['sla']==0)
	        {
	            $sql="select * from grievances g,category3_mst c,ulbmst u where 
		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='1' and app_type_id='2'";
		
		
		if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
		
		
		
		
	            $query="select count(grievance_id) as num from grievances g,cs_mst c,ulbmst u where 
		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='1' and app_type_id='2'";
		
		if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	        }
	        
	        
	        else if($_REQUEST['status']==2 && $_REQUEST['sla']==1)
	        {
	       /*$sql="SELECT * FROM grievances g,category3_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=1";
				 
				 $sql="select *,disposed_date,DATEDIFF(disposed_date,date_regd)-c.cutt_of_time  AS no_of_days_exeed,c.cutt_of_time as target_days,
	            DATE_ADD(date_regd, INTERVAL c.cutt_of_time DAY) as comp_date from grievances g,grievances_transactions gt ,category3_mst c,ulbmst u
	            where g.cat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and
        		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id IN('3','8','9') and app_type_id='2' and sla_status=1 and 
        		gt.disposal_status !=5 and is_reopened_yn='0'";
        		
        		
        		if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	            $query="SELECT count(grievance_id) as num FROM grievances g,category3_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=1";
				 
				 if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	        }
	        
	         else if($_REQUEST['status']==2 && $_REQUEST['sla']==2)
	        {
	      /* $sql="SELECT * FROM grievances g,category3_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2";
				 
				 $sql="select *,disposed_date,DATEDIFF(disposed_date,date_regd)-c.cutt_of_time  AS no_of_days_exeed,c.cutt_of_time as target_days,
	            DATE_ADD(date_regd, INTERVAL c.cutt_of_time DAY) as comp_date from grievances g,grievances_transactions gt ,category3_mst c,ulbmst u
	            where g.cat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and
        		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id IN('3','8','9') and app_type_id='2' and sla_status=2 and 
        		gt.disposal_status !=5 and is_reopened_yn='0'";
        		
        		if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	            $query="SELECT count(grievance_id) as num FROM grievances g,category3_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('3','8','9') and sla_status=2 ";
				 
				 
				 if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	        }
	        else if($_REQUEST['status']==3 && $_REQUEST['sla']==1)
	        {
	       /*$sql="SELECT * FROM grievances g,category3_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=1";
				 
				  $sql="select *,DATEDIFF(NOW(),date_regd)-c.cutt_of_time  AS no_of_days_exeed,c.cutt_of_time as target_days,
	            DATE_ADD(date_regd, INTERVAL c.cutt_of_time DAY) as comp_date from grievances g,grievances_transactions gt ,category3_mst c,ulbmst u
	            where g.cat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and
        		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id IN('2') and app_type_id='2' and sla_status=1 and gt.disposal_status !=5 and is_reopened_yn='0'";
	            
	            
	            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	            
	            
	            
	            $query="SELECT count(grievance_id) as num,app_type_id FROM grievances g,category3_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=1";
				 
				 
				 
				 if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	        }
	        else if($_REQUEST['status']==3 && $_REQUEST['sla']==2)
	        {
	      /* $sql="SELECT * FROM grievances g,category3_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=2";
				 
				 $sql="select *,DATEDIFF(NOW(),date_regd)-c.cutt_of_time  AS no_of_days_exeed,c.cutt_of_time as target_days,
	            DATE_ADD(date_regd, INTERVAL c.cutt_of_time DAY) as comp_date from grievances g,grievances_transactions gt ,category3_mst c,ulbmst u
	            where g.cat3_id=c.cs_id  and g.grievance_id=gt.grievance_id and
        		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id IN('2') and app_type_id='2' and sla_status=2 and 
        		gt.disposal_status !=5 and is_reopened_yn='0'";
        		
        		if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
        		
        		
	            
	            $query="SELECT count(grievance_id) as num,app_type_id FROM grievances g,category3_mst c,ulbmst u where g.ulbid='".$_SESSION['ulbid']."' and 
				 g.ulbid=u.ulbid and g.cat3_id=c.cs_id and app_type_id='2' and grievance_status_id IN('2') and sla_status=2";
				 
				 
				 if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	        }
	       
	        
	         else if($_REQUEST['status']==6)
	        {
	            /*$sql="select * from grievances g,cs_mst c,ulbmst u where 
		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='6' and app_type_id='1'";
		
		$sql="SELECT g.*,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_of_time+holidays_added  DAY) as comp_date,ccm.cutt_of_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_of_time-holidays_added  AS no_of_days_exeed FROM grievances g,grievances_transactions gt,category3_mst ccm where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
				  g.cat3_id=ccm.cs_id and app_type_id='2' and grievance_status_id ='6' and gt.disposal_status !=5 and is_reopened_yn='0' "; 
				  
				  if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
		
	            $query="select count(grievance_id) as num from grievances g,category3_mst c,ulbmst u where 
		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='6' and app_type_id='2'";
		
		            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	        }
	         else if($_REQUEST['status']==10)
	        {
	            /*$sql="select * from grievances g,cs_mst c,ulbmst u where 
		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='10' and app_type_id='1'";
		
		$sql="SELECT g.*,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_of_time+holidays_added  DAY) as comp_date,ccm.cutt_of_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_of_time-holidays_added  AS no_of_days_exeed FROM grievances g,grievances_transactions gt,category3_mst ccm where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
				  g.cat3_id=ccm.cs_id and app_type_id='2' and grievance_status_id ='10' and gt.disposal_status !=5 and is_reopened_yn='0'";
				  
				  if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
		
	            $query="select count(grievance_id) as num from grievances g,category3_mst c,ulbmst u where 
		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='10' and app_type_id='2'";
		
		            if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	        }
	         else if($_REQUEST['status']==11)
	        {
	            /*$sql="select * from grievances g,cs_mst c,ulbmst u where 
		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='4' and app_type_id='1'";
		
		$sql="SELECT g.*,disposed_date,holidays_added as no_holidays, DATE_ADD(date_regd, INTERVAL ccm.cutt_of_time+holidays_added  DAY) as comp_date,ccm.cutt_of_time+holidays_added as target_days,DATEDIFF(disposed_date,g.date_regd)-ccm.cutt_of_time-holidays_added  AS no_of_days_exeed FROM grievances g,grievances_transactions gt,category3_mst ccm where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
				  g.cat3_id=ccm.cs_id and app_type_id='2' and grievance_status_id ='4' and gt.disposal_status !=5 and is_reopened_yn='0'"; 
				  
				  if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
		
	            $query="select count(grievance_id) as num from grievances g,category3_mst c,ulbmst u where 
		g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.ulbid='".$_SESSION['ulbid']."' and grievance_status_id='4' and app_type_id='2'";
		
		if(isset($_POST['search']))
        			{
        			            
        			            if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                         
                			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
                			            
            			                $query.=" and date(date_regd) between '".$f_date."' and '".$t_date."' order by date_regd DESC" ;
            			                 
			                      }
        			  
        			           
        		     }
		
	        }
	    }

		
		*/
		
		////////////////////pagination
		
		//$tbl_name="nalgonda_survey";		//your table name
		// How many adjacent pages should be shown on each side?
		$adjacents = 5;
		
		/* 
		   First get total number of rows in data table. 
		   If you have a WHERE clause in your query, make sure you mirror it here.
		*/
		
		//echo $query;
		if($f_date == '' || $t_date == '')
		{
        		$result=mysqli_query($conn,$query);
        		//$total_pages = mysql_fetch_array($result);
        		while($row=mysqli_fetch_assoc($result))
        		{
        	           $total_pages = $row['num'];
        	        //echo $row['num'];
        		}
        	        
        	        
		}
	        
		//echo $total_pages;
		/* Setup vars for query. */
		$targetpage = "ward_received.php"; 	//your file name  (the name of this file)
		$limit = 50; 								//how many items to show per page
		$page = $_GET['page'];
		if($page) 
			$start = ($page - 1) * $limit; 			//first item to display on this page
		else
			$start = 0;								//if no page var is given, set start to 0
		
		/* Get data. */
		if($f_date == '' || $t_date == '')
	    {
	       $sql.=" LIMIT $start, $limit";
	       
	    }
	        //echo $sql;
	        
	        //$sql. = "SELECT * FROM $tbl_name order by submission_date desc LIMIT $start, $limit";
		//$rs = mysql_query($sql);
		
		/* Setup page vars for display. */
		
		if ($page == 0) $page = 1;					//if no page var is given, default to 1.
		$prev = $page - 1;							//previous page is page - 1
		$next = $page + 1;							//next page is page + 1
		$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
		$lpm1 = $lastpage - 1;						//last page minus 1
		
		/* 
			Now we apply our rules and draw the pagination object. 
			We're actually saving the code to a variable in case we want to draw it more than once.
		*/
		 //echo $lastpage;
		$pagination = "";
		if($lastpage > 1)
		{	
			$pagination .= "<div class=\"pagination\">";
			//previous button
			if ($page > 1) 
				$pagination.= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$prev\"><< previous</a>";
			else
				$pagination.= "<span class=\"disabled\"><< previous</span>";	
			
			//pages	
			if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
				$pagination.= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$counter\">$counter</a>";					
				}
			}
			elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
			{
				//close to beginning; only hide later pages
				if($page < 1 + ($adjacents * 2))		
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
				$pagination.= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$counter\">$counter</a>";					
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$lastpage\">$lastpage</a>";		
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
					$pagination.= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=2\">2</a>";
					$pagination.= "...";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$counter\">$counter</a>";					
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$lastpage\">$lastpage</a>";		
				}
				//close to end; only hide early pages
				else
				{
					$pagination.= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=2\">2</a>";
					$pagination.= "...";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$counter\">$counter</a>";					
					}
				}
			}
			
			//next button
			if ($page < $counter - 1) 
				$pagination.= "<a href=\"$targetpage?aptid=$aptid1&status=$status1&user_type=$user_type1&sla=$sla1&ulbid-$ulbid1&page=$next\">next >></a>";
			else
				$pagination.= "<span class=\"disabled\">next >></span>";
			 $pagination.= "</div>\n";
		  	
		}  	
		
		
		
		
		
		////////////////////pagination end
		
		
		
		
		if($rs=mysqli_query($conn,$sql))
		{
			$field_info = mysqli_fetch_fields($rs);
			while($row = mysqli_fetch_assoc($rs))
			{
			
				
			
				
					foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
			}
			
	
			
		}
		else
		echo mysqli_error($conn);
						
		
		$tpl->assign('data',$data);



		$sql="select ward_id,ward_desc from ward_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
			$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	

	  	$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=5";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));
			

		$sql="select dept_id,dept_desc from dept_mst";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
					
		$tpl->assign('dept_list',$dept_list);
		
		
			
		 $sql ="select emp_id, emp_name, emp_mobile from emp_mst where ulbid='".$_SESSION['ulbid']."'";
		$rs=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
				$emp_list[$row['emp_id']]=$row['emp_name']." - ".$row['emp_mobile'];
				$emp_mobile[$row['emp_id']]=$row['emp_mobile'];
		}

        $tpl->assign('emp_list',$emp_list);
        $tpl->assign('emp_mobile',$emp_mobile);
        
		
		
		
		//$sql="select cs_id,comp_desc from category3_mst where ulbid='".$_SESSION['ulbid']."'";
		
		//if($_REQUEST['aptid']=='1')
		//{
		$sql="select cs_id,cs_desc as comp_desc from cs_mst";
		//}
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));	
		$sql ="select user_id,user_name from users where ulbid='".$_SESSION['ulbid']."'";			
			if($rs=mysqli_query($conn,$sql))
        		{
        			while($row = mysqli_fetch_assoc($rs))
        				$users_list[$row['user_id']]=$row['user_name'];
        		}
        		
        		
        		
        		mysqli_close($conn);
        $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('fdate',$_POST['f_date']);
        $tpl->assign('tdate',$_POST['t_date']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('ward_received.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>