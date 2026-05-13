{include file='header.tpl'}

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
<script src="assets/data-tables/jquery.dataTables.js"></script>
<script src="assets/data-tables/DT_bootstrap.js"></script>

<script>
function fill(desg_id, dept_id, desg_desc, desig_marathi) {
    document.manage_desg.desg_id.value = desg_id;
    $('#dept_id').val(dept_id);
    document.manage_desg.desg_desc.value = desg_desc;
    document.manage_desg.desig_marathi.value = desig_marathi;
    return false;
}

function delete_desg1(desg_id) {
    if(confirm("Do You Want To Delete The Selected Designation..!")) {
        document.manage_desg_del.desg_id.value = desg_id;
        document.manage_desg_del.submit();
    }
}

/*
$(document).ready(function() {
    $('#buss').click(function() {
        $('#ref').load('http://municipalservices.in/manage_desg.php #ref');
    });
}); */
</script>

<div class="row">

    <div class="boxed">
	
        <div class="title-bar success">
            <h4>ADD / UPDATE DESIGNATION DETAILS</h4>
        </div>
		
        <div class="inner no-radius">

			<form method="post" name='manage_desg_del' action="manage_desg_del.php">
                <input type="hidden" name="csrf_token" value="{$csrf_token}" />
                <input type='hidden' name='desg_id' value=''>
            </form> 

			{if !empty($errors)}
				{foreach $errors as $error}
					<p style="color:red;">{$error}</p>
				{/foreach}
			{/if}

            <form method="post" action="save_manage_desg.php" name="manage_desg" class="form-horizontal">
                <input type="hidden" name="csrf_token" value="{$csrf_token}" />
                <input type='hidden' name='desg_id' value='0'>

                <div class="form-body">
                    {if isset($msg)}
                    <div class="{$class}">
                        <button class="close" data-close="alert"></button>
                        {$msg}
                    </div>
                    {/if}

                    <div class="form-group">
                        <label class="control-label col-md-4">Select Department <span class="required" style="color:red"> * </span></label>
                        <div class="col-md-4">
                            <select name='dept_id' id='dept_id' class="form-control" required="required">
                                <option value='0'>-- Select Department --</option>
                                {html_options options=$dept_list}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4">Designation Name <span class="required" style="color:red"> * </span></label>
                        <div class="col-md-4">
                            <input name="desg_desc" id="desg_desc" type="text" maxlength='70' placeholder="Enter Designation Name" data-type="text" onkeyup="funInputFielTypes(this)" class="form-control" required="required" />
							<div style="font-size:10px;color:red;" id="desg_descX"></div>
						</div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4">Designation Name In Marathi <span class="required" style="color:red"> * </span></label>
                        <div class="col-md-4">
                            <input type="text" name="desig_marathi" id="desig_marathi" placeholder="Enter Designation Name In Marathi" class="form-control" data-type="text" onkeyup="funInputFielTypes(this)" required="required">
							<div style="font-size:10px;color:red;" id="desig_marathiX"></div>
						</div>
                    </div>

                    <div class="form-actions fluid">
                        <div class="col-md-offset-5 col-md-9">
                            <button type="submit" class="btn btn-info" name="save" id="submitBtn" disabled>Submit</button>
                            <button type="button" class="btn btn-danger" onclick="this.form.reset();">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row" id="div_print">
    <div class="boxed">
        <div class="title-bar white">
            <h4>EXISTING DESIGNATION DETAILS</h4>
        </div>
        <div class="inner no-radius table-responsive">
            <form action="manage_desg.php" method="post">
                <input type="hidden" name="csrf_token" value="{$csrf_token}" />
                <table class="table table-striped table-bordered table-hover table-full-width" id="data-table" width="100%">
                    <thead>
                        <tr style="background-color:#2c3e50; color:#FFF;">
                            <th>SR.NO</th>
                            <th>DEPARTMENT NAME</th>
                            <th>DESIGNATION NAME</th>
                            <th>DESIGNATION IN MARATHI</th>
                            <th>SORT ORDER</th>
                            <th class="noExport">EDIT</th>
                            <th class="noExport">DELETE</th>
                        </tr>
                    </thead>
                    <tbody>
                        {assign var="i" value="0"}
                        {foreach from=$desg_list item=row key=desg_id}
                        <tr>
                            <td>{$smarty.foreach.row.iteration}</td>
                            <td>{$dept_list[$row.dept_id]}</td>
                            <td>{$row.desg_desc}<input type="hidden" name="{'desg_id'|cat:$i}" value="{$desg_id}"></td>
                            <td>{$row.desig_marathi}</td>
                            <td> -
                               <!-- <select id="{'orderid'|cat:$i}" name="{'orderid'|cat:$i}">
                                    <option value="">-- Select --</option>
                                    {html_options options=$desg_count_list selected=$row.sort_order}
                                </select> -->
								
								
                            </td>
                            <td>
                                <input type="button" class="btn btn-primary" onclick="fill('{$desg_id}','{$row.dept_id}','{$row.desg_desc}','{$row.desig_marathi}')" value="Edit">
                            </td>
                            <td>
                                {if !isset($row.num_emp)}
                                <input type='radio' name='delete_desg' onchange="delete_desg1('{$desg_id}');"> Delete
                                {/if}
                            </td>
                        </tr>
                        {assign var="i" value=$i+1}
                        {/foreach}
                    </tbody>
                </table>
                <center>
                    <input type="hidden" name="cnt" value="{$i}">
                    <input type="submit" name="sort_order" value="UPDATE" class="btn btn-success">
                </center>
            </form>
        </div>
    </div>
</div>

{include file='footer_print.tpl'}
{include file='footer.tpl'}
