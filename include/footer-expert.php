	<!-- contents -->
	<div class="div_002_01">
		<div class="footer_div_001">
			<ul class="footer_ul_001 footer_ul_expert_001">
				<li onclick="expertHome()"><img id="expertMainImage" src="<?php echo BG_THEME_URL?>/img/home.png" alt="" height="28px"><br><span class="footer_spnan_001">홈</span></li>
				<li onclick="findConst()"><img id="findConstImage" src="<?php echo BG_THEME_URL?>/img/construction-find.png" alt="" height="28px"><br><span class="footer_spnan_001">의뢰찾기</span></li>
				<li onclick="goMarket()"><img src="<?php echo BG_THEME_URL?>/img/shop.png" alt="" height="28px"><br><span class="footer_spnan_001">마켓</span></li>
				<li onclick="ingConst()"><img id="ingConstImage" src="<?php echo BG_THEME_URL?>/img/under-construction.png" alt="" height="28px"><br><span class="footer_spnan_001">시공중<br>(완료)</span></li>
				<li onclick="profile()"><img id="profileImage" src="<?php echo BG_THEME_URL?>/img/expert-profile.png" alt="" height="28px"><br><span class="footer_spnan_001">프로필</span></li>
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
		updateImageIfActivePage('expertMainImage', 'expert-main', '<?php echo BG_THEME_URL?>/img/home.png', '<?php echo BG_THEME_URL?>/img/home-expert.png');
		updateImageIfActivePage('findConstImage', 'expert-construction-list', '<?php echo BG_THEME_URL?>/img/construction-find.png', '<?php echo BG_THEME_URL?>/img/construction-find-active.png');
		updateImageIfActivePage('ingConstImage', 'expert-under-construction', '<?php echo BG_THEME_URL?>/img/under-construction.png', '<?php echo BG_THEME_URL?>/img/under-construction-active.png');
		updateImageIfActivePage('profileImage', 'expert-profile', '<?php echo BG_THEME_URL?>/img/expert-profile.png', '<?php echo BG_THEME_URL?>/img/expert-profile-active.png');
	});

</script>

<?php wp_footer()?>
</html>