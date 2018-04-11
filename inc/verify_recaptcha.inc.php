<?php
function verify_recaptcha($response_key, $secret_key, $error = false){
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
		'secret'   => $secret_key,
		'response' => $response_key,
	]));

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$data = curl_exec($ch);

	curl_close($ch);

	$response = @json_decode($data);

	if ($response && $response->success){
		$error = false;
	}
	else{
		$error = true;
	}
	
	return $error;
	
	
}
?>