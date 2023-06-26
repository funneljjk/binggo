<?php
/**
 * Template Name: 고객 - 의뢰내역(견적/A/S)
 */
?>

<?php include BG_THEME_DIR.'/include/header.php'?>

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
$where  = $_where  ? $_where : "`post_status` = 'publish' AND `post`.`post_type` = 'binggo_request' AND `post_author` LIKE {$user->ID}";
$order  = $_order  ? $_order : "`post_date` DESC";

$limit   = '';
$_offset = $_offset ? $_offset : 0;
$_limit  = $_limit  ? $_limit  : 0;
if($_offset && $_limit){
	$limit = "LIMIT {$_offset}, {$_limit}";
}

$request_list = $wpdb->get_results("SELECT {$select} FROM {$from} WHERE {$where} ORDER BY {$order} {$limit}");
?>

<section class="user_construction_list ">
	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<div class="div_004">
			
			<!-- 의뢰리스트 -->
			<div class="user_expert_list_div_002">
				<!-- 반복문 시작 -->
				<?php foreach($request_list as $item):?>
					<?php
					$request = new Binggo_Request($item->ID);
					
					$progress1 = 0;
					if(in_array($request->request_status, array('admin_receive', 'quotes_request'))){
						$progress1 = 25;
					}
					elseif(in_array($request->request_status, array('construct_start', 're_construct_start', 'as_start'))){
						$progress1 = 50;
					}
					elseif(in_array($request->request_status, array('construct_end', 're_construct_end', 'as_end'))){
						$progress1 = 75;
					}
					
					$progress2 = 0;
					if(in_array($request->request_status, array('construct_end', 're_construct_end', 'as_end'))){
						$progress2 = 25;
					}
					// elseif(in_array($request->request_status, array('construct_start'))){
					// 	$progress2 = 50;
					// }
					?>
				<div class="expert_construction_list_div_002">
					<a href="<?php echo add_query_arg('request_id', $request->ID, site_url('/고객-의뢰서-상세보기/'))?>">
						<div class="expert_construction_list_div_003">
							<div class="user_construction_list_div_001"><h5><?php echo "{$request->location} {$request->location2}, {$request->construct_industry}"?></h5></div>
							<div class="user_construction_list_div_002"><?php echo $request->date?></div>
						</div>
					</a>
					<div class="expert_construction_list_div_003">
						<input class="rangeInput001" type="range" min="0" max="75" step="25" value="<?php echo esc_attr($progress1)?>" disabled>
						<ul class="user_construction_list_ul_001">
							<li><span class="rangeText <?php echo $progress1 == 0 ? 'rangeText_active' : ''?>">견적요청</span></li>
							<li style="text-align: center;"><span class="rangeText <?php echo $progress1 == 25 ? 'rangeText_active' : ''?>" style="margin-left: -25px;">컨펌완료</span></li>
							<li style="text-align: center;"><span class="rangeText <?php echo $progress1 == 50 ? 'rangeText_active' : ''?>" style="margin-right: -25px;">공사신청</span></li>
							<li style="text-align: right;">
								<span class="rangeText <?php echo $progress1 == 75 ? 'rangeText_active' : ''?>">
									<?php
									if($request->request_status == 'end'){
										echo '거래종료';
									}
									else{
										echo '거래확정';
									}
									?>
								</span>
							</li>
						</ul>
						
						<?php if(in_array($request->request_status, array('construct_start', 'construct_end', 're_construct_start', 're_construct_end', 'as_start', 'as_end'))):?>
						<input class="rangeInput002" type="range" min="0" max="50" step="25" value="<?php echo esc_attr($progress2)?>" disabled>
						<ul class="user_construction_list_ul_002">
							<li>
								<span class="rangeText">
								<?php
								if(in_array($request->request_status, array('construct_start', 'construct_end'))){
									echo '공사시작';
								}
								elseif(in_array($request->request_status, array('re_construct_request', 're_construct_start', 're_construct_end'))){
									echo '재시공시작';
								}
								?>
								</span>
							</li>
							<li style="text-align: center;"><span class="rangeText <?php echo $progress2 == 25 ? 'rangeText_active' : ''?>">공사완료</span></li>
							<li style="text-align: right;"><span class="rangeText <?php echo $progress2 == 50 ? 'rangeText_active' : ''?>">공사완료확정</span></li>
						</ul>
						<?php endif?>
					</div>
					<div class="expert_construction_list_div_003" onclick="quotesListMove('<?php echo add_query_arg('request_id', $request->ID, site_url('/고객-견적-리스트/'))?>')" style="cursor:pointer;">
						<?php
						$quotes_list = $request->get_quotes();
						if($request->request_status == 'quotes_request' && $quotes_list):
						?>
						<div class="feedText001">
							<?php
							foreach($quotes_list as $quotes):
								$experts_images = get_user_meta($user->ID, 'experts_images', true);
								$logo           = isset($experts_images['logo']) ? $experts_images['logo'] : array();
							?>
								<?php if($logo):?>
									<?php foreach($logo as $idx=>$id):?>
									<img src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="" width="40px">
									<?php endforeach?>
								<?php else:?>
									<img src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="" width="40px">
								<?php endif?>
							<?php endforeach?>
						</div>
						<?php endif?>
						
						<div class="feedText001 feedText003">
							<?php
							if(in_array($request->request_status, array('wait', 'admin_receive'))){
								echo '의뢰서가 등록되었습니다.';
							}
							elseif($request->request_status == 'quotes_request'){
								echo $request->get_quotes_count().'건의 견적서를 확인하세요.';
							}
							elseif($request->request_status == 'construct_request'){
								echo '공사신청이 접수 되었습니다.';
							}
							// elseif($request->request_status == 'construct_request'){
							// 	echo '공사가 확정되어 전문가와 매칭 되었습니다.'; // 불필요
							// }
							elseif($request->request_status == 'construct_start'){
								echo '공사가 시작되었습니다.';
							}
							elseif($request->request_status == 'construct_end'){
								echo '공사가 완료되었습니다.';
							}
							elseif($request->request_status == 'as_request'){
								echo 'A/S가 접수 되었습니다.';
							}
							elseif($request->request_status == 're_construct_start'){
								echo '재시공이 시작되었습니다.';
							}
							elseif($request->request_status == 'end'){
								echo '거래가 종료되었습니다.';
							}
							?>
						</div>
						<?php if($request->construct_end_date):?>
						<div class="feedText002">
							<?php echo esc_html($request->construct_confirm_date ? $request->construct_confirm_date : $request->construct_end_date)?>
						</div>
						<?php endif?>
					</div>
					
					<div class="expert_construction_list_div_003">
						<?php if(in_array($request->request_status, array('construct_end', 're_construct_end'))):?>
						<div class="user_construction_list_btn_001">
							<a href="<?php echo add_query_arg('request_id', $request->ID, site_url('/고객-공사완료-확정/'))?>">
								<button>
									공사완료확정<br><span style="font-size: 12px;">(7일 후 자동 확정)</span>
								</button>
							</a>
						</div>
						<div class="user_construction_list_btn_002">
							<a href="<?php echo add_query_arg('request_id', $request->ID, site_url('/고객-재시공-요청-as-요청/'))?>">
								<button>재시공 요청</button>
							</a>
						</div>
						
						<?php elseif($request->request_status == 're_construct_start'):?>
						<div class="user_construction_list_btn_003">
							<button>재시공접수 완료</button>
						</div>
						
						<?php elseif(in_array($request->request_status, array('construct_confirm'))):?>
						<div class="user_construction_list_btn_003">
							<a href="<?php echo add_query_arg('request_id', $request->ID, site_url('/고객-재시공-요청-as-요청/'))?>">
								<button class="asActive">A/S요청<span style="font-size: 12px;">(공사완료날짜 기준으로 1년간)</span></button>
							</a>
						</div>
						
						<?php elseif($request->request_status == 'as_start'):?>
						<div class="user_construction_list_btn_003">
							<button class="asDisabled">a/s접수완료</button>
						</div>
						
						<?php elseif($request->request_status == 'as_end'):?>
						<div class="user_construction_list_btn_003">
							<button class="asActive asComplete">A/S완료확정<span style="font-size: 12px;">(7일 후 자동 확정)</span></button>
						</div>
						
						<?php elseif($request->request_status == 'end'):?>
						<div class="user_construction_list_btn_003">
							<button class="asDisabled">a/s접수불가<span style="font-size: 12px;">(공사완료된지 1년이 지났습니다)</span></button>
						</div>
						
						<?php endif?>
					</div>
					
					<!-- <div class="overlay001"></div> 시작날짜전날 까지 의뢰자가 의뢰를 하지 않을 경우 의뢰 자동 종료 -->
				</div>
				<?php endforeach?>
			</div>
		</div>
	</div>
	
	<!-- right space -->
	<div class="div_003"></div>
	
