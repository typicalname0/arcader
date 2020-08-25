<?php
$conn = mysqli_connect("localhost", "", "", "");

function validateCaptcha($privatekey, $response) {
	$responseData = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$privatekey.'&response='.$response));
	return $responseData->success;
}

function webhookSend($webhookurl, $desc, $content) {
	$content = htmlspecialchars($content);
	$content = str_replace("@everyone", "", $content);
	$timestamp = date("c", strtotime("now"));

	$json_data = json_encode([
		"username" => "stomks man",
		// Text-to-speech
		"tts" => false,

		// Embeds Array
		"embeds" => [
			[
				// Embed Title
				"title" => $title,

				// Embed Type
				"type" => "rich",

				// Embed Description
				"description" => $desc,

				// Timestamp of embed must be formatted as ISO8601
				"timestamp" => $timestamp,

				// Embed left border color in HEX
				"color" => hexdec( "3366ff" )
			]
		]

	], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

	$ch = curl_init( $webhookurl );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt( $ch, CURLOPT_POST, 1);
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt( $ch, CURLOPT_HEADER, 0);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

	$response = curl_exec( $ch );
	curl_close( $ch );
}
?>