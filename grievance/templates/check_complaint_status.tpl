<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Design</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all">
    <link href="https://fonts.googleapis.com/css?family=Mallanna&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        table tr:nth-child(odd) {
            /*background-color: #f1f1f1;*/
        }
        table tr:nth-child(even) {
            background-color: #ffffff;
        }
        tr td span {
            font-family: 'Mallanna', sans-serif;
            font-size: 18px;
            font-weight: bold;
        }
        @media (max-width: 767px) {
            .nav-header {
                font-size: 10px !important;
            }
        }
        .nav-header {
            background-color: #0066CC;
            color: #FFF;
            padding: 5px;
            text-align: center;
            font-size: 22px;
        }
  
        @media (max-width: 767px) {
            .panel {
                margin-top: 20px !important;
            }
            .panel-body {
                padding: 10px !important;
            }
            .form-control {
                width: 100% !important;
            }
            .btn {
                margin-bottom: 10px;
            }
				
        }
		
		 .mb_bg {
            background-image: url(images/mb_bg.jpg);
            height: 600px;
            background-size: contain;
            background-position: bottom;
            background-repeat: repeat-x;
            background-color: #068fdd;
        }
		 
    </style>
	
</head>
<body style="padding: 0px; margin: 0px;">
    <div class="row" style="background-color: #0b1c40;">
        <div class="container">
            <center>
                <!-- Content here -->
            </center>
        </div>
        <div class="nav-header">
            <div class="container">
                <img src="images/nagpur-logo.png" style="width: 50px;">
                <strong>NAGPUR MUNICIPAL CORPORATION / नागपूर महानगरपालिका</strong>
            </div>
        </div>
    </div>
    <div>
        <div>
            <div class="row" style="background-color: #e3f6f5;">
                <div class="container">
                    <center>
                        <!-- Content here -->
                    </center>
                </div>
                <div style="background-color: #0066CC; color: #FFF; padding: 5px; text-align: center; font-size: 15px;"><strong>Search Complaint</strong></div>
            </div>
        
			<div id="area" class="container" style="margin-top: 15px;">
                <div class="panel panel-info mb_bg" style="margin-top: 15px;">
                    <div class="panel-heading" style="text-align: center;">Check Status</div>
                    <div class="panel-body">
                        <form name='check_complaint_status' method='POST' action='check_complaint_status.php' onSubmit="return validateForm();">
                            <input type="hidden" name="ulbid" value="{$ulbid}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Name</label>
                                    <input type="text" name="person_name" value="{$person_name}"  id="person_name" class="form-control"/>
                                </div>
                                <div class="col-md-3">
                                    <label>Mobile No</label>
                                    <input type="text" name="mobile" value="{$mobile}"  class="form-control"/>
                                </div>
                                <div class="col-md-3">
                                    <label>Period From</label>
                                    <input type="text" name="from_date" id="from_date" value="{$from_date}" readonly class="datepick form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Period To</label>
                                    <input type="text" name="to_date" id="to_date" value="{$to_date}" readonly class="datepick form-control">
                                </div>
                                <div class="col-md-3" style="margin-top: 10px;">
                                    <label>Reference No</label>
                                    <input type="text" name="grievance_id" value="{$grievance_id}" class="form-control">
                                </div>
                                <div class="col-md-3" style="margin-top: 10px;">
                                    <label>Status</label>
                                    <select name="grievance_status_id" id="grievance_status_id" class="form-control" required>
                                        <option value=''>-All-</option>
                                        {html_options options=$grievance_status_list selected=$grievance_status_id}
                                    </select>
                                </div>
								<div class="row" style="padding-bottom:12px;">
            <div class="col-md-12 d-flex text-center" style="margin-top: 32px;">
               <!-- <input style="padding:8px 20px;margin-right:12px" type="reset" name="reset" id="reset" value="Reset" onclick="resetForm()" class="print_btn btn btn-danger"/>-->
                <input style="padding:8px 20px" type="submit" name="save" id="save" value="Search" class="excel_btn btn btn-success"/>
            </div>
        </div>
                            </div>
                        </form>
                    </div>
                </div>
                {if isset($data)}
                <strong> <span style='color: red'>*Please check the grievance status </span></strong>
                <p></p>
                <div class="table table-responsive">
                <table id='example' width="100%" border="1" cellpadding="0" cellspacing="0" class="table" style="font-size: 13px;">
                    <tr style="background-color: #3366CC; color: #FFF;">
                        <th align="center" valign="middle" scope="col" style="width: 40px;">S.No</th>
                        <th align="center" valign="middle" scope="col" style="width: 100px;">Complaint No</th>
                        <th align="center" valign="middle" scope="col" style="width: 120px;">Name & Mobile</th>
                        <th align="center" valign="middle" scope="col" style="width: 150px;">Address</th>
                        <th align="center" valign="middle" scope="col" style="width: 300px;"><div style="width: 300px;">Complaint Details</div></th>
                        <th align="center" valign="middle" scope="col" style="width: 100px;">Status</th>
                    </tr>
                    {foreach from=$data key=grievance_id item=row}
                    <tr>
                        <td align="center" valign="middle" style="width: 40px;">{counter}</td>
                        <td align="center" valign="middle" style="width: 100px; word-wrap: break-word;"><a href="view_comp_det.php?grievance_id={$grievance_id}&id={$ulbid}" target="_blank" style="color: #FF6600;">{$grievance_id}</a></td>
                        <td align="center" valign="middle" style="width: 120px; word-wrap: break-word;">{$row.person_name} ({$row.mobile})</td>
                        <td align="center" valign="middle" style="width: 150px; word-wrap: break-word;"><div style="width: 150px; padding: 0px 5px 0px 5px;">{$row.hno}, {$row.address}</div></td>
                        <td align="center" valign="middle" style="width: 300px; word-wrap: break-word; text-align: justify; padding: 0px 10px 0px 10px;">
                            <div style="width: 300px; word-wrap: break-word;">{if $row.comp_desc eq ''}
                            N/A.{elseif $row.comp_desc neq ''}{$row.comp_desc}{/if}
                            </div>
                        </td>
                        <td align="center" valign="middle" style="width: 100px; word-wrap: break-word;">
                            {$grievance_status_list[$row.grievance_status_id]}
                        </td>
                    </tr>
                    {/foreach}
                </table>
                </div>
                {/if}
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
            var mobile = document.check_complaint_status.mobile.value;
            var patt = '/^[7-9]\d{9}$|^$/';
            var lenth = '/^\d{10}$/';
            if ( !lenth.test(mobile) && !patt.test(mobile)) {
                alert("Please Enter Valid Mobile No");
                return false;
            }
            return true;
        }        
		
		function resetForm() {
		alert('sss');
            var mobilef = document.getElementById('mobile');
            var person_name = document.getElementById('person_name');
            var grievance_id = document.getElementById('grievance_id');
            var from_date = document.getElementById('from_date');
            var to_date = document.getElementById('to_date');
            var to_date = document.getElementById('grievance_status_id');
          
			mobile.val('');
			person_name.val('');
			grievance_id.val('');
			from_date.val('');
			to_date.val('');
			grievance_status_id.val('');
           
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
            $(".datepick").datepicker({ 'maxDate': '0' });
        });
    </script>
</body>
</html>
