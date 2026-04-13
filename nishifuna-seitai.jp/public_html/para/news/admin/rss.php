<?php

// データファイル設定（パス含む）
$update_file = '../data/news.cgi';
// 出力ファイル名（スクリプトからの相対パス。要書き込み可能属性）
$rss = '../rss/index.xml';

//設定ファイル（URLを記述）
include 'config.php';

// サイト情報
$site_title = SITE_TITLE;
$site_link = $url."news/";
$site_description = SITE_INTRO;

// データファイル読込
$data = fopen($update_file, 'r');
$item_num = 0;
while (!feof($data)) {
	$line = fgets($data);
	$line = strip_tags($line);
	$line = mb_convert_encoding($line,"EUC-JP","ASCII,JIS,UTF-8,EUC-JP,SJIS");
	$line = str_replace(array("\r","\n","\r\n"),"",$line);
	$array = explode("\t",$line);
	for($i=0;$i<4;$i++){
		if($i==0){
			$key = "date:";
			$value = $array[0];
			$entries[$item_num]["$key"] = $value;
		}
		if($i==1){
			$key = "title:";
			$value = $array[1];
			$entries[$item_num]["$key"] = $value;
		}
		if($i==2){
			$key = "summary:";
			$value = $array[2];
			$entries[$item_num]["$key"] = $value;
		}
		if($i==3){
			$key = "Up:";
			$value = $array[3];
			$entries[$item_num]["$key"] = $value;
		}
	}
	$item_num++;
}
$item_num = $item_num-1;
$count_num = $item_num-1;
$update = trim($entries[$count_num]['date:']);
$t = explode(".",$update[0]);
$timestamp = mktime(0,0,0,$t[1],$t[2],$t[0],0);
$update_long = date('d M Y H:i:s', $timestamp) . ' +0900';

//======================================================================
//section : RSS XML
//======================================================================

$file2 = fopen($rss,'w');

$string = <<<_RSS_
<?xml version="1.0" encoding="EUC-JP"?>
<rss version="2.0">

<channel>
<title>$site_title</title>
<link>$site_link</link>
<description>$site_description</description>
<pubDate>$update_long</pubDate>
<language>ja</language>


_RSS_;

fwrite($file2, $string);

$string = '';
for ($count = $count_num; $count >=0 ; $count--) {
	$up = trim($entries[$count]['Up:']);
	if($up=="公開する"){
		$date = trim($entries[$count]['date:']);
		$date = str_replace(array(':','T','+'), '-', $date);
		$t = explode('.', $date);
		$timestamp = mktime(0,0,0,$t[1],$t[2],$t[0],0);
		$time = date('d M Y H:i:s', $timestamp) . ' +0900';
		$string .= "<item>\n";
		$title = trim($entries[$count]['title:']);
		$string .= "<title>$title</title>\n";
		$link = $site_link."#".$count;
		$string .= "<link>$link</link>\n";
		$string .= "<guid>$link</guid>\n";
		$string .= "<pubDate>$time</pubDate>\n";
		$summary = trim($entries[$count]['summary:']);
		$string .= "<description>$summary</description>\n";
		$string .= "</item>\n\n";
	}
}

$string .= "</channel>\n</rss>\n";
fwrite($file2,$string);
fclose($file2);

?>

