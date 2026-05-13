<?php
    //die('testing');
    $access_key = '2';
    //return $access_key;
    function check_access_key($key){
        // echo "hi";
        return ($access_key == $key) ?  1 : 0;
    }
?>