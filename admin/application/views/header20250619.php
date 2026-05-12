<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content=":: Nagpur Municipal Corporation">

    <meta name="author" content=":: Nagpur Municipal Corporation">



    <title>:: Dashboard</title>

    <!-- Vendor css -->
    <link rel="icon" href="<?php echo base_url(); ?>../assets/cdma/TSFC/images/favicon.png" />

    <link href="<?php echo base_url(); ?>assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">

    <!-- Shamcey CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/shamcey.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-91.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/mystyle.css">

    <link href="<?php echo base_url(); ?>assets/lib/medium-editor/medium-editor.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/lib/medium-editor/default.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/lib/summernote/summernote-bs4.css">


    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontawesome/css/all.css">


    <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>

    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" id="fontsizesheet" href="#">




    <style>
        .myheaderengs {
            font-family: 'Open Sans', sans-serif;
            font-size: 23px;
            margin-top: 36px;
            font-weight: bold;
        }

        .myheadertelugu {
            font-family: 'Mallanna', sans-serif;
            font-size: 38px;
            font-weight: bold;
            margin-top: 19px;
            line-height: 0.8;
        }




        .myhide {
            display: block;
        }

        .hidelang {
            display: block;
            padding-top: 20px;
        }


        @media screen and (max-width: 768px) {
            .myheadertelugu {
                font-family: 'Mallanna', sans-serif;
                font-size: 19px;
                font-weight: 600;
                margin-top: 19px;
                line-height: 0.8;
            }

            .myheadereng {
                font-family: 'Open Sans', sans-serif;
                font-size: 22px;
                margin-top: 22px;
                font-weight: bold;
            }

            .myhide {
                display: none;
            }

            .hidelang {
                display: none;
            }

        }

        body {
            position: initial !important;
        }
    </style>
<!-- jQuery CDN (optional, only needed if you plan to use jQuery in your script) -->

<script>
    setInterval(function () {
        $.ajax({
            url: "<?= base_url('auth/check_session') ?>",
            success: function(response) {
                if (response === "expired") {
                    alert("Session expired! You will be logged out.");
                    window.location.href = "<?= base_url() ?>";
                }
            }
        });
    }, 60000); // Check every 60 seconds
</script>

<script>
    $(window).on('beforeunload', function () {
        navigator.sendBeacon("<?= base_url('auth/logout_on_close') ?>");
    });
</script>

</head>

