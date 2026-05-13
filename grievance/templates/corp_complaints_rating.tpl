{include file='corp_header.tpl'}
{literal}
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
<style>
table>thead>tr>th{
	color:#FFF !important;
}
</style>
{/literal}


<div class="">

	<form method="POST" action="" class="form-horizontal">
		<div class="boxed">
			
			<div class="inner no-radius" style="border-bottom-left-radius: 0px !important;border-bottom-right-radius: 0px !important;">
				{if !empty($errors)}
					{foreach $errors as $error}
						<p style="color:red;">{$error}</p>
					{/foreach}
				{/if}
				<div class="col-md-2" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>
						<input type="text" class="phone-group form-control datepicker" name="f_date" id="f_date" value="{$fdate}" placeholder="Select Date" data-type="date" onchange="funInputFielTypes(this)" autocomplete="off">
						<div style="font-size:10px;color:red;" id="f_dateX"></div>
					</div>
				</div>
				<div class="col-md-2" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>
						<input type="text" class="phone-group form-control datepicker" name="t_date" id="t_date" value="{$tdate}" placeholder="Select Date" data-type="date" onchange="funInputFielTypes(this)" autocomplete="off">
						<div style="font-size:10px;color:red;" id="t_dateX"></div>
					</div>
				</div>
								
				<div class="col-md-2">
					<div class="form-group" style="margin-top:31px;">
						<input name="search" type="submit" class="btn btn-success" value="Search" id="submitBtn" disabled>
					<a class="btn btn-dark" style="color:#FFF" href="">Reset</a>
					</div>
				</div>
			</div>
		</div>
	</form>

</div>

<div class="row ">
    <div class="">
        <div class="boxed">
            <!-- Title Bart Start -->
            <div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
                <h4>Citizen Feedback Department wise and category wise</h4>
                <!-- <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
                <p class="m-0"><a href="corp_reports.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
            </div>
            <!-- Title Bart End -->
            <div class="inner no-radius">
                <div id="area" class=" table-responsive">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
                        <caption style="caption-side:top; text-align:center;font-size:16px;">
                            <b>
                                <CENTER><strong>VIEW CITIZEN FEEDBACK DEPARTMENT WISE AND CATEGORY WISE DETAILS</strong></CENTER>
                            </b>
                        </caption>
                        <thead>
                            <tr style="background-color:#161D6E; color:#FFF;text-align:center;">
                                <th>Sr.no</th>
                                <th>COMPLAINT NAME</th>
                                <th>5-STAR RATING</th>
                                <th>4-STAR RATING</th>
                                <th>3-STAR RATING</th>
                                <th>2-STAR RATING</th>
                                <th>1-STAR RATING</th>
                                <th>TOTAL</th>

                            </tr>

                        </thead>
                        <tbody>

                            {assign var="tot" value="0"}

                            {foreach from=$cat_list item=row key=cat_id}
							{if $cat_id != ''}
                            <tr style="background-color:#D9FAFF; font-weight:bold; color:#000;">
                                <td colspan="8"><strong>{$cat_list[$cat_id]}</strong></td>
                            </tr>

                            {foreach from=$cs_list[$cat_id] item=row2 key=cs_id}
                            <tr>

                                <td align='center'>{counter}</td>
                                <td>{$row2.desc}</td>
                                <td align='center'><a href="rating_wise_dept_complaints.php?app_type_id=1&rating_num=5&cs_id={$cs_id}&department_id={$cat_id}&status=0&f_date={$fdate}&t_date={$tdate}" target="_blank"">{$data[$cs_id].5star}</a></td>
                                <td align='center'><a href="rating_wise_dept_complaints.php?app_type_id=1&rating_num=4&cs_id={$cs_id}&department_id={$cat_id}&status=0&f_date={$fdate}&t_date={$tdate}" target="_blank"">{$data1[$cs_id].4star}</a></td>
                                <td align='center'><a href="rating_wise_dept_complaints.php?app_type_id=1&rating_num=3&cs_id={$cs_id}&department_id={$cat_id}&status=0&f_date={$fdate}&t_date={$tdate}" target="_blank"">{$data2[$cs_id].3star}</a></td>
                                <td align='center'><a href="rating_wise_dept_complaints.php?app_type_id=1&rating_num=2&cs_id={$cs_id}&department_id={$cat_id}&status=0&f_date={$fdate}&t_date={$tdate}" target="_blank"">{$data3[$cs_id].2star}</a></td>
                                <td align='center'><a href="rating_wise_dept_complaints.php?app_type_id=1&rating_num=1&cs_id={$cs_id}&department_id={$cat_id}&status=0&f_date={$fdate}&t_date={$tdate}" target="_blank"">{$data4[$cs_id].1star}</a></td>
                                <td align='center'>{$data[$cs_id].5star+$data1[$cs_id].4star+$data2[$cs_id].3star+$data3[$cs_id].2star+$data4[$cs_id].1star}</td>



                            </tr>
						
                            {/foreach}	
							{/if}
                            {/foreach}



                            <tr>
                                <td align='center' colspan="2"><strong>Total</strong></td>
                                <td align='center'><strong>{$totals.5}</strong></td>
                                <td align='center'><strong>{$totals.4}</strong></td>
                                <td align='center'><strong>{$totals.3}</strong></td>
                                <td align='center'><strong>{$totals.2}</strong></td>
                                <td align='center'><strong>{$totals.1}</strong></td>
                                <td align='center'><strong>{$totals.tot}</strong></td>
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