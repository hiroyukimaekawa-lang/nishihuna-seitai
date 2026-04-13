<?php
##======================================================##
##  365 Links                                           ##
##  Copyright (C) php365.com All rights reserved.       ##
##  http://php365.com/                                  ##
##======================================================##
// ユーザー設定ライブラリ
require_once("./lib/config.php");
// 共通仕様サブルーチン
require_once(PATH_LIB."common.php");
// HTMLファイル作成ライブラリ
if(HTML_FLG == 1){	require_once("./html_kit.php"); }

check_host();

if($_SERVER['REQUEST_METHOD'] == "GET"){	$_POST['mode'] = &$_GET['mode']; }

$script_name4html = t2h($_SERVER['SCRIPT_NAME']);
switch($_SERVER['REQUEST_METHOD']):
	case 'GET':
		switch($_GET['mode']):
			case 'regist':		// 登録フォーム表示
				regist();
				break;
			case 'rank':		// ランキング表示
				rank();
				break;
			case 'ct':		// カテゴリ表示
				ct();
				break;
			case 'jump':		// カウントアップ、ロケーション
				jump();
				break;
			case 'rank_reset':	// ランキングリセット入口
				rank_reset();
				break;
			case 'check':
				check();
				break;
			default:
				top_html();
				break;
		endswitch;
		break;
	case 'POST':
		switch($_POST['mode']):
			case 'regist':		// 登録フォーム表示
				regist();
				break;
			case 'do_regist':	// 新規登録処理
				decode();
				do_regist();
				break;
			case 'modify':		// 修正フォーム表示
				modify();
				break;
			case 'do_modify':	// データ修正処理
				decode();
				do_modify();
				break;
			case 'delete':		// データ削除処理
				delete();
				break;
			case 'do_search':	// キーワード検索
				decode();
				do_search();
				break;
			case 'do_rank_reset':	// ランキングリセット実行
				do_rank_reset();
				break;
			case 'html_remake':	// HTMLファイル再構築
				html_remake();
				break;
			default:
				top_html();
				break;
		endswitch;
		break;
	default:
		top_html();
		break;
