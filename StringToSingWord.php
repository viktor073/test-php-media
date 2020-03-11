<?php
	/**
	 * класс для подсчета: общее количество слов, количество вхождений каждого слова.
	 * класс сохраняет результат обработки в файл и в базу данных
	 */
	class StringToSingWord
	{
		const REPLACE = ['—', '/', '\t', '	', '\n', '\r\n', '\r', '', ' ', ',', '.', PHP_EOL, '!', '?', ';', ':', '"', "'", "┘", '(', ')', '\\', '-'];
		public $arrCountSingWord;
		public $countAllWords;
		public $str;
		function __construct($str_org)
		{
			if(!is_string($str_org)){
				throw new Exception('Значение переменной не строка -');
			}
			$this->str = $str_org;
			$str_org = mb_strtolower($str_org);
			$str_org = preg_replace('/[^ a-zа-яё\d]/ui', '|', $str_org);
			$str_org = str_replace(self::REPLACE, "|", $str_org);
			$arr = explode('|', $str_org);

			$arr = array_diff($arr, self::REPLACE);

			foreach ($arr as $key => $value) {
				if(array_search(mb_substr($value, 0, 1), self::REPLACE) > 0) $arr[$key] = mb_substr($value, 1);
				if(array_search(mb_substr($value, -1, 1), self::REPLACE) > 0) $arr[$key] = mb_substr($value, 0, mb_strlen($value)-1);
			}

			$this->countAllWords = count($arr);//считаем общее количество слов

			$this->arrCountSingWord = array_count_values($arr);//считаем количество вхождений каждого слова
		}

		public function putToFile(){
			if (!file_exists('test')) {
				if(!mkdir('test')){
					echo "Not created - direct 'test'".PHP_EOL;
					return false;
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

			//готовим контент для вставки в файл .csv
			foreach ($this->arrCountSingWord as $key => $value) {
				$content = $content.$key.'; '.$value . PHP_EOL;
			}
			$content = $content."Всего слов:;".$this->countAllWords;
			$content = mb_convert_encoding($content, "CP1251");
			//вставляем контент в файл
			if(file_put_contents($filename, $content)) return true;
		}

		public function putToDB(){
			require ('autoloadClass.php');
			require("dbConf.php");
			$pdo = singlePDO::GetInst($host, $name_bd, $user_name, $user_password);
			//вставляем строку в uploaded_text
			$insertQuery = 'INSERT INTO uploaded_text(content, date_ex, words_count) VALUES(?,?,?)';
			$statement = $pdo->prepare($insertQuery);

			$success = $statement->execute([
				$pdo->quote($this->str),
				date("Y-m-d"),
				$this->countAllWords
			]);
			//получаем id текущего INSERT запроса из uploaded_text
			$text_id = $pdo->lastInsertId();
			//вставляем строки в word
			//готовим запрос INSERT
			$insertQuery = 'INSERT INTO word(text_id, word, count) VALUES(?,?,?)';
			$statement = $pdo->prepare($insertQuery);
			//выполняем запрос INSERT
			foreach ($this->arrCountSingWord as $key => $value) {
				$success = $statement->execute([
					$text_id,
					$pdo->quote($key),
					$value
				]);
			}
		}
	}