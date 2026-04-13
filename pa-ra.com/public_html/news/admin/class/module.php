<?php
/*設定ファイル書き込み*/
if($_POST['Submit']=="SET")
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

}

/*設定ファイル読み込み*/
$data = file(DATA_ROOT."config.cgi");
//読み込む時は改行記号を取り除く
for($i=0; $i<4; $i++){
    $data[$i] = str_replace("\n", "", $data[$i]);
	$data[$i] = str_replace("\r\n","",$data[$i] );
}
 

/************************************************************************************
サイトセッティング情報
************************************************************************************/

//ログインパス
define('PASS',$data[0]);
define('SSL_PASS',$data[1]);

//サイト名
define('SITE_TITLE',$data[2]);

//サイト説明
define('SITE_INTRO',$data[3]);
/************************************************************************************
モジュール
************************************************************************************/

class module {

	/*リンク書き込み*/
	function linkWrite($write)
	{
		$line = $write[date]."\t".$write[title]."\t".$write[message]."\t".$write[up]."\n";
		$fh=fopen($write[root],"a+");
		flock($fh, LOCK_EX);
		fwrite($fh,$line);
		flock($fh, LOCK_UN);
		fclose($fh);
		$SID = session_id();
		header( "Location: ./?m=news&PHPSESSID=".$SID."" );
	}
	
	/* リンクデータ読み込み */
	function linkRead($read)
	{
		$fh=fopen($read[root],"r");
		
		while( $line = fgets($fh,1024) ){ 
			$ret[] = $line;
		}
		fclose($fh);
		return $ret;
	}
	
	/* リンクデータ読み込み個別 */
	function linkReadNum($read,$no)
	{
		$fh=fopen($read[root],"r");
		$i = 1;
		while( $line = fgets($fh,1024) ){
			if($i == $no)
			{ 
				$ret = $line;
				$ret =strip_tags($ret,'<a><img><br />');
				$ret = htmlspecialchars($ret,ENT_NOQUOTES);
			}
			$i++;
		}
		fclose($fh);
		return $ret;
	}
	
	/* 書き込みデータ処理 */
	function linkPreview(&$str)
	{
		$str =strip_tags($str,'<a><img><br />');
		$str = nl2br($str);
		$str = str_replace("\t","",$str);
		$str = str_replace("\n","",$str);
		$str = str_replace("\r\n","",$str);
		$str =htmlspecialchars($str,ENT_QUOTES);
		$str = str_replace("\"","&quot;",$str);
		$str = str_replace("&lt;br /&gt;","<br />",$str);
		return $str;
	}
	
	function linkComp(&$str)
	{
		$str = str_replace("&quot;","\"",$str);
		$str = str_replace("\t","",$str);
		$str = str_replace("\n","",$str);
		$str = str_replace("\r\n","",$str);
		$str = str_replace("&lt;","<",$str);
		$str = str_replace("&gt;",">",$str);
		return $str;
	}
	
	/* データ削除　No.指定*/
	function linkDelete($read,$no)
	{
		$fh=fopen($read[root],"r");
		$i = 1;
		while( $line = fgets($fh,1024) ){
			if($i <> $no)
			{ 
				$ret[] = $line;
			}
			$i++;
		}
		fclose($fh);
		
		//書き込み
		if(count($ret)>0)
		{
		
			$fh=fopen($read[root],"w+");
			flock($fh, LOCK_EX);
			foreach($ret as $line)
			{
				fwrite($fh,$line);
			}
			flock($fh, LOCK_UN);
			fclose($fh);
		}else{
		
			$fh=fopen($read[root],"w+");
			flock($fh, LOCK_EX);

			flock($fh, LOCK_UN);
			fclose($fh);		
		}
		
		$SID = session_id();
		header( "Location: ./?m=news&PHPSESSID=".$SID."" );
	}
	
	/* データ更新　No.指定*/
	/*リンク書き込み*/
	function linkUpdate($write,$no)
	{
		$fh=fopen($write[root],"r");
		$i = 1;
		while( $line = fgets($fh,1024) ){
			if($i <> $no)
			{ 
				$ret[] = $line;
			}else{
				$ret[] = $write[date]."\t".$write[title]."\t".$write[message]."\t".$write[up]."\n";
			}
			$i++;
		}
		fclose($fh);
		
		//書き込み
		if(count($ret)>0)
		{
			$fh=fopen($write[root],"w+");
			flock($fh, LOCK_EX);
			foreach($ret as $line)
			{
				fwrite($fh,$line);
			}
			flock($fh, LOCK_UN);
			fclose($fh);
		}
		
		$SID = session_id();
		header( "Location: ./?m=news&PHPSESSID=".$SID."" );
	}

	/*データ並び替え*/
	function DataSort($write)
	{
		$dcount=0;
		$fh=fopen($write[root],'r');
		flock($fh, LOCK_EX);
		while ($line = fgets($fh,1024)){
			$rett[]=$line;
		}
		flock($fh, LOCK_UN);
		fclose($fh);
		foreach($rett as $line){
			$darray = explode("\t",$line);
			$adate[$dcount]=$darray[0];
			$sdate[$dcount]=$darray[0];
			$stitle[$dcount]=$darray[1];
			$smessage[$dcount]=$darray[2];
			$up[$dcount]=$darray[3];
			$dcount++;
		}
		sort($adate);
		print_r($adate);
		for($j=0;$j<$dcount;$j++){
			for($k=0;$k<$dcount;$k++){
				if($adate[$j]==$sdate[$k]){
					$ret[] = $sdate[$k]."\t".$stitle[$k]."\t".$smessage[$k]."\t".$up[$k];
					unset($sdate[$k]);
					unset($stitle[$k]);
					unset($messagee[$k]);
					unset($up[$k]);
					break;
				}
			}
		}
		$fh=fopen($write[root],"w+");
		flock($fh, LOCK_EX);
		foreach($ret as $line)
		{
			fwrite($fh,$line);
		}
		flock($fh, LOCK_UN);
		fclose($fh);

		$SID = session_id();
		header( "Location: ./?m=news&PHPSESSID=".$SID."" );
	}
}
?>