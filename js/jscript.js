$(function(){
	$.ajaxSetup( {
		type: 'POST', // метод передачи данных
		beforeSend: function(){ // Функция вызывается перед отправкой запроса
			output.innerHTML = 'Запрос отправлен. Ждите ответа.';
		},
		error: function(req, text, error){ // отслеживание ошибок во время выполнения ajax-запроса
			output.innerHTML = 'Сервис временно не доступен. Приносим извинения.';
		},
		complete: function(){ // функция вызывается по окончании запроса
		//	output.innerHTML = 'Запрос завершен.';
		},
	});

	$("#btn_active_form").click(function(){
		$('#formdata').ajaxSubmit({
			url: '/active_form.php', // путь к php-обработчику
			success: function(data){ // функция, которая будет вызвана в случае удачного завершения запроса к серверу
					output.innerHTML = data;
					$('#formdata')[0].reset();
	     	}
	    });
	});
});//end