</section>
	
<script>
//레인지 텍스트 색상 변경
// function updateRangeText(range, targetUlClass) {
// 	const rangeTexts = document.querySelector(targetUlClass).getElementsByClassName("rangeText");
// 	for (let i = 0; i < rangeTexts.length; i++) {
// 	  rangeTexts[i].classList.remove("rangeText_active");
// 	}
	
// 	if (range.value == 0) {
// 		rangeTexts[0].classList.add("rangeText_active");
// 	} else if (range.value == 25) {
// 	  rangeTexts[1].classList.add("rangeText_active");
// 	} else if (range.value == 50) {
// 		rangeTexts[2].classList.add("rangeText_active");
// 	} else if (range.value == 75) {
// 	  rangeTexts[3].classList.add("rangeText_active");
// 	}
// }

// document.addEventListener("DOMContentLoaded", function() {
// 	updateRangeText(document.querySelector(".rangeInput001"), '.user_construction_list_ul_001');
// 	updateRangeText(document.querySelector(".rangeInput002"), '.user_construction_list_ul_002');
// });

function quotesListMove(src){
	window.location.href = src;
}

jQuery(document).ready(function($){
	$(".asComplete").click(function(){
	var confirmation = confirm("A/S완료를 확정 하시겠습니까?");
	if (confirmation == true) {
		alert("A/S 완료가 확정되었습니다.");
	}
	else {
		return;
	}
});
});
</script>

<?php include BG_THEME_DIR.'/include/footer.php'?>
<?php wp_footer()?>
</body>
</html>