<div class="nav">
    <?php if (is_active_sidebar('sid-bar')) : //ウィジェット有効判断
        dynamic_sidebar('sid-bar'); ?>
    <?php else : ?>
    <?php endif; ?>
</div>