<!--
こちらはWIING WebServiceCloudのオリジナルWordPressテーマ「WIING STAFF'S」を使用しています。
余分なプラグインや機能、記述などを入れない軽量シンプルなWordPress専門テーマです。
▽WIING STAFF'S ダウンロード
https://wiing-wsc.com/staffs/
-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title><?php global $post;
            if (!is_null($post)) {
                if (get_post_meta($post->ID, 'meta_title', true)) {
                    echo get_post_meta($post->ID, 'meta_title', true) . '-';
                    bloginfo('name');
                } else {
                    the_title();
                    echo '-';
                    bloginfo('name');
                }
            } ?></title>
    <meta name="description" content="<?php
                                        if (!is_null($post)) {
                                            if (get_post_meta($post->ID, 'meta_desc', true)) {
                                                echo get_post_meta($post->ID, 'meta_desc', true);
                                            } else {
                                                bloginfo('description');
                                                echo '-';
                                                bloginfo('name');
                                            }
                                        } ?>" />
    <?php
    if (!is_null($post)) {
        if (get_post_meta($post->ID, 'meta_keyword', true)) {
            echo '<meta name="Keywords" content="';
            echo get_post_meta($post->ID, 'meta_keyword', true);
            echo '" />';
        }
    } ?>
    <meta name="author" content="WIING　WSC">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" type="image/vnd.microsoft.icon">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/apple-touch-icon.png">
    <!--<meta name="robots" content="noindex,nofollow,noarchive">-->
    <?php wp_head(); ?>
    <?php # canonical 自動取得 
    ?>
    <?php if (is_category()) { ?>
        <link rel="canonical" href="<?php echo (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>">
    <?php } else { ?>
        <?php if (!empty($custom['canonical'][0])) {
            $custom['canonical'][0] = $custom['canonical'][0];
        } elseif (!empty($custom['canonical_page'][0])) {
            $custom['canonical'][0] = $custom['canonical_page'][0];
        } else {
            $custom['canonical'][0] = get_the_permalink();
        } ?>
        <link rel="canonical" href="<?php echo $custom['canonical'][0] ?>">
    <?php } ?>
    <?php # END canonical 自動取得 
    ?>
    <link href="<?php echo get_template_directory_uri(); ?>/css/reset.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/base.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/base_res.css">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
    <?php /* ページパフォーマンス低下時のみ該当イメージをプリロードする
<link rel="preload" href="<?php echo esc_url( home_url('/') ); ?>wp-content/uploads/2024/03/ico_sma_men2.png" as="image">
*/ ?>
    <?php /* OGP START-->*/ ?>
    <meta property="og:url" content="<?php the_permalink(); ?>" />
    <meta property="og:title" content="<?php the_title(); ?>" />
    <meta property="og:description" content="<?php echo mb_substr(str_replace(array("	", "\r\n", "\r", "\n"), '', strip_tags(get_the_excerpt())), 0, 50); ?>" />
    <meta property="og:image" content="<?php if (has_post_thumbnail()) {
                                            the_post_thumbnail_url('full');
                                        } else {
                                            echo  get_template_directory_uri() . '/images/ima_pro_sor01.jpg';
                                        } ?>" />
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
    <meta property="og:locale" content="ja_JP" />

    <?php /* <meta property="fb:app_id" content="App-ID（TEL登録必須）" /> */ ?>
    <meta name="twitter:card" content="photo">
    <meta name="twitter:site" content="<?php echo esc_url(home_url('/')); ?>">
    <meta name="twitter:image" content="<?php if (has_post_thumbnail()) {
                                            the_post_thumbnail_url('full');
                                        } else {
                                            echo get_template_directory_uri() . '/images/ima_pro_sor01.jpg';
                                        } ?>" />
    <meta name="twitter:title" content="<?php the_title(); ?>">
    <meta name="twitter:description" content="<?php echo mb_substr(str_replace(array("	", "\r\n", "\r", "\n"), '', strip_tags(get_the_excerpt())), 0, 50); ?>">
    <?php /* OGP END*/ ?>
</head>

