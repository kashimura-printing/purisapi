<?php get_header(); ?>
<!--アーカイブ-->
<div id="con">
	<article>
		<section>
			<?php if (have_posts()) :
				the_archive_title('<h1 class="bre-cru">', '</h1>');
				//		the_archive_description( '<h2">', '</h2>' );
			?>
				<div class="con-blo-non">
				<?php while (have_posts()) : 	the_post(); //ループを止めるためのカウント記述
					$cat = get_the_category(); // カテゴリー名取得
					$catId = $cat[0]->cat_ID; // ID取得
					$catNam = $cat[0]->name; // 名称取得
					$catSlu = $cat[0]->category_nicename; // スラッグ取得
					$catLin = get_category_link($catId); // リンクURL取得

					echo '<section>';
					echo '<div class="con-blo mar-bot-tal">';
					echo '<p class="sec-dat">';
					the_time("Y/m/d", $post->ID);
					echo '</p>';
					echo '<h2 class="sec-tit"><a href="';
					the_permalink();
					echo '">';
					the_title();
					echo '</a></h2>';
					echo '<p class="sec-cat-tit"><a href="';
					echo $catLin;
					echo '">';
					echo $catNam;
					echo '</a></p>';
					echo '<p class="con-blo-ima"><a href="';
					the_permalink();
					echo '">';
					if (has_post_thumbnail()) {
						the_post_thumbnail('post-thumbnail');
					} else {
						echo '<img src="';
						echo get_template_directory_uri();
						echo '/images/ima_pro_sor01.jpg">';
					}
					echo '</a></p>';
					echo '<div class="pad-mid">';
					the_excerpt();
					echo '<div class="eff-but-blo pad-top-bot-tal">';
					echo '<button type="button" class="eff-but" onClick="';
					echo <<<EOM
location.href='
EOM;
					the_permalink();
					echo <<<EOM
'
EOM;
					echo '">';
					echo '詳しく読む<i class="fas fa-angle-right"></i></button>';
					echo '</div>';
					echo '</div>';

					echo '</div>';
					echo '</section>';

				//		the_title();
				//		the_content();
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
				<?php get_responsive_pagination(7, 4); ?>
		</section>
	</article>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>