<?php

 //if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Rate Limiter Helper for CodeIgniter 3
 * Usage: rate_limit_check($limit, $window_seconds)
 */

function rate_limit_check($limit = 10, $window = 60)
{
    $ip = $_SERVER['REMOTE_ADDR'];
    $uri = $_SERVER['REQUEST_URI'];
    $key = md5($ip . '_' . $uri);

    $storageFile = sys_get_temp_dir() . "/rate_limit_$key.json";

    $currentTime = time();
    $data = ['count' => 0, 'start_time' => $currentTime];

    if (file_exists($storageFile)) {
        $data = json_decode(file_get_contents($storageFile), true);
        
        // Check if window has expired
        if ($currentTime - $data['start_time'] > $window) {
            // Reset window
            $data = ['count' => 1, 'start_time' => $currentTime];
        } else {
            $data['count']++;
        }
    } else {
        $data['count'] = 1;
    }

    // Save updated data
    file_put_contents($storageFile, json_encode($data));

    if ($data['count'] > $limit) {
      /*   http_response_code(429); // Too Many Requests
        header('Retry-After: ' . $window);
        echo "Too many requests. Please wait {$window} seconds and try again.";
        exit; */
		
		 $_SESSION['error_message'] = "Error: Limit:Too many requests. Please wait {$window} seconds and try again.!";
	header("Location: smartnmcInsert.php");
	exit;
    }
}
