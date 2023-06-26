<?php
/**
 * Template Name: 약관 동의
 */
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<?php wp_head()?>
</head>


<body class="accept_terms">
	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<i class="material-icons backArrow">&#xe5c4;</i>

		<div class="accept_terms_div_001">
			<div>
				<h2>약관의 동의 하시고<br>믿고 안전하게 공사하세요!</h2>
			</div>
			<div>
				<input type="checkbox" id="fullTerms">
				<label for="fullTerms">전체 약관에 동의 합니다.</label>
			</div>
			<div>
				<ul>
					<li><i class="material-icons">&#xe5ca;</i><span>개인정보 수집 및 이용 동의(필수)</span><a class="" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#myModal">보기</a></li>
					<li><i class="material-icons">&#xe5ca;</i><span>사용자 이용약관(필수)</span><a class="" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#myModal02">보기</a></li>
					<li><i class="material-icons">&#xe5ca;</i><span>위치정보 서비스 이용약관(필수)</span><a class="" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#myModal03">보기</a></li>
					<li><i class="material-icons">&#xe5ca;</i><span>만 14세 이상입니다(필수)</span></li>
				</ul>
			</div>
			<div>
				<div>
					<button>동의하고 가입하기</button>
				</div>
			</div>
		</div>

	</div>

	<!-- right space -->
	<div class="div_003"></div>

	<!-- The Modal 1 -->
	<div class="modal" id="myModal">
		<div class="modal-dialog modal-dialog-scrollable"> 
			<div class="modal-content">
		
				<!-- Modal Header -->
				<div class="modal-header">
				<h4 class="modal-title">개인정보 수집 및 이용 동의</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
		
				<!-- Modal body -->
				<div class="modal-body">
					<p>내용</p>
				</div>
		
			</div>
		</div>
	</div>

	<!-- The Modal 2 -->
	<div class="modal" id="myModal02">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
		
				<!-- Modal Header -->
				<div class="modal-header">
				<h4 class="modal-title">사용자 이용약관</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
		
				<!-- Modal body -->
				<div class="modal-body">
					<p>내용</p>
				</div>
		
			</div>
		</div>
	</div>

	<!-- The Modal 3 -->
	<div class="modal" id="myModal03">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
		
				<!-- Modal Header -->
				<div class="modal-header">
				<h4 class="modal-title">위치정보 서비스 이용약관</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
		
				<!-- Modal body -->
				<div class="modal-body">
					<p>내용</p>
				</div>
		
			</div>
		</div>
	</div>
	
	<script>
		jQuery(document).ready(function($) {
			$('.div_002 button').on('click', function(){
				window.location.href = '/고객-메인';
			})
		});
	</script>
	
	<?php wp_footer()?>
</body>
</html>