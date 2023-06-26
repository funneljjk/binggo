<?php
/**
 * Template Name: 고객 - 공사요청
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

$request_id = $quotes->post_parent;
$request    = new Binggo_Request($request_id);
if(!$request->ID){
	echo '<script>';
	echo 'alert("잘못된 경로입니다.");';
	echo 'window.location.href="'.esc_url_raw(site_url()).'";';
	echo '</script>';
	exit;
}

$biz_name     = get_user_meta($user->ID, 'biz_name', true);
$biz_number   = get_user_meta($user->ID, 'biz_number', true);
$biz_ceo      = get_user_meta($user->ID, 'biz_ceo', true);
$biz_type     = get_user_meta($user->ID, 'biz_type', true);
$biz_category = get_user_meta($user->ID, 'biz_category', true);
$addr         = get_user_meta($user->ID, 'addr', true);
$tax_email    = get_user_meta($user->ID, 'tax_email', true);
?>

<form action="<?php echo esc_url(admin_url('admin-post.php'))?>" method="post" enctype="multipart/form-data">
	<?php wp_nonce_field('binggo_security_request_'.$user->ID, 'binggo_nonce')?>
	<input type="hidden" name="action" value="binggo_user_quotes_construct_request">
	<input type="hidden" id="user_id" name="user_id" value="<?php echo esc_attr($user->ID)?>">
	<input type="hidden" id="request_id" name="request_id" value="<?php echo esc_attr($request_id)?>">
	<input type="hidden" id="quotes_id" name="quotes_id" value="<?php echo esc_attr($quotes_id)?>">
	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<div class="div_004">

			<!-- 요청내역 -->
			<div class="expert_profile_div_002" style="margin-top:80px;">
				<div>
					<h5>요청 내역</h5>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>설치 지역</h6>
					</div>
					<div>
						<div><?php echo esc_html($request->location.' '.$request->location2.' '.$request->location3)?></div>
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>서비스</h6>
					</div>
					<div>
						<div><?php echo esc_html($request->construct_industry)?></div>
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>공사 일정</h6>
					</div>
					<div>
						<div><?php echo esc_html("{$request->start_date}~{$request->end_date}")?></div>
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>요청 사항</h6>
					</div>
					<div>
						<?php echo wpautop($request->post_content)?>
					</div>
				</div>
				<div class="expert_profile_div_002" style="margin-top:8px;">
					<div>
						<h6>현장사진</h6>
					</div>
					<div style="margin-left: -20px; margin-right:-20px; overflow:hidden;">
						<swiper-container class="mySwiper" pagination-clickable="true" space-between="0"
						slides-per-view="5" free-mode="true" pagination="false" >

							<!-- 반복문 -->
							<?php if($request->scene && is_array($request->scene)):?>
							<?php foreach($request->scene as $idx=>$id):?>
							<swiper-slide>
								<img class="imgModal3" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
							</swiper-slide>
							<?php endforeach?>
							<?php endif?>
							<!-- 반복문 끝 -->

							<swiper-slide></swiper-slide>
							<swiper-slide></swiper-slide>
						</swiper-container>
					</div>
				</div>
				<div class="expert_profile_div_002" style="margin-top:20px;">
					<div>
						<h6>도면사진</h6>
					</div>
					<div style="margin-left: -20px; margin-right:-20px; overflow:hidden;">
						<swiper-container class="mySwiper" pagination-clickable="true" space-between="0"
						slides-per-view="5" free-mode="true" pagination="false" >

							<!-- 반복문 -->
							<?php if($request->floor_plan && is_array($request->floor_plan)):?>
							<?php foreach($request->floor_plan as $idx=>$id):?>
							<swiper-slide>
								<img class="imgModal3" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
							</swiper-slide>
							<?php endforeach?>
							<?php endif?>
							<!-- 반복문 끝 -->

							<swiper-slide></swiper-slide>
							<swiper-slide></swiper-slide>
						</swiper-container>
					</div>
				</div>
				<div class="expert_profile_div_002" style="margin-top:20px;">
					<div>
						<h6>추가/기타 사진</h6>
					</div>
					<div style="margin-left: -20px; margin-right:-20px; overflow:hidden;">
						<swiper-container class="mySwiper" pagination-clickable="true" space-between="0"
						slides-per-view="5" free-mode="true" pagination="false" >

							<!-- 반복문 -->
							<?php if($request->etc && is_array($request->etc)):?>
							<?php foreach($request->etc as $idx=>$id):?>
							<swiper-slide>
								<img class="imgModal3" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
							</swiper-slide>
							<?php endforeach?>
							<?php endif?>
							<!-- 반복문 끝 -->

							<swiper-slide></swiper-slide>
							<swiper-slide></swiper-slide>
						</swiper-container>
					</div>
				</div>
			</div>
			<!-- 요청내역  끝 -->


			<hr class="hr_001" style="margin-top:40px;">
			<!-- 견적 정보 -->
			<div class="expert_profile_div_002 user_quotes_detail_div_001">
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

			<hr class="hr_001" style="margin-top:40px;">
			<div class="expert_profile_div_002">
				<div>
					<h5>결제 금액</h5>
				</div>
				<div style="text-align: center;">
					<h2>총 <span><?php echo number_format($option_sum)?></span>원</h2>
				</div>
			</div>
			<hr class="hr_001" style="margin-top:40px;">
			<div class="expert_profile_div_002">
				<div>
					<h5>계좌 정보</h5>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>은행</h6>
					</div>
					<div>
						<div><?php echo esc_html($expert->bank)?></div>
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>예금주</h6>
					</div>
					<div>
						<div><?php echo esc_html($expert->bank_owner)?></div>
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>계좌번호</h6>
					</div>
					<div>
						<div><?php echo esc_html($expert->bank_account)?></div>
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>지급조건</h6>
					</div>
					<div>
						<div>선금 100%</div>
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>계산서 요청</h6>
					</div>
					<div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio1" name="user_construct_request[string][tax]" value="현금영수증" required>
							<label class="form-check-label" for="radio1">현금영수증</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio2" name="user_construct_request[string][tax]" value="세금계산서" checked>
							<label class="form-check-label" for="radio2">세금계산서</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio3" name="user_construct_request[string][tax]" value="미발행">
							<label class="form-check-label" for="radio3">미발행</label>
						</div>
						<input type="number" class="form-control form-control-sm hiddenInput001" name="user_construct_request[string][billing_phone]"  placeholder="핸드폰번호를 입력하세요." style="display:none;" value="<?php echo esc_html($request->billing_phone)?>">
						
						<input type="text" class="form-control form-control-sm hiddenInput002" name="user_construct_request[string][biz_name]"  placeholder="회사명(법인명)" value="<?php echo esc_attr($biz_name)?>" required>
						<input type="number" class="form-control form-control-sm hiddenInput002" name="user_construct_request[string][biz_number]"  placeholder="사업자등록번호" value="<?php echo esc_attr($biz_number)?>" required>
						<input type="text" class="form-control form-control-sm hiddenInput002" name="user_construct_request[string][biz_ceo]"  placeholder="대표자명" value="<?php echo esc_attr($biz_ceo)?>" required>
						<input type="text" class="form-control form-control-sm hiddenInput002" name="user_construct_request[string][biz_type]"  placeholder="업태"  value="<?php echo esc_attr($biz_type)?>" required>
						<input type="text" class="form-control form-control-sm hiddenInput002" name="user_construct_request[string][biz_category]"  placeholder="종목" value="<?php echo esc_attr($biz_category)?>" required>
						<input type="text" class="form-control form-control-sm hiddenInput002" name="user_construct_request[string][addr]"  placeholder="사업장주소" value="<?php echo esc_attr($addr)?>" required>
						<input type="email" class="form-control form-control-sm hiddenInput002"  name="user_construct_request[string][tax_email]" placeholder="세금계산서 이메일" value="<?php echo esc_attr($tax_email)?>" required>
					</div>
				</div>
			</div>
		</div>

		<!-- 하단 버튼 -->
		<div class="button_bottom_001">
			<button type="submit">요청완료</button>
		</div>

	</div>

	<!-- right space -->
	<div class="div_003"></div>
</form>
	
<script>
jQuery(document).ready(function($){
	$('#radio1').click(function() {
		$('.hiddenInput001').show();
		$('.hiddenInput001').attr("required", true);
		$('.hiddenInput002').hide();
		$('.hiddenInput002').attr("required", false);
	});
	$('#radio2').click(function() {
		$('.hiddenInput001').hide();
		$('.hiddenInput001').attr("required", false);
		$('.hiddenInput002').show();
		$('.hiddenInput002').attr("required", true);
	});
	$('#radio3').click(function() {
		$('.hiddenInput001').hide();
		$('.hiddenInput001').attr("required", false);
		$('.hiddenInput002').hide();
		$('.hiddenInput002').attr("required", false);
	});
});
</script>

<?php wp_footer()?>
</body>
</html>