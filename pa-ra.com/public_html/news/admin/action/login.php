<?php
session_start();

/*ログイン*/

$pass = escape($_POST['pass']);
$pass = crypt($pass,'QQQ');

if($_SESSION['pass']!="")
{
	if($_SESSION['pass'] != SSL_PASS)
	{
		 /*ログイン失敗*/
		 header( "Location: ./?m=index&t=out" );
	}

}else{

if($pass == SSL_PASS)
{
	$_SESSION['pass'] = $pass;
}
else
{
	 /*ログイン失敗*/
	 header( "Location: ./?m=index" );
}

}



?>