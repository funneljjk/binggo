<?php if(!defined('ABSPATH')) exit;?>

<?php include BG_THEME_DIR.'/include/header-sub.php';?>

<section class="woocommerce">
	
	<!-- left space -->
	<div class="div_001"></div>
	
	<!-- contents -->
	<div class="div_002">
		<?php woocommerce_content()?>
	</div>
	
	<!-- right space -->
	<div class="div_003"></div>
</section>

<?php wp_footer()?>
</body>
</html>