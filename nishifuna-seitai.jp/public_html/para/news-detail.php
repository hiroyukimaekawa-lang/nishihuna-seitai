<?php //▼▼ 既存ページヘ埋め込み時はまるっとコピペ下さい （この行も含みページ最上部に）※.phpでかつUTF-8のページのみ可▼▼
//※逆にこのページに対して既存のページのhtmlを記述する形でももちろんOKです。
//----------------------------------------------------------------------
// 詳細ページ（ポップアップと兼用）
// 設定ファイルの読み込みとページ独自設定
//----------------------------------------------------------------------
include_once("./pkobo_news/admin/include/config.php");//（必要に応じてパスは適宜変更下さい）
$img_updir = './pkobo_news/upload';//画像保存パス（必要に応じてパスは適宜変更下さい）

$id = (!empty($_GET['id'])) ? h($_GET['id']) : exit('パラメータがありません');
$getFormatDataArr = getLines2DspData($file_path,$img_updir,$config,$id);
$dataArr = (!empty($getFormatDataArr)) ? $getFormatDataArr : exit('データが存在しません');
//----------------------------------------------------------------------
// 設定ファイルの読み込みとページ独自設定
//----------------------------------------------------------------------
//▲▲ コピペここまで ▲▲（この行も含む）?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo h(strip_tags($dataArr['title']));//タイトルを表示（必要に応じてコピペ下さい）?>｜詳細ページ</title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="Keywords" content="" />
<meta name="Description" content="<?php echo h(strip_tags($dataArr['title']));//タイトルを表示（必要に応じてコピペ下さい）?>" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />


<link rel="stylesheet" href="style.css" media="screen" />


