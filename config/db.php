<?php
//данные для подключенния к базе данных
$server = "localhost"; //адрес сервера
$username = "root"; // имя пользователя
$password = "root"; // пароль
$dbname = "sendform"; //имя базы данных

$db = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
