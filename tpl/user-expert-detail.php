<?php
/**
 * Template Name: 고객 - 전문가 프로필 상세보기
 */
?>

<?php include BG_THEME_DIR.'/include/header-sub.php'?>

<?php
$expert_id = isset($_GET['expert_id']) ? intval($_GET['expert_id']) : 0;
$is_expert = get_user_meta($expert_id, 'is_expert', true);
if(!$is_expert){
	echo '<script>';
	echo 'alert("잘못된 경로입니다.");';
	echo 'window.location.href="'.esc_url_raw(site_url()).'";';
	echo '</script>';
	exit;
}

$expert = new Experts($expert_id);
?>
<section class="user_expert_detail">
	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<div class="expert_profile_div_001">
			<div>
				<?php if($expert->logo):?>
					<?php foreach($expert->logo as $idx=>$id):?>
					<img class="expert_profile_img_001" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="" width="100px">
					<?php endforeach?>
				<?php else:?>
					<img class="expert_profile_img_001" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="" width="100px">
				<?php endif?>
				<h4><?php echo esc_html($expert->first_name)?> <?php if($is_expert_confirm):?><img src="<?php echo BG_THEME_URL?>/img/certificationExpert.png" alt="인증된전문가" width="15px" style="vertical-align:top;"><?php endif?></h4>
				<?php echo esc_html(implode(', ', $expert->location))?>
			</div>
		</div>

		<!-- 포트폴리오 --><!-- 등록된 포폴이 없으면 안보이게 처리 -->
		<?php if($expert->portfolio):?>
		<div class="expert_profile_div_002 user_expert_detail_div_001" style=" margin-left:-20px; margin-right:-20px; overflow: hidden;">
			<swiper-container class="mySwiper" pagination-clickable="true" space-between="0"
			slides-per-view="2" pagination="false" >
			<!-- 반복문 -->
				<?php foreach($expert->portfolio as $item):
					$location           = get_post_meta($item->ID, 'location', true);
					$price              = get_post_meta($item->ID, 'price', true);
					$work_time          = get_post_meta($item->ID, 'work_time', true);
					$work_time_criteria = get_post_meta($item->ID, 'work_time_criteria', true);
					$worked_date        = get_post_meta($item->ID, 'worked_date', true);
					
					$construction       = get_post_meta($item->ID, 'construction', true);
					$business           = get_post_meta($item->ID, 'business', true);
					$portfolio_images   = get_post_meta($item->ID, 'portfolio_images', true);
					
					$price        = $price        ? $price        : 0;
					$business     = $business     ? $business     : array('-');
					$construction = $construction ? $construction : array('-');
					
					$thumbnail = isset($portfolio_images['thumbnail']) ? $portfolio_images['thumbnail'] : array();
					$images    = isset($portfolio_images['images'])    ? $portfolio_images['images']    : array();
				?>
				<swiper-slide>
					<div class="expert_profile_div_006">
						<div>
							<div><h6><?php echo esc_html($item->post_title)?></h6></div>
						</div>
						<div>
							<?php if($thumbnail):?>
								<?php foreach($thumbnail as $id):?>
								<img class="imgModal2" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
								<?php endforeach?>
							<?php else:?>
							<img class="imgModal2" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="">
							<?php endif?>
						</div>
						<div>
							<ul>
								<li>시공형태</li>
								<li>사업장</li>
								<li>시공비</li>
								<li>지역정보</li>
								<li>작업소요시간</li>
								<li>작업년도</li>
							</ul>
							<ul>
								<li><?php echo esc_html(implode(', ', $construction))?></li>
								<li><?php echo esc_html(implode(', ', $business))?></li>
								<li><?php echo esc_html(number_format($price))?>원</li>
								<li><?php echo esc_html($location)?></li>
								<li><?php echo esc_html($work_time.$work_time_criteria)?></li>
								<li><?php echo esc_html($worked_date)?></li>
							</ul>
						</div>
						<?php if($images):?>
						<div>
							<?php foreach($images as $id):?>
							<img class="imgModal2" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="" width="100%">
							<?php endforeach?>
						</div>
						<?php endif?>
					</div>
				</swiper-slide>
				<?php endforeach?>
				<!-- 반복문 끝 -->
				<swiper-slide></swiper-slide>
			</swiper-container>
		</div>
		<?php endif?>
		<!-- 포트폴리오  끝-->


		<!-- 리뷰 -->
		<div class="expert_profile_div_002">
			<div>
				<h5>리뷰</h5>
			</div>
			<div>
				<h6>
					<span class="reviewNum" style="font-size: 20px;">4.1</span> 
					<i class="fa fa-star fa002"></i>
					<i class="fa fa-star fa002"></i>
					<i class="fa fa-star fa002"></i>
					<i class="fa fa-star fa002"></i>
					<i class="fa fa-star fa002"></i>
				</h6>
			</div>
			<div style="padding: 10px ; width:100%; overflow:auto; background-color:#F1F1F5;">

				<!-- 반복 구간 시작 -->
				<?php for($i=1; $i<3; $i++):?>
				<ul class="user_expert_list_ul_001">
					<li style="position:relative">
						<img src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="" width="100%">
					</li>
					<li>
						<h6>
							<span style="float:left">지역, 시공형태</span>
							<span class="moreText001">더보기</span>
						</h6>
						<div style="clear:both;">
							<i class="fa fa-star fa001"></i>평점<br>
							날짜<br>
							<span class="manual001">설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란,
							설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란, 설명란
							</span>
						</div>
					</li>
				</ul>
				<hr class="hr_001">
				<?php endfor?>
				</ul>
				<!-- 반복 구간 끝 5개 까지만 보여준다 -->

			</div>

			<div class="moreThan001">
			   <a href="/전문가-리뷰-확인하기">더보기<i class="material-icons">&#xe313;</i></a>
			</div>
		</div>
			<!-- 리뷰 끝-->


		<!-- 전문가 정보 -->
		<div class="expert_profile_div_003">
			<div>
				전문가명
			</div>
			<div>
				<?php echo esc_html($expert->first_name)?>
			</div>
		</div>
		<div class="expert_profile_div_003">
			<div>
				서비스지역
			</div>
			<div>
				<?php echo $expert->location ? esc_html(implode(', ', $expert->location)) : ''?>
			</div>
		</div>
		<div class="expert_profile_div_003">
			<div>
				지원서비스
			</div>
			<div>
			<?php echo $expert->available_service ? esc_html(implode(', ', $expert->available_service)) : ''?>
			</div>
		</div>
		<div class="expert_profile_div_003">
			<div>
				경력
			</div>
			<div>
				<?php echo esc_html($expert->career)?>년
			</div>
		</div>
		<div class="expert_profile_div_003">
			<div>
				고용
			</div>
			<div>
				<?php echo esc_html($expert->hire_count)?>번
			</div>
		</div>
		<div class="expert_profile_div_003">
			<div>
				직원수
			</div>
			<div>
			<?php echo esc_attr($expert->staff)?>명
			</div>
		</div>
		<div class="expert_profile_div_003">
			<div>
				서비스설명
			</div>
			<div>
				<?php echo wpautop($expert->service_description)?>
			</div>
		</div>
		<!-- 전문가 정보 끝 -->

		<!-- 사진 -->
		<?php if($expert->images && is_array($expert->images)):?>
		<div class="expert_profile_div_002">
			<div>
				<h5>사진</h5>
			</div>
			<div style="margin-left: -20px; margin-right:-20px; overflow:hidden;">
				<swiper-container class="mySwiper" pagination-clickable="true" space-between="0"
				slides-per-view="5" free-mode="true" pagination="false" >
					<!-- 반복문 -->
					<?php foreach($expert->images as $id):?>
					<swiper-slide>
						<img class="imgModal3" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
					</swiper-slide>
					<!-- 반복문 끝 -->
					<?php endforeach?>
					
					<swiper-slide></swiper-slide>
					<swiper-slide></swiper-slide>
				</swiper-container>
			</div>
		</div>
		<?php endif?>
		<!-- 사진 끝-->

		<!-- 하단 버튼 -->
		<div class="button_bottom_001">
			<div>
				<div class="user_expert_detail_div_002">
					<i class="fa fa-heart heartBtn2" onclick="toggleHeartColor(this)" style="color:#ededed;"></i>
				</div>
			</div>
			<div>
				<a href="<?php echo add_query_arg('expert_id', $expert_id, site_url('/고객-의뢰서-작성/'))?>"><button>의뢰 요청하기</button></a>
			</div>
		</div>
	</div>

	<!-- right space -->
	<div class="div_003"></div>

	<!-- 이미지 미리보기 모달창-->
	<div id="imageModal" class="modal002">
		<span class="close002">&times;</span>
		<img class="modal-content002" id="modalImage">
		<div id="caption"></div>
	</div>
	
