<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['limbs'] = !empty($_COOKIE['limbs_error']);
  $errors['abilities'] = !empty($_COOKIE['abilities_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['go'] = !empty($_COOKIE['go_error']);

  if ($errors['name']) {
    setcookie('name_error', '', 100000);
    $messages[] = '<div class="error">Заполните name.</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Заполните email.</div>';
  }
  if ($errors['year']) {
    setcookie('year_error', '', 100000);
    $messages[] = '<div class="error">Заполните year.</div>';
  }
  if ($errors['gender']) {
    setcookie('gender_error', '', 100000);
    $messages[] = '<div class="error">Заполните gender.</div>';
  }
  if ($errors['limbs']) {
    setcookie('limbs_error', '', 100000);
    $messages[] = '<div class="error">Заполните limbs.</div>';
  }
  if ($errors['abilities']) {
    setcookie('abilities_error', '', 100000);
    $messages[] = '<div class="error">Заполните abilities.</div>';
  }  
  if ($errors['bio']) {
    setcookie('bio_error', '', 100000);
    $messages[] = '<div class="error">Заполните bio.</div>';
  }
  if ($errors['go']) {
    setcookie('go_error', '', 100000);
    $messages[] = '<div class="error">Заполните go.</div>';
  }

  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
  $values['abilities'] = empty($_COOKIE['abilities_value']) ? [] : json_decode($_COOKIE['abilities_value']);
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['go'] = empty($_COOKIE['go_value']) ? '' : $_COOKIE['go_value'];
  include('form.php');
}
else {
  $errors = FALSE;
  if (empty($_POST['name'])) {
    $errors = TRUE;
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  } else {
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['email']) || !preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $_POST['email'])) {
    $errors = TRUE;
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
    setcookie('email_error', '1', time() + 24 * 60 * 60);
  } else {
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['year']) || !is_numeric($_POST['year']) || (int)$_POST['year'] <= 1922 || (int)$_POST['year'] >= 2022) {
    $errors = TRUE;
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
  } else {
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
  }
  if ($_POST['gender'] !== 'm' && $_POST['gender'] !== 'w'){
    $errors = TRUE;
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
  } else {
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
  }
  if ($_POST['limbs'] !== '2' && $_POST['limbs'] !== '3' && $_POST['limbs'] !== '4') {  
    $errors = TRUE;
    setcookie('limbs_error', '1', time() + 24 * 60 * 60);
  } else {
    setcookie('limbs_value', $_POST['limbs'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['abilities']) || !is_array($_POST['abilities'])) {
    $errors = TRUE;
    setcookie('abilities_error', '1', time() + 24 * 60 * 60);
  } else {
    setcookie('abilities_value', json_encode($_POST['abilities']), time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['bio']) || strlen($_POST['bio']) > 128) {
    $errors = TRUE;
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
  } else{
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
  }
  if ($_POST['go'] == '') {
    $errors = TRUE;
    setcookie('go_error', '1', time() + 24 * 60 * 60);
  } else {
    setcookie('go_value', $_POST['go'], time() + 30 * 24 * 60 * 60);
  }

  if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {
    setcookie('name_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('year_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('limbs_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('go_error', '', 100000);
  }

  $user = 'u52804'; 
  $pass = '3418446';
  $db = new PDO('mysql:host=localhost;dbname=u52804', $user, $pass, [PDO::ATTR_PERSISTENT => true]); 
  
  $name = $_POST['name'];
  $email = $_POST['email'];
  $year = $_POST['year'];
  $gender = $_POST['gender'];
  $limbs = $_POST['limbs'];
  $name = $_POST['bio'];

  try {
    $stmt = $db->prepare("INSERT INTO users (name, email, year, gender, limbs, biography, checkbox) VALUES (?, ?, ?, ?, ?, ?, ?);");
    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['year'], $_POST['gender'], $_POST['limbs'], $_POST['bio'], $_POST['go']]);
    $strId = $db->lastInsertId();
    if (isset($_POST['abilities'])) {
      $stmt = $db -> prepare("INSERT INTO user_ab (user_id, ability_id) VALUES (?, ?);");
      foreach ($_POST['abilities'] as $superpower) {
        $stmt->execute([$strId, $superpower]);
      }
    }
  } catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
  }

  setcookie('save', '1');
  header('Location: index.php');
}
