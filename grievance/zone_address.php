<!DOCTYPE html>
<?php
require "config.php";
error_reporting(0);

require_once('connection.php');
$conn = getconnection();


 $sql_list = "SELECT *  FROM  ward_mst_geolocation ORDER BY SortOrder ASC";
$rs_list= mysqli_query($conn,$sql_list);




?>

<html>
<head>
  <style>
       .error{
        color:red !important;
    }
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }
    tr:nth-child(even) {
      background-color: #dddddd;
    }
    .g220-img {
      width: 100px;
      /* height: 82px; */
      position: absolute;
      right: 178px;
      top: 20px;
      background: white;
      border-radius: 8px;
      padding: 5px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
      padding: 0px !important;
    }
    .table {
      font-size: 14px !important;
    }
    .dataTables_filter label {
      display: flex !important;
      margin-bottom: 15px !important;
    }
    .allert-style {
    margin: 0px 121px 0px 117px;
}
  </style>
  <title>::NMC Zones Location </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
  <script src="js/modernizr.js"></script>
  \
</head>
<body>
  <div class="g220">
    <a href="https://www.g20.org/en"><img src="images/g220.png" class="img-fluid g220-img" style=""></a>
    <img src="images/header-nmc.jpg" class="img-fluid" style="width:100%">
  </div>
  <center>
    <div class="bg-success p-2 text-white mb-3">
      <h4>Get Zones Location</h4>
    </div>
  </center>

  <?php if (isset($_SESSION['success_message'])) : ?>
    <div class="alert alert-success allert-style">
      <strong>Success!</strong> <?php echo $_SESSION['success_message']; ?>
    </div>
    <?php unset($_SESSION['success_message']); // Clear the session message ?>
  <?php endif; ?>
  
  <div class="container">
    <form action="smartnmcInsertAction.php" name='BirthForm' method="post" enctype="multipart/form-data">
      <div class="row align-items-end">
        <!-- <div class="col-md-4">
          <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" placeholder="" name="name" value="">
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3 mt-3">
            <label for="mobile" class="form-label">Mobile</label>
            <input type="text" class="form-control" id="mobile" placeholder="" name="mobile" value="" onkeypress="return isNumber(event)">
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3 mt-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="" name="email" value="">
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3 mt-3">
            <label for="address" class="form-label">Address</label>
            <input type="address" class="form-control" id="address" placeholder="" name="address" value="">
          </div>
        </div> -->
       
        <div class="col-md-4">
          <div class="mb-3 mt-3">
            <label for="zones" class="form-label">Select Zones</label>
            <select class="form-select" id="zones" name="zones" onchange="fetchData(this.value)">
              <option value="">-select-</option>
              <?php $i=1; while($row = mysqli_fetch_assoc($rs_list)) { ?>
              <option value="<?php echo $row['ward_id'];?>"><?php echo $row['ward_desc'];?></option>
              <?php } ?>

            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3 mt-3">
            <label for="description" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" placeholder="" name="address" value="" readonly>
            <!-- <textarea class="form-control" id="description" placeholder="" name="description" value=""></textarea> -->
          </div>
        </div>
        <div class="col-md-2">
        <div class="mb-3 mt-3">
        <a href=""  target="__blank" class="btn btn-warning " id="location">Directions</a>
        <!-- <button type="submit" class="btn btn-warning waves-effect waves-light w_100">Submit</button> -->
      </div>
      </div>
      </div>
      
    </form>
  </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


<script>
  function isNumber(evt) {
    evt = evt || window.event;
    var charCode = evt.which || evt.keyCode;
    var inputValue = String.fromCharCode(charCode);
    var currentValue = evt.target.value || '';
    var newValue = currentValue + inputValue;
    if (charCode < 48 || charCode > 57 || newValue.length > 10) {
      return false;
    }
    return true;
  }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script>
<script>
  $(document).ready(function() {
    $(function() {
      $("form[name='BirthForm']").validate({
        rules: {
          name: "required",
          address: "required",
          department: "required",
          description: "required",
        
          mobile: {
            required: true,
            minlength: 10,
            maxlength: 10
          }
        },
        messages: {
          name: "Enter Name",
          address: "Enter Address",
          department: "Enter Department",
          description: "Enter Description",
          mobile: {
            required: "Please Enter Mobile Number",
            minlength: "Please Enter 10 digit valid Mobile Number",
            maxlength: "Please Enter 10 digit valid Mobile Number",
          },
         
        },
        submitHandler: function(form) {
          form.submit();
        }
      });
    });
  });
</script>
<script>
  $(document).ready(function() {
    // Check if the form was submitted successfully (using your existing logic)
    <?php if ($_POST && $rs) { ?>
      // Show the success alert
      $("#success-alert").show();
    <?php } ?>
  });


  function fetchDataold(zoneId) {
  if (zoneId !== "") {
   // alert(zoneId);
    // Make AJAX request to the proxy endpoint
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        // Handle the response from the API endpoint
        var response = JSON.parse(this.responseText);
        // Process the response data as needed
        console.log(response.data);
        var zoneAddress = response.data.ward_address;
        var link = response.data.ward_link;
        // Update the input field value
        document.getElementById("address").value = zoneAddress;
        document.getElementById("location").setAttribute('href',link);
        // var a = document.getElementById('location'); //or grab it by tagname etc
        //   a.href = "somelink url"
      }
    };
    xhttp.open("GET", "proxy.php?zone_id=" + zoneId, true);
    xhttp.send();
  }
}

</script>
<script>
function fetchData(zoneId) {
  
  if (zoneId) {
   
    $.ajax({
      url: 'zone_address_details.php',
      method: 'POST',
      data: { zoneId: zoneId },
      dataType: 'json',
      success: function(data) {
        
      // console.log(data);
        $('#details').html(data);
        var zoneAddress = data.ward_address;
        var link = data.ward_link;
      
        document.getElementById("address").value = zoneAddress;
        document.getElementById("location").setAttribute('href',link);
      }
    });
  } else {
    
    // Clear the details div if no zone is selected
    $('#details').html('');
  }
}
</script>
</html>
