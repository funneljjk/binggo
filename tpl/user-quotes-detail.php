<?php
/**
 * Template Name: 고객 - 견적 상세보기
 */
?>

<?php include BG_THEME_DIR.'/include/header-sub.php'?>

<?php
$quotes_id = isset($_GET['quotes_id']) ? intval($_GET['quotes_id']) : 0;
$quotes = get_post($quotes_id);
if($quotes->post_type != 'expert_quotes'){
	echo '<script>';
	echo 'alert("잘못된 경로입니다.");';
	echo 'window.location.href="'.esc_url_raw(site_url()).'";';
	echo '</script>';
	exit;
}

global $wpdb;

$expert = new Experts($quotes->post_author);

$options    = get_post_meta($quotes_id, 'option', true);
$option_sum = $wpdb->get_var("SELECT SUM(`meta_value`) FROM `wp_postmeta` WHERE `post_id` = {$quotes_id} AND `meta_key` LIKE 'price'");
$option_sum = $option_sum ? $option_sum : 0;

$arr = array(
	'action'       => 'binggo_user_quotes_check',
	'user_id'      => $user->ID,
	'binggo_nonce' => wp_create_nonce('binggo_security_quotes_'.$user->ID),
	'quotes_id'    => $quotes_id,
);
$construct_request_url = add_query_arg($arr, admin_url('admin-post.php'));
?>

	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<div class="div_004">

		<!-- 견적 정보 -->
		<div class="expert_profile_div_002 user_quotes_detail_div_001 modalView" style="margin-top: 80px;">
			<div>
				<h5>견적 정보</h5>
			</div>
			<div class="expert_profile_div_003">
				<div>
					<?php if($expert->logo):?>
						<?php foreach($expert->logo as $idx=>$id):?>
						<img src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="" style="width: calc(100% - 10px);">
						<?php endforeach?>
					<?php else:?>
						<img src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="" style="width: calc(100% - 10px);">
					<?php endif?>
				</div>
				<div>
					<h6><?php echo esc_html($expert->first_name)?> <?php if($expert->is_expert_confirm):?><img src="<?php echo BG_THEME_URL?>/img/certificationExpert.png" alt="인증된전문가" width="15px" style="vertical-align:top;"><?php endif?><br>
					<i class="fa fa-star fa001"></i> 평점<span class="textNum002">(<?php echo esc_html($star)?>)</span><br>
					고용 <?php echo number_format($hire_count)?>회 | 경력 <?php echo number_format($career)?>년<br>
					견적서등록 날짜 <?php echo date('Y-m-d', strtotime($quotes->post_date))?>
				</div>
			</div>
			<hr class="hr_001">

				<!-- 반복문 -->
				<?php foreach($options as $option):?>
				<div class="expert_profile_div_003 expert_profile_div_004">
					<div>
					</div>
					<div>
						<?php echo esc_html($option['option_name'])?>
					</div>
					<div>
						<?php echo number_format($option['option_price'])?>원
					</div>
				</div>
				<?php endforeach?>
				<!-- 반복문 끝 -->

				<div class="expert_profile_div_003 expert_profile_div_004">
					<div>
					</div>
					<div>
						<h6>총 견적 금액</h6>
					</div>
					<div>
						<h6><?php echo number_format($option_sum)?>원</h6>
					</div>
				</div>
				<hr class="hr_001">

				<div class="expert_profile_div_003">
					<div>
					</div>
					<div>
						<h6>견적 설명</h6>
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
					</div>
					<div>
						<?php echo wpautop($quotes->post_content)?>
					</div>
				</div>
		</div>
		<!-- 견적 정보 -->

		<?php if($expert->portfolio):?>
		<!-- 포트폴리오 -->
		<div class="expert_profile_div_002" style=" margin-left:-20px; margin-right:-20px; overflow: hidden;">
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
							<div style="text-align: right;"><a href="<?php echo add_query_arg('portfolio_id', $item->ID, site_url('/전문가-포트폴리오-작성-수정/'))?>">수정</a></div>
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
			   <a href="<?php echo add_query_arg('user_id', $expert->id, site_url('/전문가-리뷰-확인하기/'))?>">더보기<i class="material-icons">&#xe313;</i></a>
			</div>
		</div>
		<!-- 리뷰 끝-->


		 <!-- 전문가 정보 -->
		 <div class="expert_profile_div_002">
			<div>
				<h5>전문가 정보</h5>
			</div>

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
		<!-- 사진  끝-->

		<!-- 하단 버튼 -->
		<!-- <div class="button_bottom_001">
			<div>
				<a href=""><button>공사 요청</button></a>
			</div>
		</div> -->
		<div class="button_bottom_001 button_bottom_002">
			<a href="tel:<?php echo esc_html($expert->billing_phone)?>"><button style="background-color: white; color:black; box-shadow: 0 0 10px 5px rgba(0, 0, 0, 0.05); width: calc(100% - 10px); ">문의</button></a>
			<a href="<?php echo esc_url($construct_request_url)?>"><button>공사 요청</button></a>
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

<script>
//파일 미리보기 모달창
function openModalWithImage(src) {
	const modal = $('#imageModal');
	const modalImg = $('#modalImage');

	modalImg.attr('src', src);
	modal.show();
}

jQuery(document).ready(function ($) {
	$('.imgModal2, .imgModal3').on('click', function () {
		openModalWithImage($(this).attr('src'));
	});

	$('.close002').on('click', function () {
		$('#imageModal').hide();
	});

	jQuery(document).on('click', function (event) {
		if ($(event.target).is('#imageModal')) {
			$('#imageModal').hide();
		}
	});

	//하트 평점에 맞춰 색상 변경
	jQuery(document).ready(function($) {
		const reviewNum = parseFloat($(".reviewNum").text());
		const fullStars = Math.floor(reviewNum);
		const decimal = reviewNum % 1;
		const stars = $(".fa002");

		stars.each(function(index) {
			if (index < fullStars) {
			$(this).addClass("gold001");
			} else if (decimal > 0.0 && decimal < 0.5 && index === fullStars) {
			$(this).addClass("half001");
			} else if (decimal >= 0.5 && index === fullStars) {
			$(this).addClass("gold001");
			}
		});
	});

	//리뷰 더보기 버튼
	$('.moreText001').on('click', function() {
		var $manual = $(this).closest('li').find('.manual001');
		var $more = $(this);

		if ($manual.css('-webkit-line-clamp') === '1') {
			$manual.css({
				'-webkit-line-clamp': 'unset',
				'overflow': 'visible',
			});
			$more.text('숨기기');
		} else {
			$manual.css({
				'-webkit-line-clamp': '1',
				'overflow': 'hidden',
			});
			$more.text('더보기');
		}
	});
});
</script>

<?php wp_footer()?>
</body>
</html>