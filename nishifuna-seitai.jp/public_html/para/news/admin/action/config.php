<?php
session_start();

/*ログインチェック*/

if($_SESSION['pass'] != SSL_PASS)
{
	 /*ログイン失敗*/
	 header( "Location: ./?m=index&t=out" );
}

/*設定ファイル書き込み*/
if($_POST['Submit']=="更新")
{

	function setting (){
	for ($i=0; $i<4; $i++){
		$array[$i] = trim($_POST["$i"]);
		$array[$i] = str_replace("\r\n","",$array[$i]);
		$array[$i] = str_replace("\n","",$array[$i]);
		$array[$i] = str_replace("\t","",$array[$i]);
	}
	
	$array[1] = crypt($array[0],'QQQ');
	$file = fopen(DATA_ROOT."config.cgi","w");
	flock($file,LOCK_EX);
	for ($i=0; $i<4; $i++){
	
		fputs($file,$array[$i]."\n") or die("ファイル書き込みエラー");
	}
	flock($file,LOCK_UN);
	fclose($file);
	return true;
	}
	
	setting();
	
	
	$SID = session_id(); 
	header( "Location: ./?m=config&PHPSESSID=".$SID."" );
}



?>