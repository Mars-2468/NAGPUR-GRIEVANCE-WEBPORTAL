{include file='corp_header.tpl'}
{literal}

<style>
  .activ_column {
    background-color: #7ac18a;
    color: white !important;
  }

  .activ_column a {
    /*background-color: #54B435;*/
    color: #FFF !important;
    /*text-shadow: 0 0 3px #FFFF;*/
    text-decoration: underline #1C82AD;
  }

  a {
    color: blue;
    text-decoration: underline;
  }

  /* Your regular styles go here */

  @media print {

    /* Set the page to landscape mode */
    @page {
      size: landscape;
    }

    /* Additional print styles if needed */
    body {
      font-size: 12pt;
      margin: 1cm;
      /* Adjust margins as needed */
    }
  }
</style>

<script language='javascript'>
  var tableToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,',
      template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
      base64 = function(s) {
        return window.btoa(unescape(encodeURIComponent(s)))
      },
      format = function(s, c) {
        return s.replace(/{(\w+)}/g, function(m, p) {
          return c[p];
        })
      }
    return function(table, name) {
      if (!table.nodeType) table = document.getElementById(table)
      var ctx = {
        worksheet: name || 'Worksheet',
        table: table.innerHTML
      }
      window.location.href = uri + base64(format(template, ctx))
    }
  })()
</script>
<script>
  function print_div() {
    var divContents = $("#area").html();
    var printWindow = window.open();
    printWindow.document.write(divContents);
    printWindow.document.close();
    printWindow.print();
  }
</script>


{/literal}

<div class="" style="margin-top: -45px;">
 
 <form method="POST" action="" class="form-horizontal">

    <div class="boxed">

      <div class="title-bar blue1"></div>
      <div class="inner no-radius">
		{if !empty($errors)}
			{foreach $errors as $error}
				<p style="color:red;">{$error}</p>
			{/foreach}
		{/if}
        <div class="col-md-3" style="margin-right:15px;">
          <div class="form-group">
            <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>

            <input type="text" class="phone-group form-control datepicker" name="f_date" id="f_date" value="{$fdate}" placeholder="Select Date" data-type="date" onchange="funInputFielTypes(this)" autocomplete="off">
			<div style="font-size:10px;color:red;" id="f_dateX"></div>
          </div>
        </div>


        <div class="col-md-3" style="margin-right:15px;">
          <div class="form-group">
            <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>

            <input type="text" class="phone-group form-control datepicker" name="t_date" id="t_date" value="{$tdate}" placeholder="Select Date" data-type="date" onchange="funInputFielTypes(this)" autocomplete="off">
			<div style="font-size:10px;color:red;" id="t_dateX"></div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group" style="margin-top:31px;">
            <input name="search" type="submit" class="btn btn-success" value="SEARCH" id="submitBtn" disabled>
          </div>
        </div>


      </div>


    </div>


  </form>


<div class="boxed">


  <div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
    <h4>Deptwise Complaints Report</h4>
  
    <p class="m-0"><a href="ajax_corp_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
    </div>



  <div class="inner no-radius">
    <div id="area" class="table-responsive">

      <table id='data-table' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
        <caption style="caption-side:top; text-align:center;font-size:16px;">
          <b>
            <CENTER><strong>VIEW DEPARTMENT WISE COMPLAINT DETAILS</strong></CENTER>
          </b>
        </caption>
        <thead>
          <tr style="background-color:#2c3e50; color:#FFF;text-align:center;">
            <th align='center' rowspan='2'> S.No </th>
            <!--	<th align='center'> Id </th>-->
            <th align='center' rowspan='2'> DEPARTMENT NAME </th>
            <th align='center' rowspan='2'> RECEIVED </th>
            <th align='center' colspan='2'> UNDER PROGRESS </th>
            <th align='center' colspan='2'>REDRESSED </th>
            <th align='center' rowspan='2'>UN RESOLVABLE </th>
            <th align='center' rowspan='2'>REOPENED </th>
            <th align='center' rowspan='2'>REOPENED UNDERPROGRESS </th>
            <th align='center' rowspan='2'>REOPENED COMPLETED </th>
            <th align='center' rowspan='2'>REJECTED </th>
            <th align='center' rowspan='2'>FINANCIAL IMPLICATION </th>
            <th align='center' rowspan='2'>TRANSFERS </th>
          </tr>

          <tr style="background-color:#2c3e50; color:#FFF;text-align:center;">

            <th align='center'>WITHIN SLA </th>
            <th align='center'>BEYOND SLA </th>
            <th align='center'>WITHIN SLA </th>
            <th align='center'>BEYOND SLA </th>

          </tr>

        </thead>
        <tbody>
          {assign var ="totreceived" value="0"}
          {assign var ="totpending" value="0"}
          {assign var ="totpending_be" value="0"}
          {assign var ="totcompleted" value="0"}
          {assign var ="totcompleted_be_sla" value="0"}
          {assign var ="totunresolved" value="0"}
          {assign var ="totreopened" value="0"}
          {assign var ="totreopend_underProgress" value="0"}
          {assign var ="totreopend_completedcount" value="0"}
          {assign var ="totrejected" value="0"}
          {assign var ="totrejected" value="0"}
          {assign var ="totfin" value="0"}



