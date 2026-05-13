<?php
$ulbid ="1168";
$asm ="1168004033";
//$wsdlUrl = 'http://qacdma.cgg.gov.in/cdma_hhd/CDMA_SERVICES.asmx?wsdl';

$url = 'http://qacdma.cgg.gov.in/cdma_hhd/CDMA_SERVICES.asmx?wsdl';
   

    $sc = new SoapClient($url);

                $params = array(
                'assessmentNo' => '1126010912',
                'ULBID' => '1126',
                'penaltyFlag'=>true,
                'username'=>'ff',
                'password'=>'dfdf', 
                'spcode'=>'fs'
               
                );

    
     //$result = $sc->__soapCall('getPropertyTaxDetails', array('parameters' => $params));
     $result = $sc->getPropertyTaxDetails($params);
            $response = json_decode(json_encode($result), True);
    print_r($result);
    
    
  
?>