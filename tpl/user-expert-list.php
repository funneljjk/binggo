<?php
/**
 * Template Name: 고객 - 전문가찾기(의뢰신청)
 */
?>

<?php include BG_THEME_DIR.'/include/header.php'?>

<?php
global $wpdb;

$_wishlist = isset($_GET['wishlist']) ? intval($_GET['wishlist']) : 0;

$f_seqeunce = isset($_GET['f_seqeunce']) ? sanitize_text_field($_GET['f_seqeunce']) : '';
$f_location = isset($_GET['f_location']) ? sanitize_text_field($_GET['f_location']) : '';

$_pageid = isset($_GET['pageid']) ? intval($_GET['pageid']) : 1;

$select = '*';
$where  = "`expert`.`meta_key` LIKE 'is_expert' AND `expert`.`meta_value` LIKE 1";
$order  = "`users`.`ID` DESC";
$_limit  = 5;
$_offset = ($_pageid-1) * $_limit;
$_offset = $offset ? $offset : 0;

$from = "`{$wpdb->prefix}users` AS `users` LEFT JOIN `{$wpdb->prefix}usermeta` AS `expert` ON `users`.`ID` = `expert`.`user_id`";
if($f_seqeunce){
	$from  .= " LEFT JOIN `{$wpdb->prefix}usermeta` AS `seqeunce` ON `users`.`ID` = `meta`.`user_id`";
	$where .= " AND `seqeunce`.`meta_key` LIKE '{$f_seqeunce}'";
	$order  = " `seqeunce`.`meta_value` DESC";
	if($f_seqeunce == 'first_name'){
		$order = "`seqeunce`.`meta_value` ASC";
	}
}
if($f_location){
	$from .= " LEFT JOIN `{$wpdb->prefix}usermeta` AS `location` ON `users`.`ID` = `meta`.`user_id`";
	$where .= " AND `location`.`meta_key` LIKE 'location' AND `location`.`meta_value` LIKE '%{$f_location}%'";
}

if($_wishlist){
	$wishlist = get_user_meta($_wishlist, 'wishlist', true);
	$where .= " AND `users`.`ID` IN ($_wishlist)";
}

$limit   = '';
if($_offset && $_limit){
	$limit = "LIMIT {$_offset}, {$_limit}";
}

$experts = $wpdb->get_results("SELECT {$select} FROM {$from} WHERE {$where} ORDER BY {$order} {$limit}");
?>

<!-- left space -->
<div class="div_001"></div>

