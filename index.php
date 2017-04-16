<?php
ini_set('max_execution_time',false);
ini_set('memory_limit','3G');
set_time_limit(0);
ignore_user_abort(true);
require "loader.php";
require "Config/Config.php";
use System\Graph;
use System\Facebook;
///
$gr = new Graph($cf['token']);
//*/
$fb = new Facebook($cf['email'],$cf['pass'],$cf['user']);
function cck($file){
	return file_exists($file)?(!(strpos(file_get_contents($file),'c_user')!==false)):false;
}
if(cck($fb->cookies)){
	$a = $fb->login();
}
$fdt = explode('/',$fb->cookies);
$fdt = __DIR__.'/data/'.str_replace('.txt','',end($fdt)).'_data.json';
file_exists($fdt) or ffc($fdt,' ');
$target = explode("\n",file_get_contents(__DIR__.'/Config/target.txt'));
$data = json_decode(file_get_contents($fdt),true);
$data = is_array($data)?$data:array();
$count = 0;
foreach($target as $pp){
$ax = $gr->getnewpost($pp);
if(!isset($data[$pp]) or $data[$pp]!=$ax){
	$fb->do_act($ax);
	$data[$pp]=$ax;
	$act[$pp] = $ax; 
	$count++;
	if($count>=9){
		break;
	}
}
}
ffc($fdt,json_encode($data));
if(isset($act)){
	print json_encode($act);
}