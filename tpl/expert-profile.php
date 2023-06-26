<?php
/**
 * Template Name: 전문가 - 전문가 프로필
 */
?>

<?php include BG_THEME_DIR.'/include/header-expert.php';?>

<?php
$expert = new Experts($user->ID);
?>
	<!-- left space -->
<form action="<?php echo esc_url(admin_url('admin-post.php'))?>" method="post" enctype="multipart/form-data">
	<?php wp_nonce_field('binggo_security_'.$expert->ID, 'binggo_nonce')?>
	<input type="hidden" name="action" value="binggo_expert_profile">
	<input type="hidden" id="user_id" name="user_id" value="<?php echo esc_attr($expert->ID)?>">
	
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
				<h4><?php echo esc_html($expert->first_name)?><?php if($expert->is_expert_confirm):?><img src="<?php echo BG_THEME_URL?>/img/certificationExpert.png" alt="인증된전문가" width="15px" style="vertical-align:top;"><?php endif?></h4>
				<?php echo esc_html(implode(', ', $expert->location))?>
			</div>
		</div>

		<!-- 전문가 정보 필수 -->
		<div class="expert_profile_div_002">
			<div>
				<h5>전문가 정보<i class="fa fa-star requirStar"></i></h5>
			</div>

			<div class="expert_profile_div_003">
				<div>
					전문가명
				</div>
				<div>
					<input type="text" class="form-control form-control-sm" name="experts[string][first_name]" value="<?php echo esc_attr($expert->first_name)?>">
				</div>
			</div>
			<div class="expert_profile_div_003">
				<div>
					서비스지역
				</div>
				<div>
					<select class="form-select form-select-sm selectEvent" name="experts[string][service_location]">
						<option value="" disabled selected>서비스 가능 지역</option>
						<option value="전체지역">전체지역</option>
						<option value="강원도">강원도</option>
						<option value="경기도">경기도</option>
						<option value="경상남도">경상남도</option>
						<option value="경상북도">경상북도</option>
						<option value="광주광역시">광주광역시</option>
						<option value="대구광역시">대구광역시</option>
						<option value="대전광역시">대전광역시</option>
						<option value="부산광역시">부산광역시</option>
						<option value="서울특별시">서울특별시</option>
						<option value="세종특별자치시">세종특별자치시</option>
						<option value="울산광역시">울산광역시</option>
						<option value="인천광역시">인천광역시</option>
						<option value="전라남도">전라남도</option>
						<option value="전라북도">전라북도</option>
						<option value="제주특별자치도">제주특별자치도</option>
						<option value="충청남도">충청남도</option>
						<option value="충청북도">충청북도</option>
					</select>
					<div class="selectText">
						<input type="hidden" id="location" name="experts[string][location]" value="<?php echo esc_html('-'.implode('-', $expert->location))?>">
						<?php foreach($expert->location as $item):?>
							<span class="selected-item"><?php echo esc_html($item)?><span class="remove-location-btn">x</span></span>
						<?php endforeach?>
					</div>
				</div>
			</div>
			<div class="expert_profile_div_003">
				<div>
					지원서비스
				</div>
				<div style="height:calc(1.5em + 0.5rem)">
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="experts[array][available_service][]" value="신규설치" <?php echo in_array('신규설치', $expert->available_service) ? 'checked' : ''?>>
						<span class="checkmark">신규설치</span>
					</label>
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="experts[array][available_service][]" value="이전설치" <?php echo in_array('이전설치', $expert->available_service) ? 'checked' : ''?>>
						<span class="checkmark">이전설치</span>
					</label>
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="experts[array][available_service][]" value="철거" <?php echo in_array('철거', $expert->available_service) ? 'checked' : ''?>>
						<span class="checkmark">철거</span>
					</label>
					<label class="custom-checkbox">
						<input class="custom-input" type="checkbox" name="experts[array][available_service][]" value="기타" <?php echo in_array('기타', $expert->available_service) ? 'checked' : ''?>>
						<span class="checkmark">기타</span>
					</label>
				</div>
			</div>
			<div class="expert_profile_div_003">
				<div>
					경력
				</div>
				<div>
					<input type="number" class="form-control form-control-sm" placeholder="숫자만 입력" min="0" name="experts[int][career]" value="<?php echo esc_attr($career)?>">
				</div>
			</div>
			<div class="expert_profile_div_003">
				<div>
					고용
				</div>
				<div style="height:calc(1.5em + 0.5rem)">
					<?php echo esc_html($expert->hire_count)?>번
				</div>
			</div>
			<div class="expert_profile_div_003">
				<div>
					직원수
				</div>
				<div>
					<input type="number" class="form-control form-control-sm" placeholder="숫자만 입력" min="0" name="experts[int][staff]" value="<?php echo esc_attr($staff)?>">
				</div>
			</div>
			<div class="expert_profile_div_003">
				<div>
					세금계산서
				</div>
				<div style="height:calc(1.5em + 0.5rem)">
					<?php if($expert->is_billing_tax):?>
						발행가능
					<?php else:?>
						발행불가
					<?php endif?>
				</div>
			</div>
			<div class="expert_profile_div_003">
				<div>
					서비스설명
				</div>
				<div>
					<textarea class="form-control" rows="3" id="comment" name="experts[textarea][service_description]"><?php echo esc_textarea($expert->service_description)?></textarea>
				</div>
			</div>
		</div>
		<!-- 전문가 정보 끝 -->

		<!-- 추가 정보 -->
		<div class="expert_profile_div_002">
			<div>
				<h5>추가 정보</h5>
			</div>

			<div class="expert_profile_div_003 expert_profile_div_004">
				<div>
					연락가능시간
				</div>
				<div style="padding-right:2.5px">
					<select class="form-select form-select-sm selecTime" id="startTime" name="experts[string][can_contact_time_start]">
						<option value="" disabled selected>시작시간</option>
						<?php for($i=0; $i<24; $i++):?>
							<option value="<?php echo esc_attr($i)?>" <?php echo $i == $expert->can_contact_time_end ? 'selected' : ''?>><?php echo esc_html($i)?></option>
						<?php endfor?>
					</select>
				</div>
				<div style="padding-left:2.5px">
					<select class="form-select form-select-sm selecTime" id="endTime" name="experts[string][can_contact_time_end]">
						<option value="" disabled selected>종료시간</option>
						<?php for($i=0; $i<24; $i++):?>
							<option value="<?php echo esc_attr($i)?>" <?php echo $i == $expert->can_contact_time_end ? 'selected' : ''?>><?php echo esc_html($i)?></option>
						<?php endfor?>
					</select>
				</div>
			</div>
			<div class="expert_profile_div_003">
				<div>
					본인인증
				</div>
				<div class="input-group">
					<input id="user-phone" type="text" class="form-control form-control-sm" placeholder="핸드폰번호 숫자만 입력" min="0" value="<?php echo esc_attr($expert->billing_phone)?>">
					<button id="expert_certify" class="btn btn-dark btn-sm" onclick="expertCertify()">인증 하기</button>
				</div>
			</div>
			<div class="expert_profile_div_003 expert_confirm_wrap" style="margin-top: 5px; display: none;">
				<div></div>
				<div class="input-group hidden">
					<input id="user-phone-confirm" type="number" class="form-control form-control-sm" placeholder="인증 번호를 입력하세요" min="0">
					<button id="expert_confirm" class="btn btn-dark btn-sm" onclick="expertConfirm()">인증 완료</button>
				</div>
			</div>
			<div class="expert_profile_div_003">
				<div>
					사업자등록증
				</div>
				<?php if(!$expert->business_license_number):?>
				<div>
					<input type="file" class="form-control form-control-sm" name="experts_images[business_license][]">
				</div>
				<?php else:?>
				<div>
					<?php foreach($expert->business_license as $id):?>
					<label>
						<input type="hidden" name="uploaded_experts_images[business_license][]">
						<div class="file_input_img_wrapper">
							<img class="file_input_img" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
							<div class="delete-icon">×</div>
						</div>
					</label>
					<?php endforeach?>
				</div>
				<?php endif?>
			</div>
			<div class="expert_profile_div_003 expert_profile_div_004">
				<div>
					정산정보
				</div>
				<div style="padding-right:2.5px">
					<select class="form-select form-select-sm" name="experts[string][bank]">
						<option value="" disabled selected>은행명</option>
						<option value="KDB산업" <?php echo $expert->bank == 'KDB산업' ? 'selected' : ''?>>KDB산업</option>
						<option value="기업" <?php echo $expert->bank == '기업' ? 'selected' : ''?>>기업</option>
						<option value="KB국민" <?php echo $expert->bank == 'KB국민' ? 'selected' : ''?>>KB국민</option>
						<option value="수협" <?php echo $expert->bank == '수협' ? 'selected' : ''?>>수협</option>
						<option value="농협" <?php echo $expert->bank == '농협' ? 'selected' : ''?>>농협</option>
						<option value="농협중앙회" <?php echo $expert->bank == '농협중앙회' ? 'selected' : ''?>>농협중앙회</option>
						<option value="우리" <?php echo $expert->bank == '우리' ? 'selected' : ''?>>우리</option>
						<option value="SC제일" <?php echo $expert->bank == 'SC제일' ? 'selected' : ''?>>SC제일</option>
						<option value="씨티" <?php echo $expert->bank == '씨티' ? 'selected' : ''?>>씨티</option>
						<option value="우체국" <?php echo $expert->bank == '우체국' ? 'selected' : ''?>>우체국</option>
						<option value="하나" <?php echo $expert->bank == '하나' ? 'selected' : ''?>>하나</option>
						<option value="신한" <?php echo $expert->bank == '신한' ? 'selected' : ''?>>신한</option>
						<option value="대구" <?php echo $expert->bank == '대구' ? 'selected' : ''?>>대구</option>
						<option value="부산" <?php echo $expert->bank == '부산' ? 'selected' : ''?>>부산</option>
						<option value="광주" <?php echo $expert->bank == '광주' ? 'selected' : ''?>>광주</option>
						<option value="제주" <?php echo $expert->bank == '제주' ? 'selected' : ''?>>제주</option>
						<option value="전북" <?php echo $expert->bank == '전북' ? 'selected' : ''?>>전북</option>
						<option value="경남" <?php echo $expert->bank == '경남' ? 'selected' : ''?>>경남</option>
						<option value="새마을" <?php echo $expert->bank == '새마을' ? 'selected' : ''?>>새마을</option>
						<option value="신협" <?php echo $expert->bank == '신협' ? 'selected' : ''?>>신협</option>
						<option value="상호저축" <?php echo $expert->bank == '상호저축' ? 'selected' : ''?>>상호저축</option>
						<option value="HSBC" <?php echo $expert->bank == 'HSBC' ? 'selected' : ''?>>HSBC</option>
						<option value="도이치" <?php echo $expert->bank == '도이치' ? 'selected' : ''?>>도이치</option>
						<option value="JP모건" <?php echo $expert->bank == 'JP모건' ? 'selected' : ''?>>JP모건</option>
						<option value="BOA" <?php echo $expert->bank == 'BOA' ? 'selected' : ''?>>BOA</option>
						<option value="중국공상" <?php echo $expert->bank == '중국공상' ? 'selected' : ''?>>중국공상</option>
						<option value="산림조합" <?php echo $expert->bank == '산림조합' ? 'selected' : ''?>>산림조합</option>
						<option value="케이뱅크" <?php echo $expert->bank == '케이뱅크' ? 'selected' : ''?>>케이뱅크</option>
						<option value="카카오뱅크" <?php echo $expert->bank == '카카오뱅크' ? 'selected' : ''?>>카카오뱅크</option>
						<option value="토스뱅크" <?php echo $expert->bank == '토스뱅크' ? 'selected' : ''?>>토스뱅크</option>
					</select>
				</div>
				<div style="padding-left:2.5px">
					<input type="text" class="form-control form-control-sm" placeholder="예금주명" name="experts[string][bank_owner]" value="<?php echo esc_attr($expert->bank_owner)?>">
				</div>
			</div>
			<div class="expert_profile_div_003" style="margin-top: 5px;">
				<div>
				</div>
				<div>
					<input type="number" class="form-control form-control-sm" placeholder="계좌번호 숫자만 입력" min="0" name="experts[string][bank_account]" value="<?php echo esc_attr($expert->bank_account)?>">
				</div>
			</div>
			<div class="expert_profile_div_003">
				<div>
					사업장주소
				</div>
				<div class="input-group">
					<input type="text" id="addr1" class="form-control form-control-sm" placeholder="사업장 주소" min="0" name="experts[string][addr1]" onclick="addr_execDaumPostcode()" value="<?php echo esc_attr($expert->addr1)?>">
					<button type="button" class="btn btn-dark btn-sm" onclick="addr_execDaumPostcode()">주소 찾기</button>
				</div>
			</div>
			<div class="expert_profile_div_003" style="margin-top: 5px;">
				<div>
				</div>
				<div>
					<input type="text" id="addr2" class="form-control form-control-sm" placeholder="상세 주소" name="experts[string][addr2]" value="<?php echo esc_attr($expert->addr2)?>">
				</div>
			</div>

		</div>
		<!-- 추가 정보 끝 -->

		<!-- 사진 및 동영상 -->
		<div class="expert_profile_div_002">
			<div>
				<h5>사진 및 동영상</h5>
			</div>

			<div class="expert_profile_div_003 expert_profile_div_005">
				<div>
					로고사진 <!-- 1개 제한 -->
				</div>
				<div class="file-input-wrapper">
					<label class="file-input-label" onclick="addImageField(this, 'logo', 1, 'experts_images[logo][]')">
						<span class="file-input-icon">+</span>
					</label>
				</div>
				<div class="img_field_wrap">
					<?php foreach($expert->logo as $idx=>$id):?>
					<label>
						<input type="hidden" class="image_fields logo n<?php echo esc_attr($idx)?>" name="uploaded_experts_images[logo][]" value="<?php echo esc_attr($id)?>">
						<div class="file_input_img_wrapper">
							<img class="file_input_img" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
							<div class="delete-icon">×</div>
						</div>
					</label>
					<?php endforeach?>
				</div>
			</div>
			<div class="expert_profile_div_003 expert_profile_div_005">
				<div>
					배경사진 <!-- 1개 제한 -->
				</div>
				<div class="file-input-wrapper">
					<label class="file-input-label" onclick="addImageField(this, 'background', 1, 'experts_images[background][]')">
						<span class="file-input-icon">+</span>
					</label>
				</div>
				<div class="img_field_wrap">
					<?php foreach($expert->background as $idx=>$id):?>
					<label>
						<input type="hidden" class="image_fields background n<?php echo esc_attr($idx)?>" name="uploaded_experts_images[background][]" value="<?php echo esc_attr($id)?>">
						<div class="file_input_img_wrapper">
							<img class="file_input_img" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
							<div class="delete-icon">×</div>
						</div>
					</label>
					<?php endforeach?>
				</div>
			</div>
			<div class="expert_profile_div_003 expert_profile_div_005">
				<div>
					기타사진
				</div>
				<div class="file-input-wrapper">
					<label class="file-input-label" onclick="addImageField(this, 'etc', 3, 'experts_images[etc][]')">
						<span class="file-input-icon">+</span>
					</label>
				</div>
				<div class="img_field_wrap">
					<?php foreach($expert->etc as $idx=>$id):?>
					<label>
						<input type="hidden" class="image_fields etc n<?php echo esc_attr($idx)?>" name="uploaded_experts_images[etc][]" value="<?php echo esc_attr($id)?>">
						<div class="file_input_img_wrapper">
							<img class="file_input_img" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
							<div class="delete-icon">×</div>
						</div>
					</label>
					<?php endforeach?>
				</div>
			</div>
			<div class="expert_profile_div_003 expert_profile_div_005">
				<div>
					자격증관련
				</div>
				<div class="file-input-wrapper">
					<label class="file-input-label" onclick="addImageField(this, 'license', 3, 'experts_images[license][]')">
						<span class="file-input-icon">+</span>
					</label>
				</div>
				<div class="img_field_wrap">
					<?php foreach($expert->license as $idx=>$id):?>
					<label>
						<input type="hidden" class="image_fields license n<?php echo esc_attr($idx)?>" name="uploaded_experts_images[license][]" value="<?php echo esc_attr($id)?>">
						<div class="file_input_img_wrapper">
							<img class="file_input_img" src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="">
							<div class="delete-icon">×</div>
						</div>
					</label>
					<?php endforeach?>
				</div>
			</div>
			
		</div>
		<!-- 사진 및 동영상 끝 -->
		
		<div class="expert_profile_div_002">
			<div class="alert alert-secondary">
				<i class="fa" style="font-size: 14px !important;">&#xf06a;</i> 허위 정보에 대한 모든 책임은 본인에게 있습니다.<br>
				건설업 관련 서비스는 전문건설업 등록증을 통해 신뢰도를 높여보세요.
			</div>
		</div>
		
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
			</swiper-container>
		</div>
		
		<a href="<?php echo site_url('/전문가-포트폴리오-작성-수정/')?>">
			<button type="button" class="expert_profile_btn_001" style="margin-top: 10px;">포트폴리오 등록하기</button>
		</a>
		<!-- 포트폴리오 끝-->
		
		<!-- 하단 버튼 -->
		<div class="button_bottom_001">
			<a href="">
				<button type="submit">프로필 저장</button>
			</a>
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


