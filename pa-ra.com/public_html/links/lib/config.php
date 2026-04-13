<?php
##======================================================##
##  365 Links Config                                    ##
##  Copyright (C) php365.com All rights reserved.       ##
##  http://php365.com/                                  ##
##======================================================##
// ↓ランキングリセット方法
// links.php?mode=rank_reset　にアクセスして下さい。
#============#
#  基本設定  #
#============#
// ------------- 設定ここから -------------
// ↓管理モード（0:ユーザ・管理者が登録可、1:管理者のみ登録可）
define("ADMIN_MODE", 1);

// ↓管理用パスワード（必ず修正・半角英数8文字以内）
define("ADMIN_PASS", "2784");

// ↓ホームに指定するURL（必ず修正）
$homeurl = 'http://chambeer.net/';

// ↓タイトル
$title = '欧州麦酒屋リンク集';

// ↓新規登録データのログファイル名
define("LOGFILE", "./links.cgi");

// ↓バックアップ用のデフォルトファイル名（不要な場合""と指定して下さい。）
define("BACKFILE", "./back/backup.cgi");

// ↓バックアップは何日分必要ですか？（必ず1以上の数字で指定して下さい。）
// （例：ファイル名は、./back/backupx.cgiで、xのところに数字が入ります。）
// （バックアップファイルは、タイムスタンプで新旧を判断して下さい。）
define("BACKCNT", 3);

// ↓紹介コメントの制限文字数（全角文字）
$com_max = 80;

// ↓１ページに表示するデータ件数
define("PAGEVIEW", 30);

// ↓バナー登録を出来るようにしますか？（0:No 1:Yes）
define("BANNER_FLG", 1);

// ↓バナーの横にテキストリンクを表示しますか？（0:No 1:Yes）
// バナー登録出来るように設定した時のみ有効
define("TLINK_FLG", 1);

// ↓リンクのtarget設定（例："_blank","_top"）
$target = "new";

// ↓HTMLファイル（静的ページ）作成に関する設定（ランキングページは対象外）//
// ↓HTMLファイル（静的ページ）を作りますか？（0:No 1:Yes）
define("HTML_FLG", 1);
// ↓HTMLファイル（トップページ）のファイル名
define("HTML_TOPFILE", "./links.html");
// ↓HTMLファイル（トップページ以外）を格納するディレクトリ
define("HTML_DIR", "./html/");
// ↓HTMLファイル・カテゴリファイルの更新について
// 各カテゴリのデータ件数の表示方法（0:常に表示 1:トップページのみ表示）（1:推奨）
// （1:に設定すると、カテゴリファイルの更新が最小限で済みます。）
// （0:に設定すると、データの追加・削除があった場合、全カテゴリファイルの更新が必要となります。
define("CT_COUNT_FLG", 1);

// ↓ランキング機能の使いますか？（0:No 1:Yes）
define("RANK_FLG", 0);

// ↓検索機能の使いますか？（0:No 1:Yes）
define("SEARCH_FLG", 1);

// ↓カテゴリ設定（$category[0]から連番で、好きなだけ設定できます。）
$category = array();
$category[0] = 'ホームページ作成';
$category[1] = '地域情報';
$category[2] = 'オフィス関連';
$category[3] = 'お役立ちサイト';
$category[4] = 'ライフスタイル';
$category[5] = '通販サイト';
$category[6] = 'サーチエンジン';
$category[7] = '健康・美容';
$category[8] = 'その他';


