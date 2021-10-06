<?php

	header( "Content-disposition: attachment; filename=sample.html" );
	header( "Content-Type: text/html; charset=UTF-8" );

	$url = "http://localhost:8888/WordpPress/KongresOnline/email/dianews/titulok-emailu/";
	if ( file_get_contents( $url ) ) {
		echo file_get_contents( $url ) ;
	} else {
		echo "File downloading failed!";
	}



