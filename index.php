<?php
require "loader.php";
require "Config/Config.php";
use System\Graph;
use System\Facebook;






$fb = new Facebook($cf['email'],$cf['pass'],$cf['user']);
function cck($file){
	return file_exists($file)?(strpos(file_get_contents($file),'c_user')!==false):false;
}
if(cck($fb->cookies)){
	$a = $fb->login();
}
