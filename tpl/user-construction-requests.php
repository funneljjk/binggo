<?php
/**
 * Template Name: 고객 - 의뢰서 작성
 */
?>

<?php include BG_THEME_DIR.'/include/header-sub.php'?>

<?php
$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;
$request    = new Binggo_Request($request_id);

$expert_id  = isset($_GET['expert_id'])  ? intval($_GET['expert_id']) : 0;
if($expert_id && !get_user_meta($expert_id, 'is_expert', true)){
	echo '<script>';
	echo 'alert("잘못된 경로입니다.");';
	echo 'window.location.href="'.esc_url_raw(site_url()).'";';
	echo '</script>';
	exit;
}
?>

<form action="<?php echo esc_url(admin_url('admin-post.php'))?>" method="post" enctype="multipart/form-data" onsubmit="return submit_form();">
	<?php wp_nonce_field('binggo_security_request_'.$user->ID, 'binggo_nonce')?>
	<input type="hidden" name="action" value="binggo_request">
	<input type="hidden" id="user_id" name="user_id" value="<?php echo esc_attr($user->ID)?>">
	<input type="hidden" id="request_id" name="request_id" value="<?php echo esc_attr($request_id)?>">
	<input type="hidden" id="expert_id" name="expert_id" value="<?php echo esc_attr($expert_id)?>">

	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<div class="div_004">

			<!-- 사업장 필수정보를 입력해 주세요 -->
			<div class="expert_profile_div_002">
				<div>
					<h5>사업장 필수정보를 입력해 주세요</h5>
				</div>

				<div class="expert_profile_div_003 expert_profile_div_004">
					<div>
						공사위치<i class="fa fa-star requirStar"></i>
					</div>
					<div style="padding-right: 2.5px;">
						<select class="form-select form-select-sm" id="location001" name="request[string][location]" required>
							<option value="" disabled selected>도시</option>
							<option value="강원도" <?php echo $request->location == '강원도' ? 'selected' : ''?>>강원도</option>
							<option value="경기도" <?php echo $request->location == '경기도' ? 'selected' : ''?>>경기도</option>
							<option value="경상남도" <?php echo $request->location == '경상남도' ? 'selected' : ''?>>경상남도</option>
							<option value="경상북도" <?php echo $request->location == '경상북도' ? 'selected' : ''?>>경상북도</option>
							<option value="광주광역시" <?php echo $request->location == '광주광역시' ? 'selected' : ''?>>광주광역시</option>
							<option value="대구광역시" <?php echo $request->location == '대구광역시' ? 'selected' : ''?>>대구광역시</option>
							<option value="대전광역시" <?php echo $request->location == '대전광역시' ? 'selected' : ''?>>대전광역시</option>
							<option value="부산광역시" <?php echo $request->location == '부산광역시' ? 'selected' : ''?>>부산광역시</option>
							<option value="서울특별시" <?php echo $request->location == '서울특별시' ? 'selected' : ''?>>서울특별시</option>
							<option value="세종특별자치시" <?php echo $request->location == '세종특별자치시' ? 'selected' : ''?>>세종특별자치시</option>
							<option value="울산광역시" <?php echo $request->location == '울산광역시' ? 'selected' : ''?>>울산광역시</option>
							<option value="인천광역시" <?php echo $request->location == '인천광역시' ? 'selected' : ''?>>인천광역시</option>
							<option value="전라남도" <?php echo $request->location == '전라남도' ? 'selected' : ''?>>전라남도</option>
							<option value="전라북도" <?php echo $request->location == '전라북도' ? 'selected' : ''?>>전라북도</option>
							<option value="제주특별자치도" <?php echo $request->location == '제주특별자치도' ? 'selected' : ''?>>제주특별자치도</option>
							<option value="충청남도" <?php echo $request->location == '충청남도' ? 'selected' : ''?>>충청남도</option>
							<option value="충청북도" <?php echo $request->location == '충청북도' ? 'selected' : ''?>>충청북도</option>
						</select>
					</div>
					<div style="padding-left: 2.5px;">
						<select class="form-select form-select-sm " id="location002" name="request[string][location2]">
						<?php if($request->location2):?>
							<option value="<?php echo esc_attr($request->location2)?>" selected><?php echo esc_html($request->location2)?></option>
						<?php endif?>
						</select>
					</div>
				</div>
				
				<div class="expert_profile_div_003">
					<div></div>
					<div>
						<input type="text" class="form-control form-control-sm" placeholder="상세 주소를 입력하세요." name="request[string][location3]" value="<?php echo esc_attr($request->location2)?>">
					</div>
				</div>

				<div class="expert_profile_div_003 user_construction_requests_div_001">
					<div>
						공사업종<i class="fa fa-star requirStar"></i>
					</div>
					<div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio1" name="request[string][construct_industry]" value="마트" onclick="toggleInput()" <?php echo $request->construct_industry == '마트' ? 'checked' : ''?> required>
							<label class="form-check-label" for="radio1">마트</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio2" name="request[string][construct_industry]" value="편의점" onclick="toggleInput()" <?php echo $request->construct_industry == '편의점' ? 'checked' : ''?>>
							<label class="form-check-label" for="radio2">편의점</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio3" name="request[string][construct_industry]" value="저온저장고" onclick="toggleInput()" <?php echo $request->construct_industry == '저온저장고' ? 'checked' : ''?>>
							<label class="form-check-label" for="radio3">저온저장고</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio4" name="request[string][construct_industry]" value="소형업소" onclick="toggleInput()" <?php echo $request->construct_industry == '소형업소' ? 'checked' : ''?>>
							<label class="form-check-label" for="radio4">소형업소</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio5" name="request[string][construct_industry]" value="물류창고" onclick="toggleInput()" <?php echo $request->construct_industry == '물류창고' ? 'checked' : ''?>>
							<label class="form-check-label" for="radio5">물류창고</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio6" name="request[string][construct_industry]" value="업소용장비" onclick="toggleInput()" <?php echo $request->construct_industry == '업소용장비' ? 'checked' : ''?>>
							<label class="form-check-label" for="radio6">업소용장비</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio7" name="request[string][construct_industry]" value="에어콘" onclick="toggleInput()" <?php echo $request->construct_industry == '에어콘' ? 'checked' : ''?>>
							<label class="form-check-label" for="radio7">에어콘</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio8" name="request[string][construct_industry]" value="기타" onclick="toggleInput()" <?php echo $request->construct_industry == '기타' ? 'checked' : ''?>>
							<label class="form-check-label" for="radio8">기타</label>
						</div>
						<input type="text" class="form-control form-control-sm" <?php echo $request->construct_industry != '기타' ? 'style="display:none;"' : ''?> id="hiddenInput" name="request[string][construct_industry_etc]" value="<?php echo esc_attr($request->construct_industry_etc)?>">
					</div>
				</div>
				<div class="expert_profile_div_003 user_construction_requests_div_001">
					<div>
						공사형태<i class="fa fa-star requirStar"></i>
					</div>
					<div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio9" name="request[string][construct_type]" value="신규설치"  onclick="toggleInput2()" <?php echo $request->construct_type == '신규설치' ? 'checked' : ''?> required>
							<label class="form-check-label" for="radio9">신규설치</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio10" name="request[string][construct_type]" value="이전설치" onclick="toggleInput2()" <?php echo $request->construct_type == '이전설치' ? 'checked' : ''?>>
							<label class="form-check-label" for="radio10">이전설치</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio11" name="request[string][construct_type]" value="해체/철거" onclick="toggleInput2()" <?php echo $request->construct_type == '해체/철거' ? 'checked' : ''?>>
							<label class="form-check-label" for="radio11">해체/철거</label>
						</div>
						<div class="form-check">
							<input type="radio" class="form-check-input" id="radio12" name="request[string][construct_type]" value="기타" onclick="toggleInput2()" <?php echo $request->construct_type == '기타' ? 'checked' : ''?>>
							<label class="form-check-label" for="radio12">기타</label>
						</div>
						<input type="text" class="form-control form-control-sm" <?php echo $request->construct_type != '기타' ? 'style="display:none;"' : ''?> id="hiddenInput2" name="request[string][construct_type_etc]" value="<?php echo esc_attr($request->construct_type_etc)?>">
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						담당자 성함<i class="fa fa-star requirStar"></i>
					</div>
					<div>
						<input type="text" class="form-control form-control-sm" placeholder="담당자님 성함을 입력하세요." name="request[string][first_name]" value="<?php echo esc_attr($request->first_name)?>">
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						연락처<i class="fa fa-star requirStar"></i>
					</div>
					<div>
						<input type="number" class="form-control form-control-sm" placeholder="연락처를 입력하세요.(숫자만입력)" min="0" name="request[string][billing_phone]" value="<?php echo esc_attr($request->billing_phone)?>">
					</div>
				</div>
			   
			</div>
			<!-- 사업장 필수정보를 입력해 주세요 끝 -->

			<!-- 공사정보를 입력해 주세요 -->
			<div class="expert_profile_div_002">
				<div>
					<h5>공사정보를 입력해 주세요</h5>
				</div>

				<div class="expert_profile_div_003 expert_profile_div_004">
					<div>
						공사일정
					</div>
					<div style="padding-right: 2.5px;">
						<input type="date" class="form-control form-control-sm" id="startDate001" onchange="setMinEndDate()" name="request[string][start_date]" value="<?php echo esc_attr($request->start_date)?>">
					</div>
					<div style="padding-left: 2.5px;">
						<input type="date" class="form-control form-control-sm" id="endDate001" name="request[string][end_date]" value="<?php echo esc_attr($request->end_date)?>">
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						요청사항
					</div>
					<div>
						<textarea class="form-control" rows="3" id="comment2" name="request[textarea][content]"><?php echo esc_textarea($request->post_content)?></textarea>
					</div>
				</div>
				<div class="expert_profile_div_003 expert_profile_div_005">
					<div>
						현장사진
					</div>
					<div class="file-input-wrapper">
						<label for="customFileInput07" class="file-input-label" onclick="addImageField(this, 'scene', 3, 'request_images[scene][]')">
							<span class="file-input-icon">+</span>
						</label>
					</div>
					<div class="img_field_wrap">
						<?php if($request->scene && is_array($request->scene)):?>
						<?php foreach($request->scene as $idx=>$id):?>
						<label>
							<input type="hidden" class="image_fields scene n<?php echo esc_attr($idx)?>" name="uploaded_request_images[scene][]" value="<?php echo esc_attr($id)?>">
							<div class="file_input_img_wrapper">
								<img class="file_input_img" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
								<div class="delete-icon">×</div>
							</div>
						</label>
						<?php endforeach?>
						<?php endif?>
					</div>
				</div>
				<div class="expert_profile_div_003 expert_profile_div_005">
					<div>
						공사도면
					</div>
					<div class="file-input-wrapper">
						<label for="customFileInput08" class="file-input-label" onclick="addImageField(this, 'floor_plan', 3, 'request_images[floor_plan][]')">
							<span class="file-input-icon">+</span>
						</label>
					</div>
					<div class="img_field_wrap">
						<?php if($request->floor_plan && is_array($request->floor_plan)):?>
						<?php foreach($request->floor_plan as $idx=>$id):?>
						<label>
							<input type="hidden" class="image_fields floor_plan n<?php echo esc_attr($idx)?>" name="uploaded_request_images[floor_plan][]" value="<?php echo esc_attr($id)?>">
							<div class="file_input_img_wrapper">
								<img class="file_input_img" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
								<div class="delete-icon">×</div>
							</div>
						</label>
						<?php endforeach?>
						<?php endif?>
					</div>
				</div>
				<div class="expert_profile_div_003 expert_profile_div_005">
					<div>
						기타사진
					</div>
					<div class="file-input-wrapper">
						<label for="customFileInput09" class="file-input-label" onclick="addImageField(this, 'etc', 3, 'request_images[etc][]')">
							<span class="file-input-icon">+</span>
						</label>
					</div>
					<div class="img_field_wrap">
						<?php if($request->etc && is_array($request->etc)):?>
						<?php foreach($request->etc as $idx=>$id):?>
						<label>
							<input type="hidden" class="image_fields etc n<?php echo esc_attr($idx)?>" name="uploaded_request_images[etc][]" value="<?php echo esc_attr($id)?>">
							<div class="file_input_img_wrapper">
								<img class="file_input_img" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
								<div class="delete-icon">×</div>
							</div>
						</label>
						<?php endforeach?>
						<?php endif?>
					</div>
				</div>
			</div>
			<!-- 공사정보를 입력해 주세요 끝 -->

			<!-- 현장방문예약 -->
			<div class="expert_profile_div_002">
				<div>
					<h5>현장방문 예약</h5>
				</div>
				<div style="text-align:center;">
					<button type="button" class="ucrBtn001">현장방문 요청하기</button><br>
					<input type="checkbox" id="field_visit_request" class="hidden" name="request[int][field_visit_request]" value="1">
					<input class="ucrBtn001" type="date" style="margin-top: 10px;<?php echo !$request->field_visit_request ? 'display:none;' : '';?>width:calc(40% - 2.5px)" name="request[string][field_visit_date]" value="<?php echo esc_attr($request->field_visit_date)?>">
					<input class="ucrBtn001" type="time" style="margin-top: 10px;<?php echo !$request->field_visit_request ? 'display:none;' : '';?>width:calc(40% - 2.5px)" name="request[string][field_visit_time]" value="<?php echo esc_attr($request->field_visit_time)?>">
				</div>
			</div>
			<!-- 현장방문예약 끝 -->

			<!-- 매핑된전문가 -->
			<div class="expert_profile_div_002">
				<div>
					<h5>매핑된 전문가</h5>
				</div>
				<div style="text-align:center;">
					<?php if($expert_id):?>
					<h6><?php echo esc_html(get_user_meta($expert_id, 'first_name', true))?> 전문가</h6><!-- 전문가에게 다이렉트로 의뢰서를 접수한 경우 노출 -->
					<?php else:?>
					<h6>매핑된 전문가가 없습니다.</h6><!-- 의뢰리스트에서 견적을 받은경우 노출 -->
					<?php endif?>
				</div>
			</div>
			<!-- 매핑된전문가 끝 -->
		</div>

		<!-- 하단 버튼 -->
		<div class="button_bottom_001">
			<a href="/고객-의뢰서-접수-완료"><button type="submit">의뢰서 접수완료</button></a>
		</div>

	</div>

	<!-- right space -->
	<div class="div_003"></div>


	<!-- 파일 미리보기 모달창-->
	<div id="imageModal" class="modal002">
		<span class="close002">&times;</span>
		<img class="modal-content002" id="modalImage">
		<div id="caption"></div>
	</div>
