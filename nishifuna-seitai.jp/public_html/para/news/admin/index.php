<?php

/* ページ引数(ページ切り替え)　m=*/
define("PAGE","m");

$target = escape($_GET['m']);
if($target == "")
{
	$target = "index";
}

/*設定ファイル読み込み*/
require_once("./lorder.php");
require_once("./class/module.php");

/*モジュール読み込み*/
require_once("./action/".$target.".php");

if($target=="index" or $target=="logout"){
/*ページロード*/
require_once("./view/".$target.".tpl");
}else{
/*ヘッダーロード*/
require_once("./view/head.tpl");

/*メニューロード*/
require_once("./view/login.tpl");

/*ページロード*/
require_once("./view/".$target.".tpl");
}
/*フッターロード*/
require_once("./view/foot.tpl");

/*RSS更新*/
if($target == "news")
{
	require_once("rss.php");
}

/*ログインチェック*/
function loginCheck($str)
{
	if($str == "admin")
	{
		return 1;
	}else{
		return 0;
	}
}

/*
 *文字コード　変換
 */
 /*SJIS→EUC*/
function sjis2euc(&$str)
{
	//$str = mb_convert_encoding($str,"EUC-JP","AUTO");
	return $str;
}

 /*EUC→SJIS*/
function euc2sjis(&$str)
{
	//$str = mb_convert_encoding($str,"SJIS","AUTO");
	return $str;
}

/**
 *エスケープ処理
 */
function escape(&$str)
{
	if(get_magic_quotes_gpc()) 
	{
		$str = stripslashes(trim(htmlspecialchars($str)));
	}else{
		$str = trim(htmlspecialchars($str));
	}
	return $str;
}

/*
 *編集BOXエスケープ
 */
function escape2(&$str)
{
	if(get_magic_quotes_gpc()) 
	{
		$str = stripslashes(trim($str));
	}else{
		$str = trim($str);
	}
	return $str;
}

?>