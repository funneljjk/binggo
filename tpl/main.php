<?php
/**
 * Template Name: 로그인/회원가입
 */
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<?php wp_head()?>
	<title>로그인/회원가입</title>
</head>

<body class="index_001">
	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<div class="index_div_001">
			<div>
				<h1>손해 없이 수리하고<br>1년 보증까지</h1> 
			</div>
			<div>
				<img src="<?php echo BG_THEME_URL?>/img/repair.png" alt="예시 이미지 " width="60%">
			</div>
			<div>
				<button><img src="<?php echo BG_THEME_URL?>/img/google_logo001.png" alt="" width="20px"> Google로 계속하기</button>
				<a href="https://binggo.funnelmoa.com/?action=cosmosfarm_members_social_login&amp;channel=kakao&amp;redirect_to=%2F" title="kakao">
					<button>
						<img src="<?php echo BG_THEME_URL?>/img/kakao_logo001.png" alt="kakao"> Kakao로 계속하기
					</button>
				</a>
				<button><img src="<?php echo BG_THEME_URL?>/img/naver_logo001.png" alt="" width="20px"> Naver로 계속하기</button>
			</div>
		</div>
	</div>

	<!-- right space -->
	<div class="div_003"></div>
	
	<script>
	jQuery(document).ready(function($){
		$('.index_div_001 button').on('click', function(){
			window.location.href = '/고객-메인';
		})
	})
	</script>
	
	<?php wp_footer()?>
</body>
</html>