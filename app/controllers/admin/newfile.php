<?php
$file = "/var/www/html/my-framework.loc/app/views/File/upload/" . $_FILES['image']['name'];
move_uploaded_file($_FILES['image']['tmp_name'], $file);

