<?php
	get_header();
	wp_head();

	?>
	<div class="container">
		<?php

			the_title();
			the_content();

		?>
	</div>



<?php

	get_footer();
	wp_footer();
