<h2 id="t02">ニュース→更新→確認</h2><br />
<?php
	$reDate = mb_convert_kana($reDate,"n","EUC-JP");
	$check=explode(".",$reDate);
	if((ereg("[0-9]{2}",$check[1])==FALSE) or (ereg("[0-9]{2}",$check[2])==FALSE)){
		$cmonth=$check[1];
		$cday=$check[2];
		if(ereg("[0-9]{2}",$check[1])==FALSE){
			$cmonth="0".$check[1];
		}
		if(ereg("[0-9]{2}",$check[2])==FALSE){
			$cday="0".$check[2];
		}
		$reDate=$check[0].".".$cmonth.".".$cday;
	}
	if((ereg("[^0-9^.]",$reDate) == TRUE) or ($reDate==NULL) or ($reTitle==NULL) or ($reMessage==NULL))
	{
		if(ereg("[^0-9^.]",$reDate) == TRUE){
			echo "日付に含まれてはいけない文字が含まれています。修正して下さい<br />";
		}
		if(($reDate==NULL) or ($reTitle==NULL) or ($reMessage==NULL)){
			echo "空欄があります。修正して下さい<br />";
		}
?>
		<table width="" border="1" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="2" align="center"><form id="preview" name="preview" method="post" action="./?m=newsUpdate&r=preview&no=<?=$_GET['no']?>">
			<input type="submit" name="Submit" value="修正" />
			<input type="hidden" name="date" value="<?=$reDate?>" />
			<input type="hidden" name="title" value="<?=$reTitle?>" />
			<input type="hidden" name="message" value="<?=$reMessage?>" />
			<input type="hidden" name="up" value="<?=$reUp?>" />
			</form></td>
		</tr>
		</table>
<?php
	}else{
?>
<form id="preview" name="preview" method="post" action="./?m=news&r=up_comp&no=<?=$_GET['no']?>">
<table width="" border="1" cellspacing="0" cellpadding="0">
<tr>
	<th colspan="2">ニュース更新確認</th>
</tr>
<tr>
	<td width="100">日付</td>
	<td width="494"><?=$reDate?></td>
</tr>
<tr>
	<td>タイトル</td>
	<td><?=$reTitle?></td>
</tr>
<tr>
	<td>本文</td>
	<td><?=$reMessage?></td>
</tr>
<tr>
	<td>公開設定</td>
	<td><?=$reUp?></td>
</tr>
<tr>
	<td colspan="2" class="center">
	<input type="submit" name="Submit" value="更新" class="btn" />
	<input type="hidden" name="date" value="<?=$reDate?>" />
	<input type="hidden" name="title" value="<?=$reTitle?>" />
	<input type="hidden" name="message" value="<?=$reMessage?>" />
	<input type="hidden" name="up" value="<?=$reUp?>" />
	</form>
	<form id="preview" name="preview" method="post" action="./?m=newsUpdate&r=preview&no=<?=$_GET['no']?>">
	<input type="submit" name="Submit" value="修正" class="btn" />
	<input type="hidden" name="date" value="<?=$reDate?>" />
	<input type="hidden" name="title" value="<?=$reTitle?>" />
	<input type="hidden" name="message" value="<?=$reMessage?>" />
	<input type="hidden" name="up" value="<?=$reUp?>" />
	</form></td>
</tr>
</table>
<?php
	}
?>
<br />
<h5>［<a href="./?m=news">戻る</a>]</h5>
