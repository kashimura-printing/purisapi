<?php
//メンテナンス設定
function maintenance_mode() {
    if (!current_user_can('edit_themes') || !is_user_logged_in()) {
        wp_die('只今、メンテナンス中です。<br>
メンテナンス完了予定：2022/6/22 AM 8:00');
    }
}
//add_action('get_header', 'maintenance_mode');

//余計な画像srcretしない
add_filter('wp_calculate_image_srcset_meta', '__return_null');

// ビジュアルエディターとテキストエディターの切り替え時にolの自動整形不具合対処
function replace_content_on_editor_switch() {
    // 現在のページが投稿編集画面かどうかを確認
    global $pagenow;
    if ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) {
        ?>
        <script>
        jQuery(document).ready(function($) {
            // ビジュアルエディターに切り替えるボタンをクリックしたときの処理
            $('#content-tmce').on('click', function() {
                var content = $('#content').val();
                // <ol>タグ内の改行を除去する処理
                content = content.replace(/<ol(?:\s+class=["']([^"']+)["'])?>([\s\S]*?)<\/ol>/ig, function(match, classAttr, innerContent) {
                    if (classAttr) {
                        // クラス属性がある場合
                        return '<ol class="' + classAttr + '">' + innerContent.replace(/\n/g, '') + '</ol>';
                    } else {
                        // クラス属性がない場合
                        return '<ol><li>' + innerContent.replace(/\n/g, '') + '</li></ol>';
                    }
                });
                $('#content').val(content);
            });

            // テキストエディターに切り替えるボタンをクリックしたときの処理
            $('#content-html').on('click', function() {
                var content = $('#content').val();
                // 不適切なタグを制御する処理
                content = content.replace(/<ol(?:\s+class=["']([^"']+)["'])?>([\s\S]*?)<\/ol>/ig, function(match, classAttr, innerContent) {
                    if (innerContent.trim() === '') {
                        // 内容が空の場合は空にする
                        return '';
                    }
                    // ビジュアルエディターに切り替えるときに不要な処理なし
                    return match;
                });
                $('#content').val(content);
            });
        });
        </script>
        <?php
    }
}
add_action( 'admin_notices', 'replace_content_on_editor_switch' );

// WordPress自動更新通知メール停止
add_filter('auto_core_update_send_email' , '__return_false');
// WPテーマ自動更新通知メール停止(有効化するとテーマが削除できない場合がある)
//add_filter( 'auto_theme_update_send_email', '__return_false' );
// // WPプラグイン自動更新通知メール停止(有効化するとテーマが削除できない場合がある)
//add_filter( 'auto_plugin_update_send_email', '__return_false' );

//linkタグstyleインクルード制御
function additional_tags_for_tiny_mce( $settings ) {
    if ( ! empty( $settings['valid_children'] ) ) {
        $settings['valid_children'] .= ';';
    } else {
        $settings['valid_children'] = '';
    }
 
    $settings['valid_children'] .= '+body[link|meta|style],+div[span|meta],+span[span|meta]';
 
    return $settings;
}
add_filter( 'tiny_mce_before_init', 'additional_tags_for_tiny_mce' );

//カテゴリータイトル<span>等制御
add_filter('get_the_archive_title', function($ArcNam){
if(is_category()){
$ArcNam = single_cat_title('',false);
}elseif(is_date()) {
$ArcNam = get_the_time('Y年 n月');
}elseif(is_tag()) {
$ArcNam = single_tag_title('',false);
}elseif(is_tax()) {
$ArcNam = single_term_title('',false);
}elseif(is_404()) {
$ArcNam = '404 Not Found';
}else{
}
return $ArcNam;
});


