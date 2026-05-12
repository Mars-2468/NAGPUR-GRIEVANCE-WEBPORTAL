<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_email_details'))
{
    
    function get_email_details($subject,$body,$email_id,$cc,$attachment)
    {
        
        $ci =& get_instance();
        
        $ci->load->library('email');
        
        $config = array(
				'protocol'  => 'smtp',
				'smtp_host' => 'smtp.elasticemail.com',
				'smtp_port' => 2525,
				'smtp_user' => 'vishal.vmax@gmail.com ',
				'smtp_pass' => 'A0C410812F3017E63E6D19D9871C13DABBD9',
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			);
		
		/*$mail->setFrom('support@bhadrachalamonline.com', 'Bhadrachalam');
		$mail->addReplyTo('vmaxhelp@gmail.com', 'Information');*/
		
		$ci->email->initialize($config);
		$ci->email->set_mailtype("html");
		$ci->email->set_newline("\r\n");
		
		/*$htmlContent = '<h1>Sending email via SMTP server</h1>';
		$htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';*/
        
        $email_id = 'vmax.phanindra@gmail.com';
        //$email_id = 'info@iskconportland.com';
		$ci->email->to($email_id);
		if($cc != '')
		{
		    $ci->email->cc($cc);
		}
		
		$ci->email->from('noreply@iskcon.in','ISKCON');
		$ci->email->subject($subject);
		$ci->email->message($body);
		if($attachment != '')
		{
		    $ci->email->attach($attachment);
		}

		//Send email
		if (!$ci->email->send())
		{
		    show_error($ci->email->print_debugger());
		    return 0;
		}
		else
		{
		    return 1;
		}
    }
        
			
}