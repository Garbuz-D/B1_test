<?php
#загрузить файл с информацией о пользователяхы
include 'download.php';
include 'param.php';
$filename = 'users.csv';
$table_name = $users_table_name;
download($filename, $table_name);
?>