//post-snippetsアップデート停止
add_filter('site_option__site_transient_update_plugins', 'plugin_update_stop4');
function plugin_update_stop4($data) {
    $plugin_name = 'post-snippets/post-snippets.php';
    if (isset($data->response[$plugin_name])) {
        unset($data->response[$plugin_name]);
    }
    return $data;
}
//simple-membershipアップデート停止
add_filter('site_option__site_transient_update_plugins', 'plugin_update_stop');
function plugin_update_stop($data) {
    $plugin_name = 'simple-membership/simple-wp-membership.php';
    if (isset($data->response[$plugin_name])) {
        unset($data->response[$plugin_name]);
    }
    return $data;
}
//プラグインアップデート停止
add_filter('site_option__site_transient_update_plugins', 'plugin_update_stop3');
function plugin_update_stop3($data) {
    $plugin_name = 'addquicktag/addquicktag.php';
    if (isset($data->response[$plugin_name])) {
        unset($data->response[$plugin_name]);
    }
    return $data;
}
add_filter('site_option__site_transient_update_plugins', 'plugin_update_stop2');
function plugin_update_stop2($data) {
    $plugin_name = 'all-in-one-wp-migration/all-in-one-wp-migration.php';
    if (isset($data->response[$plugin_name])) {
        unset($data->response[$plugin_name]);
    }
    return $data;
}


// ACFカスタムフィールドの位置表示制御
function clear_meta_box_order(){
    // 通常の投稿ページの編集画面
    delete_user_meta( wp_get_current_user()->ID, 'meta-box-order_post' );
    // 固定ページの編集画面
    delete_user_meta( wp_get_current_user()->ID, 'meta-box-order_page' );
}
add_action( 'admin_init', 'clear_meta_box_order' );

// CDN　dnsプリヘッチを停止する
function remove_dns_prefetch( $hints, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
        return array_diff( wp_dependencies_unique_hosts(), $hints );
    }
    return $hints;
}
add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );
// titleタグをhead内に生成する
//add_theme_support( 'title-tag' );
	
// HTML5でマークアップさせる
//add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	
// Feedのリンクを自動で生成する
//add_theme_support( 'automatic-feed-links' );
	
//外観項目にメニュー項目を追加する
//register_nav_menu('mainmenu', 'メインメニュー'); 

//アイキャッチ画像表示
add_theme_support( 'post-thumbnails' );

// カスタムヘッダー機能を有効化
add_theme_support( 'custom-header' ); 

// ウィジェット内ショートコードを有効化
add_filter('widget_text', 'do_shortcode' );

register_sidebar(array (
'name' => 'サイドバーウェジェット',
'id' => 'sid-bar',
'description' => '',
'before_widget' => '<div  id="%1$s" class="%2$s nav-blo">',
'after_widget' => '</div>',
'before_title' => '<h2 class="nav-tit">',
'after_title' => '</h2><hr>',
 ));


//WordPress自動挿Pタグを無効化
    add_filter('the_content', 'wpautop_filter', 9);
    function wpautop_filter($content) {
        global $post;
        $remove_filter = false;
        $arr_types = array('page'); //自動整形を無効にする投稿タイプを記述
        $post_type = get_post_type( $post->ID );
        if (in_array($post_type, $arr_types)) $remove_filter = true;
        if ( $remove_filter ) {
            remove_filter('the_content', 'wpautop');
            remove_filter('the_excerpt', 'wpautop');
        }
        return $content;
    }

//WordPress自動挿各種タグを無効化
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles' );
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head','rest_output_link_wp_head');
remove_action('wp_head','wp_oembed_add_discovery_links');
remove_action('wp_head','wp_oembed_add_host_js');
remove_action('wp_head', 'rsd_link');
remove_action( 'wp_head', 'wlwmanifest_link' );

//外観にメニュー機能を有効化
add_theme_support('menus');

function lab_setup() {
	register_nav_menus( array(
		'global' => 'グローバルナビ',
		'header' => 'ヘッダーナビ',
		'footer' => 'フッターナビ',
		'smartmenu' => 'スマートフォントップUIメニュー',
	) );
	
}
add_action( 'after_setup_theme', 'lab_setup' );

//  メニュータグからクラスを削除して、表示中メニューに 'current' クラスを付与する
add_filter( 'nav_menu_css_class', 'my_custom_nav', 10, 2 );
function my_custom_nav( $classes, $item ) {
    //     $classes を空にする前にカスタムクラスを変数へ入れておく        
    if( !empty( $classes[0] ) ){
        $custom_class = esc_attr( $classes[0] );
	}
	$classes = array();
    if( $item -> current == true ) {
        $classes[] = 'current';
	}
    $custom_class = 'men-lis';//liに入れるクラス名
    // 先に変数に入れておいたカスタムクラス名を配列へ入れる
    if( !empty( $custom_class ) ){
        $classes[] = $custom_class;
	}
    return $classes;
}
// メニュータグからID を削除する 
add_filter('nav_menu_item_id', 'removeId', 10);
function removeId( $id ){ 
    return $id = array(); 
}