<body>



    <div class="sh-logopanel">
        <a href="#" class="sh-logo-text"><img src="<?php echo base_url(); ?>../assets/cdma/TSFC/images/ap-logo.png"></a>
        <a id="navicon" href="#" class="sh-navicon d-none d-xl-block"><i class="fa fa-bars"></i></a>
        <a id="naviconMobile" href="#" class="sh-navicon d-xl-none"><i class="fa fa-bars"></i></a>
    </div><!-- sh-logopanel -->




    <div class="sh-sideleft-menu">
        <label class="sh-sidebar-label">Navigation</label>
        <ul class="nav">
            <li class="nav-item">
                <a href="<?php echo base_url() ?>dashboard" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>



            <?php foreach ($main_menu_list as $key => $val) { ?>

                <?php if (is_array($sub_menus[$val['main_menu_id']])) { ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link with-sub">
                            <i class="<?php echo $val['icon']; ?>"></i>
                            <span> <?php echo $val['main_menu_name']; ?> </span>
                        </a>
                        <ul class="nav-sub">
                            <?php $i = 1;
                            foreach ($sub_menus[$val['main_menu_id']] as $subMenuId => $submenuValue) { ?>

                                <?php
                                if ($submenuValue['SubcontrollerName'] == "create-category") {
                                } else {
                                ?>
                                    <li class="nav-item"><a href="<?php echo base_url() . $submenuValue['SubcontrollerName']; ?>" class="nav-link"><?php echo $submenuValue['submenuname']; ?></a></li>
                                <?php
                                }
                                ?>



                            <?php $i++;
                            } ?>




                            <!--------------- custom menus ----------------->






                        </ul>
                    </li>

                    <?php






                } else {


                    if (is_array($custom_menus[$val['main_menu_id']])) {
                    ?>

                        <li class="nav-item">
                            <a href="#" class="nav-link with-sub">
                                <i class="<?php echo $val['icon']; ?>"></i>
                                <span> <?php echo $val['main_menu_name']; ?> </span>
                            </a>
                            <ul class="nav-sub">
                                <?php foreach ($custom_menus[$val['main_menu_id']] as $subMenuId => $submenuValue) { ?>


                                    <li class="nav-item"><a href="<?php echo base_url() . $submenuValue['controller']; ?>" class="nav-link"><?php echo $submenuValue['page_name']; ?></a></li>


                                <?php } ?>
                            </ul>
                        </li>


                    <?php
                    } else {




                    ?>

                        <li class="nav-item">
                            <a href="<?php echo base_url() . $val['controllerName'] ?>" class="nav-link">
                                <i class="<?php echo $val['icon']; ?>"></i>
                                <span> <?php echo $val['main_menu_name']; ?></span>
                            </a>
                        </li>
            <?php }
                }
            } ?>
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>social-media-links" class="nav-link">
                    <i class="fa fa-list"></i>
                    <span>Social Media Links</span>
                </a>
            </li>

            <!--<li class="nav-item">
             <a href="<?php echo base_url(); ?>startups-partners" class="nav-link">
               <i class="fa fa-list"></i>
               <span>Startups & Partners</span>
             </a>
           </li> -->
           <li class="nav-item">
             <a href="<?php echo base_url(); ?>team-details" class="nav-link">
               <i class="fa fa-tasks"></i>
               <span>Team Details</span>
             </a>
           </li> 
		   <li class="nav-item">
             <a href="<?php echo base_url(); ?>imp-links" class="nav-link">
               <i class="fa fa-tasks"></i>
               <span>Important Links</span>
             </a>
           </li> 
	   <li class="nav-item">
             <a href="<?php echo base_url(); ?>slider-list" class="nav-link">
               <i class="fa fa-tasks"></i>
               <span>Slider List</span>
             </a>
           </li> 
 	   <li class="nav-item">
             <a href="<?php echo base_url(); ?>encroachment-queries" class="nav-link">
               <i class="fa fa-tasks"></i>
               <span>Encroachment Queries</span>
             </a>
           </li> 		
        <!-- <li class="nav-item">
          <a href="<?php echo base_url(); ?>complaint-details" class="nav-link">
            <i class="fa fa-database"></i>
            <span>Complaint Details</span>
          </a>
        </li>   -->

            <!--<li class="nav-item">-->
            <!--  <a href="<?php echo base_url(); ?>recent-announcements-text" class="nav-link">-->
            <!--    <i class="fa fa-tasks"></i>-->
            <!--    <span>Recent Announcements / Text</span>-->
            <!--  </a>-->
            <!--</li>    -->

            <!-- <li class="nav-item">
          <a href="<?php echo base_url(); ?>schemes-category" class="nav-link">
            <i class="fa fa-tasks"></i>
            <span>Schemes Category</span>
          </a>
        </li>    -->

            <!--<li class="nav-item">-->
            <!--  <a href="<?php echo base_url(); ?>agenda_and_minutes_category_year" class="nav-link">-->
            <!--    <i class="fa fa-tasks"></i>-->
            <!--    <span>Agenda & Minutes Category Year</span>-->
            <!--  </a> agenda_and_minutes-->
            <!--</li>   -->

            <!-- <li class="nav-item">
          <a href="<?php echo base_url(); ?>schemes-sub-category" class="nav-link">
            <i class="fas fa-clipboard-list"></i>
            <span>Schemes Sub Category </span>
          </a>
        </li>  -->

            <!-- <li class="nav-item">
          <a href="<?php echo base_url(); ?>report-category " class="nav-link">
           <i class="fas fa-file-alt"></i>
            <span>Reports </span>
          </a>
        </li> -->
         <li class="nav-item">
                <!-- <a href="<?php //echo base_url(); ?>faq-details" class="nav-link"> -->
                <a href="https://nmcnagpur.gov.in/work-orders" class="nav-link" target="_blank">
                    <i class="fas fa-file-alt"></i>
                    <span>Work Order</span>
                </a>
            </li>
            <li class="nav-item">
                <!-- <a href="<?php //echo base_url(); ?>faq-details" class="nav-link"> -->
                <a href="https://nmcnagpur.gov.in/laq-lcq" class="nav-link" target="_blank">
                    <i class="fas fa-file-alt"></i>
                    <span>LAQ/LCQ</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>faq-details" class="nav-link">
                    <i class="fas fa-file-alt"></i>
                    <span>Faqs</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>logout" class="nav-link">
                    <i class="fa fa-power-off"></i>
                    <span>Logout</span>
                </a>
            </li>



        </ul>
    </div><!-- sh-sideleft-menu -->


    <div class="sh-headpanel">
        <div class="row" style="width:100%;">
            <!--<img class="img-responsive" src="<?php echo base_url(); ?>assets/img/banners/<?php echo $this->session->userdata('banner'); ?>">-->

            <div class="col-md-8">

                <div class="myheaderengs"> Nagpur Municipal
                    Corporation<?php //echo $this->session->userdata('ulbtype')
                                ?> </div>

            </div>
            <div class="col-md-4 hidelang">

                <?php foreach ($languageList->result() as $languageId => $array) {
                    if ($array->languageId == $this->session->langId) {
                        $selLanguage = $array->language_desc;
                    }
                }
                ?>
                <?php //print_r($languageList->result()); exit;
                ?>
                <div style="display:block;">
                    <?php foreach ($languageList->result() as $languageId => $array) {  ?>
                        <input type="button" value="<?php echo $array->language_desc; ?>" class="btn btn-default <?php if ($this->session->userdata('btncolor') == $array->languageId) {
                                                                                                                        $clsstring = "btn-primary";
                                                                                                                    } else {
                                                                                                                        $clsstring = "";
                                                                                                                    }
                                                                                                                    echo $clsstring; ?> btn-xs " id="id<?php echo $array->languageId ?>" onclick="changeLanguage(<?php echo $array->languageId; ?>)"> &nbsp;&nbsp;&nbsp;
                    <?php   }   ?>
                </div>

                <div style=" display:block;">Language Selected : <strong><span id="lang"><?php echo $selLanguage; ?></span> </strong></div>



            </div>


        </div>


    </div><!-- sh-headpanel-left -->

    <!-- <div class="sh-headpanel-right">
       
       
       
      </div> sh-headpanel-right -->
    </div><!-- sh-headpanel -->

    <div class="sh-mainpanel">
        <div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    <li class="breadcrumb-item text-right" aria-current="page"><strong>User name:</strong>
                        <?php echo $this->session->userdata('username'); ?></li>
                </ol>
            </nav>




        </div><!-- sh-breadcrumb -->


        <div style="width:100%;">
            <div style="width:50%; text-align:left; padding-left: 18px; padding-top:15px;"> </div>
            <div style="width:100%; text-align:right">

            </div>

            <!--    <label>Select Language</label>-->
            <!--<div id="google_translate_element"></div>-->
            <!--   <script type="text/javascript">-->
            <!--        function googleTranslateElementInit() {-->
            <!--         new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'bn,en,gu,hi,kn,ml,mr,pa,ta,te,ur', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');-->
            <!--     }-->
            <!--  </script>-->
            <!--  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>-->
        </div>
        <!-- sh-pagetitle -->