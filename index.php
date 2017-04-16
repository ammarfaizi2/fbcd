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

function cek($a){
	if(file_exists($a)){
		return strpos(file_get_contents($a),'c_user')!==false;
	} else {
		return false;
	}
}
if(!cek($fb->cookies)){
	print 'login'.$fb->login();
}
$fdt = explode('/',$fb->cookies);
$fdt = 'data/'.str_replace('.txt','',end($fdt)).'_data.json';
file_exists($fdt) or ffc($fdt,' ');
$target = explode("\n",file_get_contents(__DIR__.'/Config/target.txt'));
$data = json_decode(file_get_contents($fdt),true);
$data = is_array($data)?$data:array();
$count = 0;
$act = array();
foreach($target as $pp){
$ax = $gr->getnewpost($pp);
print $ax.'='.$data[$pp];
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
file_put_contents($fdt,json_encode($data));
if(isset($act)){
#	print json_encode(array('act'=>$act,))
	;
	print_r($act);
	print_r($data);
}