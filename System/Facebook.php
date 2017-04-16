<?php
namespace System;
use System\Core;
use System\Crayner_Machine;
require_once __DIR__.'/Helper/hte.php';
require_once __DIR__.'/Helper/ffc.php';
class Facebook extends Crayner_Machine
{
	private $email;
	private $pass;
	private $user;
	public $cookies;
	public function __construct($email,$pass,$user=null)
	{
		$this->email = $email;
		$this->pass = $pass;
		if($user===null){
			$email = explode("@",$email);
			$this->user = $email[0];
			$this->cookies = 'data/cookies/'.$email[0].'.txt';
		} else {
			$this->user = $user;
			$this->cookies = 'data/cookies/'.$user.'.txt';
		}
		if(!file_exists($this->cookies)){
			ffc($this->cookies,'');
		}
		$this->cookies = realpath(__DIR__.'/..').$this->cookies;
	}
	public function go_to($url,$post=null,$op=null)
	{
		$a = $this->curl($url,$post,$this->cookies,$op,'all');
		if(isset($a[1]['redirect_url']) and !empty($a[1]['redirect_url'])){
			$a = $this->curl($a[1]['redirect_url'],null,$this->cookies,$op);
		} else {
			$a = $a[0];
		}
		return $a;
	}
	public function login()
	{
		$furl = "https://m.facebook.com/";
		$a = $this->go_to($furl);
		$a = file_get_contents('aa');
		$s = explode("type=\"submit\"",$a,2);
		$s = explode("<",$s[0]);
		$s = explode("value=\"",end($s));
		$s = explode("\"",$s[1]);
		$s = $s[0];
		$a = explode("<form",$a,2);
		if(count($a)<2){
			return false;
		}
		$a = explode("</form>",$a[1],2);
		$a = explode("<input type=\"hidden\"",$a[0]);
		$ps='';
		for($i=1;$i<count($a);$i++){
			$b = explode("name=\"",$a[$i],2);
			$b = explode("\"",$b[1],2);
			$c = explode("value=\"",$a[$i],2);
			$c = explode("\"",$c[1],2);
			$ps.=urlencode($b[0]).'='.urlencode($c[0]).'&';
		}
		$act = explode("action=\"",$a[0],2);
		$act = explode("\"",$act[1],2);
		$act = hte($act[0]);
		$ps.="email=".urlencode($this->email)."&pass=".urlencode($this->pass)."&login=".urlencode($s);
		return $this->go_to($act,$ps,array(CURLOPT_REFERER=>$furl));
	}
	public function do_act($ax)
	{
		$furl = 'https://m.facebook.com/';
		$ref = $furl.$ax;
		$a = $this->go_to($ref);
		$a = explode("href=\"/reactions/picker/?",$a,2);
		$a = explode("\"",$a[1],2);
		$aee = '/reactions/picker/?'.hte($a[0]);
		$a = $this->go_to('https://m.facebook.com'.$aee,null,array(CURLOPT_REFERER=>$ref));
		$ref = 'https://m.facebook.com'.$aee;
		$a = explode('href="/ufi/reaction',$a);
		$br = rand(0,10)>=3?2:1;
		$a = explode('"',$a[$br]);
		$a = hte("/ufi/reaction".$a[0]);
		$a = $this->go_to($furl.$a,null,array(CURLOPT_REFERER=>$ref));
		return $a;
	}
}