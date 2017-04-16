<?php
if(!function_exists('hte')){
	function hte($str)
	{
		return trim(html_entity_decode($str,ENT_QUOTES,'UTF-8'));
	}
}