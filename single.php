<?php get_header(); ?>
<div id="con">
    <!--投稿記事-->
    <?php
    // ACFで保存されたチェックボックスフィールドの値を取得
    /*
$viewable_authors = get_field('key_veiw_able_author');
if (!empty($viewable_authors)) {
    foreach ($viewable_authors as $author) {
        echo '選択された権限: ' . $author . '<br>';
    }
} else {
    echo 'チェックボックスで権限が未選択<br>';
}
*/
    ?>
    <?php
    // カスタムフィールドの選択肢と対応するWordPressの権限
    $acf_to_user_roles = array(
        'Administrator' => 'administrator',
        'Editor' => 'editor',
        'Author' => 'author',
        'Contributor' => 'contributor',
        'Subscriber' => 'subscriber'
    );

    // ログインしているかどうかを判定
    if (is_user_logged_in()) {
        // 現在のユーザー情報を取得
        $current_user = wp_get_current_user();

        // ユーザーの権限を取得
        $user_roles = (array) $current_user->roles;

        // カスタムフィールドの値が空かどうかをチェック
        if (empty($viewable_authors)) {
            // カスタムフィールドが空の場合、誰でも閲覧可能なコンテンツを表示
            //echo 'このページのコンテンツを表示するFst';
            echo do_shortcode('[html-single-php-contents]');
    ?>

            <?php
        } else {
            // カスタムフィールドが空でない場合、ユーザーの権限と選択された権限を照合して表示を制御
            // ACFのチェックボックスで選択されている権限をWordPressの権限に変換
            $selected_roles = array_map(function ($selected_role) use ($acf_to_user_roles) {
                return $acf_to_user_roles[$selected_role];
            }, $viewable_authors);

            // ユーザーの権限と選択された権限を照合して表示を制御
            if (array_intersect($selected_roles, $user_roles)) {
                // ユーザーが選択された権限を持っている場合、コンテンツを表示
                //echo 'このページのコンテンツを表示するSnd';
                echo do_shortcode('[html-single-php-contents]');
            ?>

            <?php
            } else {
                // ユーザーが選択された権限を持っていない場合、制限メッセージを表示
                echo 'このページは閲覧権限が制限されています。詳しくは管理者にお問い合わせください。';
            }
        }
    } else {
        // ログインしていない場合、カスタムフィールドが空の場合のみページを表示
        if (empty($viewable_authors)) {
            // カスタムフィールドが空の場合、誰でも閲覧可能なコンテンツを表示
            //echo 'このページのコンテンツを表示するFst2';
            ?>
            <article>
                <section>
                    <?php edit_post_link('この記事を編集 〉', '<p>', '</p>'); ?>
                    <div class="con-blo">
                        <div class="">
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
echo get_post_meta($post->ID, 'custom_field_name', true);//ワードプレス用カスタムフィールド参照
the_field("item_download", $post->ID);//ACF専用カスタムフィールド参照URL

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
                        <?php echo do_shortcode('[htm-sns-blo]'); ?>
                    </div>
                </section>

                <nav class="nav-sin">
                    <div class="nav-sin-rig"><?php next_post_link('%link', '<img src="' . get_template_directory_uri() . '/images/chevron-left.svg" />&nbsp;次のページ', TRUE, ''); ?>
                    </div>
                    <div class="nav-sin-lef">
                        <?php previous_post_link('%link', '前のページ&nbsp;<img src="' . get_template_directory_uri() . '/images/chevron-right.svg" />', TRUE, ''); ?>
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
            </article>
    <?php
        } else {
            // カスタムフィールドが空でない場合、ログインを促すメッセージを表示
            echo 'このページを表示するにはログインが必要です。';
        }
    }
    ?>

</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>