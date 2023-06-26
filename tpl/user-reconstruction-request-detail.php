<?php
/**
 * Template Name: 고객 - 재시공 요청, AS 요청 내역
 */
?>

<?php include BG_THEME_DIR.'/include/header-sub.php'?>

<?php
$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;
$request    = new Binggo_Request($request_id);

$re_construct_images = $request->re_construct_images ? $request->re_construct_images['re_construct'] : array();

?>

<section class="user_reconstruction_request">
	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<div class="div_004">
			<?php if($request->expert_id != $user->ID):?>
			<div class="user_main_div_001">
				<a href="/고객-의뢰내역-견적as"><button>닫기</button></a><!-- 전문가가 시공중리스트에서 재시공 접수 버튼 눌렀을때는 숨김 -->
			</div>
			<?php endif?>
			
			<?php foreach($request->re_construct_request as $idx=>$item):?>
			<div class="expert_profile_div_002">
				<div>
					<h5>요청 <?php echo esc_html($idx+1)?></h5>
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
			
		</div>

	</div>

	<!-- right space -->
	<div class="div_003"></div>
	
</section>

	<?php wp_footer()?>
</body>
</html>