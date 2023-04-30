<?php
/**
 * Реализовать проверку заполнения обязательных полей формы в предыдущей
 * с использованием Cookies, а также заполнение формы по умолчанию ранее
 * введенными значениями.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  // TODO: аналогично все поля.
	$errors['email'] = !empty($_COOKIE['email_error']);
	$errors['year'] = !empty($_COOKIE['year_error']);
	$errors['biographi'] = !empty($_COOKIE['biographi_error']);
	$errors['limbs'] = !empty($_COOKIE['limbs_error']);
	$errors['gender'] = !empty($_COOKIE['gender_error']);
	$errors['ability'] = !empty($_COOKIE['ability_error']);
	$errors['checkbox'] = !empty($_COOKIE['checkbox_error']);

  // Выдаем сообщения об ошибках.
  if ($errors['fio']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('fio_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя.</div>';
  }
  // TODO: тут выдать сообщения об ошибках в других полях.
	if($errors['email']){
		setcookie('email_error','',100000);
		$messages[]='<div class="error">set email.</div>';
	}
  if($errors['year']){
		setcookie('year_error','',100000);
		$messages[]='<div class="error">Выберите год.</div>';
	}
	if($errors['biographi']){
		setcookie('biographi_error','',100000);
		$messages[]='<div class="error">set bio</div>';
	}
	if($errors['limbs']){
		setcookie('limbs_error','',100000);
		$messages[]='<div class="error">выбери конеч</div>';
	}
	if($errors['ability']){
		setcookie('ability','',100000);
		$messages[]='<div class="error">добавь способности</div>';
	}
	if($errors['checkbox']){
		setcookie('checkbox_error');
		$messages[]='<div class="error">поставь галку</div>';
	}
  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  // TODO: аналогично все поля.
	$values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
	$values['year'] = empty($_COOKIE['year_value']) ? '' : (int)$_COOKIE['year_value'];
	$values['biographi'] = empty($_COOKIE['biographi_value']) ? '' : (int)$_COOKIE['biographi_value'];
	$values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : (int)$_COOKIE['limbs_value'];
	$values['ability'] = empty($_COOKIE['ability_value']) ? '' : (int)$_COOKIE['ability_value'];
	$values['checkbox'] = empty($_COOKIE['checkbox_value']) ? '' : (int)$_COOKIE['checkbox_value'];

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['fio'])|| !preg_match('/^([a-zA-Z\'\-]+\s*|[а-яА-ЯёЁ\'\-]+\s*)$/u', $_POST['fio'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
  }

	if (empty($_POST['year'])|| !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
  }
	// if (empty($_POST['checkbox'])|| !($_POST['checkbox'] == 'on' || $_POST['checkbox'] == 1)) {
  //   // Выдаем куку на день с флажком об ошибке в поле fio.
  //   setcookie('checkbox', '1', time() + 24 * 60 * 60);
  //   $errors = TRUE;
  // }
	if($_POST['checkbox']==''){
    //print('Чекбокс<br/>');
    $errors = TRUE;
    setcookie('checkbox_error', '1', time() + 24 * 60 * 60);
}
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('checkbox_value', $_POST['checkbox'], time() + 30 * 24 * 60 * 60);
  }
	if (empty($_POST['email']) || !preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $_POST['email'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }
	// if (empty($_POST['limbs'])|| !is_numeric($_POST['limbs']) ||($_POST['limbs']<1)||($_POST['limbs']>4)) {
  //   // Выдаем куку на день с флажком об ошибке в поле fio.
  //   setcookie('limbs', '1', time() + 24 * 60 * 60);
  //   $errors = TRUE;
  // }
	if($_POST['limbs'] !== '1' && $_POST['limbs'] !== '2' && $_POST['limbs'] !== '3' && $_POST['limbs'] !== '4'){  
		//print('Укажите количество конечностей<br/>');
		$errors = TRUE;
		setcookie('limbs_error', '1', time() + 24 * 60 * 60);
	}
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('limbs_value', $_POST['limbs'], time() + 30 * 24 * 60 * 60);
}
	if (empty($_POST['gender'])|| !($_POST['gender']=='M' || $_POST['gender']=='F')) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
  }
	if (empty($_POST['ability'])|| !is_array($_POST['ability'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('ability_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('ability_value', $_POST['ability'], time() + 30 * 24 * 60 * 60);
  }
	if (empty($_POST['biographi'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('biographi_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('biographi_value', $_POST['biographi'], time() + 30 * 24 * 60 * 60);
  }
// *************
// TODO: тут необходимо проверить правильность заполнения всех остальных полей.
// Сохранить в Cookie признаки ошибок и значения полей.
// *************

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('fio_error', '', 100000);
		setcookie('year_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('limbs_error', '', 100000);
    setcookie('biographi_error', '', 100000);
    setcookie('ability_error', '', 100000);
    setcookie('checkbox_error', '', 100000);

    // TODO: тут необходимо удалить остальные Cookies.
  }

  // Сохранение в БД.
  $user = 'u52804';
$pass = '3418446';
$db = new PDO('mysql:host=localhost;dbname=u52804', $user, $pass, [PDO::ATTR_PERSISTENT => true]);

// // Подготовленный запрос. Не именованные метки.
 try {
	// var_dump($_POST['fio']);
	// var_dump($_POST['year']);
	// var_dump($_POST['biography']);
	// var_dump($_POST['email']);
	// var_dump($_POST['limbs']);
	// var_dump($_POST['gender']);
 $stmt = $db->prepare("INSERT INTO users SET name = ?, year = ?, biography = ?, email = ?, limbs = ?, gender = ?, checkbox = ?");
 $stmt->execute([$_POST['fio'], $_POST['year'], $_POST['biography'], $_POST['email'], $_POST['limbs'], $_POST['gender'], 1]);
 } catch (PDOException $e) {
 print('Error : ' . $e->getMessage());
 exit();
 }

 $user_id = $db->lastInsertId();

 foreach ($_POST['ability'] as $ability) {
 try {
 $stmt = $db->prepare("INSERT INTO user_ab SET user_id = ?, ability_id = ?");
 $stmt->execute([$user_id, $ability]);
 } catch (PDOException $e) {
 print('Error : ' . $e->getMessage());
 exit();
 }
 }

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}
