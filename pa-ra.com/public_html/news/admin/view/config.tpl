<h2 id="t01">設定情報</h2>
<form name="form1" method="post" action="./?m=config">
<table width="600" border="1" cellspacing="0" cellpadding="0">
<tr>
	<th colspan="2">セッティング</th>
</tr>
<tr>
	<td>ログインパスワード</td>
	<td><label><input name="0" type="text" id="0" value="<?=PASS?>"></label></td>
</tr>
<tr>
	<td width="150">サイト名</td>
	<td width="444"><input name="2" type="text" id="2" value="<?=SITE_TITLE?>"></td>
</tr>
<tr>
	<td width="150">説明文</td>
	<td><input name="3" type="text" id="3" value="<?=SITE_INTRO?>"></td>
</tr>
<tr>
	<td colspan="3" align="center"><label><input type="submit" name="Submit" value="更新"></label></td>
</tr>
</table>
</form>
