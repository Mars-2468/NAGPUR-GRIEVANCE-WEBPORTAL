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
			<div>Feedback report to the complaints</div>			
			<div style=""><a href="controlroom_check_comp_status.php" class="btn btn-warning">Back</a></div>	
		</div>
      
	</div>
    
	<div class="inner no-radius table-responsive">
    <div>
        <div>           
           
			<div id="area" class="container" style="margin-top: 15px;">
                <div class="panel panel-info" style="margin-top: 15px;">
                    <div class="panel-heading"  style="">
					
					<div>Rating report status</div>
					
					
					</div>
                    <div class="panel-body">
                       
					   
					<table class="table table-bordered" id="data-table">
					  <thead> 
					  <tr>
						  <th class="text-center">Total complaint ratings</th>
						  <th class="text-center">5&nbsp;<i class="fa fa-star text-orange"></i> rating(s)</th>
						  <th class="text-center">4&nbsp;<i class="fa fa-star text-orange"></i> rating(s)</th>
						  <th class="text-center">3&nbsp;<i class="fa fa-star text-orange"></i> rating(s)</th>
						  <th class="text-center">2&nbsp;<i class="fa fa-star text-orange"></i> rating(s)</th>
						  <th class="text-center">1&nbsp;<i class="fa fa-star text-orange"></i> rating</th>
					  </tr>
					  </thead>
					  <tbody> 
					  
					  <tr class="text-center">
					  <td><a href="controlroom_grievance_ratingwise_list.php?rating=12345"  style="color:blue;">{$total_complaints}</a></td>
						{for $cnt=4 to 0 step -1}
						 <td><a href="controlroom_grievance_ratingwise_list.php?rating={$cnt+1}" style="color:blue;">{$star[$cnt]}</a></td>
						 {/for}
					  </tr>
					  </tbody>
					</table>
					
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




  {include file='footer_print.tpl'}











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