{include file='header.tpl'}
{literal}
{/literal}

     <form name='contact' method='POST' action='update_comm_contact.php' class="form-horizontal" enctype="multipart/form-data" onSubmit="return validateForm1()">
    			
        <input type="hidden" name="token" value="{$token_id}"/>
        
        <input type='hidden' name='previous_image' value="{$data.file_url}">
        <input type='hidden' name='previous_image' value="{$data.file_url}">
        <input type='hidden' name='id' value="{$data.id}">
        
        <input type='hidden' name='previous_building_image' value="{$data.officebuilding}">
        <div class="form-body">
        
            <div class="form-group">
                <label class="control-label col-md-3">HO/ Ward Office Name: <span class="required">* </span></label>
                    <div class="col-md-8">
                                <input name="comm_name" type="text" id="comm_name"  data-required="1" class="form-control" value="{$data.comm_name}" required >
                    </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3">Name Marathi: <span class="required">* </span></label>
                    <div class="col-md-8">
                                <input name="comm_name_marathi" type="text" id="comm_name_marathi"  data-required="1" class="form-control" value="{$data.comm_name_marathi}"  >
                    </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3">Mobile: <span class="required">* </span></label>
                    <div class="col-md-8">
                        <input name="mobile" type="text"  id="mobile1"  data-required="1" class="form-control int1 num" value="{$data.mobile}" onblur="validation()" />
                    </div>
            </div>
            
		    <div class="form-group">
                <label class="control-label col-md-3">Designation: <span class="required">* </span></label>
                    <div class="col-md-8">
                        <input name="designation" type="text"  data-required="1" class="form-control" value="{$data.designation}" required />

                    </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Department: <span class="required">* </span></label>
                    <div class="col-md-8">
                    <select name="user_type" class="form-select">
                        <option selected disabled>-- Select Designation --</option>
                        {foreach from=$departments key=des item=department}
                        <option value="{$department.id}" {if $data.user_type eq $department.id} selected {/if} >{$department.title}</option>
                        {/foreach}
                    </select>
                    </div>
                    
            </div>
            
   

            <div class="form-group">
                <label class="control-label col-md-3">Upload Photo: <span class="required">* </span></label>
                    <div class="col-md-8">
                                <input name="f1" type="file" id="f1"  data-required="1" class="form-control"/>
                    </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Previous Photo: <span class="required">* </span></label>
                    <div class="col-md-8">
                                <img src='{if $data.file_url eq ''}default-user.png{else} {$data.file_url} {/if}' width="75px" height="75px">
                    </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3">Email: <span class="required"> </span></label>
                    <div class="col-md-8">
                                <input type="email" id="email"  name="email" data-required="1" class="form-control" value="{$data.email}"/>
                    </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3">Land Line: <span class="required"> </span></label>
                    <div class="col-md-8">
                                <input type="text" id="land_line" name="land_line" data-required="1" class="form-control" value="{$data.land_line}"/>
                    </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3">Fax: <span class="required"> </span></label>
                    <div class="col-md-8">
                                <input type="text" id="fax" name="fax" data-required="1" class="form-control" value="{$data.fax}"/>
                    </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3">Address: <span class="required"> </span></label>
                    <div class="col-md-8">
                                <textarea class="form-control" name="address" >{$data.address}</textarea>
                    </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3">Address Marathi: <span class="required"> </span></label>
                    <div class="col-md-8">
                                <textarea class="form-control" name="address_marathi" >{$data.address_marathi}</textarea>
                    </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3">Map Link: <span class="required"> </span></label>
                    <div class="col-md-8">
                                <textarea class="form-control" name="link" >{$data.link}</textarea>
                    </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3">Office Building Photo: <span class="required">* </span></label>
                    <div class="col-md-8">
                                <input name="f2" type="file" id="f2"  data-required="1" class="form-control"/>
                    </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3">Previous Office Building Photo: <span class="required">* </span></label>
                    <div class="col-md-8">
                                <img src='{if $data.officebuilding eq ''}default-img.png{else} {$data.officebuilding} {/if}' width="75px" height="75px">
                    </div>
            </div>
            
            <div class="form-actions fluid">
                <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Update</button>
                <button type="button" class="btn btn-danger">Cancel</button>
                </div>
            </div>
        </div>
        
    </form>

{include file='footer.tpl'}
{literal}
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
{/literal}