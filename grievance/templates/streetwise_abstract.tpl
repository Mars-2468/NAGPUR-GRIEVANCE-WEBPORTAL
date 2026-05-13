{include file='header.tpl'}
{literal}
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css" media="all">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /> Data Table CSS -->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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



<script>
    $(document).ready(function() {
        $(".datepick").datepicker({
            maxDate: +2000,
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });

    });
</script>
{/literal}



<!--<div class="" style="margin-top: -45px;">
    <form method="POST" class="form-horizontal">


<div class="boxed">
    
    <div class="title-bar blue"></div>
    <div class="inner no-radius">
   <!--{if $ulb eq '208' || $ulb eq '210' || $ulb eq '3'}     
<div class="col-md-3" style="margin-right:15px;">
<div class="form-group">
  <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">Village:</label>
  
   <select name="ulbid"  class="form-control">
              <option value="">--select--</option>
              {html_options options=$villages selected=$ulb}
          </select>
  
</div>
</div>
{/if}-
<div class="col-md-3" style="margin-right:15px;">
<div class="form-group">
  <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>
  
  <input type="text" class="phone-group form-control datepicker"  name="f_date" value="{$fdate}" placeholder="Select Date" autocomplete="off">
  
</div>
</div>      


<div class="col-md-3" style="margin-right:15px;">
<div class="form-group">
  <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>
 
  <input type="text" class="phone-group form-control datepicker"  name="t_date" value="{$tdate}" placeholder="Select Date" autocomplete="off">
  
</div>
</div>  
 
  <div class="col-md-2" >
       <div class="form-group" style="margin-top:31px;">
        <input name="search" type="submit" class="btn btn-success" value="SEARCH"> 
       </div>
      </div>   
   
   
    </div>
    
    
</div>


 </form>
 </div>-->

<!--<div style="text-align:right;"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></div>-->

<div class="" style="margin-top: -45px;">
    <form method="POST" class="form-horizontal">


        <div class="boxed">

            <div class="title-bar blue"></div>
            <div class="inner no-radius">
                <!--{if $ulb eq '208' || $ulb eq '210' || $ulb eq '3'}     
<div class="col-md-3" style="margin-right:15px;">
<div class="form-group">
  <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">Village:</label>
  
   <select name="ulbid"  class="form-control">
              <option value="">--select--</option>
              {html_options options=$villages selected=$ulb}
          </select>
  
</div>
</div>
{/if}-->
                <div class="col-md-3" style="margin-right:15px;">
                    <div class="form-group">
                        <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>

                        <input type="text" class="phone-group form-control datepicker" name="f_date" value="{$fdate}" placeholder="Select Date" autocomplete="off">

                    </div>
                </div>


                <div class="col-md-3" style="margin-right:15px;">
                    <div class="form-group">
                        <label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>

                        <input type="text" class="phone-group form-control datepicker" name="t_date" value="{$tdate}" placeholder="Select Date" autocomplete="off">

                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group" style="margin-top:31px;">
                        <input name="search" type="submit" class="btn btn-success" value="SEARCH">
                    </div>
                </div>


            </div>


        </div>


    </form>
</div>

