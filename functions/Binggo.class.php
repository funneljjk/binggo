<?php
/*
* Binggo
* @link https://www.cosmosfarm.com/
* @copyright Copyright 2023 Cosmosfarm. All rights reserved.
*/

class Binggo {
	
	public static function sanitize_data($data=array()){
		if(!$data){
			return (object) array();
		}
		
		$int_raw      = isset($data['int'])      ? $data['int']      : array();
		$string_raw   = isset($data['string'])   ? $data['string']   : array();
		$textarea_raw = isset($data['textarea']) ? $data['textarea'] : array();
		$array_raw    = isset($data['array'])    ? $data['array']    : array();
		
		$int      = array();
		$string   = array();
		$textarea = array();
		$array    = array();
		
		foreach($int_raw as $key=>$value) $int[$key]           = intval($value);
		foreach($string_raw as $key=>$value) $string[$key]     = sanitize_text_field($value);
		foreach($textarea_raw as $key=>$value) $textarea[$key] = sanitize_textarea_field($value);
		foreach($array_raw as $key=>$value) $array[$key]       = array_map('sanitize_text_field', $value);
		
		$data = array();
		$data = array_merge($data, $int, $string, $textarea, $array);
		
		return (object) $data;
	}
	
	public static function sanitize_image($data=array()){
		if(!$data){
			return (object) array();
		}
		
		$files = array();
		foreach($data as $key=>$file){
			foreach($file as $name=>$value){
				if(is_array($value)){
					foreach($value as $idx=>$val){
						$files[$name][$idx][$key] = sanitize_text_field($val);
					}
				}
			}
		}
		
		return (object) $files;
	}
}