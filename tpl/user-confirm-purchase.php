<?php
/**
 * Template Name: 고객 - 공사완료 확정
 */
?>

<?php include BG_THEME_DIR.'/include/header-sub.php'?>

<?php
$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;
$request = new Binggo_Request($request_id);
if(!$request->ID){
	echo '<script>';
	echo 'alert("잘못된 경로입니다.");';
	echo 'window.location.href="'.esc_url_raw(site_url()).'";';
	echo '</script>';
	exit;
}

$quotes_list = $request->get_quotes();

$quotes_id = $request->quotes_id;
$quotes = get_post($quotes_id);

$images          = $request->complete_images;
$complete_images = isset($images['complete']) ? $images['complete'] : array();

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
<form action="<?php echo esc_url(admin_url('admin-post.php'))?>" method="post" enctype="multipart/form-data" onsubmit="return submit_form();">
	<?php wp_nonce_field('binggo_security_'.$user->ID, 'binggo_nonce')?>
	<input type="hidden" name="action" value="binggo_user_construct_complete">
	<input type="hidden" id="user_id" name="user_id" value="<?php echo esc_attr($user->ID)?>">
	<input type="hidden" id="request_id" name="request_id" value="<?php echo esc_attr($request_id)?>">
	
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
						<i class="fa fa-star fa001"></i> 평점<span class="textNum002">(<?php echo esc_html($expert->star)?>)</span><br>
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
						<?php foreach($complete_images as $id):?>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
						</swiper-slide>
						<?php endforeach?>
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
					<?php echo wpautop($request->complete_content)?>
				</div>
				<!-- 전달내용  끝-->

			</div>
			<!-- 공사완료내역 -->

			<hr class="hr_001" style="margin-top:40px;">
			<!-- 리뷰작성 -->
			<div class="expert_profile_div_002">
				<div>
					<h5>리뷰 작성</h5>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>별점</h6>
					</div>
					<div>
						<select class="form-select form-select-sm" name="review[int][star]">
							<option value="" disabled selected>1~5점의 별점을 선택해 주세요.</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>내용</h6>
					</div>
					<div>
						<textarea class="form-control" rows="3" id="comment2" name="review[textarea][content]"></textarea>
					</div>
				</div>
				<div class="expert_profile_div_003 expert_profile_div_005">
					<div>
						사진
					</div>
					<div class="file-input-wrapper">
						<label for="customFileInput09" class="file-input-label" onclick="addImageField(this, 'review', 3, 'review_images[review][]')">
							<span class="file-input-icon">+</span>
						</label>
					</div>
					<div class="img_field_wrap">
						<?php foreach($request->review_images as $idx=>$id):?>
						<label>
							<input type="hidden" class="image_fields etc n<?php echo esc_attr($idx)?>" name="uploaded_review_images[review][]" value="<?php echo esc_attr($id)?>">
							<div class="file_input_img_wrapper">
								<img class="file_input_img" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
								<div class="delete-icon">×</div>
							</div>
						</label>
						<?php endforeach?>
					</div>
				</div>
			</div>
			<!-- 전달내용  끝-->

		</div>

		<!-- 하단 버튼 -->
		<div class="button_bottom_001">
			<button type="submit">작성완료</button>
		</div>

	</div>

	<!-- right space --> 
	<div class="div_003"></div>
	
</form>

	<!-- 파일 미리보기 모달창-->
	<div id="imageModal" class="modal002">
		<span class="close002">&times;</span>
		<img class="modal-content002" id="modalImage">
		<div id="caption"></div>
	</div>

<script>
//이미지 시작
function addImageField(obj, cls, lmt, name){
	var image_field = jQuery(".image_fields."+cls)
	if(image_field.length >= lmt){
		alert(lmt+'개 까지 선택 가능합니다.');
		return false;
	}
	
	var seq   = image_field.length + 1;
	var field = '<label>';
	field += '<input type="file" class="image_fields '+cls+' n'+seq+'" name="'+name+'" accept="image/*" hidden>';
	field += '<div class="file_input_img_wrapper"><img class="file_input_img" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt=""><div class="delete-icon">×</div></div>';
	field += '</label>';
	
	var wrap = jQuery(obj).parent().siblings(".img_field_wrap");
	
	jQuery(wrap).append(field);
	
	setTimeout(() => {
		jQuery(".image_fields."+cls+".n"+seq).click();
	});
	
	activteHandleImagePreview();
	expert_image_delete_icon();
}

function expert_image_delete_icon(){
	jQuery(".delete-icon").on("click", function(e){
		e.preventDefault();
		jQuery(this).parent().parent().remove();
	});
}

function activteHandleImagePreview(){
	jQuery(".image_fields").on("click", function(){
		var image_field = jQuery(this);
		var image       = image_field.siblings(".file_input_img_wrapper").find(".file_input_img");
		
		handleImagePreview(image_field, image);
	})
}

function handleImagePreview(inputElement, previewSelector){
	inputElement.on('change', function(){
		if (this.files && this.files[0]) {
			const fileInputImgs = jQuery(previewSelector);
			const availableImg = fileInputImgs.filter(function () {
				return !jQuery(this).data('used');
			}).first();
			
			if (availableImg.length) {
				const reader = new FileReader();
				
				reader.onload = function (e) {
					availableImg.attr('src', e.target.result);
					availableImg.data('used', true);
				};
				
				reader.readAsDataURL(this.files[0]);
			}
		}
	});

	inputElement.on('focus', function () {
		if (inputElement.val()) {
			inputElement.blur();
		}
	});
}

function createDeleteIcon(imgElement, inputElement) {
	const deleteIcon = jQuery('<div>', {
		class: 'delete-icon',
		html: '&times;'
	});
	
	deleteIcon.on('click', function () {
		imgElement.attr('src', '<?php echo BG_THEME_URL?>/img/ex_img.png');
		imgElement.data('used', false);
		deleteIcon.remove();
		inputElement.val('');
	});

	return deleteIcon;
}
//이미지 종료

jQuery(document).ready(function ($) {
	//파일 미리보기 모달창
	function openModalWithImage(src) {
		const modal = $('#imageModal');
		const modalImg = $('#modalImage');

		modalImg.attr('src', src);
		modal.show();
	}
	$('.file_input_img, .imgModal3').on('click', function () {
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
});
</script>

	<?php wp_footer()?>
</body>
</html>