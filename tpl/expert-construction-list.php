<?php
/**
 * Template Name: 전문가 - 의뢰찾기
 */
?>

<?php include BG_THEME_DIR.'/include/header-expert.php'?>

<?php
global $wpdb;

$f_location       = isset($_GET['f_location'])       ? sanitize_text_field($_GET['f_location'])       : '';
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

// $from  .= " LEFT JOIN `{$wpdb->prefix}postmeta` AS `expert` ON `post`.`ID` = `expert`.`post_id`";
$where .= " AND `status`.`meta_key` LIKE 'request_status' AND `status`.`meta_value` IN ('admin_receive', 'quotes_request', 'construct_request')";
// $where .= " AND `expert`.`meta_key` LIKE 'expert_id' AND `expert`.`meta_value` LIKE '{$user->ID}'";

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
		<form action="" method="get">
			<div class="user_main_div_001 expert_construction_list_div_001">
				<div>
					<select class="form-select form-select-sm" name="f_location">
						<option value="">전체지역</option> <!-- 등록된 지역 데이터 가져와서 뿌려줌 -->
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
					<select class="form-select form-select-sm" name="f_seqeunce">
						<option value="">최신순</option>
						<option value="cost" <?php echo $f_seqeunce == 'cost' ? 'selected' : ''?>>비용순</option>
					</select>
				</div>
				<div>
					<select class="form-select form-select-sm" name="f_quotes_request">
						<option value="">전체</option>
						<option value="request" <?php echo $f_quotes_request == 'request' ? 'selected' : ''?>>발송건</option>
						<option value="not_request" <?php echo $f_quotes_request == 'not_request' ? 'selected' : ''?>>미발송건</option>
					</select>
				</div>
			</div>
		</form>

		<!-- 의뢰리스트 -->
		<div class="user_expert_list_div_002">
			<?php if(!$request_list):?>
				
			<span>의뢰가 없습니다.</span>
			
			<?php else:?>
			<!-- 반복문 시작 -->
			<?php foreach($request_list as $item):?>
				<?php
					$request = new Binggo_Request($item->ID);
					
					$title = "{$request->location} {$request->location2} {$request->location3}, {$request->construct_type}";
					if($request->construct_type_etc){
						$title = "{$request->location} {$request->location2} {$request->location3}, {$request->construct_type_etc}";
					}
					
					$quotes_count = $request->get_quotes_count();
					$quotes_sum   = $request->get_quotes_sum();
				?>
			<div class="expert_construction_list_div_002">
				<div class="expert_construction_list_div_003">
					<h5><?php echo esc_html($title)?></h5>
				</div>
				<div class="expert_construction_list_div_003">
					<ul class="expert_construction_list_ul_001">
						<li>
							<?php echo esc_html($request->date)?><br>
							받은견적 : <?php echo esc_html($quotes_count)?>개<br>
							<span style="font-weight: bold;">비딩 : <?php echo number_format($quotes_sum)?>원</span>
						</li>
						<li>
							<a href="<?php echo add_query_arg('request_id', $request->ID, site_url('/고객-의뢰서-상세보기/'))?>">
								<button>자세히<br>보기</button>
							</a>
						</li>
						<li>
							<?php if($request->request_status == 'admin_receive'):?>
							<a href="<?php echo add_query_arg('request_id', $request->ID, site_url('/전문가-견적서-작성/'))?>">
								<button style="background-color: black;">견적서<br>작성하기</button>
							</a>
							
							<?php elseif($request->request_status == 'quotes_request' && $request->is_wrote_quotes($user->ID)):?>
							<button style="background-color: #ededed; color:#767676"  data-bs-toggle="modal" data-bs-target="#myModal">견적서<br>발송완료</button>
							
							<?php elseif($request->request_status == 'construct_request'):?>
							<a href="<?php echo add_query_arg('request_id', $request->ID, site_url('/고객-의뢰서-상세보기/'))?>"><button style="background-color: red;">공사요청<br>접수</button></a>
							
							<?php elseif(!in_array($request->request_status, array('admin_receive', 'quotes_request', 'construct_request'))):?>
							<button style="background-color: #ededed; color:#767676"  data-bs-toggle="modal" data-bs-target="#myModal">의뢰<br>종료</button>
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
				</div>
				<!-- <div class="overlay001"></div> 시작날짜전날 까지 의뢰자가 의뢰를 하지 않을 경우 의뢰 자동 종료 -->
			</div>
			<?php endforeach?>
			<!-- 반복문 끝 -->
			<?php endif?>
		</div>
	</div>
</div>

<!-- right space -->
<div class="div_003"></div>

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

<?php include BG_THEME_DIR.'/include/footer-expert.php'?>