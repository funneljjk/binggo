<?php
/**
 * Template Name: 전문가 - 포트폴리오 작성/수정
 */
?>

<?php include BG_THEME_DIR.'/include/header-sub.php'?>

<?php
$portfolio_id = isset($_GET['portfolio_id']) ? intval($_GET['portfolio_id']) : 0;

$title              = '';
$location           = '';
$price              = '';
$work_time          = '';
$work_time_criteria = '';
$worked_date        = '';

$construction     = array();
$business         = array();
$portfolio_images = array();

$thumbnail    = array();
$images       = array();

if($portfolio_id){
	$portfolio = get_post($portfolio_id);
	if($portfolio->post_author != $user->ID){
		echo '<script>';
		echo 'alert("잘못된 경로입니다.");';
		echo 'window.location.href="'.esc_url_raw(site_url()).'";';
		echo '</script>';
		exit;
	}
	
	$title              = $portfolio->post_title;
	$location           = get_post_meta($portfolio_id, 'location', true);
	$price              = get_post_meta($portfolio_id, 'price', true);
	$work_time          = get_post_meta($portfolio_id, 'work_time', true);
	$work_time_criteria = get_post_meta($portfolio_id, 'work_time_criteria', true);
	$worked_date        = get_post_meta($portfolio_id, 'worked_date', true);
	
	$construction       = get_post_meta($portfolio_id, 'construction', true);
	$business           = get_post_meta($portfolio_id, 'business', true);
	$portfolio_images   = get_post_meta($portfolio_id, 'portfolio_images', true);
	
	$thumbnail = isset($portfolio_images['thumbnail']) ? $portfolio_images['thumbnail'] : array();
	$images    = isset($portfolio_images['images'])    ? $portfolio_images['images']    : array();
}
?>

