<?php
	/**
	 * обработчик формы
	 */
	require ('autoloadClass.php');
	if (!empty($_POST['str'])) {

		try {
			$strToWord1 = new StringToSingWord($_POST['str']);
		}
		catch(Exception $e) {
			echo $e->getMessage(), "\n<br>";
			return;
		}
		$strToWord1->putToDB();
	}

	if(!empty($_FILES['files']['name'])){
		$files = $_FILES['files'];
		foreach ($files['tmp_name'] as $index => $tmpPath) {
			if(!array_key_exists($index, $files['name'])){
			continue;
			}
			if(!empty($tmpPath)){
				try {
					$strToWord = new StringToSingWord(file_get_contents($tmpPath));
				}
				catch(Exception $e) {
					echo $e->getMessage(), "\n<br>";
					return;
				}
				$strToWord->putToDB();
			}
		}
	}
	header('Location: index.php');
?>