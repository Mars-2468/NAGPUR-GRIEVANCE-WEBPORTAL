<?php
/* connect to gmail */
$hostname = '{mail.egovindia.in:993/imap/ssl}INBOX';
$username = 'imap@egovindia.in';
$password = 'Me&S$?1QNt%{';

set_time_limit(4000); 
 

/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

/* grab emails */
$emails = imap_search($inbox,'ALL');

/* if emails are returned, cycle through each... */
if($emails) {
	
	/* begin output var */
	$output = '';
	
	/* put the newest emails on top */
	rsort($emails);
	
	/* for every email... */
	foreach($emails as $email_number) {
		
		/* get information specific to this email */
		$overview = imap_fetch_overview($inbox,$email_number,0);
//echo "<pre>";	print_r($overview);die;
		$message = imap_fetchbody($inbox,$email_number,2);
		//	echo "<pre>";	print_r($message);die;
		/* output the email header information */
		$output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
		$output.= '<span class="subject">'.$overview[0]->subject.'</span> ';
		$output.= '<span class="from">'.$overview[0]->from.'</span>';
		$output.= '<span class="date">on '.$overview[0]->date.'</span>';
		$output.= '</div>';
		
		/* output the email body */
		$output.= '<div class="body">'.$message.'</div>';
	}
	echo "<pre>";	print_r($output);

} 

/* close the connection */
imap_close($inbox);




// // Connect to gmail
// $imapPath = '{mail.egovindia.in:993/imap/ssl}INBOX';
// $username = 'imap@egovindia.in';
// $password = 'Me&S$?1QNt%{';
 
// // try to connect 
// $inbox = imap_open($imapPath,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());
 
 
// // search and get unseen emails, function will return email ids
// $emails = imap_search($inbox,'ALL');
 
// $output = '';
 
// foreach($emails as $mail) {
 
//  $headerInfo = imap_headerinfo($inbox,$mail);
//  echo "<pre>";print_r($headerInfo);die;
//  $output .= $headerInfo->subject.'<br/>';
//  $output .= $headerInfo->toaddress.'<br/>';
//  $output .= $headerInfo->date.'<br/>';
//  $output .= $headerInfo->fromaddress.'<br/>';
//  $output .= $headerInfo->reply_toaddress.'<br/>';
 
//  $emailStructure = imap_fetchstructure($inbox,$mail);
 
//  if(!isset($emailStructure->parts)) {
//  $output .= imap_body($inbox, $mail, FT_PEEK); 
//  } else {
//      //	
//  }
//   echo $output;
//   $output = '';
// }
 
// // colse the connection
// imap_expunge($inbox);
// imap_close($inbox);
?>
