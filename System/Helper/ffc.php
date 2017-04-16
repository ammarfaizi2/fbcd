<?php
if(!function_exists('ffc')){
function ffc($dir,$contents)
{
if(strpos($dir,'/')===false)
return file_put_contents($dir,$contents);
$parts=explode('/',$dir);
$file=array_pop($parts);
$dir='';
foreach($parts as $part){
	if(!is_dir($dir.="/$part")) mkdir($dir);
}
return file_put_contents("$dir/$file",$contents);
}
}