{include file='corp_header.tpl'}
{literal}
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css" media="all">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .activ_column {
        background-color: #7ac18a;
        color: white !important;
    }

    .activ_column a {
        /*background-color: #54B435;*/
        color: #FFF !important;
        /*text-shadow: 0 0 3px #FFFF;*/
        text-decoration: underline #1C82AD;
    }

    a {
        color: blue;
        text-decoration: none;
    }

    .icon {
        font-size: 60px;
        margin-bottom: 20px;
    }

    .icon,
    h5 {
        color: #fff;
    }

    .card {
        min-height: 176px;
    }



    .bounce:hover {
        -webkit-animation-name: bounce;
        -moz-animation-name: bounce;
        -o-animation-name: bounce;
        animation-name: bounce;
        animation-duration: 1s;
        animation-timing-function: ease-in-out;
        animation-delay: 0s;
        animation-direction: alternate;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
            opacity: 1;
        }

        40% {
            transform: translateY(-20px);
        }

        60% {
            transform: translateY(-10px);
        }
    }
 
#overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black overlay */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999; /* Set a high z-index value */
}
 
</style>

<script>
    $(document).ready(function() {
        getzone('all');
    });
      function getzone(id) {
            $("#overlay").show();
            $.post('ajax_corp_zonal_map_counts.php', {zone_id: id}, function(data) {
                //alert(data);
                  $("#overlay").hide();
               $("#result").html(data);
            });
        }
     
 </script>
{/literal}


<div id="overlay">
  <div class="spinner-border" role="status" style="color: #fff;">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>

