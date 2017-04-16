<?php
namespace System;
use System\Crayner_Machine;
require_once __DIR__.'/Helper/ffc.php';
class Graph extends Crayner_Machine
{
	const W = 'https://graph.facebook.com/';
	public function __construct($token)
	{
		$this->token = $token;
	}
	public function getnewpost($id='me')
	{
		$a = $this->curl(self::W.$id.'/feed/?fields=id&limit=1&access_token='.$this->token);
		$a = json_decode($a,true);
		if($a===null) return false;
		return isset($a['data'][0]['id'])?substr($a['data'][0]['id'],(strpos($a['data'][0]['id'],'_')+1)):false;
	}
}
