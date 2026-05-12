<?php echo form_open_multipart(); ?>
<input type="hidden" name="cat_id" value="<?php echo $cat_det['page_id']; ?>">

<div class="form-group">
                <label class="control-label col-sm-3" for="email">Post name: <span class="tx-danger">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="pagename" class="form-control mytext1"  onkeyup="fun1(this.value)" placeholder="Enter Post name">
                                <span class="myerror"> <?php echo form_error('pagename');?></span>
                </div>
        </div>
        
  <div class="form-group">
    <label class="control-label col-sm-3" for="email">Post Title: <span class="tx-danger">*</span></label>
    <div class="col-sm-9">
      <input type="text" name="pagetitle" class="form-control mytext1"  onkeyup="fun1(this.value)" placeholder="Enter Post title">
                    <span class="myerror"> <?php echo form_error('pagetitle');?></span>
    </div>
  </div>
 
  
  
  <div class="form-group">
    <label class="control-label col-sm-3" for="email"></label>
    <div class="col-sm-9">
      <input type="button" id="enableDate" value="Enable Date" class="btn btn-default">
      <input type="hidden" id="enableDateStatus" value="0">
    </div>
  </div>
  
  
  
  
  
  
  <div style="display:none" id="period">
  
   <div class="form-group">
    <label class="control-label col-sm-3" for="email">From Date: <span class="tx-danger"></span></label>
    <div class="col-sm-9">
      <input type="text" name="fromDate" class="form-control" id="datepickerfrom" value="00-00-0000" readonly>
                    <span class="myerror"> <?php echo form_error('fromDate');?></span>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-3" for="email">To Date: <span class="tx-danger"></span></label>
    <div class="col-sm-9">
      <input type="text" name="toDate" class="form-control" id="datepickerto" value="00-00-0000" readonly>
                    <span class="myerror"> <?php echo form_error('toDate');?></span>
    </div>
  </div>
  
  </div>
  

  

  
    

	<br><br>	<br>
	<div class="">
    <textarea id="richTextArea"  name="content" style=" height:400px;"><?php if($aboutData[0]['content'] !=''){echo $aboutData[0]['content'];} ?></textarea>
    
    </div>
    <br>
    
    <div class="form-horizontal">
        
    <div class="form-group">
    <label class="control-label col-sm-3" for="email">Related Tags:<span class="tx-danger">*</span> <br> <span style="font-size:12px;"> Separated by Enter </span></label>
    <div class="col-sm-9">
      <input type="text" class="form-control" placeholder="Ex (Sports, national , words , poltics)" name="ptags" >
      <!--<span class="myerror"> <?php echo form_error('ptags');?></span>-->
    </div>
    
  </div> 
  
  
   <div class="form-group">
    <label class="control-label col-sm-3" for="email">Description:  <span class="tx-danger">*</span> <br> </label>
    <div class="col-sm-9">
      <textarea rows="3" class="form-control mytext1" placeholder="Enter Page Related Description here " name="ptags" required></textarea>
                    <span class="myerror"> <?php echo form_error('ptags');?></span>
    </div>
  </div>
  
  
  </div>
    
    
    <span class="error"><?php echo form_error('content');?></span>
<br>
<center>
    <input type="button" name="draft" value="Save to Draft" class="btn btn-default btn-sm" id="draft" onclick="go_draft()">	
    <input type="submit" name="save" value="Publish" id="publish" class="btn btn-success btn-sm"></center>
	
    <br><br>



    </div>
    <?php echo form_close(); ?>