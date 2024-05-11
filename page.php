<?php get_header(); ?>
<!--固定ページ-->
<div id="con">
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
    $viewable_authors = get_field('key_veiw_able_author');

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
            echo do_shortcode('[html-page-php-contents]');
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
                echo do_shortcode('[html-page-php-contents]');
            } else {
                // ユーザーが選択された権限を持っていない場合、制限メッセージを表示
                echo 'このページは閲覧権限が制限されています。詳しくは管理者にお問い合わせください。';
            }
        }
    } else {
        // ログインしていない場合、カスタムフィールドが空の場合のみページを表示
        if (empty($viewable_authors)) {
            // カスタムフィールドが空の場合、誰でも閲覧可能なコンテンツを表示
            //echo 'このページのコンテンツを表示するFst';
    ?>
            <article>
                <section>
                    <?php edit_post_link('この記事を編集 〉', '<p>', '</p>'); ?>
                    <?php
                    if (is_front_page()) {
                        echo '<div class="hom-con-blo">';
                    } else {
                        echo '<div class="con-blo">';
                    }
                    ?>
                    <?php if (have_posts()) : ?>
                        <?php
                        // ページ出力のループ処理をcontent.phpで実行する
                        while (have_posts()) :
                            the_post(); //ループを止めるためのカウント記述
                            the_content();
                        endwhile;
                        ?>
                    <?php else : ?>
                        <?php get_template_part('none', get_post_format()); ?>
                    <?php endif; ?>
</div>
</section>
</article>
<?php
        } else {
            // カスタムフィールドが空でない場合、ログインを促すメッセージを表示
            echo '<article>
            <section>';
            if (is_front_page()) {
                echo '<div class="hom-con-blo">';
            } else {
                echo '<div class="con-blo">';
            }
            edit_post_link('この記事を編集 〉', '<p>', '</p>');
            echo 'このページを表示するには<a href="';
            echo esc_url(home_url('/'));
            echo 'wp-login.php/" target="_self">ログイン</a>が必要です。';
            echo '</div>
            </section>
        </article>';
        }
    }
?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>