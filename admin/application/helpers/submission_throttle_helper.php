<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Rate limit helper for webpage/form submissions
 * Prevents excessive form submissions from same IP/URI
 * 
 * @param int $limit           Max allowed submissions in the window
 * @param int $window_seconds  Time window in seconds (e.g. 60 = 1 minute)
 * @param string|null $custom_key Custom identifier (optional)
 */
if (!function_exists('rate_limit_check')) {
    function rate_limit_check($limit = 5, $window_seconds = 60, $custom_key = null)
    {
        $CI =& get_instance();
        $CI->load->driver('cache', ['adapter' => 'file']); // Change to 'redis' or 'memcached' for production

        $ip = $CI->input->ip_address();
        $uri = $CI->uri->uri_string();
        $key = $custom_key ?: 'rate_limit_' . md5($ip . '_' . $uri);

        $data = $CI->cache->get($key);

        $now = time();

        if ($data && isset($data['count']) && isset($data['start'])) {
            if (($now - $data['start']) < $window_seconds) {
                $data['count']++;

                if ($data['count'] > $limit) {
                    // Too many submissions
                    //show_error('Too many submissions. Please wait and try again later.', 429);
                    //exit;
					
					$this->session->set_flashdata('error_message', "Too many submissions. Please wait and try again later!");
					redirect($_SERVER['HTTP_REFERER']);
					exit;
						
                }
            } else {
                // Reset if time window has passed
                $data = ['count' => 1, 'start' => $now];
            }
        } else {
            $data = ['count' => 1, 'start' => $now];
        }

        $CI->cache->save($key, $data, $window_seconds);
    }
}
