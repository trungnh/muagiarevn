<?php 
include "./wp-load.php";
include dirname(__FILE__) . "/wp-content/themes/clipper/framework/admin/importer.php";

$token = 'SJKbdpv7xV7r2xwzqF6GQ_jYd0QPBHmx';
$response = getResponse($token);
var_dump(response);die;

/*================ Functions ================*/
function getResponse($token, $url = '')
{
	$requestUrl = 'http://api.accesstrade.vn/me/product_links';
	$header = 	array('Content-Type: application/x-www-form-urlencoded');
	$userAgent = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36';
	
	$data	=	"access_key={$token};url=http://tiki.vn";
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
	curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
	curl_setopt($ch, CURLOPT_URL, $requestUrl);
	curl_setopt($process, CURLOPT_POSTFIELDS, $data); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$data = curl_exec($ch);
	curl_close($ch);

	return $data;
}