{include file='header.tpl'}
{literal}

<style>
table tr:nth-child(odd) {
 background-color: #f1f1f1;
}
table tr:nth-child(even) {
 background-color: #ffffff;
}
</style>

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
    	<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
    	

    	
 
    	


<script>
function fill(ward_id,ward_desc)
{
	document.manage_wards.ward_id.value=ward_id;
	document.manage_wards.ward_desc.value=ward_desc;
} 

function delete_ward(ward_id)
{
	
	if(confirm('Do You really want to delete this record'))
	{
	
		$.post('ajax_del_ward.php',{ward_id:ward_id},function(data)
		{
		if(data==1)
		{
		alert('Ward deleted successfully');
		window.location='manage_wards.php';
		}
		else if(data==0)
		{
		alert('Unable to delete , Try again');
		}
		else if(data==2)
		{
		alert('Ward is mapped with employees You cannot delete this ward');
		}
		
		});
	}

} 

function validateForm()
{
	var ward_desc=document.manage_wards.ward_desc.value;		
	if(ward_desc=='')
	{
		alert("Please Enter Ward No / Description");
		return false;
	}

	return true;
}

function fun1()
{
	var value1=parseFloat($("#literacy_male").val());
	var value2=parseFloat($("#literacy_female").val());
	if(isNaN(value1)){value1=0;}
	if(isNaN(value2)){value2=0;}
	
	
	$("#literacy_total").val(value1+value2);
	
}
function fun2()
{
	var value1=parseFloat($("#private_highschools").val());
	var value2=parseFloat($("#private_upper_prischools").val());
	var value3=parseFloat($("#private_primary_schools").val());
	var value4=parseFloat($("#gove_highschools").val());
	var value5=parseFloat($("#gove_upper_prischools").val());
	var value6=parseFloat($("#gove_primary_schools").val());
	if(isNaN(value1)){value1=0;}
	if(isNaN(value2)){value2=0;}
	if(isNaN(value3)){value3=0;}
	if(isNaN(value4)){value4=0;}
	if(isNaN(value5)){value5=0;}
	if(isNaN(value6)){value6=0;}
	$("#tot_highschools").val( value1+value4);
	$("#tot_upper_prischools").val( value2+value5);
	$("#tot_primary_schools").val( value3+value6);
	
	
}
function assetsyn(value)
{
	if(value==1)
	{
		$("#muncipal_building").show('slow');
	}
	else
	{
		$("#muncipal_building").hide('slow');
	}
}
</script>
{/literal}




 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4></h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
               
			<form   method="post" action="town_profile.php" class="form-horizontal" onSubmit="return validateForm()">
			<input type='hidden' name='ward_id' value='0'>
				<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
					<div >
<form name="form" method="POST" action="town_profile.php" enctype="multipart/form-data" onSubmit="return validateForm();">
<input type="hidden" name="ulbid" value="{$ulbid}">
  </br>
  
  
