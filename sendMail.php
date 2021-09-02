<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
$address = $_POST['usermail'];
$name = $_POST['username'];
$lastname = $_POST['userlastname'];
$phone = $_POST['userphone'];
$email = $_POST['usermail'];

$mail1 = new PHPMailer(true);
$mail1->CharSet = 'UTF-8';
$mail1->setLanguage('ru', 'phpmailer/language/');
$mail1->isHTML(true);

$mail1->setFrom('whirpool@gmail.com', 'whirpool');

    $mail1->addAddress($address, $name);     //Add a recipient




    //Attachments
    $mail1->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail1->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail1->isHTML(true);                                  //Set email format to HTML
    $mail1->Subject = 'Заявка на реэстрацію приладу';
    $mail1->Body    = 'Ваша заявка прийнята </br>ми з вами зв"яжемося';
    $mail1->AltBody = 'Ваша заявка прийнята ми з вами зв"яжемося';

    $mail1->send();
$mail2 = new PHPMailer(true);
$mail2->CharSet = 'UTF-8';
$mail2->setLanguage('ru', 'phpmailer/language/');
$mail2->isHTML(true);

$mail2->setFrom('whirpool@gmail.com', 'whirpool');

$mail2->addAddress('whirpool@gmail.com', 'whirpool');     //Add a recipient

$body ='<h1> Вам подано заявку</h1>';
$body .= '<p><h2>Інформація замовника</h2></p>';
$body .= "<p>Ім'я: </p>".$name;
$body .= "<p>Прізвище: </p>".$lastname;
$body .= "<p>Телефон: </p>".$lastname;
if (!empty($_FILES['image']['tmp_name'])) {
        $filepath = __DIR__.'/img/'.$_FILES['image']['name'];
        if (copy($_FILES['image']['tmp_name'], $filepath)) {
            $fileAttach = $filepath;
            $body .= "<p>Завантажене фото у додатку </p>";
            $mail2->addAttachment($fileAttach);
        }
}

//Attachments
$mail2->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
$mail2->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

//Content
$mail2->isHTML(true);                                  //Set email format to HTML
$mail2->Subject = 'Заявка на реэстрацію приладу';
$mail2->Body    = $body;
$mail2->AltBody = 'Ваша заявка прийнята';

$mail2->send();
