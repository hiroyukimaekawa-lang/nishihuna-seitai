<h2 id="t02">ニュース更新</h2>
<?php
	if($param[date]==NULL){
		$param[date]=date("Y.m.d");
	}
?>
<form id="form1" name="form1" method="post" action="./?m=newsPre">
<table width="700" border="1" cellspacing="0" cellpadding="0">
<tr>
	<th colspan="2">ニュース更新</th>
</tr>
<tr>
	<td width="100">日付</td>
	<td width="594"><input name="date" type="text" id="date" size="40" value="<?=$param[date]?>" /></td>
</tr>
<tr>
	<td>タイトル</td>
	<td><input name="title" type="text" id="title" size="40" value="<?=$param[title]?>" /></td>
</tr>
<tr>
	<td>本文</td>
	<td><textarea name="message" cols="50" rows="10" id="message"><?=$param[message]?></textarea></td>
</tr>
<tr>
	<td>公開設定</td>
	<td>
	<?php
		if($param[up]=="公開しない"){
	?>
		<input type="radio" name="up" id="up" value="公開する" />公開する
		<input type="radio" name="up" id="up" value="公開しない" checked="checked" />公開しない</td>
	<?php
		}else{
	?>
		<input type="radio" name="up" id="up" value="公開する" checked="checked" />公開する
		<input type="radio" name="up" id="up" value="公開しない" />公開しない</td>
	<?php } ?>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" name="Submit" value="追加" class="btn" /></td>
</tr>
</table>

</form>
<br />
<h1>ニュース一覧</h1>
<?php


$itemCount = count($item);
if($itemCount > 0 )
{

krsort($item);
foreach($item as $ret)
{
	$array = explode("\t",$ret);
	sjis2euc($array[0]);
	sjis2euc($array[1]);
	sjis2euc($array[2]);
	sjis2euc($array[3]);
	$reDate[$i]   = $array[0];
	$reTitle[$i]  = $array[1];
	$reMessage[$i]= $array[2];
	$reUp[$i]     = $array[3];

?>
<table width="700" border="1" cellspacing="0" cellpadding="0">
<tr>
	<th width="100">NO.<?=$itemCount?></th>
	<th width="594"></th>
</tr>
<tr>
	<td>日付</td>
	<td><?=$reDate[$i]?></td>
</tr>
<tr>
	<td>タイトル</td>
	<td><?=$reTitle[$i]?></td>
</tr>
<tr>
	<td>本文</td>
	<td><?=$reMessage[$i]?></td>
</tr>
<tr>
	<td>公開設定</td>
	<td><?=$reUp[$i]?></td>
</tr>
<tr>
	<td colspan="2"  class="center">
	<form id="form2" name="form2" method="post" action="./?m=newsUpdate&no=<?=$itemCount?>">
	<label><input type="submit" name="Submit2" value="修正" /></label>
	</form>
	<form id="form2" name="form2" method="post" action="./?m=newsDelete&no=<?=$itemCount?>">
	<label><input type="submit" name="Submit3" value="削除" /></label>
	</form>
	</td>
</tr>
</table><br />
<?php
$itemCount--;
}}
?>