<body>

    <?php /* 解析タグを使用する場合は下記コメントの有効化
<script src="<?php echo get_template_directory_uri(); ?>/js/analytics.js" async></script>
*/ ?>
    <?php if (is_page(array('aboutus'))) : ?>
    <?php endif; ?>
    <div id="wra">
        <div class="hea-wra">
            <header>
                <div class="hea-con">
                    <h1 class="hea-lef"><a href="<?php echo esc_url(home_url('/')); ?>" title="WIING WebServiceCloudのWordPress用メディアブログテーマです。-WIING STAFF'S"><img src="<?php echo get_template_directory_uri(); ?>/images/but_log01.png" alt="WIING WebServiceCloudのWordPress用メディアブログテーマです。-WIING STAFF'S" width="120" height="120"></a></h1>
                    <div class="hea-rig">
                        <h1 class="hea-tit">
                            <?php bloginfo('name'); ?>
                        </h1>
                        <div id="hum-men-wra">
                            <div class="hum-men"><span></span> <span></span><span></span></div>
                        </div>
                    </div>
                </div>
            </header>
            <nav>
                <?php
                /*外観-メニューから以下のメニューを追加
		 'global' => 'グローバルナビ',
		'header' => 'ヘッダーナビ',
		'footer' => 'フッターナビ',
		 */
                wp_nav_menu(array(
                    'theme_location' => 'global', //メニュー位置を指定
                    'menu' => 'gloval', //WPメニュー名指定。指定しないとulにid・class指定できない
                    'menu_class' => 'men', // WPメニュー構成ul要素クラス名
                    'menu_id' => 'men', // WPメニュ構成ul要素ID名
                    'container' => 'div', // ulを囲う親要素指定。なしの場合false
                    'container_class' => 'men-wra', // コンテナ適用クラス名
                    'container_id' => 'men-wra', // コンテナ適用ID名
                ));
                ?>
            </nav>
            <?php if (is_front_page()) : ?>
                <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/base_sma_men.css">
                <div class="sma-men-nav">
                    <nav>
                        <?php
                        /*外観-メニューから以下のメニューを追加
		 'smartmenu' => 'スマートフォントップUIナビ',
		 */
                        wp_nav_menu(array(
                            'theme_location' => 'smartmenu', //メニュー位置を指定
                            'menu' => 'smartmenu', //WPメニュー名指定。指定しないとulにid・class指定できない
                            'menu_class' => 'sma-men', // WPメニュー構成ul要素クラス名
                            'menu_id' => 'sma-men', // WPメニュ構成ul要素ID名
                            'container' => 'div', // ulを囲う親要素指定。なしの場合false
                            'container_class' => 'sma-men-wra', // コンテナ適用クラス名
                            'container_id' => 'sma-men-wra', // コンテナ適用ID名
                            'link_before'     => '<span class="sma-men-ico"></span>',
                        ));
                        ?>
                    </nav>
                    <?php
                    $groupField = get_field('ico_sma_men_gro'); // グループフィールド名指定
                    // グループフィールドの値が設定されている場合
                    if ($groupField) {

                        // PHPの変数を定義します
                        $SmaIcoIma = "ico_sma_men";
                        $ImaDir = get_template_directory_uri() . '/images/';
                        $imageURL = array(); // これはあなたが前に取得したACFの子フィールドグループの画像URLの配列です

                        // メニューの数分ループして、子フィールドに画像URLが指定されていれば取得します
                        for ($i = 0; $i <= count($groupField); $i++) {
                            $subField = $SmaIcoIma . $i;
                            if (isset($groupField[$subField]) && $groupField[$subField] != '') {
                                $imageURL[] = $groupField[$subField];
                            } else {
                                //            $imageURL[] = $ImaDir . 'but_log01.png'; // 代替え画像
                                $imageURL[] = $ImaDir . $SmaIcoIma . $i . '.svg'; // 代替え画像

                            }
                        }

                        // JavaScriptのコードを出力します
                        echo "
    <script>
    $(function () {

        var SmaIcoIma = '$SmaIcoIma';
        var IcoNamNum;
        var SmaMenLen=$('.sma-men > .men-lis').length;
        var ImaDir = '$ImaDir';
        var imageURL = " . json_encode($imageURL) . ";
        if(SmaMenLen > 8){
            $('.sma-men > .men-lis').css('width','22%');  
        }
        if(SmaMenLen > 15){
            SmaMenLen = 16;
            $('.sma-men > .men-lis:nth-of-type(n+17)').hide();
        }
        for (var i = 1; i <= SmaMenLen; i++) {
            var imgSrc;
            if(imageURL[i] !== undefined && imageURL[i] !== '') {
                imgSrc = imageURL[i];
            } else {
                IcoNamNum = SmaIcoIma + i;
                imgSrc = ImaDir + '/' + IcoNamNum + '.svg';
            }
            var ImaAlt = $('.sma-men > .men-lis:nth-of-type('+i+') > a').text();
            $('.sma-men > .men-lis:nth-of-type('+i+') > a > .sma-men-ico').append('<img src=\"'+imgSrc+'\" width=\"240\" height=\"240\" alt=\"'+ImaAlt+'のイメージ\">');
        }
    });
    </script>
    ";
                    } else {
                        // グループフィールドの値が設定されていない場合
                        echo "グループフィールドの値は設定されていません。";
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- hea-wra -->
        <?php if (is_front_page()) : ?>
            <div class="mai-vis-sli-wra">
                <ul class="mai-fle-sec">
                    <li>
                        <div class="eff-mai-wra">
                            <p class="mai-fad"><img src="<?php echo get_template_directory_uri(); ?>/images/ima_mai_vis01.jpg" alt="WIING STAFF'SWordPress専用テーマの紹介のイメージ" loading="lazy"></p>
                            <p class="mai-sli">&nbsp;</p>
                        </div>
                        <h2 class="mai-vis-tit"><a href="promotion">WIING STAFF'S<br>WordPress専用テーマの紹介</a></h2>
                        <div class="eff-but-blo">
                            <button type="button" class="eff-but" onClick="location.href='promotion'">詳しく読む<img src="<?php echo get_template_directory_uri(); ?>/images/chevron-right.svg" alt="" class="but-arr"></button>
                        </div>
                    </li>
                    <li>
                        <div class="eff-mai-wra">
                            <p class="mai-fad"><img src="<?php echo get_template_directory_uri(); ?>/images/ima_mai_vis02.jpg" alt="問い合わせ社内サポートチームのイメージ" loading="lazy"></p>
                            <p class="mai-sli">&nbsp;</p>
                        </div>
                        <h2 class="mai-vis-tit"><a href="contact">問い合わせ<br>社内サポートチーム</a></h2>
                        <div class="eff-but-blo">
                            <button type="button" class="eff-but" onClick="location.href='promotion'">詳しく読む<img src="<?php echo get_template_directory_uri(); ?>/images/chevron-right.svg" alt="" class="but-arr"></button>
                        </div>
                    </li>
                    <li>
                        <div class="eff-mai-wra">
                            <p class="mai-fad"><img src="<?php echo get_template_directory_uri(); ?>/images/ima_mai_vis03.jpg" alt="WIING STAFF'S使い方ガイドのイメージ" loading="lazy"></p>
                            <p class="mai-sli">&nbsp;</p>
                        </div>
                        <h2 class="mai-vis-tit"><a href="guide">WIING STAFF'S<br>使い方ガイド</a></h2>
                        <div class="eff-but-blo">
                            <button type="button" class="eff-but" onClick="location.href='promotion'">詳しく読む<img src="<?php echo get_template_directory_uri(); ?>/images/chevron-right.svg" alt="" class="but-arr"></button>
                        </div>
                    </li>
                    <li>
                        <div class="eff-mai-wra">
                            <p class="mai-fad"><img src="<?php echo get_template_directory_uri(); ?>/images/ima_sor04.jpg" alt="WIING STAFF'Sプロフィールのイメージ" loading="lazy"></p>
                            <p class="mai-sli">&nbsp;</p>
                        </div>
                        <h2 class="mai-vis-tit"><a href="profile">WIING STAFF'S<br>プロフィール</a></h2>
                        <div class="eff-but-blo">
                            <button type="button" class="eff-but" onClick="location.href='profile'">詳しく読む<img src="<?php echo get_template_directory_uri(); ?>/images/chevron-right.svg" alt="" class="but-arr"></button>
                        </div>
                    </li>

                </ul>
            </div>
        <?php endif; ?>

        <div id="mai-con-wra">
            <?php if (is_single()) : ?>
                <?php echo do_shortcode('[htm-bre-cru]');    ?>
            <?php endif; ?>
            <?php if (is_page() && !is_front_page()) : ?>
                <?php
                $parent_id = $post->post_parent; // 親ページのIDを取得-ショートコードからだと参照不可
                $parent_slug = get_post($parent_id)->post_name;
                $parent_title = get_post($parent_id)->post_title;
                echo '<div class="bre-cru-wra">';
                echo '<div class="bre-cru"><a href="';
                echo esc_url(home_url('/'));
                echo '">HOME</a>&nbsp;〉';
                if ($parent_id) {
                    echo '<a href="';
                    echo get_permalink($parent_id);;
                    echo '">';
                    echo $parent_title;
                    echo '</a>&nbsp;〉';
                }
                echo get_the_title();
                echo '</div>';
                echo '</div>';
                ?>
            <?php endif; ?>

            <div id="mai-con">