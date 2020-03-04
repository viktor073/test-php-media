<?php
	function str_parse($str){
		$str = mb_strtolower($str);
		$str = preg_replace('/[^ a-zа-яё\d]/ui', '|', $str);
		$replace = ['—', '/', '\t', '	', '\n', '\r\n', '\r','', ' ', ',', '.', PHP_EOL, '!', '?', ';', '\ ', ':', '"', "'", "┘"];
		$str = str_replace($replace, "|", $str);
		$str_arr = explode('|', $str);
		$replace = array_merge($replace, ['(', ')', '\\', '-']);
		$str_arr = array_diff($str_arr, $replace);
		foreach ($str_arr as $key => $value) {
			if(array_search(mb_substr($value, 0, 1), $replace) > 0) $str_arr[$key] = mb_substr($value, 1);
			if(array_search(mb_substr($value, -1, 1), $replace) > 0) $str_arr[$key] = mb_substr($value, 0, mb_strlen($value)-1);
		}
		return $str_arr;
	}
?>