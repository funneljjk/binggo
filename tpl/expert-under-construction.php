<?php
/**
 * Template Name: 전문가 - 시공중(완료)
 */
?>

<?php include BG_THEME_DIR.'/include/header-expert.php'?>

<?php
global $wpdb;

$f_seqeunce       = isset($_GET['f_seqeunce'])       ? sanitize_text_field($_GET['f_seqeunce'])       : 'latest';
$f_quotes_request = isset($_GET['f_quotes_request']) ? sanitize_text_field($_GET['f_quotes_request']) : '';

$_pageid = isset($_GET['pageid']) ? intval($_GET['pageid']) : 1;

$select = '*';
$from   = "`{$wpdb->prefix}posts` AS `post` LEFT JOIN `{$wpdb->prefix}postmeta` AS `status` ON `post`.`ID` = `status`.`post_id`";
$where  = "`post_status` = 'publish' AND `post`.`post_type` = 'binggo_request' AND `post_author` NOT LIKE {$user->ID}";
$order  = "`post_date` DESC";
$_limit  = 5;
$_offset = ($_pageid-1) * $_limit;
$_offset = $_offset ? $_offset : 0;

$from  .= " LEFT JOIN `{$wpdb->prefix}postmeta` AS `expert` ON `post`.`ID` = `expert`.`post_id`";
$where .= " AND `status`.`meta_key` LIKE 'request_status' AND `status`.`meta_value` NOT IN ('wait', 'admin_receive', 'quotes_request', 'construct_request')";
$where .= " AND `expert`.`meta_key` LIKE 'expert_id' AND `expert`.`meta_value` LIKE '{$user->ID}'";

$limit = '';
if($_limit && $_offset){
	$limit = "LIMIT {$_offset}, {$_limit}";
}

$request_list = $wpdb->get_results("SELECT {$select} FROM {$from} WHERE {$where} ORDER BY {$order} {$limit}");
?>
<!-- left space -->
<div class="div_001"></div>

<!-- contents -->
<div class="div_002">
	<div class="div_004">
		
		<!-- 상단 select/ -->
		<div class="user_main_div_001 expert_construction_list_div_001">
			<div>
				<select class="form-select form-select-sm " name="f_seqeunce">
					<option value="">최신순</option>
					<option value="cost" <?php echo $f_seqeunce == 'cost' ? 'selected' : ''?>>비용순</option>
				</select>
			</div>
			<div>
				<select class="form-select form-select-sm " name="f_quotes_request">
					<option value="전체">전체</option>
					<option value="request" <?php echo $f_quotes_request == 'request' ? 'selected' : ''?>>발송건</option>
					<option value="not_request" <?php echo $f_quotes_request == 'not_request' ? 'selected' : ''?>>미발송건</option>
				</select>
			</div>
		</div>

		<!-- 의뢰리스트 -->
		<div class="user_expert_list_div_002">
			<?php if(!$request_list):?>
				
			<span>시공중인 의뢰가 없습니다.</span>
				
			<?php else:?>
			<?php foreach($request_list as $item):?>
				<?php
					$request = new Binggo_Request($item->ID);
					
					$title = "{$request->location} {$request->location2} {$request->location3}, {$request->construct_type}";
					if($request->construct_type_etc){
						$title = "{$request->location} {$request->location2} {$request->location3}, {$request->construct_type_etc}";
					}
					
					$quotes_count   = $request->get_quotes_count();
					$quotes_average = $request->get_quotes_average();
				?>
			<!-- 반복문 시작 -->
			<div class="expert_construction_list_div_002">
				<div class="expert_construction_list_div_003">
					<div>
						<h5><?php echo esc_html($title)?></h5>
					</div>
					<?php if(in_array($request->request_status, array('construct_start', 'construct_end', 're_construct_start', 're_construct_end', 'as_start', 'as_end'))):?>
					<div style="text-align: right;">
						A/S n회(날짜)
						<?php echo esc_html($request->construct_end_date)?>
					</div>
					<?php endif?>
				</div>
				<div class="expert_construction_list_div_003">
					<ul class="expert_construction_list_ul_001">
						<li>
							등록날짜<br>
							받은견적 : <?php echo esc_html($request->get_quotes_count())?>개<br>
							<span style="font-weight: bold;">비용 : <?php echo number_format($request->get_quotes_sum())?>원</span>
						</li>
						
						<li>
							<?php if($request->request_status == 'construct_start'):?>
								<a href="<?php echo add_query_arg('request_id', $request->ID, site_url('/고객-의뢰서-상세보기/'))?>"><button>공사<br>진행중</button></a>
							<?php elseif($request->request_status == 're_construct_start'):?>
								<a href="<?php echo add_query_arg('request_id', $request->ID, site_url('/고객-재시공-요청-as-요청-내역/'))?>"><button>재시공<br>접수</button></a>
							<?php elseif($request->request_status == 'as_start'):?>
								<a href="<?php echo add_query_arg('request_id', $request->ID, site_url('/고객-재시공-요청-as-요청-내역/'))?>"><button>A/S<br>접수</button></a>
							<?php else:?>
								<a href="<?php echo add_query_arg('request_id', $request->ID, site_url('/고객-의뢰서-상세보기/'))?>"><button style="background-color: white; border:1px solid black; color: black;">자세히<br>보기</button></a>
							<?php endif?>
						</li>
						<li>
							<?php if(in_array($request->request_status, array('construct_start', 're_construct_start','as_start'))):?>
								<a href="<?php echo add_query_arg('request_id', $request->ID, site_url('/전문가-공사완료-요청/'))?>"><button style="background-color: red">공사완료<br>요청</button></a>
							<?php elseif($request->request_status == 'as_start'):?>
								<button>A/S완료<br>요청</button>
							<?php elseif(in_array($request->request_status, array('construct_end', 're_construct_end','as_end'))):?>
								<button style="background-color: #ededed; color:gray;">요청중</button>
							<?php elseif(in_array($request->request_status, array('construct_confirm'))):?>
								<a href="<?php echo add_query_arg('request_id', $request->ID, site_url('/고객-전체-공사-내용/'))?>"><button style="background-color: #ededed; color:gray;">공사<br>완료</button></a>
							<?php endif?>
						</li>
					</ul>
				</div>
				<div class="expert_construction_list_div_003">
					<div class="roundText"><?php echo esc_html("{$request->location} {$request->location2}")?></div>
					<div class="roundText"><?php echo esc_html($request->construct_industry)?></div>
					<div class="roundText"><?php echo esc_html($request->construct_type)?></div>
					<div class="roundText">시작일 <?php echo esc_html($request->start_date)?></div>
					<div class="roundText">종료일 <?php echo esc_html($request->end_date)?></div>
					<?php if($request->field_visit_date && $request->field_visit_time):?>
					<div class="roundText">방문일 <?php echo esc_html($request->field_visit_date, $request->field_visit_time)?></div>
					<?php endif?>
					<?php if($request->purchase_confirmation):?>
					<div class="roundText roundText002">구매확정</div>
					<?php endif?>
					<?php if($request->purchase_review):?>
					<div class="roundText roundText002">구매평작성</div>
					<?php endif?>
				</div>
				<!-- <div class="overlay001"></div>  해당부분은 공사도 완료되고, 완료날짜로 부터 1년이 지난상테 -->
			</div>
			<?php endforeach?>
			<!-- 반복문 끝 -->
			<?php endif?>
		</div>
	</div>
</div>
 
<!-- right space -->
<div class="div_003"></div>

<?php include BG_THEME_DIR.'/include/footer-expert.php';?>