<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">
  <tr style="background:#CCC;">
    <td colspan="4" align="center" class="bg-danger"><strong>Town Profile </strong></td>
  </tr>
 
  <tr>
    <td colspan="3">Area </td>
    <td width="51%"><label>
      <input type="text" name="area" id="area" value="{$data.area}" class="floatnum"/> Sq.Mtrs
    </label></td>
  </tr>
  <tr>
    <td colspan="3">Year of Constitution </td>
    <td><input type="text" name="year_of_const" id="year_of_const" value="{$data.year_of_const}"/></td>
  </tr>
  
  <tr>
    <td width="15%" rowspan="6">Population </td>
    <td width="12%" rowspan="2"><strong>2001 Census </strong></td>
    <td width="22%">Male </td>
    <td><input type="text" name="male_pop_2001" id="male_pop_2001" value="{$data.male_pop_2001}" class="num" onchange="fun3()"/></td>
  </tr>
  <tr>
    <td>Female </td>
    <td><input type="text" name="female_pop_2001" id="female_pop_2001" value="{$data.female_pop_2001}" class="num" onchange="fun3()"/></td>
  </tr>
 
  <tr>
    <td rowspan="2"><strong>20011 Census</strong> </td>
    <td>Male </td>
    <td><input type="text" name="male_pop_2011" id="male_pop_2011" value="{$data.male_pop_2011}" class="num"/></td>
  </tr>
  <tr>
    <td height="38">Female </td>
    <td><input type="text" name="female_pop_2011" id="female_pop_2011" value="{$data.female_pop_2011}" class="num"/></td>
  </tr>
 
  <tr>
    <td rowspan="2"><strong>Current</strong> </td>
    <td>Male </td>
    <td><input type="text" name="male_pop_current" id="male_pop_current" value="{$data.male_pop_current}" class="num"/></td>
  </tr>
  <tr>
    <td>Female </td>
    <td><input type="text" name="female_pop_current" id="female_pop_current" value="{$data.female_pop_current}" class="num"/></td>
  </tr>
  
  <tr>
    <td>SC Population </td>
    <td colspan="2">2001 Census</td>
    <td><input type="text" name="pop_sc" id="pop_sc" value="{$data.pop_sc}" class="num"/></td>
  </tr>
  <tr>
    <td>ST Population </td>
    <td colspan="2">2001 Census</td>
    <td><input type="text" name="pop_st" id="pop_st" value="{$data.pop_st}" class="num"/></td>
  </tr>
  <tr>
    <td rowspan="2">House Holds </td>
    <td colspan="2">2001 Census </td>
    <td><input type="text" name="households_2001" id="households_2001" value="{$data.households_2001}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="2">2011 Census </td>
    <td><input type="text" name="households_2011" id="households_2011" value="{$data.households_2011}" class="num"/></td>
  </tr>
  <tr>
    <td rowspan="3">literecy rate </td>
    <td colspan="2">Male </td>
    <td><input type="text" name="literacy_male" id="literacy_male" value="{$data.literacy_male}" class="floatnumpercent" onkeyup="fun1()"/> % </td>
  </tr>
  <tr>
    <td colspan="2">Female </td>
    <td><input type="text" name="literacy_female" id="literacy_female" value="{$data.literacy_female}" class="floatnumpercent" onkeyup="fun1()"/> % </td>
  </tr>
  <tr>
    <td colspan="2">Total </td>
    <td><input type="text" name="literacy_total" id="literacy_total" value="{$data.literacy_total}" class="floatnumpercent" readonly/> % </td>
  </tr>
  <tr>
    <td colspan="3">Municipal Wards </td>
    <td><input type="text" name="muncipal_wards" id="muncipal_wards" value="{$data.muncipal_wards}" class="num"/></td>
  </tr>
  <tr>
    <td rowspan="2">Slums </td>
    <td colspan="2">Notified </td>
    <td><input type="text" name="slums_notified" id="slums_notified" value="{$data.slums_notified}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="2">Non Notified </td>
    <td><input type="text" name="slums_non_notified" id="slums_non_notified" value="{$data.slums_non_notified}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="3">Slum Population </td>
    <td><input type="text" name="slum_pop" id="slum_pop" value="{$data.slum_pop}" class="num"/></td>
  </tr>
  <tr>
    <td rowspan="2">Total Staff </td>
    <td height="36" colspan="2">Regular </td>
    <td><input type="text" name="staff_reg" id="staff_reg" value="{$data.staff_reg}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="2">Outsourcing </td>
    <td><input type="text" name="staff_outsrc" id="staff_outsrc" value="{$data.staff_outsrc}" class="num"/></td>
  </tr>
</table>

<p><br />
</p>
<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">
  <tr style="background:#dfdfdf;" class="bg-success">
    <td colspan="4" align="center"><strong>Educational Institutions </strong></td>
  </tr>
  <tr>
    <td width="15%" rowspan="9" align="left">Schools </td>
    <td width="13%" rowspan="3" align="center">Private </td>
    <td width="21%">High schools </td>
    <td width="51%"><input type="text" name="private_highschools" id="private_highschools" value="{$data.private_highschools}" class="num" onkeyup="fun2()"/></td>
  </tr>
  <tr>
    <td>Upper primary schools </td>
    <td><input type="text" name="private_upper_prischools" id="private_upper_prischools" value="{$data.private_upper_prischools}" class="num" onkeyup="fun2()"/></td>
  </tr>
  <tr>
    <td>Primary schools </td>
    <td><input type="text" name="private_primary_schools" id="private_primary_schools" value="{$data.private_primary_schools}" class="num" onkeyup="fun2()"/></td>
  </tr>
  <tr>
    <td rowspan="3" align="center">Government </td>
    <td width="21%">High schools </td>
    <td><input type="text" name="gove_highschools" id="gove_highschools" value="{$data.gove_highschools}" class="num" onkeyup="fun2()"/></td>
  </tr>
  <tr>
    <td>Upper primary schools </td>
    <td><input type="text" name="gove_upper_prischools" id="gove_upper_prischools" value="{$data.gove_upper_prischools}" onkeyup="fun2()"/></td>
  </tr>
  <tr>
    <td>Primary schools </td>
    <td><input type="text" name="gove_primary_schools" id="gove_primary_schools" value="{$data.gove_primary_schools}" class="num" onkeyup="fun2()"/></td>
  </tr>
  <tr>
    <td rowspan="3" align="center">Total </td>
    <td width="21%">High schools </td>
    <td><input type="text" name="tot_highschools" id="tot_highschools" value="{$data.tot_highschools}" class="num" /></td>
  </tr>
  <tr>
    <td>Upper primary schools </td>
    <td><input type="text" name="tot_upper_prischools" id="tot_upper_prischools" value="{$data.tot_upper_prischools}" class="num"/></td>
  </tr>
  <tr>
    <td>Primary schools </td>
    <td><input type="text" name="tot_primary_schools" id="tot_primary_schools" value="{$data.tot_primary_schools}" class="num" readonly/></td>
  </tr>
  <tr>
    <td rowspan="4" align="left">Colleges</td>
    <td rowspan="2" align="center">Private </td>
    <td>Junior/Polytechnic Colleges </td>
    <td><input type="text" name="private_junior_colleges" id="private_junior_colleges" value="{$data.private_junior_colleges}" class="num"/></td>
  </tr>
  <tr>
    <td>Degree/Engineering/Post Graduation Colleges </td>
    <td><input type="text" name="private_degree_colleges" id="private_degree_colleges" value="{$data.private_degree_colleges}" class="num"/></td>
  </tr>
  <tr>
    <td rowspan="2" align="center">Government </td>
    <td>Junior/Polytechnic Colleges </td>
    <td><input type="text" name="govt_junior_colleges" id="govt_junior_colleges" value="{$data.govt_junior_colleges}" class="num"/></td>
  </tr>
  <tr>
    <td>Degree/Engineering/Post Graduation Colleges </td>
    <td><input type="text" name="govt_degree_colleges" id="govt_degree_colleges" value="{$data.govt_degree_colleges}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="3" align="left">Hostels </td>
    <td><input type="text" name="hostels" id="hostels" value="{$data.hostels}" class="num"/></td>
  </tr>
