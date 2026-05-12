 <footer  id="footer_bar" class="bg-dark text-white text-center1 py-3 p-3 mt-auto">
<script>
/* window.addEventListener('load', function() {
    let loadTime = (performance.now() / 1000).toFixed(2);
    // Show on page
    const info = document.createElement('div');
    info.textContent = "Full page loaded in " + loadTime + " seconds.";
    info.style.position = "fixed";
    info.style.bottom = "10px";
    info.style.right = "10px";
    info.style.background = "#222";
    info.style.color = "#fff";
    info.style.padding = "6px 10px";
    info.style.borderRadius = "5px";
    info.style.fontSize = "13px";
    info.style.zIndex = 9999;
    document.body.appendChild(info);
}); */
</script>

     <link href="<?php echo base_url(); ?>assets/nmc/css/bootstrap-fte.min.css" rel="stylesheet">
  <style>
    /* Custom styling for the social icons */
    .social-icons a {
      display: block;
      text-decoration: none;
      color: #fff;
      background-color: #007bff;
      width: 50px;
      height: 50px;
      margin-bottom: 10px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background-color 0.3s ease;
    }
    .social-icons a:hover {
      background-color: #0056b3;
    }
  </style>


  <!-- Social Icons -->
  <div class="social-icons position-fixed d-flex flex-column" style="right: 5px; bottom: 40px; z-index: 9999;">
    <a href="https://play.google.com/store/apps/details?id=com.app.newnmc" target="_blank" class="bg-light text-white">
		<img src="assets/nmc/images/google-play-app-store3.png" style="height:55px;width:55px;border-radius:200px;" />
	</a>
	<a href="https://apps.apple.com/in/app/my-nagpur-nmc/id6476917248" target="_blank" class="bg-light text-white">
		<img src="assets/nmc/images/apple-phone.png" style="height:55px;width:55px;border-radius:200px;" />
	</a>     
	<a href="https://wa.me/917397807397?text=Hi" target="_blank" class="bg-primary text-white">
		<img src="assets/nmc/ngmc/whatsappimg.png" style="height:55px;width:55px;border-radius:200px;" />
	</a>
	<a href="https://www.facebook.com/nmcngp/" target="_blank" class="bg-primary text-white">
      <i class="bi bi-facebook"></i>
    </a>
    <a href="https://x.com/ngpnmc" target="_blank" class="bg-info text-white">
      <i class="bi bi-twitter"></i>
    </a>
    <a href="https://www.instagram.com/nmcngp/?igshid=YmMyMTA2M2Y%3D" target="_blank" class="bg-danger text-white">
      <i class="bi bi-instagram"></i>
    </a>

  </div>

  <script src="assets/nmc/js/bootstrap-fte.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    <div class="container footer-top py-2">
      <div class="row gy-4">
        <div class="col-lg-3 col-md-12 footer-about">
          <a href="#" class="logo d-flex align-items-center" style="text-decoration:none;color:#ffffff">
           <?php if($language_id==1){ ?>
          <h4>NMC Address</h4>
		  <?php } else {?>	
          <h4>NMC पत्ता</h4>
		  <?php } ?>
          </a>
          <div class="footer-contact pt-3">
           <?php if($language_id==1){ ?>
		   <p>Chatrapati Shivaji Maharaj Administrative Building,</p>
			<p>Nagpur Munciplal Corporation,</p>
			<p>Mahanagar Palika Marg, Civil Lines,</p>
			<p>Nagpur, Maharastra,</p>
			<p>India, 440 001</p>
		<?php }else{ ?>	
			<p>छत्रपती शिवाजी महाराज प्रशासकीय इमारत,</p>
			<p>नागपूर महानगरपालिका,</p>
			<p>महानगर पालिका मार्ग, सिव्हिल लाईन्स,</p>
			<p>नागपूर, महाराष्ट्र,</p>
			<p>भारत, 440 001</p>
		<?php } ?>
          </div>
          <div class="social-links d-flex mt-4">
            <a href="https://x.com/ngpnmc" target="_blank" style="text-decoration:none;color:#ffffff"><i class="bi bi-twitter-x m-1"></i></a>
            <a href="https://www.facebook.com/nmcngp/" target="_blank" style="text-decoration:none;color:#ffffff"><i class="bi bi-facebook m-1"></i></a>
          <a href="https://www.instagram.com/nmcngp/?igshid=YmMyMTA2M2Y%3D" target="_blank" style="text-decoration:none;color:#ffffff"><i class="bi bi-instagram m-1"></i></a> 
              <!--<a href="https://linkedin.com" target="_blank" style="text-decoration:none;color:#ffffff"><i class="bi bi-linkedin m-1"></i></a>-->
   		 </div>
		 
        <div>
		  <img src="assets/nmc/ngmc/images/wcag2A.png" style="width:150px;height:75px;padding-top:10px;padding-right:10px;padding-bottom:10px;aspect-ratio: 1/1;">
        </div>
		
        </div>

        <div class="col-lg-3 col-md-12 footer-links">
         <?php if($language_id==1){ ?>
			<h4><a href="<?php echo base_url().'institutional-structure';?>" style="text-decoration:none;color:#ffffff" target="_blank">Institutional Structure</a></h4>
			<div class="footer-contact pt-1">
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'faqs';?>" style="text-decoration:none;color:#ffffff">FAQ's</a></p>
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'terms-amp-conditions';?>" style="text-decoration:none;color:#ffffff">Terms & Conditions</a></p>
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'privacy-policy';?>" style="text-decoration:none;color:#ffffff">Privacy Policy</a></p>
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'disclaimer';?>" style="text-decoration:none;color:#ffffff">Desclaimer</a></p>
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'hyperlinking-policy';?>" style="text-decoration:none;color:#ffffff">Hyperlinking Policy</a></p>
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'copy-right-policy';?>" style="text-decoration:none;color:#ffffff">Copy right policy</a></p>
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'site-map';?>" style="text-decoration:none;color:#ffffff">Site Map</a></p>
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'screen-info';?>" style="text-decoration:none;color:#ffffff">Screen-info</a></p>
			</div>
			<?php } else {?>		
			
			<h4><a href="<?php echo base_url().'institutional-structure';?>" style="text-decoration:none;color:#ffffff" target="_blank">संस्थात्मक संरचना</a></h4>
			<div class="footer-contact pt-1">
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'faqs';?>" style="text-decoration:none;color:#ffffff">वारंवार विचारले जाणारे प्रश्न</a></p>
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'terms-amp-conditions';?>" style="text-decoration:none;color:#ffffff">नियम आणि अटी</a></p>
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'privacy-policy';?>" style="text-decoration:none;color:#ffffff">गोपनीयता धोरण</a></p>
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'disclaimer';?>" style="text-decoration:none;color:#ffffff">अस्वीकरण</a></p>
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'hyperlinking-policy';?>" style="text-decoration:none;color:#ffffff">हायपरलिंकिंग धोरण</a></p>
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'copy-right-policy';?>" style="text-decoration:none;color:#ffffff">कॉपी राइट पॉलिसी</a></p>
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'site-map';?>" style="text-decoration:none;color:#ffffff">साइट नकाशा</a></p>
				<p><i class="bi bi-chevron-right"></i> <a href="<?php echo base_url().'screen-info';?>" style="text-decoration:none;color:#ffffff">स्क्रीन-माहिती</a></p>
			</div>
			
			<?php } ?>
        </div>

        <div class="col-lg-3 col-md-12 footer-links">
            <?php if($language_id==1){ ?>
          <h4>Services</h4>
		  <?php } else {?>	
          <h4>सेवा</h4>
		  <?php } ?>
          <div class="footer-contact pt-1">
			<?php foreach($bottom_services as $key=>$value) { ?>
				<p><i class="bi bi-chevron-right"></i> <a target="_blank" href="<?php echo $value['site_controller'];?>" style="text-decoration:none;color:#ffffff"><?php echo $value['page_name'];?></a></p>
			<?php } ?>	
			
			<!--	
				<p><i class="bi bi-chevron-right"></i> <a target="_blank" href="https://geocivicnmcapp.nmcptax.com/CitizenServices/CitizenTax/index.html" style="text-decoration:none;color:#ffffff">Property Tax</a></p>
				<p><i class="bi bi-chevron-right"></i> <a target="_blank" href="https://nagpurjalseva.ocwindia.com/" style="text-decoration:none;color:#ffffff">Pay Your Water Charges</a></p>
				<p><i class="bi bi-chevron-right"></i> <a target="_blank" href="http://www.lbtnagpur.com:8080/UserInterfaces-war/" style="text-decoration:none;color:#ffffff">Local Body Tax</a></p>
				<p><i class="bi bi-chevron-right"></i> <a target="_blank" href="https://nmcnagpur.gov.in/RTI/ws/nmc/home.do" style="text-decoration:none;color:#ffffff">RTI</a></p>
				<p><i class="bi bi-chevron-right"></i> <a target="_blank" href="https://mahatenders.gov.in/nicgep/app" style="text-decoration:none;color:#ffffff">e-Tender</a></p>
				
				<p><i class="bi bi-chevron-right"></i> <a target="_blank" href="#" style="text-decoration:none;color:#ffffff">Birth and Death</a></p>
				<p><i class="bi bi-chevron-right"></i> <a target="_blank" href="#" style="text-decoration:none;color:#ffffff">Building Plan</a></p>
				<p><i class="bi bi-chevron-right"></i> <a target="_blank" href="#" style="text-decoration:none;color:#ffffff">Hospital Registration</a></p>
				<p><i class="bi bi-chevron-right"></i> <a target="_blank" href="#" style="text-decoration:none;color:#ffffff">Citizen Disability Form</a></p>
			-->
			</div>
        </div>

        <div class="col-lg-3 col-md-12 footer-newsletter">
          <h6>
			 <?php if($language_id==1){ ?>
			 Total Visitors Count
			  <?php } else {?>	
			 एकूण अभ्यागतांची संख्या
			  <?php } ?>	
			 &nbsp;:&nbsp;<span class="badge text-bg-warning"><?php echo $visitors_count;?></span>
		  </h6>          <!-- <h6>Daily Visitors Count&nbsp;:&nbsp;<span class="badge text-bg-warning">999999</span></h6><hr> -->
          
		  <h6><a href="https://apps.apple.com/in/app/my-nagpur-nmc/id6476917248" target="_blank" style="background-color: transparent; display: inline-block;"><img src="assets/nmc/images/apple-phone.png" style="width:50px;height:50px;"></a>&nbsp;&nbsp;<a href="https://play.google.com/store/apps/details?id=com.app.newnmc" target="_blank" style="background-color: rgba(0,0,0,0.1);cursor:pointer"><img src="assets/nmc/images/google-play-app-store3.png" style="width:60px;height:60px;"></a></h6>
          <h6> <?php if($language_id==1){ ?>
			  Download My Nagpur App
			  <?php } else {?>	
			 माय नागपूर ॲप डाउनलोड करा
			  <?php } ?>
		  </h6><hr>
        
       
         <!-- <h4>Newsletter</h4>
          <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
          <form action="" method="post" class="php-email-form">
            <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>           
            <div class="error-message"></div>
            <div class="sent-message" style="display:none">Your subscription request has been sent. Thank you!</div>
          </form> -->
        </div>

      </div>
    </div>

	<div class="container copyright text-center mt-1">
       <p>© <span>
	  
	  
	  <?php if($language_id==1){ ?>
			 Copyright
			  <?php } else {?>	
			 कॉपीराइट
			  <?php } ?>
	  </span> <strong class="px-1 sitename">NMC</strong> <span>
	  
	  
	   <?php if($language_id==1){ ?>
			 All Rights Reserved and
			  <?php } else {?>	
			 सर्व हक्क राखीव आणि
			  <?php } ?>
	  </span>  
	          
		  <?php if($language_id==1){ ?>
			   Designed by 
			  <?php } else {?>	
			 यांनी डिझाइन केले आहे
			  <?php } ?>
		  
		  <a href="https://mars-india.com" target="_blank" style="text-decoration:none;color:#ffffff"><strong><em>
		  
		 
		  <?php if($language_id==1){ ?>
			    Mars Telecom Systems
			  <?php } else {?>	
			 मार्स टेलिकॉम सिस्टम्स
			  <?php } ?>
		  
		  </em></strong></a>
		  
		    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  		<span style="font-size:12px;font-weignt:normal;" class="<?= ($language_id==1) ? 'footer-en' : 'footer-mr'; ?>">
				<i>
					<?php if($language_id==1){ ?>
						Last Updated on 
						<!-- <span class="badge bg-warning text-dark">08-01-2026</span> -->
						<span class="badge bg-warning text-dark"><?php echo date('d-m-Y'); ?></span>
					<?php } else { ?>
						अंतिम अद्यतन 
						<!-- <span class="badge bg-warning text-dark">०८-०१-२०२६</span> रोजी केले -->
						<span class="badge bg-warning text-dark"><?php echo date('d-m-Y'); ?></span> रोजी केले
					<?php } ?>
				</i> 
			</span> 
			
      </p>
    </div>

   <!-- <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">NMC</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
          Designed by <a href="#"  target="_blank" style="text-decoration:none;color:#ffffff;"><em><strong>Devteam</strong></em></a> Distributed by <a href="https://mars-india.com" target="_blank" style="text-decoration:none;color:#ffffff"><strong><em>Mars Telecom Systems</em></strong></a>
      </div>
    </div> -->
 
 
 <script src="assets/nmc/js/bootstrap-fte.bundle.min.js"></script> 
  <script src="assets/nmc/ngmc/cust-js.js"></script>
   </footer>
      <script>
        function submitForm(ele) {
            // Automatically submit the form when the change event is triggered
			//alert(ele.value);
			if(ele.value==1)			
				document.getElementById("myForm").action = "https://www.nmcnagpur.gov.in/admin/";
            else if(ele.value==2)
				document.getElementById("myForm").action = "https://nmcnagpur.gov.in/DASH/";
           	else
				windows.reload();
				
			/*  else if(ele.value==3)
			 document.getElementById("myForm").action = "https://www.nmcnagpur.gov.in/assets/300/2024/04/mediafiles/User_manual_for_Web_Portal_(For_only_Departmental_Login).pdf";
           	 */
			document.getElementById("myForm").submit();
        }
    </script>
	
	   <!-- Footer -->
	   
	   