<!--▼▼CSS。既存ページヘの埋め込み時はコピペ下さい（head部分に）▼▼-->
<style type="text/css">
/* CSSは必要最低限しか指定してませんのでお好みで（もちろん外部化OK） */
body{
	font-family:"メイリオ", Meiryo, Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;
	font-size:13px;
}
h2{
	font-size:16px;
	color:#F39;
	margin:10px 0px 10px 0;
	font-weight:normal;
	border:1px solid #F39;
	border-bottom:3px solid #F39;
	padding:5px 10px;
	text-shadow:1px 1px 0px #fff;
	
	background: rgb(255,255,255); /* Old browsers */
	background: -moz-linear-gradient(top,  rgba(255,255,255,1) 0%, rgba(243,243,243,1) 50%, rgba(237,237,237,1) 51%, rgba(255,255,255,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,1)), color-stop(50%,rgba(243,243,243,1)), color-stop(51%,rgba(237,237,237,1)), color-stop(100%,rgba(255,255,255,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(243,243,243,1) 50%,rgba(237,237,237,1) 51%,rgba(255,255,255,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(243,243,243,1) 50%,rgba(237,237,237,1) 51%,rgba(255,255,255,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(243,243,243,1) 50%,rgba(237,237,237,1) 51%,rgba(255,255,255,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom,  rgba(255,255,255,1) 0%,rgba(243,243,243,1) 50%,rgba(237,237,237,1) 51%,rgba(255,255,255,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
}
#up_ymd{
	text-align:right;
	font-size:13px;
	margin:5px 10px;
}
.detailUpfile{
	margin:5px 0 35px;
	text-align:center;
}
.backORcloseBtn{
	text-align:center;
	line-height:100%;
	margin-top:15px;
}
.backORcloseBtn a{
	display:inline-block;
	padding:4px 15px;
	border:1px solid #aaa;
	color:#999;
	border-radius:6px;
	text-decoration:none;
	font-size:12px;
}
.detailUpfile img{
	max-width:100%;
	height:auto;
}
.pNav{
	font-size:11px;	
}
</style>
<!--▲▲CSS。既存ページヘの埋め込み時　コピペここまで（head部分に）▲▲-->

</head>
<body id="body03">
<div id="all" class="clearfix">
<div id="header" class="clearfix">
<a href="index.php">
			<img src="img/logo.png" alt="エステティックサロンPaRa（パラ）" width="174" height="69" /></a>
			<div id="headerRight" class="clearfix">
			<div id="headerCopy">
			<h1>船橋市西船橋のエステティックサロン</h1>
			<h4>船橋市のエステ・痩身・フェイシャル・アンチエイジングはPaRa（パラ）へ</h4></div>
			
			<div id="siteMap"><a href="sitemap.html">サイトマップ</a>
			</div>
			</div>
			
			<ul class="clearfix">
				
				<li id="contact"><a href="contact.html">お問い合わせ</a></li>
				<li id="about"><a href="recruit.html">スタッフ募集</a></li>
			</ul><br class="clear" />
			
</div><!--ヘッダー-->
		
	<ul id="headMenu">
		<li id="top"><a href="index.php">トップ</a></li>
		<li id="flow"><a href="operation.html">施術案内</a></li>
			<li id="staff"><a href="staff.html">スタッフ紹介</a></li>
			<li id="price"><a href="price.html">料金表</a></li>
			<li id="access"><a href="access.html">アクセス</a></li>
			<li id="faq"><a href="faq.html">よくあるご質問</a></li>
	</ul><!-- #EndLibraryItem --><div id="contents">
	<div id="pan">
		<a href="index.php">船橋市のエステティックサロン PaRa（パラ）</a> > スタッフ紹介
		</div>
	<!--パンくず-->

<!--▼▼埋め込み時はここから以下をコピーして任意の場所に貼り付けてください（html部は自由に編集可）▼▼-->

<?php if(!$copyright){echo $warningMesse;exit;}else{ ?>

<?php if($config['popupFlag'] == 0){ //ポップアップ表示の場合は表示しない?>

<?php } ?>
<h2><?php echo h(strip_tags($dataArr['title']));?></h2>
<div id="up_ymd"><?php echo h($dataArr['up_ymd']);?></div>
<div id="detail">
<?php
for($i=0;$i<=$maxCommentCount;$i++){
	if(!empty($dataArr['comment'][$i]) || !empty($dataArr['upfile_path'][$i])){
		
		//アップファイル表示用のタグをセット。 画像の場合はimgタグ、その他の場合はファイルにリンクする（タグ部分は自由に変更可）
		$upfileTag = '';//初期化
		if(!empty($dataArr['upfile_path'][$i])){
			if($dataArr['file_type'][$i] == 'img'){
				$upfileTag = '<img src="'.$dataArr['upfile_path'][$i].'?'.uniqid().'" />';//画像の場合のタグ
			}else{
				$linkText = (isset($extensionListText[$dataArr['extension'][$i]])) ? $extensionListText[$dataArr['extension'][$i]] : 'アップファイル（'.$dataArr['extension'][$i].'）';//リンクテキストをセット
				$upfileTag = '<a href="'.$dataArr['upfile_path'][$i].'" target="_blank">'.$linkText.'</a>';//画像以外の場合のタグ
			}
			$upfileTag = '<div class="detailUpfile">'.$upfileTag.'</div>';
		}
?>
<div class="detailText"><?php echo (!empty($dataArr['comment'][$i])) ? $dataArr['comment'][$i] : '';?></div>
<?php echo $upfileTag;?>
<?php 
	}
}
?>
</div>
<div class="backORcloseBtn"><?php echo ($config['popupFlag'] == 1) ? '<a href="javascript:window.close()">× 閉じる</a>' : '<a href="javascript:history.back()">&lt;&lt;戻る</a>';//CLOSEボタン、または戻るボタン?></div>
<?php echo $copyright;}//著作権表記削除不可?>

<!--▲▲埋め込み時　コピーここまで▲▲-->
</div>
<div id="right"	>
		<h3>お問い合わせ・ご予約</h3>
		<img src="img/sideTel.png" alt="047-401-2239" width="249" height="36" />
		<p class="chui">千葉県船橋市西船4-11-10-102</p>
		<p class="chui">※当サロンは予約制となっております。<br />
（土日祝は混み合いますので、お早めにご予約下さい）</p>
<a href="contact.html"><img src="img/formButton.png" alt="フォームからお問い合わせ" onmouseover="this.src='img/formButton2.png'" onmouseout="this.src='img/formButton.png'" /></a>
<a href="coupon.html"><img src="img/courpon.gif" alt="今すぐ使えるクーポン" onmouseover="this.src='img/courpon2.gif'" onmouseout="this.src='img/courpon.gif'" /></a>
<a href="blog/" target="_blank"><img src="img/para-blog.jpg" alt="パラのブログ" onmouseover="this.src='img/para-blog2.jpg'" onmouseout="this.src='img/para-blog.jpg'" /></a>



 <a href="http://www.nishifuna-seitai.com/" target="_blank"><img src="img/sideBanner.jpg" onmouseover="this.src='img/sideBanner2.jpg'" onmouseout="this.src='img/sideBanner.jpg'" /></a>
	</div><br class="clear" />
		
		
		
</div><!--オール--><!-- #BeginLibraryItem "/Library/footer.lbi" --><div id="footerwrap">
		<div id="footer">
		<ul class="clearfix">
			<li><a href="privacy.html">個人情報保護方針</a>　</li>
		</ul>
		<div id="copy">COPYRIGHT (C) 2019 PaRa ALLRIGHT RESERVED.</div>
		<br class="clear" />
		西船橋のエステティックサロン トータルボディケアPaRa パラ<br />
千葉県船橋市西船4-11-10-102　TEL 047-401-2239　営業時間 9:00〜20:00　定休日 水曜
<hr />
Total Bodycare PaRa（パラ）は、総武線・東西線・武蔵野線の<strong>西船橋駅近く</strong>にある<strong>エステティックサロン</strong>です。充実したカウンセリングにより、お客様一人ひとりに適した施術で、お客様のご要望に沿った施術を行っております。どうぞお気軽にお問い合わせください。 </div>
	</div>
</body>
</html>