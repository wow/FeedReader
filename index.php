<?php
header('Content-type:application/json;charset=utf-8');

use Wow\FeedReader\FeedReader;

require_once 'vendor/autoload.php';

$request = $_REQUEST;

$feedReader = new FeedReader();
$response = $feedReader->searchByKeyword($request);

echo json_encode($response);
