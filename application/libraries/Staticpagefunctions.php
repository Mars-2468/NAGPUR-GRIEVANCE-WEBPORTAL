<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Staticpagefunctions
{
  function __construct()
  {
    $this->CI = &get_instance();
    $this->CI->load->database();
    $this->CI->load->library('session');
    //$this->CI->load->helper('captcha');
  }

  public function getAgendaAndMinutes()
  {

    // $select_array=array( 'tbl_agenda_mst.id as mainid', 'tbl_agenda_mst.*', 'tbl_agenda_category_mst.*', 'tbl_agenda_category_year_mst.*' );

    // $condition=array('tbl_agenda_mst.status'=>'Enable','tbl_agenda_category_mst.status'=>'Enable','tbl_agenda_category_year_mst.status'=>'Enable');

    // $this->CI->db->select($select_array);

    // $this->CI->db->from('tbl_agenda_mst');

    // $this->CI->db->join('tbl_agenda_category_mst','tbl_agenda_mst.category_id=tbl_agenda_category_mst.id');

    // $this->CI->db->join('tbl_agenda_category_year_mst','tbl_agenda_mst.year_id=tbl_agenda_category_year_mst.id');

    // $this->CI->db->where($condition);
    // $res = $this->CI->db->get()->result_array();
    //echo '<pre>';print_r($res);

    $select_array = array('id', 'category', 'status');
    $condition = array('status' => 'Enable');
    $this->CI->db->select($select_array);
    $this->CI->db->from('tbl_agenda_category_mst');
    $this->CI->db->where($condition);
    $res = $this->CI->db->get()->result_array();
    //echo '<pre>';print_r($res);
    $html = '<div class="clearfix"></div><div class="main-content"><div class="container"><div id="print_divv"><h5>Agenda And Minutes</h5><hr /><div class=" agenda"><div class="row mt-5">';

    foreach ($res as $key => $val) {
      $html .= '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4  mb-5"><a class="thumbnail internal" href="agenda-and-minutes-year?id=' . $val['id'] . '">' . $val['category'] . ' </a></div>';
    }

    $html .= '</div></div></div></div></div><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p></div></div>	';

    return $html;
  }
  public function getAgendaAndMinutesYears()
  {
    $categoryID = $_GET['id']; // get category Id

    // category
    $select_array0 = array('category');
    $this->CI->db->where(array('id' => $categoryID));
    $this->CI->db->from('tbl_agenda_category_mst');
    $catDTL = $this->CI->db->get()->result_array();
    //echo '<pre>';print_r($catDTL);
    // category

    // years 
    $select_array = array('tbl_agenda_mst.id as mainid', 'tbl_agenda_category_year_mst.*');

    $condition = array('tbl_agenda_mst.category_id' => $categoryID, 'tbl_agenda_mst.status' => 'Enable', 'tbl_agenda_category_year_mst.status' => 'Enable');

    $this->CI->db->select($select_array);

    $this->CI->db->from('tbl_agenda_mst');

    $this->CI->db->join('tbl_agenda_category_year_mst', 'tbl_agenda_mst.year_id=tbl_agenda_category_year_mst.id');

    $this->CI->db->where($condition);
    $res = $this->CI->db->get()->result_array();
    // years 
    //echo '<pre>';print_r($res);
    $html = '<div class="clearfix"></div><div class="main-content"><div class="container"><div class=><div id="print_divv "><h5>' . $catDTL[0]['category'] . '</h5><hr /><div class=" agenda"><div class="row mt-5">';

    foreach ($res as $key => $val) {
      $html .= '<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2  mb-5"><a class="thumbnail internal" href="agenda-and-minutes-details?catid=' . $catDTL[0]['id'] . '&yearid=' . $val['id'] . '">' . $val['year'] . '</a></div>';
    }

    $html .= '</div></div></div></div></div><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p></div></div>	';

    return $html;
  }

  public function getAgendaAndMinutesDetails()
  {
    $categoryID = $_GET['catid']; // get category Id
    $yearID = $_GET['yearid']; // get Year Id

    // category
    $select_array0 = array('category');
    $this->CI->db->where(array('id' => $categoryID));
    $this->CI->db->from('tbl_agenda_category_mst');
    $catDTL = $this->CI->db->get()->result_array();
    //echo '<pre>';print_r($catDTL);
    // category
    // year
    $select_array1 = array('year');
    $this->CI->db->where(array('id' => $yearID));
    $this->CI->db->from('tbl_agenda_category_year_mst');
    $yearDTL = $this->CI->db->get()->result_array();
    //echo '<pre>';print_r($catDTL);
    // year

    $select_array = array('tbl_agenda_mst.id as mainid', 'tbl_agenda_mst.*', 'tbl_agenda_category_mst.*', 'tbl_agenda_category_year_mst.*');

    $condition = array('tbl_agenda_mst.category_id' => $categoryID, 'tbl_agenda_mst.year_id' => $yearID, 'tbl_agenda_mst.status' => 'Enable', 'tbl_agenda_category_mst.status' => 'Enable', 'tbl_agenda_category_year_mst.status' => 'Enable');

    $this->CI->db->select($select_array);

    $this->CI->db->from('tbl_agenda_mst');

    $this->CI->db->join('tbl_agenda_category_mst', 'tbl_agenda_mst.category_id=tbl_agenda_category_mst.id');

    $this->CI->db->join('tbl_agenda_category_year_mst', 'tbl_agenda_mst.year_id=tbl_agenda_category_year_mst.id');

    $this->CI->db->where($condition);
    $res = $this->CI->db->get()->result_array();
    //echo '<pre>';print_r($res);

    $html = '<div class="clearfix"></div>
        <div class="main-content">
        <div class="container">
            

           <div id="print_divv"><div class="page_gui">
        <h5>' . $catDTL[0]['category'] . ' Year - ' . $yearDTL[0]['year'] . '</h5>
        <hr /></div>';
    $html .= '<div class="main_sec">
                <div class="sec_1 " >
                <table class="table table-bordered">
                <tbody>
                <tr class="table-info">
                <td>Information</td>
                <td>Agenda Attachment</td>
                <td>Meeting Attachment</td>
                </tr>';
    foreach ($res as $key => $val) {
      $html .= '<tr>
                    <td>' . $val['text'] . '</td>
                    <td><a href="assets/cdma/agenda_and_minutes/' . $val['file'] . '" download><i class="fa fa-download"></i></a></td>
                    <td><a href="assets/cdma/agenda_and_minutes/' . $val['file1'] . '" download><i class="fa fa-download"></i></a></td>
                </tr>';
    }

    $html .= '</tbody>
                </table>
                </div></div></div></div></div></div>	
            	';

    return $html;
  }
  public function getKnowYourPropertyTaxDetails()
  {
    $html = ' <div class="">
        
        <div class="main-content">
        <div class="container">
          <div class="row">
          <div class="wrap">
               <div class="search">
                  <input type="text" name="code" class="searchTerm" placeholder="Enter your Property Code.">
                  <button type="submit" class="searchButton">
                    <i class="fa fa-search"></i>
                 </button>
               </div>
               
            </div>
            <div class="result result-table" style="overflow-x:auto;">
                
            </div>
           
          </div>
          <br><br><br><br><br><br><br><br><br><br>
       </div></div>	</div></div>	';
    return $html;
  }
  public function getVidoGallery()
  {
    $select_array = array('*');

    $this->CI->db->select($select_array);

    $videoDet = $this->CI->db->get('videos_mst')->result_array();


    $html = '<div><h3>Video Gallery</h3><br></div><br><div class="row">';

    foreach ($videoDet as $key => $val) {
      $html .= '<div class="col-md-3 al1" style="margin-bottom:20px;">
	 <iframe width="300" height="300" src=' . $val['thumbnail_url'] . ' frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> <br>
	 <div style="font-size:13px; padding:8px;">' . $val['videoTitel'] . '</div>
	 </div>';
    }

    $html .= '</div>';

    return $html;
  }


  public function getGallery($album_id)
  {

    $select_array = array('*');
    $condition = array('album_id' => $album_id);
    $this->CI->db->select($select_array);
    $this->CI->db->where($condition);
    $albumDet = $this->CI->db->get('album_image_map')->result_array();



    $html = '
        
        <style>
                
            .col_mr{
                margin-left:10px;
                margin-right:10px;
            }
                
        </style>
        

        <br><br> <div><h3>Photo Gallery</h3><br></div> <br> <div class="gallery-cnt">
        <div class="row"> ';

    foreach ($albumDet as $key => $val) {
      //echo "<pre>";  print_r($val);
      // $html.='

      // <div class="col-md-2 al1 col_mr" style="margin-bottom:20px; overflow: hidden; height: 200px; border:1px solid #ccc; padding: 0px;">

      //    <a data-fancybox="gallery" href='.$val['image_path'].' height="1300"><img src='.$val['image_path'].'></a>

      // </div>';
      $html .= '  <a href=' . $val['image_path'] . ' class="col-md-3" title="Test" style="margin-top:15px;">
        
                <div class="al1">
                <div class="al_inn">
                <img src=' . $val['image_path'] . ' width="200" height="200 !important">
                </div>
                
                <div style="padding:10px;">
                <div class="al_text"> ' . $val['title'] . '  </div>
               
                </div>
                
              
                
                </div>
                </a>';
    }

    $html .= '</div> <br><br>';

    $html .= '</div>';
    return $html;
  }
  public function getPetetionForm()
  {

    $condition = array('constutency_id' => 1);
    $db2 = $this->CI->load->database('database2', TRUE);

    $db2->select('*');
    $db2->where($condition);
    $q = $db2->get('mandal_mst');
    $mandals = $q->result_array();


    $html = '<form action="" method="post" enctype="multipart/form-data">
        
        <h3>Register Complaint</h3>
        <br><br>
        <div class="row">
	
			
		
			<div class="form-group col-md-3 dist_show">
				<label for="street">Mandal</label> <span class="red">*</span>
					<select name="mandal_id" id="mandal_id" class="form-control" onchange="getVillages(this.value)" required>
			  <option value="">-- select ---</option>';
    foreach ($mandals as $key => $val) {
      $html .= '<option value="' . $val['mandal_id'] . '">' . $val['mandal_desc'] . '</option>';
    }
    $html .= '</select>
				 
		      </div>
	 
			<div class="form-group col-md-3 dist_show">
				<label for="street"> Village </label> <span class="red">*</span>
				 
					<select class="dropdown form-control" name="village_id" id="village_id" required>
					<option value="">--Select Village / Ward--</option>
					</select>
				 
		      </div>
		
		
				<div class="form-group col-md-12">
		      
					<input type="checkbox" name="checkbox1" id="checkbox1" onclick="chkotherdistrict()"> Other District
			  
				 </div>
				 
				 
				 <div class="form-group col-md-12" id="autoUpdate" style="display:none;">  
				
					<textarea rows="3" class="form-control" name="other_district_remarks" id="other_district_remarks"> </textarea>
					 
		      </div>
				 
				 
				 <div class="form-group col-md-3">
					<label for="street"> Full name </label> <span class="red">*</span>
					<input class="form-control" name="fullname" id="fullname" type="text" value="" required>
				 
		      </div>
			  
			  <div class="form-group col-md-3">
				<label for="usr">Gender</label> <span class="red">*</span>
				<div style="padding-top:5px;">
					<input name="gender" type="radio" value="male" required>
					Male
					<input name="gender" type="radio" value="female">
				Female
				</div>
				 
			</div>
				 
				 
				 
			<div class="form-group col-md-3">
				<label for="street"> Father / Husband name </label>
				<input class="form-control" name="fhname" id="fhname" type="text" value="" >
				 
		      </div>
		      
		      <div class="form-group col-md-3">
				<label for="street"> Age </label> <span class="red">*</span>
				<input class="form-control" name="age" id="age" type="number" maxlength="2" value="" required>
				 
		      </div>


			<div class="form-group col-md-3">
				<label for="street"> Mobile no </label> <span class="red">*</span>
				 
				<input class="form-control" name="mobileno" id="mobileno" type="number" value="" maxlength="10" onkeypress="return isNumber(event)" required>
			 
		      </div>
			  
			  <div class="form-group col-md-3">
				<label for="street"> H.No </label> 
				<input class="form-control" name="Hno" id="Hno" type="text" value="" >				 
		      </div>
					
			

		

			<div class="form-group col-md-12">  
				<label for="street"> Address </label><span class="red">*</span>
				<textarea rows="3" class="form-control" name="address" id="address" required> </textarea>
				 
		      </div>
					
					
			
				
				
				<div class="form-group col-md-3">
				<label for="street">Street</label> 
				<input class="form-control" name="street" id="street" type="text" value=""> 
				 
				</div>
				
				
		
				<div class="form-group col-md-12">  
				<label for="street">  Subject </label><span class="red">*</span>
				<input type="text"  class="form-control" name="subject" id="subject" required> 
				 
		      </div>
		      
		      <div class="form-group col-md-12">  
				<label for="street"> Details </label><span class="red">*</span>
				<textarea rows="3" class="form-control" name="details" id="details" required> </textarea>
				 
		      </div>
			  
			  
			  <div class="form-group col-md-3">
				<label for="allottedTO"> Upload</label> 
				
				<input class="form-control" name="userfile" type="file" id="file0" onchange="ValidateSize(this.id)" accept="image/jpeg,image/gif,image/png,application/pdf">
				<input type="hidden" id="photoid" value="3">
		</div>
		
		<div class="form-group col-md-12">
		<br><br>
		<center>
		<input type="submit" name="save_petetion" class="btn btn-success" value="Submit">
		</center>
		<br><br><br><br>
		</div>
			
	</div>';
    return $html;
  }

  public function getBloodDonationForm()
  {
    $condition = array('constutency_id' => 1);
    $db2 = $this->CI->load->database('database2', TRUE);

    $db2->select('*');
    $db2->where($condition);
    $q = $db2->get('mandal_mst');
    $mandals = $q->result_array();

    $html = '<form action="" method="post">
        <h3>Blood Donor Registration</h3>
        <br><br>
        <div class="row">
	        
	        
		<div class="col-md-3">
			<div class="form-group">
			  <label  >Donor Name: <span class="red">*</span></label>
			  <input type="text" class="form-control" id="usr" name="doonar_name" required>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="form-group">
			  <label >Gender: <span class="red">*</span></label>
			 <select class="form-control" name="gender" required>
				<option value="">-Select-</option>
				<option value="Male">Male</option>
				<option value="Female">Female</option>
			 </select>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="form-group">
			  <label  >Age: <span class="red">*</span></label>
			 <select class="form-control" name="age" required>
				<option value="">-Select-</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="55">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				  
			 </select>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="form-group">
			  <label  >Blood Group: <span class="red">*</span></label>
			 <select class="form-control" name="bloodgroup" required>
				<option value="">-Select-</option>
				<option value="O+">O+</option>
				<option value="O-">O-</option>
				<option value="A+">A+</option>
				<option value="A-">A-</option>
				<option value="B+">B+</option>
				<option value="B-">B-</option>
				<option value="AB+">AB+</option>
				<option value="AB-">AB-</option>
				<option value="A1+">A1+</option>
				<option value="A1-">A1-</option>
				<option value="A2+">A2+</option>
				<option value="A2-">A2-</option>
				<option value="A1B+">A1B+</option>
				<option value="A1B-">A1B-</option>
				<option value="A2B+">A2B+</option>			 
				  
			 </select>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="form-group">
			  <label  >Mobile Number <span class="red">*</span></label>
			  <input type="number" maxlength="10" class="form-control" name="mobile" required>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="form-group">
			  <label >Email id :  </label>
			  <input type="email" class="form-control" name="email">
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="form-group">
			  <label >Alternate Mobile Number :  </label>
			  <input type="number" class="form-control" maxlength="10" name="mobile2">
			</div>
		</div>
		
		
		<div class="col-md-3">
			<div class="form-group">
			  <label >House number  </label>
			  <input type="text" class="form-control" name="hno">
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="form-group">
			  <label >Address <span class="red">*</span></label>
			   <textarea class="form-control" rows="3" name="address" required></textarea>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="form-group">
			  <label >Town/Mandal: <span class="red">*</span></label>
			  <select name="mandal_id" id="mandal_id" class="form-control" onchange="getVillages(this.value)" required>
			  <option value="">-- select ---</option>';
    foreach ($mandals as $key => $val) {
      $html .= '<option value="' . $val['mandal_id'] . '">' . $val['mandal_desc'] . '</option>';
    }
    $html .= '</select>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="form-group">
			  <label >Village/Ward: <span class="red">*</span></label>
			   <select name="village_id" id="village_id" class="form-control" required>
			  <option value="">-- select ---</option>
			 
			  </select>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="form-group">
			  <label >Pin code :<span class="red">*</span></label>
			  <input type="text" class="form-control" name="pincode" required>
			</div>
		</div>
		
		<div class="col-md-12">
		<br><br>
		<center>
		<input type="submit" class="btn btn-success" value="Submit" name="save_bloo_donations">
		</center>
		</div>
		<br><br><br><br><br><br>
		</form>
		
		 
	</div>
        
        ';


    return $html;
  }
  public function getAlbumName($album_id)
  {
    $select_array = array('*');
    $condition = array('album_id' => $album_id);
    $this->CI->db->select($select_array);
    $this->CI->db->where($condition);
    $albumname = $this->CI->db->get('album_mst')->result_array();
    return $albumname;
  }

  public function getAlbumPhotos($album_id)
  {
    $select_array = array('*');
    $condition = array('album_id' => $album_id);
    $this->CI->db->select($select_array);
    $this->CI->db->where($condition);
    $photos = $this->CI->db->get('album_image_map')->result_array();

    $content .= "<div>";
    foreach ($photos as $key => $val) {


      $content .= "<div class='col-md-3'>";
      $content .= "<div class='ph_pic_it'>";
      $content .= "<a data-fancybox='gallery' href='" . base_url() . $val['image_path'] . "'><img src='" . base_url() . $val['image_path'] . "' class='img-responsive' alt='" . $val['alttext'] . "'> </a>";
      $content .= "</div>";
      $content .= "</div>";
    }
    $content .= "</div>";
    return $content;
  }

  public function getComplaintDetails()
  {
    $select_array = array('*');
    $condition = array('status' => 'Enable');
    $this->CI->db->select($select_array);
    $this->CI->db->where($condition);
    $AllCategory = $this->CI->db->get('tbl_agenda_category_mst')->result_array();
    //print_r($AllCategory);exit;
    $result = ' <div class="container mt-5 mb-5">
                       <div class="row ">
                       
       
        
                       <div class="col-md-3"></div>
                       <div class="col-md-6">';

    if (!empty($this->CI->session->flashdata('success'))) {
      $result .= '<div class="alert alert-success alert-dismissible" id="success-alert">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong> </strong> ' . $this->CI->session->flashdata('success') . '
                                    </div>';
    }

    if (!empty($this->CI->session->flashdata('Error'))) {
      $result .= '<div class="alert alert-danger alert-dismissible" id="success-alert">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong> </strong> ' . $this->CI->session->flashdata('Error') . '
                                    </div>';
    }

    $result .= '<h4 class="text-center"> <b>Complaint Form</b> </h4>
                      <form action="' . base_url() . 'complaint-submit' . '" method="post" name="complaint" autocomplete="off" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="email"><b>Select Scheme: </b></label>
                          <select class="form-control" name="category" id="category" required>
                                <option value="">--Select Scheme--</option>';
    foreach ($AllCategory as $rowval) {
      $result .= '<option value="' . $rowval['id'] . '">' . $rowval['category'] . '</option>';
    }
    $result .= '</select>
                        </div>
                        <div class="form-group">
                          <label for="email"><b>Select Sub Category: </b></label>
                          <select class="form-control" name="subcategory" id="subcategory">
                                <option value="">--Select--</option>
                            </select>
                        </div>
                        <div class="form-group">
                          <label for="pwd"><b>Name:*</b></label>
                          <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" autocomplete="off">
                        </div>
                        <div class="form-group">
                          <label for="pwd"><b>Mobile:*</b></label>
                          <input type="text" class="form-control" id="mobile" placeholder="Enter Mobile Number" name="mobile" autocomplete="off">
                        </div>
                        <div class="form-group">
                          <label for="pwd"><b>Email Address:*</b></label>
                          <input type="text" class="form-control" id="email_address" placeholder="Enter Address" name="email_address" autocomplete="off">
                        </div>
                        <div class="form-group">
                          <label for="pwd"><b>Complaint Details:*</b></label>
                          <textarea name="details" id="details" rows="3" style="width:100%;border: 1px solid #ced4da; border-radius:3px;" autocomplete="off"></textarea>
                        </div>
                        <!--<div class="form-group">
                          <label for="pwd"><b>Attachment File :</b></label>
                          <input type="file" class="form-control" id="attachment" placeholder="Enter password" name="userfile[]" multiple style="padding: 3px; ">
                        </div>-->
                        
                       <div class="g-recaptcha" data-sitekey="' . $this->CI->config->item('google_key') . '"></div> 
                        <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
                        <hr>
                        
                        <div>
                          <span id="gc-error" style="color:red"></span>
                        </div>
                         <br>
                        <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                      </form>
                    </div>
                    </div>
                    <br>';
    return $result;
  }

  public function getMonthlyDetails()
  {
    $select_array = array('*');
    $condition = array('cat' => 1, 'status' => 'Enable');
    $this->CI->db->select($select_array);
    $this->CI->db->where($condition);
    $AllCategory = $this->CI->db->get('tbl_reports_category')->result();
    //print_r($AllCategory);exit;
    $result = ' 
                <div class="container">
                  <div class="row">';
    foreach ($AllCategory as $val) {
      if ($val->open == 1) {
        $target = "";
      } else {
        $target = "_blank";
      }
      $result .= '<div class="col-sm-4">
                      <h3 class="text-center">' . $val->title . '</h3>
                      <a href="report-details/' . $val->id . '" target="' . $target . '"><img src="assets/reports/' . $val->img . '" alt="report"></a>
                    </div>';
    }
    $result .= '</div>
                </div>';
    return $result;
  }
  public function getQuarterlyDetails()
  {
    $select_array = array('*');
    $condition = array('cat' => 2, 'status' => 'Enable');
    $this->CI->db->select($select_array);
    $this->CI->db->where($condition);
    $AllCategory = $this->CI->db->get('tbl_reports_category')->result();
    //print_r($AllCategory);exit;
    $result = ' 
                <div class="container">
                  <div class="row">';
    foreach ($AllCategory as $val) {
      if ($val->open == 1) {
        $target = "";
      } else {
        $target = "_blank";
      }
      $result .= '<div class="col-sm-4">
                      <h3 class="text-center">' . $val->title . '</h3>
                      <a href="report-details/' . $val->id . '" target="' . $target . '"><img src="assets/reports/' . $val->img . '" alt="report"></a>
                    </div>';
    }
    $result .= '</div>
                </div>';
    return $result;
  }
  public function getAnnualDetails()
  {
    $select_array = array('*');
    $condition = array('cat' => 3, 'status' => 'Enable');
    $this->CI->db->select($select_array);
    $this->CI->db->where($condition);
    $AllCategory = $this->CI->db->get('tbl_reports_category')->result();
    //print_r($AllCategory);exit;
    $result = ' 
                <div class="container">
                  <div class="row">';
    foreach ($AllCategory as $val) {
      if ($val->open == 1) {
        $target = "";
      } else {
        $target = "_blank";
      }
      $result .= '<div class="col-sm-4">
                      <h3 class="text-center">' . $val->title . '</h3>
                      <a href="report-details/' . $val->id . '" target="' . $target . '"><img src="assets/reports/' . $val->img . '" alt="report"></a>
                    </div>';
    }
    $result .= '</div>
                </div>';
    return $result;
  }
  public function getAlbums($ulbid, $lang_id)
  {
    $select_array = array('a.album_id', 'album_desc', 'a.ts', 'COUNT(aim.album_id) as photos', 'image_path', 'aim.alttext');
    $condition = array('a.ulbid' => $ulbid, 'a.langId' => $lang_id);
    $this->CI->db->select($select_array);
    $this->CI->db->from('album_mst a');
    $this->CI->db->join('album_image_map aim', 'a.album_id=aim.album_id');
    $this->CI->db->where($condition);
    $this->CI->db->group_by('aim.album_id');
    $this->CI->db->group_by('a.ts', 'DESC');
    $albums = $this->CI->db->get();
    //echo "<pre>"; print_r($albums->result_array()); exit;
    //$result=$this->CI->db->last_query();
    $content = "";




    $content .= '<br><div><h3>Photo Gallery</h3><br></div>   <div class="row">';

    foreach ($albums->result_array() as $key => $val) {

      $content .= '
       
        
        
        
        <a href=' . base_url() . '/gallery?q=' . $val['album_id'] . ' class="col-md-3" title=' . $val['album_desc'] . ' style="margin-top:15px;">
        
        <div class="al1">
        <div class="al_inn">
        <img src="' . $val['image_path'] . '" width="200" height="200">
        </div>
        
        <div style="padding:10px;">
        <div class="al_text"> ' . $val['album_desc'] . ' </div>
        <div class="al_small">Name of Program</div>
        </div>
       <hr style="margin:0px;">
         <div style="padding: 10px;">
        	<div class="al_small" ><i class="fa fa-image"></i> ' . $val['photos'] . ' Photos</div>
        </div>
        
        </div>
        </a>';
    }
    $content .= '</div>';
    return $content;

    // $content.="<figure class='snip1514'>";
    //  $content.="<img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/sample86.jpg' alt='sample86' />";
    //  $content.="<a href='#'></a>";
    // $content.="</figure>";

    foreach ($albums->result_array() as $key => $albmudet) {


      $content .= "<div class='col-md-3 alb_link show-bg'>";
      $content .= "<a href='" . base_url() . $ulbid . "/album/photos/" . $albmudet['album_id'] . "'>";
      $content .= "<div class='ph_alb_mn'>";
      $content .= "<img src='" . base_url() . $albmudet['image_path'] . "' class='img-responsive' alt='" . $albmudet['alttext'] . "' title='" . $albmudet['title'] . "'>";
      //  	$content.="<figure class=''>";
      //      $content.="<img src='".base_url().$albmudet['image_path']."' alt='sample86' />";
      //      $content.="<a href='#'></a>";
      //       $content.="</figure>";		

      $content .= "<div class='ph_alb_tit'><i class='fa fa-folder' style='color:#99e1e5;'></i> " . $albmudet['album_desc'] . "</div>";
      $content .= "<div class='ph_alb_tit'><i class='fa fa-calendar' style='color:#99e1e5;'></i><span style='color:#bbbbbb;'> Created :</span> " . date('d-m-Y H:i:s', strtotime($albmudet['ts'])) . " </div>";
      $content .= "<div class='ph_alb_tit'><i class='fa fa-image' style='color:#99e1e5;'></i> " . $albmudet['photos'] . " photos</div>";
      $content .= "</div>";
      $content .= "</a>";
      $content .= "</div>";
    }
    return $content;
  }
  public function getPublicNotice($lang_id)
  {

    $condition = array('is_custumlink' => '3');
    $this->CI->db->where($condition);
    $this->CI->db->from('custom_menus');
    // echo "<pre>";
    // print_r($this->CI->db->last_query());
    // exit;
    $catresult = $this->CI->db->get()->result_array();

    foreach ($catresult as $key => $val) {

      $catdesc[$val['page_id']] = $val['page_title'];
    }



    $select_array = array('custom_menus.content', 'category_id', 'page_title', 'post_category_map.page_id', 'departments_data.image_path', 'departments_data.date', 'departments_data.sliderLinkText');
    $condition = array('langId' => $lang_id);
    $this->CI->db->select($select_array);
    $this->CI->db->where($condition);
    $this->CI->db->where_in('user_type', array('A', 'D'));
    $this->CI->db->from('post_category_map');
    $this->CI->db->join('custom_menus', 'post_category_map.page_id=custom_menus.page_id');
    $this->CI->db->join('departments_data', 'custom_menus.page_id=departments_data.page_id');
    // $this->CI->db->join('departments_mst','custom_menus.dep_id=departments_mst.id');
    $this->CI->db->order_by('departments_data.last_updated', 'DESC');
    $result = $this->CI->db->get()->result_array();
    // echo $this->CI->db->last_query(); exit;


    foreach ($result as $key => $val) {
      $categories[$val['category_id']] = $val['category_id'];
      $data[$val['category_id']][$val['page_id']]['page_id'] = $val['page_id'];
      $data[$val['category_id']][$val['page_id']]['page_title'] = $val['page_title'];
      $data[$val['category_id']][$val['page_id']]['image_path'] = $val['image_path'];
      $data[$val['category_id']][$val['page_id']]['date'] = $val['date'];
      $data[$val['category_id']][$val['page_id']]['sliderLinkText'] = $val['sliderLinkText'];
      $data[$val['category_id']][$val['page_id']]['content'] = $val['content'];
    }



    /* $select_array=array('a.album_id','album_desc','a.ts','COUNT(aim.album_id) as photos','image_path','aim.alttext');
    $condition=array('a.ulbid'=>$ulbid,'a.langId'=>$lang_id);
    $this->CI->db->select($select_array);
    $this->CI->db->from('cu');
    $this->CI->db->join('album_image_map aim','a.album_id=aim.album_id');
    $this->CI->db->where($condition);
    $this->CI->db->group_by('aim.album_id');
    $this->CI->db->group_by('a.ts','DESC');
    $albums=$this->CI->db->get();
    //echo "<pre>"; print_r($albums->result_array()); exit;
    //$result=$this->CI->db->last_query();*/
    $content = "<p></p>";
    foreach ($categories as $key => $val) {

      $content .= '<div class="table-responsive">
        <table class="table table-bordered" border="0" width="100%" cellspacing="1" cellpadding="2">
        <tbody>
          <tr class="mytable_colr">
          <td class="chead1" colspan="5" align="center"><strong>' . $catdesc[$val] . '</strong></td>
          </tr>
          <tr class="mytable_colr-gray">
            <td class="chead1" align="center" style="width:10%"><strong>Sr.No</strong></td>
            <td class="chead1" align="center" style="width:30%"><strong>Date</strong></td>
            <td class="chead1" align="center" style="width:50%"><strong>Description</strong></td>
            <td class="chead1" align="center" style="width:10%"><strong>Download File</strong></td>
          </tr>';
      $i = 1;
      foreach ($data[$val] as $key2 => $val2) {
        $content .= '<tr align="center" style="vertical-align: middle;">
            <!-- <td>' . $i . '</td>
            <td>' . $val2['date'] . '</td>-->
            <td>
              <p style="margin-bottom:0rem !important">' . $i . '</p>
            </td>
            <td>
              <p style="margin-bottom:0rem !important">' . $val2['date'] . '</p>
            </td>
            <td>
              <!-- <p>' . $val2['content'] . '</p>-->
              ' . $val2['content'] . '
            </td>
            <td>
              <p style="margin-bottom:0rem !important">
                <a title="Jahir Suchana" href="' . $val2['image_path'] . '" download>
                  <!--04-06-24 <i class="fa-solid fa-file-pdf fa-fade fa-2xl" style="color: #ff0303;"></i>-->
                  <i class="fa-solid fa-file-pdf fa-fade" style="color: #ff0303;line-height:0px !important;font-size: 2em;"></i>
                </a>
              </p>
            </td>
          </tr>';
        $i++;
      }

      $content .= '</tbody></table></div>';
    }
    return $content;
  }
  public function getWorkOrders($lang_id)
  {
    $condition = array('is_custumlink' => '3');
    $this->CI->db->where($condition);
    $this->CI->db->from('custom_menus');
    $catresult = $this->CI->db->get()->result_array();
    foreach ($catresult as $key => $val) {

      $catdesc[$val['page_id']] = $val['page_title'];
    }

    
    //print_r($catdesc);



    $select_array = array('AgencyName', 'custom_menus.content', 'category_id', 'page_title', 'post_category_map.page_id', 'work_oder_data.image_path', 'work_oder_data.date', 'work_oder_data.sliderLinkText');
    $condition = array('user_type' => 'D', 'langId' => $lang_id);
    $this->CI->db->select($select_array);
    $this->CI->db->where($condition);
    $this->CI->db->from('post_category_map');
    $this->CI->db->join('custom_menus', 'post_category_map.page_id=custom_menus.page_id');
    $this->CI->db->join('work_oder_data', 'custom_menus.page_id=work_oder_data.page_id');
    $this->CI->db->order_by('work_oder_data.last_updated', 'DESC');
    $result = $this->CI->db->get()->result_array();
    //echo $this->CI->db->last_query();

    //exit;


    foreach ($result as $key => $val) {
      $categories[$val['category_id']] = $val['category_id'];
      $data[$val['category_id']][$val['page_id']]['page_id'] = $val['page_id'];
      $data[$val['category_id']][$val['page_id']]['page_title'] = $val['page_title'];
      $data[$val['category_id']][$val['page_id']]['image_path'] = $val['image_path'];
      $data[$val['category_id']][$val['page_id']]['date'] = $val['date'];
      $data[$val['category_id']][$val['page_id']]['sliderLinkText'] = $val['sliderLinkText'];
      $data[$val['category_id']][$val['page_id']]['content'] = $val['content'];
      $data[$val['category_id']][$val['page_id']]['AgencyName'] = $val['AgencyName'];
    }

    // print_r($categories);
    //exit;


    /* $select_array=array('a.album_id','album_desc','a.ts','COUNT(aim.album_id) as photos','image_path','aim.alttext');
    $condition=array('a.ulbid'=>$ulbid,'a.langId'=>$lang_id);
    $this->CI->db->select($select_array);
    $this->CI->db->from('cu');
    $this->CI->db->join('album_image_map aim','a.album_id=aim.album_id');
    $this->CI->db->where($condition);
    $this->CI->db->group_by('aim.album_id');
    $this->CI->db->group_by('a.ts','DESC');
    $albums=$this->CI->db->get();
    //echo "<pre>"; print_r($albums->result_array()); exit;
    //$result=$this->CI->db->last_query();*/
    $content = "<p></p>";
    foreach ($categories as $key => $val) {

      $content .= '<div class="table-responsive">
        <table class="table table-bordered" border="0" width="100%" cellspacing="1" cellpadding="2">
        <tbody>
          <tr class="mytable_colr">
          <td class="chead1" colspan="5" align="center"><strong>' . $catdesc[$val] . '</strong></td>
          </tr>
            <tr class="mytable_colr-gray">
            <td class="chead1" align="center" style="width:5%" ><strong>Sr.No</strong></td>
            <td class="chead1" align="center" style="width:10%"><strong>Date</strong></td>
            <td class="chead1" align="center" style="width:20%"><strong>Agency name</strong></td>
            <td class="chead1" align="center" style="width:60%"><strong>Description</strong></td>
            <td class="chead1" align="center" style="width:5%"><strong>Download File</strong></td>
          </tr>';
      $i = 1;
      foreach ($data[$val] as $key2 => $val2) {
        $content .= '<tr align="center" style="vertical-align: middle;">
            <!-- <td>' . $i . '</td>
            <td>' . $val2['date'] . '</td>
            <td>' . $val2['AgencyName'] . '</td>-->
            <td>
              <p style="margin-bottom:0rem !important">' . $i . '</p>
            </td>
            <td>
              <p style="margin-bottom:0rem !important">' . $val2['date'] . '</p>
            </td>
            <td>
              <p style="margin-bottom:0rem !important">' . $val2['AgencyName'] . '</p>
            </td>
            <td>
              <!-- <p style="margin:0px;">' . $val2['content'] . '</p>-->
              ' . $val2['content'] . '
            </td>
            <td>
              <p>
                <a title="Jahir Suchana" href="' . $val2['image_path'] . '" download>
                  <!--04-06-24 <i class="fa-solid fa-file-pdf fa-fade fa-2xl" style="color: #ff0303;"></i>-->
                  <i class="fa-solid fa-file-pdf fa-fade" style="color: #ff0303;line-height:0px !important;font-size: 2em;"></i>
                </a>
              </p>
            </td>
          </tr>';
        $i++;
      }
      $content .= '</tbody></table></div>';
    }
    return $content;
  }

  public function getquotations($lang_id)
  {
    $condition = array('is_custumlink' => '3');
    $this->CI->db->where($condition);
    $this->CI->db->from('custom_menus');
    $catresult = $this->CI->db->get()->result_array();
    foreach ($catresult as $key => $val) {

      $catdesc[$val['page_id']] = $val['page_title'];
    }



    $select_array = array('nameval', 'custom_menus.content','custom_menus.meta_desc', 'category_id', 'page_title', 'post_category_map.page_id', 'quotations_data.image_path', 'quotations_data.date', 'quotations_data.sliderLinkText');
    $condition = array('user_type' => 'D', 'langId' => $lang_id);
    $this->CI->db->select($select_array);
    $this->CI->db->where($condition);
    $this->CI->db->from('post_category_map');
    $this->CI->db->join('custom_menus', 'post_category_map.page_id=custom_menus.page_id');
    $this->CI->db->join('quotations_data', 'custom_menus.page_id=quotations_data.page_id');
    $this->CI->db->order_by('quotations_data.last_updated', 'DESC');
    $result = $this->CI->db->get()->result_array();
    //echo $this->CI->db->last_query();

    //exit;

//echo "<pre>";print_r($result);echo "</pre>";die();	


    foreach ($result as $key => $val) {
      $categories[$val['category_id']] = $val['category_id'];
      $data[$val['category_id']][$val['page_id']]['page_id'] = $val['page_id'];
      $data[$val['category_id']][$val['page_id']]['page_title'] = $val['page_title'];
      $data[$val['category_id']][$val['page_id']]['image_path'] = $val['image_path'];
      $data[$val['category_id']][$val['page_id']]['date'] = $val['date'];
      $data[$val['category_id']][$val['page_id']]['sliderLinkText'] = $val['sliderLinkText'];
      $data[$val['category_id']][$val['page_id']]['content'] = $val['content'];
      $data[$val['category_id']][$val['page_id']]['meta_desc'] = $val['meta_desc'];
      $data[$val['category_id']][$val['page_id']]['nameval'] = $val['nameval'];
    }




    /* $select_array=array('a.album_id','album_desc','a.ts','COUNT(aim.album_id) as photos','image_path','aim.alttext');
    $condition=array('a.ulbid'=>$ulbid,'a.langId'=>$lang_id);
    $this->CI->db->select($select_array);
    $this->CI->db->from('cu');
    $this->CI->db->join('album_image_map aim','a.album_id=aim.album_id');
    $this->CI->db->where($condition);
    $this->CI->db->group_by('aim.album_id');
    $this->CI->db->group_by('a.ts','DESC');
    $albums=$this->CI->db->get();
    //echo "<pre>"; print_r($albums->result_array()); exit;
    //$result=$this->CI->db->last_query();*/
    $content = "<p></p>";
    foreach ($categories as $key => $val) {
      $content .= '<div class="table-responsive">
        <table class="table table-bordered" border="0" width="100%" cellspacing="1" cellpadding="2">
        <tbody>
          <tr class="mytable_colr">
            <td class="chead1" colspan="5" align="center"><strong>' . $catdesc[$val] . '</strong></td>
          </tr>
          <tr class="mytable_colr-gray">
            <td class="chead1" align="center" style="width:5%"><strong>SNo</strong></td>
            <td class="chead1" align="center" style="width:10%"><strong>Date</strong></td>
            <td class="chead1" align="center" style="width:45%"><strong>Name</strong></td>
            <td class="chead1" align="center" style="width:30%"><strong>Description</strong></td>
            <td class="chead1" align="center" style="width:10%"><strong>Download File</strong></td> 
          </tr>';
      $i = 1;
      foreach ($data[$val] as $key2 => $val2) {
        $content .= '<tr  align="center" style="vertical-align: middle;">
              <!--<td>' . $i . '</td>
              <td>' . $val2['date'] . '</td>
              <td>' . $val2['nameval'] . '</td>-->
              <td>
                <p style="margin-bottom:0rem !important">' . $i . '</p>
              </td>
              <td>
                <p style="margin-bottom:0rem !important">' . $val2['date'] . '</p>
              </td>
              <td>
                <p style="margin-bottom:0rem !important">' . $val2['nameval'] . '</p>
              </td>
              <td>
                <!--<p>' . $val2['content'] . '</p>-->
                ' . $val2['meta_desc'] . '
              </td>
              <td>
                <p>
                  <a title="" href="' . $val2['image_path'] . '" download>
                    <!--04-06-24 <i class="fa-solid fa-file-pdf fa-fade fa-2xl" style="color: #ff0303;"></i>-->
                    <i class="fa-solid fa-file-pdf fa-fade" style="color: #ff0303;line-height:0px !important;font-size: 2em;"></i>
                  </a>
                </p>
              </td>
            </tr>';
        $i++;
      }
      $content .= '</tbody></table></div>';
    }
    return $content;
  }

  public function getFaq($lang_id)
  {
    $condition = array('is_custumlink' => '3');
    $this->CI->db->where($condition);
    $this->CI->db->from('custom_menus');
    $catresult = $this->CI->db->get()->result_array();
    foreach ($catresult as $key => $val) {

      $catdesc[$val['page_id']] = $val['page_title'];
    }



    $select_array = array('ans_image', 'custom_menus.content', 'category_id', 'page_title', 'post_category_map.page_id', 'faq.image_path', 'faq.date', 'faq.sliderLinkText');
    $condition = array('user_type' => 'D', 'langId' => $lang_id);
    $this->CI->db->select($select_array);
    $this->CI->db->where($condition);
    $this->CI->db->from('post_category_map');
    $this->CI->db->join('custom_menus', 'post_category_map.page_id=custom_menus.page_id');
    $this->CI->db->join('faq', 'custom_menus.page_id=faq.page_id');
    $this->CI->db->order_by('faq.last_updated', 'DESC');
    $result = $this->CI->db->get()->result_array();
    //echo $this->CI->db->last_query();

    //exit;


    foreach ($result as $key => $val) {
      $categories[$val['category_id']] = $val['category_id'];
      $data[$val['category_id']][$val['page_id']]['page_id'] = $val['page_id'];
      $data[$val['category_id']][$val['page_id']]['page_title'] = $val['page_title'];
      $data[$val['category_id']][$val['page_id']]['image_path'] = $val['image_path'];
      $data[$val['category_id']][$val['page_id']]['date'] = $val['date'];
      $data[$val['category_id']][$val['page_id']]['sliderLinkText'] = $val['sliderLinkText'];
      $data[$val['category_id']][$val['page_id']]['content'] = $val['content'];
      $data[$val['category_id']][$val['page_id']]['ans_image'] = $val['ans_image'];
    }




    /* $select_array=array('a.album_id','album_desc','a.ts','COUNT(aim.album_id) as photos','image_path','aim.alttext');
    $condition=array('a.ulbid'=>$ulbid,'a.langId'=>$lang_id);
    $this->CI->db->select($select_array);
    $this->CI->db->from('cu');
    $this->CI->db->join('album_image_map aim','a.album_id=aim.album_id');
    $this->CI->db->where($condition);
    $this->CI->db->group_by('aim.album_id');
    $this->CI->db->group_by('a.ts','DESC');
    $albums=$this->CI->db->get();
    //echo "<pre>"; print_r($albums->result_array()); exit;
    //$result=$this->CI->db->last_query();*/
    $content = "<p></p>";
    foreach ($categories as $key => $val) {

      $content .= '<div class="table-responsive">
        <table class="table table-bordered" border="0" width="100%" cellspacing="1" cellpadding="2">
        <tbody>
          <tr class="mytable_colr">
          <td class="chead1" colspan="5" align="center"><strong>' . $catdesc[$val] . '</strong></td>
          </tr>
          <tr class="mytable_colr-gray">
          <td class="chead1" align="center" style="width:10%"><strong>Sr.No</strong></td>
          <td class="chead1" align="center" style="width:15%"><strong>Date</strong></td>
          <td class="chead1" align="center" style="width:25%"><strong>Description</strong></td>
          <td class="chead1" align="center" style="width:25%"><strong>Question</strong></td>
          <td class="chead1" align="center" style="width:25%"><strong>Answer</strong></td>

          </tr>';
      $i = 1;
      foreach ($data[$val] as $key2 => $val2) {
        $content .= '<tr align="center" style="vertical-align: middle;">
            <td>' . $i . '</td>
            <td>' . $val2['date'] . '</td>
            <td>
              <p>' . $val2['content'] . '</p>
            </td>
            <td>
              <!--04-06-24 <p><a title="" href="' . $val2['image_path'] . '" download>Download Question</a></p>-->
              <p>
                <a title="" href="' . $val2['image_path'] . '" download>
                  <i class="fa-solid fa-file-pdf fa-fade" style="color: #ff0303;line-height:0px !important;font-size: 2em;"></i>
                </a>
              </p>
            </td>
            <td>
              <!--04-06-24 <p><a title="" href="' . $val2['ans_image'] . '" download>Download Answer</a></p>-->
              <p>
                <a title="" href="' . $val2['ans_image'] . '" download>
                  <i class="fa-solid fa-file-pdf fa-fade" style="color: #ff0303;line-height:0px !important;font-size: 2em;"></i>
                </a>
              </p>
            </td>
          </tr>';
        $i++;
      }
      $content .= '</tbody></table><div>';
    }
    return $content;
  }

  public function getFeedbackform($ulbid)
  {

    /*$vals = array(
      //'word'          => 'Random',
      'img_path'      => "assets/cdma/captcha/",
      'img_url'       => base_url() . "assets/cdma/captcha/",
      'font_path'     => 'system/fonts/texb.ttf',
      'img_width'     => '150',
      'img_height'    => 30,
      'expiration'    => 7200,
      'word_length'   => 6,
      'font_size'     => 16,
      'img_id'        => 'Imageid',
      'pool'          => '123456789',

      // White background and border, black text and red grid
      'colors'        => array(
        // 'background' => array(230, 230, 230),
        'border' => array(255, 255, 255),
        'text' => array(0, 0, 0),
        //'grid' => array(255, 40, 40)
      )
    );


    $captch = create_captcha($vals);*/





    $a = mt_rand(1000, 9999);
    //$a = chr(64+rand(0,26)).''.rand(1000,2600).''.chr(64+rand(0,26));

    $base_url = base_url();
    $aa = base_url(uri_string());

    $image_path = base_url() . "assets/cdma/captcha/captcha3.png";
    $content = $this->CI->session->flashdata('message');


    $content .= '<h3></h3>
      
      <p> Any query, of generic nature, related to content, design, service or technological issues with regard to this portal can be sent to us through this customized Feedback interface. </p>
      
      <p> All fields are mandatory, except where marked &apos;optional&apos;   </p>

      
      
      <form method="POST" onsubmit="return validateForm()" action="' . $base_url . 'CustomePageController/add_feedback">
        <div class="form-horizontal">
          <input type="hidden" name="ulbid" value="' . $ulbid . '"/> 
          <input type="hidden" name="currenturl" value="' . $aa . '"/> 
 
          <div class="form-group">
            <label class="col-md-3 control-label" for="selectbasic">Feedback for <span class="form_star">*</span></label>
            <div class="col-md-4">
              <input type="radio" name="feedback_for" value="1" required="required"> Web related suggestion <br>
              <input type="radio" name="feedback_for" value="2" required="required"> RTI Related <br>
              <input type="radio" name="feedback_for" value="3" required="required"> Content on Website <br>
              <input type="radio" name="feedback_for" value="4" required="required"> Others <br>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="textinput">Your Name <span class="form_star">*</span></label>  
            <div class="col-md-4">
              <input id="" name="name" placeholder="Enter Your Name" class="form-control input-md" type="text" required="required">  
            </div>		
          </div>
	
          <div class="form-group">
            <label class="col-md-3 control-label" for="textinput">Mobile Number <span class="form_star">*</span></label>   
            <div class="col-md-4">
              <input placeholder="Enter Valid Mobile no" class="form-control input-md" type="text" name="mobile" required="required" pattern="[789][0-9]{9}">  
            </div>		
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="textinput">Email Id <span class="form_star">*</span></label>  
            <div class="col-md-4">
              <input placeholder="Enter Mail Id" class="form-control input-md" type="email" name="emailid" required="required">
            </div>		
          </div>
	
          <div class="form-group">
            <label class="col-md-3 control-label" for="textinput">Address <span class="form_star">*</span> </label>  
            <div class="col-md-4">
              <textarea class="form-control" rows="5" id="textarea" placeholder="Enter complete address" name="address" required="required"></textarea>
            </div>		
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="textinput">Comment <span class="form_star">*</span> </label>  
            <div class="col-md-4">
              <textarea class="form-control" rows="5" id="textarea" placeholder="Enter comment" name="comment" required="required"></textarea>
            </div>		
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="textinput">Captcha</label>
            <div class="col-md-4">
            <div style="font-style:italic;font-weight: bold;font-size:17px; letter-spacing: 6px; border: 1px solid #ddd;width: 110px;text-align:center;color:red;margin-bottom:10px;background-image:url(';
    $content .= $image_path;
    $content .= '); font-family: "Stinky", Helvetica, sans-serif;color: #1874c3;" id="cap">' . $a . '</div>
            <input type="button" class="btn btn-primary btn-sm" id="captcha_reload" value="Realod"/>
            </div>		
          </div>
          <input type="hidden" id="captc" value=' . $a . '>

          <div class="form-group">
            <label class="col-md-3 control-label" for="textinput">Enter Captcha <span class="form_star">*</span></label>  
            <div class="col-md-4">
              <input  class="form-control input-md captcha" type="text" name="captcha" id="cap1" placeholder="captcha">
            </div>		
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="textinput"></label>  
            <div class="col-md-4">
              <input type="submit" class="btn btn-success btn-sm" value="Submit" name="submit">
            </div>		
          </div>
	      </div> 
      </form>';
    return $content;
  }

  /*public function getSitemap($parameters)
  {
    //print_r($parameters);

    $condition = array('c.ulbid' => $parameters['ulbid'], 'c.langId' => $parameters['langId'], 's.menu_type_id' => $parameters['menu_type_id']);

    $select_array = array('s.page_id', 's.menu_id', 'c.page_name', 'c.controller', 'c.is_custumlink', 'c.is_target_blank', 'c.site_controller', 'c.is_alert');
    $this->CI->db->select($select_array);
    $this->CI->db->from('site_main_menu s');
    $this->CI->db->join('custom_menus c', 's.page_id=c.page_id');
    $this->CI->db->where($condition);
    $this->CI->db->order_by('menu_id', 'ASC');
    $result['main_menus'] = $this->CI->db->get()->result_array();

    //Sub menus

    $select_array = array('s.page_id', 's.main_menu_id', 's.sub_menu_id', 'c.page_name', 'c.controller', 'c.is_custumlink', 'c.is_target_blank', 'c.site_controller', 'c.is_alert');
    $this->CI->db->select($select_array);
    $this->CI->db->from('site_sub_menus s');
    $this->CI->db->join('custom_menus c', 's.page_id=c.page_id');
    $this->CI->db->where('c.ulbid', $parameters['ulbid']);
    $this->CI->db->order_by('sub_menu_id', 'ASC');
    $result['sub_menus'] = $this->CI->db->get()->result_array();

    // sub sub menus

    $select_array = array('s.page_id', 's.main_menu_id', 's.sub_menu_id', 's.sub_sub_menu_id', 'c.page_name', 'c.controller', 'c.is_custumlink', 'c.is_target_blank', 'c.site_controller', 'c.is_alert');
    $this->CI->db->select($select_array);
    $this->CI->db->from('site_sub_sub_menus s');
    $this->CI->db->join('custom_menus c', 's.page_id=c.page_id');
    $this->CI->db->where('c.ulbid', $parameters['ulbid']);
    $this->CI->db->order_by('sub_sub_menu_id', 'ASC');
    $result['sub_sub_menus'] = $this->CI->db->get()->result_array();

    // MENUS STOTING INTO ARRAYS

    $pages['mainmenu'] = array();
    $pages['submenu'] = array();
    $pages['chilemenu'] = array();

    foreach ($result['sub_menus'] as $key => $submenuarray) {
      $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['page_name'] = $submenuarray['page_name'];
      $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['controller'] = $submenuarray['controller'];
      $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_custumlink'] = $submenuarray['is_custumlink'];
      $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_target_blank'] = $submenuarray['is_target_blank'];
      $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['site_controller'] = $submenuarray['site_controller'];
      $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_alert'] = $submenuarray['is_alert'];
    }

    foreach ($result['sub_sub_menus'] as $key => $submenuarray) {
      $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['page_name'] = $submenuarray['page_name'];
      $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['controller'] = $submenuarray['controller'];
      $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_custumlink'] = $submenuarray['is_custumlink'];
      $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_target_blank'] = $submenuarray['is_target_blank'];
      $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['site_controller'] = $submenuarray['site_controller'];
      $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_alert'] = $submenuarray['is_alert'];
    }

    array_push($pages['chilemenu'], $data3);

    foreach ($result['main_menus'] as $key => $mainmenuarray) {
      $data1[$mainmenuarray['menu_id']]['page_name'] = $mainmenuarray['page_name'];
      $data1[$mainmenuarray['menu_id']]['controller'] = $mainmenuarray['controller'];
      $data1[$mainmenuarray['menu_id']]['is_custumlink'] = $mainmenuarray['is_custumlink'];
      $data1[$mainmenuarray['menu_id']]['is_target_blank'] = $mainmenuarray['is_target_blank'];
      $data1[$mainmenuarray['menu_id']]['site_controller'] = $mainmenuarray['site_controller'];
      $data1[$mainmenuarray['menu_id']]['is_alert'] = $mainmenuarray['is_alert'];
      $data1[$mainmenuarray['menu_id']]['child'] = array();
    }

    // print_r($data2);
    $content = "<div class='col-md-4'>";

    $content .= "<div id='test' class='tree'>";
    $content .= "<ul>";
    $content .= "<li class='parent_li'><span title='Home'>Home</span>";
    $content .= "<ul>";
    //return "get site map";

    foreach ($data1 as $menuid => $mainmenudetails) {
      $base_url = base_url();

      $content .= "<li class='parent_li'><span class='site_color' title='About Municipality'>" . $mainmenudetails['page_name'] . "</span>";

      $content .= "<ul>";

      foreach ($data2[$menuid] as $submenuid => $submenudetails) {

        $content .= "<li class='parent_li'><a href='" . $base_url . $submenudetails['site_controller'] . "' target='_blank'><span title='Basic Information of Municipality'>" . $submenudetails['page_name'] . "</span></a>";

        $content .= "<ul>";

        foreach ($data3[$menuid][$submenuid] as $subsubmenuid => $subsubmenudetails) {

          $content .= "<li class='parent_li'><a href='" . $base_url . $subsubmenudetails['site_controller'] . "' target='_blank'><span title='Last two years trade licenses'>" . $subsubmenudetails['page_name'] . "</span></a></li>";
        }

        $content .= "</ul>";
        $content .= "</li>";
      }
      $content .= "</ul>";
      $content .= "</li>";
    }

    $content .= "</ul>";
    $content .= "</li>";
    $content .= "</ul>";
    $content .= "</div>";
    $content .= "</div>";


    return $content;

    //return $content;

  }*/



  /*public function getMenus($params)
  {
    // Main menus 
    $condition = array('c.ulbid' => $params['ulbid'], 'c.langId' => $params['langId'], 's.menu_type_id' => $params['menu_type_id']);

    $select_array = array('s.page_id', 's.menu_id', 'c.page_name', 'c.controller', 'c.is_custumlink', 'c.is_target_blank', 'c.site_controller');
    $this->CI->db->select($select_array);
    $this->CI->db->from('site_main_menu s');
    $this->CI->db->join('custom_menus c', 's.page_id=c.page_id');
    $this->CI->db->where($condition);
    $this->CI->db->order_by('menu_id', 'ASC');
    $result['main_menus'] = $this->CI->db->get()->result_array();

    //echo $this->CI->db->last_query();

    //Sub menus

    $select_array = array('s.page_id', 's.main_menu_id', 's.sub_menu_id', 'c.page_name', 'c.controller', 'c.is_custumlink', 'c.is_target_blank', 'c.site_controller');
    $this->CI->db->select($select_array);
    $this->CI->db->from('site_sub_menus s');
    $this->CI->db->join('custom_menus c', 's.page_id=c.page_id');
    $this->CI->db->where('c.ulbid', $params['ulbid']);
    $this->CI->db->order_by('sub_menu_id', 'ASC');
    $result['sub_menus'] = $this->CI->db->get()->result_array();

    // sub sub menus

    $select_array = array('s.page_id', 's.main_menu_id', 's.sub_menu_id', 's.sub_sub_menu_id', 'c.page_name', 'c.controller', 'c.is_custumlink', 'c.is_target_blank', 'c.site_controller');
    $this->CI->db->select($select_array);
    $this->CI->db->from('site_sub_sub_menus s');
    $this->CI->db->join('custom_menus c', 's.page_id=c.page_id');
    $this->CI->db->where('c.ulbid', $params['ulbid']);
    $this->CI->db->order_by('sub_menu_id', 'ASC');
    $result['sub_sub_menus'] = $this->CI->db->get()->result_array();

    // MENUS STOTING INTO ARRAYS

    $pages['mainmenu'] = array();
    $pages['submenu'] = array();
    $pages['chilemenu'] = array();

    foreach ($result['sub_menus'] as $key => $submenuarray) {
      $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['page_name'] = $submenuarray['page_name'];
      $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['controller'] = $submenuarray['controller'];
      $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_custumlink'] = $submenuarray['is_custumlink'];
      $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_target_blank'] = $submenuarray['is_target_blank'];
      $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['site_controller'] = $submenuarray['site_controller'];
    }

    array_push($pages['submenu'], $data2);

    foreach ($result['sub_sub_menus'] as $key => $submenuarray) {
      $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['page_name'] = $submenuarray['page_name'];
      $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['controller'] = $submenuarray['controller'];
      $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_custumlink'] = $submenuarray['is_custumlink'];
      $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_target_blank'] = $submenuarray['is_target_blank'];
      $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['site_controller'] = $submenuarray['site_controller'];
    }

    array_push($pages['chilemenu'], $data3);

    foreach ($result['main_menus'] as $key => $mainmenuarray) {
      $data1[$mainmenuarray['menu_id']]['page_name'] = $mainmenuarray['page_name'];
      $data1[$mainmenuarray['menu_id']]['controller'] = $mainmenuarray['controller'];
      $data1[$mainmenuarray['menu_id']]['is_custumlink'] = $mainmenuarray['is_custumlink'];
      $data1[$mainmenuarray['menu_id']]['is_target_blank'] = $mainmenuarray['is_target_blank'];
      $data1[$mainmenuarray['menu_id']]['site_controller'] = $mainmenuarray['site_controller'];
      $data1[$mainmenuarray['menu_id']]['child'] = array();
    }

    array_push($pages['mainmenu'], $data1);
    return $pages;
  }*/


  public function getSitemap($parameters)
  {
    //print_r($parameters);

    $condition1 = array('ulbid' => $parameters['ulbid'], 'flag' => 1);
    $this->CI->db->select('*');
    $this->CI->db->from('menu_type_mst');
    $this->CI->db->where($condition1);
    $result['menu_type'] = $this->CI->db->get()->result_array();

    $content = "<div class='container'>";
    $content .= "<div class='row'>";

    foreach ($result['menu_type'] as $key => $val_menu) {
      $data1 = array();
      //print_r($result['menu_type']);


      /* Main Site Menu*/

      $condition = array('c.ulbid' => $parameters['ulbid'], 'c.langId' => $parameters['langId'], 's.menu_type_id' => $val_menu['menu_type_id']);

      //print_r($condition);

      $select_array = array('s.page_id', 's.menu_id', 's.menu_type_id', 'c.page_name', 'c.controller', 'c.is_custumlink', 'c.is_target_blank', 'c.site_controller', 'c.is_alert', 'c.page_sidebars_id');
      $this->CI->db->select($select_array);
      $this->CI->db->from('site_main_menu s');
      $this->CI->db->join('custom_menus c', 's.page_id=c.page_id');
      $this->CI->db->where($condition);
      $this->CI->db->order_by('menu_id', 'ASC');
      //echo $this->CI->db->last_query();
      $result['main_menus'] = $this->CI->db->get()->result_array();




      //Sub menus

      $select_array = array('s.page_id', 's.main_menu_id', 's.sub_menu_id', 's.menu_type_id', 'c.page_name', 'c.controller', 'c.is_custumlink', 'c.is_target_blank', 'c.site_controller', 'c.is_alert', 'c.page_sidebars_id');
      $this->CI->db->select($select_array);
      $this->CI->db->from('site_sub_menus s');
      $this->CI->db->join('custom_menus c', 's.page_id=c.page_id');
      $this->CI->db->where('c.ulbid', $parameters['ulbid']);
      $this->CI->db->order_by('sub_menu_id', 'ASC');
      $result['sub_menus'] = $this->CI->db->get()->result_array();

      // sub sub menus

      $select_array = array('s.page_id', 's.main_menu_id', 's.sub_menu_id', 's.sub_sub_menu_id', 'c.page_name', 'c.controller', 'c.is_custumlink', 'c.is_target_blank', 'c.site_controller', 'c.is_alert', 'c.page_sidebars_id');
      $this->CI->db->select($select_array);
      $this->CI->db->from('site_sub_sub_menus s');
      $this->CI->db->join('custom_menus c', 's.page_id=c.page_id');
      $this->CI->db->where('c.ulbid', $parameters['ulbid']);
      $this->CI->db->order_by('sub_sub_menu_id', 'ASC');
      $result['sub_sub_menus'] = $this->CI->db->get()->result_array();




      // MENUS STOTING INTO ARRAYS

      $pages['mainmenu'] = array();
      $pages['submenu'] = array();
      $pages['chilemenu'] = array();

      foreach ($result['sub_menus'] as $key => $submenuarray) {



        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['page_name'] = $submenuarray['page_name'];
        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['controller'] = $submenuarray['controller'];
        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_custumlink'] = $submenuarray['is_custumlink'];
        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_target_blank'] = $submenuarray['is_target_blank'];
        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['site_controller'] = $submenuarray['site_controller'];
        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_alert'] = $submenuarray['is_alert'];
      }





      foreach ($result['sub_sub_menus'] as $key => $submenuarray) {



        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['page_name'] = $submenuarray['page_name'];
        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['controller'] = $submenuarray['controller'];
        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_custumlink'] = $submenuarray['is_custumlink'];
        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_target_blank'] = $submenuarray['is_target_blank'];
        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['site_controller'] = $submenuarray['site_controller'];
        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_alert'] = $submenuarray['is_alert'];
      }

      array_push($pages['chilemenu'], $data3);

      foreach ($result['main_menus'] as $key => $mainmenuarray) {



        $data1[$mainmenuarray['menu_id']]['page_name'] = $mainmenuarray['page_name'];
        $data1[$mainmenuarray['menu_id']]['controller'] = $mainmenuarray['controller'];
        $data1[$mainmenuarray['menu_id']]['is_custumlink'] = $mainmenuarray['is_custumlink'];
        $data1[$mainmenuarray['menu_id']]['is_target_blank'] = $mainmenuarray['is_target_blank'];
        $data1[$mainmenuarray['menu_id']]['site_controller'] = $mainmenuarray['site_controller'];
        $data1[$mainmenuarray['menu_id']]['is_alert'] = $mainmenuarray['is_alert'];
        $data1[$mainmenuarray['menu_id']]['child'] = array();
      }
      //print_r($data1);
      /* End Main Site Menu*/

      $base_url1 = base_url();


      $content .= "<div class='col-md-3'>";
      if ($val_menu['menu_type_id'] == '1') {

        $content .= "<div><a href='" . $base_url1 . $parameters['ulbid'] . "/home-page' target='_blank'><h6>Main Navigation</h6></a></div>";
      } else {
        $content .= "<div><h6>" . $val_menu['menu_type_sitemap_desc'] . "</h6></div>";
      }

      $content .= "<div id='test' class='tree'>";

      $content .= "<ul>";
      if ($val_menu['menu_type_id'] == '1') {

        $content .= "<li class='parent_li'><a href='" . $base_url1 . $parameters['ulbid'] . "/home-page' target='_blank'><span title='Home'>Main Navigation</span></a>";
      }

      $content .= "<ul>";



      foreach ($data1 as $menuid => $mainmenudetails) {

        if ($mainmenudetails['is_custumlink'] == 1) {
          $base_url = '';
        } else {
          $base_url = base_url();
        }
        if ($mainmenudetails['is_target_blank'] == 0 || $mainmenudetails['is_target_blank'] == 1) {
          $target = '';
        } else {
          $target = "target='_blank'";
        }
        if ($mainmenudetails['is_alert'] == 1) {
          $alertClass = "confirmation";
          $target = "target='_blank'";
        } else {
          $alertClass = "";
        }

        if (count($data2[$menuid]) > 0) {
          $content .= "<li class='parent_li'><a href='" . $base_url . $mainmenudetails['site_controller'] . "' " . $target . " class='myclass " . $alertClass . "'><span class='site_color' title='About Municipality'>" . $mainmenudetails['page_name'] . "</span></a>";
        } else {

          $content .= "<li class='parent_li'><a href='" . $base_url . $mainmenudetails['site_controller'] . "' " . $target . " class='myclass " . $alertClass . "'><span class='site_color' title='About Municipality'>" . $mainmenudetails['page_name'] . "</span></a>";
        }
        $content .= "<ul>";

        foreach ($data2[$menuid] as $submenuid => $submenudetails) {

          if ($submenudetails['is_custumlink'] == 1) {
            $base_url = '';
          } else {
            $base_url = base_url();
          }


          if ($submenudetails['is_target_blank'] == 1) {
            $target = '';
          } else {
            $target = "target='_blank'";
          }
          if ($submenudetails['is_alert'] == 1) {
            $alertClass = "confirmation";
            $target = "target='_blank'";
          } else {
            $alertClass = "";
          }

          $content .= "<li class='parent_li'><a href='" . $base_url . $submenudetails['site_controller'] . "' " . $target . " class='" . $alertClass . "'><span title='Basic Information of Municipality'>" . $submenudetails['page_name'] . "</span></a>";

          $content .= "<ul>";

          foreach ($data3[$menuid][$submenuid] as $subsubmenuid => $subsubmenudetails) {

            if ($subsubmenudetails['is_custumlink'] == 1) {
              $base_url = '';
            } else {
              $base_url = base_url();
            }

            if ($subsubmenudetails['is_target_blank'] == 0 || $subsubmenudetails['is_target_blank'] == 1) {
              $target = '';
            } else {
              $target = "target='_blank'";
            }
            if ($subsubmenudetails['is_alert'] == 1) {
              $alertClass = "confirmation";
              $target = "target='_blank'";
            } else {
              $alertClass = "";
            }

            $content .= "<li class='parent_li'><a href='" . $base_url . $subsubmenudetails['site_controller'] . "' " . $target . " class='" . $alertClass . "'><span title='Last two years trade licenses'>" . $subsubmenudetails['page_name'] . "</span></a></li>";
          }

          $content .= "</ul>";

          $content .= "</li>";
        }

        $content .= "</ul>";
        $content .= "</li>";
      }



      $content .= "</ul>";
      $content .= "</li>";
      $content .= "</ul>";
      $content .= "</div>";

      $content .= "</div>";
    }
    $content .= "</div>";
    $content .= "</div>";
    // print_r($content);
    return $content;
  }

  public function getFaqs($ulbid, $lang_id)
  {
    error_reporting(1);
    //$select_array=array('a.album_id','album_desc','a.ts','COUNT(aim.album_id) as photos','image_path','aim.alttext');
    $departments_data = $this->CI->db->select('D.id,D.depart_name');
    $departments_data = $this->CI->db->from('departments_mst D');
    $this->CI->db->join('faqs F', 'F.dept_id = D.id');
    $this->CI->db->group_by('D.depart_name');

    $query =  $this->CI->db->get();
    $departments_data =  $query->result_array();
    //echo "<pre>"; print_R($departments_data);
    // $condition=array('status'=>1);
    // $this->CI->db->select('*');
    // $this->CI->db->from('faqs');
    // $this->CI->db->where($condition);
    // $faq=$this->CI->db->get();

    //$result =  $albums->result_array();
    // echo   $result=$this->CI->db->last_query(); exit;
    $content = "";




    $content .= '
        <section class="section">
  <div class="container ">';
    $fa = 1;
    foreach ($departments_data as $department) {

      $this->CI->db->select('*');
      $this->CI->db->from('faqs');
      $this->CI->db->join('departments_mst', 'faqs.dept_id = departments_mst.id');
      $this->CI->db->where('faqs.status', '1');
      $this->CI->db->where('faqs.dept_id', $department['id']);
      $faq = $this->CI->db->get();

      //echo $this->CI->db->last_query();
      $content .= '
  <h4 class="text-center">' . $department['depart_name'] . '</h4>
  <div class="row">
      <div class="col-md-10 m-auto">
          
  <div class="accordion mt-3" id="accordionExample">';

      foreach ($faq->result_array() as $key => $val) {
        //if ($val['dept_id'] == $department['id']) {

        $content .= '
        <div class="accordion-item">
    <h2 class="accordion-header" id="heading' . $fa . '">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $fa . '" aria-expanded="false" aria-controls="collapse2">
      ' . $val['question'] . '
      </button>
    </h2>
    <div id="collapse' . $fa . '" class="accordion-collapse collapse" aria-labelledby="heading' . $fa . '" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      ' . $val['answer'] . '
      </div>
    </div>
  </div>';
        $fa++;
        // }
      }
      $content .= '
  
    </div>
    
          </div>
      </div>';
      $fa++;
    }
    $content .= '
    </div>
    </section>';
    return $content;
  }
}
