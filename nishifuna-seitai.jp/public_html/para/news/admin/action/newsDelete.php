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

?>