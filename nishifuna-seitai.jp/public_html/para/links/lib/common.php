<?php
##======================================================##
##  共通仕様サブルーチン                                ##
##======================================================##
#--------------#
#  エラー処理  #
#--------------#
function error($msg){
	global $homeurl;

echo <<<EOM
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta http-equiv="Content-Language" content="ja">
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<title>$msg</title>
</head>
<body>
<h4>$msg</h4>
恐れ入りますが、再度試して下さい。<hr>
前の画面に戻ってやり直す場合は、ブラウザの「戻る」ボタンを押して下さい。<hr>
<a href="javascript:history.back();">&lt;&lt;戻る</a>　  <a href="${homeurl}">ホームへ戻る</a>
</body></html>
EOM;
exit;
}
#--------------------#
#  最後のメッセージ  #
#--------------------#
function finish($msg){
	global $homeurl,$title;

$msg4text = strip_tags($msg);
echo <<<EOM
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta http-equiv="Content-Language" content="ja">
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<title>$msg4text</title>
<link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>
<h4>$msg</h4>
<a href="javascript:history.back();">&lt;&lt;戻る</a>　  <a href="${homeurl}">ホームへ戻る</a>
</body></html>
EOM;
exit;
}
#------------------#
#  ホストチェック  #
#------------------#
function check_host(){
	global $SPAM;

	$ch = new checkHost();
	if($ch->check_allow_host()){	return; }
	if(!$ch->check_deny_host()){	error("アクセスを許可されていません"); }
	// 逆引きチェック
	if(!$ch->check_hostbyaddr($SPAM['hostbyname'])){	error("逆引きエラー"); }
	// 正引きチェック
	if(!$ch->check_hostbyname($SPAM['hostbyaddr'])){	error("正引きエラー"); }
	unset($ch);
}
#--------------------------#
#  ホストチェック用クラス  #
#--------------------------#
class checkHost{

