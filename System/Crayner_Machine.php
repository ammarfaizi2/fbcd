<?php
namespace System;
use System\Core;

class Crayner_Machine extends Core
{
	public static function curl($url,$post=null,$cookie=null,$opt=null,$rt=null)
	{
		$ch = curl_init($url);
		$op = array(
			CURLOPT_RETURNTRANSFER=>true,
			CURLOPT_SSL_VERIFYPEER=>false,
			CURLOPT_SSL_VERIFYHOST=>false,
			CURLOPT_FOLLOWLOCATION=>false,
			CURLOPT_USERAGENT=>self::UA,
			CURLOPT_TIMEOUT=>500,
			CURLOPT_CONNECTTIMEOUT=>500
		);
		if(isset($post)){
			$op[CURLOPT_POST] = true;
			$op[CURLOPT_POSTFIELDS] = $post;
		}
		if(isset($cookie)){
			$op[CURLOPT_COOKIEJAR] = $cookie;
			$op[CURLOPT_COOKIEFILE] = $cookie;
		}
		if(is_array($opt)){
			foreach($opt as $a => $b){
				$op[$a] = $b;
			}
		}
		curl_setopt_array($ch,$op);
		$out = curl_exec($ch);
		$err = curl_error($ch) and $out = $err;
		$inf = curl_getinfo($ch);
		curl_close($ch);
		return $rt=="all"?array($out,$inf):$out;
	}
}