<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('encrypt_data')) {
    function encrypt_data($data, $key = '12345678901234567890123456789012') {
        $cipher = 'aes-256-cbc';
        $ivLen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivLen);

        $encrypted = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        if ($encrypted === false) return false;

        return bin2hex($iv . $encrypted); // safe for URL and storage
    }
}

if (!function_exists('decrypt_data')) {
    function decrypt_data($hexData, $key = '12345678901234567890123456789012') {
        $cipher = 'aes-256-cbc';
        $data = hex2bin($hexData);

        if ($data === false) return false;

        $ivLen = openssl_cipher_iv_length($cipher);
        $iv = substr($data, 0, $ivLen);
        $ciphertext = substr($data, $ivLen);

        $decrypted = openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        return $decrypted !== false ? $decrypted : false;
    }
}


if (!function_exists('dept_user_ids')) {
    function dept_user_ids() {
       $userids=[
		'Zone_01',
		'Zone_02',
		'Zone_03',
		'Zone_04',
		'Zone_05',
		'Zone_06',
		'Zone_07',
		'Zone_08',
		'Zone_09',
		'Zone_10',		
		'Garden_dept',
		'SW_dept',
		'SWM_dept',
		'GAD_dept',
		'Edu_dept',
		'Acc_dept',
		'PHE_dept',
		'Elec_dept',
		'Envi_dept',
		'PWD_dept',
		'Fire_dept',
		'Tax_dept',
		'Skysign_dept',
		'PRO_dept',
		'IT_dept',
		'Workshop_dept',
		'Health_dept',
		'HMP_dept',
		'Town_dept',
		'Election_dept',
		'Sports_dept',
		'Central_dept',
		'Transport_dept',
		'Library_dept',
		'Slum_dept',
		'Advertisment_dept',
		'Traffic_dept',
		'Waterworks_dept',
		'Project_dept',
		'Market_dept',
		'Air_dept',
		'Urgent_dept',
		'Committee_dept',
		'Pradhan_dept',
		'Recruitment_dept',
		'Smart_dept',
		'Single_dept',
		'Enc_dept1',
		'Estate_dept',
		'CFC_dept',
		'Dpdc-dept',
		'Zone-dept',
		'SW_dept'
	   ];
        return $userids;
    }
}

if (!function_exists('super_admin_dept_user_ids')) {
    function super_admin_dept_user_ids() {
       $userids=[
		'Zone_01',
		'Zone_02',
		'Zone_03',
		'Zone_04',
		'Zone_05',
		'Zone_06',
		'Zone_07',
		'Zone_08',
		'Zone_09',
		'Zone_10',
		'superadmin',
		'devspace',
		'Garden_dept',
		'SW_dept',
		'SWM_dept',
		'GAD_dept',
		'Edu_dept',
		'Acc_dept',
		'PHE_dept',
		'Elec_dept',
		'Envi_dept',
		'PWD_dept',
		'Fire_dept',
		'Tax_dept',
		'Skysign_dept',
		'PRO_dept',
		'IT_dept',
		'Workshop_dept',
		'Health_dept',
		'HMP_dept',
		'Town_dept',
		'Election_dept',
		'Sports_dept',
		'Central_dept',
		'Transport_dept',
		'Library_dept',
		'Slum_dept',
		'Advertisment_dept',
		'Traffic_dept',
		'Waterworks_dept',
		'Project_dept',
		'Market_dept',
		'Air_dept',
		'Urgent_dept',
		'Committee_dept',
		'Pradhan_dept',
		'Recruitment_dept',
		'Smart_dept',
		'Single_dept',
		'Enc_dept1',
		'Estate_dept',
		'CFC_dept',
		'Dpdc-dept',
		'Zone-dept',
		'SW_dept'
	   ];
        return $userids;
    }
}

if (!function_exists('super_dev_admin')) {
    function super_dev_admin() {
       $supdevadmin_userids=[		
		'superadmin',
		'devspace'		
	   ];
        return $supdevadmin_userids;
    }
}