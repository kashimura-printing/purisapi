</div>
<!--#mai-con-->
</div>
<!-- #mai-con-wra -->
<footer>
	<div id="foo-wra">
		<div id="foo-con">
			<div class="foo-men">
				<h2 class="foo-men-tit">管理人</h2>
				<hr>
				<div class="foo-men-tex">
					<p>WIING STAFF'SはWIING WebServiceCloud 合同会社の社内ポータルサイト用WordPressテーマです。</p>
					<p>社内や部署内で必要な情報を共有していきます。ログインしないとサイト閲覧できない仕様です。</p>

				</div>
			</div>
			<div class="foo-rig-blo">
				<p class="foo-log"><a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/but_log01.png" alt="WIING MEDIA-WordPressテーマ"></a></p>
			</div>
			<div class="foo-sns-blo">
				<?php
				wp_nav_menu(array(
					'theme_location' => 'footer', //functionに指定したメニュー位置を指定
					'menu' => 'foot-nav', //メニュー名を指定。指定しないとulにid等指定できない
					'menu_class' => 'foo-men-lis', // メニュー構成ul要素クラス名
					'menu_id' => '', // メニュ構成するul要素ID名
					'container' => '', // ulを囲う親タグ要素。親要素なしの場合には false
					'container_class' => 'foo-men-cla', // コンテナ適用クラス名
					'container_id' => 'foo-men', // コンテナ適用ID名
				));
				?>
				<?php /* 遅くなるので<a class="twitter-timeline" href="https://twitter.com/wiingwsc?ref_src=twsrc%5Etfw">Tweets by wiingwsc</a>
                    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
					*/ ?>
			</div>

		</div>
	</div>
	<div id="cop">&copy; <a href="https://wiing-wsc.com">WIING WebServiceCloud</a>.</div>
</footer>
</div>
<p id="pag-top" class="src-anc cle-bot"><a href="#wra" rel="noopener noreferrer" aria-label="ページトップへ"><img src="<?php echo get_template_directory_uri(); ?>/images/arrow-up.svg" alt=""></a></p>
<?php wp_footer(); ?>
<!--function.phpやプラグインを読込、WordPressシステム読込の記述-->
</body>

</html>