{foreach from=$dept_list key=dept_id item=row}
<tr>
    <td align='center'>{counter}</td>

    <td class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">
        <a href="corp_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=0&f_date={$fdate}&t_date={$tdate}">
            {$row}
        </a>
    </td>

    <td align='center' class="{if $active_class eq 'tr-clmn'}activ_column{/if}">
        <a href="corp_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=0&f_date={$fdate}&t_date={$tdate}">
            {if isset($data[$dept_id]['count']) && $data[$dept_id]['count'] neq ''}
                {$data[$dept_id]['count']}
            {else}
                -
            {/if}
        </a>
    </td>

    <td align='center' class="{if $active_class eq 'pwsla-clmn' || $active_class eq 'tr-totpending'}activ_column{/if}">
        {if !empty($data_list[$dept_id].underprogress_within_sla)}
            <a href="corp_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=2&sla_status=1&f_date={$fdate}&t_date={$tdate}">
                {$data_list[$dept_id].underprogress_within_sla}
            </a>
        {else}-{/if}
    </td>

    <td align='center' class="{if $active_class eq 'pdbsla-clmn' || $active_class eq 'tr-totpending'}activ_column{/if}">
        {if !empty($data_list[$dept_id].underprogress_beyond_sla)}
            <a href="corp_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=2&sla_status=2&f_date={$fdate}&t_date={$tdate}">
                {$data_list[$dept_id].underprogress_beyond_sla}
            </a>
        {else}-{/if}
    </td>

    <td align='center' class="{if $active_class eq 'cmp-wthin-sla' || $active_class eq 'tr-totresolved'}activ_column{/if}">
        {if !empty($data_list[$dept_id].completed_within_sla)}
            <a href="corp_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=3&f_date={$fdate}&t_date={$tdate}">
                {$data_list[$dept_id].completed_within_sla}
            </a>
        {else}-{/if}
    </td>

    <td align='center' class="{if $active_class eq 'cmp-bnd-sla' || $active_class eq 'tr-totresolved'}activ_column{/if}">
        {if !empty($data_list[$dept_id].completed_beyond_sla)}
            <a href="corp_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=4&f_date={$fdate}&t_date={$tdate}">
                {$data_list[$dept_id].completed_beyond_sla}
            </a>
        {else}-{/if}
    </td>

    <td align='center'>-</td>

    <td align='center' class="{if $active_class|in_array:['tr-totpending','tr-totpending-reopen','tr-totpending-reopen-total']}activ_column{/if}">
        {if !empty($data_list[$dept_id].reopened)}
            <a href="corp_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=5&f_date={$fdate}&t_date={$tdate}">
                {$data_list[$dept_id].reopened}
            </a>
        {else}-{/if}
    </td>

    <td align='center' class="{if $active_class|in_array:['tr-totpending','tr-totpending-reopen','tr-totpending-reopen-under-progress']}activ_column{/if}">
        {if !empty($data_list[$dept_id].reopend_underProgress)}
            <a href="corp_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=6&f_date={$fdate}&t_date={$tdate}">
                {$data_list[$dept_id].reopend_underProgress}
            </a>
        {else}-{/if}
    </td>

    <td align='center' class="{if $active_class|in_array:['tr-totresolved','tr-totpending-reopen','tr-totpending-reopen-completed']}activ_column{/if}">
        {if !empty($data_list[$dept_id].reopened_completed)}
            <a href="corp_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=7&f_date={$fdate}&t_date={$tdate}">
                {$data_list[$dept_id].reopened_completed}
            </a>
        {else}-{/if}
    </td>

    <td align='center'>
        {if !empty($data_list[$dept_id].rejected)}
            <a href="corp_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=8&f_date={$fdate}&t_date={$tdate}">
                {$data_list[$dept_id].rejected}
            </a>
        {else}-{/if}
    </td>

    <td align='center' class="{if $active_class eq 'tr-totresolved' || $active_class eq 'tr-totresolved-fin'}activ_column{/if}">
        {if !empty($data_list[$dept_id].fin)}
            <a href="corp_dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=9&f_date={$fdate}&t_date={$tdate}">
                {$data_list[$dept_id].fin}
            </a>
        {else}-{/if}
    </td>

    <td align='center' class="{if $active_class eq 'tr-clmn'}activ_column{/if}">
        {$data_list[$dept_id].transfers|default:'-'}
    </td>
