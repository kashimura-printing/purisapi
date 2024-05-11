<?php get_header(); ?>
<div id="con">
    <article>
        <section>
            <?php if (!in_category(array('non_cat'))) : ?>
                <div class="con-blo">
                    <div class="con-blo-sec">
                        <?php if (have_posts()) : ?>
                            <h1 class="page-title"><?php printf(__('検索結果%s', 'wiingsearch'), '<span>『' . esc_html(get_search_query()) . '』</span>'); ?></h1>
                            <ul class="cir-lis mar-top-bot-mid">
                                <?php while (have_posts()) : the_post(); // ループ開始. 
                                ?>
                                    <?php the_title(sprintf('<li><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></li>'); ?>
                                <?php endwhile; // ループエンド. 
                                ?>
                            </ul>
                        <?php else :
                            echo '<h1 class="page-title">検索結果：一致するページは見つかりませんでした。</h1>';
                            echo '<li>お手数ですがご不明点な点はMeChac総合サポート窓口にお問い合わせください。</li>';

                        //	get_template_part( 'content', 'none' );// 結果がない場合にページを表示させる場合.
                        endif; ?>
                    </div>
                </div>
                <?php get_responsive_pagination(7, 4); ?>
            <?php else : ?>
                <div class="con-blo">
                    <div class="con-blo-sec">

                        <h1 class="page-title">検索結果：一致するページは見つかりませんでした。</h1>
                        <ul class="cir-lis mar-top-bot-mid">
                            <li>カテゴリーが適切に選択されていない可能性があります。</li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </article>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>