</table>
<br />
<br />
<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">
  <tr style="background:#dfdfdf;" class="bg-lovender">
    <td colspan="3" align="center"><strong>Others </strong></td>
  </tr>
  <tr>
    <td colspan="2">Major Industries </td>
    <td width="51%"><input type="text" name="major_industries" id="major_industries" value="{$data.major_industries}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="2">Major Companies </td>
    <td><input type="text" name="major_companies" id="major_companies" value="{$data.major_companies}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="2">Parks </td>
    <td><input type="text" name="parks" id="parks" value="{$data.parks}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="2">Lakes / tanks </td>
    <td><input type="text" name="lake_tanks" id="lake_tanks" value="{$data.lake_tanks}" class="num" /></td>
  </tr>
  <tr>
    <td colspan="2">Community Halls </td>
    <td><input type="text" name="community_halls" id="community_halls" value="{$data.community_halls}" class="num" /></td>
  </tr>
  <tr>
    <td colspan="2">Smruthivanam </td>
    <td><input type="text" name="vanam" id="vanam" value="{$data.vanam}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="2">Burrial Grounds </td>
    <td><input type="text" name="burial_grounds" id="burial_grounds" value="{$data.burial_grounds}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="2">Municipal Open Spaces </td>
    <td><input type="text" name="open_spaces" id="open_spaces" value="{$data.open_spaces}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="2">Hotels </td>
    <td><input type="text" name="hostels_others" id="hostels_others" value="{$data.hostels_others}" class="num"/></td>
  </tr>
  <tr>
    <td width="28%">Markets </td>
    <td width="21%">Vegetable </td>
    <td><input type="text" name="vegitable_markets" id="vegitable_markets" value="{$data.vegitable_markets}" class="num"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Non Vegetable </td>
    <td><input type="text" name="non_vegitable_markets" id="non_vegitable_markets" value="{$data.non_vegitable_markets}" class="num" /></td>
  </tr>
</table>
<br />
<br />
<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">
  <tr style="background:#dfdfdf;" class="bg-vimeo">
    <td colspan="2" align="center"><strong>UPA </strong></td>
  </tr>
  <tr>
    <td width="49%">Civil Society Organizations </td>
    <td width="51%"><input type="text" name="civil_soc_org" id="civil_soc_org" value="{$data.civil_soc_org}" class="num" /></td>
  </tr>
  <tr>
    <td>TLFs </td>
    <td><input type="text" name="tlfs" id="tlfs" value="{$data.tlfs}" class="num" /></td>
  </tr>
  <tr>
    <td>SLFs </td>
    <td><input type="text" name="slfs" id="slfs" value="{$data.slfs}" class="num" /></td>
  </tr>
  <tr>
    <td>SHGs </td>
    <td><input type="text" name="shgs" id="shgs" value="{$data.shgs}" class="num"/></td>
  </tr>
  <tr>
    <td>CMEY groups </td>
    <td><input type="text" name="cmey_groups" id="cmey_groups" value="{$data.cmey_groups}" class="num" /></td>
  </tr>
  <tr>
    <td>Colony welfare associations </td>
    <td><input type="text" name="col_welfare_asso" id="col_welfare_asso" value="{$data.col_welfare_asso}" class="num" /></td>
  </tr>
  <tr>
    <td>Civic exnora societies </td>
    <td><input type="text" name="civic_exno_soc" id="civic_exno_soc" value="{$data.civic_exno_soc}" class="num" /></td>
  </tr>
  <tr>
    <td>NGOs </td>
    <td><input type="text" name="ngos" id="ngos" value="{$data.ngos}" class="num" /></td>
  </tr>
  <tr>
    <td>No.of Shelters </td>
    <td><input type="text" name="shelters" id="shelters" value="{$data.shelters}" class="num" /></td>
  </tr>
