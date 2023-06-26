<?php
/**
 * Template Name: 고객 - 의뢰서 접수 완료
 */
?>

<?php include BG_THEME_DIR.'/include/header-sub.php'?>

<?php
$request = isset($_GET['request']) ? sanitize_text_field($_GET['request']) : '';
?>

	<!-- left space -->
	<div class="div_001"></div>

	<!-- contents -->
	<div class="div_002">
		<div class="index_div_001">
			<div>
				<h1>손해 없이 수리하고<br>1년 보증까지</h1>
			</div>
			<div>
				<img src="<?php echo BG_THEME_URL?>/img/ex_img.png" alt="예시 이미지 " width="50%">
			</div>
			<?php if($request == 'construct'):?>
			<div>
				<h5>
					공사 요청이 완료되었습니다.<br>
					입금되시면 전문가가 연락드립니다.<br>
					감사합니다:)
				</h3>
			</div>
			<?php else:?>
			<div>
				<h5>
					의뢰 접수가 완료되었습니다.<br>
					빙고에서 연락 드리도록 하겠습니다.<br>
					감사합니다:)
				</h3>
			</div>
			<?php endif?>
		</div>
	</div>

	<!-- right space -->
	<div class="div_003"></div>

	<script>
		jQuery(document).ready(function($){
			setTimeout(function(){
				window.location.href = "/고객-의뢰내역-견적as";
			}, 3000); // 3000ms = 3s
		});
	</script>
	
	<?php wp_footer()?>
</body>
</html>