<!-- 주소 -->
<div id="layer" style="display:none;position:fixed;overflow:hidden;z-index:999;-webkit-overflow-scrolling:touch;">
	<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
</div>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
var element_layer = document.getElementById('layer');

function closeDaumPostcode() {
	element_layer.style.display = 'none';
}

function addr_execDaumPostcode(){
	new daum.Postcode({
		oncomplete: function(data){
			document.getElementById("addr1").value = data.roadAddress;
			document.getElementById("addr2").focus();
			
			element_layer.style.display = 'none';
		},
		width : '100%',
		height : '100%',
		maxSuggestItems : 5
	}).embed(element_layer);
	
	element_layer.style.display = 'block';
	initLayerPosition();
}
function initLayerPosition(){
	var width = 350; //우편번호서비스가 들어갈 element의 width
	var height = 470; //우편번호서비스가 들어갈 element의 height
	var borderWidth = 1; //샘플에서 사용하는 border의 두께

	element_layer.style.width = width + 'px';
	element_layer.style.height = height + 'px';
	element_layer.style.border = borderWidth + 'px solid #ededed';
	element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
	element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth) + 'px';
}

//전문가프로필 서비스지역 이벤트 시작
const selectElement = document.querySelector('.selectEvent');
const selectTextDiv = document.querySelector('.selectText');

