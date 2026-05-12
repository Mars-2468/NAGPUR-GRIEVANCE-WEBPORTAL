<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Rate Limiter Helper for CodeIgniter 3
 * Usage: rate_limit_check($limit, $window_seconds)
 */

if (!function_exists('rate_limit_check')) {
    function rate_limit_check($limit = 60, $window_seconds = 60, $custom_key = null)
    {
        $CI =& get_instance();
        $CI->load->driver('cache', ['adapter' => 'file']); // Use 'redis' or 'memcached' for better performance

        $ip = $CI->input->ip_address();
        $uri = $CI->uri->uri_string();
        $key = $custom_key ?: 'rate_limit_' . md5($ip . '_' . $uri);

        $data = $CI->cache->get($key);

        if ($data) {
            $data['count']++;

            if ($data['count'] > $limit) {
                // Optional: Log or trigger alert
               // show_error('Too many requests. Please wait and try again later.', 429);
			   /* $this->session->set_flashdata('error_message', "Too many submissions. Please wait and try again later!");
					redirect($_SERVER['HTTP_REFERER']);
					exit; */
					return $data['count'];
            }
			
		/* 	
			//optional
			
			if ($data['count'] > $limit) {
				$CI->output
					->set_status_header(429)
					->set_content_type('application/json')
					->set_output(json_encode([
						'error' => 'Rate limit exceeded',
						'retry_after' => $remaining
					]))
					->_display();
				exit;
			} 
		*/
			
			
        } else {
            $data = ['count' => 1];
        }

        // Save back with expiration
        $CI->cache->save($key, $data, $window_seconds);
    }
}
