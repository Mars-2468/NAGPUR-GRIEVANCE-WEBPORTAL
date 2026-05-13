<html>
<?php
$formUrl = "https://mh.nagpurnmc.in/grievance/public_web_complaint_form.php";

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
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
}

.center-page {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.card-box {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    max-width: 420px;
    width: 100%;
}

.qr-img {
    max-width: 220px;
    width: 100%;
    height: auto;
    border: 5px solid #e9ecef;
    border-radius: 10px;
    padding: 5px;
}

.lang-text {
    font-size: 13px;
    line-height: 1.5;
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

<div  class="center-page">
    <div class="card-box text-center">

        <h4 class="mb-2">
            <i class="bi bi-qr-code text-primary"></i> 
            Citizen Complaint Form
        </h4>
        <div class="text-muted small mb-3">नागरिक तक्रार नोंदणी फॉर्म</div>

        <div class="bg-info-subtle text-dark p-2 rounded lang-text mb-3">
            <div>Scan the QR code to quickly register your complaint</div>
            <div>QR कोड स्कॅन करून आपली तक्रार नोंदवा</div>
        </div>

        <div class="my-3">
            <a href="<?php echo $qrCode; ?>" target="_blank">
                <img src="<?php echo $qrCode; ?>" alt="QR Code" class="qr-img">
            </a>
        </div>

        <div class="bg-light border rounded p-2 lang-text text-muted">
            <div>
                Open your mobile camera → focus on the QR code → the form will open → submit your complaint
            </div>
            <div>
                मोबाईल कॅमेरा उघडा → QR कोडवर लक्ष केंद्रित करा → फॉर्म उघडेल → तक्रार नोंदवा
            </div>
        </div>

        <button class="btn btn-primary mt-3 px-4" onclick="printDiv()">
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