<form action="<?php echo esc_url(admin_url('admin-post.php'))?>" method="post" enctype="multipart/form-data" onsubmit="return submit_form();">
	<?php wp_nonce_field('binggo_security_'.$user->ID, 'binggo_nonce')?>
	<input type="hidden" name="action" value="binggo_expert_portfolio">
	<input type="hidden" id="user_id" name="user_id" value="<?php echo esc_attr($user->ID)?>">
	<input type="hidden" id="portfolio_id" name="portfolio_id" value="<?php echo esc_attr($portfolio_id)?>">
	
	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<div class="div_004">
			<div class="user_main_div_001">
				<button type="submit">저장</button>
			</div>

			<div class="expert_profile_div_002">
				<div>
					<h5>시공 형태</h5>
				</div>
				<div>
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="portfolio[array][construction][new_install]" value="신규설치" <?php echo in_array('신규설치', $construction) ? 'checked' : ''?>>
						<span class="checkmark">신규설치</span>
					</label>
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="portfolio[array][construction][transfer_install]" value="이전설치" <?php echo in_array('이전설치', $construction) ? 'checked' : ''?>>
						<span class="checkmark">이전설치</span>
					</label>
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="portfolio[array][construction][demolish]" value="철거" <?php echo in_array('철거', $construction) ? 'checked' : ''?>>
						<span class="checkmark">철거</span>
					</label>
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="portfolio[array][construction][etc]" value="기타" <?php echo in_array('기타', $construction) ? 'checked' : ''?>>
						<span class="checkmark">기타</span>
					</label>
				</div>
			</div>

			<div class="expert_profile_div_002">
				<div>
					<h5>사업장 정보</h5>
				</div>
				<div >
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="portfolio[array][business][garage]" value="물류창고" <?php echo in_array('물류창고', $business) ? 'checked' : ''?>>
						<span class="checkmark">물류창고</span>
					</label>
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="portfolio[array][business][small_business]" value="소형업소" <?php echo in_array('소형업소', $business) ? 'checked' : ''?>>
						<span class="checkmark">소형업소</span>
					</label>
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="portfolio[array][business][mart]" value="마트" <?php echo in_array('마트', $business) ? 'checked' : ''?>>
						<span class="checkmark">마트</span>
					</label>
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="portfolio[array][business][air_conditioner]" value="에어컨" <?php echo in_array('에어컨', $business) ? 'checked' : ''?>>
						<span class="checkmark">에어컨</span>
					</label>
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="portfolio[array][business][refrigerator]" value="저온저장고" <?php echo in_array('저온저장고', $business) ? 'checked' : ''?>>
						<span class="checkmark">저온저장고</span>
					</label>
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="portfolio[array][business][convenience]" value="편의점" <?php echo in_array('편의점', $business) ? 'checked' : ''?>>
						<span class="checkmark">편의점</span>
					</label>
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="portfolio[array][business][for_business]" value="업소용장비" <?php echo in_array('업소용장비', $business) ? 'checked' : ''?>>
						<span class="checkmark">업소용장비</span>
					</label>
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="portfolio[array][business][etc]" value="기타" <?php echo in_array('기타', $business) ? 'checked' : ''?>>
						<span class="checkmark">기타</span>
					</label>
				</div>
			</div>

			<div class="expert_profile_div_002">
				<div>
					<h5>포트폴리오 제목</h5>
				</div>
				<div>
					<input type="text" class="form-control form-control-sm" name="portfolio[string][title]" value="<?php echo esc_attr($title)?>">
				</div>
			</div>

			<div class="expert_profile_div_002">
				<div>
					<h5>대표 이미지</h5>
				</div>
				<div class="expert_quotes_write_div_002">
					<div class="file-input-wrapper">
						<label class="file-input-label" onclick="addImageField(this, 'thumbnail', 1, 'portfolio_images[thumbnail][]')">
							<span class="file-input-icon">+</span>
						</label>
					</div>
					<div class="img_field_wrap">
						<?php foreach($thumbnail as $idx=>$id):?>
						<label>
							<input type="hidden" class="image_fields thumbnail n<?php echo esc_attr($idx)?>" name="uploaded_portfolio_images[thumbnail][]" value="<?php echo esc_attr($id)?>">
							<div class="file_input_img_wrapper">
								<img class="file_input_img" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
								<div class="delete-icon">×</div>
							</div>
						</label>
						<?php endforeach?>
					</div>
				</div>
			</div>

			<div class="expert_profile_div_002">
				<div>
					<h5>추가 이미지(최대 4장)</h5>
				</div>
				<div class="expert_quotes_write_div_002">
					<div class="file-input-wrapper">
						<label class="file-input-label" onclick="addImageField(this, 'images', 4, 'portfolio_images[images][]')">
							<span class="file-input-icon">+</span>
						</label>
					</div>
					<div class="img_field_wrap">
						<?php foreach($images as $idx=>$id):?>
						<label>
							<input type="hidden" class="image_fields images n<?php echo esc_attr($idx)?>" name="uploaded_portfolio_images[images][]" value="<?php echo esc_attr($id)?>">
							<div class="file_input_img_wrapper">
								<img class="file_input_img" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
								<div class="delete-icon">×</div>
							</div>
						</label>
						<?php endforeach?>
					</div>
				</div>
			</div>

			<div class="expert_profile_div_002">
				<div>
					<h5>상세 정보</h5>
				</div>
				<div class="expert_profile_div_003">
					<div>
						지역정보
					</div>
					<div>
						<select class="form-select form-select-sm" name="portfolio[string][location]">
							<option value="" disabled selected>서비스 지역</option>
							<option value="강원도" <?php echo $location == '강원도' ? 'selected' : ''?>>강원도</option>
							<option value="경기도" <?php echo $location == '경기도' ? 'selected' : ''?>>경기도</option>
							<option value="경상남도" <?php echo $location == '경상남도' ? 'selected' : ''?>>경상남도</option>
							<option value="경상북도" <?php echo $location == '경상북도' ? 'selected' : ''?>>경상북도</option>
							<option value="광주광역시" <?php echo $location == '광주광역시' ? 'selected' : ''?>>광주광역시</option>
							<option value="대구광역시" <?php echo $location == '대구광역시' ? 'selected' : ''?>>대구광역시</option>
							<option value="대전광역시" <?php echo $location == '대전광역시' ? 'selected' : ''?>>대전광역시</option>
							<option value="부산광역시" <?php echo $location == '부산광역시' ? 'selected' : ''?>>부산광역시</option>
							<option value="서울특별시" <?php echo $location == '서울특별시' ? 'selected' : ''?>>서울특별시</option>
							<option value="세종특별자치시" <?php echo $location == '세종특별자치시' ? 'selected' : ''?>>세종특별자치시</option>
							<option value="울산광역시" <?php echo $location == '울산광역시' ? 'selected' : ''?>>울산광역시</option>
							<option value="인천광역시" <?php echo $location == '인천광역시' ? 'selected' : ''?>>인천광역시</option>
							<option value="전라남도" <?php echo $location == '전라남도' ? 'selected' : ''?>>전라남도</option>
							<option value="전라북도" <?php echo $location == '전라북도' ? 'selected' : ''?>>전라북도</option>
							<option value="제주특별자치도" <?php echo $location == '제주특별자치도' ? 'selected' : ''?>>제주특별자치도</option>
							<option value="충청남도" <?php echo $location == '충청남도' ? 'selected' : ''?>>충청남도</option>
							<option value="충청북도" <?php echo $location == '충청북도' ? 'selected' : ''?>>충청북도</option>
						</select>
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						시공비용
					</div>
					<div>
						<input type="number" class="form-control form-control-sm " placeholder="숫자만 입력 하세요." name="portfolio[string][price]" value="<?php echo esc_attr($price)?>">
					</div>
				</div>
				<div class="expert_profile_div_003 expert_profile_div_004">
					<div>
						작업소요시간
					</div>
					<div style="padding-right:2.5px">
						<select class="form-select form-select-sm" name="portfolio[string][work_time]">
							<option value="" disabled selected>소요시간</option>
							<?php for($i=0; $i<24; $i++):?>
							<option value="<?php echo esc_attr($i)?>" <?php echo $work_time == $i ? 'selected' : ''?>><?php echo esc_html($i)?></option>
							<?php endfor?>
						</select>
					</div>
					<div style="padding-left:2.5px">
						<select class="form-select form-select-sm" name="portfolio[string][work_time_criteria]">
							<option value="" disabled selected>시간/일/주/월</option>
							<option value="시간" <?php echo $work_time_criteria == '시간' ? 'selected' : ''?>>시간</option>
							<option value="일" <?php echo $work_time_criteria == '일' ? 'selected' : ''?>>일</option>
							<option value="주" <?php echo $work_time_criteria == '주' ? 'selected' : ''?>>주</option>
							<option value="월" <?php echo $work_time_criteria == '개월' ? 'selected' : ''?>>개월</option>
						</select>
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						작업년/월
					</div>
					<div>
						<input type="month" class="form-control form-control-sm " min="1950-01-01" name="portfolio[string][worked_date]" value="<?php echo esc_attr($worked_date)?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- right space -->
	<div class="div_003"></div>
	
</form>

<script>
jQuery(document).ready(function () {
	expert_image_delete_icon();
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
	return false;
}
</script>

	<?php wp_footer()?>
</body>
</html>