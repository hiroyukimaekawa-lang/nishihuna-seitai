<h2 id="t02">ニュース→削除</h2>
<br />
<table width="600" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="2">ニュース削除</th>
  </tr>
  <tr>
    <td>日付</td>
    <td><?=$reDate?></td>
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
    <td colspan="2" align="center"><form id="preview" name="preview" method="post" action="./?m=news&r=d_comp&no=<?=$_GET['no']?>">
<input type="submit" name="Submit" value="削除" class="btn" />
    </form></td>
  </tr>
</table>
<br />
<h5>［<a href="./?m=news">戻る</a>］</h5>
