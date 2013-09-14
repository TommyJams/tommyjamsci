<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twitterproxy extends CI_Controller{

	public function twitterhandle(){

		session_start();

		$this->load->library('twitteroauth/TwitterOAuth');
		// require_once("twitteroauth/twitteroauth.php"); //Path to twitteroauth library
 		
		$twitteruser = "tommyjams";
		$notweets = 10;
		$consumerkey = "Fh22VgGqVUgoFfhn4uADdw";
		$consumersecret = "slSgXgHTTgi6z2cFl8dfWIwILM3njiWfQHaF8cE0xA";
		$accesstoken = "630529499-sWjOJ9pXm9qufutOCUdw8iq0exSFj2RSoClsauSq";
		$accesstokensecret = "iLsAk65xqzn8nXWmVul9gp33SvVz5AxN2UK1Lb7ew"; 
 
		function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  			$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  			return $connection;
		}
  
		$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
 
		$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
 
 		$output = json_encode($tweets);
    	$this->output->set_content_type('application/json');
    	$this->output->set_output($output);
		// echo json_encode($tweets);

	}
}
?>