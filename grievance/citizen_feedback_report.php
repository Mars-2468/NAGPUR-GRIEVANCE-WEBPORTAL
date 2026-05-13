<?php
require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		if(isset($_POST['save1']))
		{
		    for($i=0; $i<=$_POST['cnt']; $i++)
		    {
		        $cs_id="cs_id".$i;
		        $cutt_of_time="cutt_of_time".$i;
		        if($_POST[$cs_id]!='')
		        {
		         
		         
		         
		         $sql ="insert into comp_cutofdays_map(cs_id,cutt_off_time)values(?,?)
		         ON DUPLICATE KEY UPDATE cutt_off_time=?";
		         $cs_id=$_POST[$cs_id];
		         $cutt_off_time=$_POST[$cutt_of_time];
		         $query=$conn->prepare($sql);
		         $query->bind_param("iss",$cs_id,$cutt_off_time,$cutt_off_time);
		         
		         
		        }
		    }
		
		  
				
			
            if($query->execute())
			{
				$tpl->assign('class','alert alert-success display-hide');
				$tpl->assign('msg','Saved Successfully ');
			}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$tpl->assign('msg','Unable to Process, Please try again');
			}

		}
	
	$sql = $conn->prepare("select count(r.grievance_id) as 5star,c.cs_id from rating_mst r , grievances g , cs_mst c where g.grievance_id = r.grievance_id and 
	c.cs_id = g.cat3_id and rating_no = ? and g.ulbid = ? group by g.cat3_id");
	$rating_no=5;
	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$sql->bind_param("is",$rating_no,$ulbid);
	$sql->execute();
	$rs=$sql->get_result();
	while($row= $rs->fetch_assoc())
	{
	    $data[$row['cs_id']]['5star']=$row['5star'];
	    $tot= $data[$row['cs_id']]['5star'];
	    $totals[5]+=$row['5star'];
	    $totals['tot']+=$row['5star'];
	}
	

	$sql = $conn->prepare("select count(r.grievance_id) as 5star,c.cs_id from rating_mst r , grievances g , cs_mst c where g.grievance_id = r.grievance_id and 
	c.cs_id = g.cat3_id and rating_no = ? and g.ulbid = ? group by g.cat3_id");
	$rating_no=5;
	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$sql->bind_param("is",$rating_no,$ulbid);
	$sql->execute();
	$rs=$sql->get_result();
	while($row= $rs->fetch_assoc())
	{
	    $data[$row['cs_id']]['5star']=$row['5star'];
	    $tot= $data[$row['cs_id']]['5star'];
	    $totals[5]+=$row['5star'];
	    $totals['tot']+=$row['5star'];
	}
	
	

	$sql=$conn->prepare("select count(r.grievance_id) as 3star,c.cs_id from rating_mst r , grievances g , cs_mst c where g.grievance_id = r.grievance_id and 
	c.cs_id = g.cat3_id and rating_no = ? and g.ulbid = ? group by g.cat3_id");
	$rating_no=3;
	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$sql->bind_param("is",$rating_no,$ulbid);
	$sql->execute();
	$rs=$sql->get_result();
	while($row= $rs->fetch_assoc())
	{
	    $data2[$row['cs_id']]['3star'] = $row['3star'];
	    $tot3=$data2[$row['cs_id']]['3star'];
	     $totals[3]+=$row['3star'];
	     $totals['tot']+=$row['3star'];
	}

	

	$sql=$conn->prepare("select count(r.grievance_id) as 2star,c.cs_id from rating_mst r , grievances g , cs_mst c where g.grievance_id = r.grievance_id and 
	c.cs_id = g.cat3_id and rating_no = ? and g.ulbid = ? group by g.cat3_id");
	$rating_no=2;
	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$sql->bind_param("is",$rating_no,$ulbid);
	$sql->execute();
	$rs=$sql->get_result();
	while($row= $rs->fetch_assoc())
	{
	    $data3[$row['cs_id']]['2star'] = $row['2star'];
	    $tot4=$data3[$row['cs_id']]['2star'];
	     $totals[2]+=$row['2star'];
	     $totals['tot']+=$row['2star'];
	}
	$sql=$conn->prepare("select count(r.grievance_id) as 1star,c.cs_id from rating_mst r , grievances g , cs_mst c where g.grievance_id = r.grievance_id and 
	c.cs_id = g.cat3_id and rating_no = ? and g.ulbid = ? group by g.cat3_id");
	$rating_no=1;
	$ulbid=htmlspecialchars(strip_tags($_SESSION['ulbid']));
	$sql->bind_param("is",$rating_no,$ulbid);
	$sql->execute();
	$rs=$sql->get_result();
	while($row= $rs->fetch_assoc())
	{
	    $data4[$row['cs_id']]['1star'] = $row['1star'];
	    $tot5=$data4[$row['cs_id']]['1star'];
	     $totals[1]+=$row['1star'];
	      $totals['tot']+=$row['1star'];
	}
	
		$sql=$conn->prepare("select cat_id, description from category_mst where ulbid=? and cs_type_id=?");
		$ulbid=250;
		$cs_type_id=1;
		$sql->bind_param("si",$ulbid,$cs_type_id);
		$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		  $cat_list[$row['cat_id']]=$row['description'];  
		}
		
		
		$sql=$conn->prepare("select cs_id,cat_id, cs_desc from cs_mst where  cs_type_id=?");
		$ulbid=250;
		$cs_type_id=1;
		$sql->bind_param("i",$cs_type_id);
		$sql->execute();
		$rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		  $cs_all_list[$row['cs_id']]['cs_desc']=$row['cs_desc']; 
		  $cs_all_list[$row['cs_id']]['cat_id']=$row['cat_id']; 
		}
	
		
		$sql ="select count(DISTINCT(r.grievance_id)) as count,cat3_id from rating_mst r, grievances g where r.grievance_id=g.grievance_id group by cat3_id";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs)){
		$data['feedbacks'][$row['cat3_id']]['count'] = $row['count'];
		}
		
		
		
		
		/*$sql =$conn->prepare("select COUNT(id) as user_count from login_details where type='1' and ulbid =?");
		$sql->bind_param("s",htmlspecialchars(strip_tags($_SESSION['ulbid'])));
		$sql->execute();
	    $rs=$sql->get_result();
	    $row = $rs->fetch_assoc();*/
	    $conn->close();
	    
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
		 
		 
		$conn->close();
		$tpl->assign('cs_all_list',$cs_all_list);
		$tpl->assign('totals',$totals); 
        $tpl->assign('data',$data); 
       
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('cat_list',$cat_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('citizen_feedback_report.tpl');
	}
	else
	{
		
		echo "<script>window.location='index.php';</script>";
	}
?>