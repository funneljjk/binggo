<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php wp_head()?>
</head>

<?php
$user = wp_get_current_user();
if(!$user->ID){
	echo '<script>';
	echo 'alert("로그인이 필요합니다.");';
	echo 'window.location.href="'.esc_url_raw(site_url()).'";';
	echo '</script>';
	exit;
}
?>

<body>
	<!-- contents -->
	<div class="div_002_01">
		<div class="header_div_001">
			<ul class="header_ul_002">
				<li><i class="material-icons backArrow">&#xe5c4;</i></li>
				<li><?php echo get_the_title()?></li>
				<li></li>
			</ul>
		</div>
	</div>