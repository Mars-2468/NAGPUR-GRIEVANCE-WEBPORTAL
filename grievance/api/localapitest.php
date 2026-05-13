<?php
if(isset($_REQUEST['uid']) && isset($_REQUEST['pwd']))
{
    if($_REQUEST['uid']=='admin' && $_REQUEST['pwd']=='123')
    {
        $data[]=array('statuscode'=>'200','message'=>'success');
    }
    else
    {
        $data[]=array('statuscode'=>'201','message'=>'fail');
    }
    echo json_encode($data);
}
?>