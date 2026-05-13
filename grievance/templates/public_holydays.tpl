{include file='header.tpl'}
{literal}

<script>
	function validateForm() {
		var errors = 0;
	
		var errorMessage = $('#errorMessage');
            
        errorMessage.text('');
		var date1 = $("#datepicker").val();		  
		 
		if(!isValidDateWithDayValidation(date1)){
			errorMessage.text('Invalid date type. Allowed date type is yyyy-mm-dd only.');
			return false;
		}
		
		$(".text").each(function() {
			
			
			var date = $(".text").val();

			if (date == '') {
				($(this)).css({
					"background-color": "pink"
				});
				errors++;
			} else {
				($(this)).css({
					"background-color": "white"
				});
			}
		});
		
	
		if (errors == 0) {
			return true;
		} else {
			alert("Please Enter Correct Value in High-lighted Fields - " + errors);
			return false;
		}
	}

		
function isValidDateWithDayValidation(dateString) {
    // The date regex for YYYY-MM-DD
    var regex = /^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/;
    
    if (!regex.test(dateString)) {
        return false; // If it doesn't match the basic format
    }

    // Extract year, month, and day from the date string
    var parts = dateString.split('-');
    var year = parseInt(parts[0], 10);
    var month = parseInt(parts[1], 10) - 1; // Month is zero-indexed in JavaScript
    var day = parseInt(parts[2], 10);

    // Check if the date is valid using the Date object
    var date = new Date(year, month, day);

    // Return true if the day, month, and year match, else false
    return date.getFullYear() === year && date.getMonth() === month && date.getDate() === day;
}


		
	function delete_rec(id) {
		if (confirm('Do You Really Want To Delete This Record..!')) {
			var csrf_token = $("#csrf_token").val();
			$.post('delete_holy.php', {
				id: id,
				csrf_token: csrf_token
			}, function(data) {
				//alert(data);
				if (data == 1) {
					alert('Holidays Deleted Successfully..!');
					window.location = 'public_holydays.php';
				} else if (data == 0) {
					alert('Unable To Delete, Try Again..!');
				} else if (data == 3) {
					alert('Invalid Token..!');
				} else if (data == 4) {
					alert('csrf error');
				}
			});
		}
	}

</script>


<!--
<script type="text/javascript" language="javascript">
	$(document).ready(function() { /// Wait till page is loaded
		$('#buss').click(function() {
			//alert();
			$('#ref').load('http://egovmars.in/csms/public_holydays.php #ref', function() {
				/// can add another function here
			});
		});
	}); //// End of Wait till page is loaded
</script> -->
{/literal}




<div class="row ">
	<div>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar success">
				<h4>ADD HOLIDAY DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius">

				<form name='public_holydays' method='POST' action='save_public_holydays.php' class="form-horizontal" onSubmit="return validateForm()">

					<input type="hidden" name="token" value="{$token_id}" />

					<input type="hidden" name="csrf_token" value="{$csrf_token}" id="csrf_token" />
					<input type='hidden' name='street_id' value='0'>
					<div class="form-body">
						