// ↓スパム投稿対策設定 ここから //
$SPAM = array();
// ↓Cookie必須（0=No、1=Yes）
$SPAM['cookie'] = 1;
// ↓JavaScript必須（0=No、1=Yes）
$SPAM['js'] = 1;
// ↓ワンタイムチケットを使用する（0=No、1=Yes）
$SPAM['ticket'] = 1;
// ↓投稿制限時間（単位：秒）
// フォーム（確認画面）を表示してから、送信ボタンを押すまで #Cookie、ワンタイムチケットを使う場合のみ有効
$SPAM['limit'] = 3;
// ↓投稿有効期限（単位：秒）
// フォーム（確認画面）を表示してから、送信ボタンを押すまで #Cookie、ワンタイムチケットを使う場合のみ有効
$SPAM['expire'] = 5*60;
// ↓正引き出来ないホストからのアクセス（0=許可しない、1=許可する）
$SPAM['hostbyname'] = 0;
// ↓逆引き出来ないホストからのアクセス（0=許可しない、1=許可する）
$SPAM['hostbyaddr'] = 0;
// ↓Referer（リファラー）チェック（0=No、1=Yes）#Cookieを使う場合のみ有効
$SPAM['referer'] = 1;
// ↓接続元IPが変わったら（0=許可しない、1=許可する）
// フォームを表示してから、送信ボタンを押すまで #Cookieを使う場合のみ有効
$SPAM['change_ip'] = 0;
// ↓ユーザーエージェントが変わったら（0=許可しない、1=許可する）
// フォームを表示してから、送信ボタンを押すまで #Cookieを使う場合のみ有効
$SPAM['change_ua'] = 0;
// ↓Secret Key（接続元IP・ユーザーエージェント照合用、必ず修正、適当に変更して下さい。）
// $SPAM['change_ip']、$SPAM['change_ua']のどちらかを1に設定した場合は必ず修正
$SPAM['secret_key'] = "Vn0ajd6aq2XALYmJ6aYlDSc47dU7ARuA";
// ↓半角文字のみの投稿（0=許可しない、1=許可する）
// 英文字のみの投稿を許可したくない時には、"0=許可しない"を選択して下さい。
$SPAM['single'] = 0;
// ↓URLを含む投稿（0=許可しない、1=許可する）
$SPAM['url'] = 0;
// ↓パスワードを設定していない投稿（0=修正・削除を許可しない、1=修正・削除を許可する）
// 管理用パスワードによる修正・削除は、どちらに設定しても常に出来ます。
$SPAM['nopass'] = 1;
// ↑スパム投稿対策設定 ここまで //


// ↓CAPTCHA（画像認証）用設定 ここから //
$REG = array();
// ↓画像認証（0=No、1=認証使用）＊認証キーは、GDライブラリが使える環境のみ
$REG['check'] = 0;

// ↓暗号方法（0=XOR、1=Mcrypt(推奨)、2=AddSub）
// 画像認証で1（認証キー使用）を選択した場合のみ有効
// Mcryptは使える環境のみ、AddSubはBCMath関数が使える環境のみ
$REG['crypt'] = 0;

// ↓暗号用パスワード（必ず修正、半角英数8文字以内）
// 画像認証で1（認証キー使用）を選択した場合のみ有効
$REG['pass'] = "password";

// ↓暗号用シード値（適当に書いてある文字の順番を入れ替えて下さい）
// 暗号方法で0（XOR）を選択した場合のみ有効
$REG['seed'] = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

// ↓認証キー用画像背景サイズ（幅）
$REG['size_x'] = "65";
// ↓認証キー用画像背景サイズ（高さ）
$REG['size_y'] = "30";

// ↓認証キー用背景色（設定しない場合は""と指定して下さい。ページ背景色と同じになります。）
// 画像認証で1（認証キー使用）を選択した場合のみ有効
//（例：青色に設定する場合　$REG['regkey_bgc'] = "#0000FF";　又は、$REG['regkey_bgc'] = "0.0.255";
$REG['regkey_bgc'] = "";

// ↓認証キー用画像文字色（設定しない場合は""と指定して下さい。デフォルトで"#D2691Ed2691e"（chocolate）になります。）
// 画像認証で1（認証キー使用）を選択した場合のみ有効
//（例：青色に設定する場合　$REG['regkey_fc'] = "#0000FF";　又は、$REG['regkey_fc'] = "0.0.255";
$REG['regkey_fc'] = "";

// ↓認証キー用背景の線の色
//（例：青色に設定する場合　$REG['regkey_blc'] = "#0000FF";　又は、$REG['regkey_blc'] = "0.0.255";
$REG['regkey_blc'] = "#E0E0E0";

// ↓認証キー用背景の線の数（単位：本）
$REG['regkey_bln'] = 4;

// ↓認証キー用文字の回転角度（例：+-15度の場合　$REG['angle_rotation'] = "15";）
$REG['angle_rotation'] = "15";

// ↓認証キー有効期限
// 投稿フォームを表示してから、送信ボタンを押すまでの時間（単位：分）
$REG['expire'] = 10;

// ↑CAPTCHA（画像認証）用設定 ここまで //