//ページネーション
function get_responsive_pagination($_pagination_range_pc,$_pagination_range_sp){
    global $wp_query;
    $total_posts_num = $wp_query->found_posts;
    //記事数が0の場合終了
    if ($total_posts_num == 0) return;
    //1ページに表示する範囲
    $page_range = get_query_var('posts_per_page');
    //合計ページ数
    $total_page_num = ceil($total_posts_num/$page_range);
    //現在のページを取得
    $index_page_num = get_query_var('paged') ? get_query_var('paged') :1 ;
    //開始件数を取得
    $from = $page_range * ($index_page_num - 1 ) + 1;
    //終了件数を取得
    $to = $page_range * $index_page_num;
    //開始件数から終了件数
    $from_to = '';
    //合計該当記事数が終了件数より小さい場合、終了件数に設定
    if($total_posts_num <= $to)$to = $total_posts_num;
    if($total_posts_num == 1 ){
        $from_to = $from;
    }else{
        $from_to = $from.'〜'.$to;
    }
    if($from == $to)$from_to = $from;
    /* PC */
    $pagination_range = $_pagination_range_pc;
    //ページャー範囲が合計ページ数より多い場合
    if ($pagination_range >= $total_page_num) $pagination_range = $total_page_num;
    $pagination_offset = floor($pagination_range / 2);
    $pagination_from_limit = $total_page_num - $pagination_range + 1;
    $offset_from = $index_page_num - $pagination_offset;
    if ($offset_from <= 1) $offset_from = 1;
    if ($offset_from >= $pagination_from_limit) $offset_from = $pagination_from_limit;
    $offset_to = $offset_from + $pagination_range;

    /* SP */
    $pagination_range_sp = $_pagination_range_sp;
    //ページャー範囲が合計ページ数より多い場合
    if ($pagination_range_sp >= $total_page_num) $pagination_range_sp = $total_page_num;
    $pagination_offset_sp = floor($pagination_range_sp / 2);
    $pagination_from_limit_sp = $total_page_num - $pagination_range_sp + 1;
    $offset_from_sp = $index_page_num - $pagination_offset_sp;
    if ($offset_from_sp <= 1) $offset_from_sp = 1;
    if ($offset_from_sp >= $pagination_from_limit_sp) $offset_from_sp = $pagination_from_limit_sp;
    $offset_to_sp = $offset_from_sp + $pagination_range_sp;

    $add_class = '';
    $source = '';
    if($total_page_num > $_pagination_range_sp + 2 ) $add_class .= ' pagination-range-over-sp';
    if($total_page_num > $_pagination_range_pc + 2 ) $add_class .= ' pagination-range-over-pc';
    $source .= '<nav class="pag-nav'.$add_class.'">'."\n";
    $source .= '<ul class="clearfix">'."\n";

    //prev first
    if($index_page_num != 1 ) {
        $source .= '<li class="pagination-no-num first"><a href="'.get_pagenum_link(1).'"><i class="fas fa-angle-double-left"></i></a></li>'."\n";
        $source .= '<li class="pagination-no-num prev"><a href="'.get_pagenum_link($index_page_num - 1).'"><i class="fas fa-angle-left"></i></span></a></li>'."\n";
    }else{
        $source .= '<li class="pagination-no-num first"><span><i class="fas fa-angle-left"></i></span></li>'."\n";
        $source .= '<li class="pagination-no-num prev"><span><i class="fas fa-angle-double-left"></i></span></li>'."\n";
    }

    for ($i=$offset_from; $i < $offset_to; $i++){
        if($index_page_num == $i){
            if($i>=$offset_from_sp && $i<$offset_to_sp){
                $source .= '<li class="pagination-index pagination-sp"><span>'.$i.'</span></li>'."\n";
            }else{
                $source .= '<li class="pagination-index"><span>'.$i.'</span></li>'."\n";
            }
        }else{
            if($i>=$offset_from_sp && $i<$offset_to_sp){
                $source .= '<li class="pagination-sp"><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>'."\n";
            }else{
                $source .= '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>'."\n";
            }
        }
    }

    //next last
    if($index_page_num != $total_page_num) {
        $source .= '<li class="pagination-no-num next"><a href="'.get_pagenum_link($index_page_num + 1).'"><i class="fas fa-angle-right"></i></a></li>'."\n";
        $source .= '<li class="pagination-no-num last"><a href="'.get_pagenum_link($total_page_num).'"><i class="fas fa-angle-double-right"></i></a></li>'."\n";
    }else{
        $source .= '<li class="pagination-no-num next"><span><i class="fas fa-angle-right"></i></span></li>'."\n";
        $source .= '<li class="pagination-no-num last"><span><i class="fas fa-angle-double-right"></i></span></li>'."\n";
    }

    $source .= '</ul>'."\n";
    $source .= '</nav>'."\n";
    $source .= '<div class="pagination-txt">'.$from_to.'<span> / '.$total_posts_num.'件</div>'."\n";

    echo $source;

}

