<?php
/**
 * Template Name: 전문가 -  메인
 */
?>

<?php include BG_THEME_DIR.'/include/header-expert.php'?>

<?php
global $wpdb;

$_pageid = isset($_GET['pageid']) ? intval($_GET['pageid']) : 1;

$_from   = '';
$_where  = '';
$_order  = '';
$_limit  = 5;
$_offset = ($_pageid-1) * $_limit;

$select = '*';
$from   = $_from   ? $_from  : "`{$wpdb->prefix}posts` AS `post`";
$where  = $_where  ? $_where : "`post_status` = 'publish' AND `post`.`post_type` = 'binggo_request'";
$order  = $_order  ? $_order : "`post_date` DESC";

$limit   = '';
$_offset = $_offset ? $_offset : 0;
$_limit  = $_limit  ? $_limit  : 0;
if($_offset && $_limit){
	$limit = "LIMIT {$_offset}, {$_limit}";
}
$request_list = $wpdb->get_results("SELECT {$select} FROM {$from} WHERE {$where} ORDER BY {$order} {$limit}");

?>

<!-- left space -->
<div class="div_001"></div>

<!-- contents -->
<div class="div_002">
	<div class="div_004">

		<!-- top banner slide -->
		<div id="user_main_slide_001" class="carousel slide" data-bs-ride="carousel" >
			<!-- The slideshow/carousel -->
			<div class="carousel-inner">
				<div class="carousel-item active">
					<div class="user_main_slide_div_001"></div>
					<div class="carousel-caption">
						<h3>전문가 이용 가이드</h3>
					</div>
				</div>
				<div class="carousel-item">
					<div class="user_main_slide_div_001"></div>
					<div class="carousel-caption">
						<h3>배너01</h3>
					</div>
				</div>
				<div class="carousel-item">
					<div class="user_main_slide_div_001"></div>
					<div class="carousel-caption">
						<h3>배너02</h3>
					</div>
				</div>
			</div>
			<!-- Left and right controls/icons -->
			<button class="carousel-control-prev" type="button" data-bs-target="#user_main_slide_001" data-bs-slide="prev">
			<span class="carousel-control-prev-icon"></span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#user_main_slide_001" data-bs-slide="next">
			<span class="carousel-control-next-icon"></span>
			</button>
		</div>
		<!-- top banner slide end -->

		<!-- 최근 매칭된 전문가  -->
		<div class="user_main_div_001">
			<div>
				<h5>최근 등록된 의뢰</h5>
			</div>
			<div>
				<a href="/전문가-의뢰찾기">더보기</a>
			</div>
		</div>
		<div class="user_main_div_002 swiperChange" >
			<swiper-container class="mySwiper" init="false" pagination="false">
				<?php foreach($request_list as $request):?>
					<?php
					$request = new Binggo_Request($request->ID);
					?>
				<swiper-slide>
					<div class="card">
						<?php if(isset($request->images_list[0])):?>
						<img class="card-img-top" src="<?php echo esc_url_raw(get_the_guid($request->images_list[0]))?>" alt="Card image" style="width:100%">
						<?php else:?>
						<img class="card-img-top" src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="Card image" style="width:100%">
						<?php endif?>
						
						<div class="card-body">
							<h5 class="card-title"><?php echo esc_html($request->location.' '.$request->location2)?></h5>
							<?php echo esc_html($request->construct_type)?>
						</div>
					</div>
				</swiper-slide>
				<?php endforeach?>
			</swiper-container>
		</div>
		 <!-- 최근 매칭된 전문가 end  -->

		 <!-- 현재 시공중  -->
		<div class="user_main_div_001">
			<div>
				<h5>현재 시공중</h5>
			</div> 
		</div>
		<div class="user_main_div_002">
			<swiper-container class="mySwiper" pagination="false" effect="coverflow" grab-cursor="true" centered-slides="true"
			slides-per-view="auto" coverflow-effect-rotate="50" coverflow-effect-stretch="0" coverflow-effect-depth="100"
			coverflow-effect-modifier="1" coverflow-effect-slide-shadows="true">
			
				<?php for($i=1; $i<5; $i++):?>
				<swiper-slide class="swiper-slide_001">
					<div class="image-container"></div>
				</swiper-slide>
				<?php endfor?>

			</swiper-container>

		</div>
		 <!-- 현재 시공중  end  -->

		<!-- 최근 등록된 상품  -->
		<div class="user_main_div_001">
			<div>
				<h5>최근 등록된 상품</h5>
			</div> 
			<div>
				<a href="">더보기</a>
			</div>
		</div>
		
		<?php for($i=1; $i<5; $i++):?>
		<div class="card">
			<div class="card-body">
			  <img src="<?php echo BG_THEME_URL?>/img/ex_img.png" class="float-start" alt="Paris" width="60" height="60">
				<h5>상품명</h5>
				지역, 제품번호, 금액
			</div>
		</div>
		<?php endfor?>
		
		<!-- 최근 등록된 상품  end-->

		<!-- 빙고 이야기  -->
		<div class="user_main_div_001">
			<div>
				<h5>빙고 이야기</h5>
			</div> 
			<div>
				<a href="">더보기</a>
			</div>
		</div>
		<div style="overflow: hidden; width: 110%; margin-left: -20px;">
			<div class="user_main_div_003">
				<swiper-container class="mySwiper" pagination-clickable="false" slides-per-view="3"
				space-between="20" free-mode="true" pagination="false"  >
					
					<?php for($i=1; $i<5; $i++):?>
					<swiper-slide class="swiper_slide_002">
						<div class="image_container_002"></div>
						<h4>빙고 이야기</h4>
					</swiper-slide>
					<?php endfor?>
				</swiper-container>
			</div>
		</div>
		<!-- 빙고 이야기  end-->
	</div>
</div>

<!-- right space -->
<div class="div_003"></div>

<script>
jQuery(document).ready(function($){
	const swiperEl = document.querySelector('.swiperChange swiper-container')
	Object.assign(swiperEl, {
	  slidesPerView: 2,
	  spaceBetween: 90,
	  pagination: {
		clickable: true,
	  },
	  breakpoints: {
		450: {
		  slidesPerView: 3,
		  spaceBetween: 70,
		},
	  },
	});
	swiperEl.initialize();
});
</script>

<?php include BG_THEME_DIR.'/include/footer-expert.php'?>