<?php
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	require_once('connection.php');
	$conn=getconnection();
	include('prepare_connection.php');
	
	
	 if(isset($_REQUEST['id'])){$ulbid=$_REQUEST['id'];}else{$ulbid=$_POST['ulbid'];}
		
       

		$sql="select open_comp_banner from users where ulbid=? ";
		
		$ulbid=$ulbid;
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		$query->execute();
		$rs=$query->get_result();
		
		$row = $rs->fetch_assoc();
		
		$banner=$row['open_comp_banner'];
		
		if(isset($_POST['save']))
		{
			if($_POST['from_date'] !='')
            {
                $from_date = date('Y-m-d',strtotime($_POST['from_date']));
                $from_date1 = date('Ymd',strtotime($_POST['from_date']));
                $tpl->assign('from_date',$_POST['from_date']);
            }
            if($_POST['to_date'] !='')
            {
                $to_date = date('Y-m-d',strtotime($_POST['to_date']));
                $to_date1 = date('Ymd',strtotime($_POST['to_date']));
    	        $tpl->assign('to_date',$_POST['to_date']);
            }
		
			
			
	 $sql="select grievance_id,person_name,email,hno,address,ward_id,street_id,mobile,comp_subject,comp_desc,grievance_origin_id,grievance_status_id from grievances 
			 where person_name like ? and mobile like ? and
			 street_id like ? and grievance_status_id like ? 
			 and grievance_id like ? and ulbid like ? and app_type_id=? ";
			
			$person_name="%".strip_tags($_POST['person_name'])."%";
			$mobile="%".strip_tags($_POST['mobile'])."%";
			$street_id="%".strip_tags($_POST['street_id'])."%";
			$grievance_status_id="%".strip_tags($_POST['grievance_status_id'])."%";
			$grievance_id="%".strip_tags($_POST['grievance_id'])."%";
			$ulbid="%".$ulbid."%";
			$app_type_id=1;
			$query=$conn->prepare($sql);
			$query->bind_param("siiiisi",$person_name,$mobile,$street_id,$grievance_status_id,$grievance_id,$ulbid,$app_type_id);
			
			
			if($_POST['from_date'] !='' && $_POST['to_date'] !=''){
			    
                $sql.=" and date(date_regd) between  ?  and ? " ;
                $sql.=" order by grievance_id desc";
                
                $from_date=$from_date;
                $to_date=$to_date;
                
                $query=$conn->prepare($sql);
                $query->bind_param("siiiisiss",$person_name,$mobile,$street_id,$grievance_status_id,$grievance_id,$ulbid,$app_type_id,$from_date,$to_date);
	            
	            
              }else if($_POST['from_date'] !=''){
                  
                 $sql.=" and date(date_regd) like ? " ;
                 $sql.=" order by grievance_id desc";
                 
                  $from_date=$from_date;
                   $query=$conn->prepare($sql);
                $query->bind_param("siiiisis",$person_name,$mobile,$street_id,$grievance_status_id,$grievance_id,$ulbid,$app_type_id,$from_date);
	                 
              }else if($_POST['to_date'] !=''){
                  
	                $sql.=" and date(date_regd) like ? " ;
	                $sql.=" order by grievance_id desc";
	                $to_date=$to_date;
	                $query=$conn->prepare($sql);
	                $query->bind_param("siiiisis",$person_name,$mobile,$street_id,$grievance_status_id,$grievance_id,$ulbid,$app_type_id,$to_date);
	                 
              }
			                      
			  
	
			
			if($query->execute())
			{
			    $rs=$query->get_result();
				$field_info = $rs->fetch_fields();
				while($row =$rs->fetch_assoc())
				{
					foreach($field_info as $fi => $f) 
						$data[$row['grievance_id']][$f->name]=$row[$f->name];
				}
				
			}
		
			$num_comp=$rs->num_rows;
			$tpl->assign('data',$data);
			$tpl->assign('num_comp',$num_comp);
			if($num_comp==0)
				$tpl->assign('msg','No details found matching your search');
		}
       
	 
		$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=?";
		
		$grievance_status_id='5';
		$query=$conn->prepare($sql);
		$query->bind_param("i",$grievance_status_id);
		
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		
		$sql="select ulbid,ulbname from ulbmst";
		$query=$conn->prepare($sql);
		$query=$conn->prepare($sql);
		if($query->execute())
		{
	        $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
			$ulb_list[$row['ulbid']]=$row['ulbname'];
		}	
		
		$conn->close();
		$tpl->assign('ulbid',$ulbid);
		$tpl->assign('banner',$banner);	
		$tpl->assign('ulb_list',$ulb_list);
	
		$tpl->assign('street_list',$street_list);	
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->display('check_comp_status_cdma.tpl');
		
?>