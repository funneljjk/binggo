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
			<ul class="header_ul_001">
				<li id="header_ul_li_001"><?php echo get_the_title()?></li>
				<?php if(get_the_ID() == '1091'):?>
				<li><button id="header_ul_li_002" onclick="changeExpert()">전문가 전환</button></li>
				<?php endif?>
				<li><a href="javascript:void(0)" data-bs-toggle="offcanvas" data-bs-target="#header_menu"><i class="fa">&#xf2bd;</i></a>&nbsp;</li>
				<li><a href="javascript:void(0)" onclick="aram()"><i class="fa">&#xf0a2;</i></a>&nbsp;</li>
			</ul>
		</div>
	</div>

	<!-- header_menu -->
	<div class="offcanvas offcanvas-end" id="header_menu">
		<div class="offcanvas-header">
			<h1 class="offcanvas-title"><i style="font-size:60px" class="fa">&#xf2bd;</i></h1>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
		</div>
		<div class="offcanvas-body">
			<p><a href="">회원정보</a></p>
			<p><a href="">공지사항/FAQ</a></p>
			<p><a href="">1대1 문의</a></p>
			<p><a href="">로그아웃</a></p>
		</div>
	</div>