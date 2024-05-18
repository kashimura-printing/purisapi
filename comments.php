<?php if (have_comments()) : //コメントがあったらコメントリストを表示する 
?>
    <h3>コメント</h3>
    <ul class="commets-list">
        <?php //wp_list_comments('avatar_size=40'); 
        ?>
        <?php
        wp_list_comments(array(
            'callback'    => 'custom_comments'
        ));
        ?>
    </ul>
<?php endif; ?>
<?php
if (comments_open()) {
    comment_form();
}
?>