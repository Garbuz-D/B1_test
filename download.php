<?php

#функция загрузки csv-файла с информацией из БД
function download($filename, $table_name){
	include 'param.php';

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Не удалось соединиться с базой данных: " . $conn->connect_error);
	}
	
	#извлечь данные из таблицы
	$result = $conn->query("SELECT * FROM " . $table_name);

	#создать и открыть временный файл
	$file = fopen($filename,"w");
	#заголовок файла для корректного отображения символов utf-8
	fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
	#записать в файл строки из таблицы в формате csv
	while($row = $result->fetch_assoc()) {
		fputcsv($file,$row,';');
	}
	#закрыть файл
	fclose($file);

	#заголовки HTTP
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=".$filename);
	header("Content-Type: application/csv; "); 
	
	
	#загрузить файл 
	readfile($filename);

	#удалить временный файл
	unlink($filename);
}
?>