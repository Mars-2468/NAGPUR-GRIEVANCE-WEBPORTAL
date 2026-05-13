<?php
/**
 * Prevents rapid repeat submissions from same user
 * Usage: call `check_submission_throttle('rating_form', 10);`
 */

require "config.php"; // Ensure session is started

function check_submission_throttle($form_key = 'default_form', $cooldown_seconds = 10)
{
    $key = 'last_submit_' . $form_key;
    $now = time();

    if (isset($_SESSION[$key]) && ($now - $_SESSION[$key]) < $cooldown_seconds) {
        $wait = $cooldown_seconds - ($now - $_SESSION[$key]);
       /*  echo "Please wait {$wait} more seconds before submitting again.";
        http_response_code(429);
        exit; */
		
		$_SESSION['error_message'] = " Please wait {$wait} more seconds before submitting again.!";
		header("Location: smartnmcInsert.php");
		exit;
    }

    // Allow submission and update time
    $_SESSION[$key] = $now;
}