</table>
<br />
<br />
<table class="table"  width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">
  <tr style="background:#dfdfdf;" class="bg-warning">
    <td colspan="3" align="center"><strong>Sanitation </strong></td>
  </tr>
  <tr>
    <td width="27%" rowspan="3">Toilets </td>
    <td width="22%">Public </td>
    <td width="51%"><input type="text" name="pub_toilets" id="pub_toilets" value="{$data.pub_toilets}" class="num"/></td>
  </tr>
  <tr>
    <td>Community </td>
    <td><input type="text" name="community" id="community" value="{$data.community}" class="num"/></td>
  </tr>
  <tr>
    <td>She Toilets </td>
    <td><input type="text" name="she_toilets" id="she_toilets" value="{$data.she_toilets}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="2">ODF Declared Wards </td>
    <td><input type="text" name="odf_wards" id="odf_wards" value="{$data.odf_wards}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="2">ODF Declared or Not ( YES/NO) </td>
    <td>
    
    <label>
      <select name="odf_yn" id="odf_yn">
        <option>-- Select --</option>
        {html_options options=$yn_list selected=$data.odf_yn}
      </select>
    </label>
    
    
  </tr>
  <tr>
    <td colspan="2">Compost Yard Location &amp; Extent </td>
    <td><input type="text" name="compost_yard" id="compost_yard" value="{$data.compost_yard}" class="floatnum"/>  Acrs </td>
  </tr>
  <tr>
    <td colspan="2">Dry Resourse Collection Center (Yes/No)</td>
    <td>
    <label>
      <select name="dry_res_col_cen_yn" id="dry_res_col_cen_yn">
        <option>-- Select --</option>
        {html_options options=$yn_list selected=$data.dry_res_col_cen_yn}
      </select>
    </label>
    </td>
    
    
  </tr>
  <tr>
    <td colspan="2">% of Door to Door Collection </td>
    <td><input type="text" name="d2d_col" id="d2d_col" value="{$data.d2d_col}" class="floatnumpercent"/> % </td>
  </tr>
  <tr>
    <td rowspan="4">Vehicles </td>
    <td>Tractors </td>
    <td><input type="text" name="tractors" id="tractors" value="{$data.tractors}" class="num"/> MTS </td>
  </tr>
  <tr>
    <td>Autos </td>
    <td><input type="text" name="autos" id="autos" value="{$data.autos}" class="num"/></td>
  </tr>
  <tr>
    <td>Tricycles </td>
    <td><input type="text" name="trycycles" id="trycycles" value="{$data.trycycles}" class="num"/></td>
  </tr>
  <tr>
    <td>Pushcarts </td>
    <td><input type="text" name="pushcarts" id="pushcarts" value="{$data.pushcarts}" class="floatnumpercent" /> % </td>
  </tr>
  <tr>
    <td rowspan="2">Workers (Sanitation) </td>
    <td>Regular </td>
    <td><input type="text" name="sanition_reg_workers" id="sanition_reg_workers" value="{$data.sanition_reg_workers}" class="num"/></td>
  </tr>
  <tr>
    <td>Out Sourced </td>
    <td><input type="text" name="sanition_out_workers" id="sanition_out_workers" value="{$data.sanition_out_workers}" class="num"/></td>
  </tr>
  <tr>
    <td rowspan="2">Hospitals </td>
    <td>Government </td>
    <td><input type="text" name="gove_hospitals" id="gove_hospitals" value="{$data.gove_hospitals}" class="num"/></td>
  </tr>
  <tr>
    <td>Private </td>
    <td><input type="text" name="private_hospitals" id="private_hospitals" value="{$data.private_hospitals}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="2">Urban Health Centres </td>
    <td><input type="text" name="urban_health_centers" id="urban_health_centers" value="{$data.urban_health_centers}" class="num"/></td>
  </tr>
  <tr>
    <td colspan="2">Garbage generation/day </td>
    <td><input type="text" name="garbage_gen" id="garbage_gen" value="{$data.garbage_gen}" class="floatnum"/> MTS </td>
  </tr>
  <tr>
    <td colspan="2">Garbage lifted/day </td>
    <td><input type="text" name="garbage_lift" id="garbage_lift" value="{$data.garbage_lift}" class="floatnum"/> MTS </td>
  </tr>
