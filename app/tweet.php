<?php
/**
 * Created by PhpStorm.
 * User: s-sakuma
 * Date: 2015/07/11
 * Time: 4:54
 *
 * とくにつかわない
 */
require('../vendor/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;
require_once('config.php');
$consumerKey = API_KEY;
$consumerSecret = API_SECRET;
$accessToken = ACCESS_TOKEN;
$accessTokenSecret = ACCESS_SECRET;
$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
var_dump($connection);

$result = $connection->post("statuses/update", array("status" => "hello world"));
var_dump($result);