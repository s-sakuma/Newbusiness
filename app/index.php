<?php
require('util.php');

// アプリケーション設定
define('CONSUMER_KEY', 'hxlPpJHDZQU28NvsFVu0WMWcf');
define('CONSUMER_SECRET', 'ho1vt4Z9YTY8qUxR7Nt7hCJNQucIkYH03c8NXmwPq0MTpm1fTB');
define('CALLBACK_URL', 'http://192.168.33.19/app/callback.php');

// URL
define('RTOKEN_URL', 'https://api.twitter.com/oauth/request_token');
define('AUTH_URL', 'https://api.twitter.com/oauth/authenticate');


//--------------------------------------
// リクエストトークンの取得
//--------------------------------------
$params = array(
	"oauth_callback" => CALLBACK_URL,
	"oauth_consumer_key" => CONSUMER_KEY,
	"oauth_nonce" => md5(microtime() . mt_rand()),
	"oauth_timestamp" => time(),
	"oauth_version" => "1.0",
	"oauth_signature_method" => "HMAC-SHA1",
);

// 署名作成
$params['oauth_signature'] = build_signature('GET', RTOKEN_URL, $params, CONSUMER_SECRET);

// GET送信
$res = file_get_contents(RTOKEN_URL . '?' . http_build_query($params));

// レスポンス取得
parse_str($res, $token);
if(!isset($token['oauth_token'])){
	echo "エラー発生";
	exit;
}
$request_token = $token['oauth_token'];


//--------------------------------------
// 認証ページにリダイレクト
//--------------------------------------
$params = array(
	'oauth_token' => $request_token,
);

// リダイレクト
header("Location: " . AUTH_URL . '?' . http_build_query($params));