</table>
<p><br />
</p>
<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">
  <tr style="background:#dfdfdf;" class="bg-info">
    <td colspan="2" align="center"><strong>Water Supply </strong></td>
  </tr>
  <tr>
    <td width="49%">Source of water </td>
    <td width="51%"><input type="text" name="water_source" id="water_source" value="{$data.water_source}" class=""/></td>
  </tr>
  <tr>
    <td>Water Demand</td>
    <td><input type="text" name="water_demand" id="water_demand" value="{$data.water_demand}" class="floatnum"/> MLD </td>
  </tr>
  <tr>
    <td>Water Treatment facility </td>
    <td><input type="text" name="water_treat_facility" id="water_treat_facility" value="{$data.water_treat_facility}" class="floatnum" /> MLD </td>
  </tr>
  <tr>
    <td>Utilisation of treatment facility </td>
    <td><input type="text" name="treat_utilization" id="treat_utilization"value="{$data.treat_utilization}" class="floatnum" /></td>
  </tr>
  <tr>
    <td>Storage Capacity </td>
    <td><input type="text" name="storage_capacity" id="storage_capacity" value="{$data.storage_capacity}" class="floatnum" /> MLD </td>
  </tr>
  <tr>
    <td>Protected water supply reservoirs </td>
    <td><input type="text" name="protected_resev" id="protected_resev" value="{$data.protected_resev}" class="num"/></td>
  </tr>
  <tr>
    <td>Total installed capacity of protected water supply </td>
    <td><input type="text" name="installd_capacity" id="installd_capacity" value="{$data.installd_capacity}" class="num"/> MGD </td>
  </tr>
  <tr>
    <td>House service connections </td>
    <td><input type="text" name="house_service_con" id="house_service_con" value="{$data.house_service_con}" class="num"/></td>
  </tr>
  <tr>
    <td>Public stand posts </td>
    <td><input type="text" name="pub_stand_posts" id="pub_stand_posts" value="{$data.pub_stand_posts}" class="num"/></td>
  </tr>
  <tr>
    <td>Length of distribution pipe line </td>
    <td><input type="text" name="pipe_line_length" id="pipe_line_length" value="{$data.pipe_line_length}" class="floatnum"/> K.M </td>
  </tr>
  <tr>
    <td>Area Covered </td>
    <td><input type="text" name="covered_area" id="covered_area" value="{$data.covered_area}" class="floatnumpercent" /> % </td>
  </tr>
  <tr>
    <td>Water supply through bore wells </td>
    <td><input type="text" name="borewel_water_supply" id="borewel_water_supply" value="{$data.borewel_water_supply}" class="floatnum"/> MGD </td>
  </tr>
  <tr>
    <td>Power bores </td>
    <td><input type="text" name="power_bores" id="power_bores" value="{$data.power_bores}" class="num"/></td>
  </tr>
  <tr>
    <td>Hand bores </td>
    <td><input type="text" name="hand_bores" id="hand_bores" value="{$data.hand_bores}" class="num"/></td>
  </tr>
  <tr>
    <td>Water Connections </td>
    <td><input type="text" name="water_conn" id="water_conn" value="{$data.water_conn}" class="num"/></td>
  </tr>
  <tr>
    <td>Residencial </td>
    <td><input type="text" name="residential" id="residential" value="{$data.residential}" class="num"/></td>
  </tr>
  <tr>
    <td>Commercial </td>
    <td><input type="text" name="commercial" id="commercial" value="{$data.commercial}" class="num"/></td>
  </tr>
  <tr>
    <td>Metered </td>
    <td><input type="text" name="metered" id="metered" value="{$data.metered}" class="num"/></td>
  </tr>
  <tr>
    <td>Covered Population </td>
    <td><input type="text" name="pop_covered" id="pop_covered" value="{$data.pop_covered}" class="floatnumpercent"/> % </td>
  </tr>
  <tr>
    <td>Unserved population </td>
    <td><input type="text" name="pop_unreserved" id="pop_unreserved" value="{$data.pop_unreserved}" class="floatnumpercent"/> % </td>
  </tr>
  <tr>
    <td>No of Hours supply in a day </td>
    <td><input type="text" name="water_sup_hrs_day" id="water_sup_hrs_day" value="{$data.water_sup_hrs_day}" class="num" maxlength='2'/> Hrs </td>
  </tr>
  <tr>
    <td>Cost Recovery of Maintenance </td>
    <td><input type="text" name="cost_recovery" id="cost_recovery" value="{$data.cost_recovery}" class="num"/></td>
  </tr>
</table>
<br />


<table  class="table" width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">
  <tr style="background:#dfdfdf;" class="bg-danger">
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="24%" rowspan="4" align="center">Tariff Structure (Monthly) </td>
    <td width="25%">Residential </td>
    <td width="51%"><input type="text" name="tarif_residential" id="tarif_residential" value="{$data.tarif_residential}" class="num"/></td>
  </tr>
  <tr>
    <td>Commercial </td>
    <td><input type="text" name="tarif_commercial" id="tarif_commercial" value="{$data.tarif_commercial}" class="num"/></td>
  </tr>
  <tr>
    <td>Industrial </td>
    <td><input type="text" name="tarif_industrial" id="tarif_industrial" value="{$data.tarif_industrial}" class="num"/></td>
  </tr>
  <tr>
    <td>Slums </td>
    <td><input type="text" name="tarif_slums" id="tarif_slums" value="{$data.tarif_slums}" class="num"/></td>
  </tr>
</table>
<p><br />
</p>



