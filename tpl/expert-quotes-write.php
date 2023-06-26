<?php
/**
 * Template Name: 전문가 - 견적서 작성
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
?>

<form action="<?php echo esc_url(admin_url('admin-post.php'))?>" method="post">
	<?php wp_nonce_field('binggo_security_quotes_'.$user->ID, 'binggo_nonce')?>
	<input type="hidden" name="action" value="binggo_expert_quotes">
	<input type="hidden" id="user_id" name="user_id" value="<?php echo esc_attr($user->ID)?>">
	<input type="hidden" id="request_id" name="request_id" value="<?php echo esc_attr($request_id)?>">
	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<div class="div_004">
			<!-- <div class="user_main_div_001">
				<button data-bs-toggle="modal" data-bs-target="#myModal">고객 의뢰서</button>
			</div> -->

			<!--  가격 옵션 1  -->
			<div class="expert_profile_div_002 user_reconstruction_request_div_001 expert_quotes_write_div_001" style="position:relative">
				<div>
					<h5>가격 옵션 1</h5>
				</div>
				<div class="expert_profile_div_003"> 
					<div>
						<h6>옵션 이름</h6>
					</div>
					<div>
						<input type="text" class="form-control form-control-sm optionText" placeholder="" name="quotes[array][option_name][]">
					</div>
				</div>
				<div class="expert_profile_div_003">
					<div>
						<h6>옵션 가격</h6>
					</div>
					<div>
						<input type="number" class="form-control form-control-sm optionWon" placeholder="숫자만 입렵 하세요." name="quotes[array][option_price][]">
					</div>
				</div>
			   
			</div>
			<!--  가격 옵션 1 끝 -->


			<div class="expert_profile_div_002" style="text-align: center; font-weight:600; font-size:20px;">
				<span>총 <span id="totalWon">0</span>원</span>
			</div>
			<div class="expert_profile_div_002" style="text-align: center; cursor:pointer;">
				<span class="requeBtn003">+ 옵션 추가하기</span>
			</div>


			<!--  견적 설명  -->
			<div class="expert_profile_div_002">
				<div>
					<h5>견적 설명</h5>
				</div>
				<div>
					<textarea class="form-control" rows="5" id="comment2" name="quotes[textarea][content]" placeholder="요성사항에 대한 답변, 서비스 진행방식, 전문가님만의 강점이나 특징 등을 작성해 주세요."></textarea>
				</div>
			</div>
			<!--  견적 설명 끝 -->


		</div>

		<!-- 하단 버튼 -->
		<div class="button_bottom_001">
			<a href=""><button>견적서 발송</button></a>
		</div>

	</div>

	<!-- right space -->
	<div class="div_003"></div>
</form>
	
	<!-- The Modal -->
	<div class="modal" id="myModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h5 class="modal-title">고객 의뢰서</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<!-- Modal body -->
				<div class="modal-body" style="padding:20px; padding-top:0;">
					<div style="width:100%; height:100%; margin-top:-70px;">
						<?php
						$url  = add_query_arg('request_id', $request->ID, site_url('/고객-의뢰서-상세보기/'));
						$html = file_get_contents($url);

						// HTML을 UTF-8로 변환합니다.
						$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

						// DOMDocument 객체를 생성하고 HTML을 로드합니다.
						$dom = new DOMDocument;
						libxml_use_internal_errors(true); // HTML이 완벽하지 않을 경우를 대비한 에러 핸들링
						$dom->loadHTML($html);
						libxml_clear_errors(); // 에러 핸들링 종료

						$xpath = new DOMXPath($dom);
						$elements = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' include001 ')]");

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
		
		jQuery(document).ready(function($) {

			function calculateSum() {
		var sum = 0;
		$('.optionWon').each(function(){
			var inputVal = $(this).val();
			if($.isNumeric(inputVal)){
				sum += parseFloat(inputVal);
			}
		});
		$('#totalWon').text(sum);
	}

	$('.requeBtn003').click(function() {
		var clonedDiv = $('.expert_quotes_write_div_001:first').clone();
		clonedDiv.find('.optionWon').val(''); // clear the value of the input field in the cloned div
		clonedDiv.find('.optionText').val(''); // clear the value of the input field in the cloned div
		var nextRequestNumber = $('.expert_quotes_write_div_001').length + 1;
		clonedDiv.find('h5').text('가격 옵션 ' + nextRequestNumber);
		clonedDiv.append('<span class="deleteRequestBtn" style="position: absolute; top: 0; right: 0; cursor:pointer;">삭제</span>');
		clonedDiv.insertAfter('.expert_quotes_write_div_001:last');
		calculateSum(); // call the sum calculation function here
	});
	
	jQuery(document).on('click', '.deleteRequestBtn', function() {
		$(this).closest('.expert_quotes_write_div_001').remove();
		$('.expert_quotes_write_div_001').each(function(index) {
			$(this).find('h5').text('가격 옵션 ' + (index + 1));
		});
		calculateSum(); // call the sum calculation function here
	});

	jQuery(document).on('input', '.optionWon', function() {
		calculateSum();
	});

});

</script>
<?php wp_footer()?>
</body>
</html>