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
$reDate = escape2($_POST['date']);
$reTitle = escape2($_POST['title']);
$reMessage = escape2($_POST['message']);
$reUp = escape2($_POST['up']);

$method->linkPreview($reDate);
$method->linkPreview($reTitle);
$method->linkPreview($reMessage);
$method->linkPreview($reUp);

sjis2euc($reDate);
sjis2euc($reTitle);
sjis2euc($reMessage);
sjis2euc($reUp);

?>