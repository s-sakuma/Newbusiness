<?php
require('util.php');
// アプリケーション設定
define('CONSUMER_KEY', 'hxlPpJHDZQU28NvsFVu0WMWcf');
define('CONSUMER_SECRET', 'ho1vt4Z9YTY8qUxR7Nt7hCJNQucIkYH03c8NXmwPq0MTpm1fTB');

// URL
define('TOKEN_URL', 'https://api.twitter.com/oauth/access_token');
define('INFO_URL', 'https://api.twitter.com/1.1/account/settings.json');


//--------------------------------------
// アクセストークンの取得
//--------------------------------------
$params = array(
	"oauth_consumer_key" => CONSUMER_KEY,
	"oauth_nonce" => md5(microtime() . mt_rand()),
	"oauth_timestamp" => time(),
	"oauth_verifier" => $_GET['oauth_verifier'],
	"oauth_version" => "1.0",
	"oauth_signature_method" => "HMAC-SHA1",
	"oauth_token" => $_GET['oauth_token'],
);

// 署名作成
$params['oauth_signature'] = build_signature('POST', TOKEN_URL, $params, CONSUMER_SECRET);

// POST送信
$options = array('http' => array(
	'method' => 'POST',
	'content' => http_build_query($params)
));
$res = file_get_contents(TOKEN_URL, false, stream_context_create($options));

// レスポンス取得
parse_str($res, $token);
$access_token = $token['oauth_token'];
$access_token_secret = $token['oauth_token_secret'];


//--------------------------------------
// ユーザーの設定情報を取得してみる
//--------------------------------------
$params = array(
	"oauth_consumer_key" => CONSUMER_KEY,
	"oauth_nonce" => md5(microtime() . mt_rand()),
	"oauth_timestamp" => time(),
	"oauth_verifier" => $_GET['oauth_verifier'],
	"oauth_version" => "1.0",
	"oauth_signature_method" => "HMAC-SHA1",
	"oauth_token" => $access_token,
);

// GET送信
$params['oauth_signature'] = build_signature('GET', INFO_URL, $params, CONSUMER_SECRET, $access_token_secret);
$res = file_get_contents(INFO_URL . '?' . http_build_query($params));

// 表示
//echo "<pre>" . print_r(json_decode($res, true), true) . "</pre>";
require_once('path/to/twitteroauth.php');
$TwitterOAuth = new TwitterOAuth('CONSUMER_KEY', 'CONSUMER_SECRET', $access_token, $access_token_secret);
$userinfo = $TwitterOAuth->get('users/show', ['screen_name'=> '@ozsakuma']);