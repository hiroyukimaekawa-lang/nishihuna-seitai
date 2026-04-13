<?php echo"<?xml version=\"1.0\" encoding=\"shift_jis\"?>"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=shift-jis" />
<title>ニュース&amp;トピックス | 西船橋のエステティックサロン PaRa パラ</title>
<meta name="description" content="ニュース&amp;トピックスページ。船橋市西船橋駅近くのエステティックサロンPaRa（パラ）では、充実した事前カウンセリングにより、お客様のご要望に沿った最適なエステの施術を行っております。" />
<meta name="keywords" content="ニュース,エステ,西船橋" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />

<link rel="stylesheet" href="http://www.pa-ra.com/style.css" />
<script type="text/javascript" src="../scripts/swfobject.js"></script>
<!--[if IE 6]>
<script src="scripts/DD_belatedPNG.js"></script>
<script>
	DD_belatedPNG.fix('div, p, h1, ul, li, a');
</script>
<![endif]-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-483787-28']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<?php
/*****************************************************************************
オブジェクト一覧
*****************************************************************************/
//日付      $object->date
//タイトル  $object->title
//本文      $object->message
//掲載数    $object->total

//クラスオブジェクト
$read[root] = DATA_ROOT2."news.cgi";
$total=$object->linkRead($read);
mb_convert_encoding($total,"SJIS","auto");
$today=date("Y.m.d");
?>


<body>
<div id="all" class="clearfix">
<div id="header" class="clearfix">

<a href="../index.php">
			<img src="../img/logo.png" alt="エステティックサロンPaRa（パラ）" width="174" height="69" /></a>
			<div id="headerRight" class="clearfix">
			<div id="headerCopy">
			<h1>船橋市西船橋のエステティックサロン</h1>
			<h2>船橋市のエステ・痩身・フェイシャル・アンチエイジングはPaRa（パラ）へ</h2></div>
			
			<div id="siteMap"><a href="http://pa-ra.com/sitemap.html">サイトマップ</a>
			</div>
			</div>
			
			<ul class="clearfix">
				
				<li id="contact"><a href="http://pa-ra.com/contact.html">お問い合わせ</a></li>
				<li id="about"><a href="http://pa-ra.com/recruit.html">スタッフ募集</a></li>
			</ul><br class="clear" />
			
	</div><!--ヘッダー-->
		
	<ul id="headMenu">
		<li id="top"><a href="http://pa-ra.com/">トップ</a></li>
		<li id="flow"><a href="http://pa-ra.com/operation.html">施術案内</a></li>
			<li id="staff"><a href="http://pa-ra.com/staff.html">スタッフ紹介</a></li>
			<li id="price"><a href="http://pa-ra.com/price.html">料金表</a></li>
			<li id="access"><a href="http://pa-ra.com/access.html">アクセス</a></li>
			<li id="faq"><a href="http://pa-ra.com/faq.html">よくあるご質問</a></li>
	</ul>


<div id="contents">
		<div id="pan">
		<a href="../index.php">船橋市のエステティックサロン PARA（パラ）</a> > ニュース&amp;トピックス</div><!--パンくず-->
		
		<div id="contentYohaku">
		<h3>ニュース&amp;トピックス</h3>
  <!-- #newsList 開始 -->
<dl id="newsList">
	<?php
	$count=count($total);
	$i=0;
	foreach($total as $ret){
		$ret=str_replace(array("\n","\r","\r\n"),"",$ret);
		$array=explode("\t",$ret);
		$date[$i]=mb_convert_encoding($array[0],"Shift_JIS","euc-jp");
		$title[$i]=mb_convert_encoding($array[1],"Shift_JIS","euc-jp");
		$message[$i]=mb_convert_encoding($array[2],"Shift_JIS","euc-jp");
		$up[$i]=mb_convert_encoding($array[3],"Shift_JIS","euc-jp");
		$i++;
	}
	for($i=$count-1;$i>=0;$i--)
	{
	if($up[$i]=="公開する"){
	?>
		<dt id="<?=$i?>" class="news_title"><span><?=$title[$i]?></span></dt>
		<dt class="date">〔更新日　<?=$date[$i]?>〕</dt>
		<dd><?=$message[$i]?></dd>
	<?php
	}
	}
	?>
	</dl>
		<!-- #newsList 終了 -->
		
		</div><!--余白-->
	</div><!--コンテンツ-->
	
	
<div id="right"	>
		<h3>お問い合わせ・ご予約</h3>
		<img src="../img/sideTel.png" alt="047-401-2239" width="249" height="36" />
		<p class="chui">千葉県船橋市西船4-11-10-202</p>
		<p class="chui">※当サロンは予約制となっております。<br />
（土日祝は混み合いますので、お早めにご予約下さい）</p>
<a href="../contact.html"><img src="../img/formButton.png" alt="フォームからお問い合わせ" onmouseover="this.src='../img/formButton2.png'" onmouseout="this.src='../img/formButton.png'" /></a>
<a href="../coupon.html"><img src="../img/courpon.gif" alt="今すぐ使えるクーポン" onmouseover="this.src='../img/courpon2.gif'" onmouseout="this.src='../img/courpon.gif'" /></a>


 <a href="http://www.nishifuna-seitai.com/" target="_blank"><img src="../img/sideBanner.jpg" onmouseover="this.src='../img/sideBanner2.jpg'" onmouseout="this.src='../img/sideBanner.jpg'" /></a>
	</div><!--ライト--><br class="clear" />	
		
		
</div><!--オール-->


<div id="footerwrap">
		<div id="footer">
		<ul class="clearfix">
			<li><a href="http://pa-ra.com/privacy.html">個人情報保護方針</a>　</li>
		</ul>
		<div id="copy">COPYRIGHT (C) 2012 PaRa ALLRIGHT RESERVED.</div>
		<br class="clear" />
		エステティックサロン PaRa（パラ）<br />
千葉県船橋市西船4-11-10-202　TEL 047-401-2239　営業時間 9:00～20:00　定休日 水曜
<hr />
Total Bodycare PaRa（パラ）は、総武線・東西線・武蔵野線の<strong>西船橋駅近く</strong>にある<strong>エステティックサロン</strong>です。充実したカウンセリングにより、お客様一人ひとりに適した施術で、お客様のご要望に沿った施術を行っております。どうぞお気軽にお問い合わせください。 </div><!--フッター-->
	</div><!--フッターwrap-->
</body>
</html>