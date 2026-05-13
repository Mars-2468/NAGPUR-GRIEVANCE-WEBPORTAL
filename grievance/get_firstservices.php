<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_REQUEST['id']))
	{
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		$cs_id=0;
        $sql=$conn->prepare("select cs_id,cs_desc from standard_services where cs_id NOT IN(?)");
        $sql->bind_param("i",$cs_id);
		$sql->execute();
		$rs = $sql->get_result();
		
		if($rs)
		{
			while($row = $rs->fetch_assoc())
				$service_list[$row['cs_id']]=$row['cs_desc'];
		}
		
		$sql=$conn->prepare("select ulbid from ulbmst where ulbname =?");
		$uid =htmlspecialchars(strip_tags($_SESSION['uid']));
        $sql->bind_param("s",$uid);
		$sql->execute();
		$rs1 = $sql->get_result();
		
		$rows = $rs1->fetch_assoc();
		$ulbid = $rows['ulbid'];
		
		$conn->close();
	}
	
	
?>

<div>

<fieldset>
    
    <!-- begin row -->
    
    <div class="row">
       
        <div class="col-md-3" style="margin-left:15px; margin-right:15px;">
		<div class="form-group">
			<label> Select Service<span class="required" style="color:red"> * </span> </label>
			<select name="cs_id" id="cs_id" class="form-control dropdown" onchange="getCompform(this.value,'<?php echo $ulbid?>')">
				<option value="0">--- Select Service ---</option>
				<?php
				foreach($service_list as $cs_id=>$comp_desc)
				{
				?>
				<option value="<?php echo $cs_id; ?>"><?php echo $comp_desc; ?></option>
				<?php
				}
				?>
			</select>
		</div>
        </div>
        <!-- end col-4 -->
    </div>
   
</fieldset>
</div>