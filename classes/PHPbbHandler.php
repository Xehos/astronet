<?php
class PHPbbHandler{
	public string $api_endpoint;

	public void __construct($api_endpoint){
		$this->api_endpoint = $api_endpoint;
	}

	public void addUser($username, $password, $mail){
		$postData = [
		    'username' => $username,
		    'password' => $password,
		    'mail' => $mail
		];
		$postDataString = http_build_query($postData);
		$ch = curl_init();
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $this->api_endpoint+"/adduser/");
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $postDataString);
		//So that curl_exec returns the contents of the cURL; rather than echoing it
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
		//execute post
		$result = curl_exec($ch);
		echo $result;
	}
}