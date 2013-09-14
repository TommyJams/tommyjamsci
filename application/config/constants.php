<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*

Newsletter-Form constants

*/

define('NEWSLETTER_FORM_DATA_FILE_PATH','newsletter/newsletter.csv');
	
define('NEWSLETTER_FORM_MSG_INVALID_DATA_MAIL','Please enter a valid e-mail address.');
define('NEWSLETTER_FORM_MSG_FILE_ERROR','Sorry. We can\'t add your e-mail address.');
define('NEWSLETTER_FORM_MSG_MAIL_EXIST','Sorry. Your e-mail address exists.');
define('NEWSLETTER_FORM_MSG_API_FAILURE','Sorry. Try again later.');
define('NEWSLETTER_FORM_SEND_MSG_OK','Thank you. Your e-mail has been added to our database. You shall hear from us very soon, meanwhile you can check out our blog.');

/*

Contact-Form constants

*/

define('CONTACT_FORM_TO_NAME','contact@tommyjams.com');
define('CONTACT_FORM_TO_EMAIL','contact@tommyjams.com');
	
define('CONTACT_FORM_SMTP_HOST','');
define('CONTACT_FORM_SMTP_USER','');
define('CONTACT_FORM_SMTP_PORT','');
define('CONTACT_FORM_SMTP_SECURE','');
define('CONTACT_FORM_SMTP_PASSWORD','');
	
define('CONTACT_FORM_SUBJECT','TommyJams Landing Page: Contact form');

define('CONTACT_FORM_MSG_INVALID_DATA_NAME','Please enter your name.');
define('CONTACT_FORM_MSG_INVALID_DATA_MAIL','Please enter valid e-mail.');
define('CONTACT_FORM_MSG_INVALID_DATA_MESSAGE','Please enter your message.');
	
define('CONTACT_FORM_SEND_MSG_OK','Thank you for contacting us.');
define('CONTACT_FORM_SEND_MSG_ERROR','Sorry, we can\'t send this message.');

define('RADIO_FORM_MSG_INVALID_DATA_NAME','Please enter your name.');
define('RADIO_FORM_MSG_INVALID_DATA_BAND','Please enter your artist name.');
define('RADIO_FORM_MSG_INVALID_DATA_PHONE','Please enter your phone number.');
define('RADIO_FORM_MSG_INVALID_DATA_MAIL','Please enter valid e-mail address.');
define('RADIO_FORM_MSG_API_FAILURE','Sorry. Try again later.');
define('RADIO_FORM_MSG_DATABASE_INSERT_FAILURE','Sorry. Could not insert into database.');
define('RADIO_FORM_SEND_MSG_OK','Thank you. Your request has been submitted! You will receive an email from us shortly.');

//If there is a local config file, overwrite the settings with that..
if (is_readable(FCPATH . 'config.local.php'))
{
    include_once(FCPATH . 'config.local.php');
}


/* End of file constants.php */
/* Location: ./application/config/constants.php */