</section>

<script>
	//파일 미리보기 모달창
function openModalWithImage(src) {
	const modal = jQuery('#imageModal');
	const modalImg = jQuery('#modalImage');

	modalImg.attr('src', src);
	modal.show();
}

//하트 평점에 맞춰 색상 변경
jQuery(document).ready(function() {
	const reviewNum = parseFloat(jQuery(".reviewNum").text());
	const fullStars = Math.floor(reviewNum);
	const decimal = reviewNum % 1;
	const stars = jQuery(".fa002");

	stars.each(function(index) {
		if (index < fullStars) {
		jQuery(this).addClass("gold001");
		} else if (decimal > 0.0 && decimal < 0.5 && index === fullStars) {
		jQuery(this).addClass("half001");
		} else if (decimal >= 0.5 && index === fullStars) {
		jQuery(this).addClass("gold001");
		}
	});
	
	jQuery('.imgModal2, .imgModal3').on('click', function () {
		openModalWithImage(jQuery(this).attr('src'));
	});

	jQuery('.close002').on('click', function () {
		jQuery('#imageModal').hide();
	});

	jQuery(document).on('click', function (event) {
		if (jQuery(event.target).is('#imageModal')) {
			jQuery('#imageModal').hide();
		}
	});

	//리뷰 더보기 버튼
	jQuery('.moreText001').on('click', function() {
		var manual = jQuery(this).closest('li').find('.manual001');
		var more = jQuery(this);

		if (manual.css('-webkit-line-clamp') === '1') {
			manual.css({
				'-webkit-line-clamp': 'unset',
				'overflow': 'visible',
			});
			more.text('숨기기');
		} else {
			manual.css({
				'-webkit-line-clamp': '1',
				'overflow': 'hidden',
			});
			more.text('더보기');
		}
	});
});
</script>

	<?php wp_footer()?>
</body>
</html>