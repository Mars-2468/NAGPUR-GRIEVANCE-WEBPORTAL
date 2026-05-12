<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2018, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2018, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');
		$this->check_inactivity();
	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}

 // Method to check for inactivity and auto logout
    private function check_inactivity()
    {
        // Session expiration timeout (in seconds)
        $timeout = 900; // 15 minutes

        // Get the current time and last activity time from the session
        $last_activity = $this->session->userdata('last_activity');
        $current_time = time();

        if ($last_activity) {
            // Check if the session has been inactive for longer than the timeout
            if (($current_time - $last_activity) > $timeout) {
                $this->logout();
            }
        }

        // Update the last activity time
        $this->session->set_userdata('last_activity', $current_time);
    }

    // Logout and delete session from the database
    public function logout()
    {
        // Get the session ID
        $user_id = $this->session->userdata('userid');

        // Delete the session from the ci_sessions table
        $this->db->where('user_id', $user_id);
        $this->db->delete('user_sessions');

        // Destroy the session
        $this->session->sess_destroy();

        // Redirect to the login page or home page
        redirect(); // Adjust the redirect URL as needed
    }

    // encrypt
	
	public function encrypt_data($plain_text, $secretKey='mars-india-2025') {
		// Generate an encryption key from the secretKey
		$key = hash('sha256', $secretKey, true);
		
		// Define the cipher method (AES-256-CBC)
		$cipher_method = 'AES-256-CBC';
		
		// Generate an initialization vector (IV) for encryption (must be random and 16 bytes for AES-256-CBC)
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
		
		// Encrypt the text
		$encrypted_text = openssl_encrypt($plain_text, $cipher_method, $key, 0, $iv);
		
		// Return the encrypted text along with the IV (IV is needed for decryption)
		return base64_encode($encrypted_text . '::' . $iv);
	}


	//decrypt
	public function decrypt_data($encrypted_text, $secretKey='mars-india-2025') {
		// Extract the encrypted data and IV from the encoded string
		list($encrypted_data, $iv) = explode('::', base64_decode($encrypted_text), 2);
		
		// Generate the same encryption key from the secretKey
		$key = hash('sha256', $secretKey, true);
		
		// Define the cipher method (AES-256-CBC)
		$cipher_method = 'AES-256-CBC';
		
		// Decrypt the text
		$decrypted_text = openssl_decrypt($encrypted_data, $cipher_method, $key, 0, $iv);
		
		return $decrypted_text;
	}	

}
