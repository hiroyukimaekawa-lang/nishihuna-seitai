<?php
#----------------------------------#
#  HTMLファイル（トップページ作成）#
#----------------------------------#
function top_html_make(&$data,&$self,&$ct_cnt_flg){
	global $CNF,$title,$homeurl,$category,$ct_cnt,$user_comment,$target,$SPAM;

	if(PAGEVIEW > count($data)){
		$pagenew = count($data);
	}else{	
		$pagenew = PAGEVIEW;
	}
	// トップページ作成開始
	if(file_exists(HTML_TOPFILE)){
		$mode = "r+";
		$chmod_flg = 1;
	}else{
		$mode = "w";
		$chmod_flg = 0;
	}
	$fp2 = @fopen(HTML_TOPFILE, "$mode") or error("fopen Error: ".HTML_TOPFILE);
	// 書き込みバッファを 0 にする
	set_file_buffer($fp2, 0);
	if($chmod_flg){		ftruncate($fp2, 0); }
	rewind($fp2);

	head_html_make($title,$fp2);
fputs($fp2, "<a name=\"top\"></a><p><center>\n");
if(SEARCH_FLG == 1){
$tmp = <<<EOM
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr><td width="50%" align="center"><big>$title</big></td>
    <td width="50%" nowrap align="center"><form action="${self}" method="post">
    <input type=hidden name=mode value=do_search><input type=text name=word size=30>
    <select name=cond><option value="and">AND<option value="or">OR</select> <input type="submit" value="検索"></td></form></tr></table><br>
EOM;
fputs($fp2, $tmp);
}else{
	fputs($fp2, "<a name=\"top\"></a><p><center>\n");
	fputs($fp2, "<big>$title</big><br><br>\n");
}
$tmp = <<<EOM
$user_comment
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-bottom: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr>
  <tr><td width="25%" bgcolor="${CNF[navi_color]}" align="left" height="25" style="padding-left: 5px;"><a href="$homeurl">ホーム</a></td>
  <td bgcolor="${CNF[navi_color]}" align="center" height="25" nowrap><b>新着サイト　${pagenew}件表示</b></td>
EOM;
fputs($fp2, $tmp);
if(ADMIN_MODE == 1){
	if(RANK_FLG == 1){
		fputs($fp2, "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"><a href=\"${self}?mode=rank\">ランキング</a></td></tr>\n");
	}else{
		fputs($fp2, "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"></td></tr>\n");
	}
}else{
	if(RANK_FLG == 1){
		if($SPAM['js']){
			fputs($fp2, "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"><a href=\"javascript:void(0);\" onClick=\"window.open('${self}?mode=regist','_top').focus();\">新規登録</a>&nbsp;&nbsp;<a href=\"${self}?mode=rank\">ランキング</a></td></tr>\n");
		}else{
			fputs($fp2, "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"><a href=\"${self}?mode=regist\">新規登録</a>&nbsp;&nbsp;<a href=\"${self}?mode=rank\">ランキング</a></td></tr>\n");
		}
	}else{
		if($SPAM['js']){
			fputs($fp2, "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"><a href=\"javascript:void(0);\" onClick=\"window.open('${self}?mode=regist','_top').focus();\">新規登録</a></td></tr>\n");
		}else{
			fputs($fp2, "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"><a href=\"${self}?mode=regist\">新規登録</a></td></tr>\n");
		}
	}
}
$tmp = <<<EOM
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-top: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr></table></center>
<table border="0" cellpadding="0" cellspacing="4" width="100%">
  <tr><td height="10"></td>
    <td height="10" width="25%" nowrap></td></tr>
  <tr><td width="75%" valign="top">
EOM;
fputs($fp2, $tmp);
	$line_num = 0;
	reset($data);
	while(list($key, $value) = each($data)){
		$line_num++;
		$value = rtrim($value);
		list($id,$count,$ct,$site,$url,$comment,$pass,$date,$host,$banner) = explode(",", $value);
		if($ct_cnt_flg){	$ct_cnt[$ct]++; }
		if(is_numeric($id) && $line_num <= PAGEVIEW){
			if(RANK_FLG == 1){
				if(BANNER_FLG == 1 && $banner != ""){
					fputs($fp2, "<a href=\"${self}?mode=jump&amp;id=$id\" target=\"$target\"><img border=\"0\" src=\"${banner}\" width=\"88\" height=\"31\"></a>");
					if(TLINK_FLG == 1){	fputs($fp2, "　<a href=\"${self}?mode=jump&amp;id=$id\" target=\"$target\"><span class=\"site_title\">$site</span></a>"); }
					fputs($fp2, "<br>\n");
				}else{
					fputs($fp2, "<a href=\"${self}?mode=jump&amp;id=$id\" target=\"$target\"><span class=\"site_title\">$site</span></a><br>\n");
				}
			}else{
				if(BANNER_FLG == 1 && $banner != ""){
					fputs($fp2, "<a href=\"$url\" target=\"$target\"><img border=\"0\" src=\"${banner}\" width=\"88\" height=\"31\"></a>");
					if(TLINK_FLG == 1){	fputs($fp2, "　<a href=\"$url\" target=\"$target\"><span class=\"site_title\">$site</span></a>"); }
					fputs($fp2, "<br>\n");
				}else{
					fputs($fp2, "<a href=\"$url\" target=\"$target\"><span class=\"site_title\">$site</span></a><br>\n");
				}
			}
			fputs($fp2, "<span style=\"background-color: ${CNF[comment_bgcolor]}\">$comment</span><br>\n");
			if(RANK_FLG){
				fputs($fp2, "<div align=\"right\"><font color=\"${CNF[comment2_bgcolor]}\">ヒット数：<b>$count</b>回 [${category[$ct]}] [No.$id]</font></div>\n");
			}else{
				fputs($fp2, "<div align=\"right\"><font color=\"${CNF[comment2_bgcolor]}\">[${category[$ct]}] [No.$id]</font></div>\n");
			}
		}
	}
$tmp = <<<EOM
    <td width="25%" nowrap valign="top" style="padding-left: 5px;">
      <table border="0" cellpadding="2" cellspacing="0" width="100%" class=solid_left>
EOM;
fputs($fp2, $tmp);
while(list($key, $value) = each($category)){
	$key_sprintf = sprintf('%02d', $key);
	$htmlname = HTML_DIR.$key_sprintf."_01.html";
	fputs($fp2, "<tr><td width=\"5\"></td><td width=\"100%\" nowrap><a href=\"${htmlname}\">$value</a>（$ct_cnt[$key]）</td></tr>\n");
}
$tmp = <<<EOM
      </table></td></tr>
  <tr><td></td>
    <td width="25%" nowrap></td></tr>
</table><br>
EOM;
fputs($fp2, $tmp);
	// 管理バー表示
	admin_bar_make($fp2,$self);

	foot_html_make($fp2);
	fclose($fp2);
	if(!$chmod_flg){	chmod(HTML_TOPFILE, 0606); }
}
#------------------------------------#
#  HTMLファイル（カテゴリページ作成）#
#------------------------------------#
function ct_html_make(&$ct_no,&$ct_count,&$page_start,&$data,&$self){
	global $CNF,$category,$title,$homeurl,$ct_cnt,$target,$SPAM;

	if(CT_COUNT_FLG && $_POST['mode'] == "do_modify" && $_POST['old_category'] == $_POST['category']){
		$page_all = $page_start;
	}elseif($ct_count == 0){
		$page_all = 1;
	}else{
		$page_all = ceil($ct_count / PAGEVIEW);
	}
	$ct_no_sprintf = sprintf('%02d', $ct_no);
	$mode = "ct";
for($i = $page_start; $i <= $page_all; $i++){
	$pagenow = $i;
	$pagenow_sprintf = sprintf('%02d', $pagenow);
	$filename = HTML_DIR.$ct_no_sprintf."_".$pagenow_sprintf.".html";
	if(file_exists($filename)){
			$filemode = "r+";
			$chmod_flg = 1;
		}else{
			$filemode = "w";
			$chmod_flg = 0;
		}
	$fp2 = @fopen("$filename", "$filemode") or error("fopen Error: $filename");
	// 書き込みバッファを 0 にする
	set_file_buffer($fp2, 0);
	if($chmod_flg){		ftruncate($fp2, 0); }
	rewind($fp2);
	head_html_make("カテゴリ：${category[$ct_no]}",$fp2);
$tmp = <<<EOM
<a name="top"></a><p><center>
<big>$title</big><br><br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-bottom: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr>
  <tr><td width="25%" bgcolor="${CNF[navi_color]}" align="left" height="25" style="padding-left: 5px;"><a href="$homeurl">ホーム</a></td>
  <td bgcolor="${CNF[navi_color]}" align="center" height="25" nowrap><b>${category[$ct_no]}</b></td>
EOM;
fputs($fp2, $tmp);
if(ADMIN_MODE == 1){
	if(RANK_FLG == 1){
		fputs($fp2, "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap><a href=\"${self}?mode=rank\">ランキング</a></td></tr>\n");
	}else{
		fputs($fp2, "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap></td></tr>\n");
	}
}else{
	if(RANK_FLG == 1){
		if($SPAM['js']){
			fputs($fp2, "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"><a href=\"javascript:void(0);\" onClick=\"window.open('${self}?mode=regist','_top').focus();\">新規登録</a>&nbsp;&nbsp;<a href=\"${self}?mode=rank\">ランキング</a></td></tr>\n");
		}else{
			fputs($fp2, "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"><a href=\"${self}?mode=regist\">新規登録</a>&nbsp;&nbsp;<a href=\"${self}?mode=rank\">ランキング</a></td></tr>\n");
		}
	}else{
		if($SPAM['js']){
			fputs($fp2, "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"><a href=\"javascript:void(0);\" onClick=\"window.open('${self}?mode=regist','_top').focus();\">新規登録</a></td></tr>\n");
		}else{
			fputs($fp2, "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"><a href=\"${self}?mode=regist\">新規登録</a></td></tr>\n");
		}
	}
}
$tmp = <<<EOM
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-top: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr></table></center>                         
<table border="0" cellpadding="0" cellspacing="4" width="100%">                         
  <tr><td height="10"></td>
    <td height="10" width="25%" nowrap></td></tr>
  <tr><td width="75%" valign="top">
EOM;
fputs($fp2, $tmp);
if($ct_count != 0){
	$rows_all = 0;
	$num_start = ($pagenow - 1) * PAGEVIEW + 1;
	reset($data);
	while(list(,$line) = each($data)){
		list($id,$count,$ct,$site,$url,$comment,$pass,$date,$host,$banner) = explode(",", $line);
		$banner = rtrim($banner);
		if($ct_no == $ct){
			$rows_all++;
			if($rows_all >= $num_start && $rows_all <= ($pagenow * PAGEVIEW)){
				if(RANK_FLG == 1){
					if(BANNER_FLG == 1 && $banner != ""){
						fputs($fp2, "<a href=\"${self}?mode=jump&amp;id=$id\" target=\"$target\"><img border=\"0\" src=\"${banner}\" width=\"88\" height=\"31\"></a>");
						if(TLINK_FLG == 1){	fputs($fp2, "　<a href=\"${self}?mode=jump&amp;id=$id\" target=\"$target\"><span class=\"site_title\">$site</span></a>"); }
						fputs($fp2, "<br>\n");
					}else{
						fputs($fp2, "<a href=\"${self}?mode=jump&amp;id=$id\" target=\"$target\"><span class=\"site_title\">$site</span></a><br>\n");
					}
				}else{
					if(BANNER_FLG == 1 && $banner != ""){
						fputs($fp2, "<a href=\"$url\" target=\"$target\"><img border=\"0\" src=\"${banner}\" width=\"88\" height=\"31\"></a>");
						if(TLINK_FLG == 1){	fputs($fp2, "　<a href=\"$url\" target=\"$target\"><span class=\"site_title\">$site</span></a>"); }
						fputs($fp2, "<br>\n");
					}else{
						fputs($fp2, "<a href=\"$url\" target=\"$target\"><span class=\"site_title\">$site</span></a><br>\n");
					}
				}
				fputs($fp2, "<span style=\"background-color: ${CNF[comment_bgcolor]}\">$comment</span><br>\n");
				if(RANK_FLG){
					fputs($fp2, "<div align=\"right\"><font color=\"${CNF[comment2_bgcolor]}\">ヒット数：<b>$count</b>回 [${category[$ct]}] [No.$id]</font></div>\n");
				}else{
					fputs($fp2, "<div align=\"right\"><font color=\"${CNF[comment2_bgcolor]}\">[${category[$ct]}] [No.$id]</font></div>\n");
				}
			}
		}
	}
}
$tmp = <<<EOM
    <td width="25%" nowrap valign="top" style="padding-left: 5px;">
      <table border="0" cellpadding="2" cellspacing="0" width="100%" class=solid_left>
EOM;
fputs($fp2, $tmp);
reset($category);
while(list($key, $value) = each($category)){
	$key_sprintf = sprintf('%02d', $key);
	$htmlname = $key_sprintf."_01.html";
	if(CT_COUNT_FLG){
		fputs($fp2, "<tr><td width=\"5\"></td><td width=\"100%\" nowrap><a href=\"${htmlname}\">$value</a></td></tr>\n");
	}else{
		fputs($fp2, "<tr><td width=\"5\"></td><td width=\"100%\" nowrap><a href=\"${htmlname}\">$value</a>（$ct_cnt[$key]）</td></tr>\n");
	}
}
$tmp = <<<EOM
      </table></td></tr>
  <tr><td></td>
    <td width="25%" nowrap></td></tr>
</table><br>
<center>
EOM;
fputs($fp2, $tmp);
	// ページコントロール
	if($rows_all > 0){	page_ctl_make($rows_all,$pagenow,$num_start,$mode,$ct_no,$fp2,$self); }
	fputs($fp2, "</center>\n");
	// 管理バー表示
	admin_bar_make($fp2,$self);

	foot_html_make($fp2);
	fclose($fp2);
	if(!$chmod_flg){	chmod("$filename", 0606); }
}
}
#----------------#
#  管理バー表示  #
#----------------#
function admin_bar_make(&$fp2,&$self){
	global $CNF;

$tmp = <<<EOM
<center><table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-bottom: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr>
  <tr><td width="25%" bgcolor="${CNF[navi_color]}" align="left" height="30" style="padding-left: 5px;"><a href="javascript:history.back();">&lt;&lt;戻る</a></td>
  <form action="${self}" method="post">
  <td bgcolor="${CNF[navi_color]}" align="center" height="30" nowrap>No：<input type="text" name="id" size="5" style="ime-mode:disabled"> Pass：<input type="password" name=pass size="10" maxlength="8">
EOM;
fputs($fp2, $tmp);
	fputs($fp2, "\n<select name=\"mode\">");
	if(ADMIN_MODE){
		fputs($fp2, "<option value=\"regist\" selected>登録<option value=\"modify\">修正");
	}else{
		fputs($fp2, "<option value=\"modify\" selected>修正");
	}
	fputs($fp2, "<option value=\"delete\">削除");
	if(HTML_FLG){	fputs($fp2, "<option value=\"html_remake\">HTML"); }
	fputs($fp2, "</option></select>\n");
$tmp = <<<EOM
  <input type="submit" value="送信" name="submit"></td></form>
  <td width="25%" bgcolor="${CNF[navi_color]}" align="right" height="30" style="padding-right: 5px;"><a href="#top">トップへ</a></td></tr>
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-top: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr>
</table></center>
EOM;
fputs($fp2, $tmp);
}
#----------------#
#  ヘッダー表示  #
#----------------#
function head_html_make($title,&$fp2){
	global $CNF,$SPAM,$msg_noscript;

	$site_font_weight = $CNF['site_bold_flag'] ? "bold" : "normal";
if($CNF[font_family] != ""){	$font_family = "font-family: ".$CNF[font_family].";"; }
if($CNF[scrollbar] != ""){	$scrollbar = "\nbody { scrollbar-base-color: ".$CNF[scrollbar]."; }"; }
$tmp = <<<EOM
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head>
<meta http-equiv="Content-Language" content="ja">
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<title>$title</title>
<STYLE TYPE="TEXT/CSS">
<!--
body,tr,td,th { color: $CNF[font_color]; font-size: $CNF[font_size]; ${font_family} }
a:link    { color: $CNF[link]; text-decoration: $CNF[link_deco]; }
a:visited { color: $CNF[visited]; text-decoration: $CNF[visited_deco]; }
a:active  { color: $CNF[active]; text-decoration: $CNF[active_deco]; }
a:hover   { color: $CNF[hover]; text-decoration: $CNF[hover_deco]; background-color: $CNF[hover_bgcolor]; }
.site_title { font-size: $CNF[site_font_size]; font-weight: ${site_font_weight}; }
.solid_left { border-color : $CNF[bgcolor] $CNF[bgcolor] $CNF[bgcolor] $CNF[ct_left]; border-width: 1px; border-style: solid; }${scrollbar}
-->
</STYLE>
<script type="text/javascript" src="./js/common.js" charset="EUC-JP"></script>
</head>
<body background="${CNF[background]}" bgcolor="${CNF[bgcolor]}">
EOM;
	if($SPAM['js'] && $msg_noscript != ""){	$tmp .= $msg_noscript; }
fputs($fp2, $tmp);
}
#----------------#
#  フッター表示  #
#----------------#
function foot_html_make(&$fp2){
	global $homeurl,$copyright;

$tmp = <<<EOM
<p align=center>${copyright}</p>
</body></html>
EOM;
fputs($fp2, $tmp);
}
#----------------------#
#  ページコントロール  #
#----------------------#
function page_ctl_make(&$rows_all,&$pagenow,&$num_start,&$mode,&$ct_no,&$fp2,&$self){

	if($rows_all < $pagenow * PAGEVIEW){
		$num_end = $rows_all;
	}else{
		$num_end = $pagenow * PAGEVIEW;
	}
	if($rows_all > PAGEVIEW){
		fputs($fp2, "$num_start - $num_end ( $rows_all 件中 )　 [ \n");
	}else{
		fputs($fp2, "$num_start - $num_end ( $rows_all 件中 )<br><br>\n");
	}
	if($pagenow != 1){
		$page_prev = $pagenow - 1;
		$page_prev_sprintf = sprintf("%02d", $page_prev);
		if($mode == "ct"){
			$ct_no_sprintf = sprintf("%02d", $ct_no);
			$filename = $ct_no_sprintf."_".$page_prev_sprintf.".html";
			fputs($fp2, "/ <a href=\"${filename}\">&lt;- 前ページ</a> \n");
		}else{
			fputs($fp2, "/ <a href=\"${self}?mode=${mode}&amp;p=$page_prev\">&lt;- 前ページ</a> \n");
		}
	}
	if($rows_all > $num_end){
		$page_next = $pagenow + 1;
		$page_next_sprintf = sprintf("%02d", $page_next);
		if($mode == "ct"){
			$ct_no_sprintf = sprintf("%02d", $ct_no);
			$filename = $ct_no_sprintf."_".$page_next_sprintf.".html";
			fputs($fp2, "/ <a href=\"${filename}\">次ページ -&gt;</a>\n");
		}else{
			fputs($fp2, "/ <a href=\"${self}?mode=${mode}&amp;p=$page_next\">次ページ -&gt;</a>\n");
		}
	}
	if($rows_all > PAGEVIEW){
		fputs($fp2, " / ]<br><br>\n");
	}
}
?>