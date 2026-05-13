<?php
        require "config.php";
        date_default_timezone_set('Asia/Calcutta');
	    ini_set('display_errors',0);
	    require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
?>
		

				   <p></p>
				   <div class="row">
							<div class="col-md-6">
							
							<select class="form-control" id="graph_report_id">
							
							<option value="">-- select --</option>
							<option value="1">Citizen Satisfaction </option>
							<option value="2">Average Rating </option>
							<option value="3">Feedback Received  </option>
							<!--<option value="4">Grievance month </option>-->
							<option value="5">Grievance Statistics  </option>
							<option value="6">Citizen Feedback by Department wise </option>
							<option value="7">Top 10 grievances (complaint  type & zone wise) </option>
							<option value="8">Department wise & zone-wise Grievance Analysis </option>
							<option value="9">Top 10 Grievance zone wise </option>
							<option value="10">Zone map report </option>
							
							
							</select>
							
							</div>
							
							<div class="col-md-6">
							<input type="button" name="search" value="Get Data" class="btn btn-success" onclick="get_charts()">
							</div>
						
						</div>
						
						
						<div class="row">
							<div class="col-md-12">
								<div id="loading_graph" style="display:none; text-align:center;">
			  
										<h4>Please Wait.. </h4>
			    
								</div>
							</div>
							<div class="col-md-12">
								<div id="result_graph" style="display:block; text-align:center;">
			  
										
			    
								</div>
							</div>
						
						</div>
                
                
                
				</div>
			</div>
		</div>
				
				
			</div>
			
			<?php
			mysqli_close($conn);
			?>