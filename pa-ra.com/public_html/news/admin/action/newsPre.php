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
 
$param[date] = escape2($_POST['date']);
$param[title] = escape2($_POST['title']);
$param[message] = escape2($_POST['message']);
$param[up] = escape2($_POST['up']);

$method->linkPreview($param[date]);
$method->linkPreview($param[title]);
$method->linkPreview($param[message]);
$method->linkPreview($param[up]);

sjis2euc($param[date]);
sjis2euc($param[title]);
sjis2euc($param[message]);
sjis2euc($param[up]);

?>