<div class="boxed">


    <div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
        <h4>Zone Wise Abstract Report</h4>
        <!-- <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
        <p class="m-0"><a href="reports.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
    </div>



    <div class="inner no-radius">
        <div id="area" class="table-responsive">

            <table id='example' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
                <caption style="caption-side:top; text-align:center;font-size:16px;">
                    <b>
                        <CENTER><strong>VIEW WARD WISE ABSTRACT DETAILS</strong></CENTER>
                    </b>
                </caption>
                <thead>

                    <tr style="background-color:#2c3e50; color:#FFF;text-align:center;">
                        <th align='center' rowspan='2'> S.No </th>
                        <!--	<th align='center'> Id </th>-->
                        <th align='center' rowspan='2'> WARD NAME </th>
                        <th align='center' rowspan='2'> RECEIVED </th>
                        <th align='center' colspan='2'> UNDER PROGRESS </th>
                        <th align='center' colspan='2'>REDRESSED </th>
                        <th align='center' rowspan='2'> PENDING FOR APPROVAL </th>
                        <th align='center' rowspan='2'>UN RESOLVABLE </th>
                        <th align='center' rowspan='2'>REOPENED </th>
                        <th align='center' rowspan='2'>REOPENED UNDERPROGRESS </th>
                        <th align='center' rowspan='2'>REOPENED COMPLETED </th>
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
                  
                    {foreach from=$street_list key=street_id item=row}

                    
                    {if $user_type eq 'U'}
                        <tr>
                            <td align='center'>{counter}</td>
                            <!--<td>{$dept_id}</td>-->
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="street_complaints.php?app_type_id=1&ward_id={$data[$street_id]['ward_id']}&street_id={$street_id}&status=0&f_date={$fdate}&t_date={$tdate}" target="_blank">{$street_list[$street_id]}</a></td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$street_id].count neq ''}<a href="street_complaints.php?app_type_id=1&ward_id={$data[$street_id]['ward_id']}&street_id={$street_id}&status=0&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data[$street_id].count}</a>{else}-{/if}</td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].pending neq ''}<a href="street_complaints.php?app_type_id=1&ward_id={$data[$street_id]['ward_id']}&street_id={$street_id}&status=21&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$street_id].pending}</a>{else}-{/if}</td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].pending_be neq ''}<a href="street_complaints.php?app_type_id=1&ward_id={$data[$street_id]['ward_id']}&street_id={$street_id}&status=22&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$street_id].pending_be}</a>{else}-{/if}</td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].completed neq ''}<a href="street_complaints.php?app_type_id=1&ward_id={$data[$street_id]['ward_id']}&street_id={$street_id}&status=3891&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$street_id].completed}</a>{else}-{/if}</td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].completed_be_sla neq ''}<a href="street_complaints.php?app_type_id=1&ward_id={$data[$street_id]['ward_id']}&street_id={$street_id}&status=3892&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$street_id].completed_be_sla}{else}-{/if}</td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].pending_approval neq ''}<a href="street_complaints.php?app_type_id=1&ward_id={$data[$street_id]['ward_id']}&street_id={$street_id}&status=1&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$street_id].pending_approval}</a>{else}-{/if}</td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].unresolved neq ''}<a href="street_complaints.php?app_type_id=1&ward_id={$data[$street_id]['ward_id']}&street_id={$street_id}&status=4&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$street_id].unresolved}</a>{else}-{/if}</td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].reopened neq ''}<a href="street_complaints.php?app_type_id=1&ward_id={$data[$street_id]['ward_id']}&street_id={$street_id}&status=13&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$street_id].reopened} </a>{else}-{/if} </td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].reopend_underProgress neq ''}<a href="street_complaints.php?app_type_id=1&ward_id={$data[$street_id]['ward_id']}&street_id={$street_id}&status=11&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$street_id].reopend_underProgress} </a>{else}-{/if} </td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].reopend_completed neq ''}<a href="street_complaints.php?app_type_id=1&ward_id={$data[$street_id]['ward_id']}&street_id={$street_id}&status=12&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$street_id].reopend_completed} </a>{else}-{/if} </td>
							
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].fin neq ''}<a href="street_complaints.php?app_type_id=1&ward_id={$data[$street_id]['ward_id']}&street_id={$street_id}&status=6&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$street_id].fin} </a>{else}-{/if} </td>
                 		    <td align='center' class="{if $active_class eq 'tr-clm3qclmn1'}activ_column{/if}">{if $data_list[$street_id].transfered neq ''}<a href="street_complaints.php?app_type_id=1&ward_id={$data[$street_id]['ward_id']}&street_id={$street_id}&status=510&f_date={$fdate}&t_date={$tdate}" target="_blank">{$data_list[$street_id].transfered} </a>{else}-{/if} </td>
						</tr>
                    {else}
                    <!-- @if($user_type eq 'E') -->
                        <tr>
                            <td align='center'>{counter}</td>
                            <!--<td>{$dept_id}</td>-->
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><a href="street_complaints.php?app_type_id=1&dept_id={$dept_id}&f_date={$fdate}&t_date={$tdate}&status=0">{$street_list[$dept_id]}</a></td>

                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data[$street_id].count neq ''}<a href="street_complaints.php?app_type_id=1&dept_id={$dept_id}&f_date={$fdate}&t_date={$tdate}&status=100">{$data[$dept_id].count}</a>{else}-{/if}</td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].pending neq ''}<a href="street_complaints.php?app_type_id=1&dept_id={$dept_id}&status=02&f_date={$fdate}&t_date={$tdate}">{$data_list[$dept_id].pending}</a>{else}-{/if}</td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].pending_be neq ''}<a href="street_complaints.php?app_type_id=1&dept_id={$dept_id}&status=08&f_date={$fdate}&t_date={$tdate}">{$data_list[$dept_id].pending_be}</a>{else}-{/if}</td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].completed neq ''}<a href="street_complaints.php?app_type_id=1&dept_id={$dept_id}&status=03&f_date={$fdate}&t_date={$tdate}">{$data_list[$dept_id].completed}</a>{else}-{/if}</td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].completed_be_sla neq ''}<a href="street_complaints.php?app_type_id=1&dept_id={$dept_id}&status=09&f_date={$fdate}&t_date={$tdate}">{$data_list[$dept_id].completed_be_sla}</a>{else}-{/if}</td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].pending_approval neq ''}<a href="street_complaints.php?app_type_id=1&dept_id={$dept_id}&status=01&f_date={$fdate}&t_date={$tdate}">{$data_list[$dept_id].pending_approval}</a>{else}-{/if}</td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].unresolved neq ''}<a href="street_complaints.php?app_type_id=1&dept_id={$dept_id}&status=44&f_date={$fdate}&t_date={$tdate}">{$data_list[$dept_id].unresolved}</a>{else}-{/if}</td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].reopened neq ''}<a href="street_complaints.php?app_type_id=1&dept_id={$dept_id}&status=05&f_date={$fdate}&t_date={$tdate}">{$data_list[$dept_id].reopened} </a>{else}-{/if} </td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].reopend_underProgress neq ''}<a href="street_complaints.php?app_type_id=1&dept_id={$dept_id}&status=0105&f_date={$fdate}&t_date={$tdate}">{$data_list[$dept_id].reopend_underProgress} </a>{else}-{/if} </td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].reopend_completed neq ''}<a href="street_complaints.php?app_type_id=1&dept_id={$dept_id}&status=07&f_date={$fdate}&t_date={$tdate}">{$data_list[$dept_id].reopend_completed} </a>{else}-{/if} </td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].rejected neq ''}<a href="street_complaints.php?app_type_id=1&dept_id={$dept_id}&status=4&f_date={$fdate}&t_date={$tdate}">{$data_list[$dept_id].rejected} </a>{else}-{/if} </td>
                            <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $data_list[$street_id].fin neq ''}<a href="street_complaints.php?app_type_id=1&dept_id={$dept_id}&status=060&f_date={$fdate}&t_date={$tdate}">{$data_list[$dept_id].fin} </a>{else}-{/if} </td>
                        </tr>

                    <!-- @endif -->
                    {/if}
                    {/foreach}

                </tbody>
                {if $user_type eq 'U'}
                <tfoot>
                    <td align='center' colspan="2"><strong>Total</strong></td>
                    <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot['received'] gt 0}<a href="total_streetwise_complaints.php?app_type_id=1&status=100&ward_id={$data[$street_id]['ward_id']}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$tot['received']}</a>{else}<strong>{$tot['received']}</strong>{/if}</td>
                    <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot['pending'] gt 0}<a href="total_streetwise_complaints.php?app_type_id=1&status=121&ward_id={$data[$street_id]['ward_id']}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$tot['pending']}</a>{else}<strong>{$tot['pending']}</strong>{/if}</td>
                    <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot['pending_be'] gt 0}<a href="total_streetwise_complaints.php?app_type_id=1&status=122&ward_id={$data[$street_id]['ward_id']}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$tot['pending_be']}</a>{else}<strong>{$tot['pending_be']}</strong>{/if}</td>
                    <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot['completed'] gt 0}<a href="total_streetwise_complaints.php?app_type_id=1&status=13891&ward_id={$data[$street_id]['ward_id']}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$tot['completed']}</a>{else}<strong>{$tot['completed']}</strong>{/if}</td>
                    <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot['completed_be_sla'] gt 0}<a href="total_streetwise_complaints.php?app_type_id=1&status=13892&ward_id={$data[$street_id]['ward_id']}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$tot['completed_be_sla']}</a>{else}<strong>{$tot['completed_be_sla']}</strong>{/if}</td>
                    <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot['pending_approval'] gt 0}<a href="total_streetwise_complaints.php?app_type_id=1&status=101&ward_id={$data[$street_id]['ward_id']}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$tot['pending_approval']}</a>{else}<strong>{$tot['pending_approval']}</strong>{/if}</td>
                    <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot['unresolved'] gt 0}<a href="total_streetwise_complaints.php?app_type_id=1&status=5&ward_id={$data[$street_id]['ward_id']}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$tot['unresolved']}</a>{else}<strong>{$tot['unresolved']}</strong>{/if}</td>

                    <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot['reopened'] gt 0}<a href="total_streetwise_complaints.php?app_type_id=1&status=113&ward_id={$data[$street_id]['ward_id']}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$tot['reopened']}</a>{else}<strong>{$tot['reopened']}</strong>{/if}</td>
                    <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot['reopend_underProgress'] gt 0}<a href="total_streetwise_complaints.php?app_type_id=1&status=111&ward_id={$data[$street_id]['ward_id']}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$tot['reopend_underProgress']}</a>{else}<strong>{$tot['reopend_underProgress']}</strong>{/if}</td>
                    <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot['reopend_completed'] gt 0}<a href="total_streetwise_complaints.php?app_type_id=1&status=112&ward_id={$data[$street_id]['ward_id']}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$tot['reopend_completed']}</a>{else}<strong>{$tot['reopend_completed']}</strong>{/if}</td>
                    <!--
					<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot['rejected'] gt 0}<a href="total_streetwise_complaints.php?app_type_id=1&status=104&ward_id={$data[$street_id]['ward_id']}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$tot['rejected']}</a>{else}<strong>{$tot['rejected']}</strong>{/if}</td>
                    -->
					<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot['fin'] gt 0}<a href="total_streetwise_complaints.php?app_type_id=1&status=106&ward_id={$data[$street_id]['ward_id']}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$tot['fin']}</a>{else}<strong>{$tot['fin']}</strong>{/if}</td>
                    <td align='center' class="{if $active_class eq 'tr-clm3qclmn1'}activ_column{/if}">{if $tot['transfered']['count'] gt 0}<a href="total_streetwise_complaints.php?app_type_id=1&status=1510&ward_id={$data[$street_id]['ward_id']}&f_date={$fdate}&t_date={$tdate}" target="_blank">{$tot['transfered']['count']}</a>{else}<strong>{$tot['transfered']['count']}</strong>{/if}</td>
                </tfoot>
                <!-- @endif -->
                {else}
                <!-- @if($user_type eq 'E') -->


                <!-- @endif -->
                {/if}
            </table>
        </div>

        <br>
        <div>
            <center>
                <!-- <input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success"/>
                <input type='button' value='Print' onclick="print_div()" class="btn btn-danger" />
                <button class="btn btn-info" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> All PDF</button> -->
                <!-- <input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export All Excel" class="btn btn-success" />
                <button class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> Export All PDF</button>
                <input type='button' value='Print' onclick="print_div()" class="btn btn-danger" /> -->
                <form action="exporttoexcel.php" method="post">
                    <!-- <input type="hidden" name="status" value="{$status}">
                    <input type="hidden" name="sla" value="{$sla}">
                    <input type="hidden" name="user_type" value="{$user_type}">
                    <input type="submit" name="excel" value="Export All Excel" class="btn btn-success"/> -->
                    <input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export To Excel" class="btn btn-success" />
                    <button type='button' class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> Export To PDF</button>
                    <input type='button' value='Print' onclick="print_div()" class="btn btn-danger" />
                </form><br>
            </center>
        </div>


    </div>
