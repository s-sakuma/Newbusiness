<?php
/*
 * 署名の作成
 */
function build_signature($method, $url, $params, $consumer_secret, $token_secret = '') {

	ksort($params);
	$base = rawurlencode($method)."&".rawurlencode($url)."&".rawurlencode(http_build_query($params));

	$key = rawurlencode($consumer_secret)."&".rawurlencode($token_secret);

	return base64_encode(hash_hmac('sha1', $base, $key, true));
}