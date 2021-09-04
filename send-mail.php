<?php
//$to = 'nobody@example.com';
//$subject = 'the subject';
//$message = 'hello';
//$headers = array(
//    'From' => 'webmaster@example.com',
//    'Reply-To' => 'webmaster@example.com',
//    'X-Mailer' => 'PHP/' . phpversion()
//);
//$headers = 'MIME-Version: 1.0' . "\r\n";
//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//
//// Дополнительные заголовки
////$headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
////$headers[] = 'From: Birthday Reminder <birthday@example.com>';
////$headers[] = 'Cc: birthdayarchive@example.com';
////$headers[] = 'Bcc: birthdaycheck@example.com';
//mail($to, $subject, $message, $headers);
$headers = array(
    'MIME-Version: 1.0' . "\r\n",
    'Content-type: text/html; charset=iso-8859-1' . "\r\n",
    'From' => 'webmaster@example.com',
    'Reply-To' => 'webmaster@example.com',
    'X-Mailer' => 'PHP/' . phpversion()
);

if (!empty($_POST['usermail'])) {
    $address = $_POST['usermail'];
}

if (!empty($_POST['username'])) {
    $name = $_POST['username'];
}

if (!empty($_POST['userlastname'])) {
    $lastname = $_POST['userlastname'];
}

if (!empty($_POST['userphone'])) {
    $phone = $_POST['userphone'];
}

if (!empty($_POST['area'])) {
    $area = $_POST['area'];
}
if (!empty($_POST['city'])) {
    $city = $_POST['city'];
}

if (!empty($_POST['index'])) {
    $index = $_POST['index'];
}
if (isset($area, $city, $index)) {
    $location = '';
    $location .= "<p><strong>Область: </strong></p>" . $area;
    $location .= "<p><strong>Місто/населений пункт: </strong></p>" . $city;
    $location .= "<p><strong>Індекс: </strong></p>" . $index;
}
if (!empty($_POST['device'])) {
    $device = $_POST['device'];
}
if (!empty($_POST['brand'])) {
    $brand = $_POST['brand'];
    $device .= 'Бренд ' . $brand;
}
if (!empty($_POST['model'])) {
    $model = $_POST['model'];
    $device .= 'Назва моделі ' . $model;
}
if (!empty($_POST['date'])) {
    $date = $_POST['date'];
}
if (!empty($_POST['nc12'])) {
    $nc12 = $_POST['nc12'];
}
if (!empty($_POST['serialnumber'])) {
    $serialnumber = $_POST['serialnumber'];
}
if (!empty($_POST['fiscalCheck'])) {
    $fiscalCheck = $_POST['fiscalCheck'];
}
if (!empty($_POST['shopname'])) {
    $shopname = $_POST['shopname'];
}

//Content
$to = $address;
$subject = 'Заявка на реэстрацію приладу';
$message = 'Ваша заявка прийнята ' . "\r\n" . ' ми з вами зв"яжемося';

mail($to, $subject, $message, $headers);

$boundary = "---";
$headers = array(
    'MIME-Version: 1.0' . "\r\n",
    "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n",
    'From' => 'webmaster@example.com',
    'Reply-To' => 'webmaster@example.com',
    'X-Mailer' => 'PHP/' . phpversion()
);

$to = $address;

$subject = 'Заявка на реэстрацію приладу';

$message = "
<html>
<head>
  <title>Інформація замовника</title>
</head>
<body>
  <h1> Вам подано заявку</h1>
  <p><h2>Інформація замовника</h2></p>
  <table>
    <tr>
      <th>Ім'я</th><td>" . $name . ' ' . $lastname . "</td>
    </tr>
    <tr>
      <th>Телефон</th><td>" . $phone . "</td>
    </tr>
    <tr>
       <th>Електронна пошта</th><td>" . $address . "</td>
    </tr>
    <tr>
       <th>Адресса</th><td>" . $location . "</td>
    </tr>   
     <tr>
       <th>Інформація про прилад</th><td>" . $device . "</td>
    </tr>
    <tr>
       <th>Код 12nc (комерційний код)</th><td>" . $nc12 . "</td>
    </tr>
    <tr>
       <th>Серійний номер</th><td>" . $serialnumber . "</td>
    </tr>
    <tr>
       <th>Дата придбання</th><td>" . $date . "</td>
    </tr>
<tr>
       <th>Номер фіксального чеку</th><td>" . $fiscalCheck . "</td>
    </tr>
  </table>
</body>
</html>
";
$filename = "form.txt";
$body = "--$boundary\n";
/* Присоединяем текстовое сообщение */
$body .= "Content-type: text/html; charset='utf-8'\n";
$body .= "Content-Transfer-Encoding: quoted-printablenn";
$body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($filename)."?=\n\n";
$body .= $message."\n";
$body .= "--$boundary\n";
$file = fopen($filename, "r"); //Открываем файл
$text = fread($file, filesize($filename)); //Считываем весь файл
fclose($file); //Закрываем файл
/* Добавляем тип содержимого, кодируем текст файла и добавляем в тело письма */
$body .= "Content-Type: application/octet-stream; name==?utf-8?B?".base64_encode($filename)."?=\n";
$body .= "Content-Transfer-Encoding: base64\n";
$body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($filename)."?=\n\n";
$body .= chunk_split(base64_encode($text))."\n";
$body .= "--".$boundary ."--\n";

mail($to, $subject, $message, $headers);
header('Location: /');