selectElement.addEventListener('change', (event) => {
	const optionText = event.target.options[event.target.selectedIndex].text;

	const selectedItem = document.createElement('span');
	selectedItem.classList.add('selected-item');
	selectedItem.textContent = optionText;

	const removeBtn = document.createElement('span');
	removeBtn.classList.add('remove-location-btn');
	removeBtn.textContent = 'x';
	removeBtn.addEventListener('click', () => {
		selectTextDiv.removeChild(selectedItem);
		
		var location = jQuery("#location").val();
		location = location.replace('-'+optionText, '');
		
		jQuery("#location").val(location);
	});

	selectedItem.appendChild(removeBtn);
	selectTextDiv.appendChild(selectedItem);
	
	var location = document.getElementById('location');
	location.value += '-'+optionText;
});

jQuery(document).ready(function () {
	jQuery(".remove-location-btn").on("click", function(){
		var local = jQuery(this).parent().text().replace('x', '');
		
		var location = jQuery("#location").val();
		location = location.replace('-'+local, '');
		
		jQuery("#location").val(location);
		
		jQuery(this).parent().remove();
	});
	
	expert_image_delete_icon();
});
//전문가프로필 서비스지역 이벤트 종료

//추가 정보 시작시간 이벤트 시작
const startTimeSelect = document.getElementById('startTime');
const endTimeSelect = document.getElementById('endTime');

