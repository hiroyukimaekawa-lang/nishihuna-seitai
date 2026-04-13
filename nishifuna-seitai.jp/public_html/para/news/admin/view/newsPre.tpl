<h2 id="t02">ニュース→確認</h2><br />
<?php
	$param[up]=$_REQUEST["up"];
	
	$param[date] = mb_convert_kana($param[date],"n","EUC-JP");
	$check=explode(".",$param[date]);
	if((ereg("[0-9]{2}",$check[1])==FALSE) or (ereg("[0-9]{2}",$check[2])==FALSE)){
		$cmonth=$check[1];
		$cday=$check[2];
		if(ereg("[0-9]{2}",$check[1])==FALSE){
			$cmonth="0".$check[1];
		}
		if(ereg("[0-9]{2}",$check[2])==FALSE){
			$cday="0".$check[2];
		}
		$param[date]=$check[0].".".$cmonth.".".$cday;
	}
	if((ereg("[^0-9^.]",$param[date]) == TRUE) or ($param[date]==NULL) or ($param[title]==NULL) or ($param[message]==NULL) or ($param[up]==NULL))
	{
		if(ereg("[^0-9^.]",$param[date]) == TRUE)
		{
			echo "日付に含まれてはいけない文字が含まれています。修正して下さい<br />";
		}
		if(($param[date]==NULL) or ($param[title]==NULL) or ($param[message]==NULL))
		{
			echo "空欄があります。修正して下さい<br />";
		}
		if($param[up]==NULL)
		{
			echo "公開設定がされていません。修正して下さい<br />";
		}
?>
		<table width="" border="1" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="2" align="center"><form id="preview" name="preview" method="post" action="./?m=news&r=preview">
			<input type="submit" name="Submit" value="修正" />
			<input type="hidden" name="date" value="<?=$param[date]?>" />
			<input type="hidden" name="title" value="<?=$param[title]?>" />
			<input type="hidden" name="message" value="<?=$param[message]?>" />
			<input type="hidden" name="up" value="<?=$param[up]?>" />
			 </form></td>
		</tr>
		</table>
<?php
	}else{
?>
<table width="" border="1" cellspacing="0" cellpadding="0">
<tr>
	<th colspan="2">ニュース追加</th>
</tr>
<tr>
	<td width="100">日付</td>
	<td width="494"><?=$param[date]?></td>
</tr>
<tr>
	<td>タイトル</td>
	<td><?=$param[title]?></td>
</tr>
<tr>
	<td>本文</td>
	<td><?=$param[message]?></td>
</tr>
<tr>
	<td>公開設定</td>
	<td><?=$param[up]?></td>
</tr>
<tr>
	<td colspan="2" class="center">
	<form id="preview" name="preview" method="post" action="./?m=news&r=preview">
	<input type="submit" name="Submit" value="修正" class="btn" />
	<input type="hidden" name="date" value="<?=$param[date]?>" />
	<input type="hidden" name="title" value="<?=$param[title]?>" />
	<input type="hidden" name="message" value="<?=$param[message]?>" />
	<input type="hidden" name="up" value="<?=$param[up]?>" />
	</form>
	<form id="preview" name="preview" method="post" action="./?m=news&r=comp">
	<input type="submit" name="Submit" value="追加" class="btn" />
	<input type="hidden" name="date" value="<?=$param[date]?>" />
	<input type="hidden" name="title" value="<?=$param[title]?>" />
	<input type="hidden" name="message" value="<?=$param[message]?>" />
	<input type="hidden" name="up" value="<?=$param[up]?>" />
	</form></td>
</tr>
</table>
<?php
	}
?>
<br />
<h5>［<a href="./?m=news">戻る</a>]</h5>
