{include file='corp_header.tpl'}
{literal}

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script>
    function fill(ward_id, ward_desc) {
        document.manage_wards.ward_id.value = ward_id;
        document.manage_wards.ward_desc.value = ward_desc;
    }

    function delete_ward(ward_id) {

        if (confirm('Do You really want to delete this record')) {

            $.post('ajax_del_ward.php', {
                ward_id: ward_id
            }, function(data) {
                if (data == 1) {
                    alert('Ward deleted successfully');
                    window.location = 'manage_wards.php';
                } else if (data == 0) {
                    alert('Unable to delete , Try again');
                } else if (data == 2) {
                    alert('Ward is mapped with employees You cannot delete this ward');
                }

            });
        }

    }

    function validateForm() {
        var ward_desc = document.manage_wards.ward_desc.value;
        if (ward_desc == '') {
            alert("Please Enter Ward No / Description");
            return false;
        }

        return true;
    }
</script>
{/literal}

<div class="row ">
    <div class="">
        <div class="boxed">
            <!-- Title Bart Start -->
            <div class="title-bar blue d-flex align-items-center justify-content-between">
                <h4>Citizen Feedback Report</h4>
                <!-- <p class="m-0"><a href="ajax_corp_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
                <p class="m-0"><a href="corp_reports.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
            </div>
            <!-- Title Bart End -->
            <div class="inner no-radius">
                <div id="area">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
                        <caption style="caption-side:top; text-align:center;font-size:16px;">
                            <b>
                                <CENTER><strong>VIEW TOP 10 GRIEVANCES (GRIEVANCE TYPE & ZONE WISE) DETAILS</strong></CENTER>
                            </b>
                        </caption>
                        <thead>
                            <tr style="background-color:#161D6E; color:#FFF;text-align:center;">
                                <th class="text-white">Sr No.</th>
                                <th class="text-white">NAME OF DEPARTMENT</th>
                                <th class="text-white">TYPE OF COMPLAINT</th>
                                <th class="text-white">CITIZEN FEEDBACKS RECEIVED</th>
                            </tr>
                        </thead>
                        <tbody>

                            {assign var="tot" value="0"}


                            {foreach from=$cs_all_list item=row key=cs_id}
                            <tr>

                                <td align='center'>{counter}</td>
                                <td align='center'>{$cat_list[$row.cat_id]}</td>
                                <td>{$row.cs_desc}</td>
                                <td align='center'>{$data['feedbacks'][$cs_id]['count']}</td>

                            </tr>

                            {/foreach}

                            <tr>
                                <td colspan="3" class="text-center">Total</td>
                                <td class="text-center">{$totals['tot']}</td>

                            </tr>

                        </tbody>

                    </table>

                    {include file='footer_print.tpl'}

                </div>
            </div>

            </form>
        </div>
    </div>
</div>
</div>
</div>

{include file='corp_footer.tpl'}

{literal}
<script>
    $(".num").keydown(function(event) {
        // Allow only backspace and delete
        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9) {
            // let it happen, don't do anything
        } else {
            // Ensure that it is a number and stop the keypress
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                event.preventDefault();
            }
        }
    });
</script>
{/literal}