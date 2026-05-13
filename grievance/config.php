<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
$baseurl = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
$baseurl .= "://" . $_SERVER['HTTP_HOST'];

$all_mayor_dmayor_users=array('muser_01','muser_02','muser_03','muser_04','dmuser_01','dmuser_02');
$mayor_users=array('mayor','muser_01','muser_02','muser_03','muser_04','nagpur');
$deputy_mayor_users=array('deputymayor','dmuser_01','dmuser_02','nagpur');
$admin_level_users=array('mayor','muser_01','muser_02','muser_03','muser_04','deputymayor','dmuser_01','dmuser_02','nagpur');

$mayor_users_dropdown=array('mayor','muser_01','muser_02','muser_03','muser_04');
$deputy_mayor_users_dropdown=array('deputymayor','dmuser_01','dmuser_02');

$limit=20;

?>