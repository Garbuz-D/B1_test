<head>
 <meta charset="utf-8"/>
</head>

<body>
<?php
include "param.php";
echo "<pre>";
#создать соединение с БД
$conn = new mysqli($servername, $username, $password);
#проверить отсутствие ошибки
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error . "\n");
}

#создать БД
$sql = "CREATE DATABASE " . $dbname;
if ($conn->query($sql) === TRUE) {
  echo "База данных создана\n";
} else {
  echo "Ошибка при создании базы данных: " . $conn->error . "\n";
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error . "\n");
}

#создать таблицу департаментов
$sql = "CREATE TABLE " . $department_table_name . "(
xml_id VARCHAR(5) PRIMARY KEY,
parent_xml_id VARCHAR(5),
name_department VARCHAR(50) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
  echo "Таблица департаментов создана\n";
} else {
  echo "Ошибка при создании таблицы департаментов: " . $conn->error . "\n";
}

#создать таблицу пользователей
$sql = "CREATE TABLE " . $users_table_name . "(
xml_id VARCHAR(5) PRIMARY KEY,
last_name VARCHAR(20) NOT NULL,
name VARCHAR(20) NOT NULL,
second_name VARCHAR(20),
department VARCHAR(5) NOT NULL,
work_position VARCHAR(30) NOT NULL,
email VARCHAR(50),
mobile_phone VARCHAR(20), 
phone VARCHAR(20),
login VARCHAR(20) NOT NULL,
password VARCHAR(20) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
  echo "Таблица пользователей создана\n";
} else {
  echo "Ошибка при создании таблицы пользователей: " . $conn->error . "\n";
}
echo "<pre>";
#закрыть соединение
$conn->close();
?>
</body>