<script type="text/javascript" src="assets/delete_cookie.js"></script>
<script>
function deleteCookie(name) {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/;';
}

var cookiesToRemove = [
    'ci_session',
    'PHPSESSID',
    'counter_nv',
    'csrf_cookie_name',
    'counter',
    'acceptcookie',
    'acceptcookiefreecounterstat'
];

cookiesToRemove.forEach(function(cookieName) {
    deleteCookie(cookieName);
});
</script>
<?php $url =base_url();?>






    <!-- Javascript --> 
	<script > 
	    
	   $('document').ready(function()
        {
            if (sessionStorage.getItem("theme") !== null)
            {
                $("#themesheet").prop('href',sessionStorage.getItem("theme"));
            }
            
            if (sessionStorage.getItem("grayscale") !== null)
            {
               $("#pagebody").addClass(sessionStorage.getItem("grayscale"));
            }
            
        }); 
        // Dropdown

$('.dropdown-toggle').hover(function(){ 
  $('.dropdown-menu', this).trigger('hover'); 
})
        
    function fun3(stylesheet)
    {
		//alert(stylesheet);
      
        //sessionStorage.setItem("theme", stylesheet);
		if(stylesheet!=''){
			document.getElementById("nav_bar").setAttribute("style", "background-color:"+stylesheet+" !important;");
			document.getElementById("footer_bar").setAttribute("style", "background-color:"+stylesheet+" !important;");
		}else{
			document.getElementById("nav_bar").setAttribute("style", "background-color:"+stylesheet+" !important;");
			document.getElementById("footer_bar").setAttribute("style", "background-color:black !important;");
	
		}
	   
	   // $("#themesheet").prop('href',sessionStorage.getItem("theme"));
        
    }   
	
    function fun1(stylesheet)
    {
      
        sessionStorage.setItem("theme", stylesheet);
        $("#themesheet").prop('href',sessionStorage.getItem("theme"));
        
    }
        
    function fun2(classname,status)
    {
        sessionStorage.setItem("grayscale", classname);
        
        sessionStorage.removeItem("theme");
        $("#themesheet").prop('href',sessionStorage.getItem("theme"));
        
        if(status=='add')
        {
            
            $("#pagebody").addClass(sessionStorage.getItem("grayscale"));
        }
        else
        {
            $("#pagebody").removeClass(sessionStorage.getItem("grayscale"));
            sessionStorage.removeItem("grayscale");
        }
    }
    
    
    
	</script>
	
	
	 <script>
  
   
   $(document).ready(function()
{
    
    $("#plus").click(function()
    {
        
        sessionStorage.removeItem('fontincreaze');
        
        var count = parseInt(localStorage.getItem('counter') || 1);
        
	    
	    if (count == 1 ) 
	    {
	        
	        sessionStorage.setItem("fontincreaze", "<?php echo base_url(); ?>/assets/cdma/css/increase111.css");
	        
	    }
	    else
	    {
	        
           sessionStorage.setItem("fontincreaze", "<?php echo base_url(); ?>/assets/cdma/css/increase2.css");
          
	    }
	    
	    
        $("#fontsizesheet").prop('href',sessionStorage.getItem("fontincreaze"));
        
        if(count <2)
        {
        localStorage.setItem('counter', ++count);
        }
    });
    
    $("#minus").click(function()
    {
        
        var normal = parseInt(localStorage.getItem('normal'));
        if(normal===0)
        {
            var count = parseInt(localStorage.getItem('counter') || 2);
        }
        else
        {
        var count = parseInt(localStorage.getItem('counter') || 1);
        }
        
        
        
        if (count == 1 ) 
	    {
	        
	        sessionStorage.setItem("fontincreaze", "<?php echo base_url(); ?>/assets/cdma/css/decrease2.css");
	    }
	    else
	    {
	        
        
        sessionStorage.setItem("fontincreaze", "<?php echo base_url(); ?>/assets/cdma/css/decrease1.css");
	    }
	    
	    
	    
        $("#fontsizesheet").prop('href',sessionStorage.getItem("fontincreaze"));
         if(count >=2)
        {
        localStorage.setItem('counter', --count);
        }
        
    });
    
     $("#actual").click(function()
    {
        
        sessionStorage.removeItem("fontincreaze");
        localStorage.removeItem("counter");
        localStorage.setItem('normal', '0');
        
        
        
        
        $("#fontsizesheet").prop('href',sessionStorage.getItem("fontincreaze"));
    });
    $("#te").click(function()
    {
        
        var url =$("#url").val();
      
        $.post('<?php echo base_url(); ?>/HomeController/changLanguage',{},function(data)
        {
           
            
            window.location=url;
        });
    });
    
    
});

