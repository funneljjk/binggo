<?php
/**
 * Template Name: 고객 - 견적 리스트
 */
?>

<?php include BG_THEME_DIR.'/include/header-sub.php'?>

<?php
$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;
$request    = new Binggo_Request($request_id);
if(!$request->ID){
	echo '<script>';
	echo 'alert("잘못된 경로입니다.");';
	echo 'window.location.href="'.esc_url_raw(site_url()).'";';
	echo '</script>';
	exit;
}

$quotes_list = $request->get_quotes();

$arr = array(
	'action'       => 'binggo_user_request_end',
	'user_id'      => $user->ID,
	'binggo_nonce' => 'binggo_security_request_'.$user->ID,
	'request_id'   => $request_id,
);
$request_end_url = add_query_arg($arr, admin_url('admin-post.php'));
?>

	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<div class="div_004">
			
			<!-- 상단 select/ -->
			<div class="user_main_div_001 expert_construction_list_div_001">
				<div>
					<select class="form-select form-select-sm ">
						<option value="최신순" selected>최신순</option><!-- 왼쪽 데이터 값기준으로 뿌려줌 -->
						<option value="비용순">비용순</option>
					</select>
				</div>
				<div>
					의뢰서 등록날짜
				</div>
			</div>

			<!-- 의뢰리스트 -->
			<div class="user_expert_list_div_002">
				<!-- 반복문 시작 -->
				<?php foreach($quotes_list as $quotes):?>
					<?php
					$user_id = $quotes->post_author;
					
					$experts_images    = get_user_meta($user_id, 'experts_images', true);
					$first_name        = get_user_meta($user_id, 'first_name', true);
					$is_expert_confirm = get_user_meta($user_id, 'is_expert_confirm', true);
					$star              = get_user_meta($user_id, 'star', true);
					$hire_count        = get_user_meta($user_id, 'hire_count', true);
					$career            = get_user_meta($user_id, 'career', true);
					
					$star       =  $star       ? $star       : 0;
					$hire_count =  $hire_count ? $hire_count : 0;
					$career     =  $career     ? $career     : 0;
					
					$logo = isset($experts_images['logo']) ? $experts_images['logo'] : array();
					
					$quotes_status = get_post_meta($quotes->ID, 'quotes_status', true);
					
					global $wpdb;
					$option_sum = $wpdb->get_var("SELECT SUM(`meta_value`) FROM `wp_postmeta` WHERE `post_id` = {$quotes->ID} AND `meta_key` LIKE 'price'");
					$option_sum = $option_sum ? $option_sum : 0;
					?>
				<div class="expert_construction_list_div_002">
					<div class="expert_construction_list_div_003" style="background-color: white;">
						<ul class="expert_construction_list_ul_001">
							<li>
								<?php if($logo):?>
									<?php foreach($logo as $idx=>$id):?>
									<img src="<?php echo esc_url_raw(get_the_guid($id))?>" alt="" width="100%">
									<?php endforeach?>
								<?php else:?>
									<img src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="" width="100%">
								<?php endif?>
							</li>
							<li>
								<?php echo esc_html($first_name)?> <?php if($is_expert_confirm):?><img src="<?php echo BG_THEME_URL?>/img/certificationExpert.png" alt="인증된전문가" width="15px" style="vertical-align:top;"><?php endif?><br>
								<i class="fa fa-star fa001"></i> 평점<span class="textNum002">(<?php echo esc_html($star)?>)</span><br>
								고용 <?php echo number_format($hire_count)?>회 | 경력 <?php echo number_format($career)?>년<br>
								견적서등록 날짜 <?php echo date('Y-m-d', strtotime($quotes->post_date))?>
							</li>
							<li>
								<a href="<?php echo add_query_arg('quotes_id', $quotes->ID, site_url('/고객-견적-상세보기/'))?>"><button style="background-color: black;">견적서<br>확인하기</button></a>
							</li>
						</ul>
					</div>
					<div class="expert_construction_list_div_003">
						<div>
							<h5><?php echo number_format($option_sum)?>원</h4>
						</div>
						<div style="text-align:right;">
							<?php
							if($quotes_status == 'construct_request'){
								echo '공사신청'; // 의뢰자가 해당 전문가에게 의뢰 요청을 한 경우
							}
							elseif($quotes_status == 'matched'){
								echo '매칭완료'; // 전문가와 매칭 완료 되었을 경우
							}
							?>
						</div>
					</div>
					<!-- <div class="overlay001"></div> 견적서중 한 전문가와 매칭 될 경우 해당 전문가를 제외하고 나머지는 어둡게 처리 -->
				</div>
				<?php endforeach?>
				<!-- 반복문 끝 -->
			</div>
		</div>


		<!-- 하단 버튼 -->
		<div class="button_bottom_001">
			<?php if(!$quotes_status || $quotes_status == 'construct_request'):?>
			<a href="#">
				<button>
					요청마감 <!-- 요청마감을 클릭시 alert창이 뜨면서 의뢰요청을 마감하시겠습니까? 되돌릴 수 없습니다. 라고 띄워주고 yes 누르면 마감처리. -->
				</button>
			</a>
			<?php elseif($quotes_status == 'matched'):?>
			<button type="button">
				매칭완료  <!-- 의뢰서가 전문가와 매칭됬을때 노출, 클릭되지 않는다. -->
			</button>
			<?php elseif($quotes_status == 'end'):?>
			<button type="button">
				마감  <!-- 의뢰서가 요청마감처리 되었거나, 기간이 지나고도 매칭되지 않았을 경우 노출, 클릭되지 않는다. -->
			</button>
			<?php endif?>
		</div>


	</div>

	<!-- right space -->
	<div class="div_003"></div>

	<?php wp_footer()?>
</body>
</html>