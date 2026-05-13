{include file='header.tpl'}
{literal} 
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="js/jquery-ui.css" type="text/css" media="all">

<style>
  table tr:nth-child(odd) {
    background-color: #f1f1f1;
  }

  table tr:nth-child(even) {
    background-color: #ffffff;
  }
</style>

<script language="javascript">
  function get_det1(desg_id) {

    var select1 = document.getElementById("emp_id");
    select1.options.length = 0;

    if (window.XMLHttpRequest)
      xmlhttp = new XMLHttpRequest();
    else
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var strArray = xmlhttp.responseText.split("___");
        var j = strArray.length;
        for (i = 0; i < j; i++) {
          var optArray = strArray[i].split(":::");
          select1.options[select1.options.length] = new Option(optArray[1], optArray[0]);
        }
      }
    }
    xmlhttp.open("GET", "get_emps.php?desg_id=" + desg_id, true);
    xmlhttp.send();

  }

  function get_det(dept_id) {
    var select = document.getElementById("emp_desg");
    var select1 = document.getElementById("emp_id");
    select.options.length = 0;
    select1.options.length = 0;

    if (window.XMLHttpRequest)
      xmlhttp = new XMLHttpRequest();
    else
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var strArray = xmlhttp.responseText.split("___");
        var j = strArray.length;
        for (i = 0; i < j; i++) {
          var optArray = strArray[i].split(":::");
          select.options[select.options.length] = new Option(optArray[1], optArray[0]);
        }
      }
    }
    xmlhttp.open("GET", "get_designations.php?dept_id=" + dept_id, true);
    xmlhttp.send();

  }



  function get_comp_det(grievance_id, status) {

    document.forms["manage_comp_det"].submit();

  }







  function validateForm() {
    var emp_id = document.update_comp.emp_id.selectedIndex;
    var alloted_date = document.update_comp.alloted_date.value;

    if (emp_id == '0' || emp_id == '-1') {

      var emp_dept = $("#emp_dept").val();
      var emp_desg = $("#emp_desg").val();
      if (emp_dept == '0') {
        $("#emp_dept").css('border-color', 'red');
      } else {
        $("#emp_dept").css('border-color', 'grey');
      }

      if (emp_desg == '0') {
        $("#emp_desg").css('border-color', 'red');
      } else {
        $("#emp_desg").css('border-color', 'grey');
      }




      alert("Please Select Employee");
      return false;
    }
    if (alloted_date == '') {
      alert("Please Enter Allotted Date");
      return false;
    }
    return true;
  }
</script>
{/literal}


