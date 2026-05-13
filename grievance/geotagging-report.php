<?php
require "config.php";


	date_default_timezone_set('Asia/Calcutta');
    

	ini_set('display_errors',1);
	require_once('Smarty.class.php');
	require_once('csrf.class.php');
    $csrf = new csrf();
	$tpl=new Smarty();
	
	 $token_id = $csrf->get_token_id();
     $token_value = $csrf->get_token($token_id);
     
	if(isset($_SESSION['uid']))
	{
	    
	    
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		//require_once('connection.php');
		//$conn=getconnection();
		
		require_once('prepare_connection.php');
		
		include('user_defined_functions.php');
		$csrf_token=generateToken($csrf_prefix_token);
		$tpl->assign('csrf_token',$csrf_token);
	 	$code=mysqli_real_escape_string($conn,$_SESSION['code']);
		

	     
             
              // echo "<pre>"; print_r($_SESSION);die;
              if($_SESSION['geotagging_status']==1){
	         $sql="select * from geotagging_cat_mst where ParentId=0";
           	 $rs=mysqli_query($conn,$sql);
          
            	while($row = mysqli_fetch_assoc($rs))
	     	{
		    	$geotagginglist[]=array('Id'=>$row['Id'],'Description'=>$row['Description']);
		    }
		     $sqlsub="select * from geotagging_cat_mst where ParentId=1";
           	 $rssub=mysqli_query($conn,$sqlsub);
           	 	while($rows = mysqli_fetch_assoc($rssub))
            {
		    	$geotaggingsublist[]=array('Id'=>$rows['Id'],'Description'=>$rows['Description']);
		    }
		    if($_SESSION['ulb']=='095'){
		      $sqlward="select * from ward_mst where ulbid='".$_SESSION['ulb']."' order by sort_order asc";
		    }else{
		       $sqlward="select * from ward_mst where ulbid='".$_SESSION['ulb']."' GROUP BY ward_desc order by ABS(ward_desc)";  
		    }
		      
           	 $rsward=mysqli_query($conn,$sqlward);
           	 	while($rswards = mysqli_fetch_assoc($rsward))
            {
		    	$geowardlist[]=array('ward_id'=>$rswards['ward_id'],'ward_desc'=>$rswards['ward_desc']);
		    }
		    $_SESSION['ulbid']=$_SESSION['emp_id'].'-'.$_SESSION['user_type'].'-'.$_SESSION['ulbid'].'-'.$_SESSION['uid'];
		    //print_r($_SESSION['ulbid']);die;
		    if($_POST['f_date'] !='' && $_POST['t_date'] !='')
			                     {
			                            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
            			                $datesbw.=" and (date(tb1.Date) between '".$f_date."' and '".$t_date."') " ;
            			                $search['f_date']=$f_date;
            			                $search['t_date']=$t_date;
			                      }
			elseif($_POST['f_date'] !='' && $_POST['t_date'] =='')
			                     {
			                            $f_date = date('Y-m-d',strtotime($_POST['f_date']));
        	                           
            			                $datesbw.=" and tb1.Date = '".$f_date."' " ;
            			                $search['f_date']=$f_date;
            			                
			                      }
			elseif($_POST['f_date'] =='' && $_POST['t_date'] !='')
			                     {
			                           
        	                            $t_date = date('Y-m-d',strtotime($_POST['t_date']));
            			                $datesbw.=" and tb1.Date ='".$t_date."'  " ;
            			                
            			                $search['t_date']=$t_date;
            			                
			                      }else{
			                          $datesbw.="";
			                          $search['f_date']='';
            			              $search['t_date']='';
			                      }
		    if($_POST['Wardno'] !='') {
			                             $Wardno.="and tb1.Wardno='".$_POST['Wardno']."'" ;
            			                 $search['Wardno']=$_POST['Wardno'];
			                          }else{
			                             $Wardno.="";
			                             $search['Wardno']='';
			                         }
			          $search['suld']=$_SESSION['ulb']; 
			          $search['type']=$_POST['type'];
			          if(!empty($_POST['subtype'])){
			              $search['subtype']=$_POST['subtype'];
			          }else{
			              $search['subtype']='';
			          }
		          //     print_r($search['type']);
		          //   print_r($_POST);
		    /*------IIHL-----*/
		    if($_POST['type']==1 and $_POST['subtype'] == 4){
		      
    		     $sqlHhlData="SELECT tb1.*,tb3.ward_desc,tb2.desc FROM `HhlData` tb1 join geotagging_cat_dropdown tb2 on tb1.YesOrNoValue=tb2.id  join ward_mst tb3 on tb1.Wardno=tb3.ward_id where tb1.ulbid='".$_SESSION['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
              $rsHhlData=mysqli_query($conn,$sqlHhlData);
              
                	while($rowsHhlData = mysqli_fetch_assoc($rsHhlData))
    	     	{
    		    	$HhlData[]=array('Id'=>$rowsHhlData['Id'],'Area'=>$rowsHhlData['Area'],
    		    	'ResidentName'=>$rowsHhlData['ResidentName'],
    		    	'HHToiletFacility'=>$rowsHhlData['HHToiletFacility'],'HHno'=>$rowsHhlData['HHno']
    		    	,'MobileNo'=>$rowsHhlData['MobileNo'],'Wardno'=>$rowsHhlData['ward_desc']
    		    	,'HHToiletFacility'=>$rowsHhlData['HHToiletFacility'],'YesOrNoValue'=>$rowsHhlData['desc']
    		    	,'latitude'=>$rowsHhlData['latitude']
    		    	,'longitude'=>$rowsHhlData['longitude'],'CaptureImagePath'=>$rowsHhlData['CaptureImagePath']
    		    	,'DateTime'=>$rowsHhlData['DateTime']);
    		    }
    		   
    		     if(!empty($HhlData)){ $gethead='Septic Tank (IHHL)'; }else{ $gethead='';  $norecors='No Records';} 
    		    
		    }else{
		          $HhlData=0;  
		    }
		    /*------PUBLIC**COMMUNITY***OTHER TOILETS-----*/
		     if($_POST['type']==1 and ($_POST['subtype']==5 || $_POST['subtype']==6 || $_POST['subtype']==7)){
		         
    		    $sqlPCO="SELECT tb1.*,tb2.ward_desc FROM `public_community_other_toilets` tb1 join ward_mst tb2 on tb1.Wardno=tb2.ward_id where tb1.ulbid='".$_SESSION['ulb']."' and tb1.ToiletID='".$_POST['subtype']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rsPCO=mysqli_query($conn,$sqlPCO);
              
                	while($rowsPCO = mysqli_fetch_assoc($rsPCO))
    	     	{
    		    	$PCO[]=array('Id'=>$rowsPCO['Id'],'Area'=>$rowsPCO['Area'],'Wardno'=>$rowsPCO['ward_desc']
    		    	,'Longitude'=>$rowsPCO['latitude'].'  & '.$rowsPCO['longitude'],'latitude'=>$rowsPCO['latitude']
    		    	,'longitudes'=>$rowsPCO['longitude'],'CaptureImagePath'=>$rowsPCO['CaptureImagePath']
    		    	,'DateTime'=>$rowsPCO['DateTime']);
    		    }
    		    if($_POST['subtype']==5){ if(!empty($PCO)){$gethead='Septic Tank (Public Toilets)'; }else{ $gethead='';  $norecors='No Records';}  }
    		    if($_POST['subtype']==6){ if(!empty($PCO)){$gethead='Septic Tank (Community Toilets)'; }else{ $gethead='';  $norecors='No Records';}  }
    		    if($_POST['subtype']==7){ if(!empty($PCO)){$gethead='Septic Tank (Others)'; }else{ $gethead='';  $norecors='No Records';} }
		     }else{
		          $PCO=0;  
		      }
		    /*------Maintance holes-----*/
		     if($_POST['type']==2  and empty($_POST['subtype'])){
		        
		       //  PRINT_R($_POST);DIE;
    		    $sqlsub="SELECT tb2.desc,tb1.*,tb3.ward_desc FROM `MHolesMst` tb1 join geotagging_cat_dropdown tb2 on tb1.ConditionValue=tb2.id join ward_mst tb3 on tb1.Wardno=tb3.ward_id where tb1.ulbid='".$_SESSION['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rssub=mysqli_query($conn,$sqlsub);
              
                	while($rows = mysqli_fetch_assoc($rssub))
    	     	{
    		    	$MHolesMst[]=array('Id'=>$rows['Id'],'Area'=>$rows['Area'],'UniqueId'=>$rows['UniqueId']
    		    	,'ConditionValue'=>$rows['desc'],'Wardno'=>$rows['ward_desc']
    		    	,'SewerLineLength'=>$rows['SewerLineLength']
    		    	,'Longitude'=>$rows['latitude'].'  & '.$rows['longitude'],'latitude'=>$rows['latitude']
    		    	,'longitudes'=>$rows['longitude'],'CaptureImagePath'=>$rows['CaptureImagePath']
    		    	,'DateTime'=>$rows['DateTime']);
    		    }
    		     if(!empty($MHolesMst)){ $gethead='Maintenance Holes'; }else{ $gethead='';  $norecors='No Records';} 
		     }else{
		      //  ECHO $_POST['subtype'];
		      //    PRINT_R($_POST['type']);DIE;
		          $MHolesMst=0;  
		      }
		    /*------IEC HODINGS-----*/
		     if($_POST['type']==3  and empty($_POST['subtype'])){
		          
    		     $sqlIEC="SELECT tb1.*,tb2.ward_desc FROM `IECHoardings` tb1 join ward_mst tb2 on tb1.Wardno=tb2.ward_id where tb1.ulbid='".$_SESSION['ulb']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rsIEC=mysqli_query($conn,$sqlIEC);
              
                	while($rowsIEC = mysqli_fetch_assoc($rsIEC))
    	     	{
    		    	$IECHODINGS[]=array('Id'=>$rowsIEC['Id'],'Area'=>$rowsIEC['Area'],'Wardno'=>$rowsIEC['ward_desc']
    		    	,'UniqueId'=>$rowsIEC['UniqueId'],'Slum_Unplanned_colony'=>$rowsIEC['Slum_Unplanned_colony']
    		        ,'Longitude'=>$rowsIEC['latitude'].'  & '.$rowsIEC['longitude'],'latitude'=>$rowsIEC['latitude']
    		    	,'longitudes'=>$rowsIEC['longitude'],'CaptureImagePath'=>$rowsIEC['CaptureImagePath']
    		        ,'DateTime'=>$rowsIEC['DateTime']);
    		    }
    		     if(!empty($IECHODINGS)){ $gethead='IEC HOARDINGS'; }else{ $gethead='';  $norecors='No Records';} 
		     }else{
		          $IECHODINGS=0;  
		     }
		     /*------stroms drain-----*/
		     if($_POST['type']==8  and empty($_POST['subtype'])){
		          
    		     $sqldrain="SELECT tb1.*,tb2.ward_desc FROM `Drain_SewersUGD` tb1 join ward_mst tb2 on tb1.Wardno=tb2.ward_id where tb1.ulbid='".$_SESSION['ulb']."' and tb1.Typeid='".$_POST['type']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rsdrain=mysqli_query($conn,$sqldrain);
              
                	while($rowsdrain = mysqli_fetch_assoc($rsdrain))
    	     	{
    		    	$stromsdrain[]=array('Id'=>$rowsdrain['Id'],'AreaFrom'=>$rowsdrain['AreaFrom'],'AreaTo'=>$rowsdrain['AreaTo'],'Wardno'=>$rowsdrain['ward_desc']
    		    	,'Length'=>$rowsdrain['Length'],'Remarks'=>$rowsdrain['Remarks']
    		        ,'Longitude'=>$rowsdrain['latitude'].'  & '.$rowsdrain['longitude'],'latitude'=>$rowsdrain['latitude']
    		    	,'longitudes'=>$rowsdrain['longitude'],'CaptureImagePath'=>$rowsdrain['CaptureImagePath']
    		        ,'DateTime'=>$rowsdrain['DateTime']);
    		          
    		    }
    		     if(!empty($stromsdrain)){ $gethead='Storm water drain'; }else{ $gethead='';  $norecors='No Records';} 
		     }else{
		          $stromsdrain=0;  
		     }
		     /*------SewersUGD-----*/
		     if($_POST['type']==9  and empty($_POST['subtype'])){
		          
    		     $sqlUGD="SELECT tb1.*,tb2.ward_desc FROM `Drain_SewersUGD` tb1 join ward_mst tb2 on tb1.Wardno=tb2.ward_id where tb1.ulbid='".$_SESSION['ulb']."' and tb1.Typeid='".$_POST['type']."' $Wardno $datesbw  ORDER BY tb1.Id DESC";
               	 $rsUGD=mysqli_query($conn,$sqlUGD);
              
                	while($rowsUGD = mysqli_fetch_assoc($rsUGD))
    	     	{
    		    	$SewersUGD[]=array('Id'=>$rowsUGD['Id'],'AreaFrom'=>$rowsUGD['AreaFrom'],'AreaTo'=>$rowsUGD['AreaTo'],'Wardno'=>$rowsUGD['ward_desc']
    		    	,'Length'=>$rowsUGD['Length'],'Remarks'=>$rowsUGD['Remarks']
    		        ,'Longitude'=>$rowsUGD['latitude'].'  & '.$rowsUGD['longitude'],'latitude'=>$rowsUGD['latitude']
    		    	,'longitudes'=>$rowsUGD['longitude'],'CaptureImagePath'=>$rowsUGD['CaptureImagePath']
    		        ,'DateTime'=>$rowsUGD['DateTime']);
    		          
    		    }
    		   
    		     if(!empty($SewersUGD)){ $gethead='Sewers UGD'; }else{ $gethead='';  $norecors='No Records';} 
		     }else{
		          $SewersUGD=0;  
		     }
              }else{
              	echo "<script>window.location='index.php';</script>";    
              }
 // print_r($SewersUGD);die;
	    $users_count=$row['user_count'];
	    $tpl->assign('users_count',$users_count);
        $tpl->assign('user_type',$_SESSION['user_type']);
		$conn->close();
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('ulbid',$_SESSION['ulbid']);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('ward_list1',$ward_list1);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('code',$code);
		$tpl->assign('token_id',$token_id);
		$tpl->assign('geowardlists',$geowardlist);
		$tpl->assign('geotagging',$geotagginglist);
		$tpl->assign('geotaggingsub',$geotaggingsublist);
		$tpl->assign('manhole',$MHolesMst);
		$tpl->assign('IEChodding',$IECHODINGS);
		$tpl->assign('SewersUGD',$SewersUGD);
		$tpl->assign('stromsdrain',$stromsdrain);
		$tpl->assign('IIHL',$HhlData);
		$tpl->assign('pub_com_othr',$PCO);
	    $tpl->assign('datahead',$gethead);
	    $tpl->assign('nrcds',$norecors);
	    $tpl->assign('search',$search);
		$tpl->display('geotagging-report.tpl');
		
		
	}
	
		
	
	
	else
	{
	/*	$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		echo "<script>window.location='index.php';</script>";
	}
?>