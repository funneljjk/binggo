<?php
/**
 * Template Name: 전문가 - 공사완료 요청
 */
?>

<?php include BG_THEME_DIR.'/include/header-sub.php'?>

<?php
global $wpdb;

$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;
$request    = new Binggo_Request($request_id);
if(!$request->ID){
	$url = site_url();
	if(get_user_meta($user->ID, 'is_expert', true)){
		$url = site_url('/전문가-메인/');
	}
	
	echo '<script>';
	echo 'alert("잘못된 경로입니다.");';
	echo 'window.location.href="'.esc_url_raw($url).'";';
	echo '</script>';
	exit;
}

$re_construct_images = $request->re_construct_images ? $request->re_construct_images['re_construct'] : array();
?>

<form action="<?php echo esc_url(admin_url('admin-post.php'))?>" method="post" enctype="multipart/form-data" onsubmit="return submit_form();">
	<?php wp_nonce_field('binggo_security_'.$user->ID, 'binggo_nonce')?>
	<input type="hidden" name="action" value="binggo_expert_complete">
	<input type="hidden" id="user_id" name="user_id" value="<?php echo esc_attr($user->ID)?>">
	<input type="hidden" id="request_id" name="request_id" value="<?php echo esc_attr($request_id)?>">
	<input type="hidden" id="expert_id" name="expert_id" value="<?php echo esc_attr($request->expert_id)?>">
	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<div class="div_004">
		
			<?php if($request->request_status == 'construct_start'):?>
				
			<!-- 요청내역 -->
			<div class="expert_profile_div_002" style="margin-top: 80px;">
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
				<div class="expert_profile_div_002" style="margin-top:20px;">
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

			<?php elseif(in_array($request->request_status, array('re_construct_start', 'as_start'))):?>
			
			<?php foreach($request->re_construct_request as $idx=>$item):?>
			<div class="expert_profile_div_002">
				<div>
					<h5>재시공/A/S 요청 내역</h5>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>요청 제목</h6>
					</div>
					<div>
						<?php echo esc_html($item['title'])?>
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>요청 사유</h6>
					</div>
					<div>
						<?php echo wpautop($item['content'])?>
					</div>
				</div>
			</div>
			<?php endforeach?>
			
			<?php if($re_construct_images):?>
			<div class="expert_profile_div_002" style="margin-top: 8px;">
				<div>
					<h6>사진</h6>
				</div>
				<div style="margin-left: -20px; margin-right:-20px; overflow:hidden;">
					<swiper-container class="mySwiper" pagination-clickable="true" space-between="0"
					slides-per-view="5" free-mode="true" pagination="false" >

						<!-- 반복문 -->
						<?php foreach($re_construct_images as $id):?>
						<swiper-slide>
							<img class="imgModal3" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
						</swiper-slide>
						<?php endforeach?>
						<!-- 반복문 끝 -->

						<swiper-slide></swiper-slide>
						<swiper-slide></swiper-slide>
					</swiper-container>
				</div>
			</div>
			<?php endif?>
			
			<?php endif?>
			
			<hr class="hr_001" style="margin-top:40px;">
			<div class="expert_profile_div_002">
				<div>
					<h5>완료 요청서 작성</h5>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>전달내용</h6>
					</div>
					<div>
						<?php if($request->request_status == 'construct_start'):?>
							<textarea class="form-control" rows="3" id="comment2" name="complete[textarea][construct_complete_content]"></textarea>
						<?php elseif($request->request_status == 're_construct_start'):?>
							<textarea class="form-control" rows="3" id="comment2" name="complete[textarea][re_construct_complete_content]"></textarea>
						<?php elseif($request->request_status == 'as_start'):?>
							<textarea class="form-control" rows="3" id="comment2" name="complete[textarea][as_complete_content]"></textarea>
						<?php endif?>
					</div>
				</div>
				<div class="expert_profile_div_003 expert_profile_div_005">
					<div>
						사진
					</div>
					<div class="file-input-wrapper">
						<?php if($request->request_status == 'construct_start'):?>
						<label for="customFileInput09" class="file-input-label" onclick="addImageField(this, 'construct_complete', 3, 'complete_images[construct_complete][]')">
							<span class="file-input-icon">+</span>
						</label>
						<?php elseif($request->request_status == 're_construct_start'):?>
						<label for="customFileInput09" class="file-input-label" onclick="addImageField(this, 're_construct', 3, 'complete_images[re_construct_complete][]')">
							<span class="file-input-icon">+</span>
						</label>
						<?php elseif($request->request_status == 'as_start'):?>
						<label for="customFileInput09" class="file-input-label" onclick="addImageField(this, 'as_complete', 3, 'complete_images[as_complete][]')">
							<span class="file-input-icon">+</span>
						</label>
						<?php endif?>
					</div>
					<div class="img_field_wrap"></div>
				</div>
			</div>
		</div>

		<!-- 하단 버튼 -->
		<div class="button_bottom_001">
			<a href=""><button>완료 요청하기</button></a>
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

function submit_form(){
	
	return true;
}
</script>
	
<?php wp_footer()?>
</body>
</html>