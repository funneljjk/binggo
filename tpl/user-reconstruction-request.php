<?php
/**
 * Template Name: 고객 - 재시공 요청, AS 요청
 */
?>

<?php include BG_THEME_DIR.'/include/header-sub.php'?>

<?php
$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;
$request    = new Binggo_Request($request_id);
?>

<section class="user_reconstruction_request">
	
<form action="<?php echo esc_url(admin_url('admin-post.php'))?>" method="post" enctype="multipart/form-data" onsubmit="return submit_form();">
	<?php wp_nonce_field('binggo_security_'.$user->ID, 'binggo_nonce')?>
	<input type="hidden" name="action" value="binggo_user_re_construct_request">
	<input type="hidden" id="user_id" name="user_id" value="<?php echo esc_attr($user->ID)?>">
	<input type="hidden" id="request_id" name="request_id" value="<?php echo esc_attr($request_id)?>">
	<input type="hidden" id="expert_id" name="expert_id" value="<?php echo esc_attr($expert_id)?>">
	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<div class="div_004">
			<?php if($request->request_status == 'construct_confirm'):?>
			<div class="user_main_div_001">
				<a href="<?php echo add_query_arg('request_id', $request_id, site_url('/고객-전체-공사-내용/'))?>"><button>공사내용</button></a><!-- 구매 확정 완료 후 a/s 에만 적용 -->
			</div>
			<?php endif?>

			<!--  요청 1  -->
			<div class="expert_profile_div_002 user_reconstruction_request_div_001" style="position:relative">
				<div>
					<h5>요청 1</h5>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>요청 제목</h6>
					</div>
					<div>
						<input type="text" class="form-control form-control-sm reqTitle" placeholder="" name="re_construct[array][title][]">
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>요청 사유</h6>
					</div>
					<div>
						<textarea class="form-control reqContent" rows="3" id="comment2" name="re_construct[array][content][]"></textarea>
					</div>
				</div>
			</div>
			<div class="expert_profile_div_003 expert_profile_div_005">
				<div>
					사진
				</div>
				<div class="file-input-wrapper">
					<label for="customFileInput07" class="file-input-label" onclick="addImageField(this, 're_construct', 3, 're_construct_images[re_construct][]')">
						<span class="file-input-icon">+</span>
					</label>
				</div>
				<div class="img_field_wrap">
				<?php /*
					<?php if($request->scene && is_array($request->scene)):?>
					<?php foreach($request->scene as $idx=>$id):?>
					<label>
						<input type="hidden" class="image_fields scene n<?php echo esc_attr($idx)?>" name="uploaded_re_construct_images[re_construct][]" value="<?php echo esc_attr($id)?>">
						<div class="file_input_img_wrapper">
							<img class="file_input_img" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
							<div class="delete-icon">×</div>
						</div>
					</label>
					<?php endforeach?>
					<?php endif?>
				*/ ?>
				</div>
			</div>
			<!--  요청 1 끝 -->

			<div class="expert_profile_div_002" style="text-align: center; cursor:pointer;">
				<span class="requeBtn002">+ 요청 추가하기</span>
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
</section>

<script>
jQuery(document).ready(function($) {
	// '요청 추가하기' 클릭 시
	$('.requeBtn002').click(function() {
		// '.user_reconstruction_request_div_001' 요소 복사
		var clonedDiv = $('.user_reconstruction_request_div_001:first').clone();
		clonedDiv.find('.reqTitle').val(''); // clear the value of the input field in the cloned div
		clonedDiv.find('.reqContent').val(''); // clear the value of the input field in the cloned div
		// 요청 번호(h5 태그의 내용) 증가
		var nextRequestNumber = $('.user_reconstruction_request_div_001').length + 1;
		clonedDiv.find('h5').text('요청 ' + nextRequestNumber);
		// 삭제 버튼 추가
		clonedDiv.append('<span class="deleteRequestBtn" style="position: absolute; top: 0; right: 0; cursor:pointer;">삭제</span>');
		// 요청 div 바로 밑에 복사본 추가
		clonedDiv.insertAfter('.user_reconstruction_request_div_001:last');
	});

	// '삭제' 클릭 시
	jQuery(document).on('click', '.deleteRequestBtn', function() {
		// 해당 요청 div 삭제
		$(this).closest('.user_reconstruction_request_div_001').remove();
		// 요청 번호 재정렬
		$('.user_reconstruction_request_div_001').each(function(index) {
			$(this).find('h5').text('요청 ' + (index + 1));
		});
	});
});

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