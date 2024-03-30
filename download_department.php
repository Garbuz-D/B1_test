<?php
#загрузить файл с информацией о департаментах
include 'download.php';
include 'param.php';
$filename = 'department.csv';
$table_name = $department_table_name;
download($filename, $table_name);
?>