</form>
	
<script>
//의뢰서작성 라디오버튼 함수
function toggleInput() {
	var radio8 = document.getElementById('radio8');
	var hiddenInput = document.getElementById('hiddenInput');

	if (radio8.checked) {
		hiddenInput.style.display = 'block';
	} else {
		hiddenInput.style.display = 'none';
	}
}
function toggleInput2() {
	var radio8 = document.getElementById('radio12');
	var hiddenInput = document.getElementById('hiddenInput2');

	if (radio8.checked) {
		hiddenInput.style.display = 'block';
	} else {
		hiddenInput.style.display = 'none';
	}
}

jQuery(document).ready(function($){
	expert_image_delete_icon();
	
	//의뢰서작성 공사일정 함수
	function formatDate(date) {
		var d = new Date(date),
			month = '' + (d.getMonth() + 1),
			day = '' + d.getDate(),
			year = d.getFullYear();

		if (month.length < 2) {
			month = '0' + month;
		}
		if (day.length < 2) {
			day = '0' + day;
		}

		return [year, month, day].join('-');
	}

	function setMinEndDate() {
		var startDate = document.getElementById('startDate001');
		var endDate = document.getElementById('endDate001');

		endDate.min = startDate.value;
		endDate.value = ''; // 마감날짜를 초기화합니다.
	}

	var today = new Date();
	var formattedToday = formatDate(today);

	var startDate = document.getElementById('startDate001');
	var endDate = document.getElementById('endDate001');

	startDate.value = formattedToday;
	// endDate.value = formattedToday;

	startDate.min = formattedToday;
	endDate.min = formattedToday;

	//파일 미리보기 모달창
	function openModalWithImage(src) {
		const modal = $('#imageModal');
		const modalImg = $('#modalImage');

		modalImg.attr('src', src);
		modal.show();
	}
	$('.file_input_img, .imgModal2').on('click', function () {
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


	//현장방문 클릭 함수
	$('button.ucrBtn001').click(function() {
		$('#field_visit_request').trigger('click');
		$('input.ucrBtn001').toggle();
	});


	//공사 위치
	var cities = {
		"강원도": ["강릉시", "고성군", "동해시", "삼척시", "속초시", "양구군", "양양군", "영월군", "원주시", "인제군", "정선군", "철원군", "춘천시", "태백시", "평창군", "홍천군", "화천군", "횡성군"],
		"경기도": ["가평군", "고양시", "과천시", "광명시", "광주시", "구리시", "군포시", "김포시", "남양주시", "동두천시", "부천시", "성남시", "수원시", "시흥시", "안산시", "안성시", "안양시", "양주시", "양평군", "여주시", "연천군", "오산시", "용인시", "의왕시", "의정부시", "이천시", "파주시", "평택시", "포천시", "하남시", "화성시"],
		"경상남도": ["거제시", "거창군", "고성군", "김해시", "남해군", "밀양시", "사천시", "산청군", "양산시", "의령군", "진주시", "창녕군", "창원시", "통영시", "하동군", "함안군", "함양군", "합천군"],
		"경상북도": ["경산시", "경주시", "고령군", "구미시", "군위군", "김천시", "문경시", "봉화군", "상주시", "성주군", "안동시", "영덕군", "영양군", "영주시", "영천시", "예천군", "울릉군", "울진군", "의성군", "청도군", "청송군", "칠곡군", "포항시"],
		"광주광역시": ["광산구", "남구", "동구", "북구", "서구"],
		"대구광역시": ["남구", "달서구", "달성군", "동구", "북구", "서구", "수성구", "중구"],
		"대전광역시": ["대덕구", "동구", "서구", "유성구", "중구"],
		"부산광역시": ["강서구", "금정구", "기장군", "남구", "동구", "동래구", "부산진구", "북구", "사상구", "사하구", "서구", "수영구", "연제구", "영도구", "중구", "해운대구"],
		"서울특별시": ["강남구", "강동구", "강북구", "강서구", "관악구", "광진구", "구로구", "금천구", "노원구", "도봉구", "동대문구", "동작구", "마포구", "서대문구", "서초구", "성동구", "성북구", "송파구", "양천구", "영등포구", "용산구", "은평구", "종로구", "중구", "중랑구"],
		"세종특별자치시": ["세종시"],
		"울산광역시": ["남구", "동구", "북구", "울주군", "중구"],
		"인천광역시": ["강화군", "계양구", "남동구", "동구", "미추홀구", "부평구", "서구", "연수구", "옹진군", "중구"],
		"전라남도": ["강진군", "고흥군", "곡성군", "광양시", "구례군", "나주시", "담양군", "목포시", "무안군", "보성군", "순천시", "신안군", "여수시", "영광군", "영암군", "완도군", "장성군", "장흥군", "진도군", "함평군", "해남군", "화순군"],
		"전라북도": ["고창군", "군산시", "김제시", "남원시", "무주군", "부안군", "순창군", "완주군", "익산시", "임실군", "장수군", "전주시", "정읍시", "진안군"],
		"제주특별자치도": ["서귀포시", "제주시"],
		"충청남도": ["계룡시", "공주시", "금산군", "논산시", "당진시", "보령시", "부여군", "서산시", "서천군", "아산시", "예산군", "천안시", "청양군", "태안군", "홍성군"],
		"충청북도": ["괴산군", "단양군", "보은군", "영동군", "옥천군", "음성군", "제천시", "증평군", "진천군", "청주시", "충주시"]
	};
	$("#location001").change(function() {
		var selectedCity = $(this).val();
		var subCities = cities[selectedCity];
		
		// Reset the sub-cities dropdown
		$("#location002").empty();

		// Populate the sub-cities dropdown
		$.each(subCities, function(index, value) {
			$("#location002").append("<option value='" + value + "'>" + value + "</option>");
		});
	});


	//현장방문 일자 오늘날짜로 자동 설정
	var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
	var yyyy = today.getFullYear();
	var hours = String(today.getHours()).padStart(2, '0');
	var minutes = String(today.getMinutes()).padStart(2, '0');
	today = yyyy + '-' + mm + '-' + dd;
	$('.ucrBtn001[type="date"]').val(today);
	$('.ucrBtn001[type="date"]').attr('min', today);
	var timeNow = hours + ':' + minutes;
	$('.ucrBtn001[type="time"]').val(timeNow);
});

// 추가 입력

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