<div class="boxed">

  <div class="title-bar success">
    <h4>TOTAL APPLICATIONS PENDING FOR APPROVAL - <b> {$num_comp_to_approve} </h4>
  </div>
  <div class="inner no-radius table-responsive">
    <div>
      {if isset($msg)}
      <div class="{$class}">
        <button class="close" data-close="alert"></button>
        {$msg}
      </div>
      {/if}
    </div>

    <div style="border:#999999 1px solid; min-height:200px;max-height:auto; margin-top:5px;" id='comp_div'> {if isset($data1)}
      <form method="post" action="view_pending_approval.php" name="update_comp" id="update_comp" onSubmit="return validateForm();">
        <input type="hidden" name="app_type_id" value="{$data1.app_type_id}">
        <input type='hidden' name='grievance_id_sel' value={$grievance_id_sel}>
        <input type='hidden' name='status_sel' value={$data1.grievance_status_id}>
        <input type='hidden' name='cs_id_sel' value={$data1.cat3_id}>

        <table width="100%" height="35" border="1" cellpadding="0" cellspacing="0" class="table table-bordered table-hover">
          <tr>
            <td align="left" valign="middle"> <strong>Name: </strong></td>
            <td align="left" valign="middle">{$data1.person_name}</td>
            <td align="left" valign="middle"> <strong>Address : </strong></td>
            <td align="left" valign="middle">{$data1.hno} , {$data1.address}</td>
          </tr>
          <tr>
            <td align="left" valign="middle"> <strong>Ward & Street : </strong></td>
            <td align="left" valign="middle">{$ward_list[$data1.ward_id]}/.{$street_list[$data1.street_id]}</td>
            <td align="left" valign="middle"> <strong>Mobile: </strong></td>
            <td align="left" valign="middle">{$data1.mobile}</td>
          </tr>
          <tr>
            <td align="left" valign="middle"> <strong>Subject: </strong></td>
            {if $data1.app_type_id eq '1'}
            <td align="left" valign="middle">{$cs_list[$data1.cat3_id]}<input type="hidden" name="subject" value="{$cs_list[$data1.cat3_id]}"></td>
            {else}
            <td align="left" valign="middle">{$cat3_list[$data1.mcat3_id]}<input type="hidden" name="subject" value="{$cat3_list[$data1.mcat3_id]}"></td>
            {/if}
            <td align="left" valign="middle"> <strong>Received Through: </strong></td>
            <td align="left" valign="middle">{$grievance_origin_list[$data1.grievance_origin_id]}</td>
          </tr>
          <tr>
            <td align="left" valign="middle"> <strong>Description: </strong></td>
            <td align="left" valign="middle">{$data1.comp_desc}</td>
            <td align="left" valign="middle"> <strong>Present Status: </strong></td>
            <td align="left" valign="middle">{$grievance_status_list[$data1.grievance_status_id]}</td>
          </tr>
          <tr>
            <td align="left" valign="middle"> <strong>Allotted to: </strong></td>
            <td align="left" valign="middle" colspan='3'>

              <div class="col-md-3">
                <select name='emp_dept' onchange="get_det(this.value);" class="form-control" id="emp_dept" autocomplete="off">
                  <option value='0'>-- Select Department --</option>
                  {html_options options=$dept_list}
                </select>
              </div>
              <div class="col-md-3">
                <select name='emp_desg' id='emp_desg' onchange="get_det1(this.value);" class="form-control" autocomplete="off">
                  <option value='0'>-- Select Designation --</option>
                </select>

              </div>
              <div class="col-md-3">
                <select name='emp_id' id='emp_id' class="form-control" autocomplete="off">
                  <option value='0'>-- Select Employee --</option>
                </select>
              </div>
            </td>
          </tr>
          <tr>
            <td align="left" valign="middle"> <strong>Allotted on: </strong></td>
            <td align="left" valign="middle">

              <input type="text" name="alloted_date" id="datepicker" readonly="readonly" class="form-control form-control-inline input-medium" autocomplete="off">

            </td>
          </tr>
          <tr>
            <td align="center" valign="middle" colspan='4'><input type='submit' name='save' value='Save Details' class="btn btn-danger"></td>
          </tr>
        </table>
      </form>
      {/if}
    </div>



    <div style="margin-top:5px;">
      <form name='manage_comp_det' id='manage_comp_det' action='view_pending_approval.php' method='POST'>
        <input type="hidden" name="app_type_id" value="{$app_type_id}">
        <div id="demo" class="table-responsive">
          <table width="100%" cellpadding="3" cellspacing="0" border="1" class="table table-striped table-bordered table-hover table-full-width" id="data-table">
            <thead>
              <tr style="background-color: #2c3e50; color:#FFF;">
                <th style="text-align: center;"> SELECT TO UPDATE </th>
                <th style="text-align: center;"> SR.NO </th>
                <th style="text-align: center;"> MODE </th>
                <th style="text-align: center;"> NAME & MOBILE NO </th>
                <th style="text-align: center;"> ADDRESS </th>
                <th style="text-align: center;">COMPLAINT / SERVICE </th>
                <th style="text-align: center;"> COMPLAINT ID </th>
                <th style="text-align: center;"> DATE </th>
                <th style="text-align: center;"> STATUS </th>
              </tr>
            </thead>
            <tbody>
              {foreach from=$data key=grievance_id item=row}
                <tr align="center">
                  <td style="width:50px;"><input type="radio" name='grievance_id' value="{$grievance_id}" {if $grievance_id_sel eq $grievance_id} checked="checked" {/if} onclick="get_comp_det(this.value,'{$row.grievance_status_id}')"></td>

                  <td>{counter}</td>
                  <td>{$grievance_origin_list[$row.grievance_origin_id]}</td>
                  <td>{$row.person_name} ({$row.mobile})</td>
                  <td>{$row.address}</td>
                  {if $row.app_type_id eq '1'}
                  <td><label title="{$row.comp_desc}">{$cs_list[$row.cat3_id]}</label></td>
                  {else}
                  <td><label title="{$row.comp_desc}">{$cat3_list[$row.cat3_id]}</label></td>
                  {/if}
                  <td>{$row.grievance_id}</td>
                  <td>{$row.date_regd|date_format:"%d-%m-%Y %H:%M:%S"}</td>
                  <td>

                    {$grievance_status_list[$row.grievance_status_id]}

                  </td>
                </tr>
              {/foreach}
            </tbody>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>

{include file='footer_print.tpl'}
{include file='footer.tpl'}
{literal}
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<script type="text/javascript" src="js/jquery-ui.js"></script>
<script>
  $(function() {
    $("#datepicker").datepicker({
      changeMonth: true,
      changeYear: true
    });
  });
</script>
{/literal}