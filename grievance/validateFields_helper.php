<?php 

function validateField($value, $type,$value2="")
{
    $value = trim($value);
    $value2 = trim($value2);
    $response = [
        'valid' => true,
        'message' => ''
    ];
//echo "<pre>";print_r($value);echo "</pre>";die();
    // First-letter space check
    if ($value !== '' && $value[0] === ' ') {
        return [
            'valid' => false,
            'message' => 'First letter should not be empty!'
        ];
    }

    switch ($type) {

        case 'text':
            if (!preg_match('/^[a-zA-Z0-9\x{0900}-\x{097F} _\-\.\(\) ]+$/u', $value)) {
                $response = ['valid' => false, 'message' => 'Invalid characters!'];
            }
            break;

        case 'sptext':
            if (!preg_match('/^[a-zA-Z0-9\x{0900}-\x{097F} _\-.,&()]+$/u', $value)) {
                 $response = ['valid' => false, 'message' => 'Invalid characters!'];
            }
            break;

        case 'dnumber':
            if (!ctype_digit($value)) {
                 $response = ['valid' => false, 'message' => 'Invalid number! digits only.'];
            }
            break;

        case 'fnumber':
            if (!preg_match('/^-?\d+(\.\d+)?$/', $value)) {
                 $response = ['valid' => false, 'message' => 'Invalid number!'];
            }
            break;

        case 'dcaptcha':
            if (!preg_match('/^[0-9]{4}$/', $value)) {
                 $response = ['valid' => false, 'message' => 'Invalid captcha!'];
            }
            break;

        case 'address':
            if (!preg_match('/^[a-zA-Z0-9\x{0900}-\x{097F} _\-.,&()\/]+$/u', $value)) {
                 $response = ['valid' => false, 'message' => 'Invalid address characters.'];
            }
            break;

        case 'address2':
            if (!preg_match('/^[a-zA-Z0-9\x{0900}-\x{097F} _\-.,()]+$/u', $value)) {
                 $response = ['valid' => false, 'message' => 'Invalid address characters.'];
            }
            break;

        case 'email':
            if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|org|net|io)$/', $value)) {
                 $response = ['valid' => false, 'message' => 'Invalid email address!'];
            }
            break;

        case 'mobile':
            if (!preg_match('/^[6-9][0-9]{9}$/', $value)) {
                 $response = ['valid' => false, 'message' => 'Invalid mobile number!'];
            }
            break;

        case 'landline':
			if (!preg_match('/^(\+91[- ]?)?(0?\(?\d{2,4}\)?[- ]?)?\d{6,8}$/', $value)) {
				$response = ['valid' => false, 'message' => 'Invalid landline number!'];
			}
            break;

        case 'fax':
			if (!preg_match('/^(\+?\d{1,3}[- ]?)?(\(?\d{2,5}\)?[- ]?)?\d{5,10}$/', $value)) {
				$response = ['valid' => false, 'message' => 'Invalid fax number!'];
			}
            break;

        case 'lat':
            if ($value < -90 || $value > 90) {
                 $response = ['valid' => false, 'message' => 'Latitude must be between -90 and 90'];
            }
            break;

        case 'lng':
            if ($value < -180 || $value > 180) {
                 $response = ['valid' => false, 'message' => 'Longitude must be between -180 and 180'];
            }
            break;

        case 'url':
			if (!preg_match('/^(https?:\/\/)?([a-z0-9.-]+\.[a-z]{2,}|localhost|127\.0\.0\.1)(:\d+)?(\/\S*)?$/i', $value)) {
				$response = ['valid' => false, 'message' => 'Invalid URL format!'];
			}
            break;

        case 'date':
            if (!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/', $value)) {
                 $response = ['valid' => false, 'message' => 'Invalid date format (YYYY-MM-DD).'];
            }
            break;

		case 'password':
			if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=\-]).{8,}$/', $value)) {
				$response = [
					'valid' => false,
					'message' => 'Password must be at least 8 characters with uppercase, lowercase, number and special character.'
				];
			}
		break;

		case 'confirm_password':
			
			// 1. Check complexity for confirm password also
			if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+=\-]).{8,}$/', $value)) {
				$response = [
					'valid' => false,
					'message' => 'Password must be at least 8 characters with uppercase, lowercase, number and special character.'
				];
			}
			// 2. Check if both match
			else if ($value !== $value2) {
				$response = [
					'valid' => false,
					'message' => 'Password and Confirm Password do not match!'
				];
			}
		break;


        case 'captcha':
            if (!preg_match('/^[a-zA-Z0-9]+$/', $value)) {
                 $response = ['valid' => false, 'message' => 'Captcha must be alphanumeric only.'];
            }
            break;

        case 'alphanumerics':
            if (!preg_match('/^[a-zA-Z0-9]*$/', $value)) {
                 $response = ['valid' => false, 'message' => 'Only alphanumerics allowed!'];
            }
            break;

        case 'alphanumerics_slash':
            if (!preg_match('/^[a-zA-Z0-9\/]*$/', $value)) {
                 $response = ['valid' => false, 'message' => 'Only alphanumerics and / allowed!'];
            }
            break;

        default:
             $response = ['valid' => true, 'message' => ''];
    }

    return $response;
}