<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">
  <tr style="background:#dfdfdf;" class="bg-lovender">
    <td colspan="3" align="center"><strong>Roads &amp; Drainage Networks </strong></td>
  </tr>
  <tr>
    <td width="24%" rowspan="5">Road </td>
    <td width="25%">C.C. roads length </td>
    <td width="51%"><input type="text" name="rd_cc_road_lenght" id="rd_cc_road_lenght" value="{$data.rd_cc_road_lenght}" class="floatnum"/> Km </td>
  </tr>
  <tr>
    <td>B T roads length </td>
    <td><input type="text" name="rd_bt_road_length" id="rd_bt_road_length" value="{$data.rd_bt_road_length}" class="floatnum"/> Km </td>
  </tr>
  <tr>
    <td>WBM roads length </td>
    <td><input type="text" name="rd_wbm_road_length" id="rd_wbm_road_length" value="{$data.rd_wbm_road_length}" class="floatnum"/> Km </td>
  </tr>
  <tr>
    <td>Kutcha roads length </td>
    <td><input type="text" name="rd_ktcha_road_length" id="rd_ktcha_road_length" value="{$data.rd_ktcha_road_length}" class="floatnum"/>Km </td>
  </tr>
  <tr>
    <td>Unserved % </td>
    <td><input type="text" name="rd_unreserved" id="rd_unreserved" value="{$data.rd_unreserved}" class="floatnumpercent"/> %</td>
  </tr>
  <tr>
    <td rowspan="4">Drainage </td>
    <td>Pucca drains length </td>
    <td><input type="text" name="dr_pucca_dr_lenght" id="dr_pucca_dr_lenght" value="{$data.dr_pucca_dr_lenght}" class="floatnum"/> Km </td>
  </tr>
  <tr>
    <td>Kutcha drains length </td>
    <td><input type="text" name="dr_katcha_dr_length" id="dr_katcha_dr_length" value="{$data.dr_katcha_dr_length}" class="floatnum"/> Km </td>
  </tr>
  <tr>
    <td>Storm water drains length </td>
    <td><input type="text" name="dr_storm_dr_length" id="dr_storm_dr_length" value="{$data.dr_storm_dr_length}" class="floatnum"/></td>
  </tr>
  <tr>
    <td>Unserved % </td>
    <td><input type="text" name="dr_unreserved" id="dr_unreserved" value="{$data.dr_unreserved}" class="floatnumpercent"/> % </td>
  </tr>
  <tr>
    <td colspan="2">Flood prone Areas in ULB </td>
    <td><input type="text" name="flood_area_ulb" id="flood_area_ulb" value="{$data.flood_area_ulb}" class="num"/></td>
  </tr>
</table>
<p>&nbsp;</p>


<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">
  <tr style="background:#dfdfdf;" class="bg-vimeo">
    <td colspan="2" align="center"><strong>Street Lighting </strong></td>
  </tr>
  <tr>
    <td width="49%">High mast lights </td>
    <td width="51%"><input type="text" name="str_high_lights" id="str_high_lights" value="{$data.str_high_lights}" class="num"/></td>
  </tr>
  <tr>
    <td>Central lighting </td>
    <td><input type="text" name="str_cen_lights" id="str_cen_lights" value="{$data.str_cen_lights}" class="num" /></td>
  </tr>
  <tr>
    <td>No. of Street Lights (LED) </td>
    <td><input type="text" name="str_led_lights" id="str_led_lights" value="{$data.str_led_lights}" class="num" /></td>
  </tr>
  <tr>
    <td>Unserved population </td>
    <td><input type="text" name="str_unreserved" id="str_unreserved" value="{$data.str_unreserved}" class="floatnumpercent"/> % </td>
  </tr>
</table>


