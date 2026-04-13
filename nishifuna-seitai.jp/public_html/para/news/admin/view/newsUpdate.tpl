<h2 id="t02">ニュース→更新</h2><br />
<form id="preview" name="preview" method="post" action="./?m=newsUpPre&no=<?=$_GET['no']?>">
<table width="600" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="2">ニュース更新</th>
    </tr>
  <tr>
    <td>日付</td>
    <td><input name="date" type="text" id="date" size="40" value="<?=$reDate?>" />    </td>
  </tr>
  <tr>
    <td>タイトル</td>
    <td><input name="title" type="text" id="title" size="40" value="<?=$reTitle?>" />    </td>
  </tr>
  <tr>
    <td>本文</td>
    <td><textarea name="message" cols="60" rows="10" id="message"><?=$reMessage?></textarea></td>
  </tr>
    <tr>
      <td>公開設定</td>
      <td><?php
		if(ereg("公開する",$reUp)==TRUE){
	?>
			<input type="radio" name="up" id="up" value="公開する" checked="checked" />公開する
			<input type="radio" name="up" id="up" value="公開しない" />公開しない</td>
	<?php
		}else{
	?>
			<input type="radio" name="up" id="up" value="公開する" />公開する
			<input type="radio" name="up" id="up" value="公開しない" checked="checked" />公開しない</td>
	<?php
		}
	?>
    </tr>
  <tr>
    <td colspan="2" align="center">
<input type="submit" name="Submit" value="確認" class="btn" />
</td>
  </tr>
</table>
</form>
<br />
<h5>［<a href="./?m=news">戻る</a>]</h5>
