{include file='header.tpl'}
<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').dataTable();
        $('#myDataTable1').dataTable();

    });

</script>
<div id="div_print" style="border:#999999 0px solid;">


    <form method="POST" class="form-horizontal">


        <div class="boxed">

             <div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
        <h4>Complaint Wise Report</h4>
        <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
    </div>
            <!--<div class="inner no-radius">
        
        <div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-5" for="usr">From Date:</label>
  <div class="col-sm-7">
  <input type="text" class="phone-group form-control datepicker"  name="f_date" value="{$fdate}">
  </div>
</div>
</div>      


<div class="col-md-3">
<div class="form-group">
  <label class="control-label col-sm-5" for="usr">To Date:</label>
  <div class="col-sm-7">
  <input type="text" class="phone-group form-control datepicker"  name="t_date" value="{$tdate}">
  </div>
</div>
</div>  
 
  <div class="col-md-2" align="right"><input name="search" type="submit" class="btn btn-success" value="SEARCH"> </div>   
   
        
    </div>
</div>





 </form>
 </div>-->

        </div>

        <div class="inner no-radius">
            <div style="width:100%; overflow:scroll;">
                <div id="area">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="data-table">

                        <thead>

                            <tr class="mytr_bgcolor" style="background-color:#161D6E; color:#FFF;">
                                <td rowspan="2">S.No</td>
                                <td rowspan="2">Category Type</td>
                                <td rowspan="2">Grievance </td>
                                <td rowspan="2">Received</td>

                                <td colspan="2" align="center">Resolved</td>
                                <td colspan="2" align="center">Pending</td>
                                <td rowspan="2">Financial Implications</td>
                                <td rowspan="2">Pending for approval</td>
                                <td rowspan="2">Rejected</td>
                                <td rowspan="2">Unresolved</td>
                                <td rowspan="2">% of Complete</td>


                            </tr>



                            <tr class="mytr_bgcolor" style="background-color:#161D6E; color:#FFF;">
                                <td align="center">With in SLA</td>
                                <td align="center">Beyond SLA</td>
                                <td align="center">With in SLA</td>
                                <td align="center">Beyond SLA</td>

                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$cs_list item=row key=cs_id}
                            <tr>
                                <td>{counter}</td>
                                <td>{$cat_list[$cat_id[$cs_id].cat_id]}</td>
                                <td><a href="complaints_full_rep.php?cs_id={$cs_id}&street_id={$emp_id}">{$cs_list[$cs_id]}</a></td>
                                <td><a href="complaints_full_rep.php?cs_id={$cs_id}&status=1" target="_blank">{$data[$cs_id].total_received}</a></td>

                                <td><a href="complaints_full_rep.php?cs_id={$cs_id}&status=2" target="_blank">{$data[$cs_id].resolved_within_sla}</a></td>
                                <td><a href="complaints_full_rep.php?cs_id={$cs_id}&status=3" target="_blank">{$data[$cs_id].resolved_beyond_sla}</a></td>

                                <td><a href="complaints_full_rep.php?cs_id={$cs_id}&status=4" target="_blank">{$data[$cs_id].pending_within_sla}</a></td>
                                <td><a href="complaints_full_rep.php?cs_id={$cs_id}&status=5" target="_blank">{$data[$cs_id].pending_beyond_sla}</a></td>

                                <td><a href="complaints_full_rep.php?cs_id={$cs_id}&status=6" target="_blank">{$data[$cs_id].fin_implication}</a></td>
                                <td><a href="complaints_full_rep.php?cs_id={$cs_id}&status=7" target="_blank">{$data[$cs_id].pending_apprvl}</a></td>
                                <td><a href="complaints_full_rep.php?cs_id={$cs_id}&status=8" target="_blank">{$data[$cs_id].rejected}</a></td>
                                <td><a href="complaints_full_rep.php?cs_id={$cs_id}&status=8" target="_blank">{$data[$cs_id].unresolved}</a></td>
                                <td>{$data[$cs_id].percent}</td>
                            </tr>
                            {/foreach}
                        </tbody>
                        <tfoot>

                            <tr>
                                <td colspan="3">Total</td>

                                <td>{$tot.total_received}</td>


                                <td>{$tot.resolved_within_sla}</td>
                                <td>{$tot.resolved_beyond_sla}</td>

                                <td>{$tot.pending_within_sla}</td>
                                <td>{$tot.pending_beyond_sla}</td>

                                <td>{$tot.fin_implication}</td>
                                <td>{$tot.pending_apprvl}</td>
                                <td>{$tot.rejected}</td>
                                <td>{$tot.unresolved}</td>
                                <td>{$tot.percent}</td>
                            </tr>

                        </tfoot>
                    </table>

                    {include file='footer_print.tpl'}


                </div>
            </div>
        </div>
</div>

<!--<center>
 	<input type="hidden" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='hidden' value='Print' onclick="print_div()" class="btn btn-danger">
</center>-->

{literal}






<style>
    div.pagination {
        padding: 3px;
        margin: 3px;
    }

    div.pagination a {
        padding: 2px 5px 2px 5px;
        margin: 2px;
        border: 1px solid #AAAADD;

        text-decoration: none;
        /* no underline */
        color: #000099;
    }

    div.pagination a:hover,
    div.pagination a:active {
        border: 1px solid #000099;

        color: #000;
    }

    div.pagination span.current {
        padding: 2px 5px 2px 5px;
        margin: 2px;
        border: 1px solid #000099;

        font-weight: bold;
        background-color: #000099;
        color: #FFF;
    }

    div.pagination span.disabled {
        padding: 2px 5px 2px 5px;
        margin: 2px;
        border: 1px solid #EEE;

        color: #DDD;
    }

</style>





{/literal}

<center>
    <div id="pagination" class="pagination" align="center">{$pagination}</div>
</center>
<br>
{include file='footer.tpl'}

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script>
    $(function() {
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true
        });
    });

</script>
