<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Лекция 5 СУБД - домашнее задание</title>
</head>
<body align="center">
	<h1>Главная - список текстов</h1>
	<a href="lesson4.php">Загрузить текст</a><br><br>
	<table align='center' border='1' width='700'>
		<tr>
			<td>№</td>
			<td>Короткий текст</td>
			<td>Подробнее</td>
		</tr>
		<?
			require("db_connection.php");
			$selectQuery = 'SELECT * FROM uploaded_text';
			$rowAll = $pdo->query($selectQuery)->fetchAll();
			if($rowAll == []){echo "Array null.";}
			else{
				foreach ($rowAll as $row) {
					$content_short = mb_substr($row['content'], 1, 50);
					printf("<tr>
						<td>%s</td>
						<td>%s</td>
						<td><a href='detail_text.php?id=%s'>подробнее...</a></td>
						</tr>",
						$row['id'], $content_short, $row['id']);
				}
			}
		?>
	</table>
</body>