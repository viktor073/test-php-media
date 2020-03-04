<?
	//Подключаем файл с параметрами
	define('HOST', '127.0.0.1:3306'); //сервер
	define('USER', 'root'); //пользователь
	define('PASSWORD', ''); //пароль
	define('NAME_BD', 'php-test-media');//база
	//Подключение...
	try {
		$pdo = new PDO('mysql:host=' .HOST. ';dbname=' .NAME_BD. '', USER, PASSWORD);

	}
		catch(PDOException $e){
			echo "Error!: " . $e->getMessage(). "<br>";
			return;
	}
?>