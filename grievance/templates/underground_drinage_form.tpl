{include file='header.tpl'}
{literal}



<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
    	

    <script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#buss').click(function(){
       //alert();
      $('#ref').load('http://municipalservices.in/manage_wards.php #ref', function() {
           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script>	

<style>
 .main-data{
    background: #4a47a3;
    padding: 10px 0;
}

h1{
    font-size: 32px;
    line-height: 44px;
    color: #fff;
    margin-bottom: 10px;
    font-weight: 600;
}
h3{
    font-size: 23px;
    line-height: 30px;
    color: #fff;
   font-weight: 600;
    text-decoration: underline;
}
.small-cnt{
    font-size: 16px;
    line-height: 20px;
    color: #fff;
    font-weight: 500;
    padding-bottom: 10px;
    font-style: italic;
    
}
label{
    font-size: 14px;
    line-height: 20px;
    color: #000;
    font-weight: 400;
    margin: 0;
}
.checkbox-dt{
    font-size: 14px !important;
    margin-right: 9px !important;
}
.form-control{
    font-size: 16px;
}
p{
    font-size: 18px;
    line-height: 20px;
    color: #000;
    font-weight: 400;
    
}
.form-check-input{
    margin-top: 4px;
}
.enclose-data{
    background: #0099ff ;
    padding: 0;
/*   margin-bottom: 20px;*/
/*    margin-top: 25px;*/
    
}
.font-weight1{
    font-weight: 700;
}
.enclose-data h5{
   color: #fff;
    font-size: 24px;
    line-height: 26px;
    margin: 0;
    padding: 10px 20px;
    
}
.margin-dt{
    margin: 0 -25px;
}
.date-cnt{
    border: 0;
    
}
.declaration-cnt ul li{
    list-style-type: decimal;
    /*padding-bottom: 15px;*/
    padding: 0px;
}
.declaration-cnt ul li p{
    margin-left: 10px;
    line-height: 30px;
    margin-bottom: 0;
}   
.pad_style {
        padding: 20px 0px;
}


.red{
    color:#ff0000;
    font-weight:bold;
}

    
</style>
{/literal}


   		{if isset($msg)}
				<div class="alert alert-success">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
   
  <form action="underground_drinage_form.php" method="post" enctype="multipart/form-data">
    <div class="main-data">
    
        <h3 class="text-center">Application for Under Ground Drainage Connection</h3>
        <h4 class="small-cnt text-center d-block">(To be filled and submitted with documents at CSC at Nizamabad Municipal Corporation office)</h4>
        </div>
            <div class="card" style="background-color:#fff;">
            <div class="card-body">
                <br>
                <br>
    
    <div class="form-cnt row" style="font-size:14px !important;">
            <div class="form-group row align-items-center col-md-6">
        <div class="col-md-5 row m-0 align-items-center">
            <label>
            Applicant Name <strong class="red">*</strong> <br>  <small class="d-block">(In Block Letters)</small>
                </label> 
                </div>
                <div class="col-md-7">
                <input type="text" class="form-control" name="applicant_name" id="applicant_name" required>
                </div>
        </div>
        <div class="form-group row align-items-center col-md-6">
        <div class="col-md-5 row m-0 align-items-center">
            <label>
                House Number <strong class="red">*</strong>
                </label> 
                </div>
                <div class="col-md-7">
                <input type="text" class="form-control" name="hno" id="hno" required>
                </div>
        </div>
         <div class="form-group row align-items-center col-md-6">
        <div class="col-md-5 row m-0 align-items-center">
            <label>
                Address <strong class="red">*</strong>
                </label> 
                </div>
                <div class="col-md-7">
                <input type="text" class="form-control" name="address" id="address" required>
                    
                </div>
        </div>
            <div class="form-group row align-items-center col-md-6">
        <div class="col-md-5 row m-0 align-items-center">
            <label>
                Division/Ward No <strong class="red">*</strong>
                </label> 
                </div>
                <div class="col-md-7">
                    
                <select class="form-control" name="ward_id" id="ward_id" required>
                        <option value="">-- select --</option>
                        {html_options options=$ward_list}
                    </select>
                </div>
        </div>
            <div class="form-group row align-items-center col-md-6">
        <div class="col-md-5 row m-0 align-items-center">
            <label>
                Tel / Mobile No <strong class="red">*</strong>
                </label> 
                </div>
                <div class="col-md-7">
                <input type="number" class="form-control" name="mobile" id="mobile" maxlength="10" required>
                </div>
        </div>
            <div class="form-group row align-items-center col-md-6">
        <div class="col-md-5 row m-0 align-items-center">
            <label>
                E-Mail  <strong class="red">*</strong>
                </label> 
                </div>
                <div class="col-md-7">
                <input type="email" class="form-control" name="email" id="email" required>
                </div>
        </div>
            <div class="form-group row align-items-center col-md-6">
        <div class="col-md-5 row m-0 align-items-center">
            <label>
                Application Type <strong class="red">*</strong>
                </label> 
                </div>
                <div class="col-md-7">
                <select class="form-control" name="app_type" id="app_type" required>
                    <option value="">-- select --</option>
                    {html_options options=$app_list}
                    </select>
                </div>
        </div>
           <!-- <div class="form-group row align-items-center col-md-6">
        <div class="col-md-5 row m-0 align-items-center">
            <label>
                Area of the Structure <strong class="red">*</strong>
                </label> 
                </div>
                <div class="col-md-7">
                <input type="file" class="form-control" name="f1" id="f1" required accept="application/pdf, image/*">
                </div>
        </div>-->
              <div class="form-group row align-items-center col-md-6">
        <div class="col-md-5 row m-0 align-items-center">
            <label>
                Drainage Pipe Size <strong class="red">*</strong>
                </label> 
                </div>
                <div class="col-md-7">
                <select class="form-control" name="pipesize" id="pipesize" required>
                    <option value="">-- select --</option>
                    <option value="1">4</option>
                    <option value="2">6</option>
                    <option value="3">8</option>
                    </select>
                </div>
        </div>
              <div class="form-group row align-items-center col-md-6">
        <div class="col-md-5 row m-0 align-items-center">
            <label>
                Water Source Details   
                </label> 
                </div>
                <div class="col-md-7 row m-0 align-items-center">
                    
                    <div class="col-md-12">
                        
                        
                        <input type="checkbox" class="form-check-input" value="1" name="check_list[]"> Tap Connection
                       
                        
                   </div>
                   
                   <div class="col-md-4">
                     
                  
                    <input type="checkbox" class="form-check-input" value="2" name="check_list[]"> Bore
                 
                 
                </div>
                
                    <div class="col-md-6">
                    
                       
                        <input type="checkbox" class="form-check-input" value="3" name="check_list[]"> Public Tap
                       
                    
                    </div>
                    
               
                    
                
                </div>
        </div>
              <div class="form-group row align-items-center col-md-6">
        <div class="col-md-5 row m-0 align-items-center">
            <label>
                No. of Seats in Toilets <strong class="red">*</strong>
                </label> 
                </div>
                <div class="col-md-7">
                <input type="number" class="form-control" name="toilet_seats" id="toilet_seats" required>
                </div>
        </div>
               
            </div>
                <br>
                <br>
                </div>
            </div>
    
        
        <div class="enclose-data">
             <div class="card-body">
            <h5>Enclosures</h5>
        </div> </div>
        
        <div class="card" style="background-color:#fff; font-size:14px !important;">
        <div class="card-body pad_style ">
        <div class="">
            
        <div class="form-cnt row">
            <div class="form-group row align-items-center col-md-6">
        <div class="col-md-7 row m-0 align-items-center">
            <label class="font-weight1">
                Property Tax Receipt <strong class="red">*</strong>
                </label> 
                </div>
                <div class="col-md-5 row m-0">
                <div class="form-check col-md-4">
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="tax_receipt_yn" id="tax_receipt_yn" value="1"> Yes
  </label>
</div>
                     <div class="form-check col-md-4">
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="tax_receipt_yn" id="tax_receipt_yn" value="2" checked> No
  </label>
</div>
                </div>
        </div>
            <div class="form-group row align-items-center col-md-6">
        <div class="col-md-5 row m-0 align-items-center">
            <label class="font-weight1">
                Aadhar Card <strong class="red">*</strong>
                </label> 
                </div>
                <div class="col-md-5 row m-0">
                <div class="form-check col-md-4">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="adhaar_yn" id="adhaar_yn" value="1"> Yes
                  </label>
                </div>
                     <div class="form-check col-md-4">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="adhaar_yn" id="adhaar_yn" value="2" checked> No
                  </label>
                </div>
                </div>
        </div>
        
            <div class="form-group row align-items-center col-md-6">
        <div class="col-md-7 row m-0 align-items-center">
            <label class="font-weight1"> 
                Food Security card (Only for BPL)  <strong class="red">*</strong>
                </label>
                </div>
                
                <div class="col-md-5 row m-0">
                <div class="form-check col-md-4">
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="fsc_yn" id="fsc_yn" value="1"> Yes
  </label>
</div>
                     <div class="form-check col-md-4">
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="fsc_yn" id="fsc_yn" value="2" checked> No
  </label>
</div>
                </div>
        </div>
        
            <div class="form-group row align-items-center margin-dt col-md-12 mb-5">
        <div class="col-md-12" ><p class="mt-3" style="font-size:14px !important; margin-left:20px; margin-top:30px;">Certified the above particulars furnished are correct and true to best of my knowledge.
</p>
                </div>
                
                </div>
                
            
             <div class="form-group row align-items-center margin-dt col-md-12" style="margin-top:30px; margin-left:20px;">
                <div class="col-md-4 row m-0 align-items-center">
                    <p class="d-flex align-items-center"><label class="mr-2 mb-0 font-weight1">Date  </label>
                    <input type="text" class="form-control" id="datepicker" name="datetime" required ></p>
                </div> 
                <!--<div class="col-md-6">
                <p class="text-center" style="float:right; margin-top:20px;">
                    <label class="d-block text-center font-weight1">Applicant Signature</label>
                    </p>
                </div>-->
        </div>
            
        </div>
    </div>
    </div>
    </div>
        
        
        <!--<div class="enclose-data">
             <div class="card-body">
            <h5>Declaration</h5>
        </div> </div>
        <div class="card" style="background-color:#fff;">
        <div class="card-body pad_style ">
        <div class="">
            
        <div class="form-cnt declaration-cnt">
            <ul >
            <li class="form-group col-md-12" style="margin-left: 34px;">
       <p style="font-size:14px !important;">I/ We are abide to Nizamabad Municipal Corporation Under Ground Drainage
Connection by-laws for submitting Licensed Engineer Approval for fixing <br>External and Internal Pipes in the Under Ground Connection.</p>
            
        </li>
             
             <li class="form-group col-md-12" style="margin-left: 34px;">
       <p style="font-size:14px !important;">I/ We are agreed for inspection of my Home at any time for Under Ground
Connection by Municipal Officials / Officers Appointed by Commissioner,<br> Nizamabad Municipal Corporation.</p>
            
        </li>
             <li class="form-group col-md-12" style="margin-left: 34px;">
       <p style="font-size:14px !important;">As per instructions of Commissioner, Nizamabad Municipal Corporation, I/ We
area agreed to execute the required necessary works for Under <br> Ground Drainage Connections.</p>
            
        </li>
            <li class="form-group col-md-12" style="margin-left: 34px;">
       <p style="font-size:14px !important;">I/ We Pay the Monthly Tariff Amount of Under Ground Drainage fixed by
Nizamabad Municipal Corporation.</p>
            
        </li>
            </ul>
    </div>
    
    
    
    
    
            <div class="form-group row align-items-end mt-5" >
        <div class="col-md-6">
            <p class="d-flex align-items-center" style="margin-top:30px !important;"><label class="mr-2 mb-0 d-block font-weight1">Date:</label>
                
<!--                <input type="text" class="form-control" >
            </p>
            <p class="d-flex align-items-center">
                <label class="mr-2 mb-0 d-block font-weight1">Place:</label>
<!--                <input type="text" class="form-control" >
            </p>
                </div>
                
                <div class="col-md-6">
                <p class="text-center" style="float:right; margin-top:50px !important;" ><label class="d-block text-center font-weight1">Signature of the Applicant</label>
<!--                    <input type="file" class="form-control date-cnt" >
                    </p>
                </div>
        </div>
    </div>
    </div>
        </div>-->
        <div class="text-center" style="margin-top: 20px;">
            <input type="submit" name="save" value="Save" class="btn btn-success">
        </div>
        </form>

         
        {literal}

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script>
$(function() {
    $( "#datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true});
});
</script>

{/literal}




 




{include file='footer.tpl'}

