<?php
require "config.php";
	ini_set('display_errors',1);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		if(isset($_POST['save']))
		{
		    for($i=0; $i<=$_POST['cnt']; $i++)
		    {
		        $cs_id="cs_id".$i;
		        $cutt_of_time="cutt_of_time".$i;
		        if($_POST[$cs_id]!='')
		        {
		            
		        $sql ="insert into comp_cutofdays_map(cs_id,cutt_off_time)values(?,?) ON DUPLICATE KEY UPDATE cutt_off_time=? ";
		        
		        $cs_id=strip_tags($_POST[$cs_id]);
		        $cutt_of_time=strip_tags($_POST[$cutt_of_time]);
		        
		        $query=$conn->prepare($sql);
		        $query->bind_param("iii",$cs_id,$cutt_of_time,$cutt_of_time);
		        if(!$query->execute())
                {
                echo "Query not executed 1";
                }
		     
		        }
		    }
		
		  $query->execute();
		  $rs = $query->get_result(); 		
			
if($rs)
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
		
	$sql ="SELECT * FROM `comp_cutofdays_map`";
	  $query=$conn->prepare($sql);
		
		if(!$query->execute())
            {
                echo "Query not executed 2";
            }
           $rs1=$query->get_result();

	while($row = $rs1->fetch_assoc())
	{
	    $data[$row['cs_id']]['cutt_off_time']=$row['cutt_off_time'];
	}
		
		
		$sql ="select cat_id,description from category_mst where ulbid= ? and cs_type_id= ? "; 
		
		$ulbid='500';
		$cs_type_id='1';
		
		$query=$conn->prepare($sql); 
		
		$query->bind_param("si",$ulbid,$cs_type_id);
		
		  if(!$query->execute())
            {
                echo "Query not executed 3";
            }
           $rs2=$query->get_result();
           
	
		while($row = $rs2->fetch_assoc())
		{
		    $cat_list[$row['cat_id']]=$row['description'];
		}
		
		$sql ="select * from cs_mst";
		
		$query=$conn->prepare($sql);
			if(!$query->execute())
            {
                echo "Query not executed 4";
            }
           $rs4=$query->get_result();
           
	
		while($row = $rs4->fetch_assoc())
		{
		    $cs_list[$row['cat_id']][$row['cs_id']]['desc']=$row['cs_desc'];
		}
		$conn->close();
        $tpl->assign('data',$data);   	
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('cat_list',$cat_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('comp_cutoffdate_map.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>