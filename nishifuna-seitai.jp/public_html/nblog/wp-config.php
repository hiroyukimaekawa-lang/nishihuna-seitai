<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、MySQL、テーブル接頭辞、秘密鍵、言語、ABSPATH の設定を含みます。
 * より詳しい情報は {@link http://wpdocs.sourceforge.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86 
 * wp-config.php の編集} を参照してください。MySQL の設定情報はホスティング先より入手できます。
 *
 * このファイルはインストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さず、このファイルを "wp-config.php" という名前でコピーして直接編集し値を
 * 入力してもかまいません。
 *
 * @package WordPress
 */

// 注意: 
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.sourceforge.jp/Codex:%E8%AB%87%E8%A9%B1%E5%AE%A4 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'nseitai_newwp');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'nseitai_newwp');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', '83ure72y');

/** MySQL のホスト名 */
define('DB_HOST', 'mysql30a.xserver.jp');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '7yHZo>DmGk``V0S3m2%%lX)+T,V5UoKK52gQXH{ASK>MatxOmtI>OdXtxgMufE!*');
define('SECURE_AUTH_KEY',  '$7^8a:o2|wC|F,ZS<mCz?XB-rwF&U|#yzy(1@hSX4bb0QW9%s}do~ypkBty1fV?_');
define('LOGGED_IN_KEY',    '&.-R}Y-jF*93BOVpaQIJT]_7F`yJzR $QKA0+5(|pW)hnTN|B]P#(*+@JToKCR%h');
define('NONCE_KEY',        'A9=~E=l*YN0-SMSI8 ^l[4-[&</*GG(,oDm>(6L&V,]UvPn6,f{-1?}a,}LW#QJ%');
define('AUTH_SALT',        '~kpjmw!he+C+2T,<1>wc:Df(E-eeWq6KD1c{^UM>7.hg$bPq&=ll]Cd5Fxh##0c2');
define('SECURE_AUTH_SALT', '9d5Wi[##&dgM{<p~~hP+:EsTs;)V^nr?=)yM-#7#EZtTc;MSI*jO$n)jU$vMLZzU');
define('LOGGED_IN_SALT',   'Kd/.:4?e^[cOTT-H<U&I6Wc]Ub8,p(aj7$_sN)}1BeU]Zr-zbf#^LLa>f*-8mM7G');
define('NONCE_SALT',       '?=;t9+pa}TZC6SRExdNQsTW.H0+gGrZ5x.Kr4,F>o:L^{W`,Dj8%4QzWS8O-l+sw');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 */
define('WP_DEBUG', false);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
