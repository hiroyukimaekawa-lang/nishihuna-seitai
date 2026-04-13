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

<link href="../../css/common.css" rel="stylesheet" type="text/css" />
<link href="../../css/sub_common.css" rel="stylesheet" type="text/css" />
<link href="../../favicon.ico" rel="shortcut icon" />
<link href="favicon.ico" rel="../../shortcut icon" />

<!--▼▼CSS。既存ページヘの埋め込み時はコピペ下さい（head部分に）▼▼-->
<style type="text/css">
/* CSSは必要最低限しか指定してませんのでお好みで（もちろん外部化OK） */
body{
	font-family:"メイリオ", Meiryo, Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;
	font-size:13px;
}
h2{
	font-size:16px;
	color:#369;
	margin:10px 0px 10px 0;
	font-weight:normal;
	border:1px solid #3D79B6;
	border-bottom:3px solid #3D79B6;
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


<!--[if IE 6]>
<script src="js/DD_belatedPNG.js"></script>
<script>
	DD_belatedPNG.fix('div,h1,a,dl,dt,dd,ul,li');
</script>
<![endif]-->

</head>

<body id="wrap"><!-- #wrap Start -->
<div id="header"><!-- #header Start -->
		<div id="h1">
			<h1>JR総武線 西船橋駅から徒歩2分のカイロプラクティックセンター</h1>
				<ul>
					<li id="hNavi01"><a href="../../about/">当院について</a></li>
					<li id="hNavi02"><a href="../../contact/">お問い合わせ</a></li>
				</ul>
	</div>
		
		<p><a href="../../" rel="top home start">西船整体院 - 船橋市の骨盤・O脚・X脚矯正、脚痩せ</a></p>
			<ul id="tNavi">
				<li id="tNavi01"><a href="sitemap.html" rel="index">サイトマップ</a></li>
				<li id="tNavi02"><a href="access/">アクセスマップ</a></li>
			</ul>
			<br class="clearB" />
	</div><!-- #header end -->
	
	<div id="container"><!-- #container Start -->
		
			<ul id="mNavi">
				<li id="mNavi01">トップ</li>
				<li id="mNavi02"><a href="../../introduction/">院内紹介</a></li>
				<li id="mNavi03"><a href="../../flow/">施術の流れ</a></li>
				<li id="mNavi04"><a href="../../treatment/">診療内容</a></li>
				<li id="mNavi05"><a href="../../price/">料金表</a></li>
				<li id="mNavi06"><a href="../../voice/">お客様の声</a></li>
				<li id="mNavi07"><a href="../../faq/">よくある質問</a></li>
			</ul>
			<br class="clearB" />
		
		<div id="contents">
			<div id="leftContents">


<!--▼▼埋め込み時はここから以下をコピーして任意の場所に貼り付けてください（html部は自由に編集可）▼▼-->

<?php if(!$copyright){echo $warningMesse;exit;}else{ ?>

<?php if($config['popupFlag'] == 0){ //ポップアップ表示の場合は表示しない?>
<div class="pNav"><a href="./">トップページ</a> &gt; <a href="news.php">お知らせ一覧</a> &gt; <?php echo h(strip_tags($dataArr['title']));?></div><!-- パンくずナビ（必要に応じて変更、削除下さい） -->
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


        <br class="clear" />
		<ul id="pageTop" class="clearfix">
			<li><a href="#wrap">ページ上へ戻る</a></li>
		</ul>


			</div><!-- #leftContents end -->
			
			<div id="rightContents"><!-- #rightContents Start -->
<h3>西船整体院へのお問い合わせ・予約はこちら</h3>
<h4>｜診療時間</h4>
<dl>
<dt>［受付］</dt>
<dd>9:00〜20:00</dd>
<dt>［休診］</dt>
<dd>水曜日（土日祝も施術を行っています）</dd>
</dl>
<br class="clearB" />
<ul id="toAccess">
<li><a href="access/">西船整体院へのアクセス</a></li>
</ul>
<div class="h-tag4">｜お電話でのお問い合わせ・ご予約</div>
<p id="tel">047-433-3377</p>
<p id="reserve">※当院は予約制となっております。<br />（土日祝は混み合いますので、お早めにご予約下さい）</p>
<div class="h-tag4">｜メールフォームでのお問い合わせ</div>
<p id="inquiry"><a href="../../contact/">お問い合わせ</a></p>
<p class="small">&nbsp;&nbsp;&nbsp;※ご予約はお電話のみとなっております。</p>

<div class="mobileTitle">西船整体院携帯サイト</div>
<div id="mobile">
<p>携帯電話からでも西船整体院の情報がご覧頂けます。左記QRコード、またはURL送信ボタンをご利用下さい。</p>
<p id="url"><a href="mailto:***@***?body=http://www.ac.cyberhome.ne.jp/~nishifuna/mobile/">URLを送信</a></p>
</div>

<ul id="staff">
<li><a href="../../staff/">スタッフ紹介</a></li>
</ul>
<div id="ad">
<p><a href="http://www.pa-ra.com" target="_blank"><img src="../../images/nishifuna-para.jpg" alt="トータルボディーケアPaRa（パラ）" width="255" height="279" /></a></p></div>
<p><img src="../../cgi-bin/daycount/daycount.cgi?gif" alt="カウンター" /></p>
</div><!-- #rightContents End -->
		</div><!-- #contents end -->
	
	</div><!-- #container end -->
	
	
	<br class="clearB" />
<div id="footer"><!-- #footer Start -->
<div id="footerContainer"><!-- #footerContainer Start -->
<div id="footerInfo"><!-- #footerInfo Start -->
<div class="h-tag2">西船整体院</div>
<address>千葉県船橋市西船4-11-10 1F<br />
TEL&nbsp;047-433-3377<br />
営業時間&nbsp;9:00〜20:00<br />
定休日&nbsp;水曜<br />
<span>COPYRIGHT&nbsp;&copy;&nbsp;2009-2018&nbsp;<a href="./" rel="top home start">NISHIFUNA-SEITAIIN</a>&nbsp;ALLRIGHT&nbsp;RESERVED.</span>
</address>
</div><!-- #footerInfo End -->
<ul id="fNavi01">
<li>-&nbsp;<a href="../../" rel="top home start">TOP</a></li>
<li>-&nbsp;<a href="../../about/">当院について</a></li>
<li>-&nbsp;<a href="../../introduction/">院内紹介</a></li>
<li>-&nbsp;<a href="../../staff/">スタッフ紹介</a></li>
<li>-&nbsp;<a href="../../flow/">施術の流れ</a></li>
<li>-&nbsp;<a href="../../price/">料金表</a>&nbsp;-&nbsp;<a href="coupon/">クーポン</a></li>
</ul>
<ul id="fNavi02">
<li>-&nbsp;<a href="../../voice/">お客様の声</a></li>
<li>-&nbsp;<a href="../../faq/">よくある質問</a></li>
<li>-&nbsp;<a href="../../access/">交通アクセス</a></li>
<li>-&nbsp;<a href="../../contact/">お問い合わせ</a>&nbsp;-&nbsp;<a href="contact/privacy.html">個人情報保護方針</a></li>
<li>-&nbsp;<a href="../../link/">リンク集</a></li>
<li>-&nbsp;<a href="../../sitemap.html" rel="index">サイトマップ</a></li>
</ul>
<ul id="fNavi03">
<li>-&nbsp;<a href="treatment/">診療内容</a></li>
<li>&nbsp;&nbsp;├&nbsp;<a href="../../treatment/normal/">一般整体</a></li>
<li>&nbsp;&nbsp;├&nbsp;<a href="../../treatment/bowleg&amp;knock_knee/">O脚・X脚矯正</a></li>
<li>&nbsp;&nbsp;├&nbsp;<a href="../../treatment/leg/">脚痩せ</a></li>
<li>&nbsp;&nbsp;└&nbsp;<a href="../../treatment/pelvis/">骨盤矯正or産後</a></li>
</ul>

</div><!-- #footerContainer End -->
</div><!-- #footer End -->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-12068976-1");
pageTracker._trackPageview();
} catch(err) {}</script>


</body>
</html>