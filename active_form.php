<?php
	require('lesson3.php');
	function set_new_file($str){
		if (!file_exists('test')) {
			if(!mkdir('test')){
				echo "Not created - direct 'test'".PHP_EOL;
				return;
			}
		}
		$i=1;
		while (true) {
			if(!file_exists('test/test'. $i .'.csv')) {
				$filename = 'test/test'. $i .'.csv';
				touch($filename);
				break;
			}
			$i++;
		}
		$res_str = mb_convert_encoding(str_parse($str), "CP1251");
		file_put_contents($filename, $res_str);
	}

	if (!empty($_POST['str'])) {
		set_new_file($_POST['str']);
	}
	if(!empty($_FILES['files']['name'])){
		$files = $_FILES['files'];
		foreach ($files['tmp_name'] as $index => $tmpPath) {
			if(!array_key_exists($index, $files['name'])){
			continue;
			}
			set_new_file(file_get_contents($tmpPath));
		}
	}
?>