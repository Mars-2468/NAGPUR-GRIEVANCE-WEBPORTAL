<?phprequire "config.php";
	ini_set('display_errors',0);
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
		$ward_id=$_REQUEST['ward_id'];
		
	     
	     	/**** Total received ****/
	      
	      $sql="SELECT count(grievance_id) as grievance_id,ward_id,cat3_id  FROM grievances  
	      where ulbid='".$ulbid1."' and app_type_id='1' and cat3_id !='0' and ward_id='".$ward_id."' group by cat3_id";
	 
	        $rs=mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
		    {
				   $data[$row['cat3_id']]['total_received']+=$row['grievance_id'];
				  $tot['total_received']+=$row['grievance_id'];
			}
				 
		 
			
				/**** resolved with in sla ****/
			
			$sql ="select COUNT(grievance_id) as resolved_within_sla,ward_id,cat3_id  from grievances where grievance_status_id IN('3','8','9') and 
			ulbid='".$ulbid1."' and app_type_id='1' and cat3_id !='0' and sla_status='1' and ward_id='".$ward_id."' group by cat3_id";
			$rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
			    $data[$row['cat3_id']]['resolved_within_sla']+=$row['resolved_within_sla'];
			    $tot['resolved_within_sla']+=$row['resolved_within_sla'];
			}
			
			/*** resolved beyond sla ****/
			
			$sql ="select COUNT(grievance_id) as resolved_beyond_sla,ward_id,cat3_id from grievances where grievance_status_id IN('3','8','9') and ulbid='".$ulbid1."' 
			and app_type_id='1' and cat3_id !='0' and sla_status='2' and ward_id='".$ward_id."' group by cat3_id";
			$rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
			    $data[$row['cat3_id']]['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
			    $tot['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
			}
			
			
			
			
			
	 			/**** pending with in sla ***/
			
			$sql ="select COUNT(grievance_id) as pending_within_sla,ward_id,cat3_id  from grievances where grievance_status_id IN('2') and ulbid='".$ulbid1."' and 
			app_type_id='1' and cat3_id !='0' and sla_status='1' and ward_id='".$ward_id."' group by cat3_id";
			$rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
			    $data[$row['cat3_id']]['pending_within_sla']+=$row['pending_within_sla'];
			    $tot['pending_within_sla']+=$row['pending_within_sla'];
			}
			
			
				/**** pending with beyond sla ***/
			
			$sql ="select COUNT(grievance_id) as pending_beyond_sla,ward_id,cat3_id from grievances where grievance_status_id IN('2') and ulbid='".$ulbid1."' and 
			app_type_id='1' and cat3_id !='0' and sla_status='2' and ward_id='".$ward_id."' group by cat3_id";
			$rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
			    $data[$row['cat3_id']]['pending_beyond_sla']+=$row['pending_beyond_sla'];
			    $tot['pending_beyond_sla']+=$row['pending_beyond_sla'];
			}
				
	       
			
			
	       $sql ="select COUNT(grievance_id) as fin_implication,ward_id,cat3_id from grievances where grievance_status_id ='6' and ulbid='".$ulbid1."' and app_type_id='1' and
	      cat3_id !='0' and ward_id='".$ward_id."' group by cat3_id";
	                    
	        $rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
				 $data[$row['cat3_id']]['fin_implication']+=$row['fin_implication'];
				 $tot['fin_implication']+=$row['fin_implication'];
			}
			
			
			
			
		  	
	         $sql ="select COUNT(grievance_id) as pending_apprvl,ward_id,cat3_id from grievances where grievance_status_id ='1' and ulbid='".$ulbid1."' and 
	         app_type_id='1' and cat3_id !='0' and ward_id='".$ward_id."' group by cat3_id";
	                    
	        $rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
				 $data[$row['cat3_id']]['pending_apprvl']+=$row['pending_apprvl'];
				 $tot['pending_apprvl']+=$row['pending_apprvl'];
			}
			
			
			
			 $sql ="select COUNT(grievance_id) as rejected,ward_id,cat3_id from grievances where grievance_status_id ='10' and ulbid='".$ulbid1."' and app_type_id='1' and 
			 cat3_id !='0' and ward_id='".$ward_id."' group by cat3_id";
	                    
	        $rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
				 $data[$row['cat3_id']]['rejected']+=$row['rejected'];
				 $tot['rejected']+=$row['rejected'];
			}
			
			
			
			
			
			$sql ="select COUNT(grievance_id) as unresolved,ward_id,cat3_id  from grievances where grievance_status_id ='4' and ulbid='".$ulbid1."' and app_type_id='1' 
			and cat3_id !='0' and ward_id='".$ward_id."' group by cat3_id";
	                    
	        $rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
				 $data[$row['cat3_id']]['unresolved']+=$row['unresolved'];
				 $tot['unresolved']+=$row['unresolved'];
			}
			
			
			
				
				$sql ="select * from ulbmst";
				$rs = mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				
		    
		    	 $sql ="select * from cs_mst  order by cs_id";
				$rs = mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				    $cs_list[$row['cs_id']]=$row['cs_desc'];
				}
				
				    
	        $sql ="select cs_id,comp_desc as cs_desc from category3_mst where ulbid='".$ulbid1."'";
	        $rs = mysqli_query($conn,$sql);
    		while($row = mysqli_fetch_assoc($rs))
    		{
    			//$cs_list[$row['cs_id']]=$row['cs_desc'];
    				    
    				    
    				    $total[$row['cs_id']]['tot_resolved']=$data[$row['cs_id']]['resolved_within_sla']+$data[$row['cs_id']]['resolved_beyond_sla'];
    				    $data[$row['cs_id']]['percent']=number_format(($total[$row['cs_id']]['tot_resolved']/$data[$row['cs_id']]['total_received'])*100,2);
    		}
    		
    				$tot['resolved']=$tot['resolved_within_sla']+$tot['resolved_beyond_sla'];
    				$tot['percent']=number_format(($tot['resolved']/$tot['total_received'])*100,2);
    				
    				
    				
    			$sql ="select cat_id,description from category_mst";
				$rs = mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				    $cat_list[$row['cat_id']]=$row['description'];
				}
		
				
			//	print_r($data);
				//For Warangal Municipality
				
				/**
				 if($_SESSION['uid']=='Warangal' || $_SESSION['uid']=='warangal')
				 {
				     
				     
				     
				     
				     $sql ="select service_type_id,soap_type from warangal_service_wise_rep";
				     $rs = mysqli_query($conn,$sql);
				     while($row= mysqli_fetch_assoc($rs))
				     {
				         $cs_list[$row['service_type_id']]=$row['soap_type'];
				     }
				     
				     $data=array();
				     
				      /*$sql="SELECT count(grievance_id) as grievance_id,app_type_id,cat3_id,g.ulbid,c.comp_desc as cs_desc FROM grievances g,category3_mst c 
	      where g.cat3_id=c.cs_id and g.ulbid=211 and app_type_id='2' group by cat3_id";*/
	      
	      //$sql ="select SUM(resolveinsla+resolve_beyond_sla+pending_with_in_sla+pending_beyond_sla) as total_received,service_type_id from warangal_service_wise_rep group by service_type_id";
	 
	        /***
	         * 
	         * 
	         * 
	        $rs=mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
		    {
				  $data[$row['cat3_id']]['total_received']+=$row['grievance_id'];
				 // $tot['total_received']+=$row['grievance_id'];
			}
				     
				     
        		 	    $sql ="SELECT * FROM `warangal_service_wise_rep`";
                               	// echo  $sql;
                            $res = mysqli_query($conn,$sql);
                            while($row = mysqli_fetch_assoc($res))
                            {
                                
                             $data[$row['service_type_id']]['resolved_within_sla']=$row['resolveinsla'];
                             $data[$row['service_type_id']]['resolved_beyond_sla']=$row['resolve_beyond_sla'];
                             $data[$row['service_type_id']]['pending_within_sla']=$row['pending_with_in_sla'];
                             $data[$row['service_type_id']]['pending_beyond_sla']=$row['pending_beyond_sla'];
                                    
                             $data[$row['service_type_id']]['total_received']=$row['resolveinsla']+$row['resolve_beyond_sla']+$row['pending_with_in_sla']+$row['pending_beyond_sla'];
                             
                             $tot['total_received']+=$data[$row['service_type_id']]['total_received'];
                             $tot['resolved_within_sla']+=$row['resolveinsla'];
                             $tot['resolved_beyond_sla']+=$row['resolve_beyond_sla'];
                             $tot['pending_within_sla']+=$row['pending_with_in_sla'];
                             $tot['pending_beyond_sla']+=$row['pending_beyond_sla'];
                             
                             $tot_resolved=$row['resolveinsla']+$row['resolve_beyond_sla'];
                             $data[$row['service_type_id']]['percent']=number_format(($tot_resolved/$data[$row['service_type_id']]['total_received'])*100,2);			
                            }
                            
                            $total_resolved=$tot['resolved_within_sla']+$tot['resolved_beyond_sla'];
                            $tot['percent']=number_format(($total_resolved/$tot['total_received'])*100,2);
                               
                            
                           ***/ 
                      
				// }
				 
				 mysqli_close($conn);
				// print_r($cs_list);
				 //End of Warangal Municipality
			//	echo "<pre>";print_r($tot); 
        //	echo "<pre>";print_r($data);	
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('ward_id',$_REQUEST['ward_id']);
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('data',$data);
		$tpl->assign('tot',$tot);
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('ward_wise_cat.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>