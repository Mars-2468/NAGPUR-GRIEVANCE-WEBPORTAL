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

    <div class="title-bar success">
        <h4>SELECT FROM THE LIST TO UPDATE THE DETAILS</h4>
    </div>
    <div class="inner no-radius table-responsive">
        <div style="text-align:right; margin-top:0px; font-size:12px; font-weight:bold; color:red;">To Search : Enter Data In Textbox And Press ENTER</b></div>


        <div style="width:100%; overflow:scroll;">
            <form action="" method="post">
                <table class="table">
                    <tr>
                        <th colspan='5'>FILTER :</th>
                    </tr>
                    <tr>
                        <th>TYPE </th>
                        <!-- <th>File no:</th> -->
                        <th>COMPLAINT ID </th>
                        <th>APPLICANT NAME </th>
                        <th>MOBILE NO </th>
                        <th>ZONE NO </th>
                        <th>DEPARTMENT </th>
                        <th>SERVICE / COMPLAINTS</th>
                        <th></th>

                    </tr>
                    <tr>
                        <td><select name="app_type_id" id="app_type_id" onchange="fun1(this.value)" class="form-control form-control-inline input-medium" autocomplete="off">
                                <option value="">-- Select Type --</option>
                                {html_options options=$app_type_list selected=$app_type_id}
                            </select></td>
                        <!-- <td><input type="text" name="ref_no" placeholder="File no" value="{$ref_no}"></td> -->
                        <td><input type="text" class="form-control form-control-inline input-medium" name="ref_no" placeholder="Enter Complaint ID" value="{$ref_no}" autocomplete="off"></td>
                        <td><input type="text" class="form-control form-control-inline input-medium" name="applicant_name" placeholder="Enter Applicant Name" value="{$applicant_name}" autocomplete="off"></td>
                        <td><input type="text" class="form-control form-control-inline input-medium" name="mobile" placeholder="Enter Mobile Number" value="{$mobile}" autocomplete="off"></td>


                        <td><select name="ward_id" id="ward_id" class="form-control form-control-inline input-medium" autocomplete="off">
                                <option value="">-- Select Zone --</option>
                                {html_options options=$ward_list selected=$ward_id}
                            </select></td>


                        <td><select name="dept_id" id="dept_id" class="form-control form-control-inline input-medium" autocomplete="off">
                                <option value="">-- Select Departemnt --</option>
                                {html_options options=$dept_list selected=$dept_id}
                            </select></td>


                        <td><select name="cat3_id" id="cat3_id" class="form-control form-control-inline input-medium" autocomplete="off">
                                <option value="">-- Select Service / Complaints --</option>
                                {html_options options=$list selected=$cat3_id}
                            </select></td>

                        <td><input type="submit" name="search" value="Search" class="btn btn-success btn-sm"></td>
                    </tr>
                </table>
            </form>
        </div>

        <hr>

        <form name='manage_comp_det' id='manage_comp_det' action='manage_comp_sel_test.php' method='POST'>
            <div id="demo">
                <div class="table-responsive" style="width:100%; overflow:scroll;">
                    <table cellpadding="3" cellspacing="0" border="1" class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
                        <thead>
                            <tr style="background-color:#2c3e50;">
                                <th style="text-align: center;">
                                    <font color='white'>SR.NO</font>
                                </th>
                                <th style="text-align: center;">
                                    <font color='white'>MODE</font>
                                </th>
                                <!-- <th  style="text-align: center;"><font color='white'>File No</font></th> -->
                                <th style="text-align: center;">
                                    <font color='white'>COMPLAINT ID</font>
                                </th>
                                <th style="text-align: center;">
                                    <font color='white'>NAME & MOBILE NO</font>
                                </th>
                                <th style="text-align: center;">
                                    <font color='white'>ZONE</font>
                                </th>
                                <th style="text-align: center;">
                                    <font color='white'>COMPLAINT / SERVICE</font>
                                </th>
                                <th style="text-align: center;">
                                    <font color='white'>DEPARTMENT</font>
                                </th>
                                <th style="text-align: center;">
                                    <font color='white'>CURRENT STATUS</font>
                                </th>

                                <th style="text-align: center;" class="export">
                                    <font color='white'>UPDATE</font>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$data key=grievance_id item=row}
                            <input type="hidden" name="app_type_id" value="{$row.app_type_id}">
                            <input type="hidden" name="cs_id" value="{$row.cat3_id}">
                            <tr>
                                <td style="text-align: center;">{counter}</td>
                                <td style="text-align: center;">
                                    {if $row.app_type_id eq '2'}
                                    Citizen Charter Counter
                                    {else}
                                    {$grievance_origin_list[$row.grievance_origin_id]}

                                    {/if}
                                </td>
                                {if $ulbid eq '207'}
                                {if $row.app_type_id eq '2'}
                                <td style="text-align: center;">{$row.file_no}</td>
                                {else}
                                <td style="text-align: center;">{$grievance_id}</td>
                                {/if}
                                {else}
                                <td style="text-align: center;">{$grievance_id}</td>
                                {/if}
                                <td style="text-align: center;">{$row.person_name} ({$row.mobile})</td>
                                <td style="text-align: center;">{$ward_list[$row.ward_id]}</td>
                                {if $row.app_type_id eq '1'}
                                <td><label title="{$row.comp_desc}">{$cs_list[$row.cat3_id]} {if $data[$grievance_id].comp_desc neq ''} - {$data[$grievance_id].comp_desc} {/if}</label></td>
                                {else}
                                <td><label title="{$row.comp_desc}">{$cat3_list[$row.mcat3_id]}</label></td>
                                {/if}
                                <td style="text-align: center;">{$dept_list[$row.emp_dept]}</td>
                                <td style="text-align: center;"><strong>{$grievance_status_list[$row.grievance_status_id]}</strong></td>

                                <td style="text-align: center;"><input type='radio' name='grievance_id' value='{$grievance_id}' onclick="get_comp_det(this.value)"></td>
                            </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
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
{/literal}
<div>
</div>

{include file='footer.tpl'}