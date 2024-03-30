<head>
 <meta charset="utf-8"/>
</head>

<body>
<?php
#формы для загрузки файлов
include 'form.html';
#список загруженных файлов
include 'file_list.php';

#функция для отображения данных из БД в табличном виде
function print_table($table_name, $table_format){
	include 'param.php';
	#соединение с БД
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Не удалось соединиться с базой данных: " . $conn->connect_error);
	}
	
	#формирование таблицы
	echo "<h2>$table_name</h2>
			<table>
			  <tr>";
	#названия столбцов
	foreach($table_format as $col_name){
		echo "<th>".$col_name."</th>";
	}
	echo "</tr>";
	
	#выбрать данные из таблицы
	$sql = "SELECT * FROM " . $table_name;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		#отобразить данные каждой записи как строку таблицы
		while($row = $result->fetch_assoc()) {
			echo "<tr>";
			foreach($row as $item){
				echo "<td>".$item."</td>";
			}
			echo "</tr>";
		}
	} else {
		echo "Таблица пуста";
	}
	echo "</table>";

	#закрыть соединение
	$conn->close();
}

#вывести таблицу департаментов
print_table($department_table_name, $allowable_format_department);
#вывести таблицу пользователей
print_table($users_table_name, $allowable_format_user);
?>
</body>