<?php
/**
 * Template Name: 고객 - 의뢰서 상세보기
 */
?>

<?php include BG_THEME_DIR.'/include/header-sub.php';?>

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

$quotes_count = 0;
$quotes_row   = 0;
if($request_id){
	global $wpdb;
	
	$request_count = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}posts` WHERE `post_author` = {$request->post_author} AND `post_type` LIKE 'binggo_request'");
	
	$quotes_count = $request->get_quotes_count();
	$quotes_row   = $request->get_quotes_average();
}

$experts_images = get_user_meta($request->post_author, 'experts_images', true);
$logo           = isset($experts_images['logo']) ? $experts_images['logo'] : array();
?>

	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<div class="div_004 include001">

			<!-- 사업장 필수정보를 입력해 주세요 -->
			<div class="expert_profile_div_002" style="padding-top:20px;">
				<div class="expert_profile_div_003 expert_profile_div_004 user_construction_requests_detail_div_001">
					<div>
						<?php if($logo):?>
							<?php foreach($logo as $idx=>$id):?>
								<img src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="" width="100%" style="border-radius: 50%;">
							<?php endforeach?>
						<?php else:?>
							<img src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="" width="100%" style="border-radius: 50%;">
						<?php endif?>
					</div>
					<div>
						<h5><?php echo esc_html($request->first_name)?></h5>
						<?php echo esc_html($request->location.' '.$request->location2)?><br>
						<!-- 편의점 운영<br> -->
						의뢰내역 <?php echo esc_html($request_count)?>개
					</div>
					<div>
						비딩가<br>
						받은 견적 <?php echo esc_html($quotes_count)?>개<br>
						<?php echo number_format($quotes_row)?>원
					</div>
				</div>
			</div>

			<?php if($user->ID != $request->post_author):?>
			<div class="expert_profile_div_002">
				<div class="alert alert-secondary">
					<i class="fa" style="font-size: 14px !important;">&#xf06a;</i> 지금 견적을 보내면 고용될 확률이 높아요!
				</div>
			</div>
			<?php endif?>
			
			<!-- 요청내역 -->
			<div class="expert_profile_div_002">
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
		</div>

		<!-- 하단 버튼 -->
		<?php if($user->ID != $request->post_author):?>
		
		<?php if(in_array($request->request_status, array('admin_receive'))):?>
		<div class="button_bottom_001 button_bottom_002">
			<button style="background-color: #ededed; color:#767676; width: calc(100% - 10px); ">삭제</button>
			
			<a href="<?php echo add_query_arg('request_id', $request_id, site_url('/전문가-견적서-작성/'))?>"><button>견적서 작성하기</button></a>
		</div>
		<?php endif?>
		
		<div class="button_bottom_001">
			<?php if($request->request_status == 'quotes_request'):?>
			<!-- 견적서 발송 후 상테 -->
			<button style="background-color: #ededed; color:#767676;"   data-bs-toggle="modal" data-bs-target="#myModal">견적서 발송완료</button>
			
			<?php elseif($request->request_status == 'construct_request'):?>
			<!-- 의뢰자가 견적서 확인 후 공사 신청 상테 -->
			<button style="background-color: #4EE2FD; color:black;" id="constApp">공사 승인하기</button>
			
			<?php elseif(in_array($request->request_status, array('construct_start', 're_construct_start'))):?>
			<!-- 전문가가 공사를 승인하고 공사 진행중인 상테 -->
			<button style="background-color: red; color:white;">공사 진행중</button>
			
			<?php elseif($request->request_status == 'construct_end'):?>
			<!-- 전문가가 공사를 완료하고 공사 컨펌 상테 -->
			<button style="background-color: #ededed; color:#767676;">공사 완료</button>
			<?php endif?>
		</div>
		
		<?php endif?>
	</div>

	<!-- right space -->
	<div class="div_003"></div>


	<!-- 파일 미리보기 모달창-->
	<div id="imageModal" class="modal002">
		<span class="close002">&times;</span>
		<img class="modal-content002" id="modalImage">
		<div id="caption"></div>
	</div>

	<!-- The Modal -->
	<div class="modal" id="myModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h5 class="modal-title">보낸 견적서</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<!-- Modal body -->
				<div class="modal-body" style="padding:20px; padding-top:0;">
					<div style="width:100%; height:100%; margin-top:-60px;">
						<?php
						$html = file_get_contents('user-quotes-detail.php');

						// HTML을 UTF-8로 변환합니다.
						$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

						// DOMDocument 객체를 생성하고 HTML을 로드합니다.
						$dom = new DOMDocument;
						libxml_use_internal_errors(true); // HTML이 완벽하지 않을 경우를 대비한 에러 핸들링
						$dom->loadHTML($html);
						libxml_clear_errors(); // 에러 핸들링 종료

						$xpath = new DOMXPath($dom);
						$elements = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' modalView ')]");

						// 선택된 요소의 HTML을 출력합니다.
						foreach ($elements as $element) {
							echo $dom->saveHTML($element);
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

<script>
jQuery(document).ready(function($){
	$("#constApp").click(function(){
		var confirmation = confirm("공사를 승인 하시겠습니까?");
		if (confirmation == true) {
			data = {
				action: 'binggo_expert_construct_start',
				binggo_nonce: '<?php echo wp_create_nonce('binggo_security_'.$user->ID)?>',
				user_id: '<?php echo esc_js($user->ID)?>',
				request_id: '<?php echo esc_js($request_id)?>',
			}
			jQuery.post("<?php echo admin_url('admin-post.php')?>", data, function(res) {
				if(res.success == true){
					alert("공사가 승인 되었습니다.");
					window.location.href = '<?php echo esc_url_raw(site_url('/전문가-시공-완료/'))?>';
				}
				else{
					alert("문제가 발생했습니다.");
				}
			});
		}
		else {
			// If the user clicked "Cancel", nothing happens
			
			return false;
		}
	});
});
</script>

<?php wp_footer()?>
</body>
</html>