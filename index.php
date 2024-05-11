<?php get_header(); ?>
<div id="con">
	<article>
		<!--一覧ページ-->
		<section>
			<div class="con-blo">
				<?php if (have_posts()) : ?>
				<?php
					// ページ出力のループ処理をcontent.phpで実行する
					while (have_posts()) :
						the_post(); //ループを止めるためのカウント記述

						/*// デバック用　情報取得の確認
echo $cat = get_the_category(); // 情報取得
echo '<br>';
echo $catId = $cat[0]->cat_ID; // ID取得
echo '<br>';
echo $catName = $cat[0]->name; // 名称取得
echo '<br>';
echo $catSlug = $cat[0]->category_nicename; // スラッグ取得
echo '<br>';
echo $link = get_category_link($catId); // リンクURL取得
echo '<br>';
echo 'カテゴリー：<a href='.$link.'>'.$catName.'</a>';
echo '<br>';
the_title();
*/
						the_content();
					//get_template_part( 'content', get_post_format() );
					//テンプレートフォーマットを読み込む。the_content();とすると固定ページの内容を表示できます。
					// ループ処理の停止
					endwhile;
				else :
				//get_template_part( 'none', get_post_format() );
				// 記事がなければ表示させるPHPファイル
				endif;
				?>
			</div>
			<nav class="nav-sin">
				<div class="nav-sin-rig">
					<?php next_post_link('%link', '次のページ', TRUE, ''); ?>
				</div>
				<div class="nav-sin-lef">
					<?php previous_post_link('%link', '前のページ', TRUE, ''); ?>
				</div>
			</nav>
			<?php if (is_object_in_term($post->ID, 'category_name')) : //カテゴリー指定ナビ 
			?>
				<nav class="nav-sin">
					<div class="nav-sin-rig">
						<?php next_post_link('%link', '%title', TRUE, '', 'category_name'); ?>
					</div>
					<div class="nav-sin-lef">
						<?php previous_post_link('%link', '%title', TRUE, '', 'category_name'); ?>
					</div>
				</nav>
			<?php endif; ?>
		</section>
	</article>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>