<p><br />
</p>
<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">
  <tr style="background:#dfdfdf;" class="bg-success">
    <td colspan="5" align="center"><strong>Revenue</strong></td>
  </tr>
  <tr>
    <td width="24%" rowspan="7">Annual income (in lakhs) </td>
    <td width="25%" align="center"><strong>Taxes </strong></td>
    <td width="17%" align="center"><strong>2014-15 </strong></td>
    <td width="17%" align="center"><strong>2015-16 </strong></td>
    <td width="17%" align="center"><strong>2016-17 </strong></td>
  </tr>
  {assign var="i" value="0"}
  {foreach from=$tax_list item=row key=tax_id}
  <input type="hidden" name="{'tax_id'|cat:$i}" value="{$tax_id}" value="{$tax_id}">
  <tr>
    <td>{$tax_list[$tax_id]} </td>
    {assign var="j" value="1"}
    {foreach from=$year_list item=row2 key=year_id}
    <input type="hidden" name="{'year_id'|cat:$i|cat:$j}" value="{$year_id}">
    
    <td align="center"><input type="text" name="{'tax_value'|cat:$i|cat:$j}" id="{'tax_value'|cat:$i}" value="{$data2[$tax_id][$year_id].value}" class="floatnum"/></td>
    
    
  
  {assign var="j" value=$j+1}
  {/foreach}
  </tr>
  {assign var="i" value=$i+1}
 {/foreach} 
 <input type="hidden" name="cnt" value="{$i}">
  
  <tr><td rowspan="4">Annual Expenditure (in lakhs) </td></tr>
  {assign var="k" value="0"}
  {foreach from=$tax_expenditure_list item=row key=tax_id}
  <input type="hidden" name="{'tax_id_exp'|cat:$k}" value="{$tax_id}" value="{$tax_id}">
  <tr>
   
    <td>{$tax_expenditure_list[$tax_id]}</td>
     {assign var="j" value="1"}
    {foreach from=$year_list item=row2 key=year_id}
    <input type="hidden" name="{'year_id_exp'|cat:$k|cat:$j}" value="{$year_id}">
    
    <td align="center"><input type="text" name="{'tax_value_exp'|cat:$k|cat:$j}" id="{'tax_value'|cat:$k|cat:$j}" value="{$data3[$tax_id][$year_id].value}" class="floatnum"/></td>
    
    
  
	  {assign var="j" value=$j+1}
	  {/foreach}
    
    
  </tr>
  {assign var="k" value=$k+1}
  {/foreach}
  <input type="hidden" name="cnt2" value="{$k}">
 
  <tr>
    <td>Last PT Revision Made  in Year </td>
    <td>&nbsp;</td>
    <td colspan="3"><input type="text" name="last_pt" id="last_pt" value="{$data.last_pt}" class="num" /></td>
  </tr>
  <tr>
    <td rowspan="2">Rate of Tax Fixed </td>
    <td>Commercial </td>
    <td><input type="text" name="rate_tax_comm" id="rate_tax_comm" value="{$data.rate_tax_comm}" class="num" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Residential </td>
    <td><input type="text" name="rat_tax_res" id="rat_tax_res" value="{$data.rat_tax_res}" class="num" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="4">Current demand </td>
    <td>Residential </td>
    <td><input type="text" name="cur_demand_res" id="cur_demand_res" value="{$data.cur_demand_res}" class="num" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Non Residential </td>
    <td><input type="text" name="cur_demand_nonres" id="cur_demand_nonres" value="{$data.cur_demand_nonres}" class="num" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Mixed </td>
    <td><input type="text" name="cur_demand_mixed" id="cur_demand_mixed" value="{$data.cur_demand_mixed}" class="num" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Govt </td>
    <td><input type="text" name="cur_demand_govt" id="cur_demand_govt" value="{$data.cur_demand_govt}" class="num" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="3">Tarde License </td>
    <td>No of assessments </td>
    <td><input type="text" name="trade_lic_assements" id="trade_lic_assements" value="{$data.trade_lic_assements}" class="num" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>License amount </td>
    <td><input type="text" name="trade_lic_amount" id="trade_lic_amount" value="{$data.trade_lic_amount}" class="num" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Current year demand (2016-17) </td>
    <td><input type="text" name="trade_lic_curr_demand" id="trade_lic_curr_demand" value="{$data.trade_lic_curr_demand}" class="num" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
</table>
<br />
<br />
<table class="table"  width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">
  <tr style="background:#dfdfdf;" class="bg-warning">
    <td colspan="2" align="center"> <strong>IT/ ERP Infrastructure </strong></td>
  </tr>
  <tr >
    <td width="49%">Systems </td>
    <td width="51%"><input type="text" name="it_systems" id="it_systems" value="{$data.it_systems}" class="num" /></td>
  </tr>
  <tr>
    <td>Printers </td>
    <td><input type="text" name="it_printers" id="it_printers" value="{$data.it_printers}" class="num" /></td>
  </tr>
  <tr>
    <td>Scanners </td>
    <td><input type="text" name="it_scanners" id="it_scanners" value="{$data.it_scanners}" class="num" /></td>
  </tr>
  <tr>
    <td>Internet Access </td>
    <td><label>
      <select name="it_internet_yn" id="it_internet_yn">
        <option>-- Select --</option>
        {html_options options=$yn_list selected=$data.it_internet_yn}
      </select>
    </label></td>
  </tr>
  <tr>
    <td>GIS Base Maps </td>
    <td><label>
      <select name="it_gis_map_yn" id="it_gis_map_yn">
        <option>-- Select --</option>
        {html_options options=$yn_list selected=$data.it_gis_map_yn}
      </select>
    </label></td>
  </tr>
  <tr>
    <td>Birth &amp; Death Online Process </td>
    <td><label>
      <select name="it_birtdeath_yn" id="it_birtdeath_yn">
        <option>-- Select --</option>
        {html_options options=$yn_list selected=$data.it_birtdeath_yn}
      </select>
    </label></td>
  </tr>
  <tr>
    <td>Building Permission Online Process </td>
    <td><label>
      <select name="it_building_per_yn" id="it_building_per_yn">
        <option>-- Select --</option>
        {html_options options=$yn_list selected=$data.it_building_per_yn}
      </select>
    </label></td>
  </tr>
  <tr>
    <td>Online Property Tax Payment </td>
    <td><label>
      <select name="it_prt_taxpayment_yn" id="it_prt_taxpayment_yn">
        <option>-- Select --</option>
        {html_options options=$yn_list selected=$data.it_prt_taxpayment_yn}
      </select>
    </label></td>
  </tr>
  <tr>
    <td>Online Water Tax Payment </td>
    <td><label>
      <select name="it_watertax_onlinepay_yn" id="it_watertax_onlinepay_yn">
        <option>-- Select --</option>
        {html_options options=$yn_list selected=$data.it_watertax_onlinepay_yn}
      </select>
    </label></td>
  </tr>
  <tr>
    <td>Website </td>
    <td><label>
      <select name="it_website_yn" id="it_website_yn">
        <option>-- Select --</option>
        {html_options options=$yn_list selected=$data.it_website_yn}
      </select>
    </label></td>
  </tr>
  <tr>
    <td>Automated Tender Process </td>
    <td><label>
      <select name="it_tender_proces_yn" id="it_tender_proces_yn">
        <option>-- Select --</option>
        {html_options options=$yn_list selected=$data.it_tender_proces_yn}
      </select>
    </label></td>
  </tr>
  <tr>
    <td>e-office </td>
    <td><select name="it_eoffice_yn" id="it_eoffice_yn">
      <option>-- Select --</option>
      {html_options options=$yn_list selected=$data.it_eoffice_yn}
    </select></td>
  </tr>
  <tr>
    <td>Mobile Apps </td>
   <td><label>
      <select name="it_mobileapp_yn" id="it_mobileapp_yn">
        <option>-- Select --</option>
        {html_options options=$yn_list selected=$data.it_mobileapp_yn}
      </select>
    </label></td>
  </tr>
  <tr>
    <td>e-news leter </td>
    <td><label>
      <select name="it_enews_yn" id="it_enews_yn">
        <option>-- Select --</option>
        {html_options options=$yn_list selected=$data.it_enews_yn}
      </select>
    </label></td>
  </tr>
  <tr>
    <td>Citizen Service Center </td>
    <td><label>
      <select name="it_citizen_charter_yn" id="it_citizen_charter_yn">
        <option>-- Select --</option>
        {html_options options=$yn_list selected=$data.it_citizen_charter_yn}
      </select>
    </label></td>
  </tr>
