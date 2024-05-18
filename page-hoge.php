<?php acf_form_head(); ?>
<?php get_header(); ?>

<?php //ログインしていないか、投稿者でなければTOPへリダイレクト
// if (!is_user_logged_in()) {
// 	wp_redirect(home_url() . '/');
// }
?>

<div id="con">


	<?php while (have_posts()) : the_post(); ?>
		<?php acf_form(array(
			"post_id" => "new_post", //新規投稿
			"post_title" => true, //投稿タイトル
			'post_content' => false, //投稿内容
			'new_post' => array(
				'post_type' => 'q_and_a', //カスタム投稿
				'post_status' => 'publish' //投稿ステータス
			),
			'field_groups' => array(864), //ACFのグループID
			'submit_value' => "投稿する", //投稿ボタンの表示
			"updated_message" => "投稿しました！"
		)); ?>



	<?php endwhile; ?>
</div>



<?php get_sidebar(); ?>
<?php get_footer(); ?>