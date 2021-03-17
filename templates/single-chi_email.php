<?php get_header(); ?>
<?php wp_head(); ?>
<div class="chi-email-container">
	<?php the_title(); ?>
	<?php the_content(); ?>
	<?php

		//		$html = file_get_contents('http://www.pharma-marketing.cz/stat/stats203.php?sendID=1HYnXblHRIe_6hWVDlDXeQ');

		// Create DOM from URL, paste your destined web url in $page
		$page = 'http://www.pharma-marketing.cz/stat/stats203.php?sendID=CQXB8s-bSZ-UfSNR4Sb6ZA';
		//        $html = new simple_html_dom();
		//
		//        //Within $html your webpage will be loaded for further operation
		//		$html->file_get_html($page);
		//		echo '<pre>';
		//		print_r(  $html);
		//		echo '</pre>';


		//		echo readfile( $page );   //needs "Allow_url_include" enabled
		//		//OR
		//		echo include( $page );    //needs "Allow_url_include" enabled
		//		//OR
		//		echo file_get_contents( $page );
		//		//OR
		//		echo stream_get_contents( fopen( $page, "rb" ) ); //you may use "r" instead of "rb"  //needs "Allow_url_fopen" enabled

		$curl = curl_init();

		curl_setopt( $curl, CURLOPT_URL, $page );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, $page );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, $page );

		$result = curl_exec( $curl );

		preg_match_all( '/<table.*?>(.*?)<\/table>/si', $result, $matches );
		//		preg_match_all('\d+', $result, $matches);

		$sentences = $matches[1];
		unset($matches);
		$list      = array();
		foreach ($sentences as $sentence ) {
			$sentence = strip_tags($sentence, '<table><tbody><td><tr>');
			echo '<pre>';
			print_r( $sentence );
			echo '</pre>';
			preg_match_all( '/\d+\.?\d*/', $sentence, $matches );
			$list[] = $matches;
		}

		echo '<pre>';
		print_r( $list );
		echo '</pre>';


	?>
</div>
<?php get_footer(); ?>
<?php wp_footer(); ?>
