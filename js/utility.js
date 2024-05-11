/* スマートフォンUI　メニュー ACFフィールド実装により廃止 */
/*
$(function () {
  var SmaIcoIma = "ico_sma_men";
  var IcoNamNum;
  var SmaMenLen=$(".sma-men > .men-lis").length;
  var ImaDir = 'wp-content/themes/wiing-staffs/images/';
  //console.log("LENGS"+SmaMenLen);
  if(SmaMenLen > 8){
	$('.sma-men > .men-lis').css('width','22%');  
  }
    if(SmaMenLen > 15){
		SmaMenLen = 16;
		$('.sma-men > .men-lis:nth-of-type(n+17)').hide();
	}
  for (var i = 0; i <= SmaMenLen; i++) {
  IcoNamNum = SmaIcoIma + i;
  ImaAlt = $('.sma-men > .men-lis:nth-of-type('+i+') > a').text();
  //console.log(ImaAlt);
  IcoNamNum = SmaIcoIma + i;
	$('.sma-men > .men-lis:nth-of-type('+i+') > a > .sma-men-ico').append('<img src="'+ImaDir+'/'+ IcoNamNum +'.svg" width="240" height="240" alt="'+ImaAlt+'">');
  }
});
*/

/* CSS　遅延var delaycss = document.createElement('link');
    delaycss.rel = 'stylesheet';
    delaycss.href = '//wiing-wsc.com/staff/wp-content/themes/wiing-staffs/css/all.min.css';
	document.head.appendChild(delaycss);
var delaycss2 = document.createElement('link');
    delaycss2.rel = 'stylesheet';
    delaycss2.href = '';
	document.head.appendChild(delaycss2);
 */
/* アニメーション　スライド */
window.onload = function() {
  scroll_effect();
  scroll_effect_ver();
  $(window).scroll(function(){
  　scroll_effect();
　　scroll_effect_ver();
  });
  function scroll_effect(){
   $('.eff-fad').each(function(){
    var elemPos = $(this).offset().top;
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll > elemPos - windowHeight + windowHeight/5){
     $(this).addClass('eff-scr');
     $(this).next('.eff-sli').addClass('eff-sli-inn');
    }
   });
  }
  function scroll_effect_ver(){
   $('.mai-fad').each(function(){
    var elemPos = $(this).offset().top;
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll > elemPos - windowHeight + windowHeight/5){
     $(this).addClass('mai-scr');
     $(this).next('.mai-sli').addClass('mai-sli-inn');
    }
   });
  }
};
/* メニュープルダウンリスト */
function menSub() 	{
	//hoverはバブリングが発生しない
	$(".men > .men-lis > a").hover(function() {
	//$(this).css("background", "#c00");
	if (!$(this).hasClass("sel-pc")) {
      //console.log("has selected");
      jQuery(this).parent(".men-lis").children(".sub-menu").slideDown();
      jQuery(this).addClass("sel-pc");
    } 
	}, function() {
	//マウスを離したときの動作
	//$(this).css("background", "");
     jQuery(this).removeClass("sel-pc");
	});		
	//hoverはバブリングが発生しない
	$(".sub-menu").hover(function() {
	//$(this).css("background", "#c00");
	}, function() {
	//マウスを離したときの動作
	//$(this).css("background", "");
    jQuery(this).slideUp();
    //console.log("outSel");
	});	
	$("#hea-con").hover(function() {
	//$(this).css("background", "#c00");
    $(".sub-menu").slideUp();
     $(".men").removeClass("sel-pc");
	
	}, function() {
	//$(this).css("background", "");
	});	
	
}


/* ハンバーガーメニュー */
$(function () {
	$(".hum-men").on('click', function() {
    $(this).toggleClass("hum-men-act");
	if (!$(".men-wra").hasClass("men-wra-act")) {
		$(".men-wra").addClass("men-wra-act");
        $(".men-wra").slideDown();
	}		
	else if($(".men-wra").hasClass("men-wra-act")) {
	  $(".men-wra").removeClass("men-wra-act");
      $(".men-wra").slideUp();		
    }		
    });
});
//リサイズ時のメニュー表示制御
$(function () 	{
	var maxWid = 1080;
	var nowWid = $(window).width();
	$(".men-wra").css('display','block');  	
	if (nowWid > maxWid){
	menSub();		
	}else{
	$(".men-wra").hide();
	$(".men .men-lis a").off();
	$(".sub-menu .men-lis").off();
	}
	//console.log("nowWidは"+nowWid);
	$(window).resize(function () {
	var nowWid = $(window).width();
	//console.log("nowWidリサイズは"+nowWid);
	if (nowWid > maxWid){
	$(".men-wra").show();		
	menSub();		
	}else{
	$(".men-wra").hide();
	$(".men .men-lis a").off();
	$(".sub-menu .men-lis").off();
	$(".sub-menu").show();
	if($(".men-wra").hasClass("men-wra-act")) {
	$(".men-wra").show();
	}
	}
  });
		
});




/* NEWS 一覧 */
$(function () {
	
  $(".blo-faq dd").hide();
  $(".blo-faq dt").click(function () {
    if (!$(this).hasClass("selected")) {
      $(this).addClass("selected").next(".blo-faq dd").slideDown();
      $(this, ".new-tit").addClass("new-tit-vis");
    } else if ($(this).hasClass("selected")) {
      $(this).removeClass("selected").next().slideUp();
      $(this, ".new-tit").removeClass("new-tit-vis");
    }
  })
})

//ページ間アンカースクロール
$(function () {
  $(document).ready(function () {
    //URLのハッシュ値を取得
    var urlHash = location.hash;
    //ハッシュ値があればページ内スクロール
    if (urlHash) {
      //スクロールを0に戻す
      $('body,html').stop().scrollTop(0);
      setTimeout(function () {
        //ロード時の処理を待ち、時間差でスクロール実行
        scrollToAnker(urlHash);
      }, 100);
    }
    //通常のクリック時
    $('a[href^="#"]').click(function () {
      //ページ内リンク先を取得
      var href = $(this).attr("href");
      //リンク先が#か空だったらhtmlに
      var hash = href == "#" || href == "" ? 'html' : href;
      //スクロール実行
      scrollToAnker(hash);
      //リンク無効化
      return false;
    });
    // 関数：スムーススクロール
    // 指定したアンカー(#ID)へアニメーションでスクロール
    function scrollToAnker(hash) {
      var target = $(hash);
      var position = target.offset().top;
      $('body,html').stop().animate({
        scrollTop: position
      }, 500);
    }
  })
  // hide #pag-top first
  $("#pag-top").hide();
  // fade in #back-top
  $(function () {
    $(window).scroll(function () {
      if ($(this).scrollTop() > 600) {
        $('#pag-top').fadeIn();
      } else {
        $('#pag-top').fadeOut();
      }
    });
  });
});