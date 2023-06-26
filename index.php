<?php if(!defined('ABSPATH')) exit;?>

<?php
get_header();

ob_start();
?>

<div id="content">
	<?php
	if (have_posts()) :
		while (have_posts()) :
			the_post();
			the_content();
		endwhile;
	endif;
	?>
</div>

<?php
echo apply_filters('the_content', ob_get_clean());

get_footer();
?>