<?php
	require('lesson3.php');
	//функция выгрузки в файлы
	function set_new_file($str){
		//готовим директорию и файл
		if (!file_exists('test')) {
			if(!mkdir('test')){
				echo "Not created - direct 'test'".PHP_EOL;
				return;
			}
		}
		//готовим файл
		$i=1;
		while (true) {
			if(!file_exists('test/test'. $i .'.csv')) {
				$filename = 'test/test'. $i .'.csv';
				touch($filename);
				break;
			}
			$i++;
		}
		$word_arr = str_parse($str);//рабираем текст на слова в lesson3.php и возвращаем массивом
		$words_count = count($word_arr);//считаем общее количество слов
		$word_count_arr = array_count_values($word_arr);//считаем количество вхождений каждого слова
		//готовим контент для вставки в файл .csv
		foreach ($word_count_arr as $key => $value) {
			$content = $content.$key.'; '.$value . PHP_EOL;
		}
		$content = $res_str."Всего слов:;".$words_count;
		$content = mb_convert_encoding($content, "CP1251");
		//вставляем контент в файл
		file_put_contents($filename, $content);
	}

	//функция выгрузки в БД
	function insert_db($str){
		require("db_connection.php");
		$word_arr = str_parse($str);//рабираем текст на слова в lesson3.php и возвращаем массивом
		$words_count = count($word_arr);//считаем общее количество слов
		//вставляем строку в uploaded_text
		$insertQuery = 'INSERT INTO uploaded_text(content, date_ex, words_count) VALUES(?,?,?)';
		$statement = $pdo->prepare($insertQuery);

		$success = $statement->execute([
			$pdo->quote($str),
			date("Y-m-d"),
			$words_count
		]);
		//получаем id текущего INSERT запроса из uploaded_text
		$text_id = $pdo->lastInsertId();
		//вставляем строки в word
		$word_count_arr = array_count_values($word_arr);//считаем количество вхождений каждого слова
		//готовим запрос INSERT
		$insertQuery = 'INSERT INTO word(text_id, word, count) VALUES(?,?,?)';
		$statement = $pdo->prepare($insertQuery);
		//выполняем запрос INSERT
		foreach ($word_count_arr as $key => $value) {
			$success = $statement->execute([
				$text_id,
				$pdo->quote($key),
				$value
			]);
		}
	}

	if (!empty($_POST['str'])) {
		//set_new_file($_POST['str']);
		insert_db($_POST['str']);
	}
	if(!empty($_FILES['files']['name'])){
		$files = $_FILES['files'];
		foreach ($files['tmp_name'] as $index => $tmpPath) {
			if(!array_key_exists($index, $files['name'])){
			continue;
			}
			if(!empty($tmpPath)){
			//set_new_file(file_get_contents($tmpPath));
				insert_db(file_get_contents($tmpPath));
			}
		}
	}
	header('Location: index.php');
?>