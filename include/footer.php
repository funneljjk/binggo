	<!-- contents -->
	<div class="div_002_01">
		<div class="footer_div_001">
			<ul class="footer_ul_001">
				<li onclick="userHome()"><img id="userMainImage" src="<?php echo BG_THEME_URL?>/img/home.png" alt="" height="28px"><br><span class="footer_spnan_001">홈</span></li>
				<li onclick="findExpert()"><img id="expertImage" src="<?php echo BG_THEME_URL?>/img/find-expert.png" alt="" height="28px"><br><span class="footer_spnan_001">전문가찾기<br>(의뢰신청)</span></li>
				<li onclick="goMarket()"><img id="shopImage" src="<?php echo BG_THEME_URL?>/img/shop.png" alt="" height="28px"><br><span class="footer_spnan_001">마켓</span></li>
				<li onclick="listConst()"><img id="constructionListImage" src="<?php echo BG_THEME_URL?>/img/construction-list.png" alt="" height="28px"><br><span class="footer_spnan_001">의뢰내역<br>(견적/A/S)</span></li>
			</ul>
		</div>
	</div>
</body>

<script>

	function updateImageIfActivePage(imageId, currentPageUrl, defaultImageUrl, activeImageUrl) {
		const currentUrl = window.location.href;
		const imageElement = document.getElementById(imageId);
		if (currentUrl.includes(currentPageUrl)) {
			imageElement.src = activeImageUrl;
		} else {
			imageElement.src = defaultImageUrl;
		}
	}

	window.addEventListener('load', function() {
		updateImageIfActivePage('userMainImage', 'user-main', '<?php echo BG_THEME_URL?>/img/home.png', '<?php echo BG_THEME_URL?>/img/home-user.png');
		updateImageIfActivePage('expertImage', 'user-expert-list', '<?php echo BG_THEME_URL?>/img/find-expert.png', '<?php echo BG_THEME_URL?>/img/find-expert-active.png');
		updateImageIfActivePage('shopImage', 'shop', '<?php echo BG_THEME_URL?>/img/shop.png', '<?php echo BG_THEME_URL?>/img/shop-active.png');
		updateImageIfActivePage('constructionListImage', 'user-construction-list', '<?php echo BG_THEME_URL?>/img/construction-list.png', '<?php echo BG_THEME_URL?>/img/construction-list-active.png');
		
	});
</script>

<?php wp_footer()?>
</html>