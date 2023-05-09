<h1>Список файлов</h1>

<div class="container">
    <div class="row">
        <div class="col">
            <?php if (!empty($_SESSION['success_signup_login'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?=$_SESSION['success_signup_login']; unset($_SESSION['success_signup_login']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">
            <?php if (!empty($_SESSION['errors'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['errors']; unset($_SESSION['errors']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<form enctype="multipart/form-data" action="app/controllers/admin/newfile.php" method="POST">
    <div class="mb-3">
        <input class="form-control" type="file" name="image">
    </div>
    <div class="mb-3">
        <button class="btn btn-success" type="submit">Загрузить</button>
    </div>
</form>

<?php

// Название <input type="file">
$input_name = 'image';

// Разрешенные расширения файлов.
$allow = array();

// Запрещенные расширения файлов.
$deny = array(
    'phtml', 'php', 'php3', 'php4', 'php5', 'php6', 'php7', 'phps', 'cgi', 'pl', 'asp',
    'aspx', 'shtml', 'shtm', 'htaccess', 'htpasswd', 'ini', 'log', 'sh', 'js', 'html',
    'htm', 'css', 'sql', 'spl', 'scgi', 'fcgi'
);

// Директория куда будут загружаться файлы.
//$path = __DIR__ . '/uploads/';

$path = '/var/www/html/my-framework.loc/public/assets/files/upload/000/';

if (isset($_FILES[$input_name])) {
    // Проверим директорию для загрузки.
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    // Преобразуем массив $_FILES в удобный вид для перебора в foreach.
    $files = array();
    $diff = count($_FILES[$input_name]) - count($_FILES[$input_name], COUNT_RECURSIVE);
    if ($diff == 0) {
        $files = array($_FILES[$input_name]);
    } else {
        foreach($_FILES[$input_name] as $k => $l) {
            foreach($l as $i => $v) {
                $files[$i][$k] = $v;
            }
        }
    }

    foreach ($files as $file) {
        $error = $success = '';

        // Проверим на ошибки загрузки.
        if (!empty($file['error']) || empty($file['tmp_name'])) {
            switch (@$file['error']) {
                case 1:
                case 2: $_SESSION['errors'] = 'Превышен размер загружаемого файла.'; break;
                case 3: $_SESSION['errors'] = 'Файл был получен только частично.'; break;
                case 4: $_SESSION['errors'] = 'Файл не был загружен.'; break;
                case 6: $_SESSION['errors'] = 'Файл не загружен - отсутствует временная директория.'; break;
                case 7: $_SESSION['errors'] = 'Не удалось записать файл на диск.'; break;
                case 8: $_SESSION['errors'] = 'PHP-расширение остановило загрузку файла.'; break;
                case 9: $_SESSION['errors'] = 'Файл не был загружен - директория не существует.'; break;
                case 10: $_SESSION['errors'] = 'Превышен максимально допустимый размер файла.'; break;
                case 11: $_SESSION['errors'] = 'Данный тип файла запрещен.'; break;
                case 12: $_SESSION['errors'] = 'Ошибка при копировании файла.'; break;
                default: $_SESSION['errors'] = 'Файл не был загружен - неизвестная ошибка.'; break;
            }
        } elseif ($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) {
            $error = 'Не удалось загрузить файл.';
        } else {
            // Оставляем в имени файла только буквы, цифры и некоторые символы.
            $pattern = "[^a-zа-яё0-9,~!@#%^-_\$\?\(\)\{\}\[\]\.]";
            $name = mb_eregi_replace($pattern, '-', $file['name']);
            $name = mb_ereg_replace('[-]+', '-', $name);
            $name = $file['name'];


            // Т.к. есть проблема с кириллицей в названиях файлов (файлы становятся недоступны).
            // Сделаем их транслит:
            $converter = array(
                'а' => 'a',   'б' => 'b',   'в' => 'v',    'г' => 'g',   'д' => 'd',   'е' => 'e',
                'ё' => 'e',   'ж' => 'zh',  'з' => 'z',    'и' => 'i',   'й' => 'y',   'к' => 'k',
                'л' => 'l',   'м' => 'm',   'н' => 'n',    'о' => 'o',   'п' => 'p',   'р' => 'r',
                'с' => 's',   'т' => 't',   'у' => 'u',    'ф' => 'f',   'х' => 'h',   'ц' => 'c',
                'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',  'ь' => '',    'ы' => 'y',   'ъ' => '',
                'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

                'А' => 'A',   'Б' => 'B',   'В' => 'V',    'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
                'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',    'И' => 'I',   'Й' => 'Y',   'К' => 'K',
                'Л' => 'L',   'М' => 'M',   'Н' => 'N',    'О' => 'O',   'П' => 'P',   'Р' => 'R',
                'С' => 'S',   'Т' => 'T',   'У' => 'U',    'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
                'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',  'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
                'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
            );

            $name = strtr($name, $converter);
            $parts = pathinfo($name);

            if (empty($name) || empty($parts['extension'])) {
                $_SESSION['errors'] = 'Недопустимое тип файла';
            } elseif (!empty($allow) && !in_array(strtolower($parts['extension']), $allow)) {
                $_SESSION['errors'] = 'Недопустимый тип файла';
            } elseif (!empty($deny) && in_array(strtolower($parts['extension']), $deny)) {
                $_SESSION['errors'] = 'Недопустимый тип файла';
            } else {
                // Чтобы не затереть файл с таким же названием, добавим префикс.
                $i = 0;
                $prefix = '';
                while (is_file($path . $parts['filename'] . $prefix . '.' . $parts['extension'])) {
                    $prefix = '(' . ++$i . ')';
                }
                $name = $parts['filename'] . $prefix . '.' . $parts['extension'];

                // Перемещаем файл в директорию.
                if (move_uploaded_file($file['tmp_name'], $path . $name)) {
                    // Далее можно сохранить название файла в БД и т.п.
                    $_SESSION['success'] = 'Файл «' . $name . '» успешно загружен.';
                    header("Location: http://my-framework.loc/file");
                } else {
                    $_SESSION['errors'] = 'Не удалось загрузить файл.';
                    header("Location: http://my-framework.loc/file");
                }
            }
        }
        header("Location: http://my-framework.loc/file");
    }
}

?>



<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">File name</th>
        <th scope="col">Size</th>
        <th scope="col">Users</th>
        <th scope="col">action</th>
    </tr>
    </thead>
    <tbody>

    <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>270 Kb.</td>
        <td>@mdo</td>
        <td>
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cloud-slash" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M3.112 5.112a3.125 3.125 0 0 0-.17.613C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13H11l-1-1H3.781C2.231 12 1 10.785 1 9.318c0-1.365 1.064-2.513 2.46-2.666l.446-.05v-.447c0-.075.006-.152.018-.231l-.812-.812zm2.55-1.45-.725-.725A5.512 5.512 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773a3.2 3.2 0 0 1-1.516 2.711l-.733-.733C14.498 11.378 15 10.626 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3c-.875 0-1.678.26-2.339.661z"/>
                <path d="m13.646 14.354-12-12 .708-.708 12 12-.707.707z"/>
            </svg>
        </td>
    </tr>

    <tr>
        <th scope="row">2</th>
        <td>Jacob</td>
        <td>150 Kb.</td>
        <td>@fat</td>
        <td>
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cloud-slash" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M3.112 5.112a3.125 3.125 0 0 0-.17.613C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13H11l-1-1H3.781C2.231 12 1 10.785 1 9.318c0-1.365 1.064-2.513 2.46-2.666l.446-.05v-.447c0-.075.006-.152.018-.231l-.812-.812zm2.55-1.45-.725-.725A5.512 5.512 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773a3.2 3.2 0 0 1-1.516 2.711l-.733-.733C14.498 11.378 15 10.626 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3c-.875 0-1.678.26-2.339.661z"/>
                <path d="m13.646 14.354-12-12 .708-.708 12 12-.707.707z"/>
            </svg>
        </td>
    </tr>

    <tr>
        <th scope="row">3</th>
        <td>Larry the Bird</td>
        <td>150 Kb.</td>
        <td>@twitter</td>

        <td>
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cloud-slash" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M3.112 5.112a3.125 3.125 0 0 0-.17.613C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13H11l-1-1H3.781C2.231 12 1 10.785 1 9.318c0-1.365 1.064-2.513 2.46-2.666l.446-.05v-.447c0-.075.006-.152.018-.231l-.812-.812zm2.55-1.45-.725-.725A5.512 5.512 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773a3.2 3.2 0 0 1-1.516 2.711l-.733-.733C14.498 11.378 15 10.626 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3c-.875 0-1.678.26-2.339.661z"/>
                <path d="m13.646 14.354-12-12 .708-.708 12 12-.707.707z"/>
            </svg>
        </td>
    </tr>
    </tbody>
</table>
