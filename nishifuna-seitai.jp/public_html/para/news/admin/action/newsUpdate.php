<?php
session_start();

/*
 *モジュール
 */
require_once("./class/module.php");

$method = new module();

/*ログインチェック*/

if($_SESSION['pass'] != SSL_PASS)
{
	 /*ログイン失敗*/
	header( "Location: ./?m=index&t=out" );
}

if($_GET['r']=="preview")
{
	$reDate = escape($_POST['date']);
	$reTitle = escape($_POST['title']);
	$reMessage = escape($_POST['message']);
	$reUp = escape($_POST['up']);
	
	$reDate = str_replace("&lt;br /&gt;","\n",$reDate);
	$reTitle = str_replace("&lt;br /&gt;","\n",$reTitle);
	$reMessage = str_replace("&lt;br /&gt;","\n",$reMessage);
	$reUp = str_replace("&lt;br /&gt;","\n",$reUp);

	sjis2euc($reDate);
	sjis2euc($reTitle);
	sjis2euc($reMessage);
	sjis2euc($reUp);
}else{
	$no = escape($_GET['no']);
	$read[root] =  DATA_ROOT."news.cgi";
	$item = $method->linkReadNum($read,$no);
	$array = explode("\t",$item);
	sjis2euc($array[0]);
	sjis2euc($array[1]);
	sjis2euc($array[2]);
	sjis2euc($array[3]);
	$reDate    = $array[0];
	$reTitle   = $array[1];
	$reMessage = $array[2];
	$reUp      = $array[3];

	$reDate  = str_replace("<br />","\n",$reDate);
	$reTitle = str_replace("<br />","\n",$reTitle);
	$reMessage = str_replace("<br />","\n",$reMessage);
	$reUpe = str_replace("<br />","\n",$reUp);
}
?>