endswitch;
exit;
#----------------#
#  初期画面表示  #
#----------------#
function top_html(){
	global $CNF,$title,$homeurl,$category,$ct_cnt,$user_comment,$target,$SPAM,$script_name4html;
	
	$data = file(LOGFILE);
	// バックアップ処理
	if(BACKFILE != "" && filesize(LOGFILE) != 0){	backup($data);	}

	if(PAGEVIEW > count($data)){
		$pagenew = count($data);
	}else{	
		$pagenew = PAGEVIEW;
	}
	head_html($title);
echo "<a name=\"top\"></a><p><center>\n";
if(SEARCH_FLG == 1){
echo <<<EOM
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr><td width="50%" align="center" style="font-size18px;"><big><b>$title</b></big></td>
    <td width="50%" nowrap align="center"><form action="${script_name4html}" method="post">
    <input type=hidden name=mode value=do_search><input type=text name=word size=30>
    <select name=cond><option value="and">AND<option value="or">OR</select> <input type="submit" value="検索"></td></form></tr></table><br>
EOM;
}else{
	echo "<a name=\"top\"></a><p><center>\n";
	echo "<big>$title</big><br><br>\n";
}
echo <<<EOM
$user_comment
<table border="0" cellpadding="0" cellspacing="0" width="100%">                               
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-bottom: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr>                               
  <tr><td width="25%" bgcolor="${CNF[navi_color]}" align="left" height="25" style="padding-left: 5px;"><a href="$homeurl">ホーム</a></td>
  <td bgcolor="${CNF[navi_color]}" align="center" height="25" nowrap><b>新着サイト　${pagenew}件表示</b></td>
EOM;
if(ADMIN_MODE == 1){
	if(RANK_FLG == 1){
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"><a href=\"${script_name4html}?mode=rank\">ランキング</a></td></tr>\n";
	}else{
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"></td></tr>\n";
	}
}else{
	if(RANK_FLG == 1){
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\">";
		if($SPAM['js']){
			echo "<a href=\"javascript:void(0);\" onClick=\"window.open('${script_name4html}?mode=regist','_top').focus();\">新規登録</a>";
		}else{
			echo "<a href=\"${script_name4html}?mode=regist\">新規登録</a>";
		}
		echo "&nbsp;&nbsp;<a href=\"${script_name4html}?mode=rank\">ランキング</a></td></tr>\n";
	}else{
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\">";
		if($SPAM['js']){
			echo "<a href=\"javascript:void(0);\" onClick=\"window.open('${script_name4html}?mode=regist','_top').focus();\">新規登録</a>";
		}else{
			echo "<a href=\"${script_name4html}?mode=regist\">新規登録</a>";
		}
		echo "</td></tr>\n";
	}
}
echo <<<EOM
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-top: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr></table></center>                         
<table border="0" cellpadding="0" cellspacing="4" width="100%">                         
  <tr><td height="10"></td>
    <td height="10" width="25%" nowrap></td></tr>
  <tr><td width="75%" valign="top">
EOM;
	$line_num = 0;
	reset($data);
	while(list($key, $value) = each($data)){
		$line_num++;
		$value = rtrim($value);
		list($id,$count,$ct,$site,$url,$comment,$pass,$date,$host,$banner) = explode(",", $value);
		$ct_cnt[$ct]++;
		if(is_numeric($id) && $line_num <= PAGEVIEW){
			if(RANK_FLG == 1){
				if(BANNER_FLG == 1 && $banner != ""){
					echo "<a href=\"${script_name4html}?mode=jump&amp;id=$id\" target=\"$target\"><img border=\"0\" src=\"${banner}\" width=\"88\" height=\"31\"></a>";
					if(TLINK_FLG == 1){	echo "　<a href=\"${script_name4html}?mode=jump&amp;id=$id\" target=\"$target\"><span class=\"site_title\">$site</span></a>"; }
					echo "<br>\n";
				}else{
					echo "<a href=\"${script_name4html}?mode=jump&amp;id=$id\" target=\"$target\"><span class=\"site_title\">$site</span></a><br>\n";
				}
			}else{
				if(BANNER_FLG == 1 && $banner != ""){
					echo "<a href=\"$url\" target=\"$target\"><img border=\"0\" src=\"${banner}\" width=\"88\" height=\"31\"></a>";
					if(TLINK_FLG == 1){	echo "　<a href=\"$url\" target=\"$target\"><span class=\"site_title\">$site</span></a>"; }
					echo "<br>\n";
				}else{
					echo "<a href=\"$url\" target=\"$target\"><span class=\"site_title\">$site</span></a><br>\n";
				}
			}
			echo "<span style=\"background-color: ${CNF[comment_bgcolor]}\">$comment</span><br>\n";
			if(RANK_FLG){
				echo "<div align=\"right\"><font color=\"${CNF[comment2_bgcolor]}\">ヒット数：<b>$count</b>回 [${category[$ct]}] [No.$id]</font></div>\n";
			}else{
				echo "<div align=\"right\"><font color=\"${CNF[comment2_bgcolor]}\">[${category[$ct]}] [No.$id]</font></div>\n";
			}
		}
	}
echo <<<EOM
    <td width="25%" nowrap valign="top" style="padding-left: 5px;">
      <table border="0" cellpadding="2" cellspacing="0" width="100%" class=solid_left>
EOM;
while(list($key, $value) = each($category)){
	echo "<tr><td width=\"5\"></td><td width=\"100%\" nowrap><a href=\"${script_name4html}?mode=ct&amp;ct=$key\">$value</a>（$ct_cnt[$key]）</td></tr>\n";
}
echo <<<EOM
      </table></td></tr>
  <tr><td></td>
    <td width="25%" nowrap></td></tr>
</table><br>
EOM;
	// 管理バー表示
	admin_bar();

	foot_html();
}
#--------------------#
#  登録フォーム表示  #
#--------------------#
function regist(){
	global $homeurl,$category,$com_max,$REG,$SPAM,$script_name4html;

	set_tracking();
	set_session();
	$ticket4html = t2h($_SESSION['ticket']);

	if(ADMIN_MODE == 1 && $_POST['pass'] != ADMIN_PASS){
		error("管理用パスワードが違います");
	}
	head_html("登録フォーム");

echo <<<EOM
\n[ <a href="javascript:history.back();">&lt;&lt;戻る</a> ]<br>
<center><b>登録フォーム</b><br><br>
<font color="#CC0000">*</font>は必須項目です。
EOM;
	if($SPAM['js']){
		$path_parts = pathinfo($_SERVER["SCRIPT_NAME"]);
		$dirname = $path_parts['dirname'] . "/";
		echo "<form action=\"".t2h($dirname)."dummy.php\" method=\"post\" name=\"form1\" id=\"form1\" onSubmit=\"return checkForm(${REG['check']},${SPAM['js']});\">\n";
		echo "<input type=\"hidden\" name=\"script\" value=\"${script_name4html}\">\n";
	}else{
		echo "<form action=\"${script_name4html}\" method=\"post\" name=\"form1\" id=\"form1\" onsubmit=\"return checkForm(${REG['check']},${SPAM['js']});\">\n";
	}
echo <<<EOM
<input type=hidden name="mode" value="do_regist">
<input type="hidden" name="ticket" value="${ticket4html}">
<table border="0" cellpadding="0" cellspacing="0" width="450">
<tr><td width="100%"><table border=0 width="100%" cellspacing="1" cellpadding="3" bgcolor="#c0c0c0">
<tr><td bgcolor="#efefef"><b>カテゴリ</b></td>
<td bgcolor="#ffffff"><select size="1" name="category">
EOM;
while(list($key, $value) = each($category)){
	echo "<option value=$key>$value</option>\n";
}
echo <<<EOM
</select></td></tr>
<tr><td bgcolor="#EFEFEF"><b>サイト名</b><font color="#CC0000">*</font></td><td bgcolor="#FFFFFF"><input type=text name=site size=60></td></tr>
<tr><td bgcolor="#EFEFEF" nowrap><b>サイトURL</b><font color="#CC0000">*</font></td><td bgcolor="#FFFFFF"><input type=text name=url size=60 value="http://"></td></tr>
EOM;
	if(BANNER_FLG == 1){
		echo "<tr><td bgcolor=\"#EFEFEF\" nowrap><b>バナーURL</b><br>（88*31固定）</td><td bgcolor=\"#FFFFFF\"><input type=text name=banner size=60 value=\"http://\"></td></tr>\n";
	}
echo <<<EOM
<tr><td bgcolor="#EFEFEF"><b>コメント</b><br>（全角${com_max}文字以内）</td><td bgcolor="#FFFFFF"><textarea rows="4" name="comment" cols="50"></textarea></td></tr>
<tr><td bgcolor="#EFEFEF" nowrap><b>パスワード</b></td><td bgcolor="#FFFFFF"><input type="password" name=pass size="10" maxlength="8"><font color="#CC0000">（修正・削除に使用、半角英数8文字以内）</font></td></tr>
EOM;

	show_regkey();
echo <<<EOM
<tr><td bgcolor="#FFFFFF" colspan="2" align="center" height="50"><input type="submit" name="submit" value="登録する">&nbsp;<input type="reset" value="リセット"></td></tr>                                                     
</table></form></center>
EOM;
	foot_html();
}
#----------------#
#  新規登録処理  #
#----------------#
function do_regist(){
	global $category,$homeurl,$com_max,$title,$ct_cnt,$REG,$SPAM,$script_name4html;

	check_referer();
	check_tracking();
	check_session();
	verify_regkey();

	if(!$_POST['site']){ error("サイト名が入力されていません"); }
	elseif($_POST['url'] == "http://" || $_POST['url'] == "https://"){ error("サイトURLが入力されていません"); }
	elseif(strlen($_POST['comment']) > ($com_max*2)){ error("コメントが全角${com_max}文字を超えています"); }
	elseif(!$SPAM['single'] && !preg_match('/[\xA1-\xFE]{2}/i', $_POST['comment']) && $_POST['comment'] != ""){
		error("半角文字のみの投稿は禁止しています");
	}elseif(!$SPAM['url'] && preg_match('/http:\/\//', $_POST['comment'])){
		error("URLを含む投稿は禁止しています。<br>どうしてもURLを投稿した場合は、頭の「h」を除いた「ttp://」から始めるようにして再度投稿して下さい。");
	}

	// NGワードチェック
	if(NG_WORD != ""){	check_ng_word(array('site','url','banner','comment')); }
	// NGURLチェック
	if(NG_URL != ""){	check_ng_url(array('site','url','banner','comment')); }

	// 時間を取得
	$date = gmdate("Y/m/d",time()+9*60*60);
	$host = getenv("REMOTE_HOST");
	$addr = getenv("REMOTE_ADDR");
	if($host == "" || $host == $addr){	$host = @gethostbyaddr($addr);	}
	// パスワードの暗号化
	$pass = "";
	if($_POST['pass'] != ""){	$pass = md5($_POST['pass']);	}
	if($_POST['banner'] == "http://" || $_POST['banner'] == "https://"){
		$_POST['banner'] = "";
	}

	$fp = @fopen(LOGFILE, "r+") or error("fopen Error: ".LOGFILE);
	// ロック開始
	lock($fp);
	$data = file(LOGFILE);
	// 重複投稿チェック
	while(list(,$value) = each($data)){
		list($id,$count,$ct,$site,$url,$comment,) = explode(",", $value);
		if($_POST['url'] == $url){
			error("既に登録されています");
		}
	}
	if(count($data) > 0 && $data[0] != ""){
		list($id,) = explode(",", rtrim($data[0]));
		$id++;
	}else{
		$id = 1;
	}
	$line = "$id,0,${_POST['category']},${_POST['site']},${_POST['url']},${_POST['comment']},$pass,$date,$host,${_POST['banner']}\n";
	array_unshift($data, $line);
	// 書き込みバッファを 0 にする
	set_file_buffer($fp, 0);
	ftruncate($fp, 0);
	rewind($fp);
	while(list(,$value) = each($data)){	fputs($fp, $value); }
	// HTMLファイル更新
	if(HTML_FLG){
		$self = $script_name4html;
		$ct_cnt_flg = 1;
		// トップページ更新開始
		top_html_make($data,$self,$ct_cnt_flg);
		// カテゴリページ更新開始
		$page_start = 1;
		if(CT_COUNT_FLG){
			ct_html_make($_POST['category'],$ct_cnt[$_POST['category']],$page_start,$data,$self);
		}else{
			reset($ct_cnt);
			while(list($ct_no,$ct_count) = each($ct_cnt)){
				ct_html_make($ct_no,$ct_count,$page_start,$data,$self);
			}
		}
	}
	// ロック解除
	unlock($fp);
	fclose($fp);

	# 登録完了メッセージ出力
	head_html("登録完了");
echo <<<EOM
<center><p><b>登録完了</b></p>
<table border="0" cellpadding="0" cellspacing="0" width="450">       
<tr><td width="100%"><table border=0 width="100%" cellspacing="1" cellpadding="3" bgcolor="#c0c0c0">
<tr><td bgcolor="#EFEFEF"><b>カテゴリ</b></td><td bgcolor="#FFFFFF">${category[$_POST['category']]}</td></tr>
<tr><td bgcolor="#EFEFEF"><b>サイト名</b><font color="#CC0000">*</font></td><td bgcolor="#FFFFFF">${_POST['site']}</td></tr>
<tr><td bgcolor="#EFEFEF" nowrap><b>サイトURL</b><font color="#CC0000">*</font></td><td bgcolor="#FFFFFF">${_POST['url']}</td></tr>
EOM;
	if(BANNER_FLG == 1){
		echo "<tr><td bgcolor=\"#EFEFEF\" nowrap><b>バナーURL</b><br>（88*31固定）</td><td bgcolor=\"#FFFFFF\">${_POST['banner']}</td></tr>\n";
	}
echo <<<EOM
<tr><td bgcolor="#EFEFEF"><b>コメント</b></td><td bgcolor="#FFFFFF">${_POST['comment']}</td></tr>
<tr><td bgcolor="#EFEFEF" nowrap><b>パスワード</b></td><td bgcolor="#FFFFFF">${_POST['pass']}</td></tr>
</table></td></tr></table>
EOM;
if(HTML_FLG){
	echo "<p align=center><a href=\"javascript:history.back();\">&lt;&lt;戻る</a>　<a href=\"".HTML_TOPFILE."\">${title}に戻る</a></p></center>\n";
}else{
	echo "<p align=center><a href=\"javascript:history.back();\">&lt;&lt;戻る</a>　<a href=\"${script_name4html}\">${title}に戻る</a></p></center>\n";
}
	foot_html();
}
#--------------------#
#  修正フォーム表示  #
#--------------------#
function modify(){
	global $homeurl,$category,$com_max,$REG,$SPAM,$script_name4html;

	set_tracking();
	set_session();
	$ticket4html = t2h($_SESSION['ticket']);

	$_POST['id'] = intval($_POST['id']);
	$match = 0;
	$fp = @fopen(LOGFILE, "r") or error("fopen Error: ".LOGFILE);
	while(!feof($fp)){
		list($id,$count,$ct,$site,$url,$comment,$pass,$date,$host,$banner) = explode(",", fgets($fp));
		if($_POST['id'] == $id){
			if(!$SPAM['nopass'] && $pass == "" && $_POST['pass'] != ADMIN_PASS){
				error("パスワードを設定していない投稿は、修正・削除を許可していません");
			}
			$match = 1;
			break;
		}
	}
	fclose($fp);
	if(!$match){	error("該当No.が存在しません");	}
	// パスワードチェック
	$post_pass_md5 = $_POST['pass'] != "" ? md5($_POST['pass']) : "";
	if($post_pass_md5 != $pass && $pass != "" && $_POST['pass'] != ADMIN_PASS){
		error("パスワードが違います");
	}
	$comment = h2t($comment);
	head_html("修正フォーム");

echo <<<EOM
\n[ <a href="javascript:history.back();">&lt;&lt;戻る</a> ]<br>
<center><b>修正フォーム</b><br><br>
<font color="#CC0000">*</font>は必須項目です。
EOM;
	if($SPAM['js']){
		$path_parts = pathinfo($_SERVER["SCRIPT_NAME"]);
		$dirname = $path_parts['dirname'] . "/";
		echo "<form action=\"".t2h($dirname)."dummy.php\" method=\"post\" name=\"form1\" id=\"form1\" onSubmit=\"return checkForm(${REG['check']},${SPAM['js']});\">\n";
		echo "<input type=\"hidden\" name=\"script\" value=\"${script_name4html}\">\n";
	}else{
		echo "<form action=\"${script_name4html}\" method=\"post\" name=\"form1\" id=\"form1\" onsubmit=\"return checkForm(${REG['check']},${SPAM['js']});\">\n";
	}
echo <<<EOM
<input type=hidden name="mode" value="do_modify">
<input type=hidden name="id" value="${_POST['id']}">
<input type=hidden name="count" value="$count">
<input type=hidden name="post_pass" value="${post_pass_md5}">
<input type=hidden name="old_pass" value="$pass">
<input type=hidden name="old_category" value="$ct">
<input type="hidden" name="ticket" value="${ticket4html}">
<table border="0" cellpadding="0" cellspacing="0" width="500">
<tr><td width="100%"><table border=0 width="100%" cellspacing="1" cellpadding="3" bgcolor="#c0c0c0">
<tr><td bgcolor="#efefef"><b>カテゴリ</b></td>
<td bgcolor="#ffffff"><select size="1" name="category">
EOM;
while(list($key, $value) = each($category)){
	if($ct == $key){
		echo "<option selected value=$key>$value</option>\n";
	}else{
		echo "<option value=$key>$value</option>\n";
	}
}
echo <<<EOM
</select></td></tr>
<tr><td bgcolor="#EFEFEF"><b>サイト名</b><font color="#CC0000">*</font></td><td bgcolor="#FFFFFF"><input type=text name=site size=60 value="$site"></td></tr>
<tr><td bgcolor="#EFEFEF" nowrap><b>サイトURL</b><font color="#CC0000">*</font></td><td bgcolor="#FFFFFF"><input type=text name=url size=60 value="$url"></td></tr>
EOM;
	if(BANNER_FLG == 1){
		echo "<tr><td bgcolor=\"#EFEFEF\" nowrap><b>バナーURL</b><br>（88*31固定）</td><td bgcolor=\"#FFFFFF\"><input type=text name=banner size=60 value=\"$banner\"></td></tr>\n";
	}
echo <<<EOM
<tr><td bgcolor="#EFEFEF"><b>コメント</b><br>（全角${com_max}文字以内）</td><td bgcolor="#FFFFFF"><textarea rows="4" name="comment" cols="50">$comment</textarea></td></tr>
<tr><td bgcolor="#EFEFEF" nowrap><b>パスワード</b></td><td bgcolor="#FFFFFF"><input type="password" name=pass size="10" maxlength="8"><font color="#CC0000">（修正する場合のみ記入、半角英数8文字以内）</font></td></tr>
EOM;

	show_regkey();
echo <<<EOM
<tr><td bgcolor="#FFFFFF" colspan="2" align="center" height="50"><input type="submit" name="submit" value="修正する">&nbsp;<input type="reset" value="リセット"></td></tr>
</table></form></center>
EOM;
	foot_html();
}
#------------------#
#  データ修正処理  #
#------------------#
function do_modify(){
	global $category,$homeurl,$com_max,$title,$ct_cnt,$REG,$SPAM,$script_name4html;

	check_referer();
	check_tracking();
	check_session();
	verify_regkey();

	$_POST['id'] = intval($_POST['id']);

	if(!$_POST['site']){ error("サイト名が入力されていません"); }
	elseif($_POST['url'] == "http://" || $_POST['url'] == "https://"){ error("サイトURLが入力されていません"); }
	elseif(strlen($_POST['comment']) > ($com_max*2)){ error("コメントが全角${com_max}文字を超えています"); }
	elseif(!$SPAM['single'] && !preg_match('/[\xA1-\xFE]{2}/i', $_POST['comment']) && $_POST['comment'] != ""){
		error("半角文字のみの投稿は禁止しています");
	}elseif(!$SPAM['url'] && preg_match('/http:\/\//', $_POST['comment'])){
		error("URLを含む投稿は禁止しています。<br>どうしてもURLを投稿した場合は、頭の「h」を除いた「ttp://」から始めるようにして再度投稿して下さい。");
	}
	// NGワードチェック
	if(NG_WORD != ""){	check_ng_word(array('site','url','banner','comment')); }
	// NGURLチェック
	if(NG_URL != ""){	check_ng_url(array('site','url','banner','comment')); }

	// 時間を取得
	$now = gmdate("Y/m/d",time()+9*60*60);
	$host = getenv("REMOTE_HOST");
	$addr = getenv("REMOTE_ADDR");
	if($host == "" || $host == $addr){	$host = @gethostbyaddr($addr);	}
	// パスワードの暗号化
	if($_POST['pass'] == ""){
		$pass = $_POST['old_pass'];
		$_POST['pass'] = "変更無";
	}else{
		$pass = md5($_POST['pass']);
	}
	if($_POST['banner'] == "http://" || $_POST['banner'] == "https://"){
		$_POST['banner'] = "";
	}

	$fp = @fopen(LOGFILE, "r+") or error("fopen Error: ".LOGFILE);
	// ロック開始
	lock($fp);
	$data = file(LOGFILE);
	while(list(,$value) = each($data)){
		list($id,,,,,,$pass_old,,,) = explode(",", trim($value));
		if($_POST['id'] == $id){
			if(!$SPAM['nopass'] && $pass_old == "" && $_POST['post_pass'] != md5(ADMIN_PASS)){
				error("パスワードを設定していない投稿は、修正・削除を許可していません");
			}
			if($_POST['post_pass'] != $pass_old && $pass_old != "" && $_POST['post_pass'] != md5(ADMIN_PASS)){
				error("パスワードが違います");
			}
			break;
		}
	}
	$line = "${_POST['id']},${_POST['count']},${_POST['category']},${_POST['site']},${_POST['url']},${_POST['comment']},$pass,$now,$host,${_POST['banner']}\n";
	# 書き込みバッファを 0 にする
	set_file_buffer($fp, 0);
	ftruncate($fp, 0);
	rewind($fp);
	$line_cnt = 0;
	$target_line_cnt = 0;
	reset($data);
	while(list($key, $value) = each($data)){
		list($id,$count,$ct,$site,$url,$comment,) = explode(",", $value);
		$line_cnt++;
		if($_POST['id'] != $id){
			fputs($fp, $value);
			$ct_cnt[$ct]++;
		}else{
			fputs($fp, $line);
			$ct_cnt[$_POST['category']]++;
			$data[$key] = $line;
			$target_line_cnt = $line_cnt;
			$target_ct_count = $ct_cnt[$ct];
		}
	}
	// HTMLファイル更新
	if(HTML_FLG){
		$self = $script_name4html;
		reset($data);
		$ct_cnt_flg = 0;
		// トップページ更新開始
		if($target_line_cnt && $target_line_cnt <= PAGEVIEW){
			top_html_make($data,$self,$ct_cnt_flg);
		}elseif($_POST['old_category'] != $_POST['category']){
			top_html_make($data,$self,$ct_cnt_flg);
		}
		// カテゴリページ更新開始
		if($target_line_cnt){
		if(CT_COUNT_FLG){
			if($_POST['old_category'] == $_POST['category']){
				$page_start = ceil($target_ct_count / PAGEVIEW);
				ct_html_make($_POST['category'],$ct_cnt[$_POST['category']],$page_start,$data,$self);
			}else{
				$page_start = 1;
				ct_html_make($_POST['category'],$ct_cnt[$_POST['category']],$page_start,$data,$self);
				ct_html_make($_POST['old_category'],$ct_cnt[$_POST['old_category']],$page_start,$data,$self);
			}
		}else{
			$page_start = 1;
			reset($ct_cnt);
			while(list($ct_no,$ct_count) = each($ct_cnt)){
				ct_html_make($ct_no,$ct_count,$page_start,$data,$self);
			}
		}
		}
	}
	// ロック解除
	unlock($fp);
	fclose($fp);

	# 修正完了メッセージ出力
	head_html("修正完了");
echo <<<EOM
<center><p><b>修正完了</b></p>
<table border="0" cellpadding="0" cellspacing="0" width="450">       
<tr><td width="100%"><table border=0 width="100%" cellspacing="1" cellpadding="3" bgcolor="#c0c0c0">
<tr><td bgcolor="#EFEFEF"><b>カテゴリ</b></td><td bgcolor="#FFFFFF">${category[$_POST['category']]}</td></tr>
<tr><td bgcolor="#EFEFEF" nowrap><b>サイト名</b><font color="#CC0000">*</font></td><td bgcolor="#FFFFFF">${_POST['site']}</td></tr>
<tr><td bgcolor="#EFEFEF"><b>サイトURL</b><font color="#CC0000">*</font></td><td bgcolor="#FFFFFF">${_POST['url']}</td></tr>
EOM;
	if(BANNER_FLG == 1){
		echo "<tr><td bgcolor=\"#EFEFEF\" nowrap><b>バナーURL</b><br>（88*31固定）</td><td bgcolor=\"#FFFFFF\">${_POST['banner']}</td></tr>\n";
	}
echo <<<EOM
<tr><td bgcolor="#EFEFEF"><b>コメント</b></td><td bgcolor="#FFFFFF">${_POST['comment']}</td></tr>
<tr><td bgcolor="#EFEFEF" nowrap><b>パスワード</b></td><td bgcolor="#FFFFFF">${_POST['pass']}</td></tr>
</table></td></tr></table>
EOM;
if(HTML_FLG){
	echo "<p align=center><a href=\"".HTML_TOPFILE."\">${title}に戻る</a></p></center>\n";
}else{
	echo "<p align=center><a href=\"${script_name4html}\">${title}に戻る</a></p></center>\n";
}
	foot_html();
}
#------------------#
#  データ削除処理  #
#------------------#
function delete(){
	global $category,$homeurl,$title,$ct_cnt,$REG,$SPAM,$script_name4html;

	$_POST['id'] = intval($_POST['id']);
	$fp = @fopen(LOGFILE, "r+") or error("fopen Error: ".LOGFILE);
	// ロック開始
	lock($fp);
	$data = file(LOGFILE);
	$line_cnt = 0;
	$target_line_cnt = 0;
	while(list(,$line) = each($data)){
		list($id,$count,$ct,$site,$url,$comment,$pass,$date,$host,$banner) = explode(",", $line);
		$line_cnt++;
		$ct_cnt[$ct]++;
		if($_POST['id'] == $id){
			if(!$SPAM['nopass'] && $pass == "" && $_POST['pass'] != ADMIN_PASS){
				error("パスワードを設定していない投稿は、修正・削除を許可していません");
			}
			// パスワードチェック
			if(md5($_POST['pass']) != $pass && $pass != "" && $_POST['pass'] != ADMIN_PASS){
				error("パスワードが違います");
			}
			$match = 1;
			$target_line_cnt = $line_cnt;
			$target_ct_count = $ct_cnt[$ct];
		}else{
			$newlog[] = $line;
		}
	}
	if(!$match){	error("該当No.が存在しません");	}
	unset($data);
	reset($newlog);
	$ct_cnt = array_fill(0, count($category), 0);

	// 書き込みバッファを 0 にする
	set_file_buffer($fp, 0);
	ftruncate($fp, 0);
	rewind($fp);
	while(list(,$value) = each($newlog)){	fputs($fp, $value); }
	// HTMLファイル更新
	if(HTML_FLG){
		$self = $script_name4html;
		$ct_cnt_flg = 1;
		// トップページ更新開始
		top_html_make($newlog,$self,$ct_cnt_flg);
		// カテゴリページ更新開始
		if($target_line_cnt){
		$page_start = 1;
		if(CT_COUNT_FLG){
			ct_html_make($ct,$ct_cnt[$ct],$page_start,$newlog,$self);
		}else{
			reset($ct_cnt);
			while(list($ct_no,$ct_count) = each($ct_cnt)){
				ct_html_make($ct_no,$ct_count,$page_start,$newlog,$self);
			}
		}
		}
	}
	// ロック解除
	unlock($fp);
	fclose($fp);

	# 削除完了メッセージ出力
	head_html("削除完了");
echo <<<EOM
<center><p><b>削除完了</b></p>
EOM;
if(HTML_FLG){
	echo "<p align=center><a href=\"".HTML_TOPFILE."\">${title}に戻る</a></p></center>\n";
}else{
	echo "<p align=center><a href=\"${script_name4html}\">${title}に戻る</a></p></center>\n";
}
	foot_html();
}
#------------------#
#  ランキング表示  #
#------------------#
function rank(){
	global $CNF,$category,$title,$homeurl,$ct_cnt,$target,$SPAM,$script_name4html;

	if(isset($_GET['p']) && intval($_GET['p']) > 0){
		$pagenow = intval($_GET['p']);
	}else{
		$pagenow = 1;
	}
	$arr1 = array();
	$arr2 = array();
	$fp = @fopen(LOGFILE, "r") or error("fopen Error: ".LOGFILE);
	while(!feof($fp)){
		list($id,$count,$ct,$site,$url,$comment,$pass,$date,$host,$banner) = explode(",", fgets($fp));
		$ct_cnt[$ct]++;
		$other = $ct.",".$site.",".$url.",".$comment.",".$banner;
		$target_id = "id".$id;
		$arr1[$target_id] = $count;
		$arr2[$target_id] = $other;
	}
	fclose($fp);
	array_pop($arr1);
	array_pop($arr2);
	arsort($arr1);
	head_html("ランキング");
echo <<<EOM
<a name=" top"></a><p><center>
<big>$title</big><br><br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-bottom: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr>
  <tr><td width="25%" bgcolor="${CNF[navi_color]}" align="left" height="25" style="padding-left: 5px;"><a href="$homeurl">ホーム</a></td>
  <td bgcolor="${CNF[navi_color]}" align="center" height="25" nowrap><b>ランキング</b></td>
EOM;
if(ADMIN_MODE == 1){
	if(RANK_FLG == 1){
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"><a href=\"${script_name4html}?mode=rank\">ランキング</a></td></tr>\n";
	}else{
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"></td></tr>\n";
	}
}else{
	if(RANK_FLG == 1){
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\">";
		if($SPAM['js']){
			echo "<a href=\"javascript:void(0);\" onClick=\"window.open('${script_name4html}?mode=regist','_top').focus();\">新規登録</a>";
		}else{
			echo "<a href=\"${script_name4html}?mode=regist\">新規登録</a>";
		}
		echo "&nbsp;&nbsp;<a href=\"${script_name4html}?mode=rank\">ランキング</a></td></tr>\n";
	}else{
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\">";
		if($SPAM['js']){
			echo "<a href=\"javascript:void(0);\" onClick=\"window.open('${script_name4html}?mode=regist','_top').focus();\">新規登録</a>";
		}else{
			echo "<a href=\"${script_name4html}?mode=regist\">新規登録</a>";
		}
		echo "</td></tr>\n";
	}
}
echo <<<EOM
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-top: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr></table></center>
<table border="0" cellpadding="0" cellspacing="4" width="100%">
  <tr><td height="10"></td>
    <td height="10" width="25%" nowrap></td></tr>
  <tr><td width="75%" valign="top">
EOM;
	$rows_all = count($arr1);
	$num_start = ($pagenow - 1) * PAGEVIEW + 1;
	if($rows_all < $pagenow * PAGEVIEW){
		$num_end = $rows_all;
	}else{
		$num_end = $pagenow * PAGEVIEW;
	}
	reset($arr1);
	for($i = 1; $i <= $num_end; $i++){
		if($i < $num_start){
			next($arr1);
		}else{
			list($target_id,$count) = each($arr1);
			list($ct,$site,$url,$comment,$banner) = explode(",", $arr2[$target_id]);
			$id = str_replace("id", "", $target_id);
			$banner = rtrim($banner);
			if(BANNER_FLG == 1 && $banner != ""){
				echo "<a href=\"${script_name4html}?mode=jump&amp;id=$id\" target=\"$target\"><img border=\"0\" src=\"${banner}\" width=\"88\" height=\"31\"></a>";
				if(TLINK_FLG == 1){	echo "　<a href=\"${script_name4html}?mode=jump&amp;id=$id\" target=\"$target\"><span class=\"site_title\">$site</span></a>"; }
				echo "<br>\n";
			}else{
				echo "<a href=\"${script_name4html}?mode=jump&amp;id=$id\" target=\"$target\"><span class=\"site_title\">$site</span></a><br>\n";
			}
			echo "<span style=\"background-color: ${CNF[comment_bgcolor]}\">$comment</span><br>\n";
			echo "<div align=\"right\"><font color=\"${CNF[comment2_bgcolor]}\">ヒット数：<b>$count</b>回 [${category[$ct]}] [No.$id]</font></div>\n";
		}
	}
echo <<<EOM
    <td width="25%" nowrap valign="top" style="padding-left: 5px;">
      <table border="0" cellpadding="2" cellspacing="0" width="100%" class=solid_left>
EOM;
while(list($key, $value) = each($category)){
	if(HTML_FLG){
		$key_sprintf = sprintf('%02d', $key);
		$filename = HTML_DIR.$key_sprintf."_01.html";
		echo "<tr><td width=\"5\"></td><td width=\"100%\" nowrap><a href=\"${filename}\">$value</a>（$ct_cnt[$key]）</td></tr>\n";
	}else{
		echo "<tr><td width=\"5\"></td><td width=\"100%\" nowrap><a href=\"${script_name4html}?mode=ct&amp;ct=$key\">$value</a>（$ct_cnt[$key]）</td></tr>\n";
	}
}
echo <<<EOM
      </table></td></tr>
  <tr><td></td>
    <td width="25%" nowrap></td></tr>
</table><br>
<center>
EOM;
	// ページコントロール
	if($rows_all > 0){	page_ctl($rows_all,$pagenow,$num_start); }
	echo "</center>\n";
	// 管理バー表示
	admin_bar();

	foot_html();
}
#----------------#
#  カテゴリ表示  #
#----------------#
function ct(){
	global $CNF,$category,$title,$homeurl,$ct_cnt,$target,$SPAM,$script_name4html;

	$_GET['ct'] = intval($_GET['ct']);
	if(isset($_GET['p']) && intval($_GET['p']) > 0){
		$pagenow = intval($_GET['p']);
	}else{
		$pagenow = 1;
	}
	head_html("カテゴリ：${category[$_GET['ct']]}");
echo <<<EOM
<a name=" top"></a><p><center>
<big>$title</big><br><br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-bottom: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr>
  <tr><td width="25%" bgcolor="${CNF[navi_color]}" align="left" height="25" style="padding-left: 5px;"><a href="$homeurl">ホーム</a></td>
  <td bgcolor="${CNF[navi_color]}" align="center" height="25" nowrap><b>${category[$_GET['ct']]}</b></td>
EOM;
if(ADMIN_MODE == 1){
	if(RANK_FLG == 1){
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"><a href=\"${script_name4html}?mode=rank\">ランキング</a></td></tr>\n";
	}else{
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"></td></tr>\n";
	}
}else{
	if(RANK_FLG == 1){
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\">";
		if($SPAM['js']){
			echo "<a href=\"javascript:void(0);\" onClick=\"window.open('${script_name4html}?mode=regist','_top').focus();\">新規登録</a>";
		}else{
			echo "<a href=\"${script_name4html}?mode=regist\">新規登録</a>";
		}
		echo "&nbsp;&nbsp;<a href=\"${script_name4html}?mode=rank\">ランキング</a></td></tr>\n";
	}else{
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\">";
		if($SPAM['js']){
			echo "<a href=\"javascript:void(0);\" onClick=\"window.open('${script_name4html}?mode=regist','_top').focus();\">新規登録</a>";
		}else{
			echo "<a href=\"${script_name4html}?mode=regist\">新規登録</a>";
		}
		echo "</td></tr>\n";
	}
}
echo <<<EOM
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-top: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr></table></center>
<table border="0" cellpadding="0" cellspacing="4" width="100%">
  <tr><td height="10"></td>
    <td height="10" width="25%" nowrap></td></tr>
  <tr><td width="75%" valign="top">
EOM;
	$rows_all = 0;
	$num_start = ($pagenow - 1) * PAGEVIEW + 1;
	$fp = @fopen(LOGFILE, "r") or error("fopen Error: ".LOGFILE);
	while(!feof($fp)){
		list($id,$count,$ct,$site,$url,$comment,$pass,$date,$host,$banner) = explode(",", fgets($fp));
		$banner = rtrim($banner);
		$ct_cnt[$ct]++;
		if($_GET['ct'] == $ct){
			$rows_all++;
			if(is_numeric($id) && $rows_all >= $num_start && $rows_all <= ($pagenow * PAGEVIEW)){
				if(RANK_FLG == 1){
					if(BANNER_FLG == 1 && $banner != ""){
						echo "<a href=\"${script_name4html}?mode=jump&amp;id=$id\" target=\"$target\"><img border=\"0\" src=\"${banner}\" width=\"88\" height=\"31\"></a>";
						if(TLINK_FLG == 1){	echo "　<a href=\"${script_name4html}?mode=jump&amp;id=$id\" target=\"$target\"><span class=\"site_title\">$site</span></a>"; }
						echo "<br>\n";
					}else{
						echo "<a href=\"${script_name4html}?mode=jump&amp;id=$id\" target=\"$target\"><span class=\"site_title\">$site</span></a><br>\n";
					}
				}else{
					if(BANNER_FLG == 1 && $banner != ""){
						echo "<a href=\"$url\" target=\"$target\"><img border=\"0\" src=\"${banner}\" width=\"88\" height=\"31\"></a>";
						if(TLINK_FLG == 1){	echo "　<a href=\"$url\" target=\"$target\"><span class=\"site_title\">$site</span></a>"; }
						echo "<br>\n";
					}else{
						echo "<a href=\"$url\" target=\"$target\"><span class=\"site_title\">$site</span></a><br>\n";
					}
				}
				echo "<span style=\"background-color: ${CNF[comment_bgcolor]}\">$comment</span><br>\n";
				if(RANK_FLG){
					echo "<div align=\"right\"><font color=\"${CNF[comment2_bgcolor]}\">ヒット数：<b>$count</b>回 [${category[$ct]}] [No.$id]</font></div>\n";
				}else{
					echo "<div align=\"right\"><font color=\"${CNF[comment2_bgcolor]}\">[${category[$ct]}] [No.$id]</font></div>\n";
				}
			}
		}
	}
	fclose($fp);
echo <<<EOM
    <td width="25%" nowrap valign="top" style="padding-left: 5px;">
      <table border="0" cellpadding="2" cellspacing="0" width="100%" class=solid_left>
EOM;
while(list($key, $value) = each($category)){
	echo "<tr><td width=\"5\"></td><td width=\"100%\" nowrap><a href=\"${script_name4html}?mode=ct&amp;ct=$key\">$value</a>（$ct_cnt[$key]）</td></tr>\n";
}
echo <<<EOM
      </table></td></tr>
  <tr><td></td>
    <td width="25%" nowrap></td></tr>
</table><br>
<center>
EOM;
	// ページコントロール
	if($rows_all > 0){	page_ctl($rows_all,$pagenow,$num_start); }
	echo "</center>\n";
	// 管理バー表示
	admin_bar();

	foot_html();
}
#--------------------------------#
#  カウントアップ、ロケーション  #
#--------------------------------#
function jump(){
	global $CNF;

	$_GET['id'] = intval($_GET['id']);
	$fp = @fopen(LOGFILE, "r+") or error("fopen Error: ".LOGFILE);
	// ロック開始
	lock($fp);
	$data = file(LOGFILE);
	# 書き込みバッファを 0 にする
	set_file_buffer($fp, 0);
	ftruncate($fp, 0);
	rewind($fp);
	while(list(,$value) = each($data)){
		$value = rtrim($value);
		list($id,$count,$ct,$site,$url,$comment,$pass,$date,$host,$banner) = explode(",", $value);
		if($_GET['id'] != $id){
			fputs($fp, "$value\n");
		}else{
			$next_url = $url;
			$date = gmdate("Y/m/d",time()+9*60*60);
			$count++;
			$line = "$id,$count,$ct,$site,$url,$comment,$pass,$date,$host,$banner\n";
			fputs($fp, $line);
		}
	}
	// ロック解除
	unlock($fp);
	fclose($fp);
	// ロケーション
	header("Location: $next_url");
}
#------------------#
#  キーワード検索  #
#------------------#
function do_search(){
	global $title,$CNF,$script_name4html;

	if(isset($_POST['p']) && intval($_POST['p']) > 0){
		$pagenow = intval($_POST['p']);
	}else{
		$pagenow = 1;
	}
	$num_start = ($pagenow - 1) * PAGEVIEW + 1;

	head_html("${_POST['word']} の検索結果");
echo <<<EOM
<center>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr><td width="50%" align="center"><big>${title}</big></td>
    <td width="50%" nowrap align="center"><form action="${script_name4html}" method="post">
    <input type=hidden name=mode value=do_search><input type=text name=word size=30 value="${_POST['word']}"> 
EOM;
if($_POST['cond'] == "and"){
	echo "<select name=cond><option value=\"and\">AND<option value=\"or\">OR</select> <input type=\"submit\" value=\"検索\"></td></form></tr></table><br>\n";
}else{
	echo "<select name=cond><option value=\"and\">AND<option value=\"or\" selected>OR</select> <input type=\"submit\" value=\"検索\"></td></form></tr></table><br>\n";
}
	$_POST['word'] = h2t($_POST['word']);
	$_POST['word'] = str_replace("　", " ", $_POST['word']);
	$_POST['word'] = ereg_replace("( )+", " ", $_POST['word']);
	$keywords = split(" ", $_POST['word']);
if($keywords[0] != ""){
	$rows_all = 0;
	// 検索開始
	search_rtn($keywords,$pagenow,$num_start,$rows_all);
	// ページコントロール
	if($rows_all < $pagenow * PAGEVIEW){
		$num_end = $rows_all;
	}else{
		$num_end = $pagenow * PAGEVIEW;
	}
	if($rows_all > 0){
		echo "<br><center>";
		for($i = 0; $i < count($keywords); $i++){
			echo "$keywords[$i] ";
		}
		echo "の検索結果　".$rows_all."件中　".$num_start." - ".$num_end." 件目</center>\n";
	}
	$table_flg = 0;
	if($pagenow > 1){
		$page_prev = $pagenow - 1;
		$button_value = "&lt;&lt;前の".PAGEVIEW."件";
		$table_flg = 1;
echo <<<EOM
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td width="50%" align="left">
<form action="${script_name4html}" method="post">
<input type=hidden name=mode value=do_search>
<input type=hidden name=word size=30 value="${_POST['word']}">
<input type=hidden name=cond value="${_POST['cond']}">
<input type=hidden name=p value="${page_prev}">
<input type="submit" value="${button_value}"></form></td>
EOM;
	}
	if($rows_all > $num_end){
		$next_view = $rows_all - $num_end;
		if($next_view > PAGEVIEW){	$next_view = PAGEVIEW;	}
		$page_next = $pagenow + 1;
		$button_value = "次の".$next_view."件&gt;&gt;";
		if($table_flg == 0){
			$table_flg = 1;
			echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
			echo "<tr><td width=\"50%\" align=\"left\"></td>\n";
		}
echo <<<EOM
<td width="50%" align="right">
<form action="${script_name4html}" method="post">
<input type=hidden name=mode value=do_search>
<input type=hidden name=word size=30 value="${_POST['word']}">
<input type=hidden name=cond value="${_POST['cond']}">
<input type=hidden name=p value="${page_next}">
<input type="submit" value="${button_value}"></form></td></tr></table>
EOM;
	}elseif($table_flg == 1){
		echo "<td width=\"50%\" align=\"right\"></td></tr></table>\n";
	}else{
		echo "<br>";
	}
	// 管理バー表示
	admin_bar();
}else{
	error("キーワードが入力されていません");
}
	foot_html();
}
#------------#
#  検索処理  #
#------------#
function search_rtn(&$keywords,&$pagenow,&$num_start,&$match_cnt){
	global $homeurl,$category,$CNF,$target,$SPAM,$script_name4html;

	$fp = @fopen(LOGFILE, "r+") or error("fopen Error: ".LOGFILE);
echo <<<EOM
<table border="0" cellpadding="0" cellspacing="0" width="100%">                               
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-bottom: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr>                               
  <tr><td width="25%" bgcolor="${CNF[navi_color]}" align="left" height="25" style="padding-left: 5px;"><a href="$homeurl">ホーム</a></td>
  <td bgcolor="${CNF[navi_color]}" align="center" height="25" nowrap><b>${_POST['word']} の検索結果</b></td>
EOM;
if(ADMIN_MODE == 1){
	if(RANK_FLG == 1){
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"><a href=\"${script_name4html}?mode=rank\">ランキング</a></td></tr>\n";
	}else{
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\"></td></tr>\n";
	}
}else{
	if(RANK_FLG == 1){
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\">";
		if($SPAM['js']){
			echo "<a href=\"javascript:void(0);\" onClick=\"window.open('${script_name4html}?mode=regist','_top').focus();\">新規登録</a>";
		}else{
			echo "<a href=\"${script_name4html}?mode=regist\">新規登録</a>";
		}
		echo "&nbsp;&nbsp;<a href=\"${script_name4html}?mode=rank\">ランキング</a></td></tr>\n";
	}else{
		echo "<td width=\"25%\" bgcolor=\"${CNF[navi_color]}\" align=\"right\" height=\"25\" nowrap style=\"padding-right: 5px;\">";
		if($SPAM['js']){
			echo "<a href=\"javascript:void(0);\" onClick=\"window.open('${script_name4html}?mode=regist','_top').focus();\">新規登録</a>";
		}else{
			echo "<a href=\"${script_name4html}?mode=regist\">新規登録</a>";
		}
		echo "</td></tr>\n";
	}
}
echo <<<EOM
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-top: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr></table></center>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr><td width="100%" valign="top"><br>
EOM;
	while(!feof($fp)){
		$rec = fgets($fp, 1024);
		$match = 0;
		for($i = 0; $i < count($keywords); $i++){
			if($_POST['cond'] == "or"){
				if(stristr($rec, $keywords[$i])){
					$match = 1;
					break;
				}
			}else{
				if(stristr($rec, $keywords[$i])){
					$match = 1;
				}else{
					$match = 0;
					break;
				}
			}
		}
		if($match == 1){
			$match_cnt++;
			if($match_cnt >= $num_start && $match_cnt <= ($pagenow * PAGEVIEW)){
				list($id,$count,$ct,$site,$url,$comment,$pass,$date,$host,$banner) = explode(",", $rec);
				$banner = rtrim($banner);
			if(RANK_FLG == 1){
				if(BANNER_FLG == 1 && $banner != ""){
					echo "<a href=\"${script_name4html}?mode=jump&amp;id=$id\" target=\"$target\"><img border=\"0\" src=\"${banner}\" width=\"88\" height=\"31\"></a>";
					if(TLINK_FLG == 1){	echo "　<a href=\"${script_name4html}?mode=jump&amp;id=$id\" target=\"$target\"><span class=\"site_title\">$site</span></a>"; }
					echo "<br>\n";
				}else{
					echo "<a href=\"${script_name4html}?mode=jump&amp;id=$id\" target=\"$target\"><span class=\"site_title\">$site</span></a><br>\n";
				}
			}else{
				if(BANNER_FLG == 1 && $banner != ""){
					echo "<a href=\"$url\" target=\"$target\"><img border=\"0\" src=\"${banner}\" width=\"88\" height=\"31\"></a>";
					if(TLINK_FLG == 1){	echo "　<a href=\"$url\" target=\"$target\"><span class=\"site_title\">$site</span></a>"; }
					echo "<br>\n";
				}else{
					echo "<a href=\"$url\" target=\"$target\"><span class=\"site_title\">$site</span></a><br>\n";
				}
			}
			echo "<span style=\"background-color: ${CNF[comment_bgcolor]}\">$comment</span><br>\n";
			if(RANK_FLG){
				echo "<div align=\"right\"><font color=\"${CNF[comment2_bgcolor]}\">ヒット数：<b>$count</b>回 [${category[$ct]}] [No.$id]</font></div>\n";
			}else{
				echo "<div align=\"right\"><font color=\"${CNF[comment2_bgcolor]}\">[${category[$ct]}] [No.$id]</font></div>\n";
			}
			}
		}
	}
	fclose($fp);
echo "</td></tr></table><br>\n";
}
#--------------------------#
#  ランキングリセット入口  #
#--------------------------#
function rank_reset(){
	global $title,$script_name4html;

	head_html("ランキングリセット");
echo <<<EOM
[ <a href="${script_name4html}">&lt;&lt; ${title}に戻る</a> ]<br>
<center><b>ランキングリセット</b>
<hr size="1">
<form action="${script_name4html}" method="post"><font color="#CC6633">▼</font>管理用パスワードを入力して下さい<br>
<input type=hidden name=mode value=do_rank_reset>
パスワード：<input type="password" name=pass size="10" maxlength="8"> <input type="submit" value="ランキングをリセットする"></form>
<hr size="1">
EOM;

	foot_html();
}
#--------------------------#
#  ランキングリセット実行  #
#--------------------------#
function do_rank_reset(){
	global $title,$script_name4html;

	// パスワードチェック
	if($_POST['pass'] != ADMIN_PASS){
			error("パスワードが違います");
	}
	$fp = @fopen(LOGFILE, "r+") or error("fopen Error: ".LOGFILE);
	// ロック開始
	lock($fp);
	$data = file(LOGFILE);
	// 書き込みバッファを 0 にする
	set_file_buffer($fp, 0);
	ftruncate($fp, 0);
	rewind($fp);
	while(list(,$value) = each($data)){
		$value = rtrim($value);
		list($id,$count,$ct,$site,$url,$comment,$pass,$date,$host,$banner) = explode(",", $value);
		$line = "$id,0,$ct,$site,$url,$comment,$pass,$date,$host,$banner\n";
		fputs($fp, $line);
	}
	// ロック解除
	unlock($fp);
	fclose($fp);

	# ランキングリセット完了メッセージ出力
	head_html("ランキングリセット完了");
echo <<<EOM
<center><p><b>ランキングリセット完了</b></p>
<p align=center><a href="${script_name4html}">${title}に戻る</a></p>
</center>
EOM;
	foot_html();
}
#----------------------#
#  HTMLファイル再構築  #
#----------------------#
function html_remake(){
	global $category,$homeurl,$title,$ct_cnt,$script_name4html;

	$self = $script_name4html;
	if($_POST['pass'] != ADMIN_PASS){
		error("管理用パスワードが違います");
	}
	$fp = @fopen(LOGFILE, "r+") or error("fopen Error: ".LOGFILE);
	// ロック開始
	lock($fp);
	$data = file(LOGFILE);
	// トップページ作成開始
	$ct_cnt_flg = 1;
	top_html_make($data,$self,$ct_cnt_flg);
	// カテゴリページ作成開始
	$page_start = 1;
	reset($ct_cnt);
	while(list($ct_no,$ct_count) = each($ct_cnt)){
		ct_html_make($ct_no,$ct_count,$page_start,$data,$self);
	}

	// ロック解除
	unlock($fp);
	fclose($fp);

	# HTMLファイル再構築完了メッセージ出力
	head_html("HTMLファイル再構築完了");
	echo "<center><p><b>HTMLファイル再構築完了</b></p>\n";
	if(HTML_FLG){
		echo "<p align=center><a href=\"".HTML_TOPFILE."\">${title}に戻る</a></p></center>\n";
	}else{
		echo "<p align=center><a href=\"${script_name4html}\">${title}に戻る</a></p></center>\n";
	}

	foot_html();
}
#----------------#
#  管理バー表示  #
#----------------#
function admin_bar(){
	global $CNF,$script_name4html;

echo <<<EOM
<center><table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-bottom: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr>
  <tr><td width="25%" bgcolor="${CNF[navi_color]}" align="left" height="30" style="padding-left: 5px;"><a href="javascript:history.back();">&lt;&lt;戻る</a></td>
  <form action="${script_name4html}" method="post">
  <td bgcolor="${CNF[navi_color]}" align="center" height="30" nowrap>No：<input type="text" name="id" size="5" style="ime-mode:disabled"> Pass：<input type="password" name=pass size="10" maxlength="8">
EOM;
	echo "\n<select name=\"mode\">";
	if(ADMIN_MODE){
		echo "<option value=\"regist\" selected>登録<option value=\"modify\">修正";
	}else{
		echo "<option value=\"modify\" selected>修正";
	}
	echo "<option value=\"delete\">削除";
	if(HTML_FLG){	echo "<option value=\"html_remake\">HTML"; }
	echo "</option></select>\n";
echo <<<EOM
  <input type="submit" value="送信" name="submit"></td></form>
  <td width="25%" bgcolor="${CNF[navi_color]}" align="right" height="30" style="padding-right: 5px;"><a href="#top">トップへ</a></td></tr>
  <tr><td width="100%" bgcolor="${CNF[navi_border]}" colspan="3" style="border-top: 1px solid #FFFFFF;"><img width=1 height=1 alt=""></td></tr>
</table></center>
EOM;
}
#----------------------#
#  ページコントロール  #
#----------------------#
function page_ctl(&$rows_all,&$pagenow,&$num_start){
	global $script_name4html;

	if($rows_all < $pagenow * PAGEVIEW){
		$num_end = $rows_all;
	}else{
		$num_end = $pagenow * PAGEVIEW;
	}
	if($rows_all > PAGEVIEW){
		echo "$num_start - $num_end ( $rows_all 件中 )　 [ \n";
	}else{
		echo "$num_start - $num_end ( $rows_all 件中 )<br><br>\n";
	}
	if($pagenow != 1){
		$page_prev = $pagenow - 1;
		if($_GET['mode'] == "ct"){
			echo "/ <a href=\"${script_name4html}?mode=${_GET['mode']}&amp;ct=${_GET['ct']}&amp;p=$page_prev\">&lt;- 前ページ</a> \n";
		}else{
			echo "/ <a href=\"${script_name4html}?mode=${_GET['mode']}&amp;p=$page_prev\">&lt;- 前ページ</a> \n";
		}
	}
	if($rows_all > $num_end){
		$page_next = $pagenow + 1;
		if($_GET['mode'] == "ct"){
			echo "/ <a href=\"${script_name4html}?mode=${_GET['mode']}&amp;ct=${_GET['ct']}&amp;p=$page_next\">次ページ -&gt;</a>\n";
		}else{
			echo "/ <a href=\"${script_name4html}?mode=${_GET['mode']}&amp;p=$page_next\">次ページ -&gt;</a>\n";
		}
	}
	if($rows_all > PAGEVIEW){
		echo " / ]<br><br>\n";
	}
}
#--------------------#
#  バックアップ処理  #
#--------------------#
function backup(&$data){

	$today = gmdate("Ymd",time()+9*60*60);
	$bakday = file(BAKDAYFILE);
	list($lastbak,$count) = explode(",", rtrim($bakday[0]));
	if($today != $lastbak){
		$count++;
		if($count > BACKCNT){	$count = 1;	}
		$len = strlen(BACKFILE);
		$rpos = strrpos(BACKFILE, ".");
		$str1_len = $rpos;
		$str2_len = $len - $rpos;
		$str1 = substr(BACKFILE, 0, $str1_len);
		$str2 = substr(BACKFILE, $str1_len, $str2_len);
		$backname = $str1.$count.$str2;
		if(file_exists($backname)){
			$mode = "r+";
			$chmod_flg = 1;
		}else{
			$mode = "w";
			$chmod_flg = 0;
		}
		$fp = @fopen("$backname", "$mode") or error("fopen Error: $backname");
		// ロック開始
		lock($fp);
		// 書き込みバッファを 0 にする
		set_file_buffer($fp, 0);
		if($chmod_flg){		ftruncate($fp, 0); }
		rewind($fp);
		while(list(,$value) = each($data)){	fputs($fp, $value); }
		// ロック解除
		unlock($fp);
		fclose($fp);
		if(!$chmod_flg){	chmod("$backname", 0606); }
		$fp = @fopen(BAKDAYFILE, "r+") or error("fopen Error: ".BAKDAYFILE);
		// ロック開始
		lock($fp);
		// 書き込みバッファを 0 にする
		set_file_buffer($fp, 0);
		ftruncate($fp, 0);
		rewind($fp);
		fputs($fp, "$today,$count");
		// ロック解除
		unlock($fp);
		fclose($fp);
	}
}
#----------------#
#  ヘッダー表示  #
#----------------#
function head_html($title){
	global $CNF,$SPAM,$msg_noscript;

	$site_font_weight = $CNF['site_bold_flag'] ? "bold" : "normal";
if($CNF[font_family] != ""){	$font_family = "font-family: ".$CNF[font_family].";"; }
if($CNF[scrollbar] != ""){	$scrollbar = "\nbody { scrollbar-base-color: ".$CNF[scrollbar]."; }"; }
echo <<<EOM
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
	if($SPAM['js'] && $msg_noscript != ""){	echo $msg_noscript; }
}
#----------------#
#  フッター表示  #
#----------------#
function foot_html(){
	global $homeurl,$copyright;

echo <<<EOM
<p align=center style="font-size:10px;">${copyright}</p>
</body></html>
EOM;
}
#----------------#
#  デコード処理  #
#----------------#
function decode(){

	if($_SERVER['REQUEST_METHOD'] == "GET"){	error("不正な投稿です"); }

	foreach($_POST as $key => $value){
		// バックスラッシュの排除
		if(get_magic_quotes_gpc()){	$value = stripslashes($value); }

		// タグ処理
		$value = htmlspecialchars($value);

		// 区切り文字","をタグ用に処理
		$value = str_replace(",", "&#44;", $value);

		// 改行処理
		if($key == "comment"){
			$value = preg_replace('/[\t\0]/', '', $value);
			$value = str_replace("\r\n", "<br>", $value);
			$value = str_replace("\r", "<br>", $value);
			$value = str_replace("\n", "<br>", $value);
		}else{
			$value = preg_replace('/[\r\n\t\0]/', '', $value);
		}
		$value = trim($value);
		$_POST[$key] = $value;
	}
}
?>