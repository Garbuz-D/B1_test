<!-- список загруженных файлов и форма для загрузки и отображения данных из таблиц в БД -->
<?php
include "param.php";
#открыть директорию с загруженными файлами
if ($handle = opendir($uploaddir)) {
	echo "Загруженные файлы:";
	#отобразить ссылку на каждый файл
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            echo "<br><a href='".$uploaddir.$entry."'>".$entry."</a>";
        }
    }
	#закрыть директорию
    closedir($handle);
}
?>

<!-- форма для загрузки данных с сервера -->
<p>
<form method='post' action='download_department.php'>
	<input type='submit' value='Загрузить данные по департаментам' name='Export'>
</form>
<form method='post' action='download_users.php'>
	<input type='submit' value='Загрузить данные по пользователям' name='Export'>
</form>

<!-- кнопка для отображения данных в виде таблиц -->
<p><button id="showData" class="float-left submit-button" >Отобразить данные</button>
<!-- скрипт перенаправляет на страницу с отображёнными таблицами -->
<script type="text/javascript">
    document.getElementById("showData").onclick = function () {
        location.href = "show_data.php";
    };
</script>