{if $flash}
	<div class="{$flash.class}">
	<button class="close" data-close="alert"></button>
		{$flash.msg}
	</div>
{/if}

						<!--old 25-04-24 <div class="form-group">
							<label class="control-label col-md-3">Select Date:<span class="required">* </span></label>
							<div class="col-md-8">
								<input name='date' id="datepicker" type="date" data-required="1" class="form-control datepicker" data-type="date" onkeyup="funInputFielTypes(this)" required />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Description:<span class="required">* </span></label>
							<div class="col-md-8">
								<input name='desciption' id='desciption' type="text" data-required="1" class="form-control" data-type="sptext" onkeyup="funInputFielTypes(this)" required />
							<div style="font-size:10px;color:red;" id="desciptionX"></div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Description Marathi:<span class="required">* </span></label>
							<div class="col-md-8">
								<input name='desciption_marathi' id='desciption_marathi' type="text" data-required="1" class="form-control" data-type="sptext" onkeyup="funInputFielTypes(this)" required />
							<div style="font-size:10px;color:red;" id="desciption_marathiX"></div>
							</div>
						</div>
					
						<div class="form-actions fluid">
							<div class="col-md-offset-3 col-md-9">
								<button type="submit" class="btn btn-info" name='save'>Submit</button>-->
						<!--<button type="button" class="btn btn-danger" onclick="this.form.reset();">Cancel</button>-->
						<!--</div>
						</div>-->

						<div class="form-group">
							<label class="control-label col-md-4">Select Date <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<input name='date' id="datepicker" type="text" data-required="1" class="form-control datepicker" placeholder="Select Date" data-type="date" onchange="funInputFielTypes(this)" autocomplete="off" required />
							<div style="font-size:10px;color:red;" id="datepickerX"></div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4">Holiday Description <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<textarea name='desciption' id='desciption' rows="2" cols="50" data-required="1" class="form-control"  data-type="sptext" onkeyup="funInputFielTypes(this)"  placeholder="Enter Holiday Description" autocomplete="off" required="required"></textarea>
							<div style="font-size:10px;color:red;" id="desciptionX"></div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Description In Marathi <span class="required" style="color:red"> * </span> <span style="margin-left:10px;"> : </span> </label>
							<div class="col-md-4">
								<textarea name='desciption_marathi' id='desciption_marathi' rows="2" cols="50" data-required="1" class="form-control"  data-type="sptext" onkeyup="funInputFielTypes(this)"  placeholder="Enter Holiday Description In Marathi" autocomplete="off" required="required"></textarea>
							<div style="font-size:10px;color:red;" id="desciption_marathiX"></div>
							</div>
						</div>

						<!--<div class="form-group" id="ref">
							<label class="control-label col-md-3">
								<div style="border:1px solid #ccc;position: relative;left: 116px;top: -14px;background-image: url('/images/download.jpg');border-radius: 4px;width: 127px;text-align: center;color: red;
                                font-weight: bold;letter-spacing: 10px;font-size: 16px;">
									<p id="captImg" style="margin-top: 10px;">{$code}</p>
								</div>
							</label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="captcha" placeholder="Enter Captcha" required="required" style="width: 385px;
                                border-radius: 3px;" onpaste="return false;">
								<input type="hidden" name="code" value="{$code}">
							</div>
						</div>
						<div class="col-md-6 col-md-offset-3">
							<p>Can't read the image? click <a id="buss" class="refreshCaptcha" style="cursor:pointer;">here</a> to refresh.</p>
						</div>-->

						<div class="form-actions fluid">
							<div class="col-md-offset-5 col-md-9">
								<button type="submit" class="btn btn-info" name='save' id="submitBtn" disabled>Submit</button>
								<!-- <button type="button" class="btn btn-danger">Cancel</button> -->
								<button type="button" class="btn btn-danger" onclick="this.form.reset();">Cancel</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>




<div class="row" id="div_print">
	<div>
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar white">
				<!--<h4>Holidays</h4>-->
				<h4>EXISTING HOLIDAY DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius table-responsive">

				<!-- old 25-04-24 <table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
					<thead>

						<tr style="background-color:#2c3e50; color:#FFF;">
							<th style="text-align: center;">S.No</th>
							<th style="text-align: center;">Date</th>
							<th style="text-align: center;">Desciption</th>
							<th style="text-align: center;">Desciption Marathi</th>
							<th class="noExport" style="text-align: center;">Delete</th>
						</tr>
					</thead>

					<tbody>

						{foreach from=$doc_list item=row key=id}
						<tr id="{$row.id}">

							<td align="center">{counter}</td>
							<td align="center">{$row.date}</td>
							<td align="center">{$row.desciption}</td>
							<td align="center">{$row.desciption_marathi}</td>
							<td align="center" class="noExport">
								<button class="btn btn-danger" name='delete_rec' id='id' onclick="delete_rec('{$id}')"> <span class="fa fa-trash"></span> Delete </button>
							</td>
						</tr>
						{/foreach}
					</tbody>
				</table>-->

				<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
					<thead>
						<tr style="background-color:#2c3e50; color:#FFF;">
							<th style="text-align: center;">SR.NO</th>
							<th style="text-align: center;">DATE</th>
							<th style="text-align: center;">DESCRIPTION NAME</th>
							<th style="text-align: center;">DESCRIPTION IN MARATHI</th>
							<th style="text-align: center;">DELETE</th>
						</tr>
					</thead>

					<tbody>
						{foreach from=$doc_list item=row key=id}
						<tr id="{$row.id}">

							<td align="center">{counter}</td>
							<td align="center">{$row.date}</td>
							<td align="center">{$row.desciption}</td>
							<td align="center">{$row.desciption_marathi}</td>
							<td align="center" class="noExport">
								<button class="btn btn-danger" name='delete_rec' id='id' onclick="delete_rec('{$id}')"> <span class="fa fa-trash"></span> Delete </button>
							</td>
						</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
{include file='footer_print.tpl'}


{include file='footer.tpl'}
