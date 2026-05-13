<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	require_once('csrf.class.php');
    $csrf = new csrf();
	$tpl=new Smarty();
	
	
	$token_id = $csrf->get_token_id(); 
    $token_value = $csrf->get_token($token_id); 
      
	if(isset($_SESSION['uid']) )
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
	
   
		if(isset($_POST['save']))
		
		{
		
		if($token_id==$_POST['token']){
	
			$sql="update tanker_mst set taker_number=?,name=?,mobile=?,address=? where tanker_id=?";
			$query=$conn->prepare($sql);
			$taker_number = mysqli_real_escape_string($conn,preg_replace('/[^A-Za-z0-9]/', ' ',$_POST['taker_number']));
			$name= mysqli_real_escape_string($conn,strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',$_POST['name'])));
			$mobile=mysqli_real_escape_string($conn,strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',$_POST['mobile'])));
            $address=mysqli_real_escape_string($conn,strip_tags(preg_replace('/[^A-Za-z0-9]/', ' ',$_POST['address'])));
			$tanker_id=$_POST['tanker_id'];
			
			$query->bind_param("ssssi",$taker_number,$name,$mobile,$address,$tanker_id);
			
			
			
			if($query->execute())
			{
			   
				$tpl->assign('class','alert alert-success display-hide');
				$msg="Successfully Added  Details";
				
			   
				
				$sql=$conn->prepare("delete from tanker_officer_map where tanker_id=?");
			    $tanker_id=$_POST['tanker_id'];
			    $sql->bind_param("i",htmlspecialchars(strip_tags($tanker_id)));
		        $sql->execute();
	            $rs=$sql->get_result();	
			
				
			    for($i=1; $i<=$_POST['cnt']; $i++)
				{
				    $name="name".$i;
				    $mobile="mobile".$i;
				    if(!$_POST[$name]=="")
				    {
				    
				    
				    $sql="insert into tanker_officer_map(tanker_id,name,mobile)values(?,?,?)";
				    $query=$conn->prepare($sql);
				    $tanker_id=$_POST['tanker_id'];
				    $name = mysqli_real_escape_string($conn,strip_tags($_POST[$name]));
				    $mobile = mysqli_real_escape_string($conn,strip_tags($_POST[$mobile]));
				    $query->bind_param("iss",$tanker_id,$name,$mobile);
				    }
				
			}	
				
				
				
			}
			else
			{
				$tpl->assign('msg','alert alert-danger display-hide');
				$msg="Unable to insert ".$sql;
				}
			
			$tpl->assign('msg',$msg);
			
		}
		
		}
		
		
	
			$sql=$conn->prepare("SELECT * FROM tanker_mst where tanker_id=?");
			$tanker_id=htmlspecialchars(strip_tags($_POST['tanker_id']));
			$sql->bind_param("i",$tanker_id);
			$sql->execute();
			$rs=$sql->get_result();
			if($rs->num_rows > 0)
			{ $i=1;
				$field_info = $rs->fetch_fields();
				while($row = $rs->fetch_assoc())
				{
						foreach($field_info as $fi => $f) 
						$data[$f->name]=$row[$f->name];
						$i++;
				}
				       
					$tpl->assign('tanker_mst_list',$tanker_mst_list);
			}else
			{  // $msg="No records available";
			   $tpl->assign('fail',$msg);
			}
			
			
				
		$sql=$conn->prepare("select * from tanker_officer_map where tanker_id=?");
		$tanker_id=htmlspecialchars(strip_tags($_POST['tanker_id']));
		$sql->bind_param("i",$tanker_id);
		$sql->execute();
		$rs=$sql->get_result();
		$i=1;
		while($row = $rs->fetch_assoc())
				{
						foreach($field_info as $fi => $f) 
							$data2[$i][$f->name]=$row[$f->name];
							 $i++;
				}
				
		$conn->close();		
		$tpl->assign('tanker_id',$_POST['tanker_id']);
		$tpl->assign('i',$i);		
		$tpl->assign('data2',$data2);
		$tpl->assign('data',$data);
		$tpl->assign('num_emp',$num_emp);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('desg_list',$desg_list);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('token_id',$token_id);
		$tpl->display('update_tankers.tpl');
	}
	else
	{
	
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>