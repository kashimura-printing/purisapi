<?php get_header(); ?>
<div id="con">
<article>
<section>
<div class="con-blo">	
<div class="con-blo-sec">	
<p class="sec-sub-snd"><a href="<?php echo esc_url( home_url('/') ); ?>" target="_blank">HOMEへ戻る</a></p>
<h2 class="sec-sub-fst">404 File Not Found</h2>
<p>アクセスしようとしたページは見つかりませんでした。</p>
<p class="pad-top-bot-mid">このエラーは、指定したページが見つからなかったことを意味します。</p>
<h3>以下のような原因が考えられます。</h3>
<ul class="con-cir-lis">
<li>アクセスしようとしたファイルが存在しない（ファイルの設置箇所を誤っている）。</li>
<li>URLアドレスが間違っている。</li>
</ul>
</div>
</div>
</section>
</article>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>