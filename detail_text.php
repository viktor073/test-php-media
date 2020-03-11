<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Лекция 5 СУБД - домашнее задание</title>
</head>
<body align="center">
	<h1>Подробная информация о тексте</h1>
	<a href="index.php">назад</a><br><br>
		<?
			if (!empty($_GET['id'])) {
				$id = $_GET['id'];
				require ('autoloadClass.php');
				require("dbConf.php");
				$pdo = singlePDO::GetInst($host, $name_bd, $user_name, $user_password);
				$selectQuery = "SELECT content, date_ex, words_count FROM uploaded_text WHERE id='$id'";
				$row = $pdo->query($selectQuery)->fetch();
				if($row == []){echo "Array null.";}
				else{
					printf("Дата загрузки: %s<br><br>", $row['date_ex']);
					printf("Общее количество слов: %s<br><br>", $row['words_count']);
					printf("Полный текст:<p>%s</p><br>", $row['content']);
				}
				$selectQuery = "SELECT * FROM word WHERE text_id='$id'";
				$rowAll = $pdo->query($selectQuery)->fetchAll();
				print("<table align='center' border='1' width='500'>
					<tr>
						<td>№</td>
						<td>№ текста</td>
						<td>Слово</td>
						<td>Количество</td>
					</tr>");
				if($rowAll == []){echo "Нет данных.";}
				else{
					foreach ($rowAll as $row) {
						printf("<tr>
							<td>%s</td>
							<td>%s</td>
							<td>%s</td>
							<td>%s</td>
							</tr>",
							$row['id'], $row['text_id'], $row['word'], $row['count']);
					}
				}
				print("</table>");
			}
		?>
</body>