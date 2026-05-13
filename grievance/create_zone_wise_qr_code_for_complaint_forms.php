<html>
<?php
require "config.php";
require_once('citizen_comp_connection.php');
$conn = getconnection();
//echo "<pre>"; print_r($_POST);echo "</pre>";die();
$zone_id=$_POST['ward_id'];
$loc_of_gvp_id=$_POST['street_id'];
//$dept_id=$_POST['cat_id'];
//$sub_dept_id=$_POST['sub_id'];
//echo $loc_of_gvp_id;exit;
$stmt = $conn->prepare("SELECT * FROM zone_ward_loc_mst WHERE id = ?");
$stmt->bind_param("i", $loc_of_gvp_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if($loc_of_gvp_id!=''){
	$loc_of_gvp_id=encryptData($loc_of_gvp_id);
}
//echo "<pre>";print_r($row);echo "</pre>";die();

$formUrl = "https://mh.nagpurnmc.in/grievance/public_complaint_form.php?loc_of_gvp_id=".$loc_of_gvp_id."";
//$formUrl = "http://localhost:8081/grievance/public_complaint_form.php?loc_of_gvp_id=".$loc_of_gvp_id."&dept_id=".$dept_id."";

//echo $formUrl;exit;
// Use reliable QR API
$qrCode = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($formUrl);
?>
<!--
<img src="<?php echo $qrCode; ?>" alt="QR Code">
-->
<head>
<title>QR Code</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
html, body {
    height: 100%;
    margin: 0;
    font-family: 'Segoe UI', Arial, sans-serif;
    background: linear-gradient(135deg, #eef2f7, #f8f9fa);
}

/* Center Layout */
.center-page {
    min-height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 30px 15px;
}

/* Card Design */
.card-box {
    background: #ffffff;
    padding: 35px 25px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    max-width: 420px;
    width: 100%;
    text-align: center;
    transition: 0.3s ease;
}

.card-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.18);
}

/* Heading */
.card-box h4 {
    font-weight: 600;
    margin-bottom: 5px;
}

/* QR Image */
.qr-img {
    max-width: 220px;
    width: 100%;
    border-radius: 12px;
    padding: 8px;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: 0.3s;
}

.qr-img:hover {
    transform: scale(1.05);
}

/* Language Text */
.lang-text {
    font-size: 13px;
    line-height: 1.6;
}

/* Info Box */
.info-box {
    background: #eef6ff;
    border-left: 4px solid #0d6efd;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
}

/* Instruction Box */
.instruction-box {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 10px;
}

/* Badge */
.badge-primary-custom {
    display: inline-block;
    margin-top: 8px;
    padding: 6px 14px;
    font-size: 13px;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(45deg, #007bff, #0056b3);
    border-radius: 20px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.2);
}

/* Button */
.btn-print {
    margin-top: 18px;
    padding: 8px 20px;
    border-radius: 25px;
    font-weight: 500;
    transition: 0.3s;
}

.btn-print:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Print */
@media print {
    body {
        background: #fff;
    }
    button {
        display: none !important;
    }
    .card-box {
        box-shadow: none;
        border: none;
    }
}
</style>

</head>
<body id="printArea">

<div class="center-page">
    <div class="card-box">

        <h4>
            <i class="bi bi-qr-code text-primary"></i> 
            Citizen Complaint Form
        </h4>
        <div class="text-muted small mb-3">
            नागरिक तक्रार नोंदणी फॉर्म
        </div>

        <div class="info-box lang-text">
            <div>Scan the QR code to quickly register your complaint</div>
            <div>QR कोड स्कॅन करून आपली तक्रार नोंदवा</div>

            <div class="badge-primary-custom">
                <?php echo $row['loc_of_gvp']; ?>
            </div>
        </div>

        <div class="my-3">
            <a href="<?php echo $qrCode; ?>" target="_blank">
                <img src="<?php echo $qrCode; ?>" alt="QR Code" class="qr-img">
            </a>
        </div>

        <div class="instruction-box lang-text text-muted">
            <div>
                Open your mobile camera → focus on the QR code → form opens → submit complaint
            </div>
            <div>
                मोबाईल कॅमेरा उघडा → QR कोड स्कॅन करा → फॉर्म उघडेल → तक्रार नोंदवा
            </div>
        </div>

        <button class="btn btn-primary btn-print" onclick="printDiv()">
            🖨 Print / Save PDF
        </button>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
function printDiv() {
    var content = document.getElementById("printArea").innerHTML;
    var original = document.body.innerHTML;

    document.body.innerHTML = content;
    window.print();
    document.body.innerHTML = original;

    location.reload(); // optional
}
</script>
</body>
</html>