startTimeSelect.addEventListener('change', (event) => {
	const selectedStartValue = parseInt(event.target.value);
	const endTimeOptions = endTimeSelect.options;

	// Reset end time to its default state
	endTimeSelect.value = "";
	
	for (let i = 0; i < endTimeOptions.length; i++) {
		const optionValue = parseInt(endTimeOptions[i].value);
		if (isNaN(optionValue)) {
			continue;
		}

		if (optionValue <= selectedStartValue) {
			endTimeOptions[i].disabled = true;
		} else {
			endTimeOptions[i].disabled = false;
		}
	}
});
//추가 정보 시작시간 이벤트 종료

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

//파일 미리보기 모달창 시작
function openModalWithImage(src) {
	const modal = jQuery('#imageModal');
	const modalImg = jQuery('#modalImage');

	modalImg.attr('src', src);
	modal.show();
}

jQuery('.file_input_img, .imgModal2').on('click', function () {
	openModalWithImage(jQuery(this).attr('src'));
});

jQuery('.close002').on('click', function () {
	jQuery('#imageModal').hide();
});

jQuery(document).on('click', function (event) {
	if(jQuery(event.target).is('#imageModal')) {
		jQuery('#imageModal').hide();
	}
});
//파일 미리보기 모달창 종료

// 추가 입력
jQuery(document).ready(function(){
	jQuery("#expert_certify").on("click", function(){
		console.log("expert_certify");
	});
	
	jQuery("#expert_confirm").on("click", function(){
		console.log("expert_confirm");
	});
});