// ページビュー数を取得する
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }

    // is_single() で単一の投稿ページであることを確認し、ページビュー数を増加させる
    if (is_single() || is_page()) {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }

    return $count.' Views';
}

// フロントエンドでのページビュー数増加アクションを追加
function increment_post_views(){
   global $post;
   if(is_single() || is_page()){
       getPostViews($post->ID);
   }
}
add_action('wp_head', 'increment_post_views');

// 管理画面にページビュー数を表示する

function count_add_column_data( $column, $post_id ) {
    switch ( $column ) {
        case 'views' :
            echo getPostViews($post_id);
            break;
    }
}
add_action( 'manage_posts_custom_column' , 'count_add_column_data', 10, 2 );
add_action( 'manage_pages_custom_column' , 'count_add_column_data', 10, 2 );


// 管理画面に閲覧数項目を追加する
function count_add_column( $columns ) {
$columns['views'] = '閲覧数';
$columns['thumbnail'] = 'サムネイル';
    return $columns;
}
add_filter( 'manage_posts_columns', 'count_add_column' );
add_filter( 'manage_pages_columns', 'count_add_column' );
 
// 閲覧数項目を並び替えれる要素にする
function column_views_sortable( $newcolumn ) {
    $columns['views'] = 'views';
    return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'column_views_sortable' );
add_filter( 'manage_edit-page_sortable_columns', 'column_views_sortable' );
 
// ページビュー数で並び替えるようにリクエストを送る
function sort_views_column( $vars )
{
    if ( isset( $vars['orderby'] ) && 'views' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'post_views_count', //Custom field key
            'orderby' => 'meta_value_num') //Custom field value (number)
        );
    }
    return $vars;	
}
add_filter( 'request', 'sort_views_column' );

/*サムネイル呼び出し=管理画面に閲覧数項目を追加するで配列配置 */
function add_thumnail($column_name, $post_id) {
  if ( $column_name == 'thumbnail') {
    $thumb = get_the_post_thumbnail($post_id, array(100,100), 'thumbnail');
   /*ない場合は「なし」を表示する*/
echo '<style>.column-thumbnail img{
max-width:100%;
width:100px;
height:auto;
}</style>';
	  if ( isset($thumb) && $thumb ) {
		echo $thumb;
	  }
	  else {
		  echo '<img src="';
echo get_template_directory_uri();
echo '/images/but_log01.svg" style="width:100px;">';
		//echo __('None');
	 }
  }
}	
add_action( 'manage_posts_custom_column', 'add_thumnail', 10, 2 );
add_action( 'manage_pages_custom_column', 'add_thumnail', 10, 2 );


// 一般設定に会員閲覧項目を追加
function custom_general_settings() {
    add_settings_field(
        'my_require_login_setting',
        '閲覧制限を有効化する',
        'my_require_login_setting_callback',
        'general'
    );
    register_setting('general', 'my_require_login_setting');
}
add_action('admin_init', 'custom_general_settings');

// 会員閲覧項目のコールバック関数
function my_require_login_setting_callback() {
    $value = get_option('my_require_login_setting');
    echo '<input type="checkbox" id="my_require_login_setting" name="my_require_login_setting" value="1" ' . checked(1, $value, false) . '/>';
}

