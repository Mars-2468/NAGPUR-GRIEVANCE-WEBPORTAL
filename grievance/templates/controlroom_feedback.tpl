{include file='header.tpl'}
{literal}

<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="actb.js"></script>
<script language="javascript" type="text/javascript" src="tablefilter.js"></script>
<script language="javascript" type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>

<script language="javascript">

    function get_comp_det(grievance_id) {

        document.forms["manage_comp_det"].submit();
    }
    function get_comp_det_emp(grievance_id) {

        document.forms["manage_comp_det_emp"].submit();
    }

    function fun1(app_type_id) {
        $.post('ajax_get_search_cat3ids.php', {
            app_type_id: app_type_id
        }, function(data) {
            $("#cat3_id").html(data);
        });
    }
	
</script>

{/literal}


<div class="boxed">

	<div class="row" style="background-color: #e3f6f5; ">
		
		<div style="background-color: #0066CC; color: #FFF; padding: 5px; font-size: 15px;display:flex; justify-content:space-between;align-items:center">
			<div>Feedback to the complaint</div>			
			<div style=""><a href="controlroom_check_comp_status.php" class="btn btn-warning">Back</a></div>	
		</div>
      
	</div>
    
	<div class="inner no-radius table-responsive">
    <div>
        <div>           
           
			<div id="area" class="container" style="margin-top: 15px;">
                <div class="panel panel-info" style="margin-top: 15px;">
                    <div class="panel-heading"  style="">
					
					<div>Check Status</div>
					
					
					</div>
                    <div class="panel-body">
                       
					   
					   
					   
					<form name='check_comp_status' method='POST' action='controlroom_feedback.php' onSubmit="return validateForm();" >

							<input type="hidden" name="ulbid" value="{$ulbid}">

						<div class="row">

						<div class="col-md-3">
							<label>Grievance Id</label>
							<input type="text" name="grievance_id" id="grievanceid"  value="{$grievances.grievance_id}" class="form-control" required readonly/>
						</div>
						<div class="col-md-3">
							<label>Name</label>
							<input type="text" name="person_name" id="person_name"  value="{$grievances.person_name}" class="form-control" required readonly/>
						</div>

						<div class="col-md-3">
							<label>Mobile No</label>
							<input type="text" name="mobile" class="form-control" value="{$grievances.mobile}" required readonly/>
						</div>

						<div class="col-md-3">
							<label>Ward</label>
							<input type="text" name="ward" id="ward"  class=" form-control" value="{$grievances.ward_desc}" required readonly>
						</div>

						<div class="col-md-3">
							<label>Street</label>
							<input type="text" name="street" id="street"   class=" form-control" value="{$grievances.street_desc}" required readonly>
						</div>

						<div class="col-md-4" style="margin-top:10px;">
							<label>Complaint Type</label>
							<input type="text" name="complaint_type" class="form-control" value="{$grievances.cs_desc}" required>
						</div>


						<div class="col-md-3" style="margin-top:10px;">
							<label>Rating</label>
							<select name="grievance_status_id" id="grievance_status_id" class="form-control" required>
								<option value=''>-All-</option>
								 {foreach from=$rating_options item=row}
									<option value="{$row}">{$row}</option>
								 {/foreach}

								
							</select>
						</div>

						<div class="col-md-3" style="margin-top:10px;" id="grievance_sub_options">
							<label>Sub Options</label>
							<select name="grievance_sub_options" id="grievance_sub_options" class="form-control" >
								<option value=''>-All-</option>
								 {foreach from=$sub_options item=row key=emp_id}
									<option value="{$row.sub_option_id}">{$row.description}</option>
								 {/foreach}
								
							</select>
						</div>
						<div class="col-md-12" style="margin-top:10px;">
							<label>Description</label>
							<textarea name="description" class="form-control" ></textarea>
						</div>


						<div class="col-md-12 text-right" style="margin-top: 20px;">
							<!-- <input type="hidden" name="grievance_id" class="form-control" value="{$grievances.grievance_id}" required> -->
							<input type="hidden" name="mobile" class="form-control" value="{$grievances.mobile}" required>
							<input type="submit" name="save" id="save" value="Submit" class="excel_btn btn btn-success"/>
							<input type="reset" name="reset" id="reset" value="Reset" class="print_btn btn btn-danger"/>
						</div>

						</div>


					</form>
					   
					   
                    </div>
                </div>
                
                <div style="padding-left: 125px; padding-top: 25px; font-size: 11px;"></div>
            </div>
        </div>
    </div>
    <br />
    <br />
    <br />
    <script language="javascript" type="text/javascript">
        function get_streets(ward_id) {
            var select = document.getElementById("street_id");
            select.options.length = 0;
            if (window.XMLHttpRequest)
                xmlhttp = new XMLHttpRequest();
            else
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var strArray = xmlhttp.responseText.split("___");
                    var j = strArray.length;
                    for (i = 0; i < j; i++) {
                        var optArray = strArray[i].split(":::");
                        if (optArray[0] == '0')
                            select.options[select.options.length] = new Option('All', '%');
                        else
                            select.options[select.options.length] = new Option(optArray[1], optArray[0]);
                    }
                }
            }
            xmlhttp.open("GET", "get_streets.php?ward_id=" + ward_id, true);
            xmlhttp.send();
        }
        function validateForm() { 
		//alert('ssss');
            var mobile = document.controlroom_check_comp_status.mobile.value;
            var patt = /^[7-9]\d{9}$|^$/;
            if (!patt.test(mobile)) {
                alert("Please Enter Valid Mobile No");
                return false;
            }
            return true;
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        $(function () {
            var dates = $("#from_date, #to_date").datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: "+0",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                onSelect: function (selectedDate) {
                    var option = this.id == "from_date" ? "minDate" : "maxDate",
                        instance = $(this).data("datepicker"),
                        date = $.datepicker.parseDate(
                            instance.settings.dateFormat ||
                            $.datepicker._defaults.dateFormat,
                            selectedDate, instance.settings);
                    dates.not(this).datepicker("option", option, date);
                }
            });
        });
        $(function () {
            $(".datepick").datepicker({ 
			dateFormat: 'yy-mm-dd',
			minDate: '2024-09-01',
            changeMonth: true,
            changeYear: true
			});
        });
    </script>
















	</div>
      