</tr>
{/foreach}
        </tbody>
      
          <tfoot>
            <td align='center' colspan='2'><strong>Total</strong></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot['received'] gt 0}</strong><a href="corp_TotalDepartmentsReceivedGrievances.php?ulbid={$ulbid}&app_type_id=1&f_date={$fdate}&t_date={$tdate}&status=100">{$tot['received'] }</a>{else}{$totreceived}{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot['underprogress_within_sla'] gt 0}</strong><a href="corp_TotalDepartmentsReceivedGrievances.php?ulbid={$ulbid}&app_type_id=1&f_date={$fdate}&t_date={$tdate}&status=200">{$tot['underprogress_within_sla']}</a>{else}{$tot['underprogress_within_sla']}{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot['underprogress_beyond_sla'] gt 0}</strong><a href="corp_TotalDepartmentsReceivedGrievances.php?ulbid={$ulbid}&app_type_id=1&f_date={$fdate}&t_date={$tdate}&status=300">{$tot['underprogress_beyond_sla']}</a>{else}{$tot['underprogress_beyond_sla']}{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot['completed_within_sla'] gt 0}</strong><a href="corp_TotalDepartmentsReceivedGrievances.php?ulbid={$ulbid}&app_type_id=1&f_date={$fdate}&t_date={$tdate}&status=400">{$tot['completed_within_sla']}</a>{else}{$tot['completed_within_sla']}{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot['completed_beyond_sla'] gt 0}</strong><a href="corp_TotalDepartmentsReceivedGrievances.php?ulbid={$ulbid}&app_type_id=1&f_date={$fdate}&t_date={$tdate}&status=500">{$tot['completed_beyond_sla']}</a>{else}{$tot['completed_beyond_sla']}{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot['unresolved'] gt 0}{$tot['unresolved']}{else}{$tot['unresolved']}{/if}</strong></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot['reopened'] gt 0}</strong><a href="corp_TotalDepartmentsReceivedGrievances.php?ulbid={$ulbid}&app_type_id=1&f_date={$fdate}&t_date={$tdate}&status=600">{$tot['reopened']}</a>{else}{$tot['reopened']}{/if}</td>

            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot['reopend_underProgress'] gt 0}</strong><a href="corp_TotalDepartmentsReceivedGrievances.php?ulbid={$ulbid}&app_type_id=1&f_date={$fdate}&t_date={$tdate}&status=105">{$tot['reopend_underProgress']}</a>{else}{$tot['reopend_underProgress']}{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot['reopened_completed'] gt 0}</strong><a href="corp_TotalDepartmentsReceivedGrievances.php?ulbid={$ulbid}&app_type_id=1&f_date={$fdate}&t_date={$tdate}&status=601">{$tot['reopened_completed']}{else}{$tot['reopened_completed']}{/if}</td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot['rejected'] gt 0}{$tot['rejected']}{else}{$tot['rejected']}{/if}</strong></td>
            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot['fin'] gt 0}</strong><a href="corp_TotalDepartmentsReceivedGrievances.php?ulbid={$ulbid}&app_type_id=1&f_date={$fdate}&t_date={$tdate}&status=700">{$tot['fin']}</a>{else}{$tot['fin']}{/if}</td>
           <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $tot['transfers']['count']}<a href="corp_TotalDepartmentsReceivedGrievances.php?ulbid={$ulbid}&app_type_id=1&f_date={$fdate}&t_date={$tdate}&status=701">{$tot['transfers']['count']}</a>{else}{$tot['transfers']['count']}{/if}</strong></td>
           </tfoot> 
       
      </table>
    </div>

    <br>

  </div>
</div>




<br>




<div style="background-image:url(images/search_bg_2.jpg); height:28px;"></div>

{include file='corp_footer.tpl'}

