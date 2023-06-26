<?php
/**
 * Template Name: 전문가 - 공사완료 상세내역
 */
?>

<?php include BG_THEME_DIR.'/include/header-sub.php'?>

<?php
$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;
$request    = new Binggo_Request($request_id);


?>
	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">

		<div class="div_004">

			<!-- 견적 정보 -->  
			<div class="expert_profile_div_002" style="margin-top: 80px;">
				<div>
					<h5>견적 정보</h5>
				</div>
				<!-- <div class="expert_profile_div_003">
					<div>
						<img src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="" style="width: calc(100% - 10px);">
					</div>
					<div>
						<h6>전문가명<img src="<?php echo BG_THEME_URL?>/img/certificationExpert.png" alt="인증된전문가" width="15px" style="vertical-align:top;"></h6>
						<i class="fa fa-star fa001"></i> 평점<span class="textNum002">(겟수)</span><br>
						고용 500회 | 경력 15년<br>
						견적서등록 날짜
					</div>
				</div>
				<hr class="hr_001"> -->

				<!-- 반복문 -->
				<div class="expert_profile_div_003">
					<div>
						옵션 1
					</div>
					<div style="text-align: right;">
						2,000,000원
					</div>
				</div>    
				<div class="expert_profile_div_003">
					<div>
						옵션 2
					</div>
					<div style="text-align: right;">
						2,000,000원
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						옵션 3
					</div>
					<div style="text-align: right;">
						2,000,000원
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						옵션 4
					</div>
					<div style="text-align: right;">
						2,000,000원
					</div>
				</div>
				<!-- 반복문 끝 -->


				<div class="expert_profile_div_003">
					<div>
						<h6>총 견적 금액</h6>
					</div>
					<div style="text-align: right;">
						<h6>8,000,000원</h6>
					</div>
				</div>
				<hr class="hr_001">
				<div class="expert_profile_div_003">
					<div>
						견적설명
					</div>
					<div>
						견적설명, 견적설명, 견적설명, 견적설명, 견적설명, 견적설명, 견적설명, 견적설명, 견적설명, 견적설명, 견적설명, 견적설명, 견적설명, 견적설명, 견적설명, 견적설명, 견적설명
					</div>
				</div>

			</div>
			<!-- 견적 정보 -->
			<hr class="hr_001" style="margin-top:40px;">
			<!-- 공사완료내역 -->
			<div class="expert_profile_div_002">
				<div>
					<h5>공사완료내역</h5>
				</div>
				<!-- 사진 및 동영상 -->
				<div>
					<h6>사진 및 영상</h6>
				</div>
				<div style="margin-left: -20px; margin-right:-20px; overflow:hidden;">
					<swiper-container class="mySwiper" pagination-clickable="true" space-between="0"
					slides-per-view="5" free-mode="true" pagination="false" >

						<!-- 반복문 -->
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<!-- 반복문 끝 -->

						<swiper-slide></swiper-slide>
						<swiper-slide></swiper-slide>
					</swiper-container>
				</div>
				<!-- 사진 및 동영상  끝-->

			</div>

			<div class="expert_profile_div_003">
				<!-- 전달내용 -->
				<div>
					<h6>전달내용</h6>
				</div>
				<div>
					<div>전달내용, 전달내용, 전달내용, 전달내용, 전달내용, 전달내용, 전달내용, 전달내용, 전달내용, 전달내용, 전달내용, 전달내용, 전달내용, 전달내용, 전달내용, 전달내용</div>
				</div>
				<!-- 전달내용  끝-->

			</div>
			<!-- 공사완료내역 -->

			<hr class="hr_001" style="margin-top:40px;">
			<!-- 리뷰작성 -->
			<div class="expert_profile_div_002">
				<div>
					<h5>리뷰 내역</h5>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>별점</h6>
					</div>
					<div>
						<span>5</span>점
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>내용</h6>
					</div>
					<div>
						내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용, 내용
					</div>
				</div>

				<!-- 사진 -->
				<div>
					<h6>사진</h6>
				</div>
				<div style="margin-left: -20px; margin-right:-20px; overflow:hidden;">
					<swiper-container class="mySwiper" pagination-clickable="true" space-between="0"
					slides-per-view="5" free-mode="true" pagination="false" >

						<!-- 반복문 -->
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
						</swiper-slide>
						<!-- 반복문 끝 -->

						<swiper-slide></swiper-slide>
						<swiper-slide></swiper-slide>
					</swiper-container>
				</div>
				<!-- 사진 끝-->
			</div>
			<!-- 전달내용  끝-->

		</div>

	</div>
	 
	<!-- right space -->
	<div class="div_003"></div>
	
	<?php wp_footer()?>
</body>
</html>