$('#category').on('change', function() {
//   alert( this.value );
var post_data = {
            'schema': this.value,
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
            };
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Get-Schema-Sub-Category",
        data: post_data,
        dataType: "JSON",  
        cache:false,
        beforeSend: function() 
        { 
            $("#overlay").fadeIn();
        },
        success:function(data)
            {      
                $('#subcategory').empty();
                $('#subcategory').html('<option value="">Select Sub Category </option>');
                $.each(data, function(key, value) {
                    $('#subcategory').append('<option value="'+ value.id +'">'+ value.text +'</option>');
                });
            },
            complete: function() 
            { 
                $("#overlay").fadeOut();
            }
    });
});

</script>
	
	
<!-- 2025-09-15	<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script> 
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>-->
<script type="text/javascript" src="assets/nmc/js/jquery-migrate-oto.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
   
$('.autoplay').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

</script>
	
 <script>
$('document').ready(function()
{
    if (sessionStorage.getItem("theme") !== null)
    {
        $("#themesheet").prop('href',sessionStorage.getItem("theme"));
    }
    
    if (sessionStorage.getItem("grayscale") !== null)
    {
       $("#pagebody").addClass(sessionStorage.getItem("grayscale"));
    }
    
    
});
    
    function fun1(stylesheet)
    {
        
        $("#pagebody").removeClass(sessionStorage.getItem("grayscale"));
        sessionStorage.removeItem("grayscale");
        sessionStorage.setItem("theme", stylesheet);
        $("#themesheet").prop('href',sessionStorage.getItem("theme"));
        
    }
    
    function fun2(classname,status)
    {
        sessionStorage.setItem("grayscale", classname);
        sessionStorage.removeItem("theme");
        $("#themesheet").prop('href',sessionStorage.getItem("theme"));
        
        if(status=='add')
        {
            
            $("#pagebody").addClass(sessionStorage.getItem("grayscale"));
        }
        else
        {
            $("#pagebody").removeClass(sessionStorage.getItem("grayscale"));
            sessionStorage.removeItem("grayscale");
        }
    }
    
  