<!-- contents -->
<div class="div_002">
	<div class="div_004">

		<!-- 상단 select/wishlist -->
		<form action="" method="get">
		<div class="user_main_div_001 user_expert_list_div_001">
			<div>
				<select class="form-select form-select-sm " name="f_seqeunce">
					<option value="first_name"  <?php echo $f_seqeunce == 'first_name' ? 'selected' : ''?>>이름순</option><!-- 왼쪽 데이터 값기준으로 뿌려줌 -->
					<option value="hire_count" <?php echo $f_seqeunce == 'hire_count' ? 'selected' : ''?>>고용순</option>
					<option value="star" <?php echo $f_seqeunce == 'star' ? 'selected' : ''?>>평점순</option>
					<option value="review" <?php echo $f_seqeunce == 'review' ? 'selected' : ''?>>리뷰순</option>
				</select>
			</div>
			<div>
				<select class="form-select form-select-sm " name="f_location">
					<option value="전체지역" selected>전체지역</option><!-- 등록된 지역 데이터 가져와서 뿌려줌 -->
					<option value="강원도" <?php echo $f_location == '강원도' ? 'selected' : ''?>>강원도</option>
					<option value="경기도" <?php echo $f_location == '경기도' ? 'selected' : ''?>>경기도</option>
					<option value="경상남도" <?php echo $f_location == '경상남도' ? 'selected' : ''?>>경상남도</option>
					<option value="경상북도" <?php echo $f_location == '경상북도' ? 'selected' : ''?>>경상북도</option>
					<option value="광주광역시" <?php echo $f_location == '광주광역시' ? 'selected' : ''?>>광주광역시</option>
					<option value="대구광역시" <?php echo $f_location == '대구광역시' ? 'selected' : ''?>>대구광역시</option>
					<option value="대전광역시" <?php echo $f_location == '대전광역시' ? 'selected' : ''?>>대전광역시</option>
					<option value="부산광역시" <?php echo $f_location == '부산광역시' ? 'selected' : ''?>>부산광역시</option>
					<option value="서울특별시" <?php echo $f_location == '서울특별시' ? 'selected' : ''?>>서울특별시</option>
					<option value="세종특별자치시" <?php echo $f_location == '세종특별자치시' ? 'selected' : ''?>>세종특별자치시</option>
					<option value="울산광역시" <?php echo $f_location == '울산광역시' ? 'selected' : ''?>>울산광역시</option>
					<option value="인천광역시" <?php echo $f_location == '인천광역시' ? 'selected' : ''?>>인천광역시</option>
					<option value="전라남도" <?php echo $f_location == '전라남도' ? 'selected' : ''?>>전라남도</option>
					<option value="전라북도" <?php echo $f_location == '전라북도' ? 'selected' : ''?>>전라북도</option>
					<option value="제주특별자치도" <?php echo $f_location == '제주특별자치도' ? 'selected' : ''?>>제주특별자치도</option>
					<option value="충청남도" <?php echo $f_location == '충청남도' ? 'selected' : ''?>>충청남도</option>
					<option value="충청북도" <?php echo $f_location == '충청북도' ? 'selected' : ''?>>충청북도</option>
				</select>
			</div>
			<div>
				<i class="fa fa-heart" id="heartBtn" onclick="toggleHeartColorList(this)" style="color:#ededed;" alt="즐겨찾기"></i>
			</div>
		</div>
		</form>
		<!-- 상단 select/wishlist end-->

		<!-- 전문가 리스트 -->
		<div class="user_main_div_001 user_expert_list_div_002">
			
			<ul class="user_expert_list_ul_001">
				<!-- 반복 구간 시작 -->
				<?php foreach($experts as $expert):?>
					<?php
					$expert = new Experts($expert->ID);
					
					$expert->experts_images;
					$expert->first_name;
					$expert->is_expert_confirm;
					$expert->star;
					$expert->hire_count;
					$expert->career;
					?>
				<li>
					<a href="<?php echo add_query_arg('expert_id', $expert->ID, site_url('/고객-전문가-프로필-상세보기/'))?>">
						<h5><?php echo esc_html($expert->first_name)?>  <?php if($expert->is_expert_confirm):?><img src="<?php echo BG_THEME_URL?>/img/certificationExpert.png" alt="인증된전문가" width="15px" style="vertical-align:top;"><?php endif?></h5>
						<h6><i class="fa fa-star fa001"></i> 평점<span class="textNum002">(<?php echo esc_html($star)?>)</span> | <?php echo number_format($hire_count)?>회 | <?php echo number_format($career)?>년</h6>
						<div><?php echo wpautop($expert->service_description)?></div>
					</a>
				</li>
				<li style="position:relative">
					<div class="user_expert_list_ul_div_001">
						<i class="fa fa-heart heartBtn2" onclick="toggleHeartColor(this)" data-expert="<?php echo esc_attr($expert->ID)?>" style="color:#ededed;" alt="즐겨찾기"></i>
					</div>
					<?php if($expert->logo):?>
						<?php foreach($expert->logo as $idx=>$id):?>
						<img src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="" width="100%">
						<?php endforeach?>
					<?php else:?>
						<img src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="" width="100%">
					<?php endif?>
				</li>
				<hr class="hr_001">
				<?php endforeach?>
				<!-- 반복 구간 끝 -->
			</ul>

		</div>
		<!-- 전문가 리스트 end-->

		<!-- 하단 버튼 -->
		<div class="button_bottom_001">
			<a href="/고객-의뢰서-작성"><button>의뢰신청</button></a>
		</div>


	</div>
</div>

<!-- right space -->
<div class="div_003"></div>

<?php include BG_THEME_DIR.'/include/footer.php'?>