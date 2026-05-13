<?php
if($_REQUEST['cs_id']==1)
{
    $url="http://125.18.179.57:8081/Taxcal/getassessmentCMS.do";
}
else if($_REQUEST['cs_id']==6)
{
    $url="http://125.18.179.57:8081/VLTTaxcal/getassessmentCMS.do";
}
else if($_REQUEST['cs_id']==14)
{
      
    //$url="http://epaycdma.telangana.gov.in:8081/Tradeapplication/tradeDashboardMob.do";
    
    $url="http://epaycdma.telangana.gov.in:8081/Tradeapplication/etradeApplicationCMS.do";
    
}
else if($_REQUEST['cs_id']==18)
{
    $url="http://epaycdma.telangana.gov.in:8081/Tradeapplication/getrenwalcms.do";
}
else if($_REQUEST['cs_id']==7)
{
    $url="http://epaycdma.telangana.gov.in:8082/CDMA_Water/newWaterApplicationCMS.do";
}
?>
<script>
    $(document).ready(function({
        window.location=<?php $url; ?>
    }))
</script>

<!--<iframe src="<?php echo $url; ?>" width="100%" height="600" frameborder="0"></iframe>-->