// JavaScript を使用して設定項目を移動する
function move_my_require_login_setting() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#my_require_login_setting').closest('tr').insertBefore($('#blogname').closest('tr'));
        });
    </script>
    <?php
}
add_action('admin_print_footer_scripts', 'move_my_require_login_setting');


// 会員閲覧設定の値に基づいて関数を呼び出す
function check_my_require_login_setting() {
    $my_require_login_setting = get_option('my_require_login_setting');
    if ($my_require_login_setting == 1) {
        my_require_login();
    }
}
add_action('init', 'check_my_require_login_setting');


// ログインしないとサイトを見れない
function my_require_login() {
  global $pagenow;
  if ( ! is_user_logged_in() &&
       $pagenow !== 'wp-login.php' &&
       ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) &&
       ! ( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
      auth_redirect();
  }
}
//add_action( 'init', 'my_require_login' ); //無効

//　ログイン画面 ロゴカスタマイズ
function custom_login_logo() { ?>
  <style>
    .login #login h1 a{
      width: 100%;
      height:140px;
      background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/but_log01.png) no-repeat center;
	background-size: 50% auto;
    }
  </style>
<?php }
add_action( 'login_enqueue_scripts', 'custom_login_logo' );
function custom_login_logo_url() {
  return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'custom_login_logo_url' );

//Gutenberg用CSS読み込み削除
//theme.min.css削除はwp_dequeue_style( 'wp-block-library-theme' );を追記
add_action( 'wp_enqueue_scripts', 'remove_block_library_style' );
function remove_block_library_style() {
  wp_dequeue_style( 'wp-block-library' );
}

//++++++++++++++++++++++++++++++++++++++++++++++
// 以下追加記述

// カスタム投稿タイプの追加
add_action( 'init', 'create_post_type' );
function create_post_type() {
    register_post_type( 'q_and_a', [ // 投稿タイプ名の定義
        'labels' => [
            'name'          => 'Q&A', // 管理画面上で表示する投稿タイプ名
            'singular_name' => 'q_and_a', // カスタム投稿の識別名
        ],
        'public'        => true,  // 投稿タイプをpublicにするか
        'has_archive'   => true, // アーカイブ機能ON/OFF
        'menu_position' => 5,     // 管理画面上での配置場所
        'show_in_rest'  => true,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ,'comments' ),
    ]);
}

// カスタムカテゴリーの追加
register_taxonomy('q_and_a_category', array('q_and_a'), array(
    'labels' => array(
        'name' => 'Q&Aカテゴリー'
    ),
    'hierarchical' => true,
    'rewrite' => array('slug' => 'qa_cat') 
));
?>
<?php
// コールバック関数を使ってコメント表示部分をカスタマイズする
function custom_comments( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' : ?>
            <li <?php comment_class(); ?> id="comment<?php comment_ID(); ?>">
            <div class="back-link"><?php comment_author_link(); ?></div>
        <?php break;
        default : ?>
            <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <article <?php comment_class(); ?> class="comment">
                    <div class="comment-body">
                        <div class="author vcard">
                            <?php echo get_avatar( $comment, 100 ); ?>
                            <span class="author-name"><?php comment_author(); ?></span>
                            <?php comment_text(); ?>
                            <?php
                            if( get_field('comment_put_img', $comment) ): 
                            ?>
                                <img src="<?php the_field('comment_put_img', $comment); ?>">
                            <?php endif; ?>
                        </div><!-- .vcard -->
                    </div><!-- comment-body -->
 
                    <footer class="comment-footer">
                        <time <?php comment_time( 'c' ); ?> class="comment-time">
                            <span class="date">
                                <?php comment_date(); ?>
                            </span>
                            <span class="time">
                                <?php comment_time(); ?>
                            </span>
                        </time>
                        <div class="reply"><?php 
                            comment_reply_link( array_merge( $args, array( 
                                'reply_text' => '返信',
                                // 'after' => ' <span>&amp;amp;darr;</span>', 
                                'depth' => $depth,
                                'max_depth' => $args['max_depth'] 
                            ) ) ); ?>
                        </div><!-- .reply -->
                    </footer><!-- .comment-footer -->
 
                </article><!-- #comment-<?php comment_ID(); ?> -->
        <?php // End the default styling of comment
        break;
    endswitch;
}