function copyFile(from, to){
	var sourceInput = document.getElementById();
	var destinationInput = document.getElementById(to);

	// 소스 input에서 파일 가져오기
	var file = sourceInput.files[0];

	// 파일 복사하기
	var fileCopy = new File([file], file.name, { type: file.type });

	// 복사한 파일을 목적지 input에 설정
	destinationInput.files = new FileList();
	destinationInput.files.add(fileCopy);
}

function expertCertify(){
	var phone = jQuery("#user-phone").val();
	if(phone == ''){
		alert("휴대폰 번호를 입력해주세요.");
		return false;
	}
	
	data = {
		action: "binggo_expert_certify",
		phone: phone
	}
	jQuery.post(binggo_script.admin_url, data, function(res){
		alert(res.msg);
		if(res.success == true){
			jQuery(".expert_confirm_wrap").show();
		}
	});
}

function expertConfirm(){
	var confirm = jQuery("#user-phone-confirm").val();
	if(confirm == ''){
		alert("인증번호를 입력해주세요.");
		return false;
	}
	
	data = {
		action: "binggo_expert_certify",
		user_id: user_id,
		confirm: confirm,
	}
	jQuery.post(binggo_script.admin_url, data, function(res){
		alert(res.msg);
		if(res.success == true){
			jQuery("#expert_certify").remove();
			jQuery("#expert_confirm").remove();
		}
	});
}
</script>

<?php include BG_THEME_DIR.'/include/footer-expert.php'?>