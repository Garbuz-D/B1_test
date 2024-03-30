<head>
 <meta charset="utf-8"/>
</head>

<body>
<?php
include 'form.html';
include 'param.php';
#название загруженного файла
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

#алгоритм обработки зависит от того, какой тип файла выбран
if($_POST['formTableType'] == 'user'){
	$allowable_format = $allowable_format_user;
	$table_name = $users_table_name;
}else{
	$allowable_format = $allowable_format_department;
	$table_name = $department_table_name;
}

echo '<pre>';
#проверка формата файла
if($_FILES['userfile']['type'] != 'text/csv'){
	echo "Файл должен иметь формат csv.\n";
}else{
	#окрыть загруженный файл
	if(($handle = fopen($_FILES['userfile']['tmp_name'], "r")) !== FALSE){
		#загрузить строку из файла
		if($data = fgetcsv($handle, 1000, ";", "\n") != $allowable_format){
			echo "Неправильный формат csv-Файла.\n";
		}else{
			$conn = new mysqli($servername, $username, $password, $dbname);
			#проверка отсутствия ошибок
			if ($conn->connect_error) {
			  die("Connection failed: " . $conn->connect_error . "\n");
			}
			
			#запросы делаются в рамках транзакции, чтобы отменить сделанные изменения в случае ошибки
			$conn->query("START TRANSACTION;");
			while (($data = fgetcsv($handle, 1000, ";", "\n")) !== FALSE) {
				$num = count($data);
				#запрос добавления строки в таблицу
				$query = "INSERT INTO " . $table_name . " VALUES (";
				for ($c=0; $c < $num; $c++) {
					$query .= ($data[$c]===""? "NULL" : '"'.$data[$c].'"') . ", ";
				}
				$query = substr($query, 0, -2) . ");";
				#отменить транзакцию в случае ошибки
				if(!$conn->query($query)){
					$error = $conn->error;
					$conn->query("ROLLBACK");
					die("Ошибка при добавлении данных: " . $error . "\n");
				}
			}
			#подтвердить транзакцию, если ошибок нет
			if ($conn->query("COMMIT;")) {
			  echo "Данные добавлены\n";
			  #загрузить файл в директорию с загрузками
			  $uploadfile = iconv('utf-8','windows-1251',$uploadfile);
			  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
					echo "Файл был успешно загружен.\n";
				} else {
					echo "Не удалось загрузить файл.\n";
				}
			} else {
			  echo "Ошибка при добавлении данных: " . $conn->error . "\n";
			}
			$conn->close();
		}
		fclose($handle);
	}else{
		echo "Ошибка открытия файла.\n";
	}
}


print "</pre>";
#вывести список загруженных файлов и формы
include "file_list.php";

?>
</body>