</div>

<strong></strong><br />

{literal}
<script language="javascript" type="text/javascript">
    var table2_Props = {
        col_0: "none",
        col_1: "select",
        col_3: "select",
        col_5: "select",
        col_6: "none",
        display_all_text: " [ Show all ] ",
        sort_select: true,
        paging: true,
        paging_length: 6,
        alternate_rows: true
    };
    setFilterGrid("example", table2_Props);
</script>



<script language="javascript" type="text/javascript">
	$(document).ready(function() {
  // Initially hide the Sub Options dropdown and set it as optional
  var subOptionsDropdown = $('#grievance_sub_options');
  subOptionsDropdown.hide();
  subOptionsDropdown.prop('required', false);

  // Attach change event handler to the Rating dropdown
  $('#grievance_status_id').change(function() {
    var selectedValues = $(this).val();
    var selectedValuesArray = Array.isArray(selectedValues) ? selectedValues : [selectedValues];

    // Check if any of the selected values are 3, 4, or 5
    var showSubOptions = selectedValuesArray.some(function(value) {
      return value === '1' || value === '2' || value === '3';
    });

    // Show or hide the Sub Options dropdown based on the condition
    if (showSubOptions) {
      subOptionsDropdown.show();
      subOptionsDropdown.prop('required', true);
    } else {
      subOptionsDropdown.hide();
      subOptionsDropdown.prop('required', false);
    }
  });
});
</script>
{/literal}
<div>
</div>

{include file='footer.tpl'}