// ↓NGワード（名前、タイトル、コメントに使われたくない言葉を指定。カンマ「,」区切、複数指定可）
// 例 define("NG_WORD", "バカ,バーカ,ばーか,ばか,死ね,氏ね,アダルト,出会い系");
define("NG_WORD", "");

// ↓NGURL（拒否したいサイトURLをIPアドレス又はホスト名で指定。カンマ「,」区切、複数指定可）
// 例 define("NG_URL", "127.0.0.1,hoge.com,127.0.0.*,*.hoge.com");
define("NG_URL", "");

// ↓アクセス拒否（荒らし対策、IPアドレス又はホスト名を指定。カンマ「,」区切、複数指定可）
// 例 define("DENY_HOST", "127.0.0.1,hoge.com,127.0.0.*,*.hoge.com");
define("DENY_HOST", "");

// ↓アクセス許可（ホワイトリスト用、IPアドレス又はホスト名を指定。カンマ「,」区切、複数指定可）
// 例 define("ALLOW_HOST", "127.0.0.1,hoge.com,127.0.0.*,*.hoge.com");
define("ALLOW_HOST", "");

$CNF = array(
	// ↓壁紙（http://から記述）
	background => '',
	// ↓背景色
	bgcolor => '#FFFFFF',
	// ↓フォントの色（ページ全体）
	font_color => '#000000',
	// ↓フォントサイズ（ページ全体、単位：pt、%など）
	// 例 font_size => '10pt',
	font_size => '90%',
	// ↓フォント設定（ページ全体）
	font_family => '',
	// ↓フォントサイズ（サイトタイトル、単位：pt、%など）
	// 例 site_font_size => '12pt',
	site_font_size => '110%',
	// ↓サイトタイトルを太字（強調）にしますか？（0:No 1:Yes）
	site_bold_flag => 1,
	// ↓スクロールバーのカラー設定（設定しない場合は''と指定して下さい。）
	scrollbar => '',
	// ↓ナビゲーションバーの罫線
	navi_border => '#C0C0C0',
	// ↓ナビゲーションバーの色
	navi_color => '#EFEFEF',
	// ↓カテゴリ左の罫線
	ct_left => '#C0C0C0',
	// ↓紹介文の背景色
	comment_bgcolor => '#FFFFF0',
	// ↓ヒット数からNoまでの背景色
	comment2_bgcolor => '#008000',
	// ↓各リンクの色
	link => '#0000CC',	// 未訪問
 	visited => '#000080',	// 既訪問
 	active => '#FF0000',	// クリックしたとき
 	hover => '#FFFFFF',	// リンクにマウスを乗せたとき
  	// ↓各リンクのテキストデコレーション
	link_deco => 'underline',	// 未訪問
	visited_deco => 'underline',	// 既訪問
	active_deco => 'underline',	// クリックしたとき
	hover_deco => 'none',		// リンクにマウスを乗せたとき
	// ↓各リンクの背景色
	hover_bgcolor => '#00008B',	// リンクにマウスを乗せたとき
);

// ↓noscriptタグ用メッセージ：タイトルの上に表示
// ↓スパム投稿対策設定 -> JavaScript必須（$SPAM['js'] = 1 の場合のみ有効、改行してEOM〜EOM;までの間に指定して下さい。任意）
$msg_noscript = <<<EOM
\n<noscript><center>
<div align="left" style="width=450px;padding:5px;white-space: nowrap;font-size: 90%;">
現在<b>JavaScriptが無効</b>になっています。<br>全ての機能を利用する為には、<b>JavaScriptの設定を有効</b>にしてからご利用下さい。</div>
</center><br></noscript>
EOM;

// ↓タイトルの下にメッセージを表示出来ます。（EOM〜EOM;までの間に指定して下さい。任意）
$user_comment = <<<EOM
EOM;
// ------------- 設定ここまで -------------
// ↓ライブラリパス
define("PATH_LIB", "lib/");
// ↓カテゴリデータカウント用
$ct_cnt = array();
$ct_cnt = array_fill(0, count($category), 0);
// ↓バックアップをした日を保存するファイル名
define("BAKDAYFILE", "./bakday.dat");
// ↓著作権表示(改変/削除不可)
$copyright = "- <a href=\"http://php365.com/\" target=\"_top\">365 Links Ver3.11</a> -";
?>