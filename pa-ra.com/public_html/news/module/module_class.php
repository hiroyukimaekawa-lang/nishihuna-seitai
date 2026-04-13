<?php

/************************************************************************************
サイトセッティング
************************************************************************************/

//データ倉庫 
define("DATA_ROOT","../news/data/");

/************************************************************************************
設定情報
************************************************************************************/
/*設定ファイル読み込み*/
$data = file(DATA_ROOT."config.cgi");
//読み込む時は改行記号を取り除く
for($i=0; $i<4; $i++){
	$data[$i] = mb_convert_encoding($data[$i],"SJIS","EUC-JP");
	$data[$i] = str_replace("\n", "", $data[$i]);
	$data[$i] = str_replace("\r\n","",$data[$i] );
}

//クラスオブジェクト
$object = new module();

/************************************************************************************
モジュール
************************************************************************************/

class module {
	
	/* リンクデータ読み込み */
	function linkRead($read)
	{
		$fh=@fopen($read[root],"r");
		$count = 0;
		
		while( $line = fgets($fh,1024) ){ 
			$item[] = $line;
		}
		fclose($fh);
		$itemCount = count($item);
		if($itemCount > 0 )
		{
		
			@krsort($item);
			foreach($item as $ret)
			{
				$array = @explode("\t",$ret);
				$array[0] = mb_convert_encoding($array[0],"SJIS","EUC-JP");
				$array[1] = mb_convert_encoding($array[1],"SJIS","EUC-JP");
				$array[2] = mb_convert_encoding($array[2],"SJIS","EUC-JP");
				$array[3] = mb_convert_encoding($array[3],"SJIS","EUC-JP");
				$this->date[]   = $array[0];
				$this->title[]  = $array[1];
				$this->message[]= $array[2];
				$this->up[]     = $array[3];
			
			}
			
			$this->total = $itemCount;
		}
		
	}

}
?>
