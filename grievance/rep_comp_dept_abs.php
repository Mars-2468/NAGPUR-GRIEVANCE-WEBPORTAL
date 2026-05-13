<?php
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	date_default_timezone_set('Asia/Calcutta');
	$tpl=new Smarty();
	session_start();
	if(isset($_SESSION['uid']))
	{
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		if($_SESSION['ulbid'] =='3')
		{
		   $sql ="select COUNT(g.grievance_id) as count,gt.dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid IN('208','210') and g.app_type_id='2' and gt.disposal_status!='5' and 
		cat3_id !='0'"; 
		}
		else
		{
		
		$sql ="select COUNT(DISTINCT gt.grievance_id) as count,gt.dept_id as emp_dept from grievances g, grievances_transactions gt where 
		g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and g.app_type_id='2' and gt.disposal_status!='5' and 
		cat3_id !='0'";
		}
		
		if(isset($_POST['search']))
        {
        			            
        			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        			            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			             if($reference_no!='')
        			             {
        			             $sql.=" and g.grievance_id = '".$reference_no."'";
        			            
        			             }
        			             if($f_date!='1970-01-01')
                                 {
                                 $sql.=" and DATE(date_regd) >= '".$f_date."'";
                                
                                 }
                                 if($t_date!='1970-01-01')
                                 {
                                  $sql.=" and DATE(date_regd) <= '".$t_date."'";
                                 
                                 }
        			          }
        			          
        			         if($f_date!= '' && $t_date!='')
            			        {
            			            
            			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."' ";
            			            
            			        }
            			       $sql.=" group by gt.dept_id"; 
            			       
            			      // echo $sql;
            			        
            			        
		 
			if($rs=mysqli_query($conn,$sql))
			{
			  while($row = mysqli_fetch_assoc($rs))
			    {
				$data[$row['emp_dept']]['count']=$row['count'];
				$tot['received']+=$row['count'];
			    }
		 	}
			else
				printf("Errormessage: %s\n", mysqli_error($conn));
			if($_SESSION['ulbid'] =='3')
		        {
		            $sql ="select COUNT(g.grievance_id) as count1,gt.dept_id as emp_dept,disposal_status from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid IN('208','210') and 
			g.app_type_id='2' and gt.disposal_status!='5' and cat3_id !='0'";
		        }
		        else
		        {
			$sql ="select COUNT(g.grievance_id) as count1,gt.dept_id as emp_dept,disposal_status from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
			g.app_type_id='2' and gt.disposal_status!='5' and cat3_id !='0'";
		        }
            if(isset($_POST['search']))
        			         {
        			            
        			            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        			            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			             if($reference_no!='')
        			             {
        			             $sql.=" and g.grievance_id = '".$reference_no."'";
        			            
        			             }
        			             if($f_date!='1970-01-01')
                                 {
                                 $sql.=" and DATE(date_regd) >= '".$f_date."'";
                                
                                 }
                                 if($t_date!='1970-01-01')
                                 {
                                  $sql.=" and DATE(date_regd) <= '".$t_date."'";
                                 
                                 }
        			          }
        			          
        			         if($f_date!= '' && $t_date!='')
            			        {
            			            
            			            $sql.="and date(date_regd) between '".$f_date."' and '".$t_date."' ";
            			            
            			        }
            			       $sql.=" group by gt.dept_id,gt.disposal_status"; 
            			       
            			       
            			       
            			       
             
		 
		if($rs=mysqli_query($conn,$sql))
		{
		  while($row = mysqli_fetch_assoc($rs))
		    {
		     
			    
		     if($row['disposal_status']==4)
			    {
			    $data_list[$row['emp_dept']]['unresolved']=$row['count1'];
			    $tot['unresolved']+=$row['count1'];
			    }
		     
		    
						
		    }
	 	}
		else
			printf("Errormessage: %s\n", mysqli_error($conn));

            if($_SESSION['ulbid'] =='3')
		        {
		            $sql ="select COUNT(g.grievance_id) as count1,gt.dept_id as emp_dept,disposal_status from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid IN('208','210') and 
			g.app_type_id='2' and gt.disposal_status!='5' and cat3_id !='0' and gt.disposal_status='2' and g.sla_status = '1'";
		        }
		        else
		        {
         
         	 $sql ="select COUNT(g.grievance_id) as count1,gt.dept_id as emp_dept,disposal_status from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
			g.app_type_id='2' and gt.disposal_status!='5' and cat3_id !='0' and gt.disposal_status='2' and g.sla_status = '1'";
		        }
			
			if(isset($_POST['search']))
              {
            	
            		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
    	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
            			            
            		    if($f_date!= '' && $t_date!='')
    			        {
    			            
    			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
    			            $tpl->assign('fdate',date('Y-m-d',strtotime($_POST['f_date'])));
    		                $tpl->assign('tdate',date('Y-m-d',strtotime($_POST['t_date'])));
    			        }
    			        
              }
          
			        
			        $sql.=" group by gt.dept_id";
			
			if($rs=mysqli_query($conn,$sql))
		    {
		        
    		  while($row = mysqli_fetch_assoc($rs))
    		  {
    		      
    		      $data_list[$row['emp_dept']]['pending']+=$row['count1'];
			        $tot['pending']+=$row['count1'];
    		  }
		    }
    		  if($_SESSION['ulbid'] =='3')
		        {
		            $sql ="select COUNT(g.grievance_id) as count2,gt.dept_id as emp_dept,disposal_status from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid IN('208','210') and 
			g.app_type_id='2' and gt.disposal_status!='5' and cat3_id !='0' and gt.disposal_status='2' and g.sla_status = '2'";
		        }
		        else
		        {
    		  
    		  $sql ="select COUNT(g.grievance_id) as count2,gt.dept_id as emp_dept,disposal_status from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
			g.app_type_id='2' and gt.disposal_status!='5' and cat3_id !='0' and gt.disposal_status='2' and g.sla_status = '2'";
		        }
			if(isset($_POST['search']))
          {
        	
        		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			            
        		    if($f_date!= '' && $t_date!='')
			        {
			            
			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
			            $tpl->assign('fdate',date('Y-m-d',strtotime($_POST['f_date'])));
		                $tpl->assign('tdate',date('Y-m-d',strtotime($_POST['t_date'])));
			        }
			        
          }
          
			        
			        $sql.=" group by gt.dept_id";
			
			if($rs=mysqli_query($conn,$sql))
		    {
		        
    		  while($row = mysqli_fetch_assoc($rs))
    		  {
    		      
    		      $data_list[$row['emp_dept']]['pending_be']+=$row['count2'];
			        $tot['pending_be']+=$row['count2'];
    		  }
    		  
		    }
         
         if($_SESSION['ulbid'] =='3')
		        {
		            $sql ="select COUNT(g.grievance_id) as count1,gt.dept_id as emp_dept,disposal_status from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid IN('208','210') and 
			g.app_type_id='2' and gt.disposal_status!='5' and cat3_id !='0' and gt.disposal_status IN ('3','8','9') and 
			g.sla_status = '1'";
		        }
		        else
		        {
         $sql ="select COUNT(g.grievance_id) as count1,gt.dept_id as emp_dept,disposal_status from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
			g.app_type_id='2' and gt.disposal_status!='5' and cat3_id !='0' and gt.disposal_status IN ('3','8','9') and 
			g.sla_status = '1'";
		        }
			if(isset($_POST['search']))
          {
        	
        		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			            
        		    if($f_date!= '' && $t_date!='')
			        {
			            
			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
			            $tpl->assign('fdate',date('Y-m-d',strtotime($_POST['f_date'])));
		                $tpl->assign('tdate',date('Y-m-d',strtotime($_POST['t_date'])));
			        }
			        
          }
          
			        
			        $sql.=" group by gt.dept_id";
			
				if($rs=mysqli_query($conn,$sql))
		    {
		        
    		  while($row = mysqli_fetch_assoc($rs))
    		  {
    		      
    		      $data_list[$row['emp_dept']]['completed']+=$row['count1'];
			        $tot['completed']+=$row['count1'];
    		  }
    		  
		    }
		    
		    if($_SESSION['ulbid'] =='3')
		        {
		            $sql ="select COUNT(g.grievance_id) as count1,gt.dept_id as emp_dept,disposal_status from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid IN('208','210') and 
			g.app_type_id='2' and gt.disposal_status!='5' and cat3_id !='0' and gt.disposal_status IN ('3','8','9') and 
			g.sla_status = '2'";
		        }
		        else
		        {
		    $sql ="select COUNT(g.grievance_id) as count1,gt.dept_id as emp_dept,disposal_status from grievances g, 
			grievances_transactions gt where g.grievance_id=gt.grievance_id and g.ulbid='".$_SESSION['ulbid']."' and 
			g.app_type_id='2' and gt.disposal_status!='5' and cat3_id !='0' and gt.disposal_status IN ('3','8','9') and 
			g.sla_status = '2'";
		        }
			if(isset($_POST['search']))
          {
        	
        		$f_date = date('Y-m-d',strtotime($_POST['f_date']));
	            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
        			            
        		    if($f_date!= '' && $t_date!='')
			        {
			            
			            $sql.=" and date(date_regd) between '".$f_date."' and '".$t_date."'";
			            $tpl->assign('fdate',date('Y-m-d',strtotime($_POST['f_date'])));
		                $tpl->assign('tdate',date('Y-m-d',strtotime($_POST['t_date'])));
			        }
			        
          }
          
			        
			        $sql.=" group by gt.dept_id";
			
				if($rs=mysqli_query($conn,$sql))
		    {
		        
    		  while($row = mysqli_fetch_assoc($rs))
    		  {
    		      
    		      $data_list[$row['emp_dept']]['completed_be']+=$row['count1'];
			        $tot['completed_be']+=$row['count1'];
    		  }
    		  
		    }
         
         if($_SESSION['ulbid'] =='3')
		        {
		            $sql="select dept_id,dept_desc from dept_mst where ulbid IN('208','210')";
		        }
		        else
		        {
		          $sql="select dept_id,dept_desc from dept_mst where ulbid='".$_SESSION['ulbid']."'";
		        }
			if($rs=mysqli_query($conn,$sql))
			{
				while($row = mysqli_fetch_assoc($rs))
					$dept_list[$row['dept_id']]=$row['dept_desc'];
			}
			else
				printf("Errormessage: %s\n", mysqli_error($conn));
				
			
			
			$sql="select * from grievance_status_mst";
			if($rs=mysqli_query($conn,$sql))
			{
				while($row = mysqli_fetch_assoc($rs))
					$status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
			}
			else
				printf("Errormessage: %s\n", mysqli_error($conn));
				
				
				$sql ="SELECT * FROM `ulb_online_application_map` where ulbid='".$_SESSION['ulbid']."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		$sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".mysqli_real_escape_string($conn,$_SESSION['ulbid'])."%'"; 
     $rs = mysqli_query($conn,$sql);
     $row = mysqli_fetch_assoc($rs);
     $users_count=$row['user_count'];
    $tpl->assign('users_count',$users_count);




		mysqli_close($conn);





	$tpl->assign('user_type',$_SESSION['user_type']);
	$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet','3'=>'Both'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('tdate',$t_date);
		$tpl->assign('fdate',$f_date);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('tot',$tot);
		$tpl->assign('status_list',$status_list);
		$tpl->assign('data_list',$data_list);		
		$tpl->assign('data',$data);
		$tpl->assign('tot',$tot);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('user_dept',$_SESSION['user_dept']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('rep_comp_dept_abs.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>	