<div class="boxed">
    <div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
        <h4>ZONAL MAP REPORTS</h4>
        <p class="m-0"><a href="ajax_corp_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
    </div>


    <div class="row">
    <div class="col-sm-8">
    
    <img src="zone_map_NMC.jpg" width="819" height="579" usemap="#Map">
    <map name="Map">
    
      <area shape="poly"  onclick="getzone(4)" title="Dharmpeth" coords="226,230,235,233,243,234,246,230,250,227,256,226,259,222,266,221,270,220,277,223,282,224,287,223,289,219,297,218,310,218,316,214,323,214,338,221,349,224,362,225,371,233,375,242,377,252,394,252,401,259,401,269,402,293,382,288,383,278,374,277,367,286,343,286,342,299,343,309,346,318,356,320,358,327,350,334,344,338,338,350,334,338,318,342,318,352,314,362,302,362,291,361,282,352,275,352,264,356,251,354,242,358,225,354,211,350,203,349,192,346,192,336,197,322,205,308,205,296,202,280,200,267,194,262" href="#">
      <area shape="poly" onclick="getzone(32)" title="Mangalwari" coords="156,242,162,230,162,211,178,211,185,210,194,212,213,211,229,200,235,196,252,195,262,183,271,172,280,164,287,154,293,149,302,148,305,139,305,127,294,112,292,94,297,99,306,99,310,108,312,118,326,122,337,123,345,119,354,117,368,150,379,168,384,179,384,187,394,189,420,188,422,195,421,203,425,214,426,219,438,215,438,220,429,222,430,232,420,223,390,236,393,249,382,249,379,232,372,222,355,222,344,220,329,212,316,211,301,215,286,218,272,215,259,222,242,231,226,228,192,259,156,242" href="#">
      <area shape="poly"  onclick="getzone(31)" title="Aashi Nagar" coords="359,116,371,111,377,105,386,100,386,94,380,89,388,81,387,76,394,49,428,64,420,80,431,85,434,94,449,102,465,112,479,116,482,132,486,139,498,143,507,137,513,153,508,158,514,179,516,193,511,197,503,193,499,200,505,205,499,212,495,205,484,209,471,209,463,210,458,214,459,225,453,234,442,241,414,249,402,252,395,238,416,226,422,236,430,233,434,229,432,226,440,223,437,216,436,211,428,213,427,198,426,185,417,185,391,186,379,153,369,145,359,116" href="#">
      <area shape="poly" onclick="getzone(3)" title="Laxmi Nagar" coords="219,359,218,370,209,379,204,381,206,389,199,396,194,398,190,414,202,415,200,422,194,425,192,438,193,449,201,452,206,464,209,476,209,490,211,498,217,500,227,498,238,499,241,494,253,494,255,490,268,488,285,488,303,495,307,506,300,518,296,528,294,539,298,546,311,549,322,555,330,559,333,561,338,552,341,541,347,533,350,523,346,512,345,494,349,482,358,475,366,469,372,464,380,450,384,444,384,437,377,433,380,414,382,412,372,404,366,399,367,389,378,357,365,371,356,374,338,375,335,366,334,355,330,343,323,348,323,355,317,366,306,366,294,365,288,359,282,357,270,359,257,360,245,361,231,363,220,359" href="#">
      <area shape="poly" onclick="getzone(26)" title="Dhantoli" coords="377,285,370,290,357,290,349,290,348,301,349,314,359,314,362,326,361,334,352,339,346,348,339,357,340,368,349,369,365,364,381,352,381,361,371,388,373,396,386,410,382,425,388,433,395,439,409,455,420,458,429,462,442,460,442,454,436,443,433,434,433,422,435,416,416,413,411,404,410,388,410,373,414,362,405,361,401,352,407,348,413,338,413,334,420,334,415,318,418,311,428,307,431,294,421,291,421,280,405,276,406,294,405,299,395,298,382,294,378,286" href="#">
      <area shape="poly" onclick="getzone(5)" title="Hanuman Nagar" coords="486,521,496,523,498,518,511,518,526,518,526,500,514,492,510,480,505,468,502,458,502,450,494,435,493,426,514,428,509,418,502,409,495,405,481,407,462,408,456,405,452,398,452,385,456,367,459,356,459,339,463,334,463,322,463,316,446,319,432,324,420,320,426,330,424,335,418,336,413,346,411,352,412,358,419,358,420,369,418,372,415,382,415,401,422,406,430,410,439,410,442,410,441,424,440,438,445,448,452,455,459,464,470,464,478,462,486,470,490,483,486,520" href="#">
      <area shape="poly" onclick="getzone(30)" title="Lakadganj" coords="580,176,586,178,596,178,602,184,610,190,612,197,607,209,611,222,619,234,626,242,640,242,636,248,642,260,640,273,644,290,638,297,631,304,629,312,624,328,622,342,610,343,605,342,592,329,582,324,566,315,553,313,540,309,537,315,534,326,517,320,518,310,508,305,502,299,493,300,483,300,481,304,477,303,479,298,475,294,471,286,474,279,474,274,472,269,486,267,495,264,507,263,515,252,522,240,523,232,522,227,517,226,506,212,511,208,505,202,515,200,522,200,522,186,521,173,516,159,521,155,527,166,540,167,548,173,556,186,566,186,580,178" href="#">
      <area shape="poly" onclick="getzone(28)" title="Gandhibag" coords="411,256,410,270,418,272,426,278,428,286,434,289,437,294,435,302,435,312,425,312,422,316,428,316,436,317,446,314,458,314,467,314,475,313,485,314,491,316,493,309,499,306,485,302,473,302,473,299,468,291,467,283,457,282,449,277,443,270,446,262,446,258,427,250,412,254" href="#">
      <area shape="poly" onclick="getzone(29)" title="Satranjipura" coords="436,250,457,243,460,237,466,234,464,220,473,214,482,215,495,212,504,220,510,227,514,231,520,231,519,238,512,247,509,254,503,259,490,263,485,263,474,263,469,266,470,271,472,274,470,277,466,279,462,276,454,276,452,275,448,270,449,267,449,262,445,256,435,251,457,244" href="#">
      <area shape="poly"  onclick="getzone(27)" title="Nehru Nagar" coords="470,319,487,321,498,319,498,311,505,307,514,313,514,319,515,325,525,328,535,330,539,325,539,320,540,314,559,318,578,328,596,338,598,346,587,346,586,355,572,350,566,358,566,364,554,359,539,359,533,360,537,368,538,381,537,395,538,407,540,411,532,403,531,409,527,411,524,422,530,431,540,441,550,450,549,456,545,459,549,464,550,471,550,478,553,491,552,497,542,497,528,499,521,492,515,480,510,469,506,459,505,445,500,434,513,433,517,426,510,416,503,403,497,400,477,405,470,406,461,405,454,399,453,387,457,366,463,355,465,343,466,335,470,321" href="#">
    </map>
	
    </div>
    <div class="col-sm-4" id="result">
    
      <table class="table table-bordered ">
        <thead>
          <tr class="boxed title-bar blue text-white">
            <th colspan="2" style="text-align:center">ZONE</th>
          </tr>
        </thead>
        <tbody  >
          <tr>
            
            <td> Complaints</td>
            <td>0</td>
            
          </tr>
           
          <tr>
            
            <td> Inprocess</td>
            <td>0</td>
           
          </tr>
          <tr>
            
            <td> Reopened</td>
            <td>0</td>
           
          </tr>
          <tr>
            
            <td>  Delayed</td>
            <td>0</td>
           
          </tr>
          <tr>
            
            <td> Resolved</td>
            <td>0</td>
           
          </tr>
          <tr>
            
            <td>Zone Rating</td>
            <td>0</td>
           
          </tr>
        </tbody>
      </table>

    </div>
   </div>




    <div style="background-image:url(images/search_bg_2.jpg); height:28px;"></div>
    {include file='corp_footer.tpl'}


    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script>
        $(function() {
            $(".datepicker").datepicker({
                changeMonth: true,
                changeYear: true
            });
        });

    </script>
