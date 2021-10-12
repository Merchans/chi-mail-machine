<?php
	require_once( "../../../../wp-load.php" );
	header( "Content-disposition: attachment; filename=index.html" );
	header( "Content-Type: text/html; charset=UTF-8" );


	if ( ! $_GET['id'] ) {
		die();
	}
	$url = get_permalink( $_GET['id'] );

	$stream_opts = [
		"ssl" => [
			"verify_peer"      => false,
			"verify_peer_name" => false,
		]
	];

	$response = file_get_contents( $url,
		false, stream_context_create( $stream_opts ) );
	$response = str_replace( '<a href="' . CHI_MAIL_BASE_URL . 'templates/email-download.php?id='. $_GET['id'] .'">Download</a>', '',
		$response );
	echo $response;
