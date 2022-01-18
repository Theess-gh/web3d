<!DOCTYPE html>
<html>
<head>
<title>3d Viewer</title>
<meta charset="utf-8" />
</head>
<body>
<?php
if ($_FILES && $_FILES["filename"]["error"]== UPLOAD_ERR_OK)
{
    $name = "upload/" . $_FILES["filename"]["name"];
    move_uploaded_file($_FILES["filename"]["tmp_name"], $name);
    echo "<form id=\"foobar\" action =\"viewmodel.php?zipfile=" . $name . "\" method=\"post\"></form>
        <script>
         setTimeout(function () {
          document.getElementById('foobar').submit();
        }, 0);
        </script>";
}
?>
<h2>Загрузка файла</h2>
<form method="post" enctype="multipart/form-data">
Выберите файл: <input type="file" name="filename" size="10" /><br /><br />
<input type="submit" value="Загрузить" />
</form>
</body>
</html>