</script>
 <script>
   document.addEventListener('DOMContentLoaded', function() {
  var dropdownBtn = document.querySelector('.dropbtn');
  var dropdownContent = document.querySelector('.dropdown-content');

  // Toggle dropdown visibility when button is clicked
  dropdownBtn.addEventListener('click', function() {
    if (dropdownContent.style.display === 'block') {
      dropdownContent.style.display = 'none';
    } else {
      dropdownContent.style.display = 'block';
    }
      });
    });
  </script>
 <script>
  $(document).ready(function() {
    $('table tbody a[href^="mailto:"]').each(function() {
      let originalHref = $(this).attr('href'); // mailto:srk.kumar@gmail.com
      let email = originalHref.replace('mailto:', '');

      // Replace . with "dot" and @ with "at"
      let replacedEmail = email.replace(/\./g, 'dot').replace(/@/g, 'at');

      // Update the href attribute to match replaced format (optional)
      // Usually mailto won't work with replaced characters, so better keep original href
      // But if you want to disable mailto, you can update href too

     $(this).attr('href', 'mailto:' + replacedEmail); // uncomment if you want to change href too

      // Replace the visible text
      //$(this).text(replacedEmail);
    });
  });
</script>

<script>
  let currentFontSize = 80;

  function setFontSize(action) {
    if (action === 'increase' && currentFontSize < 150) {
      currentFontSize += 10;
    } else if (action === 'decrease' && currentFontSize > 90) {
      currentFontSize -= 10;
    } else if (action === 'normal') {
      currentFontSize = 80;
    }

    document.documentElement.style.fontSize = currentFontSize + '%';
    localStorage.setItem('fontSize', currentFontSize);
  }

  // Load saved font size on page load
  document.addEventListener('DOMContentLoaded', function () {
    const savedFontSize = localStorage.getItem('fontSize');
    if (savedFontSize) {
      currentFontSize = parseInt(savedFontSize);
      document.documentElement.style.fontSize = currentFontSize + '%';
    }
  });