</div>




<br>




<div style="background-image:url(images/search_bg_2.jpg); height:28px;"></div>
{include file='footer.tpl'}



<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>

<script>
    function exportTableToPDF(TableId, ReportName) {
        // Create a new jsPDF instance
        const doc = new jsPDF('landscape');
        doc.setFontSize(10);

        // Add a heading to the PDF
        //const captionText = document.querySelector('#' + TableId + ' caption').textContent;
        const captionElement = document.querySelector('#' + TableId + ' caption');
        const captionText = captionElement ? captionElement.textContent : "";

        const cleanedCaptionText = captionText.replace(/\s+/g, ' ').trim();
        const pageWidth = doc.internal.pageSize.width;
        const textWidth = doc.getStringUnitWidth(cleanedCaptionText) * doc.internal.getFontSize() / doc.internal.scaleFactor;
        const x = (pageWidth - textWidth) / 2;
        doc.text(cleanedCaptionText, x, 15);

        // Generate the table from the HTML table with the specified TableId
        const table = document.getElementById(TableId);

        doc.autoTable({
            html: '#' + TableId,
            showFoot: "lastPage",
            styles: {
                lineColor: [0, 0, 0],
                fontSize: 8,
                textColor: [0, 0, 0]
            },
            headStyles: {
                fillColor: [173, 216, 230],
                lineWidth: 0.5,
                fontStyle: 'bold',
                halign: 'center',
                cellPadding: 1,
            },
            bodyStyles: {
                lineWidth: 0.5,
                halign: 'center',
                cellPadding: 1,
                alignment: 'center',
            },
            footStyles: {
                fillColor: [173, 216, 230],
                lineWidth: 0.5,
                halign: 'center',
                cellPadding: 1,
                alignment: 'center',
            },

            rowStyles: {
                lineColor: [0, 0, 0],
            },
            margin: {
                top: 20
            },
            didDrawPage: function(data) {
                // Modify the fill color of the footer on the last page
                if (typeof data.table !== "undefined" && data.pageNumber === data.table.finalYPage) {
                    doc.setFillColor(255, 255, 255);
                    doc.setTextColor(0, 0, 0);
                    doc.rect(data.settings.margin.left, doc.internal.pageSize.height - 20, doc.internal.pageSize.width - data.settings.margin.left - data.settings.margin.right, 10, 'F');
                }
            },
        });

        doc.save(ReportName + '.pdf');
    }
</script>
<script>
    $(function() {
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true
        });
    });
</script>