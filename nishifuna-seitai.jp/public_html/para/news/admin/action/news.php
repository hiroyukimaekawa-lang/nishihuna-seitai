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
 
/*
 *PREVIEW 戻り
 */

 if($_GET['r']=="preview")
 {
	$param[date] = str_replace("<br />","\n",$_POST['date']);
	$param[title] = str_replace("<br />","\n",$_POST['title']);
	$param[message] = str_replace("<br />","\n",$_POST['message']);
	$param[up] = str_replace("<br />","\n",$_POST['up']);

	$param[date] = escape($param[date]);
	$param[title] = escape($param[title]);
	$param[message] = escape($param[message]);
	$param[up] = escape($param[up]);
	
	sjis2euc($param[date]);
	sjis2euc($param[title]);
	sjis2euc($param[message]);
	sjis2euc($param[up]);
 }
 
/*
 *データ追加
 */
 if($_GET['r']=="comp")
 {
 	$write[date] = escape($_POST['date']);
 	$write[title] = escape($_POST['title']);
	$write[message] = escape($_POST['message']);
	$write[up] = escape($_POST['up']);
	
	$method->linkComp($write[date]);
	$method->linkComp($write[title]);
	$method->linkComp($write[message]);
	$method->linkComp($write[up]);
	
	//フォルダ ファイル指定
	$write[root] = DATA_ROOT."news.cgi";
	/* データ書き込み */
	$method->linkWrite($write);
	/*データ並び替え*/
	$method->DataSort($write);
 }
 
/*
 *データ削除
 */
 if($_GET['r'] == "d_comp")
 {
 	$no = escape($_GET['no']);
 	$read[root] = DATA_ROOT."news.cgi";
	//データ削除
 	$method->linkDelete($read,$no);
 }
 
/*
 *データ更新
 */
 if($_GET['r'] == "up_comp")
 {
 	$no = escape($_GET['no']);
 	$write[date] = escape($_POST['date']);
 	$write[title] = escape($_POST['title']);
	$write[message] = escape($_POST['message']);
	$write[up] = escape($_POST['up']);

	$write[date] = nl2br($write[date]);
	$write[title] = nl2br($write[title]);
	$write[message] = nl2br($write[message]);
	$write[up] = nl2br($write[up]);

	$write[message]=str_replace("\n","<br />",$write[message]);
	
	$method->linkComp($write[date]);
	$method->linkComp($write[title]);
	$method->linkComp($write[message]);
	$method->linkComp($write[up]);
	
	//フォルダ ファイル指定
	$write[root] = DATA_ROOT."news.cgi";
	/* データ書き込み */
	$method->linkUpdate($write,$no);
	/*データ並び替え*/
	$method->DataSort($write);
 }
 

$read[root] = DATA_ROOT."news.cgi";
$item = $method->linkRead($read);
　
?>