</script>



<script>
let speech;

$('#ttsPlay').on('click', function () {
  if (!('speechSynthesis' in window)) {
    alert('Text to Speech not supported in this browser');
    return;
  }

  // Stop any existing speech
  window.speechSynthesis.cancel();

  // Get main content text
  let text = $('.speechContent').text().trim();

  if (!text) {
    alert('No content available to read');
    return;
  }

  speech = new SpeechSynthesisUtterance(text);
  speech.lang = 'en-IN';       // English India
  speech.rate = 1;             // Speed (0.5–2)
  speech.pitch = 1;            // Normal pitch
  speech.volume = 1;           // Full volume

  window.speechSynthesis.speak(speech);
});

$('#ttsStop').on('click', function () {
  window.speechSynthesis.cancel();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/fuse.js@6.6.2"></script>

<script>
const micBtn = document.getElementById('micBtn');
const searchInput = document.getElementById('search_keyword');

let recognition;
let listening = false;

if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {

    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    recognition = new SpeechRecognition();

    recognition.lang = 'en-IN';      // English (India)
    recognition.continuous = false;
    recognition.interimResults = false;

    recognition.onstart = () => {
        listening = true;
        micBtn.innerHTML = '🎙️';
        micBtn.classList.add('btn-danger');
    };

    recognition.onend = () => {
        listening = false;
        micBtn.innerHTML = '🎤';
        micBtn.classList.remove('btn-danger');
    };

    recognition.onresult = (event) => {
        const transcript = event.results[0][0].transcript;
        searchInput.value = transcript;
        searchInput.focus();

        // Optional: auto-submit or trigger search
        // document.getElementById('searchForm').submit();
    };

    micBtn.onclick = () => {
        if (!listening) recognition.start();
        else recognition.stop();
    };

} else {
    micBtn.disabled = true;
    micBtn.title = "Speech recognition not supported";
}
</script>

</body>
</html>