</table>
<br />
<br />
<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">
  <tr style="background:#dfdfdf;">
    <td colspan="2" align="center"><strong>Assets </strong></td>
  </tr>
  <tr>
    <td width="49%">Municipal Building </td>
    <td width="51%"><select name="assets_building_yn" id="assets_building_yn" onchange="assetsyn(this.value)">
      
      <option>-- Select --</option>
        {html_options options=$yn_list selected=$data.assets_building_yn}
    </select></td>
  </tr>
  </table>
  
  <div {if $data.assets_building_yn eq '1'}style="display:block;" {else}style="display:block;"{/if} id="muncipal_building">
  <table class="table table-bordered">
  <tr>
    <td>Area </td>
    <td><input type="text" name="assets_building_area" id="assets_building_area" value="{$data.assets_building_area}" class="floatnum"/> Sq.Mtrs</td>
  </tr>
  <tr>
    <td>Plinth Area </td>
    <td><input type="text" name="assets_building_plintarea" id="assets_building_plintarea" value="{$data.assets_building_plintarea}" class="floatnum"/> Sq.Mtrs</td>
  </tr>
  <tr>
    <td>No of floors </td>
    <td><input type="text" name="assets_floors" id="assets_floors" value="{$data.assets_floors}" class="num"/></td>
  </tr>
  <tr>
    <td>Municpal Assests value </td>
    <td><input type="text" name="assets_value" id="assets_value" value="{$data.assets_value}" class="num"/> Lakhs</td>
  </tr>
  </table>
  </div>
  
<p><br />
  </br>
		<div class="form-actions fluid">
						<div class="col-md-offset-5 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
						<button type="button" class="btn btn-danger">Cancel</button>
						</div>
		</div>
				</div>
				
		  </form>
		</div>
   </div>
</div>
</div>









<br>
{include file='footer.tpl'}

{literal}
<script type="text/javascript">
       $(document).ready(function()
       {
      
       $(".num").keypress(function (e) {
    
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
         }
    });
    
    
    $('.floatnum').keypress(function(event) {
    
    if(event.which == 8 || event.which == 0){
        return true;
    }
    if(event.which < 46 || (event.which > 59 && event.which < 96)) {
        return false;
        //event.preventDefault();
    } // prevent if not number/dot
    
    if(event.which == 46 && $(this).val().indexOf('.') != -1) {
        return false;
        //event.preventDefault();
    } // prevent if already dot
    
});
 
 
 $('.floatnumpercent').keyup(function(event) {
 
 	value=parseFloat($(this).val());
	if(value > 100)
	{
		$(this).val('');
		return false;
	}
   if(event.which == 8 || event.which == 0){
   
        return true;
    }
    if(event.which < 46 || (event.which > 59 && event.which < 96)) {
	$(this).val('');
        return false;
        //event.preventDefault();
    } // prevent if not number/dot
    
    if(event.which == 46 && $(this).val().indexOf('.') != -1) {
        return false;
        //event.preventDefault();
    } // prevent if already dot
	
	
	
  
 }); 
 
       });
    </script>
{/literal}