	var $host;
	var $addr;
	// コンストラクタ
	function checkHost(){

		$this->host = getenv("REMOTE_HOST");
		$this->addr = getenv("REMOTE_ADDR");
		if($this->host == "" || $this->host == $this->addr){
			$this->host = @gethostbyaddr($this->addr);
		}
	}
	function check_deny_host(){

		if(DENY_HOST == ""){	return true; }
		$deny = split(",", DENY_HOST);
		while(list(,$value) = each($deny)){
			$value = str_replace("*",".*",$value);
			if(eregi($value, $this->host) || eregi($value, $this->addr)){
				return false;
			}
		}
		return true;
	}
	function check_allow_host(){

		if(ALLOW_HOST == ""){	return false; }
		$deny = split(",", ALLOW_HOST);
		while(list(,$value) = each($deny)){
			$value = str_replace("*",".*",$value);
			if(eregi($value, $this->host) || eregi($value, $this->addr)){
				return true;
			}
		}
		return false;
	}
	function check_hostbyaddr($flag=false){

		if($flag){	return true; }
		if(@gethostbyaddr($this->addr) == $this->addr){	return false; }
		return true;
	}
	function check_hostbyname($flag=false){

		if($flag){	return true; }
		if(@gethostbyname($this->host) == $this->host){	return false; }
		return true;
	}
}
#---------------------------------#
#  Referer（リファラー）チェック  #
#---------------------------------#
function check_referer(){
	global $SPAM;

	if(!$SPAM['referer']){	return; }
	$referer_url = getenv("HTTP_REFERER");
	$target_url = $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"];
	$pattern = '/^https?:\/\/'. preg_quote($target_url, '/') .'/';
	if(!preg_match($pattern, $referer_url)){	error("アクセス経路が不正です"); }
}
#--------------------------------#
#  ユーザー情報をCookieにセット  #
#--------------------------------#
function set_tracking(){
	global $SPAM;

	if(!$SPAM['cookie']){	return; }
	if($SPAM['change_ip'] || $SPAM['change_ua']){	return; }
	$ip = $_SERVER['REMOTE_ADDR'];
	$ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
	$val = sha1($ip."-".$SPAM['secret_key'])."-".sha1($ua."-".$SPAM['secret_key']);
	setcookie("tracking", $val);
}
#------------------------#
#  ユーザー情報チェック  #
#------------------------#
function check_tracking(){
	global $SPAM;

	if(!$SPAM['cookie']){	return; }
	if($SPAM['change_ip'] || $SPAM['change_ua']){	return; }
	if(!isset($_COOKIE["tracking"])){	error("照合用のユーザー情報が見つかりませんでした。"); }
	list($ip_old,$ua_old) = explode("-", $_COOKIE["tracking"]);
	$ip = $_SERVER['REMOTE_ADDR'];
	if(sha1($ip."-".$SPAM['secret_key']) != $ip_old){	error("IPアドレスの変更は許可していません。"); }
	$ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
	if(sha1($ua."-".$SPAM['secret_key']) != $ua_old){	error("ユーザーエージェントの変更は許可していません。"); }
}
#--------------------#
#  セッションセット  #
#--------------------#
function set_session(){
	global $SPAM;

	if(!$SPAM['ticket']){	return; }
	session_start();
	$_SESSION['ticket'] = md5(uniqid('', true).mt_rand()) ."-". time();
}
#----------------------#
#  セッションチェック  #
#----------------------#
function check_session(){
	global $SPAM;

	if(!$SPAM['ticket']){	return; }
	session_start();
	if(!isset($_POST['submit'], $_SESSION['ticket'], $_POST['ticket']) || $_SESSION['ticket'] !== $_POST['ticket']){
		error("リロード、又は不正なアクセスです。フォームを再表示してから再度投稿して下さい。");
	}
	$params = explode('-', $_SESSION['ticket']);
	if(count($params) != 2){	error("パラメーターが不正です"); }
	if((int)$params[1] + (int)$SPAM['limit'] > time()){	error("投稿制限中です。少し時間をおいて再度投稿して下さい。"); }
	if((int)$params[1] + (int)$SPAM['expire'] < time()){	error("投稿有効期限を過ぎました。フォームを再表示してから再度投稿して下さい。"); }
	$_SESSION = array();
	if(isset($_COOKIE['ticket'])){	setcookie("ticket", "", time() - 60*60); }
	session_destroy();
}
#--------------------#
#  NGワードチェック  #
#--------------------#
function check_ng_word($arr){

	if(empty($arr)){	return; }
	$deny = split(",", NG_WORD);
	while(list(,$value) = each($deny)){
		$pattern = '/'. preg_quote($value, '/') .'/i';
		foreach($arr as $key){
			if(preg_match($pattern, $_POST[$key])){
				error("\"".t2h($value)."\"はNGワードです。利用を許可されていません。");
			}
		}
	}
}
#-----------------#
#  NGURLチェック  #
#-----------------#
function check_ng_url($arr){

	if(empty($arr)){	return; }
	$deny = split(",", NG_URL);
	while(list(,$value) = each($deny)){
		$value = str_replace("http://", "", $value);
		$value = str_replace("https://", "", $value);
		$value = str_replace("*",".*",$value);
		foreach($arr as $key){
			if(eregi($value, $_POST[$key])){
				$value = str_replace(".*", "*", $value);
				error("\"".t2h($value)."\"はNGURLです。利用を許可されていません。");
			}
		}
	}
}
#----------------------#
#  認証キー作成・表示  #
#----------------------#
function show_regkey(){
	global $REG;

	// 認証キーを使う場合
	if($REG['check']){
		// 認証キー用サブルーチン
		require_once("./lib/reglib.php");
		// 認証キー作成
		$encrypted = make_regkey();
		echo <<<EOM
<tr><td align="left" bgcolor="#EFEFEF" nowrap><b>認証キー：</b><input type="hidden" name="encrypted" value="${encrypted}"></td>
<td align="left" bgcolor="#FFFFFF"><input type="text" name="regkey" size="6" maxlength="4" style="ime-mode:disabled"> （認証キーに&nbsp;<img src="./regkey.php?${encrypted}" alt="認証キー" align="absmiddle">&nbsp;を入力して下さい。）</td></tr>\n
EOM;
	}
}
#----------------#
#  認証キー検査  #
#----------------#
function verify_regkey(){
	global $REG;

	if($REG['check']){
		if(empty($_POST['regkey'])){	error("認証キーを入力して下さい。"); }
		if(!preg_match('/^[0-9]{4}$/', $_POST['regkey'])){	error("認証キーには指定された数字を入力して下さい。"); }

		// スパム投稿対策用サブルーチンの取り込み
		require_once("${CNF['path_lib']}reglib.php");

		$encrypted = rawurldecode($_POST['encrypted']);
		$decrypted = decode_regkey($encrypted);
		$err_msg = check_regkey($decrypted);
		if(!empty($err_msg)){	error($err_msg); }
	}
}
#----------------#
#  設定チェック  #
#----------------#
function check(){
	global $REG;

	// 認証キー用チェック
	if($REG['check'] == 1){
		$img = imagecreate(1, 1) or die("Could not Initialize of [ new GD image stream ]");
		imagedestroy($img);
		if($REG['crypt'] == 1){
			$hd = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_ECB, '');
			mcrypt_module_close($hd);
		}elseif($REG['crypt'] == 2){
			$value = bcadd(1, 1);
			$value = bcsub(1, 1);
		}
	}
	finish("設定チェック：OK");
}
#---------------------------------#
#  著作権表示出力(改変/削除不可)  #
#---------------------------------#
function show_copyright(){
	global $copyright;

	echo $copyright;
}
#----------------#
#  TEXT -> HTML  #
#----------------#
function t2h($str){

	$str = htmlspecialchars($str, ENT_QUOTES);
	$str = str_replace(",", "&#44;", $str);
	$str = str_replace("\r\n", "<br>", $str);
	$str = str_replace("\r", "<br>", $str);
	$str = str_replace("\n", "<br>", $str);
	return $str;
}
#----------------------------------------#
#  HTML -> TEXT（使用できない文字の置換）#
#----------------------------------------#
function h2t($str){
	$str = str_replace("&amp;", "&", $str);
	$str = str_replace("&quot;", "\"", $str);
	$str = str_replace("&#39;", "\'", $str);
	$str = str_replace("&lt;", "<", $str);
	$str = str_replace("&gt;", ">", $str);
	$str = str_replace("&#44;", ",", $str); // 区切り文字を元に戻す
	$str = str_replace("<br>", "\n", $str);
    	return $str;
}
#------------------------------#
#  URLエンコード（RFC3986用）  #
#------------------------------#
function encode_url_raw($str){

	return str_replace("%7E", "~", rawurlencode($str));
}
#------------------#
#  リンク自動変換  #
#------------------#
function link_make(&$str){

	$str = ereg_replace("(https?|ftp)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)","<a href=\"\\1\\2\" target=\"".TARGET."\">\\1\\2</a>",$str);
}
#--------------#
#  ロック処理  #
#--------------#
function lock(&$fp){

	for($try = 3; $try >= 1; $try--){
		if(flock($fp, LOCK_EX)){	break; }
		if($try == 1){
			error("只今、サーバーが混雑しています。<br>しばらくしてから、もう一度リクエストして下さい。");
		}
		sleep(1);
	}
}
#--------------#
#  ロック解除  #
#--------------#
function unlock(&$fp){

  	flock($fp, LOCK_UN);
}
?>