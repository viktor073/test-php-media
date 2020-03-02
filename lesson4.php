<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Лекция 4 - домашнее задание</title>
	<script src="/js/jquery.js"></script><!-- Библиотека jQuery -->
	<script src="/js/jscript.js"></script><!--свой JS-код-->
	<script src="/js/jquery.form.js"></script>
</head>
<body align="center">
	<h1>Лекция 4 - Формы и файлы</h1>
	<h2>Форма</h2>
	<div id="output">Выберите файлы и заполните поле:</div><br>
	<form method="post" enctype="multipart/form-data" id="formdata">
		<input type="file" name="files[]" accept="text/plain" multiple> <br><br>
		<textarea name="str" cols="100" rows="25"></textarea><br><br>
		<input type="button" name="btn_active_form" id="btn_active_form" value="Выполнить">
	</form>

</body>
